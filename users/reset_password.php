<?php
include 'db.php';

$tokenError = $passwordError = $confirmPasswordError = $resetError = '';
$password = $confirmPassword = '';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
} else {
    die('Jeton manquant.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);

    if (empty($password)) {
        $passwordError = 'Veuillez entrer un nouveau mot de passe.';
    }

    if ($password !== $confirmPassword) {
        $confirmPasswordError = 'Les mots de passe ne correspondent pas.';
    }

    if (empty($passwordError) && empty($confirmPasswordError)) {
        $stmt = $conn->prepare('SELECT email FROM password_resets WHERE token = ?');
        $stmt->bind_param('s', $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $email = $row['email'];

            // Utilisation de password_hash() pour sécuriser le mot de passe
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $stmt = $conn->prepare('UPDATE users SET password = ? WHERE email = ?');
            $stmt->bind_param('ss', $hashedPassword, $email);

            if ($stmt->execute()) {
                $stmt = $conn->prepare('DELETE FROM password_resets WHERE token = ?');
                $stmt->bind_param('s', $token);
                $stmt->execute();

                header('Location: login.php');
                exit();
            } else {
                $resetError = 'Erreur lors de la réinitialisation du mot de passe.';
            }
        } else {
            $resetError = 'Jeton de réinitialisation invalide.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser le mot de passe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 300px;
        }
        .input-group {
            margin-bottom: 15px;
            position: relative;
        }
        .input-group label {
            display: block;
            margin-bottom: 5px;
            color: red;
        }
        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .input-group i {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            font-size: 18px;
            color: #aaa;
            cursor: pointer;
        }
        .error {
            color: red;
            font-size: 12px;
            margin-bottom: 5px;
        }
        .button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="post">
            <div class="input-group">
                <label for="password"><?php echo $passwordError; ?></label>
                <input type="password" name="password" id="password" placeholder="Nouveau mot de passe">
                <i class="icon-eye" onclick="togglePasswordVisibility('password')">&#128065;</i>
            </div>
            <div class="input-group">
                <label for="confirm_password"><?php echo $confirmPasswordError; ?></label>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirmer le mot de passe">
                <i class="icon-eye" onclick="togglePasswordVisibility('confirm_password')">&#128065;</i>
            </div>
            <?php if ($resetError): ?>
                <div class="error"><?php echo $resetError; ?></div>
            <?php endif; ?>
            <button type="submit" class="button">Réinitialiser le mot de passe</button>
        </form>
    </div>

    <script>
        function togglePasswordVisibility(id) {
            var passwordField = document.getElementById(id);
            var icon = document.querySelector('#' + id + ' ~ i');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.innerHTML = '&#128065;'; // Changer l'icône pour l'œil ouvert
            } else {
                passwordField.type = 'password';
                icon.innerHTML = '&#128586;'; // Changer l'icône pour l'œil fermé
            }
        }
    </script>
</body>
</html>
