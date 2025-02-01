<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['idu'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: connexion.php");
    exit();
}

// Connexion à la base de données
$conn = mysqli_connect("localhost", "root", "", "qcm");

// Vérification de la connexion
if (!$conn) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

// Recherche des logs avec jointure sur la table user
$results = [];
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $query = "SELECT log.*, user.mail 
              FROM log 
              INNER JOIN user ON log.idu = user.idu 
              WHERE user.mail LIKE '%$search%'
              ORDER BY log.datedeb DESC";
} else {
    $query = "SELECT log.*, user.mail 
              FROM log 
              INNER JOIN user ON log.idu = user.idu 
              ORDER BY log.datedeb DESC";
}

$results = mysqli_query($conn, $query);


if (isset($_POST['qcm'])) {
    $userId = $_SESSION['idu'];
    // $qcmId = $_POST['qcm'];
    header("Location: qcm.php");


}

if (isset($_POST['logout'])) {
    // Récupération de l'ID utilisateur depuis la session
    $userId = $_SESSION['idu'];

    // Vérifier que $userId est valide
    if (!empty($userId)) {
        // Fermer uniquement la dernière session active
        $query = "UPDATE log 
                  SET datefin = NOW() 
                  WHERE idu = $userId 
                  AND datefin IS NULL 
                  ORDER BY datedeb DESC 
                  LIMIT 1";

        // Exécution de la requête
        if (mysqli_query($conn, $query)) {
            // Déconnexion réussie, détruire la session et rediriger
            session_destroy();
            header("Location: connexion.php");
            exit();
        } 
        // else {
        //     // Gestion des erreurs
        //     die("Erreur lors de la mise à jour de la date de fin de connexion : " . mysqli_error($conn));
        // }
    } 
    // else {
    //     die("ID utilisateur non valide.");
    // }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Journal des connexions</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .search-box { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .ongoing { color: #4CAF50; font-weight: bold; }
        h1 { 
            margin-bottom: 20px; 
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            text-align: center;
        }
        form { margin-bottom: 20px; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
        }
    </style>
</head>
<body>
    <h1>Historique des connexions</h1>
    
    <div class="search-box">
        <form method="GET">
            <input type="text" name="search" placeholder="Rechercher par mail..." 
                   value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
            <button type="submit">Rechercher</button>
        </form>
    </div>

    <?php if ($results && mysqli_num_rows($results) > 0): ?>
    <table>
        <tr>
            <th>Email</th>
            <th>Connexion</th>
            <th>Déconnexion</th>
            <th>Durée</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($results)): 
            $start = strtotime($row['datedeb']);
            $end = $row['datefin'] ? strtotime($row['datefin']) : time();
            $duration = $end - $start;
        ?>
        <tr>
            <td><?= htmlspecialchars($row['mail']) ?></td>
            <td><?= date('d/m/Y H:i', $start) ?></td>
            <td>
                <?= $row['datefin'] 
                    ? date('d/m/Y H:i', strtotime($row['datefin'])) 
                    : '<span class="ongoing">En cours</span>' ?>
            </td>
            <td>
                <?= $duration > 60 
                    ? gmdate("H\h i\m", $duration) 
                    : gmdate("i\m s\s", $duration) ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php else: ?>
    <p>Aucune activité trouvée.</p>
    <?php endif; ?>
    <form method="post">
        <button name="qcm">Accéder au QCM</button>
        <button name="logout" class="button red">Déconnexion</button>
    </form>
</body>
</html>

<?php
mysqli_close($conn);
?>
