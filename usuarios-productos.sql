INSERT INTO usuarios (id_usuario, nombre, email, contraseña, apellidos, telefono) VALUES
('U001', 'Alfonso', 'alfonso@example.com', '123', 'García', '123123123'),
('U002', 'Elena', 'elena@example.com', '123', 'Martínez', '456456456');


-- Insertar productos generales
INSERT INTO productos (id_producto, nombre, descripcion, precio, categoria, imagen) VALUES
('P001', 'Motor de Alta Potencia', 'Potente motor.', 199.99, 'motor', 'images/motor/motor1.jpg'),
('P002', 'Accesorios para Moto', 'Variedad de accesorios.', 49.99, 'motor', 'images/motor/Accesorios para Moto.jpg'),
('P003', 'Casco de Seguridad', 'Protección confiable.', 89.99, 'motor', 'images/motor/Casco de Seguridad.jpg'),

('P004', 'Bolso de Cuero', 'Elegante y práctico.', 49.99, 'moda', 'images/moda/Bolso de Cuero.jpg'),
('P005', 'Reloj Elegante', 'Estilo clásico.', 89.99, 'moda', 'images/moda/Reloj Elegante.jpg'),
('P006', 'Gafas de Sol', 'Protección UV.', 29.99, 'moda', 'images/moda/Gafas de Sol.jpg'),

('P007', 'Lavadora Inteligente', 'Lavado eficiente.', 499.99, 'electrodomesticos', 'images/electrodomesticos/Lavadora Inteligente.jpg'),
('P008', 'Refrigerador', 'Espacio amplio.', 899.99, 'electrodomesticos', 'images/electrodomesticos/Refrigerador.jpg'),
('P009', 'Microondas', 'Rápido y compacto.', 199.99, 'electrodomesticos', 'images/electrodomesticos/Microondas.jpg'),

('P010', 'Smartphone Avanzado', 'Alta tecnología.', 699.99, 'moviles', 'images/moviles/Smartphone Avanzado.jpg'),
('P011', 'Teléfono Básico', 'Sencillo y útil.', 99.99, 'moviles', 'images/moviles/Teléfono Básico.jpg'),
('P012', 'Accesorios para Móviles', 'Complementos clave.', 19.99, 'moviles', 'images/moviles/Accesorios para Móviles.webp'),

('P013', 'Computadora de Escritorio', 'Alto rendimiento.', 999.99, 'informatica', 'images/informatica/Computadora de Escritorio.jpg'),
('P014', 'Laptop Ultraligera', 'Diseño ligero.', 1299.99, 'informatica', 'images/informatica/Laptop.jpg'),
('P015', 'Monitor 4K', 'Imagen nítida.', 399.99, 'informatica', 'images/informatica/Monitor 4K.jpg'),

('P016', 'Bicicleta de Montaña', 'Resistente y ligera.', 299.99, 'deportes', 'images/deportes/Bicicleta de Montaña.jpg'),
('P017', 'Pelota de Fútbol', 'Duradera.', 19.99, 'deportes', 'images/deportes/Pelota de Fútbol.jpg'),
('P018', 'Raqueta de Tenis', 'Ligera y precisa.', 49.99, 'deportes', 'images/deportes/Raqueta de Tenis.jpg'),

('P019', 'Televisor 4K', 'Imagen vibrante.', 799.99, 'tv', 'images/tv/Televisor 4K.jpg'),
('P020', 'Barra de Sonido', 'Sonido envolvente.', 199.99, 'tv', 'images/tv/Barra de Sonido.jpg'),
('P021', 'Cámara Digital', 'Fotos nítidas.', 499.99, 'tv', 'images/tv/Cámara Digital.jpg'),

('P022', 'Muebles de Jardín', 'Diseño resistente.', 299.99, 'jardin', 'images/jardin/Muebles de Jardín.jpg'),
('P023', 'Macetas Decorativas', 'Estilo moderno.', 39.99, 'jardin', 'images/jardin/Macetas Decorativas.jpg'),
('P024', 'Aspiradora Inteligente', 'Control remoto.', 199.99, 'jardin', 'images/jardin/Aspiradora Inteligente.webp'),

('P025', 'Novela Bestseller', 'La novela que le dio miedo a Jack Skellington.', 14.99, 'libros', 'images/libros/Novela Bestseller.webp'),
('P026', 'Álbum de Música', 'Melodías únicas.', 9.99, 'libros', 'images/libros/Álbum de Música.webp'),
('P027', 'Película en Blu-ray', 'Solo apto para verdaderos españoles.', NULL, 'libros', 'images/libros/Película en Blu-ray.webp');

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
