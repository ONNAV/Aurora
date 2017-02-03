<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reproductor extends CI_Controller {

    public $carpeta = './biblioteca/';
    private static $TBLBibliotecaMusical = 'BibliotecaMusical';
    public $CaritaTriste = '<i class="material-icons">&#xE812;</i>';
    public $CaritaFeliz = '<i class="material-icons">&#xE815;</i>';
    public $sentiment_very_dissatisfied = '<i class="material-icons">&#xE814;</i>';

    public function __construct() {
        parent::__construct();
        $this->load->model('Base_model', 'Base');
        $this->load->helper('base_helper');
        $this->load->helper('icon_helper');
        $this->dirMusicaLocal();
    }

    function index() {
        $data['contenido'] = $this->load->view('Reproductor', NULL, TRUE);
        $data['nombreSeccion'] = '<i class="material-icons">music_note</i> Reproductor';
        $this->load->view($this->layout, $data);
    }

    private function dirMusicaLocal($sub = '') {
        if (!file_exists($this->carpeta . $sub)) {
            mkdir($this->carpeta . $sub, 0777, true);
        }
        return $this->carpeta . $sub;
    }

    public function AgregarCanciones() {
        $data['contenido'] = $this->load->view('AgregaCanciones', NULL, TRUE);
        $data['nombreSeccion'] = '<i class="material-icons">music_note</i> Reproductor';
        $this->load->view("_layout", $data);
    }

    public function UploadDrop() {
        header('Content-Type: text/html; charset=utf-8');
        if (!empty($_FILES)) {
            $tempFile = $_FILES['file']['tmp_name'];
            $fileName = clean_string($_FILES['file']['name']);
            if (!$this->Base->getDataWhere(Reproductor::$TBLBibliotecaMusical, array('Archivo' => $fileName, 'Origen' => 'Archivo'))) {
                strip_tags($localPath = $this->carpeta . $fileName);
                if (copy($tempFile, $localPath)) {

                    $this->InfoID3($localPath, 'Archivo');
                }
            } else {
                $this->output->set_content_type('application/json')->set_output(json_encode(array('error' => true, 'text' => "EL archivo $fileName, fue guardado anteriormente", 'icon' => $this->CaritaTriste)));
            }
        }
    }

    private function InfoID3($cancion, $origen) {
        $this->load->library('getid3_1.7.4/getid3.php');
        $getID3 = new getID3;
        $getID3->encoding = "UTF-8";
        $audio = $getID3->analyze($cancion);
        $i = pathinfo($cancion);
        $bpm = ($audio['tags']['id3v2']['bpm'][0] > 0) ? $audio['tags']['id3v2']['bpm'][0] : 0;
        $title = ($audio['tags']['id3v2']['title'][0] != NULL) ? strip_tags($audio['tags']['id3v2']['title'][0]) : strip_tags($i['filename']);
        $album = ($audio['tags']['id3v2']['album'][0] != NULL) ? strip_tags($audio['tags']['id3v2']['album'][0]) : 'Album Desconocido';
        $artista = ($audio['tags']['id3v2']['artist'][0] != NULL) ? strip_tags($audio['tags']['id3v2']['artist'][0]) : 'Artista Desconocido';
        $dataCancion = $this->Base->getDataRow(Reproductor::$TBLBibliotecaMusical, array('Origen' => $origen));
        $repro = array('Artista' => $artista, 'BPM' => $bpm, 'Titulo' => strip_tags($title), 'Album' => strip_tags($album), 'Archivo' => strip_tags($i['basename']), 'Origen' => $origen);
        log_message("USERINFO", "ID " . $dataCancion->ID);
        if ($dataCancion->ID == NULL) {
            log_message("USERINFO", "INSERT");
            if ($this->Base->InsertData(Reproductor::$TBLBibliotecaMusical, $repro) > 0) {
                $this->output->set_content_type('application/json')->set_output(json_encode(array('error' => false, 'text' => "El archivo fue agregado correctamente", 'icon' => $this->CaritaFeliz)));
            } else {
                $this->output->set_content_type('application/json')->set_output(json_encode(array('error' => true, 'text' => "Ocurrio un problema intentando registrar la cancion", 'icon' => $this->CaritaTriste)));
            }
        } else {
            $repro['ID'] = $dataCancion->ID;
            if ($this->Base->UpdateData(Reproductor::$TBLBibliotecaMusical, $repro)) {
                $this->output->set_content_type('application/json')->set_output(json_encode(array('error' => false, 'text' => "El archivo fue actualizado correctamente", 'icon' => $this->CaritaFeliz)));
            } else {
                $this->output->set_content_type('application/json')->set_output(json_encode(array('error' => true, 'text' => "Ocurrio un problema intentando actualizar la cancion", 'icon' => $this->CaritaTriste)));
            }
        }
    }

    public function UploadFromURL() {
        $data = $this->input->post('BibliotecaMusicalStream');
        $cancion = strip_tags($this->carpeta . $data['Titulo'] . '_-_' . $data['Artista'] . '.mp3');
        if (file_exists($cancion) && !$this->Base->getDataWhere(Reproductor::$TBLBibliotecaMusical, array('Origen' => $data['URL']))) {
            log_message("USERINFO", 1);
            $url = exec('casperjs C:\SITES\CasperJS\offliberty.js --url="' . $data['URL'] . '"');
            file_put_contents($cancion, fopen($url, 'r'));
            $this->EditID3($cancion, $data, true);
        } elseif (filesize($cancion) <= 62500) {
            log_message("USERINFO", 2);
            $url = exec('casperjs C:\SITES\CasperJS\offliberty.js --url="' . $data['URL'] . '"');
            file_put_contents($cancion, fopen($url, 'r'));
            $this->EditID3($cancion, $data, true);
        } else {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('error' => true, 'text' => "EL archivo {$data['URL']}, fue guardado anteriormente", 'icon' => $this->CaritaTriste)));
        }
    }

    public function EditID3($cancion, $data, $agregar = FALSE) {
        $this->load->library('getid3_1.9.12/getid3.php');
        $this->load->library('getid3_1.9.12/write.php');
        $tagwriter = new getid3_writetags;

        $tagwriter->filename = $cancion;
        $tagwriter->tagformats = array('id3v2.3');
        $tagwriter->overwrite_tags = true;
        $tagwriter->remove_other_tags = false;
        $tagwriter->tag_encoding = "UTF-8";
        $tagwriter->remove_other_tags = true;

        $TagData = array(
            'title' => array($data['Titulo']),
            'artist' => array($data['Artista']),
            'album' => array($data['Album']),
            'year' => array($data['Ano']),
            'genre' => array($data['Genero']),
        );
        $tagwriter->tag_data = $TagData;
        if ($tagwriter->WriteTags()) {
            if ($agregar) {
                $this->InfoID3($cancion, $data['URL']);
            }
//            echo 'Successfully wrote tags<br>';
//            if (!empty($tagwriter->warnings)) {
//                echo 'There were some warnings:<br>' . implode('<br><br>', $tagwriter->warnings);
//            }
        } else {
//            echo 'Failed to write tags!<br>' . implode('<br><br>', $tagwriter->errors);
            $this->output->set_content_type('application/json')->set_output(json_encode(array('error' => true, 'text' => implode('<br><br>', $tagwriter->errors), 'icon' => $this->CaritaTriste)));
        }
    }

    function getList() {
        $canciones = $this->Base->getQuery("SELECT * FROM BibliotecaMusical ORDER BY NEWID(), Titulo,Artista, BPM, Archivo, RAND(ID), Origen, Album");
        $html = '';
        foreach ($canciones as $c) {
            $ubicacion = base_url("biblioteca/$c->Archivo");
            $html .= "<li rel='$ubicacion'> <strong>$c->Titulo</strong> <em>$c->Artista</em> </li>";
        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array('canciones' => $html)));
    }

}
