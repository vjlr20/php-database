<?php
    // Controladores
    require_once './controller/CategoryController.php';

    // Creamos un objeto del controlador para consultar o manipular las categorias
    $categoryController = new CategoryController();

    // Obtenemos el resultado de la consulta de todas las categorias
    // $listCategories = $categoryController->index();

    // echo "<pre>";
    // echo json_encode($listCategories, JSON_PRETTY_PRINT);   
    // echo "</pre>";

    // Datos de la nueva categoria a registrar
    $info = array(
        'nombre' => 'Frutas',
        'descripcion' => 'Categoria de productos frutas',
        'estado' => 1
    );

    // Registramos una nueva categoria
    // $newCategory = $categoryController->store($info);

    // echo "<pre>";
    // echo json_encode($newCategory, JSON_PRETTY_PRINT);
    // echo "</pre>";

    // Buscamos una categoria por su ID
    $category = $categoryController->show(5);

    echo "<pre>";
    echo json_encode($category, JSON_PRETTY_PRINT);
    echo "</pre>";
