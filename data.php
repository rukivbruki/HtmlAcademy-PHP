<?php

/**
 * Показывать или нет выполненные задачи
 *
 * @var integer $show_complete_tasks
 */
$show_complete_tasks = $_GET['show_completed'] ?? 0;

/**
 * Текущий студент
 *
 * @var integer $current_user
 */
$current_user = $_SESSION['user'] ?? 0;

/**
 * Текущий выбранный проект
 *
 * @var integer $current_project
 */
$current_project = $_GET['project_id'] ?? 0;


/**
 * Пользователь залогинен или нет
 *
 * @var boolean $is_logged_in
 */
$is_logged_in = (bool)$current_user;
