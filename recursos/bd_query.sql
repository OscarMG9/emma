CREATE DATABASE administracion CHARACTER SET utf8 COLLATE utf8_general_ci;

USE administracion;

CREATE TABLE rol (
  idrol INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  rol VARCHAR(20) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE usuario (
  idusuario INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(45) NOT NULL,
  ap_paterno VARCHAR(45) NOT NULL,
  ap_materno VARCHAR(45),
  sexo TINYINT(1) NOT NULL,
  correo VARCHAR(100) NOT NULL,
  password VARCHAR(64),  
  imagen_perfil VARCHAR(100),
  idrol INT(11) NOT NULL,
  FOREIGN KEY(idrol) REFERENCES rol(idrol) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE alumno (
  idalumno INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(45) NOT NULL,
  matricula VARCHAR(10) NOT NULL,
  grado VARCHAR(20) NOT NULL,
  grupo CHAR(1) NOT NULL,
  idusuario INT(11) NOT NULL,
  FOREIGN KEY(idusuario) REFERENCES usuario(idusuario) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE programa_educativo (
  idprograma_educativo INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  programaeducativo VARCHAR(100) NOT NULL,
  acronimo VARCHAR(45),
  logo VARCHAR(45)
) ENGINE = InnoDB;

CREATE TABLE docente (
  iddocente INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  numempleado VARCHAR(45) NOT NULL,
  gradoestudios VARCHAR(100) NOT NULL,
  usuario_idusuario INT(11) NOT NULL,
  programa_educativo_idpe INT(11) NOT NULL,
  FOREIGN KEY(usuario_idusuario) REFERENCES usuario(idusuario) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY(programa_educativo_idpe) REFERENCES programa_educativo(idprograma_educativo) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE asignatura (
  idasignatura INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  asignatura VARCHAR(100) NOT NULL,
  acronimo VARCHAR(45) NOT NULL,
  creditos INT(11)
) ENGINE = InnoDB;

CREATE TABLE periodo (
  idperiodo INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nombreperiodo VARCHAR(100) NOT NULL,
  acronimo VARCHAR(45),
  fechainicio DATE NOT NULL,
  fechafin DATE NOT NULL,
  estatus TINYINT(1)
) ENGINE = InnoDB;

CREATE TABLE carga_horaria (
  idcarga_horaria INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  asignatura_idasignatura INT(11) NOT NULL,
  docente_iddocente INT(11) NOT NULL,
  periodo_idperiodo INT(11) NOT NULL,
  fecha_asignacion DATETIME NOT NULL,
  ponderacion_parcial_a INT(11),
  ponderacion_parcial_b INT(11),
  ponderacion_parcial_c INT(11),
  ponderacion_parcial_d INT(11),
  FOREIGN KEY(asignatura_idasignatura) REFERENCES asignatura(idasignatura) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY(docente_iddocente) REFERENCES docente(iddocente) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY(periodo_idperiodo) REFERENCES periodo(idperiodo) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE lista_alumnos (
  idlista_alumnos INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  fecha_registro DATE NOT NULL,
  alumno_idalumno INT(11) NOT NULL,
  docente_iddocente INT(11) NOT NULL,
  asignatura_idasignatura INT(11) NOT NULL,
  tipo_asistencia CHAR(1),
  fecha_asistencia DATE,
  estatus_alumno TINYINT(1),
  FOREIGN KEY(alumno_idalumno) REFERENCES alumno(idalumno) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY(docente_iddocente) REFERENCES docente(iddocente) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY(asignatura_idasignatura) REFERENCES asignatura(idasignatura) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE calificaciones (
  idcalificaciones INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  calificacion_a INT(11),
  calificacion_b INT(11) NOT NULL,
  calificacion_c INT(11) NOT NULL,
  calificacion_d INT(11) NOT NULL,
  calificacion_final INT(11) NOT NULL,
  lista_alumnos_idlista_alumnos INT(11) NOT NULL,
  periodo_idperiodo INT(11) NOT NULL,
  FOREIGN KEY(lista_alumnos_idlista_alumnos) REFERENCES lista_alumnos(idlista_alumnos) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY(periodo_idperiodo) REFERENCES periodo(idperiodo) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

INSERT INTO rol (idrol, rol) VALUES
(745, 'Administrador'),
(120, 'Alumno'),
(125, 'Docente');

INSERT INTO usuario (nombre, ap_paterno, ap_materno, sexo, correo, password, imagen_perfil, idrol) 
VALUES ('Administrador', 'Administrador', '', 0, 'admin@baseci4.com', SHA2('admin123', 0), NULL, 745);

GRANT ALL PRIVILEGES ON administracion.* TO 'usersistem'@'localhost' IDENTIFIED BY 'passwordsistem';
