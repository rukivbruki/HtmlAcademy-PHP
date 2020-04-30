<?php

/**
 * Отрисовка главной страницы для анонимного пользователя
 *
 * @param boolean $is_logged_in
 */

function do_guest($is_logged_in)
{

  $errors = [];
  $user = [];

  /** @var string $page_header */
  $page_header = render_template('templates/header.php', [
    'is_logged_in' => $is_logged_in
  ]);

  /** @var string $page_footer */
  $page_footer = render_template('templates/footer.php', [
    'is_logged_in' => $is_logged_in
  ]);

  /** @var string $layout_content */
  $layout_content = render_template('templates/guest.php', [
    'title' => 'Дела в порядке',
    'header' => $page_header,
    'footer' => $page_footer,
    'is_logged_in' => $is_logged_in,
    'errors' => $errors,
      'user' => $user
  ]);

  print($layout_content);
}
