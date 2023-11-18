<?php
session_start();

require_once('config/db_connect.php');

if (!isset($_SESSION['username']) && !isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $birthday = $_POST['birthday'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];

    $update_query = "UPDATE users SET `name` = '$name', birthday = '$birthday', email = '$email', phone = '$phone', gender = '$gender' WHERE id = $user_id";

    $errors = [];

    if (empty($name)) {
        $errors[] = "Họ và tên không được để trống.";
    }

    if (empty($email)) {
        $errors[] = "Email không được để trống.";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email không hợp lệ.";
    }

    if (empty($phone)) {
        $error[] = "Số điện thoại không được để trống.";
    } else if (!preg_match('/^\d{8,}$/', $phone)) {
        $errors[] = "Số điện thoại không hợp lệ.";
    }

    $datePattern = '/^\d{4}-\d{2}-\d{2}$/';
    if (!preg_match($datePattern, $birthday)) {
        $errors[] = "Ngày sinh không hợp lệ.";
    }

    if (!empty($errors)) {
        $msg = implode('<br>', $errors);
        $error = 1;
        header("Location: user_info.php?msg=" . urlencode($msg) . "&error=" . $error);
        exit();
    }

    try {
        if ($conn->query($update_query) === TRUE) {
            $msg = "Cập nhật thông tin thành công.";
            $error = 0;
        }
    } catch (Exception $e) {
        $msg = "An error occurred: " . $e->getMessage();
        $error = 1;
    }

    header("Location: user_info.php?msg=" . urlencode($msg) . "&error=" . $error);
}

$conn->close();
?>
