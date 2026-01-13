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

        // Función para obtener todas las categorias (SELECT)
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

        // Función para registrar una nueva categoria (INSERT)
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
        
        // Función para obtener una categoria por ID (SELECT)
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

        // Función para actualizar una categoria por ID (UPDATE)
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
                $statement->bindParam(':nombre', $info['nombre']);
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

        // Función para eliminar una categoria por ID (UPDATE por el soft delete)
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

        // Función para los eliminados (SELECT)
        public function getDeleted()
        {
            try {
                // LLamar la conexion
                $this->connection = parent::connect();

                // Consulta SQL para obtener los elementos eliminados
                $sql = "SELECT * FROM categorias WHERE fecha_borrado IS NOT NULL";

                // Preparamos la consulta
                $statement = $this->connection->prepare($sql);

                // Ejecutamos la consulta
                $statement->execute();

                // Almacenamos los resultados en un array asociativo
                $response = $statement->fetchAll(PDO::FETCH_ASSOC);

                return $response;
            } catch (\Throwable $th) {
                return NULL;
            }
        }

        // Función para recuperar los elementos eliminados (UPDATE)
        public function recover($id)
        {
            try {
                // Llamar la conexion
                $this->connection = parent::connect();

                // Consulta SQL para recuperar el elemento eliminado
                $sql = "UPDATE categorias SET fecha_borrado = NULL WHERE id = :id";

                // Preparamos la consulta
                $statement = $this->connection->prepare($sql);

                // Susitituimos el parametro :id por el valor real
                $statement->bindParam(':id', $id);

                // Ejecutamos la consulta
                $statement->execute();

                return $id;
            } catch (\Throwable $th) {
                return NULL;
            }
        }

        // Función para listar las categorias activas (SELECT) 
        public function getAllActive()
        {
            try {
                $this->connection = parent::connect();
                /**
                 * Recuperamos todas las categorias que esten activas (estado = 1) 
                 * y aquellas que no hayan sido eliminadas (fecha_borrado IS NULL)
                 * 
                 */
                $sql = "SELECT * FROM categorias WHERE estado = 1 AND fecha_borrado IS NULL";

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

        // Función para desctivar una categoria (UPDATE)
        public function deactivate($id)
        {
            try {
                $this->connection = parent::connect();

                $sql = "UPDATE categorias SET estado = 0, fecha_actualizacion = NOW() WHERE id = :id";

                // Preparamos la consulta
                $statement = $this->connection->prepare($sql);

                // Susitituimos el parametro :id por el valor real
                $statement->bindParam(':id', $id);

                // Ejecutamos la consulta
                $statement->execute();

                return $id;
            } catch (\Throwable $th) {
                return NULL;
            }
        }

        // Función para activar una categoria (UPDATE)
        public function activate($id)
        {
            try {
                $this->connection = parent::connect();

                $sql = "UPDATE categorias SET estado = 1, fecha_actualizacion = NOW() WHERE id = :id";

                // Preparamos la consulta
                $statement = $this->connection->prepare($sql);

                // Susitituimos el parametro :id por el valor real
                $statement->bindParam(':id', $id);

                // Ejecutamos la consulta
                $statement->execute();

                return $id;
            } catch (\Throwable $th) {
                return NULL;
            }
        }
    }

