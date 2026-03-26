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
    <title>Was tut der Staat dagegen? - Lernmodul</title>
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
                    <span class="progress-text" id="progress-text">Seite 4 von 5</span>
                </div>
            </div>
        </header>

        <main class="main-content">
            <div class="content-card">
                <div class="page-header">
                    <div class="icon">🏛️</div>
                    <h2>Was tut der Staat dagegen?</h2>
                </div>

                <div class="content-text">
                    <p class="lead">
                        Um die Inflation in den Griff zu bekommen, arbeiten verschiedene 
                        Institutionen zusammen. Ihre wichtigsten Werkzeuge sind die Geld- 
                        und Finanzpolitik.
                    </p>

                    <div class="institutions-grid">
                        <div class="institution-item">
                            <div class="institution-header">
                                <div class="institution-icon">🇪🇺</div>
                                <h3>Europäische Zentralbank (EZB)</h3>
                            </div>
                            <div class="institution-content">
                                <h4>Das mächtigste Werkzeug:</h4>
                                <p>
                                    Sie kann den <strong>Leitzins erhöhen</strong>. Dadurch wird es für 
                                    Banken teurer, sich Geld zu leihen. Kredite werden teurer, Sparen 
                                    wird attraktiver, die Nachfrage sinkt.
                                </p>
                                <div class="process">
                                    Zinsen ↑ → Kredite teurer → weniger Konsum → Preise stabilisieren sich
                                </div>
                            </div>
                        </div>

                        <div class="institution-item">
                            <div class="institution-header">
                                <div class="institution-icon">🏛️</div>
                                <h3>Regierung (Bund & Länder)</h3>
                            </div>
                            <div class="institution-content">
                                <h4>Finanzpolitische Maßnahmen:</h4>
                                <ul>
                                    <li>Steuern anpassen (z.B. Mehrwertsteuer senken)</li>
                                    <li>Preise deckeln (z.B. bei Energie)</li>
                                    <li>Bürger entlasten (z.B. Energiepauschale)</li>
                                    <li>Transferleistungen erhöhen</li>
                                </ul>
                            </div>
                        </div>

                        <div class="institution-item">
                            <div class="institution-header">
                                <div class="institution-icon">🇩🇪</div>
                                <h3>Deutsche Bundesbank</h3>
                            </div>
                            <div class="institution-content">
                                <h4>Der "Wächter" der Preisstabilität:</h4>
                                <p>
                                    Als Teil des EZB-Systems beobachtet sie die deutsche Preisentwicklung, 
                                    analysiert die Daten und berät die Politik. Sie ist der Experte für 
                                    die deutsche Wirtschaft.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="example-box">
                        <h3>🎯 Das Inflationsziel</h3>
                        <p>
                            Die EZB hat ein klares Ziel: Die Inflation soll bei etwa <strong>2% pro Jahr</strong> 
                            liegen. Das ist gesund für die Wirtschaft – nicht zu hoch, nicht zu niedrig.
                        </p>
                    </div>

                    <div class="info-box">
                        <h3>⚖️ Warum nicht einfach Preise verbieten?</h3>
                        <p>
                            In der <strong>sozialen Marktwirtschaft</strong> bestimmt normalerweise der 
                            Markt die Preise. Der Staat greift nur ein, wenn es zu Marktversagen oder 
                            übermäßiger Inflation kommt. Komplette Preiskontrollen können zu Engpässen 
                            und Schwarzmärkten führen.
                        </p>
                    </div>
                </div>

                <div class="navigation">
                    <a href="page3.php" class="btn btn-secondary">
                        ← Zurück
                    </a>
                    <a href="page5.php" class="btn btn-primary">
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
