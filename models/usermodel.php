<?php
class UserModel {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function login($username, $password) {
        $sql = "SELECT * FROM users 
                WHERE username = :username 
                AND password = crypt(:password, password)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'username' => $username,
            'password' => $password
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
