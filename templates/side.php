<?php if ($is_logged_in === false): ?>

    <p class="content__side-info">Если у вас уже есть аккаунт, авторизуйтесь на сайте</p>

    <a class="button button--transparent content__side-button" href="index.php?form=auth">Войти</a>

<?php else: ?>

    <h2 class="content__side-heading">Проекты</h2>

    <nav class="main-navigation">
        <ul class="main-navigation__list">

            <li class="main-navigation__list-item <?= (!$current_project) ? 'main-navigation__list-item--active' : '' ?>">
                <a class="main-navigation__list-item-link"
                   href="index.php?filter=<?= (!empty($filter)) ? $filter : '' ?><?= ($show_complete_tasks) ? '&show_completed=' . $show_complete_tasks : '' ?>">Все</a>
                <span class="main-navigation__list-item-count"><?= $tasks_count ?></span>
            </li>

            <?php foreach ($projects as $key => $project): ?>
                <?= render_template('templates/project.php',
                    [
                        'key' => $key,
                        'project' => $project,
                        'tasks' => $tasks,
                        'current_project' => $current_project,
                        'filter' => $filter,
                        'show_complete_tasks' => $show_complete_tasks
                    ]);
                ?>
            <?php endforeach; ?>

        </ul>
    </nav>

    <a class="button button--transparent button--plus content__side-button open-modal"
       href="index.php?page=project" target="project_add">Добавить проект</a>

<?php endif; ?>
