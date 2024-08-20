<?php
include 'db.php';

$emailError = $passwordError = $loginError = '';
$email = $password = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validation des entrées
    if (empty($email)) {
        $emailError = 'Veuillez entrer votre email.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = 'Email invalide.';
    }

    if (empty($password)) {
        $passwordError = 'Veuillez entrer votre mot de passe.';
    }

    // Vérification des erreurs et connexion à la base de données
    if (empty($emailError) && empty($passwordError)) {
        $stmt = $conn->prepare('SELECT id, password FROM users WHERE email = ?');
        if ($stmt) {
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if (password_verify($password, $row['password'])) {
                    // Connexion réussie
                    session_start();
                    $_SESSION['user_id'] = $row['id'];
                    header('Location: /stage/acceuil.php'); // Redirection après connexion réussie
                    exit();
                } else {
                    $loginError = 'Mot de passe incorrect.';
                }
            } else {
                $loginError = 'Aucun utilisateur trouvé avec cet email.';
            }
        } else {
            $loginError = 'Erreur de préparation de la requête.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
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
                <i class="icon-envelope">&#9993;</i>
            </div>
            <div class="input-group">
                <label for="password"><?php echo $passwordError; ?></label>
                <input type="password" name="password" id="password" placeholder="Mot de passe">
                <i class="icon-eye" onclick="togglePasswordVisibility()">
                    &#128065; <!-- Œil ouvert par défaut -->
                </i>
            </div>
            <?php if ($loginError): ?>
                <div class="error"><?php echo $loginError; ?></div>
            <?php endif; ?>
            <button type="submit" class="button">Connexion</button>
            <a href="forgot_password.php" class="link">Mot de passe oublié ?</a>
            <a href="register.php" class="link">Créer un compte</a>
        </form>
    </div>

    <script>
        function togglePasswordVisibility() {
            var passwordField = document.getElementById('password');
            var icon = document.querySelector('.icon-eye');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.innerHTML = '&#128065;'; // Œil ouvert
            } else {
                passwordField.type = 'password';
                icon.innerHTML = '&#128586;'; // Œil fermé
            }
        }
    </script>
</body>
</html>
