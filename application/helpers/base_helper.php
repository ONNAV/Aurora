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
