<?php

class Base_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function getMaxValue($campo, $tabla) {
        $this->db->select_max($campo, 'maximo');
        $consulta = $this->db->get($tabla);

        if ($consulta->num_rows() > 0) {
            return $consulta->result()[0]->maximo;
        } else {
            return false;
        }
    }

    function getCountTable($tabla, $groupby, $where) {
        $this->db->select('COUNT(1) TOTAL');
        $this->db->where($where);
        $this->db->group_by($groupby);
        $consulta = $this->db->get($tabla);

        if ($consulta->num_rows() > 0) {
            return $consulta->result()[0]->TOTAL;
        } else {
            return 0;
        }
    }

    function InsertData($table, $datos) {
        $this->db->insert($table, $datos);
        if ($this->db->affected_rows() > 0) {
            //log_message('USERINFO', "INSERT A LA TABLA $table DATOS: " . implodeString($datos) . " ID CREACION: " . $_SESSION['usu_id']);
            return $this->db->insert_id();
        } else {
            log_message('USERINFO', "PROBLEMAS CON INSERT A LA TABLA $table DATOS: " . implodeString($datos) . " ID CREACION: " . $_SESSION['usu_id']);
            return 0;
        }
    }

    function UpdateData($table, $data, $where) {
        $this->db->where($where);
        $this->db->update($table, $data);

        if ($this->db->affected_rows() > 0) {
            //log_message('USERINFO', "UPDATE A LA TABLA $table DATOS: " . implodeString($data) . " WHERE " . implodeString($where) . " ID CREACION: " . $_SESSION['usu_id']);
            return TRUE;
        } else {
            log_message('ERROR', "PROBLEMAS CON UPDATE A LA TABLA $table DATOS: " . implodeString($data) . " WHERE " . implodeString($where) . " ID CREACION: " . $_SESSION['usu_id']);
            return FALSE;
        }
    }

    function DeleteData($table, $where) {
        $this->db->where($where);
        $this->db->delete($table);

        if ($this->db->affected_rows() > 0) {
            if (is_string($where)) {
                log_message('USERINFO', "DELETE A LA TABLA $table  WHERE " . ($where) . " ID CREACION: " . $_SESSION['usu_id']);
            } else {
                log_message('USERINFO', "DELETE A LA TABLA $table  WHERE " . implodeString($where) . " ID CREACION: " . $_SESSION['usu_id']);
            }
            return TRUE;
        } else {
            if (is_string($where)) {
                log_message('ERROR', "PROBLEMAS CON DELETE A LA TABLA $table  WHERE " . ($where) . " ID CREACION: " . $_SESSION['usu_id']);
            } else {
                log_message('ERROR', "PROBLEMAS CON DELETE A LA TABLA $table  WHERE " . implodeString($where) . " ID CREACION: " . $_SESSION['usu_id']);
            }
            return FALSE;
        }
    }

    function getDataWhere($table, $where, $returnData = 'object') {
        $consulta = $this->db->get_where($table, $where);
        if ($consulta->num_rows() > 0) {
            return $consulta->result($returnData);
        } else {
            return false;
        }
    }

    function getData($table, $returnData = 'object') {
        $consulta = $this->db->get($table);
        if ($consulta->num_rows() > 0) {
            return $consulta->result($returnData);
        } else {
            return false;
        }
    }

    function getQuery($query, $returnData = 'object') {
        $consulta = $this->db->query($query);
        if ($consulta->num_rows() > 0) {
            return $consulta->result($returnData);
        } else {
            return false;
        }
    }

    function getHeaders($tabla) {
        //retorna nombre de las columnas de la tabla
        return $this->db->list_fields($tabla);
    }

    function getInformationTable($tabla) {
        //retorna informacion completa de la tablas
        return $this->db->field_data($tabla);
    }

}
