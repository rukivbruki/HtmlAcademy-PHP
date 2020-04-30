<?php

/**
 *
 * Функция-шаблонизатор
 *
 * @param string $template_name
 * @param array $data
 *
 * @return string
 */
function render_template($template_name, $data)
{
    if (!file_exists($template_name)) {
        return '';
    }

    extract($data);

    ob_start();
    require $template_name;
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

/**
 * Фильтрация для защиты от XSS
 *
 * @param string $str
 * @param bool $html_special
 *
 * @return string
 */
function esc($str, $html_special = true)
{
    $text = ($html_special) ? htmlspecialchars($str) : strip_tags($str);

    return $text;
}

/**
 * Функция для вычисления разницы между двумя датами
 *
 * @param string $task_date
 *
 * @return integer
 */
function hours_left($task_date)
{
    $current_date_ts = time();
    $task_date_ts = strtotime($task_date);

    $seconds_left = $task_date_ts - $current_date_ts;
    $hours_left = floor($seconds_left / 3600);

    return $hours_left;
}

/**
 * Функция для определения статуса задачи
 *
 * @param array $task
 *
 * @return string
 */
function task_status($task)
{
    $result = '';
    $task_date = $task['date_deadline'];
    $task_completed = (boolean)$task['date_completed'];

    if ($task_completed) {
        $result = 'task--completed';
    } else if ($task_date && hours_left($task_date) <= 24) {
        $result = 'task--important ';
    }

    return $result;
}

/**
 * Функция подключения к БД
 *
 * @param array $db
 *
 * @return mysqli
 */
function connect_db($db)
{
    $link = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
    mysqli_set_charset($link, 'utf8');

    if (!$link) {
        $error = mysqli_connect_error();
        die($error);
    }

    return $link;
}

/**
 * Функция помощник
 *
 * @param mysqli $link
 * @param string $sql
 *
 * @return array|boolean
 */
function sql_helper($link, $sql)
{
    $result_sql = mysqli_query($link, $sql);

    if ($result_sql) {
        $result = mysqli_fetch_all($result_sql, MYSQLI_ASSOC);
    } else {
        $result = false;
    }

    return $result;
}

/**
 * Подсчёт всех задач текущего пользователя
 *
 * @param mysqli $link
 * @param integer $current_user
 *
 * @return integer
 */
function count_tasks($link, $current_user)
{
    $sql = 'SELECT COUNT(id) as sum_all 
          FROM tasks 
          WHERE date_completed IS NULL AND user_id = ' . $current_user;
    $result = sql_helper($link, $sql);

    return $result[0]['sum_all'];
}

/**
 * Проверка существет ли проект и принадлежит ли он указанному юзеру
 *
 * @param mysqli $link
 * @param integer $user
 * @param integer $project
 *
 * @return boolean
 */
function check_project($link, $user, $project)
{
    $check = false;

    $sql = 'SELECT COUNT(id) as flag
          FROM projects 
          WHERE user_id = ' . $user .
        ' AND id = ' . $project;

    $result = sql_helper($link, $sql);

    if ($result[0]['flag'] != 0) {
        $check = true;
    }

    return $check;
}

/**
 * Все задачи текущего пользователя
 *
 * @param mysqli $link
 * @param integer $current_user
 * @param integer $show_complete_tasks
 * @param string $filter
 * @param string $search
 * @param integer $current_project
 *
 * @return array|boolean
 */
function get_tasks($link, $current_user, $show_complete_tasks, $filter, $search, $current_project = 0)
{
    $sql = 'SELECT *, DATE_FORMAT(date_deadline, "%d.%m.%Y") as date_deadline_formatted 
          FROM tasks 
          WHERE user_id = ' . $current_user;

    switch ($filter) {
        case 'today':
            $sql .= ' AND DATE(date_deadline) = CURDATE()';
            break;
        case 'tomorrow':
            $sql .= ' AND DATE(date_deadline) = CURDATE() + 1';
            break;
        case 'expired':
            $sql .= ' AND DATE(date_deadline) < CURDATE()';
            break;
        default:
            break;
    }

    if ($current_project) {
        $sql .= ' AND project_id = ' . $current_project;
    }

    if (!$show_complete_tasks) {
        $sql .= ' AND date_completed IS NULL';
    }

    if (!empty($search)) {
        $search = mysqli_real_escape_string($link, trim($search));
        $sql .= ' AND MATCH (name) AGAINST ("' . $search . '")';
    }

    $sql .= ' ORDER BY date_created DESC';

    return sql_helper($link, $sql);
}

/**
 * Все проекты текущего пользователя
 *
 * @param mysqli $link
 * @param integer $current_user
 *
 * @return array|boolean
 */
function get_projects($link, $current_user)
{
    $sql = 'SELECT p.*, (SELECT COUNT(id) 
          FROM tasks 
          WHERE project_id = p.id AND date_completed IS NULL) as sum 
          FROM projects p 
          WHERE p.user_id = ' . $current_user;

    return sql_helper($link, $sql);
}

/**
 * Добавляет новую задачу в БД
 *
 * @param mysqli $link
 * @param integer $current_user
 * @param array $task
 *
 * @return boolean
 */
function add_task($link, $current_user, $task)
{
    $sql = 'INSERT INTO tasks (date_created, user_id, project_id, name, file, date_deadline) VALUES (NOW(), ?, ?, ?, ?, ?)';
    $stmt = db_get_prepare_stmt($link, $sql, [
        $current_user,
        $task['project'],
        $task['name'],
        $task['filename'] ?? '',
        (!empty($task['date'])) ? $task['date'] : null
    ]);

    return mysqli_stmt_execute($stmt);
}

/**
 * Проверяет существует ли пользователь в БД
 *
 * @param mysqli $link
 * @param array $signup
 *
 * @return boolean|mysqli_result
 */
function is_user_exists($link, $signup)
{
    $email = mysqli_real_escape_string($link, $signup['email']);
    $sql = 'SELECT id FROM users WHERE email = "' . $email . '"';
    return mysqli_num_rows(mysqli_query($link, $sql));
}

/**
 * Добавляет нового пользователя в БД
 *
 * @param mysqli $link
 * @param array $signup
 *
 * @return boolean
 */
function add_user($link, $signup)
{
    $password = password_hash($signup['password'], PASSWORD_DEFAULT);
    $sql = 'INSERT INTO users (date_signup, email, name, password) VALUES (NOW(), ?, ?, ?)';
    $stmt = db_get_prepare_stmt($link, $sql, [$signup['email'], $signup['name'], $password]);
    $result = false;

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_insert_id($link);
    }

    return $result;
}

/**
 * Возвращает запрошенного пользователя по email
 *
 * @param mysqli $link
 * @param array $user
 *
 * @return array|null
 */
function get_user($link, $user)
{
    $email = mysqli_real_escape_string($link, $user['email']);
    $sql = 'SELECT * FROM users WHERE email = "' . $email . '"';
    $res = mysqli_query($link, $sql);
    return $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;
}

/**
 * Возвращает запрошенного пользователя по id
 *
 * @param mysqli $link
 * @param integer $user_id
 *
 * @return array|null
 */
function get_user_by_id($link, $user_id)
{
    $user_id = mysqli_real_escape_string($link, $user_id);
    $sql = 'SELECT * FROM users WHERE id = ' . $user_id;
    $res = mysqli_query($link, $sql);
    return $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;
}

/**
 * Добавляет проект по умолчанию при регистрации
 *
 * @param mysqli $link
 * @param integer $user_id
 *
 * @return boolean
 */
function add_project_default($link, $user_id)
{
    $sql = 'INSERT INTO projects (name, user_id) VALUES ("PHP интенсив", ?)';
    $stmt = db_get_prepare_stmt($link, $sql, [$user_id]);
    return mysqli_stmt_execute($stmt);
}

/**
 * Добавляет проект
 *
 * @param mysqli $link
 * @param integer $user_id
 * @param array $project
 *
 * @return boolean
 */
function add_project($link, $user_id, $project)
{
    $sql = 'INSERT INTO projects (name, user_id) VALUES (?, ?)';
    $stmt = db_get_prepare_stmt($link, $sql, [$project['name'], $user_id]);
    return mysqli_stmt_execute($stmt);
}

/**
 * Проверяет существует ли проект с введённым названием
 *
 * @param mysqli $link
 * @param integer $user_id
 * @param array $project
 *
 * @return integer
 */
function is_project_exists($link, $user_id, $project)
{
    $project_name = mysqli_real_escape_string($link, $project['name']);
    $sql = 'SELECT * FROM projects WHERE user_id = ' . $user_id . ' AND name = "' . $project_name . '"';
    return mysqli_num_rows(mysqli_query($link, $sql));
}

/**
 * Проверяет принадлежность задачи текущему пользователю
 *
 * @param mysqli $link
 * @param integer $task_id
 * @param integer $user_id
 *
 * @return integer
 */
function is_task_belongs_to_user($link, $task_id, $user_id)
{
    $sql = 'SELECT * FROM tasks WHERE user_id = ' . $user_id . ' AND id = ?';
    $stmt = db_get_prepare_stmt($link, $sql, [$task_id]);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    return mysqli_stmt_num_rows($stmt);
}

/**
 * Изменяет статус задачи
 *
 * @param mysqli $link
 * @param integer $task_id
 * @param boolean $completed
 *
 * @return boolean
 */
function change_task_status($link, $task_id, $completed)
{
    if ($completed) {
        $date = 'NOW()';
    } else {
        $date = 'NULL';
    }

    $sql = 'UPDATE tasks SET date_completed = ' . $date . ' WHERE id = ?';
    $stmt = db_get_prepare_stmt($link, $sql, [$task_id]);
    return mysqli_stmt_execute($stmt);
}

/**
 * Добывает горящие задачи
 *
 * @param mysqli $link
 *
 * @return array
 */
function get_fire_task($link)
{
    $sql = 'SELECT t.name as task_name, t.date_deadline, t.user_id, u.name as user_name, u.email 
          FROM tasks t
          LEFT JOIN users u ON t.user_id = u.id
          WHERE t.date_deadline BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 1 HOUR);';
    return sql_helper($link, $sql);
}
