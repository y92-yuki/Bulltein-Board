<?php
const DSN = 'mysql:host=localhost;dbname=board';
const USER = 'root';
const PASSWORD = 'root';
$succses = null;
$rows = array();
$error = array();

try {
    $pdo = new PDO(DSN,USER,PASSWORD);
} catch (PDOException $e){
    echo $e->getMessage();
}

if (isset($_POST['message_send'])) {
    if (empty($_POST['name'])) {
        $error[] = '名前を入力してください';
    }
    
    if (empty($_POST['message'])) {
        $error[] = 'コメントを入力してください';
    }
    if (empty($error)) {
        $stmt = $pdo->prepare("INSERT INTO content(name, message) VALUES(:name, :message)");
        $stmt->bindValue('name', $_POST['name'],PDO::PARAM_STR);
        $stmt->bindValue('message', $_POST['message'],PDO::PARAM_STR);
        $stmt->execute();
    
        $succses = 'コメントを投稿しました';
    }
}


if ($stmt = $pdo->prepare("SELECT * FROM content ORDER BY id DESC")) {
    $stmt->execute();
    while($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $row[] = $rows;
    }
}
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
        color: red;
    }
</style>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <title>掲示板</title>
    </head>
    <body>
        <?php if (isset($succses)) {
            echo $succses;
        } ?>
        <ul>
            <?php if (isset($error)): ?>
                <?php foreach ($error as $value): ?>
                    <li><span><?= $value ?></span></li>
                <?php endforeach ?>
            <?php endif ?>
        </ul>
        <h1>ひと言掲示板</h1>
        <form action="board.php" method="post">
            <div>
                名前<br> 
                <input type="text" name="name"> 
            </div>
            <div>
                コメント<br>
                <textarea name="message" rows="5" cols="40"></textarea>
            </div>
            <button type="submit" name="message_send">投稿する</button>
        </form>
        <?php if (isset($row)): ?>
            <p class="index">投稿内容</p>
            <?php foreach ($row as $value): ?>
                <div class="content">
                    名前： <?= $value['name'] ?> 投稿時間: <?= $value['post_date'] ?><br>
                    投稿内容<br>
                    <?= nl2br($value['message']) ?>
                </div>
                <br>
            <?php endforeach ?>
        <?php endif ?>
    </body>
</html>