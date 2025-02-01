<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            margin: 0;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f7f7f7;
            background-image: url('jeux.jpg');
            background-size: cover;
            background-position: center;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            font-size: 48px;
            color: royalblue;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        form {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-top: 20px;
            margin-bottom: 10px;
            font-size: 24px;
            color: #333;
        }

        .question {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .question label {
            display: block;
            margin: 10px 0;
            font-size: 18px;
            color: #555;
        }

        .question input[type="radio"] {
            margin-right: 10px;
        }

        input[type="submit"] {
            display: block;
            width: 100%;
            padding: 15px;
            margin-top: 20px;
            background-color: royalblue;
            color: white;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #4169e1;
        }

        input[type="submit"]:active {
            background-color: #1e3c72;
        }
    </style>
</head>
<body>
    <h1>Bienvenue sur mon QCM</h1>
    <form action="resultat.php" method="post">
    <?php
    $i = 1;
    $id = mysqli_connect("localhost", "root", "", "qcm");
    $req = "SELECT * FROM questions ORDER BY RAND() LIMIT 10";
    $resul = mysqli_query($id, $req);
    while ($ligne = mysqli_fetch_assoc($resul)) {
        echo "<input type='hidden' name='idq[]' value='" . $ligne['idq'] . "'>"; // Champ caché pour l'ID de la question
        echo "<h2>Question N$i : " . $ligne['libelleQ'] . "</h2>";
        $req2 = "SELECT * FROM reponses WHERE idq = " . $ligne['idq'];
        $resul2 = mysqli_query($id, $req2);
        while ($ligne2 = mysqli_fetch_assoc($resul2)) {
            $idr = $ligne2['idr'];
            echo "<input type='radio' name='q$i' value='$idr'>" . $ligne2['libeller'] . "<br>";
        }
        $i++;
    }
    ?>
    <input type="submit" value="Envoyer">
    </form>
</body>
</html>