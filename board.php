<?php
require_once('pdo_controller.php');
$rows = [];



if (isset($_POST['confirm_send'])) {
    $success = $board->insert();
}

if (isset($_POST['execute_modify'])) {
    $success = $board->comment_modify();
}

$rows = $board->index_select();

?>
<style>
    .content {
        margin: 0px 10px;
        padding: 10px;
        background-color: beige;
        border: 1px solid #ccc;
    }

    .index {
        text-align: center;
        font-size: 20px;
    }

    span {
        color: green;
    }

    .btn {
        text-align: right;
    }

</style>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <title>掲示板</title>
    </head>
    <body>
        <span><?php if (isset($success)) {
            echo $success;
        } ?></span>
        <h1>ひと言掲示板</h1>
        <button type="button" onclick="location.href='post.php'">投稿画面へ</button>
        <?php if (isset($rows)): ?>
            <p class="index">投稿内容</p>
            <?php foreach ($rows as $row): ?>
                <div class="content">
                    <form action="post_detail.php" method="get">
                        <?= $row['message'] ?> <?= $row['post_date'] ?> 
                        <div class="btn"><button type="submit" name="id" value="<?= $row['id'] ?>">投稿詳細</button></div>
                    </form>
                </div>
                <br>
            <?php endforeach ?>
        <?php endif ?>
    </body>
</html>