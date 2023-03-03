<?php
class Database
{
    private static $instance;
    private  $connecti;
    private static $configconn;
    private function __construct($connecti)
    {
        $options =  $connecti['options'];
        $drive = $connecti['driver'];
        $host = $connecti['host'];
        $user = $connecti['username'];
        $password = $connecti['password'];
        $dbname = $connecti['database'];
        $port = $connecti['port']; // por el que se esté conectando a la DB

        // se arma la cadena de conexión
        $dns = "{$drive}:host={$host};dbname={$dbname};port={$port}";
        // * en caso de que no haya conexion
        try {
            $this->connecti = new PDO($dns, $user, $password, $options);
            $this->connecti->exec("SET CHARACTER SET UTF8");
        } catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }

    /**
     * Crear una nueva instancia de la clase utilizando el patrón síngleton
     */
    public static function getInstance($configconn)
    {
        if (!self::$instance && self::$configconn == !$configconn[1]) {
            self::$configconn = $configconn[1];
            self::$instance = new  Database($configconn[0]);
        }
        return self::$instance;
    }

    /**
     * devolver la conexión
     */
    public function getConnecti()
    {
        return $this->connecti;
    }
    /**
     * cerra la conexión a la DB
     */
    public function closeConnecti()
    {
        $this->connecti = null;
    }
}
