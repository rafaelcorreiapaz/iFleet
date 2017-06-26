<?php

header('Content-type: application/xml; charset=iso-8859-1');
include_once 'Data.class.php';

class XML extends Data
{
    public function __call($func, $params)
    {
        echo SystemHelper::arrayToXML(parent::$func());
    }
}
