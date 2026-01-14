<?php
    use Illuminate\Database\Capsule\Manager as Capsule;

    // Conexion a la base de datos
    class Database
    {
        // Propiedades de la clase para la conexion
        private $driver = "mysql";
        private $host = "localhost";
        private $database = "tienda";
        private $username = "root";
        private $password = "";

        private $connection = NULL;

        // Metodo para conectar a la base de datos
        /* public function connect()
        {
            // Controlamos la conexion a la base de datos
            try {

                // Creamos conexion con PDO
                $this->connection = new PDO(
                    // URL de conexion
                    $this->driver . ":host=" . $this->host . ";dbname=" . $this->database,
                    $this->username, // Usuario
                    $this->password // Conreaseña
                );

                $this->connection->setAttribute(
                    PDO::ATTR_ERRMODE, // Acepta los errores de PDO
                    PDO::ERRMODE_EXCEPTION // Muestra los errores como excepciones
                );

                return $this->connection;
            } catch (\Throwable $th) {
                return NULL;
            }
        } */

        public function connect()
        {
            try {
                // Creamos la instancia para la conexion a la base de datos
                $capsule = new Capsule();

                // Configurar la conexion
                $capsule->addConnection(array(
                    'driver'    => $this->driver,
                    'host'      => $this->host,
                    'database'  => $this->database,
                    'username'  => $this->username,
                    'password'  => $this->password,
                    'charset'   => 'utf8',
                    'collation' => 'utf8_unicode_ci',
                    'prefix'    => '',
                ));

                // Especificamos que la conexion sera usada globalmente
                $capsule->setAsGlobal();

                // Indicamos que usaremos Eloquent ORM
                $capsule->bootEloquent();

                $this->connection = $capsule;

                return $this->connection;
            } catch (\Throwable $th) {
                return NULL;
            }
        }
    }
