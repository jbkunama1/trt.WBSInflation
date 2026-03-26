<?php
session_start();

// Session-Check
if (!isset($_SESSION['user_name']) || !isset($_SESSION['quiz_completed']) || !$_SESSION['quiz_completed']) {
    header('Location: pages/start.php');
    exit();
}

$name = $_SESSION['user_name'];
$date = date('d.m.Y');
$time = date('H:i');
$attempts = $_SESSION['quiz_attempts'] ?? 1;
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zertifikat - Inflation verstehen</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="header-content">
                <h1>🏦 Inflation verstehen</h1>
                <div class="success-indicator">
                    <span class="success-badge">✅ Erfolgreich abgeschlossen!</span>
                </div>
            </div>
        </header>

        <main class="main-content">
            <div class="content-card certificate-card">
                <div class="certificate-header">
                    <div class="certificate-icon">🏆</div>
                    <h2>Herzlichen Glückwunsch!</h2>
                    <p class="certificate-subtitle">Sie haben das Lernmodul erfolgreich abgeschlossen</p>
                </div>

                <div class="certificate-container">
                    <div class="certificate" id="certificate">
                        <div class="certificate-border">
                            <div class="certificate-content">
                                <div class="certificate-logo">🎓</div>
                                
                                <h3 class="certificate-title">Zertifikat</h3>
                                <p class="certificate-subtitle">Interaktives Lernmodul</p>
                                
                                <h4 class="certificate-topic">Inflation verstehen</h4>
                                
                                <div class="certificate-text">
                                    <p>Hiermit wird bestätigt, dass</p>
                                    <div class="certificate-name"><?php echo htmlspecialchars($name); ?></div>
                                    <p>das Lernmodul "Inflation verstehen" erfolgreich absolviert hat.</p>
                                </div>
                                
                                <div class="certificate-details">
                                    <div class="certificate-row">
                                        <span class="label">Datum:</span>
                                        <span class="value"><?php echo $date; ?></span>
                                    </div>
                                    <div class="certificate-row">
                                        <span class="label">Uhrzeit:</span>
                                        <span class="value"><?php echo $time; ?></span>
                                    </div>
                                    <div class="certificate-row">
                                        <span class="label">Ergebnis:</span>
                                        <span class="value">5 von 5 Punkten</span>
                                    </div>
                                    <div class="certificate-row">
                                        <span class="label">Versuche:</span>
                                        <span class="value"><?php echo $attempts; ?> von 3</span>
                                    </div>
                                </div>
                                
                                <div class="certificate-signature">
                                    <div class="signature-line">
                                        <span>Interaktives Lernmodul</span>
                                        <span>Inflation verstehen</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="achievement-summary">
                    <h3>🎯 Was Sie gelernt haben:</h3>
                    <div class="learning-objectives">
                        <div class="objective-item">
                            <span class="objective-icon">📈</span>
                            <span>Was Inflation ist und wie sie entsteht</span>
                        </div>
                        <div class="objective-item">
                            <span class="objective-icon">🔍</span>
                            <span>Die verschiedenen Ursachen von Inflation</span>
                        </div>
                        <div class="objective-item">
                            <span class="objective-icon">👥</span>
                            <span>Wer von Inflation betroffen ist</span>
                        </div>
                        <div class="objective-item">
                            <span class="objective-icon">🏛️</span>
                            <span>Welche Maßnahmen der Staat ergreift</span>
                        </div>
                        <div class="objective-item">
                            <span class="objective-icon">💡</span>
                            <span>Wie Sie bewusst mit Geld umgehen können</span>
                        </div>
                    </div>
                </div>

                <div class="certificate-actions">
                    <button onclick="printCertificate()" class="btn btn-secondary">
                        🖨️ Zertifikat drucken
                    </button>
                    <button onclick="downloadCertificate()" class="btn btn-secondary">
                        📄 Als PDF speichern
                    </button>
                </div>

                <div class="next-steps">
                    <h3>🚀 Wie geht es weiter?</h3>
                    <p>Vertiefen Sie Ihr Wissen mit unserem interaktiven Spiel!</p>
                    
                    <div class="game-preview">
                        <div class="game-icon">🎮</div>
                        <div class="game-info">
                            <h4>Inflations-Simulator</h4>
                            <p>Übernehmen Sie die Rolle der Zentralbank und steuern Sie die Inflation in verschiedenen Szenarien.</p>
                        </div>
                    </div>
                    
                    <a href="#game-placeholder" class="btn btn-primary btn-large">
                        Zum Spiel! 🎯
                    </a>
                </div>

                <div class="final-message">
                    <div class="message-icon">💫</div>
                    <h3>Vielen Dank für Deine Teilnahme!</h3>
                    <p>
                        Du hast gezeigt, dass Du die Grundlagen der Inflation verstehen kannst. 
                        Nutzen dieses Wissen, um bewusste finanzielle Entscheidungen zu treffen.
                    </p>
                </div>

                <div class="navigation">
                    <a href="pages/start.php" class="btn btn-secondary">
                        🔄 Modul neu starten
                    </a>

                </div>
            </div>
        </main>

        <footer class="footer">
            <p>&copy; 2025 TheRealTeacher.de - Interaktives Lernmodul - "Inflation verstehen"</p>
        </footer>
    </div>

    <script src="assets/js/script.js"></script>
    <script>
        function printCertificate() {
            const certificate = document.getElementById('certificate');
            const printWindow = window.open('', '_blank');
            
            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Zertifikat - ${<?php echo json_encode($name); ?>}</title>
                    <link rel="stylesheet" href="assets/style.css">
                    <style>
                        @media print {
                            body { margin: 0; }
                            .certificate { 
                                width: 100%; 
                                height: 100vh; 
                                display: flex; 
                                align-items: center; 
                                justify-content: center; 
                            }
                        }
                    </style>
                </head>
                <body>
                    ${certificate.outerHTML}
                </body>
                </html>
            `);
            
            printWindow.document.close();
            printWindow.print();
        }

        function downloadCertificate() {
            // Einfache Implementierung - könnte mit einer PDF-Library erweitert werden
            alert('PDF-Download wird in einer zukünftigen Version implementiert.');
        }

        // Konfetti-Animation bei Seitenload
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                createConfetti();
            }, 500);
        });

        function createConfetti() {
            const colors = ['#FFD700', '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4'];
            const confettiCount = 50;
            
            for (let i = 0; i < confettiCount; i++) {
                const confetti = document.createElement('div');
                confetti.style.position = 'fixed';
                confetti.style.width = '10px';
                confetti.style.height = '10px';
                confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.left = Math.random() * 100 + '%';
                confetti.style.top = '-10px';
                confetti.style.borderRadius = '50%';
                confetti.style.pointerEvents = 'none';
                confetti.style.zIndex = '9999';
                confetti.style.animation = `confetti-fall ${Math.random() * 2 + 2}s linear forwards`;
                
                document.body.appendChild(confetti);
                
                setTimeout(() => {
                    confetti.remove();
                }, 4000);
            }
        }
        
        // CSS-Animation für Konfetti
        if (!document.querySelector('#confetti-style')) {
            const style = document.createElement('style');
            style.id = 'confetti-style';
            style.textContent = `
                @keyframes confetti-fall {
                    to {
                        transform: translateY(100vh) rotate(360deg);
                    }
                }
            `;
            document.head.appendChild(style);
        }
    </script>
</body>
</html>
