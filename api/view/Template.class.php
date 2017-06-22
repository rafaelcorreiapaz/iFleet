<?php

namespace view;

abstract class Template
{

    private function montarParteFixaLayout()
    {
        include_once "layout/index.php";
    }

    private function montarMenu()
    {

    }

    public final function montarLayout()
    {
        $this->montarParteFixaLayout();
        $this->montarMenu();
        $this->montarConteudo();
    }

}