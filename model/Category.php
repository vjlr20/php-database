<?php
    require_once './db/connection.php';
    require_once './entity/CategoryEntity.php';

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

        // Método constructor
        function __construct()
        {
            // Inicializamos la conexion una vez por instancia
            $this->connection = parent::connect();
        }

        // Función para obtener todas las categorias (SELECT)
        public function getAll()
        {
            try {
                $query = CategoryEntity::whereNull('fecha_borrado')
                                    ->get(); // get() trae varios registros

                return $query->toArray();
            } catch (\Throwable $th) {
                return array();
            }
        }

        // Función para registrar una nueva categoria (INSERT)
        public function register($data) 
        {
            try {
                // Creamos la instancia para crear una nueva categoria
                $newCategory = new CategoryEntity();

                // Asignamos los valores a la nueva categoria
                $newCategory->nombre = $data['nombre'];
                $newCategory->descripcion = $data['descripcion'];
                $newCategory->estado = $data['estado'];
                $newCategory->fecha_creacion = date('Y-m-d H:i:s');
                $newCategory->fecha_actualizacion = date('Y-m-d H:i:s');

                // Guardamos la nueva categoria en la base de datos
                $newCategory->save();

                // Retornamos el ID de la nueva categoria
                return $newCategory->id;
            } catch (\Throwable $th) {
                return NULL;
            }
        }
        
        // Función para obtener una categoria por ID (SELECT)
        public function getById($id) 
        {
            try {
                $query = CategoryEntity::where('id', $id)
                                    ->first(); // first() trae un solo registro

                return $query;
            } catch (\Throwable $th) {
                return NULL;
            }
        }

        // Función para actualizar una categoria por ID (UPDATE)
        public function update($data, $id) 
        {
            try {
                // Obtener la categoria por ID
                $category = $this->getById($id);

                // Actualizar los campos de la categoria
                $category->nombre = $data['nombre'];
                $category->descripcion = $data['descripcion'];
                $category->estado = $data['estado'];
                $category->fecha_actualizacion = date('Y-m-d H:i:s');

                // Guardar los cambios en la base de datos
                $category->save();

                return $category->id;
            } catch (\Throwable $th) {
                return NULL;
            }
        }

        // Función para eliminar una categoria por ID (UPDATE por el soft delete)
        public function delete($id)
        {
            try {
                // Obtener la categoria por ID
                $category = $this->getById($id);

                $category->fecha_borrado = date('Y-m-d H:i:s');
                $category->save();

                return $category->id;
            } catch (\Throwable $th) {
                return NULL;
            }
        }

        // Función para los eliminados (SELECT)
        // public function getDeleted()
        // {
        //     try {
        //         // LLamar la conexion
        //         $this->connection = parent::connect();

        //         // Consulta SQL para obtener los elementos eliminados
        //         $sql = "SELECT * FROM categorias WHERE fecha_borrado IS NOT NULL";

        //         // Preparamos la consulta
        //         $statement = $this->connection->prepare($sql);

        //         // Ejecutamos la consulta
        //         $statement->execute();

        //         // Almacenamos los resultados en un array asociativo
        //         $response = $statement->fetchAll(PDO::FETCH_ASSOC);

        //         return $response;
        //     } catch (\Throwable $th) {
        //         return NULL;
        //     }
        // }

        // Función para recuperar los elementos eliminados (UPDATE)
        // public function recover($id)
        // {
        //     try {
        //         // Llamar la conexion
        //         $this->connection = parent::connect();

        //         // Consulta SQL para recuperar el elemento eliminado
        //         $sql = "UPDATE categorias SET fecha_borrado = NULL WHERE id = :id";

        //         // Preparamos la consulta
        //         $statement = $this->connection->prepare($sql);

        //         // Susitituimos el parametro :id por el valor real
        //         $statement->bindParam(':id', $id);

        //         // Ejecutamos la consulta
        //         $statement->execute();

        //         return $id;
        //     } catch (\Throwable $th) {
        //         return NULL;
        //     }
        // }

        // Función para listar las categorias activas (SELECT) 
        // public function getAllActive()
        // {
        //     try {
        //         $this->connection = parent::connect();
        //         /**
        //          * Recuperamos todas las categorias que esten activas (estado = 1) 
        //          * y aquellas que no hayan sido eliminadas (fecha_borrado IS NULL)
        //          * 
        //          */
        //         $sql = "SELECT * FROM categorias WHERE estado = 1 AND fecha_borrado IS NULL";

        //         // Preparamos la consulta
        //         $statement = $this->connection->prepare($sql);

        //         // Ejecutamos la consulta
        //         $statement->execute();

        //         // Almacenamos los resultados en un array asociativo
        //         $response = $statement->fetchAll(PDO::FETCH_ASSOC);

        //         return $response;
        //     } catch (\Throwable $th) {
        //         return array();
        //     }
        // }

        // Función para desctivar una categoria (UPDATE)
        // public function deactivate($id)
        // {
        //     try {
        //         $this->connection = parent::connect();

        //         $sql = "UPDATE categorias SET estado = 0, fecha_actualizacion = NOW() WHERE id = :id";

        //         // Preparamos la consulta
        //         $statement = $this->connection->prepare($sql);

        //         // Susitituimos el parametro :id por el valor real
        //         $statement->bindParam(':id', $id);

        //         // Ejecutamos la consulta
        //         $statement->execute();

        //         return $id;
        //     } catch (\Throwable $th) {
        //         return NULL;
        //     }
        // }

        // Función para activar una categoria (UPDATE)
        // public function activate($id)
        // {
        //     try {
        //         $this->connection = parent::connect();

        //         $sql = "UPDATE categorias SET estado = 1, fecha_actualizacion = NOW() WHERE id = :id";

        //         // Preparamos la consulta
        //         $statement = $this->connection->prepare($sql);

        //         // Susitituimos el parametro :id por el valor real
        //         $statement->bindParam(':id', $id);

        //         // Ejecutamos la consulta
        //         $statement->execute();

        //         return $id;
        //     } catch (\Throwable $th) {
        //         return NULL;
        //     }
        // }
    }

