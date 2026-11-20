<?php
class Client{
    public function updatePassword($userEmail, $oldPassword, $newPassword) {
        try {
            $query1 = "SELECT UserPassword_hash FROM user WHERE UserEmail = ?";
            $stmt1 = $this->conn->prepare($query1);
            $stmt1->execute([$userEmail]);
            $user = $stmt1->fetch(PDO::FETCH_ASSOC);

            
            if ($user && password_verify($oldPassword, $user['UserPassword_hash'])) {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $query2 = "UPDATE user SET UserPassword_hash = ? WHERE UserEmail = ?";
                $stmt2 = $this->conn->prepare($query2);
                $stmt2->execute([$hashedPassword, $userEmail]);
                return true;
            }
            return false;
        } catch (PDOException $e) {
            throw $e;
        }
    }
}

?>