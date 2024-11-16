<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

$usuario_nome = $_SESSION['usuario_nome'];
$usuario_nivel = $_SESSION['usuario_nivel'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h2>Bem-vindo, <?php echo htmlspecialchars($usuario_nome); ?>!</h2>
    <p>Nível de acesso: <?php echo htmlspecialchars($usuario_nivel); ?></p>

    <a href="logout.php">Sair</a>
</body>
</html>