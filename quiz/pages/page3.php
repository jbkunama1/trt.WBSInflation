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
    <title>Wer ist betroffen? - Lernmodul</title>
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
                    <span class="progress-text" id="progress-text">Seite 3 von 5</span>
                </div>
            </div>
        </header>

        <main class="main-content">
            <div class="content-card">
                <div class="page-header">
                    <div class="icon">👥</div>
                    <h2>Wer ist von Inflation betroffen?</h2>
                </div>

                <div class="content-text">
                    <p class="lead">
                        Die Auswirkungen der Inflation sind vielfältig und treffen verschiedene 
                        Gruppen auf unterschiedliche Weise. Besonders spürbar ist sie für Menschen 
                        mit begrenztem Budget.
                    </p>

                    <div class="affected-groups">
                        <div class="group-item">
                            <div class="group-icon">🎓</div>
                            <h3>Jugendliche & Schüler</h3>
                            <ul>
                                <li>Taschengeld reicht nicht mehr so weit</li>
                                <li>Kinokarten, Döner, Getränke werden teurer</li>
                                <li>Sparen für größere Wünsche dauert länger</li>
                                <li>Eltern müssen mehr auf das Haushaltsbudget achten</li>
                            </ul>
                        </div>

                        <div class="group-item">
                            <div class="group-icon">💰</div>
                            <h3>Sparer</h3>
                            <ul>
                                <li>Ersparnisse verlieren an Wert</li>
                                <li>Zinsen sind oft niedriger als Inflation</li>
                                <li>Langfristige Sparziele werden schwerer erreichbar</li>
                            </ul>
                        </div>

                        <div class="group-item">
                            <div class="group-icon">👨‍💼</div>
                            <h3>Arbeitnehmer</h3>
                            <ul>
                                <li>Lohn kauft weniger, wenn er nicht steigt</li>
                                <li>Besonders betroffen: feste Verträge ohne Anpassung</li>
                                <li>Geringverdiener spüren es am stärksten</li>
                            </ul>
                        </div>

                        <div class="group-item">
                            <div class="group-icon">👪</div>
                            <h3>Familien</h3>
                            <ul>
                                <li>Lebensmittel werden teurer</li>
                                <li>Energie- und Mietkosten steigen</li>
                                <li>Weniger Geld für Freizeitaktivitäten</li>
                            </ul>
                        </div>
                    </div>

                    <div class="example-box">
                        <h3>📉 Der schwindende Wert des Ersparten</h3>
                        <p>
                            Inflation "frisst" das Ersparte auf. Bei 5% Inflation sind 100€ nach 
                            einem Jahr real nur noch 95€ wert. Das bedeutet: Wer nicht investiert 
                            oder höhere Zinsen bekommt, verliert Geld.
                        </p>
                        <div class="value-decline">
                            <span class="value-item">100€ heute</span>
                            <span class="arrow">→</span>
                            <span class="value-item decline">95€ Kaufkraft (nach 1 Jahr)</span>
                        </div>
                    </div>

                    <div class="info-box">
                        <h3>💡 Warum trifft es manche härter?</h3>
                        <p>
                            Menschen mit wenig Geld geben einen größeren Teil ihres Einkommens für 
                            Grundbedürfnisse (Essen, Wohnen) aus. Wenn gerade diese Preise steigen, 
                            bleibt weniger für alles andere übrig.
                        </p>
                    </div>
                </div>

                <div class="navigation">
                    <a href="page2.php" class="btn btn-secondary">
                        ← Zurück
                    </a>
                    <a href="page4.php" class="btn btn-primary">
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
