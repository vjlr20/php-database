<?php
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
        public function connect()
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
        }
    }
