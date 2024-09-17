<?php
include 'conexao.php';
$mensagem_erro = '';
$mensagem_sucesso = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        header("Location: bemvindo.php");
    } else {
        $mensagem_erro = "Erro ao criar conta. Talvez o email já esteja em uso.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php if ($mensagem_erro): ?>
        <p style="color:red;"><?php echo $mensagem_erro; ?></p>
    <?php endif; ?>

    <?php if ($mensagem_sucesso): ?>
        <p style="color:green;"><?php echo $mensagem_sucesso; ?></p>
    <?php endif; ?>

    <form action="registo.php" method="POST">
        <h2>Criar conta</h2>
        <label for="name">Nome:</label><br>
        <input type="text" name="name" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Registrar</button>
        
    </form>
    <a href="login.php"><button>Login</button></a>
</body>
</html>
