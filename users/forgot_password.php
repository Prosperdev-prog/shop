<?php
include 'db.php';

$emailError = $forgotError = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    if (empty($email)) {
        $emailError = 'Veuillez entrer votre email.';
    } else {
        $stmt = $conn->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Générer un code de vérification aléatoire
            $verificationCode = rand(100000, 999999);

            // Définir l'heure d'expiration (par exemple, 1 heure à partir de maintenant)
            $expiration = date('Y-m-d H:i:s', strtotime('+1 hour'));

            // Mettre à jour l'utilisateur avec le code de vérification et la date d'expiration
            $updateStmt = $conn->prepare('UPDATE users SET verification_code = ?, verification_expiration = ? WHERE email = ?');
            $updateStmt->bind_param('sss', $verificationCode, $expiration, $email);
            $updateStmt->execute();

            // Préparer le message email
            $subject = 'Code de Vérification';
            $message = "Votre code de vérification est : {$verificationCode}";
            $headers = "From: votre_email@example.com\r\n" .
                       "Reply-To: votre_email@example.com\r\n" .
                       "X-Mailer: PHP/" . phpversion();

            // Envoyer l'email
            if (mail($email, $subject, $message, $headers)) {
                $forgotError = 'Un email avec les instructions de vérification a été envoyé.';
            } else {
                $forgotError = "L'envoi de l'email a échoué.";
            }
        } else {
            $forgotError = 'Aucun utilisateur trouvé avec cet email.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oubli de mot de passe</title>
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
            <?php if ($forgotError): ?>
                <div class="error"><?php echo $forgotError; ?></div>
            <?php endif; ?>
            <button type="submit" class="button">Envoyer</button>
            <a href="login.php" class="link">Retour à la connexion</a>
        </form>
    </div>
</body>
</html>
