<?php

/**
 * Регистрация пользователя
 *
 * @param mysqli $link
 * @param boolean $is_logged_in
 */
function do_registration($link, $is_logged_in)
{
    $errors = [];
    $signup = [];
    $modal = $_GET['form'] ?? '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $signup = $_POST['signup'];

        $required = ['email', 'password', 'name'];

        foreach ($required as $key) {
            if (empty($signup[$key])) {
                $errors[$key] = 'Заполните это поле';
            }
        }

        if (!empty($signup['email'])) {
            if (filter_var($signup['email'], FILTER_VALIDATE_EMAIL)) {
                $res = is_user_exists($link, $signup);

                if ($res) {
                    $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
                }

            } else {
                $errors['email'] = 'Введён некорректный email';
            }
        }

        if (empty($errors)) {
            $user_id = add_user($link, $signup);

            if ($user_id) {
                add_project_default($link, $user_id);

                header('Location: /index.php?form=auth');
                die();
            } else {
                http_response_code(503);
                die();
            }
        }
    }

    /** @var string $page_side */
    $page_side = $page_side = render_template('templates/side.php', [
        'is_logged_in' => $is_logged_in
    ]);

    /** @var string $page_content */
    $page_content = render_template('templates/registration.php', ['errors' => $errors, 'signup' => $signup]);

    /** @var string $page_header */
    $page_header = render_template('templates/header.php', [
        'is_logged_in' => $is_logged_in
    ]);

    /** @var string $page_footer */
    $page_footer = render_template('templates/footer.php', [
        'is_logged_in' => $is_logged_in
    ]);

    /** @var string $layout_content */
    $layout_content = render_template('templates/layout.php', [
        'title' => 'Дела в порядке - Регистрация',
        'header' => $page_header,
        'footer' => $page_footer,
        'content' => $page_content,
        'side' => $page_side,
        'errors' => $errors,
        'modal' => $modal,
        'is_logged_in' => $is_logged_in
    ]);

    print($layout_content);
}
