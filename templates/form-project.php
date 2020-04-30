<h2 class="content__main-heading">Добавление проекта</h2>

<form class="form" action="/index.php?page=project" method="post">
    <div class="form__row">
        <?php
        $class_error = isset($errors['project']['name']) ? 'form__input--error' : '';
        $value = $project['name'] ?? '';
        ?>
        <label class="form__label" for="project_name">Название <sup>*</sup></label>

        <input class="form__input <?= $class_error ?>" type="text" name="project[name]" id="project_name"
               value="<?= $value ?>" placeholder="Введите название проекта">
        <?php if (isset($errors['project']['name'])): ?>
            <p class="form__message"><?= $errors['project']['name'] ?></p>
        <?php endif; ?>
    </div>

    <div class="form__row form__row--controls">
        <input class="button" type="submit" name="" value="Добавить">
    </div>
</form>
