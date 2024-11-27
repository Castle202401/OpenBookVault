<?php
session_start(); // 启动会话，保存用户信息

// 数据库配置
$servername = "xxxxxxx"; // 数据库 IP
$username = "xxxxxxxxxxxxxxx";
$password = "xxxxxxxxx";
$dbname = "xxxxxxxxxxxx";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 处理注册请求
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];  // 姓名
    $username = $_POST['name'];  // 将姓名作为用户名
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 密码加密
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // 检查邮箱是否已注册
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "该邮箱已注册，请选择其他邮箱。";
    } else {
        // 默认角色是普通用户，假设 role_id 为 1
        $role_id = 1; // 1 代表普通用户

        // 插入新用户数据
        $sql = "INSERT INTO users (username, name, email, password, role_id) VALUES ('$username', '$name', '$email', '$hashed_password', '$role_id')";
        if ($conn->query($sql) === TRUE) {
            echo "注册成功";
            // 注册成功后跳转到登录页面
            header("Location: login.html");
            exit();
        } else {
            echo "错误: " . $conn->error;
        }
    }
}

$conn->close();
?>
