<?php
session_start();

// Session-Check
if (!isset($_SESSION['user_name'])) {
    header('Location: start.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Was ist Inflation? - Lernmodul</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="header-content">
                <h1>🏦 Inflation verstehen</h1>
                <div class="progress-container">
                    <div class="progress-bar">
                        <div class="progress-fill" id="progress-fill"></div>
                    </div>
                    <span class="progress-text" id="progress-text">Seite 1 von 5</span>
                </div>
            </div>
        </header>

        <main class="main-content">
            <div class="content-card">
                <div class="page-header">
                    <div class="icon">📈</div>
                    <h2>Was ist Inflation?</h2>
                </div>

                <div class="content-text">
                    <p class="lead">
                        Inflation bedeutet, dass die Preise für Waren und Dienstleistungen über einen 
                        längeren Zeitraum steigen. Das bedeutet, dass wir für das gleiche Geld weniger 
                        kaufen können als früher.
                    </p>

                    <div class="example-box">
                        <h3>🥙 Der Döner-Effekt</h3>
                        <div class="price-comparison">
                            <div class="price-item">
                                <div class="price-label">Früher</div>
                                <div class="price-value old-price">5,00 €</div>
                            </div>
                            <div class="arrow">→</div>
                            <div class="price-item">
                                <div class="price-label">Heute</div>
                                <div class="price-value new-price">7,00 €</div>
                            </div>
                        </div>
                        <p>
                            Für Jugendliche zeigt sich das zum Beispiel, wenn der Döner plötzlich 
                            7 Euro statt 5 Euro kostet oder ein Kinoticket deutlich teurer wird.
                        </p>
                    </div>

                    <div class="info-box">
                        <h3>💰 Was bedeutet das für mein Geld?</h3>
                        <p>
                            Wenn die Preise steigen, verliert dein Geld an <strong>Kaufkraft</strong>. 
                            Das heißt: Mit dem gleichen Betrag kannst du dir weniger leisten als früher. 
                            Dein Geld wird praktisch "weniger wert".
                        </p>
                    </div>

                    <div class="key-points">
                        <h3>📋 Wichtige Punkte:</h3>
                        <ul>
                            <li>Inflation = steigende Preise über längere Zeit</li>
                            <li>Geld verliert an Kaufkraft</li>
                            <li>Betrifft alle: vom Döner bis zum Kinoticket</li>
                            <li>Besonders spürbar bei begrenztem Budget</li>
                        </ul>
                    </div>
                </div>

                <div class="navigation">
                    <a href="start.php" class="btn btn-secondary">
                        ← Zurück
                    </a>
                    <a href="page2.php" class="btn btn-primary">
                        Weiter →
                    </a>
                </div>
            </div>
        </main>

        <button id="back-to-top" class="back-to-top">↑</button>

        <footer class="footer">
            <p>&copy; 2025 TheRealTeacher.de - Interaktives Lernmodul - Inflation</p>
        </footer>
    </div>

    <script src="../assets/js/script.js"></script>
</body>
</html>
