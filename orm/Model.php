<?php
abstract class  Model
{
    protected $id = 'id';
    protected $table;
    protected $db;
    protected $preparex;
    private $queryxxx = '';
    protected $configconn = null; // conexión por defecto, caso de utilizar otra

    public function __construct()
    {
        $conn = Database::getInstance($this->getConfig());
        $this->db = $conn->getConnecti();
    }

    /**
     * Incluir la configuración y validar si en el modelo que hereda la clase se ha definido en la propiedad: $configconn una conexion
     */
    private function getConfig()
    {
        // importar la configuración
        require_once(URL_BASE . 'config/database.php');

        $configur = $config['connections'];
        // * obtener la configuración de la DB por defecto
        if (is_null($this->configconn)) {
            $this->configconn = $configur['default'];
        }
        return [$configur[$this->configconn], $this->configconn];
    }

    /************************** ARMAR QUERY ***************************/
    /**
     * ejecuta el query
     */
    private function getQuery($queryxxx)
    {
        $this->preparex = $this->db->prepare($queryxxx);
        $this->preparex->execute();
    }

    /**
     * ejecuta query y retorna el objeto
     */
    public  function query($queryxxx)
    {
        $this->getQuery($queryxxx);
        return $this; // se retorna el objeto para poder concatenar métodos
    }

    /**
     * armar la consulta inicial del select
     */
    private function getSelect($camposxx = '*')
    {
        if (is_array($camposxx)) { // es un array
            if (empty($camposxx)) { // está vacío
                $camposxx = '*';
            } else {
                $camposxx = implode($camposxx);
            }
        }
        $this->queryxxx = "SELECT {$camposxx} FROM {$this->table} ";
    }

    /************************** FIN ARMAR QUERY ***************************/






    /************************** SELECTS ***************************/
    /**
     * Mostrar el query que se está armando
     */
    public function viewQuery($mostrar = false)
    {
        if ($mostrar) {
            echo $this->queryxxx;
        }
    }

    /**
     * armar la consulta del WHERE cuando se busca por id
     */
    public function whereId($volorxxx)
    {
        return "WHERE $this->id = '$volorxxx'";
    }

    /**
     * armar consulta con el WHERE
     */
    public function where($camposxx, $separado, $volorxxx = '')
    {
        if (empty($volorxxx)) {
            $volorxxx = $separado;
            $separado = '=';
        }
        $wherexxx = 'WHERE ';
        if (strpos($this->queryxxx,'WHERE')!==false) {
            $wherexxx = 'AND ';
        }
       
        $this->queryxxx .= "$wherexxx $camposxx $separado '$volorxxx' ";
        return $this;
    }





    /**
     * retorna todos los registros
     */
    public function all($camposxx = '*')
    {
        $this->getSelect($camposxx);
        $this->getQuery($this->queryxxx);
        return $this->get();
    }

    /** se concatena con el método que tenga la cosulta para devolver todos los registros */
    public  function get()
    {
        return $this->preparex->fetchAll();
    }

    /** buscar registro por el id */
    public function getById($id)
    {
        $this->getSelect();
        $this->queryxxx .= $this->whereId($id);
        return $this->one();
    }

    /** 
     * realizar la consulta 
     */
    public function select($camposxx = '*')
    {
        $this->getSelect($camposxx);
        return $this;
    }

    public function one()
    {
        $this->getQuery($this->queryxxx);
        return $this->preparex->fetch();
    }

    /************************** FIN SELECTS ***************************/

    /************************** DELETE ***************************/
    /**
     * inicializar el strin del query para el delete
     */
    private function homeDelete()
    {
        return  "DELETE FROM {$this->table} ";
    }

    public function deleteById($id)
    {
        $this->queryxxx = $this->homeDelete() . "WHERE {$this->id} = {$id}";
        $this->getQuery($this->queryxxx);
    }

    public function delete()
    {
        $deletexx=$this->homeDelete();
        $this->queryxxx=$deletexx.$this->queryxxx;
        $this->preparex = $this->db->prepare($this->queryxxx);
        $this->preparex->execute();
        return $this;
    }

    /************************** FIN DELETE ***************************/


    /************************** UPDATE ***************************/

    public function set($data)
    {
        $setxxxxx = '';
        foreach ($data as $key => $value) {
            $setxxxxx .= " $key=:$key,";
        }
        return trim($setxxxxx, ',');
    }
    public function homeUpdate($data)
    {
        return  "UPDATE  {$this->table} SET {$this->set($data)} ";
    }

    public function updateById($id, $dataxxxx)
    {
        $this->queryxxx = $this->homeUpdate($dataxxxx) . " WHERE {$this->id} = :{$this->id}";
        $this->preparex = $this->db->prepare($this->queryxxx);
        foreach ($dataxxxx as $key => $value) {
            $this->preparex->bindValue(":{$key}", $value);
        }
        $this->preparex->bindValue(":id", $id);
        $this->preparex->execute();
        return $this;
    }


    public function update($dataxxxx)
    {
        $queryxxx=$this->homeUpdate($dataxxxx);
        $this->queryxxx= $queryxxx.$this->queryxxx;
        $this->preparex = $this->db->prepare($this->queryxxx);
        foreach ($dataxxxx as $key => $value) {
            $this->preparex->bindValue(":{$key}", $value);
        }
        $this->preparex->execute();
        return $this;
    }

    /************************** FIN UPDATE ***************************/

    /************************** INSERTS ***************************/
    /**
     * armar las columnas
     */
    public function insertColumns($dataxxxx)
    {
        $this->queryxxx = "INSERT INTO {$this->table} (";
        foreach ($dataxxxx as $key => $value) {
            $this->queryxxx .= "{$key}, ";
        }
        $this->queryxxx = trim($this->queryxxx, ', ') . ') ';
    }

    /**
     * armar los values
     */
    public function insertValues($dataxxxx)
    {
        $this->insertColumns($dataxxxx);
        $this->queryxxx .= 'VALUES (';
        foreach ($dataxxxx as $key => $value) {
            $this->queryxxx .= ":{$key}, ";
        }
        $this->queryxxx = trim($this->queryxxx, ', ') . ') ';
    }

    /**
     * armar los BindValue
     */
    public function insetBindValue($dataxxxx)
    {
        foreach ($dataxxxx as $key => $value) {
            $this->preparex->bindValue(":{$key}", $value);
        }
    }

    /**
     * realizar el insert
     */
    public function insert($dataxxxx)
    {
        $this->insertValues($dataxxxx);
        $this->preparex = $this->db->prepare($this->queryxxx);
        $this->insetBindValue($dataxxxx);
        $this->preparex->execute();
        return $this;
    }

    /************************** FIN INSERTS ***************************/
}
