<?php
session_start(); // Ajout essentiel pour les sessions

function log_connection_attempt($mail, $success) {
    $status = $success ? "réussie" : "échec";
    $logMessage = date('Y-m-d H:i:s') . " - Tentative de connexion $status pour l'utilisateur $mail" . PHP_EOL;
    file_put_contents('connexion.log', $logMessage, FILE_APPEND);
}

if (isset($_POST['bout'])) {
    $mail = $_POST['mail'];
    $mdp = $_POST['mdp'];
    log_connection_attempt($mail, false);

    $id = mysqli_connect("localhost", "root", "", "qcm");
    $req = "SELECT * FROM user WHERE mail = '$mail' AND mdp = '$mdp'";
    $resul = mysqli_query($id, $req);
    
    if (mysqli_num_rows($resul) > 0) {
        // Récupération de l'utilisateur
        $user = mysqli_fetch_assoc($resul);
        $userId = $user['idu'];
        $role = $user['role']; // Récupération du rôle de l'utilisateur
        
        // Stockage de l'ID en session
        $_SESSION['idu'] = $userId; // Ajout crucial pour accueil.php
        
        // Insertion dans le log
        $req = "INSERT INTO log (idu, datedeb) VALUES ($userId, NOW())";
        mysqli_query($id, $req);
        
        // Log de confirmation
        file_put_contents(
            'connexion.log', 
            date('Y-m-d H:i:s') . " - Début de session pour l'utilisateur $mail" . PHP_EOL, 
            FILE_APPEND // Correction ici pour l'accumulation des logs
        );
        
        // header("Location: accueil.php");
        // exit();
        // Vérification du rôle de l'utilisateur
        if ($role == 2) {
            // Si le rôle est 2, rediriger vers journal.php
            header("Location: journal.php");
            exit();
        } else {
            // Sinon, rediriger vers accueil.php
            header("Location: accueil.php");
            exit();
        }
    } else {
        $erreur = "Mail ou mot de passe incorrect";
        file_put_contents(
            'connexion.log', 
            date('Y-m-d H:i:s') . " - Echec de connexion pour l'utilisateur $mail" . PHP_EOL, 
            FILE_APPEND
        );
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        * { 
            margin: 0; padding: 0; box-sizing: border-box;
         }
        body { 
            font-family: Arial, sans-serif; margin: 20px;
            background-color: #f7eded;
            background-image: url('netzwerk-total-001.jpg');
        }
        h1 { 
            text-align: center; margin-top: 20px;
            color: #f7eded;
            
        }
        form { 
            width: 50%; margin: 0 auto; padding: 50px;
            background-color:rgb(19, 18, 18); border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1); color: white;
            text-align: center;
            opacity: 0.7;
            position: absolute;
            top: 25%;
            left: 25%;
        }
        input{
            margin: 10px;
        }
        label { 
            display: block; margin: 2px 0; font-size: auto;
        }
        a{
                text-decoration: none;
                color: white;
                background-color:rgb(15, 99, 184);
                padding: 10px 20px;
                margin: 10px;
                border-radius: 5px;
                position: absolute;
                top: 70%;
                left: 25%;
                width: 50%;
                text-align: center;
            }
            a:hover{
                background-color: #0056b3;
            }

    </style>
</head>
<body>
    <h1>Formulaire de connexion</h1><hr>
    <form action="" method="post">
        <label for="email">Email</label>
        <input type="email" name="mail" required><br>
        
        <label for="password">Mot de passe</label>
        <input type="password" name="mdp" required><br>

        <?php if (isset($erreur)) echo "<p>$erreur</p>"; ?>
        
        <input type="submit" value="Connexion" name="bout">
    </form>
    <a href="inscription.php" target="_blank" rel="noopener noreferrer">Vous n'avez pas de compte? Cliquez ici pour vous inscrire</a>
</body>
</html>