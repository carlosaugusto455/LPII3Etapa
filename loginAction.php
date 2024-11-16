<?php
session_start();
require_once 'conexao.php';

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $senha = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    $hash = $usuario['senha'];

    if ($usuario && password_verify($senha, $hash)) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['username'];
        $_SESSION['usuario_email'] = $usuario['email'];
        $_SESSION['usuario_nivel'] = $usuario['nivel'];

        header('Location: home.php');
        exit;
    } else {
        $_SESSION['erro'] = 'Email ou senha inválidos!';
        header('Location: index.php');
        exit;
    }
} else {
    $_SESSION['erro'] = 'Por favor, preencha todos os campos!';
    header('Location: index.php');
    exit;
}
?>
