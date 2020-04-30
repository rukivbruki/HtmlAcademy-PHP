-- Заполняем список пользователей
INSERT INTO users(date_signup, email, name, password, contacts)
VALUES ('2018-03-01 00:00:00', 'katya@gmail.com',  'Катя',   'password1',  'До'),
       ('2018-03-02 11:59:59', 'valera@gmail.com', 'Валера', 'password2',  'Ре'),
       ('2018-03-03 23:59:59', 'lesha@gmail.com',  'Лёша',   'password3',  'Ми');

-- Заполняем список проектов
INSERT INTO projects(name, user_id)
VALUES ('Входящие',      1),
       ('Учеба',         2),
       ('Работа',        3),
       ('Домашние дела', 1),
       ('Авто',          2);

-- Заполняем список задач
INSERT INTO tasks(date_created, date_completed, name, file, date_deadline, user_id, project_id)
VALUES ('2018-03-02 00:00:00', null, 'Собеседование в IT компании', '', '2018-06-01 00:00:00', 1, 3),
       ('2018-03-03 00:00:00', null, 'Выполнить тестовое задание', '', '2018-05-25 00:00:00', 1, 3),
       ('2018-03-04 00:00:00', '2018-04-21 15:23:02', 'Сделать задание первого раздела', '', '2018-04-21 00:00:00', 1, 2),
       ('2018-03-05 00:00:00', null, 'Встреча с другом', '', '2018-04-22 00:00:00', 1, 1),
       ('2018-03-06 00:00:00', null, 'Купить корм для кота', '', null, 1, 4),
       ('2018-03-07 00:00:00', null, 'Заказать пиццу', '', null, 1, 4);

-- получить список из всех проектов для одного пользователя
SELECT * FROM projects
WHERE user_id = 1;

-- получить список из всех задач для одного проекта
SELECT * FROM tasks
WHERE project_id = 4;

-- пометить задачу как выполненную
UPDATE tasks SET date_completed = NOW()
WHERE id = 1;

-- получить все задачи для завтрашнего дня
SELECT * FROM tasks
WHERE date_deadline >= CURDATE() + INTERVAL 1 DAY AND date_deadline < CURDATE() + INTERVAL 2 DAY;

-- обновить название задачи по её идентификатору
UPDATE tasks SET name = 'Заказать пиццу 4 сыра'
WHERE id = 6;
