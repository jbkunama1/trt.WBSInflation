<?php
session_start();

// Verarbeitung der Formulareingabe
if ($_POST && isset($_POST['name']) && !empty(trim($_POST['name']))) {
    $_SESSION['user_name'] = trim($_POST['name']);
    $_SESSION['quiz_attempts'] = 0;
    $_SESSION['quiz_completed'] = false;
    $_SESSION['start_time'] = date('Y-m-d H:i:s');
    header('Location: page1.php');
    exit();
}

// Fehlerbehandlung
$error = '';
if ($_POST && (!isset($_POST['name']) || empty(trim($_POST['name'])))) {
    $error = 'Bitte geben Sie Ihren Namen ein.';
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inflation verstehen - Interaktives Lernmodul</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="header-content">
                <h1>🏦 Inflation verstehen</h1>
                <p class="subtitle">Ein interaktives Lernmodul</p>
            </div>
        </header>

        <main class="main-content">
            <div class="content-card">
                <div class="icon-large">📊</div>
                <h2>__________________Willkommen!__________________</h2>
                <p class="intro-text">
                    Alles wird teurer – aber warum? Lerne in diesem interaktiven Modul 
                    alles über Inflation: Was sie bedeutet, wie sie entsteht und was Du 
                    dagegen tun kannst.
                </p>
                
                <div class="module-overview">
                    <h3>Das erwartet Dich:</h3>
                    <ul>
                        <li>📖 5 informative Lernseiten</li>
                        <li>🎯 Quiz mit 5 Fragen</li>
                        <li>🏆 Persönliches Zertifikat</li>
                        <li>⏱️ Dauer: ca. 10-15 Minuten</li>
                    </ul>
                </div>

                <form method="POST" class="name-form">
                    <div class="form-group">
                        <label for="name">Dein Name für das Zertifikat:</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            placeholder="Max Mustermann"
                            value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>"
                            required
                        >
                        <?php if ($error): ?>
                            <div class="error"><?php echo $error; ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        Los geht's! 🚀
                    </button>
                </form>

                <div class="info-box">
                    <p><strong>Hinweis:</strong> Du hast 3 Versuche für das Quiz. 
                    Nur bei voller Punktzahl erhälst du das Zertifikat.</p>
                </div>
            </div>
        </main>

        <footer class="footer">
		  <a href="https://inflation.realteacher.de/admin.php" class="btn btn-outline" target="_blank">
                        👨‍🏫 Lehreransicht
                    </a>
            <p>&copy; 2025 TheRealTeacher.de - Interaktives Lernmodul - "Inflation verstehen"</p>
        </footer>
    </div>

    <script src="../assets/js/script.js"></script>
</body>
</html>
