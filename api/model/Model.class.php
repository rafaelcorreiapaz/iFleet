<?php

namespace model;

abstract class Model
{

	public abstract function validar();
	public abstract function salvar();
	protected abstract function popular();

}