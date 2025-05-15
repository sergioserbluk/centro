
-- Crear base de datos
CREATE DATABASE IF NOT EXISTS centro_estudiantes;
USE centro_estudiantes;

-- Tabla de usuarios (administradores)
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) NOT NULL UNIQUE,
    clave VARCHAR(255) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE
);

-- Tabla de categorías
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_categoria VARCHAR(50) NOT NULL UNIQUE,
    descripcion TEXT
);

-- Tabla de publicaciones
CREATE TABLE publicaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    contenido TEXT NOT NULL,
    imagen VARCHAR(255),
    fecha_publicacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_usuario INT,
    id_categoria INT,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id),
    FOREIGN KEY (id_categoria) REFERENCES categorias(id)
);

-- Tabla de mensajes de contacto
CREATE TABLE mensajes_contacto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    mensaje TEXT NOT NULL,
    fecha_envio DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Insertar usuario administrador de prueba (clave: admin123, hasheada con password_hash en PHP)
INSERT INTO usuarios (nombre_usuario, clave, correo) VALUES 
('admin', '$2y$10$zFChcwkuLNyMZ/3Z1OfK1eGpLnKLkS2bTtT0Kf2C2A4jZo3QfHK7a', 'admin@colegio.edu.ar');

-- Insertar categorías de prueba
INSERT INTO categorias (nombre_categoria, descripcion) VALUES
('Eventos', 'Actividades y reuniones programadas por el centro de estudiantes'),
('Comunicados', 'Anuncios importantes para los estudiantes'),
('En Acción', 'Acciones y campañas realizadas por el centro de estudiantes');

-- Insertar publicación de prueba
INSERT INTO publicaciones (titulo, contenido, imagen, id_usuario, id_categoria) VALUES
('Reunión de Delegados', 'El próximo lunes a las 10 hs se realizará una reunión con todos los delegados.', '', 1, 1);
