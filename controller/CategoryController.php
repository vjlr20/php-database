<?php
    use PHPMailer\PHPMailer\SMTP; //  Configurar en el servicio de envío
    use PHPMailer\PHPMailer\PHPMailer; // Para enviar los correos
    use PHPMailer\PHPMailer\Exception; //  Controlar los errores

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

        // public function trash()
        // {
        //     try {
        //         // Obtener las categorias eliminadas
        //         $categories = parent::getDeleted();

        //         if (count($categories) < 1) {
        //             return array(
        //                 'message' => 'No hay categorias eliminadas',
        //                 'data' => array(),
        //                 'status' => 404
        //             );
        //         }

        //         return array(
        //             'message' => 'Categorias eliminadas obtenidas correctamente',
        //             'data' => $categories,
        //             'status' => 200
        //         );
        //     } catch (\Throwable $th) {
        //         return array(
        //             'message' => 'Error al obtener las categorias eliminadas',
        //             'data' => array(),
        //             'status' => 500
        //         );
        //     }
        // }

        // public function restore($id)
        // {
        //     try {
        //         $category = parent::recover($id);

        //         if ($category == NULL) {
        //             return array(
        //                 'message' => 'Categoria no encontrada',
        //                 'data' => NULL,
        //                 'status' => 404
        //             );
        //         }

        //         $getCategory = parent::getById($category);

        //         return array(
        //             'message' => 'Categoria restaurada correctamente',
        //             'data' => $getCategory,
        //             'status' => 200
        //         );
        //     } catch (\Throwable $th) {
        //         return array(
        //             'message' => 'Error al restaurar la categoria',
        //             'data' => NULL,
        //             'status' => 500
        //         );
        //     }
        // }

        // public function filter()
        // {
        //     try {
        //         $categories = parent::getAllActive();

        //         if (count($categories) < 1) {
        //             return array(
        //                 'message' => 'No hay categorias activas',
        //                 'data' => array(),
        //                 'status' => 404
        //             );
        //         }

        //         return array(
        //             'message' => 'Categorias activas obtenidas correctamente',
        //             'data' => $categories,
        //             'status' => 200
        //         );
        //     } catch (\Throwable $th) {
        //         return array(
        //             'message' => 'Error al filtrar las categorias',
        //             'data' => array(),
        //             'status' => 500
        //         );
        //     }
        // }

        // public function disable($id)
        // {
        //     try {
        //         $category = parent::deactivate($id);

        //         if ($category == NULL) {
        //             return array(
        //                 'message' => 'Categoria no encontrada',
        //                 'data' => NULL,
        //                 'status' => 404
        //             );
        //         }

        //         $getCategory = parent::getById($category);

        //         return array(
        //             'message' => 'Categoria desactivada correctamente',
        //             'data' => $getCategory,
        //             'status' => 200
        //         );
        //     } catch (\Throwable $th) {
        //         return array(
        //             'message' => 'Error al desactivar la categoria',
        //             'data' => NULL,
        //             'status' => 500
        //         );
        //     }
        // }

        // public function enable($id)
        // {
        //     try {
        //         $category = parent::activate($id);

        //         if ($category == NULL) {
        //             return array(
        //                 'message' => 'Categoria no encontrada',
        //                 'data' => NULL,
        //                 'status' => 404
        //             );
        //         }

        //         $getCategory = parent::getById($category);

        //         return array(
        //             'message' => 'Categoria activada correctamente',
        //             'data' => $getCategory,
        //             'status' => 200
        //         );
        //     } catch (\Throwable $th) {
        //         return array(
        //             'message' => 'Error al activar la categoria',
        //             'data' => NULL,
        //             'status' => 500
        //         );
        //     }
        // }

        public function sendMail($to, $subject, $body)
        {
            try {
                $mail = new PHPMailer(true);

                // Configuraciones del servidor de correos
                $mail->isSMTP(); // Usar una cuenta de correo autenticada

                $mail->charset = 'UTF-8';
                $mail->Host       = 'smtp.gmail.com'; // Servidor SMTP
                $mail->SMTPAuth   = true; // Habilitar la autenticación SMTP
                $mail->Username   = "ticongle.mail2023@gmail.com"; // Usuario SMTP
                $mail->Password   = "gjaoovhwlewwwpqn"; // Contraseña SMTP
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Habilitar encriptación TLS
                $mail->Port       = 587; // Puerto TCP para conectarse

                // Remitente y destinatario
                $mail->setFrom("ticongle.mail2023@gmail.com", "Ticongle Mail TEST");
                $mail->addAddress($to); // Destinatario

                // Contenido del correo
                $mail->isHTML(true); // Formato HTML
                $mail->Subject = $subject; // Asunto
                $mail->Body    = $body; // Cuerpo del mensaje

                $mail->send();

                return array(
                    'message' => 'Correo enviado correctamente',
                    'data' => NULL,
                    'status' => 200
                );
            } catch (\Throwable $th) {
                return array(
                    'message' => 'Error al enviar el correo',
                    'data' => NULL,
                    'status' => 500
                );
            }
        }
    }

