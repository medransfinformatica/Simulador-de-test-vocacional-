CREATE DATABASE vocacional2;
USE vocacional2;

CREATE TABLE resultados (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  area1 VARCHAR(50),
  area2 VARCHAR(50),
  puntaje1 INT,
  puntaje2 INT
);
