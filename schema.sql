-- 1. Crear la base de datos desde cero
CREATE DATABASE IF NOT EXISTS warestock;
USE warestock;

-- 2. Tabla de Usuarios
CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50),
    lastname VARCHAR(50),
    username VARCHAR(50),
    email VARCHAR(255),
    password VARCHAR(60),
    image VARCHAR(255),
    is_active BOOLEAN DEFAULT 1,
    is_admin BOOLEAN DEFAULT 0,
    created_at DATETIME
);

-- Insertar el usuario Administrador por defecto (Contraseña: admin)
INSERT INTO user (name, lastname, username, email, password, is_active, is_admin, created_at) 
VALUES ('Administrador', 'Sistema', 'admin', 'admin@warestock.com', '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', 1, 1, NOW());

-- 3. Tabla de Categorías
CREATE TABLE category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(255),
    name VARCHAR(50),
    description TEXT,
    created_at DATETIME
);

-- 4. Tabla de Productos e Insumos
CREATE TABLE product (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(255),
    barcode VARCHAR(50),
    name VARCHAR(50),
    description TEXT,
    inventary_min INT DEFAULT 10,
    price_in FLOAT,
    price_out FLOAT,
    unit VARCHAR(255),
    presentation VARCHAR(255),
    user_id INT,
    category_id INT,
    created_at DATETIME,
    is_active BOOLEAN DEFAULT 1,
    es_materia_prima BOOLEAN DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES user(id),
    FOREIGN KEY (category_id) REFERENCES category(id)
);

-- 5. Tabla de Personas
CREATE TABLE person (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(255),
    name VARCHAR(255),
    lastname VARCHAR(50),
    company VARCHAR(50),
    address1 VARCHAR(50),
    address2 VARCHAR(50),
    phone1 VARCHAR(50),
    phone2 VARCHAR(50),
    email1 VARCHAR(50),
    email2 VARCHAR(50),
    kind INT, 
    created_at DATETIME
);

-- 6. Tipos de Operación
CREATE TABLE operation_type (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50)
);
INSERT INTO operation_type (name) VALUES ('entrada'), ('salida');

-- 7. Tabla de Cajas
CREATE TABLE box (
    id INT AUTO_INCREMENT PRIMARY KEY,
    created_at DATETIME
);

-- 8. Tabla de Órdenes y Ventas
CREATE TABLE sell (
    id INT AUTO_INCREMENT PRIMARY KEY,
    person_id INT,
    user_id INT,
    operation_type_id INT DEFAULT 2,
    box_id INT,
    total FLOAT,
    cash FLOAT,
    discount FLOAT,
    estado_produccion VARCHAR(50) DEFAULT 'Pendiente',
    prioridad VARCHAR(20) DEFAULT 'Media',
    fecha_entrega DATE NULL,
    diseno_url TEXT,
    created_at DATETIME,
    FOREIGN KEY (person_id) REFERENCES person(id),
    FOREIGN KEY (user_id) REFERENCES user(id),
    FOREIGN KEY (box_id) REFERENCES box(id)
);

-- 9. Tabla de Entradas y Salidas de Inventario
CREATE TABLE operation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    q FLOAT,
    operation_type_id INT,
    sell_id INT,
    created_at DATETIME,
    FOREIGN KEY (product_id) REFERENCES product(id),
    FOREIGN KEY (operation_type_id) REFERENCES operation_type(id),
    FOREIGN KEY (sell_id) REFERENCES sell(id) ON DELETE CASCADE
);

-- 10. Tabla de Recetas
CREATE TABLE product_recipe (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_parent_id INT,
    material_id INT,
    quantity_to_discount FLOAT,
    FOREIGN KEY (product_parent_id) REFERENCES product(id) ON DELETE CASCADE,
    FOREIGN KEY (material_id) REFERENCES product(id) ON DELETE CASCADE
);

-- Datos de prueba
INSERT INTO product (barcode, name, price_in, price_out, unit, inventary_min, es_materia_prima, user_id, created_at) VALUES 
('PROD-001', 'Taza Sublimada (Servicio Completo)', 3.50, 8.00, 'Unidad', 5, 0, 1, NOW()),
('MAT-001', 'Taza Blanca en Blanco 11oz', 1.50, 0.00, 'Unidad', 10, 1, 1, NOW()),
('MAT-002', 'Tinta de Sublimacion (Todos los colores)', 0.25, 0.00, 'ml', 50, 1, 1, NOW());

INSERT INTO operation (product_id, q, operation_type_id, created_at) VALUES 
(2, 50, 1, NOW()),
(3, 500, 1, NOW());

INSERT INTO product_recipe (product_parent_id, material_id, quantity_to_discount) VALUES 
(1, 2, 1.0),
(1, 3, 3.0);