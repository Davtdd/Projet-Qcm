<?php
session_start();

// Connexion base de données
$id = mysqli_connect("localhost", "root", "", "qcm");

// Vérification de la connexion
if (isset($_POST['qcm'])) {
    $userId = $_SESSION['idu'];
    // $qcmId = $_POST['qcm'];
    header("Location: qcm.php");


}

// Gestion déconnexion
if (isset($_POST['logout'])) {
    $userId = $_SESSION['idu'];
    
    // Fermer uniquement la dernière session active
    $query = "UPDATE log 
              SET datefin = NOW() 
              WHERE idu = $userId 
              AND datefin IS NULL 
              ORDER BY datedeb DESC 
              LIMIT 1"; 
    
     mysqli_query($id, $query);
    
     session_destroy();
     header("Location: connexion.php");
     exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Page d'accueil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            background-image: url('R.jpg');
        }
        .button {
            padding: 10px 20px;
            margin: 10px;
            cursor: pointer;
        }
        .red { background: red; color: white; }
        form{
            display: flex;
            justify-content: center;
            position: absolute;
            top: 25%;
            left: 40%;
        }
        h1{
            text-align: center;
            margin-top: 20px;
            color: black;
            font-size: 72px;
            color: royalblue;
        }
    </style>
</head>
<body>
    <h1>Bienvenue</h1>
    
    <form method="post">
        <button name="qcm">Accéder au QCM</button>
        <button name="logout" class="button red">Déconnexion</button>
    </form>
</body>
</html>

<?php
mysqli_close($id);
?>