<?php

function implodeString($array) {
    return implode(', ', array_map(
                    function ($v, $k) {
                return sprintf("%s='%s'", $k, $v);
            }, $array, array_keys($array)
    ));
}

function GetQuitarAcentos($s) {

    $s = utf8_encode($s);
    $s = ereg_replace("[áàâãª]", "a", $s);
    $s = ereg_replace("[ÁÀÂÃ]", "A", $s);
    $s = ereg_replace("[ÍÌÎ]", "I", $s);
    $s = ereg_replace("[íìî]", "i", $s);
    $s = ereg_replace("[éèê]", "e", $s);
    $s = ereg_replace("[ÉÈÊ]", "E", $s);
    $s = ereg_replace("[óòôõº]", "o", $s);
    $s = ereg_replace("[ÓÒÔÕ]", "O", $s);
    $s = ereg_replace("[úùû]", "u", $s);
    $s = ereg_replace("[ÚÙÛ]", "U", $s);
    $s = str_replace("ç", "c", $s);
    $s = str_replace("Ç", "C", $s);
    return $s;
}

function clean_string($string) {
    $string = trim($string);
    $string = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'), array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'), $string
    );
    $string = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'), array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'), $string
    );
    $string = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'), array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'), $string
    );
    $string = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'), array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'), $string
    );
    $string = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'), array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'), $string
    );
    $string = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'), array('n', 'N', 'c', 'C',), $string
    );
    //Esta parte se encarga de eliminar cualquier caracter extraño
    $string = str_replace(
            array("\\", "¨", "º", "~",
        "#", "@", "|", "!", "\"",
        "·", "$", "%", "&", "/",
        "?", "'", "¡",
        "¿", "[", "^", "`", "]",
        "+", "}", "{", "¨", "´",
        ">", "< ", ";", ",", ":"), '', $string
    );
    return $string;
}
