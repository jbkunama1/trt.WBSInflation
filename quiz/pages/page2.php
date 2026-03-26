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
    <title>Ursachen von Inflation - Lernmodul</title>
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
                    <span class="progress-text" id="progress-text">Seite 2 von 5</span>
                </div>
            </div>
        </header>

        <main class="main-content">
            <div class="content-card">
                <div class="page-header">
                    <div class="icon">🔍</div>
                    <h2>Warum steigen die Preise?</h2>
                </div>

                <div class="content-text">
                    <p class="lead">
                        Inflation hat nicht nur eine einzige Ursache. Meist ist es ein Zusammenspiel 
                        aus verschiedenen Faktoren, die die Preise in die Höhe treiben.
                    </p>

                    <div class="causes-grid">
                        <div class="cause-item">
                            <div class="cause-icon">🛒💨</div>
                            <h3>Nachfrage-Inflation</h3>
                            <p>
                                Wenn alle mehr von einem Produkt wollen, das Angebot aber knapp ist, 
                                steigt der Preis. Wie beim Hype um die neuesten Sneaker oder 
                                Konzertkarten.
                            </p>
                            <div class="example">
                                <strong>Beispiel:</strong> Alle wollen das neue iPhone, aber es gibt zu wenige.
                            </div>
                        </div>

                        <div class="cause-item">
                            <div class="cause-icon">⛽🚛</div>
                            <h3>Angebots-Inflation</h3>
                            <p>
                                Wenn die Herstellung teurer wird (z.B. durch höhere Energiekosten), 
                                müssen Unternehmen die Preise anheben, um profitabel zu bleiben.
                            </p>
                            <div class="example">
                                <strong>Beispiel:</strong> Benzin wird teurer → Transport wird teurer → 
                                alle Produkte werden teurer.
                            </div>
                        </div>

                        <div class="cause-item">
                            <div class="cause-icon">💸🖨</div>
                            <h3>Geldmengen-Inflation</h3>
                            <p>
                                Wenn zu viel Geld im Umlauf ist, aber die Menge der Güter gleich bleibt, 
                                verliert das Geld an Wert. Jeder Euro ist weniger "wert".
                            </p>
                            <div class="example">
                                <strong>Beispiel:</strong> Die Zentralbank druckt viel Geld → 
                                Mehr Geld für die gleichen Produkte → Preise steigen.
                            </div>
                        </div>
                    </div>

                    <div class="info-box">
                        <h3>🌍 Aktuelle Beispiele</h3>
                        <p>
                            In den letzten Jahren haben wir alle drei Arten erlebt: Corona führte zu 
                            Lieferengpässen (Angebotsinflation), der Krieg in der Ukraine verteuerte 
                            Energie (Angebotsinflation), und niedrige Zinsen brachten viel Geld in 
                            Umlauf (Geldmengen-Inflation).
                        </p>
                    </div>
                </div>

                <div class="navigation">
                    <a href="page1.php" class="btn btn-secondary">
                        ← Zurück
                    </a>
                    <a href="page3.php" class="btn btn-primary">
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
