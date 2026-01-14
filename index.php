<?php
    // Indicar que la respuesta siempre será JSON
    // header('Content-Type: text/plain; charset=utf-8');
    
    // Cargamos el autoload de Composer
    require_once './vendor/autoload.php';

    // Controladores
    require_once './controller/CategoryController.php';

    $categoryController = new CategoryController();

    // Función con Eloquent ORM
    // $response = $categoryController->index();
    $response = $categoryController->show(6);
    
    // $response = $categoryController->destroy(5);
    // $response = $categoryController->trash();
    // $response = $categoryController->restore(3);

    // $response = $categoryController->filter();
    // $response = $categoryController->disable(1);
    // $response = $categoryController->enable(1);

    echo "<pre>";
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    echo "</pre>";
    
