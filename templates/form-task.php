<h2 class="content__main-heading">Добавление задачи</h2>

<form class="form" action="index.php?page=task" method="post" enctype="multipart/form-data">
    <div class="form__row">
        <?php
        $class_error = isset($errors['task']['name']) ? 'form__input--error' : '';
        $value = $task['name'] ?? '';
        ?>

        <label class="form__label" for="task_name">Название <sup>*</sup></label>

        <input class="form__input <?= $class_error ?>" type="text" name="task[name]" id="task_name"
               value="<?= $value ?>" placeholder="Введите название">

        <?php if (isset($errors['task']['name'])): ?>
            <p class="form__message"><?= $errors['task']['name'] ?></p>
        <?php endif; ?>
    </div>

    <div class="form__row">
        <?php
        $class_error = isset($errors['task']['project']) ? 'form__input--error' : '';
        $value = $task['project'] ?? '';
        ?>

        <label class="form__label" for="task_project">Проект <sup>*</sup></label>

        <select class="form__input form__input--select <?= $class_error; ?>" name="task[project]" id="task_project">
            <option>Выберите проект</option>
            <?php foreach ($projects as $key => $project): ?>
                <option
                    value="<?= $project['id'] ?>" <?= ($project['id'] === $value) ? 'selected' : '' ?> ><?= esc($project['name']) ?></option>
            <?php endforeach; ?>
        </select>

        <?php if (isset($errors['task']['project'])): ?>
            <p class="form__message"><?= $errors['task']['project'] ?></p>
        <?php endif; ?>
    </div>

    <div class="form__row">
        <?php
        $class_error = isset($errors['task']['date']) ? 'form__input--error' : '';
        $value = $task['date'] ?? '';
        ?>

        <label class="form__label" for="task_date">Срок выполнения</label>

        <input class="form__input form__input--date <?= $class_error ?>" value="<?= $value ?>" type="date"
               name="task[date]" id="task_date"
               placeholder="Введите дату и время">

        <?php if (isset($errors['task']['date'])): ?>
            <p class="form__message"><?= $errors['task']['date'] ?></p>
        <?php endif; ?>
    </div>

    <div class="form__row">
        <label class="form__label" for="task_file">Файл</label>

        <div class="form__input-file">
            <input class="visually-hidden" type="file" name="task_file" id="task_file" value="">

            <label class="button button--transparent" for="task_file">
                <span>Выберите файл</span>
            </label>
        </div>
    </div>

    <div class="form__row form__row--controls">
        <?php if (count($errors)): ?>
            <p class="error-message">Пожалуйста, исправьте ошибки в форме</p>
        <?php endif; ?>
        <input class="button" type="submit" name="" value="Добавить">
    </div>
</form>

