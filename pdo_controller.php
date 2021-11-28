<?php
class Content {
    const DSN = 'mysql:host=localhost;dbname=board';
    const USER = 'root';
    const PASSWORD = 'root';

    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO(self::DSN,self::USER,self::PASSWORD);
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }

    public function index_select() {
        if ($stmt = $this->pdo->prepare("SELECT id, message, post_date FROM content ORDER BY id DESC")) {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function detail_select() {
        $stmt = $this->pdo->prepare("SELECT * FROM content WHERE id = :id");
        $stmt->bindValue('id', $_GET['id'],PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function comment_controller($send) {
        if (isset($send)) {
            if (empty($_POST['name'])) {
                $name_error = '名前を入力してください';
            }
            
            if (empty($_POST['message'])) {
                $comment_error = 'コメントを入力してください';
            }

            if (!empty($name_error || $comment_error)) {
                $errors = [$name_error, $comment_error]; 
                return array_filter($errors);       
            }elseif (!empty($name_error)) {
                return $comment_error;
            }elseif (!empty($comment_error)) {
                return $name_error;
            }
        }
    }        
    
    public function insert() {
        $stmt = $this->pdo->prepare("INSERT INTO content(name, message) VALUES(:name, :message)");
        $stmt->bindValue('name', $_POST['name'],PDO::PARAM_STR);
        $stmt->bindValue('message', $_POST['message'],PDO::PARAM_STR);
        $stmt->execute();
        return 'コメントを投稿しました';
    }

    public function comment_modify() {
        $stmt = $this->pdo->prepare("UPDATE content SET message = :modify_message WHERE id = :modify_id");
        $stmt->bindValue('modify_message', $_POST['modify_message'],PDO::PARAM_STR);
        $stmt->bindValue('modify_id', $_POST['modify_id'],PDO::PARAM_INT);;
        $stmt->execute();
        return 'コメントを編集しました';
    }
    
}
$board = new Content();
?>