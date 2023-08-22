<?php

class Conexion{

	static public function conectar(){

		$link = new PDO("mysql:host=localhost;dbname=pos",
			            "root",
			            "2124");

		$link->exec("set names utf8");

		return $link;

	}

}