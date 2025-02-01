<?php
// Connexion à la base de données
$id = mysqli_connect("localhost", "root", "", "qcm");
if (!$id) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

// Traitement de la déconnexion
if (isset($_POST['deconnexion'])) {
    session_start();
    if (isset($_SESSION['idu'])) {
        $userId = $_SESSION['idu'];
        
        // Mettre à jour la date de fin de connexion dans la table log
        $update_query = "UPDATE log 
                         SET datefin = NOW() 
                         WHERE idu = $userId 
                         AND datefin IS NULL 
                         ORDER BY datedeb DESC 
                         LIMIT 1"; // Met à jour uniquement la dernière session active
        
        if (mysqli_query($id, $update_query)) {
            // Déconnexion réussie, détruire la session et rediriger
            session_destroy();
            header("Location: connexion.php");
            exit();
        } else {
            die("Erreur lors de la mise à jour de la date de fin de connexion : " . mysqli_error($id));
        }
    }
}

// Récupération des IDs des questions (uniquement si le formulaire de questions est soumis)
if (isset($_POST['idq']) && is_array($_POST['idq'])) {
    $idq_list = $_POST['idq'];
    $total_questions = count($idq_list);
    $score = 0;
    $results = [];

    foreach ($idq_list as $index => $idq) {
        $question_num = $index + 1;
        $user_answer = $_POST["q$question_num"] ?? null;

        // Récupérer la question
        $question_query = "SELECT libelleQ FROM questions WHERE idq = $idq";
        $question_result = mysqli_query($id, $question_query);
        if (!$question_result) {
            die("Erreur lors de la récupération de la question : " . mysqli_error($id));
        }
        $question = mysqli_fetch_assoc($question_result)['libelleQ'];

        // Récupérer la réponse correcte (où veriter = 1)
        $correct_query = "SELECT idr, libeller FROM reponses WHERE idq = $idq AND verite = 1";
        $correct_result = mysqli_query($id, $correct_query);
        if (!$correct_result) {
            die("Erreur lors de la récupération de la réponse correcte : " . mysqli_error($id));
        }
        $correct_row = mysqli_fetch_assoc($correct_result);
        $correct_id = $correct_row['idr'];
        $correct_answer = $correct_row['libeller'];

        // Récupérer la réponse de l'utilisateur
        $user_answer_text = "Non répondue";
        if ($user_answer) {
            $user_query = "SELECT libeller FROM reponses WHERE idr = $user_answer";
            $user_result = mysqli_query($id, $user_query);
            if (!$user_result) {
                die("Erreur lors de la récupération de la réponse de l'utilisateur : " . mysqli_error($id));
            }
            $user_row = mysqli_fetch_assoc($user_result);
            $user_answer_text = $user_row['libeller'] ?? "Invalide";
        }

        // Vérifier si la réponse est correcte
        $is_correct = ($user_answer == $correct_id);
        if ($is_correct) {
            $score++;
        }

        // Stocker les résultats
        $results[] = [
            'question' => $question,
            'user_answer' => $user_answer_text,
            'correct_answer' => $correct_answer,
            'is_correct' => $is_correct
        ];
    }

    // Calcul de la note sur 20
    $note = ($score / $total_questions) * 20;
} else {
    // Si aucune question n'est soumise, initialiser des valeurs par défaut
    $results = [];
    $note = 0;
}

// Récupérer la dernière date de connexion de l'utilisateur
session_start();
if (isset($_SESSION['idu'])) {
    $userId = $_SESSION['idu'];
    $last_login_query = "SELECT datedeb FROM log WHERE idu = $userId ORDER BY datedeb DESC LIMIT 1";
    $last_login_result = mysqli_query($id, $last_login_query);
    if ($last_login_result && mysqli_num_rows($last_login_result) > 0) {
        $last_login_row = mysqli_fetch_assoc($last_login_result);
        $last_login_date = $last_login_row['datedeb'];
    } else {
        $last_login_date = "Aucune date de connexion trouvée.";
    }
} else {
    $last_login_date = "Utilisateur non connecté.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Résultats</title>
    <style>
        .correct { color: green; }
        .incorrect { color: red; }
        .deconnexion-btn {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #f44336;
            color: white;
            border: none;
            cursor: pointer;
        }
        .deconnexion-btn:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <h1>Votre résultat</h1>
    <?php if (!empty($results)): ?>
        <h2>Note : <?= number_format($note, 2) ?> / 20</h2>
        <?php foreach ($results as $index => $result): ?>
            <div style="margin-bottom: 20px;">
                <h3>Question <?= $index + 1 ?> : <?= htmlspecialchars($result['question']) ?></h3>
                <p>Votre réponse : <?= htmlspecialchars($result['user_answer']) ?></p>
                <?php if ($result['is_correct']): ?>
                    <p class="correct">Correct !</p>
                <?php else: ?>
                    <p class="incorrect">Incorrect. Réponse correcte : <?= htmlspecialchars($result['correct_answer']) ?></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Afficher la dernière date de connexion -->
    <p>Dernière date de connexion : <?= htmlspecialchars($last_login_date) ?></p>

    <!-- Bouton de déconnexion -->
    <form method="post" action="">
        <button type="submit" name="deconnexion" class="deconnexion-btn">Déconnexion</button>
    </form>
</body>
</html>
<?php mysqli_close($id); ?>