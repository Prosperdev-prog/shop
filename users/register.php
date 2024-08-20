<?php
include 'db.php';

$emailError = $passwordError = $confirmPasswordError = $registerError = '';
$email = $password = $confirmPassword = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);

    // Validation des entrées
    if (empty($email)) {
        $emailError = 'Veuillez entrer votre email.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = 'Email invalide.';
    }

    if (empty($password)) {
        $passwordError = 'Veuillez entrer votre mot de passe.';
    }

    if (empty($confirmPassword)) {
        $confirmPasswordError = 'Veuillez confirmer votre mot de passe.';
    } elseif ($password !== $confirmPassword) {
        $confirmPasswordError = 'Les mots de passe ne correspondent pas.';
    }

    // Vérification des erreurs et insertion dans la base de données
    if (empty($emailError) && empty($passwordError) && empty($confirmPasswordError)) {
        // Hachage du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare('INSERT INTO users (email, password) VALUES (?, ?)');
        if ($stmt) {
            $stmt->bind_param('ss', $email, $hashedPassword);
            if ($stmt->execute()) {
                header('Location: login.php'); // Redirection après inscription réussie
                exit();
            } else {
                $registerError = 'Erreur lors de l\'inscription. Veuillez réessayer.';
            }
        } else {
            $registerError = 'Erreur de préparation de la requête.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
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
        .link {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }
        .link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="post">
            <div class="input-group">
                <label for="email"><?php echo $emailError; ?></label>
                <input type="email" name="email" id="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>">
            </div>
            <div class="input-group">
                <label for="password"><?php echo $passwordError; ?></label>
                <input type="password" name="password" id="password" placeholder="Mot de passe">
            </div>
            <div class="input-group">
                <label for="confirm_password"><?php echo $confirmPasswordError; ?></label>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirmez le mot de passe">
            </div>
            <?php if ($registerError): ?>
                <div class="error"><?php echo $registerError; ?></div>
            <?php endif; ?>
            <button type="submit" class="button">Inscription</button>
            <a href="login.php" class="link">Déjà un compte ? Connectez-vous</a>
        </form>
    </div>
</body>
</html>
