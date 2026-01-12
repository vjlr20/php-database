-- Creando base de datos de mi tienda
CREATE DATABASE tienda;

-- Usando la base de datos 'tienda'
USE tienda;

-- Creando tabla 'categorias'
CREATE TABLE categorias (
    id bigint PRIMARY KEY AUTO_INCREMENT, -- Identificador único de la categoría
    
    nombre varchar(150) NOT NULL, -- Nombre de la categoría
    descripcion text, -- Descripción de la categoría
    
    estado tinyinit, -- Estado de la categoría (activo/inactivo)
    fecha_creacion timestamp DEFAULT CURRENT_TIMESTAMP, -- Fecha de creación de la categoría
    fecha_actualizacion timestamp DEFAULT CURRENT_TIMESTAMP, -- Fecha de última actualización
    fecha_borrado timestamp NULL -- Fecha de borrado lógico
);

-- Creando tabla 'productos'
CREATE TABLE productos (
    id bigint PRIMARY KEY AUTO_INCREMENT, -- Identificador único del producto,
    
    nombre varchar(150) NOT NULL, -- Nombre del producto
    descripcion text, -- Descripción del producto
    precio decimal(10, 2) NOT NULL, -- Precio del producto

    estado tinyinit, -- Estado del producto (disponible/no disponible
    fecha_creacion timestamp DEFAULT CURRENT_TIMESTAMP, -- Fecha de creación del producto
    fecha_actualizacion timestamp DEFAULT CURRENT_TIMESTAMP, -- Fecha de última actualización
    fecha_borrado timestamp NULL -- Fecha de borrado lógico
);

-- Creando tabla 'productos_categorias' para la relación muchos a muchos
CREATE TABLE productos_categorias (
    id bigint PRIMARY KEY AUTO_INCREMENT, -- Identificador único de la relación
    
    producto_id bigint NOT NULL, -- Identificador foraneo del producto
    categoria_id bigint NOT NULL, -- Identificador foraneo de la categoría

    fecha_creacion timestamp DEFAULT CURRENT_TIMESTAMP, -- Fecha de creación de la relación
    fecha_actualizacion timestamp DEFAULT CURRENT_TIMESTAMP, -- Fecha de última actualización
    fecha_borrado timestamp NULL, -- Fecha de borrado lógico
);

