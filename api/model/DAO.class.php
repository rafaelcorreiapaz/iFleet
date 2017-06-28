<?php

namespace model;

use model\Model;

interface DAO
{

	public function load($id);
	public function queryAll();
	public function queryAllOrderBy($orderColumn);
	public function delete($id);
	public function salvar(Model $obj);

}