-- Создание БД
CREATE DATABASE eqvb71qhagmikjm5
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

-- Обращение к БД
USE eqvb71qhagmikjm5;

-- Создание таблицы для пользователей
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date_signup DATETIME DEFAULT NOW(),
  email CHAR(128),
  name CHAR(128),
  password CHAR(128),
  contacts VARCHAR(1024)
);

-- Создание уникального индекса
CREATE UNIQUE INDEX email ON users(email);

-- Создание таблицы для проектов
CREATE TABLE projects (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name CHAR(128),
  user_id INT,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Создание обычных индексов
CREATE INDEX u_int ON projects(user_id);

-- Создание таблицы для задач
CREATE TABLE tasks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date_created DATETIME DEFAULT NOW(),
  date_completed DATETIME,
  name VARCHAR(512),
  file VARCHAR(512),
  date_deadline DATETIME,
  user_id INT,
  project_id INT,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (project_id) REFERENCES projects(id)
);

-- Создание обычных индексов
CREATE INDEX u_int ON tasks(user_id);
CREATE INDEX p_int ON tasks(project_id);
CREATE INDEX dcre_dt ON tasks(date_created);
CREATE INDEX dcom_dt ON tasks(date_completed);
CREATE INDEX dd_dt ON tasks(date_deadline);
CREATE INDEX n_text ON tasks(name);

-- Создание полнотекстового индекса для поля "название"
CREATE FULLTEXT INDEX f_n ON tasks(name);
