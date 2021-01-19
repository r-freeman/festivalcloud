<?php
require_once '../../classes/Festival.php';

try {
    $festivals = Festival::all();
}
catch (Exception $ex) {
    die($ex->getMessage());
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <?php require '../../utils/styles.php'; ?>
        <?php require '../../utils/scripts.php'; ?>
    </head>
    <body>
      <?php require '../../utils/toolbar.php'; ?>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php require '../../utils/header.php'; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h2>Festivals <a href="create.php" class="btn btn-primary pull-right">Add</a></h2>
                    <?php if (count($festivals) == 0) { ?>
                        <p>There are no festivals</p>
                    <?php } else { ?>
                        <table id="table-festivals" class="table table-hover">
                            <thead>
                                <th>Title</th>
                                <th>City</th>
                                <th>Start</th>
                                <th>End</th>
                            </thead>
                            <tbody>
                                <?php foreach ($festivals as $festival) { ?>
                                    <tr data-id="<?= $festival->id ?>">
                                        <td><a href="show.php?id=<?= $festival->id ?>" class="btn-link"><?= $festival->title ?></a></td>
                                        <td><?= $festival->city ?></td>
                                        <td><?= $festival->start_date ?></td>
                                        <td><?= $festival->end_date ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php require '../../utils/footer.php'; ?>
                </div>
            </div>
        </div>
    </body>
</html>
