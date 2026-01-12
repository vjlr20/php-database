<?php
    require_once './db/connection.php';

    /**
     * Modelo de Categoria:
     * Donde haremos las consultas directas a la base de datos
     */
    class Category extends Database //  Heredamos la conexion a la base de datos
    {
        // Atributos de la clase Categoria
        private $name;
        private $description;

        // Atributo para la conexion
        private $connection = NULL; 

        // Función para obtener todas las categorias
        public function getAll()
        {
            try {
                // Usamos el metodo connect de la clase padre Database
                $this->connection = parent::connect(); 

                // Consulta SQL para obtener todas las categorias  
                $sql = "SELECT * FROM categorias";

                // Preparamos la consulta
                $statement = $this->connection->prepare($sql);

                // Ejecutamos la consulta
                $statement->execute();

                // Almacenamos los resultados en un array asociativo
                $response = $statement->fetchAll(PDO::FETCH_ASSOC);

                return $response;
            } catch (\Throwable $th) {
                return array();
            }
        }

        // Función para registrar una nueva categoria
        public function register($data) 
        {
            try {
                // Usamos el metodo connect de la clase padre Database
                $this->connection = parent::connect();

                // Consulta SQL para insertar una nueva categoria
                $sql = "
                    INSERT INTO categorias (nombre, descripcion, estado)
                    VALUES 
                    (:nombre, :descripcion, :estado) 
                ";

                // Preparamos la consulta
                $statement = $this->connection->prepare($sql);

                // Vinculamos los parametros (reemplazamos los valores)
                $statement->bindParam(':nombre', $data['nombre']);
                $statement->bindParam(':descripcion', $data['descripcion']);
                $statement->bindParam(':estado', $data['estado']);

                // Ejecutamos la consulta
                $statement->execute();

                // Retornamos el ID del registro insertado
                $response = $this->connection->lastInsertId();

                return $response;
            } catch (\Throwable $th) {
                return NULL;
            }
        }
        
        // Función para obtener una categoria por ID
        public function getById($id) 
        {
            try {
                // Llamamos la conexion a la base de datos
                $this->connection = parent::connect();

                // Consulta SQL para obtener una categoria por ID
                $sql = "SELECT * FROM categorias WHERE id = :id";

                // Preparamos la consulta
                $statement = $this->connection->prepare($sql);

                // Susitituimos el parametro :id por el valor real
                $statement->bindParam(':id', $id);

                // Ejecutamos la consulta
                $statement->execute();

                // Almacenamos el resultado en un array asociativo
                $response = $statement->fetch(PDO::FETCH_ASSOC);

                // Retornamos el unico resultado
                return $response;
            } catch (\Throwable $th) {
                return NULL;
            }
        }

        public function update() {}

        public function delete() {}
    }

