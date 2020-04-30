<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<!--<body class="body-background --><?//= ((count($errors) && !empty($modal)) || $modal) ? 'overlay' : '' ?><!--">-->
<body class="body-background">
<h1 class="visually-hidden">Дела в порядке</h1>

<div class="page-wrapper">
    <div class="container">
        <?= $header ?>
        <div class="content">
            <section class="welcome">
                <h2 class="welcome__heading">«Дела в порядке»</h2>
                <div class="welcome__text">
                    <p>«Дела в порядке» — это веб приложение для удобного ведения списка дел. Сервис помогает
                        пользователям не забывать о предстоящих важных событиях и задачах.</p>
                    <p>После создания аккаунта, пользователь может начать вносить свои дела, деля их по проектам и
                        указывая сроки.</p>
                </div>
                <a class="welcome__button button" href="/index.php?page=registration">Зарегистрироваться</a>
            </section>
        </div>
    </div>
</div>

<?= $footer ?>

<?php //if ($is_logged_in === false): ?>
<!--    --><?//= render_template('templates/authorization.php',
//        [
//            'errors' => $errors,
//            'user' => $user,
//            'modal' => $modal
//        ]);
//    ?>
<?php //endif; ?>

<script src="script.js"></script>
</body>
</html>
