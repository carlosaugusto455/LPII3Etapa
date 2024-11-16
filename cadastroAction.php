<?php
session_start();
require_once 'conexao.php';

if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $nivel = 'usu';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['erro'] = 'Email inválido.';
        header('Location: cadstro.php');
        exit;
    }

    $sql = "SELECT * FROM usuarios WHERE email = :email OR username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email, 'username' => $username]);
    if ($stmt->fetch(PDO::FETCH_ASSOC)) {
        $_SESSION['erro'] = 'Este Email ou Nome de Usuário já está cadastrado.';
        header('Location: cadastro.php');
        exit;
    }

    $senha_hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (username, email, senha, nivel) VALUES (:username, :email, :senha, :nivel)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'username' => $username,
        'email' => $email,
        'senha' => $senha_hash,
        'nivel' => $nivel
    ]);

    $_SESSION['sucesso'] = 'Cadastro realizado com sucesso! Você pode fazer login agora.';
    header('Location: index.php');
    exit;
} else {
    $_SESSION['erro'] = 'Por favor, preencha todos os campos.';
    header('Location: cadastro.php');
    exit;
}
?>
