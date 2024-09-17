<?php
session_start();
$mensagem_erro = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conexao.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        $utilizador = $resultado->fetch_assoc();
        
        if (password_verify($password, $utilizador['password'])) {
            $_SESSION['utilizador'] = $utilizador['name'];
            header("Location: bemvindo.php");
            exit;
        } else {
            $mensagem_erro = "password incorreta!";
        }
    } else {
        $mensagem_erro = "Utilizador não encontrado!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php if ($mensagem_erro): ?>
        <p style="color:red;"><?php echo $mensagem_erro; ?></p>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <h2>Login</h2>
        <label for="email">Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label for="password">password:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Entrar</button>
    </form>
    <a href="registo.php"><button>Criar conta</button></a>
</body>
</html>
