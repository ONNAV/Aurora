<?php

function implodeString($array) {
    return implode(', ', array_map(
                    function ($v, $k) {
                return sprintf("%s='%s'", $k, $v);
            }, $array, array_keys($array)
    ));
}
