<?php
use models\TodoItemModel;
$tableHasAdminEditMark = count(array_filter($items, function($item) {
    return (bool) $item['admin_edit'];
})) != 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/styles.css">
    <title>BeeJee Test</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md">
                <nav aria-label="...">
                    <ul class="pagination">
                        <li class="page-item <?= $currentPage > 1 ? '' : 'disabled' ?>">
                            <a class="page-link" href="?sort=<?= $sortField ?>&order=<?= $sortOrder ?>&p=1" tabindex="-1" aria-disabled="true">&laquo;</a>
                        </li>
                        <?php if ($currentPage - 1 > 0) : ?>
                            <li class="page-item"><a class="page-link" href="?sort=<?= $sortField ?>&order=<?= $sortOrder ?>&p=<?= $currentPage - 1 ?>"><?= $currentPage - 1 ?></a></li>
                        <?php endif ?>
                        <li class="page-item active" aria-current="page">
                            <a class="page-link" href="#"><?= $currentPage ?></a>
                        </li>
                        <?php if ($currentPage + 1 <= $lastPage) : ?>
                            <li class="page-item"><a class="page-link" href="?sort=<?= $sortField ?>&order=<?= $sortOrder ?>&p=<?= $currentPage + 1 ?>"><?= $currentPage + 1 ?></a></li>
                        <?php endif ?>
                        <li class="page-item <?= $currentPage < $lastPage ? '' : 'disabled' ?>">
                            <a class="page-link" href="?sort=<?= $sortField ?>&order=<?= $sortOrder ?>&p=<?= $lastPage ?>">&raquo;</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <?php if ($isAdmin) : ?>
                <div class="col-auto"><a href="/logout" class="btn btn-primary">Выйти из профиля</a></div>
            <?php else : ?>
                <div class="col-auto"><a href="/login" class="btn btn-primary">Авторизация</a></div>
            <?php endif ?>
        </div>

        <h4>Список задач</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>
                        <a href="?sort=username&order=<?= $sortField === 'username' 
                            ? ($sortOrder === 'asc' ? 'desc' : 'asc') : $sortOrder 
                        ?>&p=<?= $currentPage ?>" class="table-header-nowrap">Имя пользователя
                            <?php if ($sortField === 'username') : ?>
                                <i class="fa fa-caret-<?= $sortOrder === 'asc' ? 'up' : 'down' ?>"></i>
                            <?php endif ?>
                        </a>
                    </th>
                    <th>
                        <a href="?sort=email&order=<?= $sortField === 'email' 
                            ? ($sortOrder === 'asc' ? 'desc' : 'asc') 
                            : $sortOrder ?>&p=<?= $currentPage ?>"
                        >Email
                            <?php if ($sortField === 'email') : ?>
                                <i class="fa fa-caret-<?= $sortOrder === 'asc' ? 'up' : 'down' ?>"></i>
                            <?php endif ?>
                        </a>
                    </th>
                    <th><span class="table-header-nowrap">Текст задачи</span></th>
                    
                    <!-- Add a column with a mark of admin edit only if the table has such items
                    to make columns of the table more balanced by width. -->
                    <?php if ($tableHasAdminEditMark): ?><th></th><?php endif ?>
                    
                    <th>
                        <!-- Because of status cyrillic labels "Выполнено" and "Не выполнено" 
                        are represented as 1 and 0 respectively in the database, sorting 
                        1 > 0 ==> "Выполнено" > "Не выполнено" is not true for strings.
                        So just inverse this field's visual sorting: visually represent
                        ascend sorting as descend and vice versa. -->
                        <a href="?sort=status&order=<?= $sortOrder === 'asc' 
                            ? 'desc' : 'asc' ?>&p=<?= $currentPage ?>"
                        >Статус
                            <?php if ($sortField === 'status') : ?>
                                <i class="fa fa-caret-<?= $sortOrder === 'asc' ? 'down' : 'up' ?>"></i>
                            <?php endif ?>
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item) : ?>
                    <tr data-item-id="<?= $item['todo_id'] ?>">
                        <td class="align-middle"><?= $item['username'] ?></td>
                        <td class="align-middle"><?= $item['email'] ?></td>
                        <td class="align-middle">
                            <span class="todo-item-text"><?= $item['text'] ?></span>
                            <?php if ($isAdmin) : ?>
                                <a href="#" class="todo-item-text-edit"><i class="fa fa-pencil"></i></a>
                            <?php endif ?>
                        </td>
                        <?php if ($tableHasAdminEditMark): ?>
                            <td class="align-middle">
                                <span class="admin-edit-place">
                                    <?php if ($item['admin_edit']) : ?>
                                        <span class="badge badge-secondary">Отредактировано администратором</span>
                                    <?php endif ?>
                                </span>
                            </td>
                        <?php endif ?>
                        <td class="align-middle">
                            <div class="form-check form-check-inline">
                                <?php if ($isAdmin) : ?>
                                    <input class="form-check-input todo-status-checkbox" type="checkbox" <?= $item['status'] ? 'checked' : '' ?>>
                                <?php endif ?>
                                <?php if ($item['status']) : ?>
                                    <span class="form-check-label badge badge-success">Выполнено</span>
                                <?php else : ?>
                                    <span class="form-check-label badge badge-light">Не выполнено</span>
                                <?php endif ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

        <div id="todo-tbody"></div>

        <h4>Добавить задачу</h4>
        <?php if (in_array(TodoItemModel::ERROR_ALL_OK, $errors)) : ?>
            <div class="alert alert-success" role="alert">Задача успешно добавлена</div>
        <?php else : ?>
            <?php if (in_array(TodoItemModel::ERROR_USERNAME_EMPTY, $errors)) : ?>
                <div class="alert alert-danger" role="alert">Имя пользователя не введено</div>
            <?php endif ?>
            <?php if (in_array(TodoItemModel::ERROR_EMAIL_EMPTY, $errors)) : ?>
                <div class="alert alert-danger" role="alert">Email не введен</div>
            <?php endif ?>
            <?php if (in_array(TodoItemModel::ERROR_EMAIL_INVALID, $errors)) : ?>
                <div class="alert alert-danger" role="alert">Email введен некорректно</div>
            <?php endif ?>
            <?php if (in_array(TodoItemModel::ERROR_TEXT_EMPTY, $errors)) : ?>
                <div class="alert alert-danger" role="alert">Текст не введен</div>
            <?php endif ?>
        <?php endif ?>

        <form action="/item/add" method="post">
            <div class="form-row align-items-center">
                <div class="col-2">
                    <input type="text" name="username" class="form-control mb-2" placeholder="Имя пользователя">
                </div>
                <div class="col-2">
                    <input type="text" name="email" class="form-control mb-2" placeholder="Email">
                </div>
                <div class="col-md">
                    <input type="text" name="text" class="form-control mb-2" placeholder="Текст задачи">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-2">Добавить</button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <?php if ($isAdmin) : ?><script src="/table.js"></script><?php endif ?>
</body>

</html>