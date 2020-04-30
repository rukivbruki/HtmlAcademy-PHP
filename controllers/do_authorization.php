<?php

/**
 * Регистрация пользователя
 *
 * @param mysqli $link
 * @param boolean $is_logged_in
 */
function do_authorization($link, $is_logged_in)
{

    $errors = [];
    $user = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user = $_POST['user'];

        $required = ['email', 'password'];

        foreach ($required as $key) {
            if (empty($user[$key])) {
                $errors[$key] = 'Заполните это поле';
            }
        }

        if (!empty($user['email']) && !empty($user['password'])) {
            $user_bd = get_user($link, $user);

            if ($user_bd) {
                if (password_verify($user['password'], $user_bd['password'])) {
                    $_SESSION['user'] = $user_bd['id'];
                } else {
                    $errors['password'] = 'Неверный пароль';
                }
            } else {
                $errors['email'] = 'Такой пользователь не найден';
            }
        }

        if (empty($errors)) {
            header('Location: /index.php');
            die();
        }
    }

    /** @var string $page_side */
    $page_side = $page_side = render_template('templates/side.php', [
        'is_logged_in' => $is_logged_in
    ]);

    /** @var string $page_content */
    $page_content = render_template('templates/authorization.php', ['errors' => $errors, 'user' => $user]);

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
        'title' => 'Дела в порядке - Авторизация',
        'header' => $page_header,
        'footer' => $page_footer,
        'content' => $page_content,
        'side' => $page_side,
        'user' => $user,
        'errors' => $errors,
        'is_logged_in' => $is_logged_in
    ]);

    print($layout_content);
}
