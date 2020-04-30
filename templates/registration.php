<h2 class="content__main-heading">Регистрация аккаунта</h2>

<form class="form" action="/index.php?page=registration" method="post" enctype="multipart/form-data">

    <div class="form__row">
        <?php
        $class_error = isset($errors['email']) ? 'form__input--error' : '';
        $value = $signup['email'] ?? '';
        ?>
        <label class="form__label" for="email">E-mail <sup>*</sup></label>

        <input class="form__input <?= $class_error ?>" type="text" name="signup[email]" id="email" value="<?= $value ?>"
               placeholder="Введите e-mail">

        <?php if (isset($errors['email'])): ?>
            <p class="form__message"><?= $errors['email'] ?></p>
        <?php endif; ?>
    </div>

    <div class="form__row">
        <?php
        $class_error = isset($errors['password']) ? 'form__input--error' : '';
        $value = $signup['password'] ?? '';
        ?>
        <label class="form__label" for="password">Пароль <sup>*</sup></label>

        <input class="form__input <?= $class_error ?>" type="password" name="signup[password]" id="password"
               value="<?= $value ?>" placeholder="Введите пароль">

        <?php if (isset($errors['password'])): ?>
            <p class="form__message"><?= $errors['password'] ?></p>
        <?php endif; ?>
    </div>

    <div class="form__row">
        <?php
        $class_error = isset($errors['name']) ? 'form__input--error' : '';
        $value = $signup['name'] ?? '';
        ?>

        <label class="form__label" for="name">Имя <sup>*</sup></label>

        <input class="form__input <?= $class_error ?>" type="text" name="signup[name]" id="name" value="<?= $value ?>"
               placeholder="Введите имя">

        <?php if (isset($errors['name'])): ?>
            <p class="form__message"><?= $errors['name'] ?></p>
        <?php endif; ?>
    </div>

    <div class="form__row form__row--controls">
        <?php if (count($errors)): ?>
            <p class="error-message">Пожалуйста, исправьте ошибки в форме</p>
        <?php endif; ?>

        <input class="button" type="submit" name="" value="Зарегистрироваться">
    </div>
</form>
