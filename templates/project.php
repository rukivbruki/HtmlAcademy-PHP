<li class="main-navigation__list-item <?= ($current_project == $project['id']) ? 'main-navigation__list-item--active' : '' ?>">
    <a class="main-navigation__list-item-link"
       href="/index.php?project_id=<?= $project['id'] ?><?= (!empty($filter)) ? '&filter=' . $filter : '' ?><?= ($show_complete_tasks) ? '&show_completed=' . $show_complete_tasks : '' ?>"><?= esc($project['name']) ?></a>
    <span class="main-navigation__list-item-count">
    <?= $project['sum'] ?>
  </span>
</li>
