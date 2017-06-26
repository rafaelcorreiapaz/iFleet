<?php

header('Content-type: application/json; charset=iso-8859-1');
include_once 'Data.class.php';


class JSON extends Data
{
    public function __call($func, $params)
    {
        echo SystemHelper::arrayToJSON(parent::$func());
    }
}