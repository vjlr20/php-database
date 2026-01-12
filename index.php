<?php
    // Controladores
    require_once './controller/CategoryController.php';

    // Creamos un objeto del controlador para consultar o manipular las categorias
    $categoryController = new CategoryController();

    // // Obtenemos el resultado de la consulta de todas las categorias
    // $listCategories = $categoryController->index();

    // echo "<pre>";
    // echo json_encode($listCategories, JSON_PRETTY_PRINT);   
    // echo "</pre>";

    // Datos de la nueva categoria a registrar
    // $info = array(
    //     'nombre' => 'Ropa',
    //     'descripcion' => 'Categoria de productos ropa',
    //     'estado' => 1
    // );

    // // Registramos una nueva categoria
    // $newCategory = $categoryController->store($info);

    // echo "<pre>";
    // echo json_encode($newCategory, JSON_PRETTY_PRINT);
    // echo "</pre>";

    // Buscamos una categoria por su ID
    // $category = $categoryController->show(5);

    // echo "<pre>";
    // echo json_encode($category, JSON_PRETTY_PRINT);
    // echo "</pre>";

    // $category = $categoryController->destroy(3);

    // echo "<pre>";
    // echo json_encode($category, JSON_PRETTY_PRINT);
    // echo "</pre>";

    $updateInfo = array(
        'nombre' => 'Bebidas actualizado',
        'descripcion' => 'Categoria de productos bebidas actualizado',
        'estado' => 1
    );
    $category = $categoryController->update($updateInfo, 6);

    echo "<pre>";
    echo json_encode($category, JSON_PRETTY_PRINT);
    // print_r($updateInfo);
    echo "</pre>";
