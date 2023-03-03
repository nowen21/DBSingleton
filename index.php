<?php
require_once(__DIR__ . '/config/configlobal.php');
require_once(__DIR__ . '/db/Database.php');
require_once(__DIR__ . '/orm/Model.php');
require_once(__DIR__ . '/models/Usuario.php');

$usuarioModel = new Usuario();
$usuario = $usuarioModel
    // * probar el seleccionar todo
    // ->select()
    // ->all()

    // * probar el seleccionar un registro por el id
    ->getById(7)

    // * probar el seleccionar un registro por cualquier parámetro
    // ->select()
    // ->where('id',1)
    // ->one();

    // * probar el delete por id
    //->deleteById(3)


    // * probar el delete por cualquier parametro
    // ->delete()->where('nombres','nombre12')

    // * probar el update por id
    // ->updateById(1, ['nombres' => 'nombre11',])

    // * probar el insert
    // ->insert(['nombres' => 'nombre12',])

    //  ->viewQuery(true)


;
echo '<pre>';
print_r($usuario);
