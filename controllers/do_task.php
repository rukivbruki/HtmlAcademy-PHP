<?php


/**
 * @param $link
 * @param $current_user
 * @param $current_project
 * @param $is_logged_in
 * @param $show_complete_tasks
 * @param $current_user_info
 */
function do_task($link, $current_user, $current_project, $is_logged_in, $current_user_info)
{

    $errors = [];
    $task = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $task = $_POST['task'];

        $required = ['name', 'project'];

        foreach ($required as $key) {
            if (empty($task[$key])) {
                $errors['task'][$key] = 'Заполните это поле';
            }
        }

        if (!empty($task['project'])) {
            if (!check_project($link, $current_user, $task['project'])) {
                $errors['task']['project'] = 'Неверно задан проект';
            }
        }

        if (!empty($task['date'])) {
            $test = strtotime($task['date']);

            if ($test === false) {
                $errors['task']['date'] = 'Неверная дата';
            } else if (hours_left($task['date']) < 0) {
                $errors['task']['date'] = 'Дата должна быть в будущем';
            }
        }

        if (isset($_FILES['task_file']) && is_uploaded_file($_FILES['task_file']['tmp_name'])) {
            $file = $_FILES['task_file'];
            $file_ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . '.' . $file_ext;

            move_uploaded_file($file['tmp_name'], 'uploads/' . $filename);

            $task['filename'] = $filename;
        }

        if (!count($errors['task'])) {
            $res = add_task($link, $current_user, $task);

            if (!$res) {
                http_response_code(503);
                die();
            }

            header('Location: /index.php?project_id=' . $task['project']);
            die();
        }
    }

    $filter = $_GET['filter'] ?? 'all';
    $search = $_GET['search'] ?? '';

    $tasks = get_tasks($link, $current_user, $filter, $search, $current_project);
    $tasks_count = count_tasks($link, $current_user);
    $projects = get_projects($link, $current_user);

    /** @var string $page_side */
    $page_side = render_template('templates/side.php', [
        'current_project' => $current_project,
        'tasks_count' => $tasks_count,
        'projects' => $projects,
        'tasks' => $tasks,
        'is_logged_in' => $is_logged_in,
        'filter' => $filter
    ]);

    /** @var string $page_content */
    $page_content = render_template('templates/form-task.php', [
        'projects' => $projects,
        'errors' => $errors,
        'task' => $task
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
        'title' => 'Дела в порядке - Добавление задачи',
        'header' => $page_header,
        'footer' => $page_footer,
        'side' => $page_side,
        'content' => $page_content,
        'errors' => $errors,
        'task' => $task
    ]);

    print($layout_content);
}
