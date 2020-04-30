<?php

require_once 'vendor/autoload.php';
require_once 'functions.php';

$db = require_once 'config/db.sample.php';
$link = connect_db($db);

$tasks = get_fire_task($link);
$user_tasks = [];

if (count($tasks)) {

    foreach ($tasks as $task) {
        $user_tasks[$task['user_id']][] = $task;
    }

    foreach ($user_tasks as $tasks) {
        $name = $tasks[0]['user_name'];
        $email = $tasks[0]['email'];

        $body = "Уважаемый, {$name}. Следующие задачи скоро истекут:\n";

        foreach ($tasks as $task) {
            $body .= "\n- Задача '{$task['task_name']}' на {$task['date_deadline']}.";
        }

        // Create the Transport
        $transport = (new Swift_SmtpTransport('phpdemo.ru', 25))
            ->setUsername('keks@phpdemo.ru')
            ->setPassword('htmlacademy');

        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);

        // Create a message
        $message = (new Swift_Message('Уведомление от сервиса «Дела в порядке»'))
            ->setFrom(['keks@phpdemo.ru' => 'Keks'])
            ->setTo([$email => $name])
            ->setBody($body, 'text/plain');

        // Send the message
        $result = $mailer->send($message);
    }
}
