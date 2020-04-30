<tr class="tasks__item task <?= task_status($task) ?>">

    <td class="task__select">
        <label class="checkbox task__checkbox">
            <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="<?= $task['id'] ?>"
                   name="<?= 'task_' . ($key + 1) ?>" <?= ($task['date_completed']) ? 'checked' : '' ?>>
            <span class="checkbox__text"><?= esc($task['name']) ?></span>
        </label>
    </td>

    <td class="task__file">
        <?php if ($task['file']): ?>
            <a class="download-link" href="/uploads/<?= esc($task['file']) ?>"
               target="_blank"><?= esc($task['file']) ?></a>
        <?php endif; ?>
    </td>

    <td class="task__date"><?= esc($task['date_deadline_formatted']) ?></td>

</tr>
