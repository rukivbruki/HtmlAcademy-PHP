<?php

session_start();

require_once 'functions.php';
require_once 'mysql_helper.php';
require_once 'data.php';

require_once 'controllers/do_guest.php';

require_once 'controllers/do_registration.php';
require_once 'controllers/do_authorization.php';
require_once 'controllers/do_index.php';
require_once 'controllers/do_project.php';
require_once 'controllers/do_task.php';

$db = require_once 'config/db.sample.php';
$link = connect_db($db);

/**
 * Информация о текущем пользователе
 *
 * @var array $current_user_info
 */
$current_user_info = [];

if ($is_logged_in) {
    $current_user_info = get_user_by_id($link, $current_user);
}

$page = $_GET['page'] ?? '';

switch ($page) {
    case 'registration':
        do_registration($link, $is_logged_in);
        break;
    case 'authorization':
        do_authorization($link, $is_logged_in);
        break;
    case 'project':
        do_project($link, $current_user, $current_project, $is_logged_in, $show_complete_tasks, $current_user_info);
        break;
    case 'task':
        do_task($link, $current_user, $current_project, $is_logged_in, $show_complete_tasks, $current_user_info);
        break;
    case 'logout':
        session_destroy();
        header('Location: /index.php');
        break;
    default:
        if ($is_logged_in) {
            do_index($link, $current_user, $current_project, $is_logged_in, $show_complete_tasks, $current_user_info);
        } else {
            do_guest($is_logged_in);
        }
        break;
}
