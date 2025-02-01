<?php
if (isset($_POST['bout'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $mail = $_POST['mail'];
    $mdp = $_POST['mdp'];
    $id = mysqli_connect("localhost", "root", "", "qcm");
    $req = "SELECT * FROM user where mail = '$mail'";
    $resul = mysqli_query($id, $req);
    if (mysqli_num_rows($resul) != 0) {
        echo " Desoler le Mail : $mail existe deja dans la base de donnée";
        exit();
        
    }else {
        $req = "INSERT INTO user (nom, prenom, mail, mdp) VALUES ('$nom', '$prenom', '$mail', '$mdp')";
        $resul = mysqli_query($id, $req);
        // echo "Inscription reussie, vous allez etre redirigé pour vous connecter";
        header("refresh:3;url=connexion.php");

        
    }
    // $resul = mysqli_query($id, $req);
    echo "Inscription reussie, vous allez etre redirigé pour vous connecter";
    header("refresh:3;url=connexion.php");
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
body{
    font-family: 'Roboto', sans-serif;
    background-color: #f7eded;
    background-image: url('OIP.jpg');

}
h1{
    text-align: center;
    margin-top: 20px;
    color: black;
    font-size: 72px;
} 
form{
    width: 50%;
    margin: 0 auto;
    padding: 20px;
    background-color:rgb(20, 19, 19);
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    color: white;
    position: absolute;
    top: 25%;
    left: 25%;
    opacity: 0.7;
}
label{
    display: block;
    margin: 10px 0;
    font-size: auto;
}
.bout{
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: none;
    border-radius: 5px;
    background-color: #007bff;
    color:rgb(190, 179, 179);
    cursor: pointer;
}
a{
                text-decoration: none;
                color: white;
                background-color:rgb(15, 99, 184);
                padding: 10px 20px;
                margin: 10px;
                border-radius: 5px;
                position: absolute;
                top: 80%;
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
    <h1>Formulaire d'inscrription</h1> <hr>
    <form action="" method="post">
        <label for="nom">Nom</label>
        <input type="text" name="nom" placeholder="Entrez votre nom" required> <br>
        <label for="prenom">Prenom</label>
        <input type="text" name="prenom" placeholder="prenom" required> <br>
        <label for="email">Email</label>
        <input type="email" name="mail" placeholder="email" required> <br>
        <label for="password">Mot de passe</label>
        <input type="password" name="mdp" placeholder="password" required> <br>
        <!-- <label for="password2">Confirmer mot de passe</label>
        <input type="password" name="password2" placeholder="passwor" required> <br> -->
        <!-- <button type="submit">S'inscrire</button> -->
        <input class="bout" type="submit" value="S'inscrire" name="bout"> 
    </form>
    <a href="connexion.php" target="_blank" rel="noopener noreferrer">Vous avez deja un compte? Cliquez ici pour vous connecter</a>
</body>
</html>