<?php 
/**
 * poder realizar múltiples conexiones a múltiples DB
 */
$config= [
    
    'connections' => [
        'default'=>'mysql',
        /**
         * conexión a mysql
         */
        'mysql' => [ // nombre de la conexion
            'driver' => 'mysql',
            'host' => 'localhost',
            'port' => 3307,
            'database' => 'orm',
            'username' => 'root',
            'password' => '',
            'options' =>[
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // la consults se devulven en un array asociativo
            ],
            /**
             * Otras opciones
             */
        ],
       /**
        * Otras conexiones
        */
    ],
    
];