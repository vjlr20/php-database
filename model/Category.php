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
                $sql = "SELECT * FROM categorias WHERE fecha_borrado IS NULL";

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

        // Función para actualizar una categoria por ID
        public function update($data, $id) 
        {
            try {
                // Preparamos la conexion a la base de datos
                $this->connection = parent::connect();
                
                // Consultamos la categoria actual
                $category = $this->getById($id);

                $info = array();

                if ($data['nombre'] == NULL) {
                    $info['nombre'] = $category['nombre'];
                } else {
                    $info['nombre'] = $data['nombre'];
                }

                if ($data['descripcion'] == NULL) {
                    $info['descripcion'] = $category['descripcion'];
                } else {
                    $info['descripcion'] = $data['descripcion'];
                }

                if ($data['estado'] == NULL) {
                    $info['estado'] = $category['estado'];
                } else {
                    $info['estado'] = $data['estado'];
                }

                // Consulta SQL para actualizar una categoria por ID
                $sql = "UPDATE categorias 
                        SET 
                        nombre = :nombre, 
                        descripcion = :descripcion, 
                        estado = :estado,
                        fecha_actualizacion = NOW() 
                        WHERE id = :id";

                // Preparamos la consulta
                $statement = $this->connection->prepare($sql);
                
                // Susitituimos los parametros por los valores reales
                $statement->bindParam(':nombre',$info['nombre']);
                $statement->bindParam(':descripcion', $info['descripcion']);
                $statement->bindParam(':estado', $info['estado']);
                $statement->bindParam(':id', $id);

                // Ejecutamos la consulta
                $statement->execute();

                return $id;
            } catch (\Throwable $th) {
                return NULL;
            }
        }

        // Función para eliminar una categoria por ID
        public function delete($id)
        {
            try {
                // Llamamos la conexion a la base de datos
                $this->connection = parent::connect();

                // Consulta SQL para eliminar una categoria por ID
                // $sql = "DELETE FROM categorias WHERE id = :id";
                $sql = "UPDATE categorias SET fecha_borrado = NOW() WHERE id = :id";

                // Preparamos la consulta
                $statement = $this->connection->prepare($sql);

                // Susitituimos el parametro :id por el valor real
                $statement->bindParam(':id', $id);

                // Ejecutamos la consulta
                $statement->execute();

                // return true;
                return $id;
            } catch (\Throwable $th) {
                return NULL;
            }
        }
    }

