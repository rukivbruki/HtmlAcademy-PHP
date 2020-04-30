<header class="main-header">

    <a href="/index.php">
        <img src="img/logo.png" width="153" height="42" alt="Логотип Дела в порядке">
    </a>


    <div class="main-header__side">

        <?php if ($is_logged_in === true): ?>

            <a class="main-header__side-item button button--plus open-modal" href="/index.php?page=task"
               target="task_add">Добавить задачу</a>

            <div class="main-header__side-item user-menu">
                <div class="user-menu__image">
                    <img src="img/user-pic.jpg" width="40" height="40" alt="Пользователь">
                </div>

                <div class="user-menu__data">
                    <p><?= esc($current_user_info['name']) ?></p>

                    <a href="index.php?page=logout">Выйти</a>
                </div>
            </div>

        <?php else: ?>

            <a class="main-header__side-item button button--transparent" href="index.php?page=authorization">Войти</a>

        <?php endif; ?>

    </div>

</header>
