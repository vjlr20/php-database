<?php
    // Indicar que la respuesta siempre será JSON
    // header('Content-Type: text/plain; charset=utf-8');
    
    // Cargamos el autoload de Composer
    require_once './vendor/autoload.php';

    // Controladores
    require_once './controller/CategoryController.php';

    // Establecer zona horaria
    // date_default_timezone_set('America/El_Salvador');

    $categoryController = new CategoryController();

    // Función con Eloquent ORM
    $response = $categoryController->index();
    // $response = $categoryController->show(6);
    // $response = $categoryController->store(array(
    //     'nombre' => "Mascotas",
    //     'descripcion' => "Productos para el cuidado de mascotas",
    //     'estado' => 1
    // ));

    // $response = $categoryController->update(array(
    //     'nombre' => "Detergente y limpieza (Actualizado)",
    //     'descripcion' => "Productos de limpieza y detergentes (Actualizado).",
    //     'estado' => 1,
    // ), 7);
    
    // $response = $categoryController->destroy(4);
    // $response = $categoryController->trash();
    // $response = $categoryController->restore(3);

    // $response = $categoryController->filter();
    // $response = $categoryController->disable(1);
    // $response = $categoryController->enable(1);

    // $response = $categoryController->sendMail(
    //     "victor20.lopez99@gmail.com",
    //     "Envío de correo con PHPMailer y SMTP",
    //     "<h1>¡Hola desde PHPMailer!</h1>"      
    // );

    echo "<pre>";
    echo json_encode($response, JSON_PRETTY_PRINT);
    echo "</pre>";
    
