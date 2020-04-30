<h2 class="modal__heading">Вход на сайт</h2>

<form class="form" action="index.php?page=authorization" method="post" enctype="multipart/form-data">
    <div class="form__row">
        <?php
        $class_error = isset($errors['email']) ? 'form__input--error' : '';
        $value = $user['email'] ?? '';
        ?>

        <label class="form__label" for="email">E-mail <sup>*</sup></label>
        <input class="form__input <?= $class_error ?>" type="text" name="user[email]" id="email"
               value="<?= $value ?>" placeholder="Введите e-mail">

        <?php if (isset($errors['email'])): ?>
            <p class="form__message"><?= $errors['email'] ?></p>
        <?php endif; ?>
    </div>

    <div class="form__row">
        <?php
        $class_error = isset($errors['password']) ? 'form__input--error' : '';
        $value = $user['password'] ?? '';
        ?>

        <label class="form__label" for="password">Пароль <sup>*</sup></label>
        <input class="form__input <?= $class_error ?>" type="password" name="user[password]" id="password"
               value="<?= $value ?>" placeholder="Введите пароль">

        <?php if (isset($errors['password'])): ?>
            <p class="form__message"><?= $errors['password'] ?></p>
        <?php endif; ?>
    </div>

    <div class="form__row form__row--controls">
        <?php if (count($errors)): ?>
            <p class="error-message">Пожалуйста, исправьте ошибки в форме</p>
        <?php endif; ?>
        <input class="button" type="submit" name="" value="Войти">
    </div>
</form>
