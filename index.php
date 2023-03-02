<?php
require_once(__DIR__ . '/config/configlobal.php');
require_once(__DIR__ . '/db/Database.php');
require_once(__DIR__ . '/orm/Model.php');
require_once(__DIR__ . '/models/Usuario.php');

$usuarioModel = new Usuario();
$usuario = $usuarioModel
    
    // ->select()
    //->all()

    ->select()
    ->where('id',1)
    ->one();


    //->deleteById(3)

    // ->updateById(1, ['nombres' => 'nombre11',])

    //  ->viewQuery(true)
;
echo '<pre>';
print_r($usuario);
