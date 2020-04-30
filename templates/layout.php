<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/flatpickr.min.css">
</head>
<body>
<h1 class="visually-hidden">Дела в порядке</h1>

<div class="page-wrapper">
    <div class="container container--with-sidebar">
        <?= $header ?>
        <div class="content">
            <section class="content__side"><?= $side ?></section>
            <main class="content__main">
                <?= $content ?>
            </main>
        </div>
    </div>
</div>

<?= $footer ?>

<script src="flatpickr.js"></script>
<script src="script.js"></script>
</body>
</html>
