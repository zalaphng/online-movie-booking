<?php
session_start();

require_once('config/db_connect.php');

if (!isset($_SESSION['username']) && !isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];

    $user_id = $_SESSION['user_id'];
    $query = "SELECT password FROM users WHERE id = $user_id";
    $result = $conn->query($query);
    $userData = $result->fetch_assoc();

    if ($userData && password_verify($currentPassword, $userData['password'])) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $updateQuery = "UPDATE users SET password = '$hashedPassword' WHERE id = $user_id";
        if ($conn->query($updateQuery) === TRUE) {
            echo "Mật khẩu đã được cập nhật.";
        } else {
            echo "Có lỗi xảy ra khi cập nhật mật khẩu mới: " . $conn->error;
        }
    } else {
        echo "Mật khẩu cũ không chính xác.";
    }
}
?>
