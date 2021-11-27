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

    public function select() {
        if ($stmt = $this->pdo->prepare("SELECT * FROM content ORDER BY id DESC")) {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function comment_controller() {
        if (isset($_POST['message_send'])) {
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
    
}
$board = new Content();
?>