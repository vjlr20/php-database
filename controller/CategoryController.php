<?php
    require_once './model/Category.php';
    
    // Controlador de Categoria
    class CategoryController extends Category
    {
        public function index()
        {
            try {
                // Consultamos el metodo getAll del modelo Category
                $categories = parent::getAll(); 

                // Validamos si hay categorias
                if (count($categories) < 1) {
                    return array(
                        'message' => 'No hay categorias registradas',
                        'data' => array(),
                        'status' => 404
                    );
                }

                // Retornamos las categorias encontradas
                return array(
                    'message' => 'Categorias obtenidas correctamente',
                    'data' => $categories,
                    'status' => 200
                );
            } catch (\Throwable $th) {
                return array(
                    'message' => 'Error al obtener las categorias',
                    'data' => array(),
                    'status' => 500
                );
            }
        }

        public function store($data)
        {
            try {
                $newCategory = parent::register($data);

                if ($newCategory == NULL) {
                    return array(
                        'message' => 'No se pudo registrar la categoria',
                        'data' => array(),
                        'status' => 400
                    );
                }

                $category = parent::getById($newCategory);

                return array(
                    'message' => 'Categoria registrada correctamente',
                    'data' => $category, // ID del nuevo registro
                    'status' => 201
                );
            } catch (\Throwable $th) {
                return array(
                    'message' => 'Error al registrar la categoria',
                    'data' => NULL,
                    'status' => 500
                );
            }
        }

        public function show($id)
        {
            try {
                $category = parent::getById($id);

                if ($category == NULL) {
                    return array(
                        'message' => 'Categoria no encontrada',
                        'data' => array(),
                        'status' => 404
                    );
                }

                return array(
                    'message' => 'Categoria obtenida correctamente',
                    'data' => $category,
                    'status' => 200
                );
            } catch (\Throwable $th) {
                return array(
                    'message' => 'Error al obtener la categoria',
                    'data' => NULL,
                    'status' => 500
                );
            }
        }

        public function update($array, $id)
        {
            try {
                $updateCategory = parent::update($array, $id);
                
                if ($updateCategory == NULL) {
                    return array(
                        'message' => 'Categoria no encontrada',
                        'data' => NULL,
                        'status' => 404
                    );
                }

                $category = parent::getById($id);

                return array(
                    'message' => 'Categoria actualizada correctamente',
                    'data' => $category,
                    'status' => 200
                );
            } catch (\Throwable $th) {
                return array(
                    'message' => 'Error al actualizar la categoria',
                    'data' => NULL,
                    'status' => 500
                );
            }
        }

        public function destroy($id)
        {
            try {
                $category = parent::delete($id);

                if ($category == NULL) {
                    return array(
                        'message' => 'Categoria no encontrada',
                        'data' => NULL,
                        'status' => 404
                    );
                }

                $getCategory = parent::getById($category);

                return array(
                    'message' => 'Categoria eliminada correctamente',
                    'data' => $getCategory,
                    'status' => 200
                );
            } catch (\Throwable $th) {
                return array(
                    'message' => 'Error al eliminar la categoria',
                    'data' => NULL,
                    'status' => 500
                );
            }
        }
    }

