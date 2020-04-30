<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="index.php" method="get">
    <input class="search-form__input" type="text" name="search" value="<?= (!empty($search)) ? esc($search) : '' ?>"
           placeholder="Поиск по задачам">

    <input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
    <nav class="tasks-switch">
        <a href="index.php?filter=all<?= ($current_project) ? '&project_id=' . $current_project : '' ?><?= ($show_complete_tasks) ? '&show_completed=' . $show_complete_tasks : '' ?>"
           class="tasks-switch__item <?= ($filter === 'all' || !$filter) ? 'tasks-switch__item--active' : '' ?>">Все
            задачи</a>
        <a href="index.php?filter=today<?= ($current_project) ? '&project_id=' . $current_project : '' ?><?= ($show_complete_tasks) ? '&show_completed=' . $show_complete_tasks : '' ?>"
           class="tasks-switch__item <?= ($filter === 'today') ? 'tasks-switch__item--active' : '' ?>">Повестка дня</a>
        <a href="index.php?filter=tomorrow<?= ($current_project) ? '&project_id=' . $current_project : '' ?><?= ($show_complete_tasks) ? '&show_completed=' . $show_complete_tasks : '' ?>"
           class="tasks-switch__item <?= ($filter === 'tomorrow') ? 'tasks-switch__item--active' : '' ?>">Завтра</a>
        <a href="index.php?filter=expired<?= ($current_project) ? '&project_id=' . $current_project : '' ?><?= ($show_complete_tasks) ? '&show_completed=' . $show_complete_tasks : '' ?>"
           class="tasks-switch__item <?= ($filter === 'expired') ? 'tasks-switch__item--active' : '' ?>">Просроченные</a>
    </nav>

    <label class="checkbox">
        <input class="checkbox__input visually-hidden show_completed"
               type="checkbox" <?= ($show_complete_tasks) ? 'checked' : '' ?> >
        <span class="checkbox__text">Показывать выполненные</span>
    </label>
</div>

<table class="tasks">

    <?php if (!count($tasks)): ?>

        <p><i>Нет задач.</i></p>

    <?php else: ?>

        <?php foreach ($tasks as $key => $task): ?>
            <?= render_template('templates/task.php',
                [
                    'key' => $key,
                    'task' => $task
                ]);
            ?>
        <?php endforeach; ?>

    <?php endif; ?>

</table>
