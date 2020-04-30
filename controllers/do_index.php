<?php

/**
 * Отрисовка главной страницы для залогиненного пользователя
 *
 * @param mysqli $link
 * @param integer $current_user
 * @param integer $current_project
 * @param boolean $is_logged_in
 * @param boolean $show_complete_tasks
 * @param array $current_user_info
 */
function do_index($link, $current_user, $current_project, $is_logged_in, $show_complete_tasks, $current_user_info)
{

    if ($current_project) {
        if (!check_project($link, $current_user, $current_project)) {
            header('Location: /index.php');
            die();
        }
    }

    if (isset($_GET['check'])) {
        $check = $_GET['check'];
        $task_id = $_GET['task_id'];

        if (is_task_belongs_to_user($link, $task_id, $current_user)) {
            change_task_status($link, $task_id, $check);

            header('Location: /index.php');
        }
    }

//    $errors = [];
//    $project = [];
//    $task = [];


    $filter = $_GET['filter'] ?? 'all';
    $search = $_GET['search'] ?? '';

    $tasks = get_tasks($link, $current_user, $show_complete_tasks, $filter, $search, $current_project);
    $tasks_count = count_tasks($link, $current_user);
    $projects = get_projects($link, $current_user);

    /** @var string $page_side */
    $page_side = render_template('templates/side.php', [
        'current_project' => $current_project,
        'tasks_count' => $tasks_count,
        'projects' => $projects,
        'tasks' => $tasks,
        'show_complete_tasks' => $show_complete_tasks,
        'is_logged_in' => $is_logged_in,
        'filter' => $filter
    ]);

    /** @var string $page_content */
    $page_content = render_template('templates/index.php', [
        'tasks' => $tasks,
        'show_complete_tasks' => $show_complete_tasks,
        'current_project' => $current_project,
        'filter' => $filter,
        'search' => $search
    ]);

//    /** @var string page_content__form_task */
//    $page_content__form_task = render_template('templates/form-task.php', [
//        'projects' => $projects,
//        'errors' => $errors,
//        'task' => $task
//    ]);

    /** @var string $page_header */
    $page_header = render_template('templates/header.php', [
        'is_logged_in' => $is_logged_in,
        'current_user_info' => $current_user_info
    ]);

    /** @var string $page_footer */
    $page_footer = render_template('templates/footer.php', [
        'is_logged_in' => $is_logged_in
    ]);

    /** @var string $layout_content */
    $layout_content = render_template('templates/layout.php', [
        'title' => 'Дела в порядке - Главная страница',
        'header' => $page_header,
        'footer' => $page_footer,
        'side' => $page_side,
//        'page_content__form_task' => $page_content__form_task,
        'content' => $page_content,
//        'projects' => $projects,
//        'errors' => $errors,
//        'task' => $task,
//        'project' => $project,
//        'is_logged_in' => $is_logged_in
    ]);

    print($layout_content);
}
