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
    <title>Zusammenfassung - Lernmodul</title>
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
                    <span class="progress-text" id="progress-text">Seite 5 von 5</span>
                </div>
            </div>
        </header>

        <main class="main-content">
            <div class="content-card">
                <div class="page-header">
                    <div class="icon">📚</div>
                    <h2>Wissen ist Macht (über dein Geld)</h2>
                </div>

                <div class="content-text">
                    <p class="lead">
                        Inflation ist ein komplexes Thema, aber die Grundlagen zu verstehen, 
                        hilft dir, klügere finanzielle Entscheidungen zu treffen.
                    </p>

                    <div class="summary-grid">
                        <div class="summary-item">
                            <div class="summary-icon">📈</div>
                            <h3>Was ist Inflation?</h3>
                            <p>Steigende Preise über längere Zeit → Geld verliert an Kaufkraft</p>
                        </div>

                        <div class="summary-item">
                            <div class="summary-icon">🔍</div>
                            <h3>Drei Hauptursachen</h3>
                            <p>Nachfrage-, Angebots- und Geldmengen-Inflation wirken oft zusammen</p>
                        </div>

                        <div class="summary-item">
                            <div class="summary-icon">👥</div>
                            <h3>Wer ist betroffen?</h3>
                            <p>Alle, aber besonders Menschen mit wenig Geld und festen Einkommen</p>
                        </div>

                        <div class="summary-item">
                            <div class="summary-icon">🏛️</div>
                            <h3>Was tut der Staat?</h3>
                            <p>EZB, Regierung und Bundesbank arbeiten mit verschiedenen Werkzeugen</p>
                        </div>
                    </div>

                    <div class="key-takeaways">
                        <h3>🎯 Die wichtigsten Erkenntnisse</h3>
                        <ul>
                            <li><strong>Inflation betrifft uns alle</strong> – auch Jugendliche merken es im Alltag</li>
                            <li><strong>Verstehen hilft</strong> – wer die Zusammenhänge kennt, kann besser planen</li>
                            <li><strong>Der Staat hat Werkzeuge</strong> – aber sie brauchen Zeit zum Wirken</li>
                            <li><strong>Bewusster Umgang mit Geld</strong> wird immer wichtiger</li>
                        </ul>
                    </div>

                    <div class="personal-relevance">
                        <h3>💡 Was bedeutet das für mich?</h3>
                        <div class="relevance-content">
                            <p>
                                Als Jugendlicher kannst du lernen, bewusst mit Geld umzugehen und 
                                wirtschaftliche Zusammenhänge zu verstehen. Das hilft dir heute beim 
                                Haushalten und in Zukunft bei größeren finanziellen Entscheidungen.
                            </p>
                            <div class="tips">
                                <h4>Praktische Tipps:</h4>
                                <ul>
                                    <li>💰 Preise vergleichen und bewusst einkaufen</li>
                                    <li>📊 Wirtschaftsnews verfolgen und verstehen</li>
                                    <li>💡 Über Sparen und Investieren informieren</li>
                                    <li>🤝 Mit Familie über Haushaltsbudget sprechen</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="conclusion-box">
                        <h3>🎓 Fazit</h3>
                        <p>
                            Wer informiert ist, kann klügere Entscheidungen treffen – heute und in 
                            der Zukunft. Inflation ist kein abstraktes Thema, sondern betrifft unser 
                            tägliches Leben. Das Verständnis dafür ist der erste Schritt zu einem 
                            bewussten Umgang mit Geld.
                        </p>
                    </div>
                </div>

                <div class="navigation">
                    <a href="page4.php" class="btn btn-secondary">
                        ← Zurück
                    </a>
                    <a href="../quiz.php" class="btn btn-primary btn-quiz">
                        Quiz starten! 🎯
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
