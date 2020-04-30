<?php

require_once "do_index.php";

/**
 * @param $link
 * @param $current_user
 * @param $current_project
 * @param $is_logged_in
 * @param $current_user_info
 */
function do_project($link, $current_user, $current_project, $is_logged_in, $current_user_info)
{

    $errors = [];
    $project = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $project = $_POST['project'];

        if (empty($project['name'])) {
            $errors['project']['name'] = 'Заполните это поле';
        }

        if (!empty($project['name'])) {
            $is_project_exists = is_project_exists($link, $current_user, $project);

            if ($is_project_exists) {
                $errors['project']['name'] = 'Такой проект уже существует';
            }
        }

        if (!count($errors['project'])) {
            $res = add_project($link, $current_user, $project);

            if (!$res) {
                http_response_code(503);
                die();
            }

            header('Location: /index.php');
            die();
        }
    }

    $filter = $_GET['filter'] ?? 'all';


    $tasks_count = count_tasks($link, $current_user);
    $projects = get_projects($link, $current_user);

    /** @var string $page_side */
    $page_side = render_template('templates/side.php', [
        'current_project' => $current_project,
        'tasks_count' => $tasks_count,
        'projects' => $projects,
        'is_logged_in' => $is_logged_in,
        'filter' => $filter
    ]);

    /** @var string $page_content__form_project */
    $page_content = render_template('templates/form-project.php', [
        'errors' => $errors,
        'project' => $project
    ]);

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
        'title' => 'Дела в порядке - Добавление проекта',
        'header' => $page_header,
        'footer' => $page_footer,
        'side' => $page_side,
        'content' => $page_content,
        'projects' => $projects,
        'errors' => $errors,
        'project' => $project,
        'is_logged_in' => $is_logged_in
    ]);

    print($layout_content);
}
