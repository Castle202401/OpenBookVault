<?php
session_start(); // 启动会话，保存用户信息

// 数据库配置
$servername = "23.91.96.62"; // 数据库 IP
$username = "bysj";
$password = "BEhLA7ZyEDbNTzrP";
$dbname = "bysj";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 处理登录请求
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 检查用户是否存在
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // 验证密码
        if (password_verify($password, $user['password'])) {
            // 登录成功，设置会话信息
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role_id']; // 假设您在数据库中有 role_id 字段来区分角色

            // 重定向到后台页面
            header("Location: ../");
            exit();
        } else {
            echo "密码错误";
        }
    } else {
        echo "该邮箱未注册";
    }
}

$conn->close();
?>
