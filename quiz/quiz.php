<?php
session_start();

// Session-Check
if (!isset($_SESSION['user_name'])) {
    header('Location: pages/start.php');
    exit();
}

// Versuche verwalten
if (!isset($_SESSION['quiz_attempts'])) {
    $_SESSION['quiz_attempts'] = 0;
}

// Maximale Versuche prüfen
if ($_SESSION['quiz_attempts'] >= 3) {
    $error_message = "Sie haben bereits 3 Versuche absolviert. Bitte starten Sie das Modul neu.";
} elseif (isset($_SESSION['quiz_completed']) && $_SESSION['quiz_completed']) {
    header('Location: result.php');
    exit();
}

$name = $_SESSION['user_name'];
$date = date('d.m.Y');
$time = date('H:i:s');

if (!isset($_SESSION['fragen']) && !isset($error_message)) {
    // Fragen aus JSON laden
    $fragen_json = file_get_contents("fragenpool_komplett.json");
    $alle_fragen = json_decode($fragen_json, true);
    
    if (!$alle_fragen) {
        $error_message = "Fehler beim Laden der Fragen. Bitte versuchen Sie es später erneut.";
    } else {
        // Trennen nach Typ
        $mc_fragen = array_filter($alle_fragen, fn($f) => $f['typ'] === 'mc');
        $tf_fragen = array_filter($alle_fragen, fn($f) => $f['typ'] === 'tf');
        
        // Zufällig auswählen
        shuffle($mc_fragen);
        shuffle($tf_fragen);
        $auswahl = array_merge(array_slice($mc_fragen, 0, 3), array_slice($tf_fragen, 0, 2));
        
        // Mischen & speichern
        shuffle($auswahl);
        $_SESSION['fragen'] = array_values($auswahl);
    }
}

// Fragen aus Session holen
$fragen = $_SESSION['fragen'] ?? [];
$score = 0;
$feedback = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($error_message)) {
    $_SESSION['quiz_attempts']++;
    $current_attempt = $_SESSION['quiz_attempts'];
    
    $antworten = [];
    
    foreach ($fragen as $index => $frage) {
        $userAntwort = $_POST['frage_' . $index] ?? '';
        $antworten[] = $userAntwort;
        $richtig = $frage['richtig'];
        
        if ($frage['typ'] === 'tf') {
            if (($richtig === true && $userAntwort === "true") || 
                ($richtig === false && $userAntwort === "false")) {
                $score++;
            }
        } elseif ($frage['typ'] === 'mc') {
            if ($userAntwort === $richtig) {
                $score++;
            }
        }
    }
    
    // Logging - Datenverzeichnis erstellen falls nicht vorhanden
    @mkdir("data", 0777, true);
    
    // Detailliertes Logging
    $log_entry = sprintf(
        "%s,%s,%s,%d,%d,%d,%s\n",
        $name,
        $date,
        $time,
        $current_attempt,
        $score,
        count($fragen),
        implode(';', $antworten)
    );
    file_put_contents("data/quiz_log.csv", $log_entry, FILE_APPEND | LOCK_EX);
    
    if ($score === 5) {
        // Erfolgreicher Abschluss
        $success_entry = sprintf("%s,%s,%s,%d\n", $name, $date, $time, $current_attempt);
        file_put_contents("data/teilnehmer.csv", $success_entry, FILE_APPEND | LOCK_EX);
        
        $_SESSION['quiz_completed'] = true;
        $_SESSION['final_score'] = $score;
        unset($_SESSION['fragen']);
        
        header("Location: result.php");
        exit();
    } else {
        // Nicht bestanden
        $feedback = sprintf(
            "Sie haben %d von 5 Fragen richtig beantwortet. Für das Zertifikat benötigen Sie die volle Punktzahl.",
            $score
        );
        
        if ($current_attempt < 3) {
            $feedback .= sprintf(" Sie haben noch %d Versuch(e).", 3 - $current_attempt);
            unset($_SESSION['fragen']); // Neue Fragen beim nächsten Versuch
        } else {
            $feedback .= " Sie haben alle 3 Versuche aufgebraucht.";
            $error_message = "Alle Versuche aufgebraucht. Bitte starten Sie das Modul neu.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz - Inflation verstehen</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="header-content">
                <h1>🏦 Inflation verstehen</h1>
                <div class="quiz-info">
                    <span class="user-name">👤 <?php echo htmlspecialchars($name); ?></span>
                    <span class="attempts">🎯 Versuch <?php echo ($_SESSION['quiz_attempts'] + 1); ?> von 3</span>
                </div>
            </div>
        </header>

        <main class="main-content">
            <div class="content-card">
                <div class="page-header">
                    <div class="icon">🎯</div>
                    <h2>Quiz: Testen Sie Ihr Wissen!</h2>
                </div>

                <?php if (isset($error_message)): ?>
                    <div class="error-box">
                        <h3>⚠️ Keine weiteren Versuche möglich</h3>
                        <p><?php echo htmlspecialchars($error_message); ?></p>
                        <div class="navigation">
                            <a href="pages/start.php" class="btn btn-primary">
                                Modul neu starten
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <?php if (!empty($feedback)): ?>
                        <div class="feedback-box <?php echo $score === 5 ? 'success' : 'warning'; ?>">
                            <p><?php echo htmlspecialchars($feedback); ?></p>
                        </div>
                    <?php endif; ?>

                    <div class="quiz-instructions">
                        <p>
                            <strong>Anleitung:</strong> Beantworten Sie alle 5 Fragen. 
                            Für das Zertifikat benötigen Sie die volle Punktzahl (5/5).
                        </p>
                    </div>

                    <form method="post" class="quiz-form">
                        <?php foreach ($fragen as $index => $frage): ?>
                            <div class="question-container">
                                <div class="question-header">
                                    <span class="question-number">Frage <?php echo ($index + 1); ?></span>
                                    <span class="question-type"><?php echo $frage['typ'] === 'mc' ? 'Multiple Choice' : 'Richtig/Falsch'; ?></span>
                                </div>
                                
                                <p class="question-text">
                                    <strong><?php echo htmlspecialchars($frage['frage']); ?></strong>
                                </p>
                                
                                <div class="options-container">
                                    <?php if ($frage['typ'] === 'mc'): ?>
                                        <?php foreach ($frage['optionen'] as $option): ?>
                                            <label class="option-label">
                                                <input 
                                                    type="radio" 
                                                    name="frage_<?php echo $index; ?>" 
                                                    value="<?php echo htmlspecialchars($option); ?>" 
                                                    required
                                                >
                                                <span class="option-text"><?php echo htmlspecialchars($option); ?></span>
                                            </label>
                                        <?php endforeach; ?>
                                    <?php elseif ($frage['typ'] === 'tf'): ?>
                                        <label class="option-label">
                                            <input 
                                                type="radio" 
                                                name="frage_<?php echo $index; ?>" 
                                                value="true" 
                                                required
                                            >
                                            <span class="option-text">✅ Richtig</span>
                                        </label>
                                        <label class="option-label">
                                            <input 
                                                type="radio" 
                                                name="frage_<?php echo $index; ?>" 
                                                value="false" 
                                                required
                                            >
                                            <span class="option-text">❌ Falsch</span>
                                        </label>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <div class="quiz-submit">
                            <button type="submit" class="btn btn-primary btn-large">
                                Antworten prüfen 📋
                            </button>
                        </div>
                    </form>

                    <div class="navigation">
                        <a href="pages/page5.php" class="btn btn-secondary">
                            ← Zurück zu den Inhalten
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </main>

        <button id="back-to-top" class="back-to-top">↑</button>

        <footer class="footer">
            <p>&copy; 2025 TheRealTeacher.de - Interaktives Lernmodul - Inflation</p>
        </footer>
    </div>

    <script src="assets/js/script.js"></script>
</body>
</html>