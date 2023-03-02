<?php
require_once(__DIR__ . '/config/configlobal.php');
require_once(__DIR__ . '/db/Database.php');
require_once(__DIR__ . '/orm/Model.php');
require_once(__DIR__ . '/models/Usuario.php');

 $usuarioModel= new Usuario();
 $usuario=$usuarioModel
 ->select()
 ->all()
 //->select()
 //->deleteById(3)
 //->where('id',2)
 //->one();
 //->viewQuery(true)
 ;
 echo '<pre>';
 print_r($usuario);
