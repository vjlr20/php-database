<?php
    require_once './db/connection.php';
    require_once './entity/CategoryEntity.php';

    use Carbon\Carbon; // Usamos Carbon para manejo de fechas

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
                /**
                 * Creamos la consulta para obtener categorias
                 * SELECT * FROM categorias WHERE fecha_borrado IS NULL
                 */
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
                /**
                 * Creamos la instancia de la entidad Categoria
                 * 
                 * INSERT INTO categorias 
                 * (nombre, descripcion, estado, fecha_creacion, fecha_actualizacion)
                 * VALUES (?, ?, ?, ?, ?)
                 */

                // Creamos la instancia para crear una nueva categoria
                $newCategory = new CategoryEntity();

                // Asignamos los valores a la nueva categoria
                $newCategory->nombre = $data['nombre'];
                $newCategory->descripcion = $data['descripcion'];
                $newCategory->estado = $data['estado'];
                $newCategory->fecha_creacion = Carbon::now('America/El_Salvador');
                $newCategory->fecha_actualizacion = Carbon::now('America/El_Salvador');

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
                /**
                 * Creamos la consulta para obtener una categoria por ID
                 * SELECT * FROM categorias WHERE id = ?
                 */
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
                /**
                 * Creamos la consulta para actualizar una categoria por ID
                 * 
                 * UPDATE categorias
                 * SET nombre = ?, descripcion = ?, estado = ?, fecha_actualizacion = ?
                 * WHERE id = ?
                 */

                // Obtener la categoria por ID
                $category = $this->getById($id);

                // Actualizar los campos de la categoria
                $category->nombre = $data['nombre'];
                $category->descripcion = $data['descripcion'];
                $category->estado = $data['estado'];
                $category->fecha_actualizacion = Carbon::now('America/El_Salvador');

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
                /**
                 * Creamos la consulta para eliminar una categoria por ID
                 * 
                 * UPDATE categorias
                 * SET fecha_borrado = ?
                 * WHERE id = ?
                 */

                // Obtener la categoria por ID
                $category = $this->getById($id);

                $category->fecha_borrado = Carbon::now('America/El_Salvador');
                $category->save();

                return $category->id;
            } catch (\Throwable $th) {
                return NULL;
            }
        }

        // Función para los eliminados (SELECT)
        public function getDeleted()
        {
            try {
                /**
                 * Recuperamos todas las categorias que hayan sido eliminadas
                 *  SELECT * FROM categorias WHERE fecha_borrado IS NOT NULL
                 * 
                 */
                $categories = CategoryEntity::whereNotNull('fecha_borrado')
                                    ->get();

                return $categories->toArray();
            } catch (\Throwable $th) {
                return NULL;
            }
        }

        // Función para recuperar los elementos eliminados (UPDATE)
        public function recover($id)
        {
            try {
                /**
                 * Recuperamos la categoria por ID
                 * 
                 * UPDATE categorias
                 * SET fecha_borrado = NULL
                 * WHERE id = ?
                 * 
                 */
                $category = $this->getById($id);

                $category->fecha_borrado = NULL;
                $category->save();

                return $category->id;
            } catch (\Throwable $th) {
                return NULL;
            }
        }

        // Función para listar las categorias activas (SELECT) 
        public function getAllActive()
        {
            try {
                /**
                 * Recuperamos todas las categorias que esten activas (estado = 1) 
                 * y aquellas que no hayan sido eliminadas
                 * 
                 * SELECT * FROM categorias WHERE estado = 1 AND fecha_borrado IS NULL
                 */
                $categories = CategoryEntity::where('estado', 1)
                                    ->whereNull('fecha_borrado')
                                    ->get();

                return $categories->toArray();
            } catch (\Throwable $th) {
                return array();
            }
        }

        // Función para desctivar una categoria (UPDATE)
        public function deactivate($id)
        {
            try {
                /**
                 * Creamos la consulta para desactivar una categoria por ID
                 * 
                 * UPDATE categorias
                 * SET estado = 0, fecha_actualizacion = ?
                 * WHERE id = ?
                 */

                $category = $this->getById($id);

                $category->estado = 0;
                $category->fecha_actualizacion = Carbon::now('America/El_Salvador');

                $category->save();

                return $category->id;
            } catch (\Throwable $th) {
                return NULL;
            }
        }

        // Función para activar una categoria (UPDATE)
        public function activate($id)
        {
            try {
                /**
                 * Creamos la consulta para activar una categoria por ID
                 * 
                 * UPDATE categorias
                 * SET estado = 1, fecha_actualizacion = ?
                 * WHERE id = ?
                 */
                $category = $this->getById($id);

                $category->estado = 1;
                $category->fecha_actualizacion = Carbon::now('America/El_Salvador');

                $category->save();

                return $category->id;
            } catch (\Throwable $th) {
                return NULL;
            }
        }
    }

