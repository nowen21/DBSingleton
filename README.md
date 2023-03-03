# DBSingleton
Conexión a base de datos mediante el patrón síngleton con diferentes motores de bases de datos, este caso está en php y con múltiples conexiones

ESTRUCTURA DEL PROYECTO
DBSingleton
* |---config
* |------configlobal.php
         
         Se realiza la configuración de las variables globales 
* |------database.php
         
         Se realiza la configuración de o las base de datos a las que se pueda conectar el proyecto
* |---db
* |------Database.php
         
         Clase en la que se realiza la conexión a la base de datos, tiene la lógica para conectarse con cualquier driver que soporte PDO
* |---models
* |------Usuario.php
         
         Modelo para la tabla usuarios contien los siguientes atributos 

         // * Nombre de la tabla que representa este modelo
         protected $table='usuarios'; // Es obligatorio indicar el nombre de la tabla
         // * En el caso que este modelo se tenga que conectar a otra base de datos, se configura en el archivo config/database.php
         // protected $connection=''; // Es opcional

         // * En el caso de que la tabla tenga otro nombre para el id, por defecto va a tener id
         // protected $primaryKey = ''; // Es opcional
* |---orm
* |------Model.php
         
         Clase abstracta en la que diseñanan los métodos para el CRUD de cualquier tabla, esta clase tiene la lógica para entender a que DB se debe conectar.
         Esta clase tien los siguiente atributos de tipo protected:
         protected $primaryKey = 'id';// id por defecto de la tabal
         protected $table; // Nombre de la tabla, este viene del modelo que implementa la clase,
         protected $connection = null; // conexión por defecto, caso de utilizar otra
* |---index.php
