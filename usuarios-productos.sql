INSERT INTO usuarios (id_usuario, nombre, email, contraseña, apellidos, telefono) VALUES
('U001', 'Alfonso', 'alfonso@example.com', '123', 'García', '123123123'),
('U002', 'Elena', 'elena@example.com', '123', 'Martínez', '456456456');


-- Insertar productos generales
use `tienda2`;
INSERT INTO productos (id_producto, nombre, descripcion, precio, categoria, imagen, id_vendedor) VALUES
(11, 'Laptop Dell XPS 15', 'Portátil de alto rendimiento con procesador Intel i7', 1299.99, 'Tecnología', 'laptop.jpg', 'U002'),
(12, 'Teléfono Samsung Galaxy S21', 'Smartphone con pantalla AMOLED y cámara de 64MP', 799.99, 'Tecnología', 'samsung.jpg', 'U003'),
(13, 'Auriculares Sony WH-1000XM4', 'Auriculares inalámbricos con cancelación de ruido', 349.99, 'Accesorios', 'sony.jpg', 'U001');

-- Insertar el usuario administrador
INSERT INTO usuarios (id_usuario, nombre, email, contraseña, apellidos, telefono)
VALUES ('4237', 'ADMINISTRADOR', 'admin@tienda.com', 'hashedpassword', 'Sistema', '000000000');

-- Crear la tabla de permisos (si necesitas gestionar roles)
CREATE TABLE permisos (
    id_permiso INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario VARCHAR(255) NOT NULL,
    nombre_permiso VARCHAR(255) NOT NULL,
    CONSTRAINT fk_permiso_usuario FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

-- Asignar permisos al administrador
INSERT INTO permisos (id_usuario, nombre_permiso)
VALUES ('4237', 'ADMINISTRAR_TIENDAS');
