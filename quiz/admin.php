<?php
session_start();

// KONFIGURATION - Hier Ihr Passwort ändern!
define('ADMIN_PASSWORD', 'therealteacher'); // TODO: Ändern Sie dieses Passwort!

// Login-Verarbeitung
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    if ($_POST['password'] === ADMIN_PASSWORD) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_login_time'] = time();
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $login_error = "Falsches Passwort!";
    }
}

// Logout-Verarbeitung
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Prüfung ob eingeloggt
$is_logged_in = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;

// Wenn nicht eingeloggt, Login-Formular anzeigen
if (!$is_logged_in) {
    ?>
    <!DOCTYPE html>
    <html lang="de">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Login - Inflation Lernmodul</title>
        <link rel="stylesheet" href="assets/style.css">
        <style>
            body {
                background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
                min-height: 100vh;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }
            .login-container {
                max-width: 480px;
                margin: 120px auto;
                padding: 3rem;
                background: white;
                border-radius: 16px;
                box-shadow: 0 8px 32px rgba(0,0,0,0.12);
                border: 1px solid rgba(255,255,255,0.2);
            }
            .login-header {
                text-align: center;
                margin-bottom: 3rem;
                color: #2c3e50;
            }
            .login-header h1 {
                font-size: 2rem;
                margin-bottom: 1rem;
                font-weight: 700;
            }
            .login-header p {
                font-size: 1.1rem;
                color: #6c757d;
                margin: 0;
            }
            .login-form {
                display: flex;
                flex-direction: column;
                gap: 2rem;
            }
            .form-group {
                display: flex;
                flex-direction: column;
            }
            .form-group label {
                margin-bottom: 0.8rem;
                font-weight: 600;
                color: #34495e;
                font-size: 1.1rem;
            }
            .form-group input {
                padding: 1rem 1.2rem;
                border: 2px solid #e0e6ed;
                border-radius: 12px;
                font-size: 1.1rem;
                transition: all 0.3s ease;
                background: #fafbfc;
            }
            .form-group input:focus {
                outline: none;
                border-color: #3498db;
                background: white;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(52, 152, 219, 0.2);
            }
            .login-btn {
                padding: 1.2rem;
                background: linear-gradient(135deg, #3498db, #2980b9);
                color: white;
                border: none;
                border-radius: 12px;
                font-size: 1.2rem;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s ease;
                margin-top: 1rem;
            }
            .login-btn:hover {
                transform: translateY(-3px);
                box-shadow: 0 8px 20px rgba(52, 152, 219, 0.3);
            }
            .login-btn:active {
                transform: translateY(-1px);
            }
            .error-message {
                background: linear-gradient(135deg, #e74c3c, #c0392b);
                color: white;
                padding: 1.2rem;
                border-radius: 12px;
                margin-bottom: 2rem;
                text-align: center;
                font-weight: 500;
                box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
            }
            .login-info {
                margin-top: 2.5rem;
                padding: 1.5rem;
                background: linear-gradient(135deg, #f8f9fa, #e9ecef);
                border-radius: 12px;
                font-size: 1rem;
                color: #495057;
                border-left: 4px solid #3498db;
                line-height: 1.6;
            }
            .container {
                padding: 0 1rem;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="login-container">
                <div class="login-header">
                    <h1>🔐 Admin-Bereich</h1>
                    <p>Bitte melden Sie sich an, um fortzufahren.</p>
                </div>

                <?php if (isset($login_error)): ?>
                    <div class="error-message">
                        ❌ <?php echo htmlspecialchars($login_error); ?>
                    </div>
                <?php endif; ?>

                <form method="post" class="login-form">
                    <div class="form-group">
                        <label for="password">Passwort:</label>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               required 
                               autocomplete="current-password"
                               placeholder="Geben Sie Ihr Passwort ein">
                    </div>
                    
                    <button type="submit" name="login" class="login-btn">
                        🚀 Anmelden
                    </button>
                </form>

                <div class="login-info">
                    <strong>ℹ️ Hinweis:</strong><br>
                    Nach der Anmeldung bleiben Sie für diese Browser-Session eingeloggt.
                </div>
            </div>
        </div>

        <script>
            // Automatischer Fokus auf Passwort-Feld
            document.getElementById('password').focus();
            
            // Enter-Taste für Login
            document.getElementById('password').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    document.querySelector('.login-btn').click();
                }
            });
        </script>
    </body>
    </html>
    <?php
    exit();
}

// Ab hier: Original Admin-Code (nur wenn eingeloggt)
// Session-Timeout nach 4 Stunden
if (time() - $_SESSION['admin_login_time'] > 14400) {
    session_destroy();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Funktionen für Admin-Aktionen
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'reset_all':
                // Alle Daten löschen
                @unlink('data/quiz_log.csv');
                @unlink('data/teilnehmer.csv');
                $message = "Alle Daten wurden erfolgreich gelöscht.";
                break;
                
            case 'export_csv':
                // CSV-Export
                $filename = 'inflation_quiz_export_' . date('Y-m-d_H-i') . '.csv';
                $filepath = 'data/' . $filename;
                
                // Kombinierte Daten erstellen
                $export_data = "Name,Datum,Uhrzeit,Versuch,Punkte,Erfolgreich\n";
                
                // Quiz-Log einlesen
                if (file_exists('data/quiz_log.csv')) {
                    $log_lines = file('data/quiz_log.csv', FILE_IGNORE_NEW_LINES);
                    foreach ($log_lines as $line) {
                        $parts = str_getcsv($line);
                        if (count($parts) >= 6) {
                            $erfolgreich = ($parts[4] == 5) ? 'Ja' : 'Nein';
                            $export_data .= sprintf(
                                "%s,%s,%s,%s,%s,%s\n",
                                $parts[0], $parts[1], $parts[2], $parts[3], $parts[4], $erfolgreich
                            );
                        }
                    }
                }
                
                file_put_contents($filepath, $export_data);
                
                // Download senden
                header('Content-Type: application/csv');
                header('Content-Disposition: attachment; filename="' . $filename . '"');
                header('Content-Length: ' . filesize($filepath));
                readfile($filepath);
                unlink($filepath);
                exit();
        }
    }
}

// Daten einlesen
$quiz_log = [];
$teilnehmer = [];
$stats = [
    'total_attempts' => 0,
    'successful_completions' => 0,
    'success_rate' => 0,
    'average_attempts' => 0
];

if (file_exists('data/quiz_log.csv')) {
    $log_lines = file('data/quiz_log.csv', FILE_IGNORE_NEW_LINES);
    foreach ($log_lines as $line) {
        $parts = str_getcsv($line);
        if (count($parts) >= 6) {
            $quiz_log[] = [
                'name' => $parts[0],
                'date' => $parts[1],
                'time' => $parts[2],
                'attempt' => $parts[3],
                'score' => $parts[4],
                'max_score' => $parts[5] ?? 5,
                'answers' => isset($parts[6]) ? explode(';', $parts[6]) : []
            ];
        }
    }
    $stats['total_attempts'] = count($quiz_log);
}

if (file_exists('data/teilnehmer.csv')) {
    $teilnehmer_lines = file('data/teilnehmer.csv', FILE_IGNORE_NEW_LINES);
    foreach ($teilnehmer_lines as $line) {
        $parts = str_getcsv($line);
        if (count($parts) >= 4) {
            $teilnehmer[] = [
                'name' => $parts[0],
                'date' => $parts[1],
                'time' => $parts[2],
                'attempts' => $parts[3]
            ];
        }
    }
    $stats['successful_completions'] = count($teilnehmer);
}

// Statistiken berechnen
if ($stats['total_attempts'] > 0) {
    $stats['success_rate'] = round(($stats['successful_completions'] / $stats['total_attempts']) * 100, 1);
    
    // Durchschnittliche Versuche berechnen
    $user_attempts = [];
    foreach ($quiz_log as $entry) {
        $user_attempts[$entry['name']] = max($user_attempts[$entry['name']] ?? 0, $entry['attempt']);
    }
    if (!empty($user_attempts)) {
        $stats['average_attempts'] = round(array_sum($user_attempts) / count($user_attempts), 1);
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Inflation Lernmodul</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        /* Verbesserte Abstände und Layout */
        body {
            line-height: 1.6;
            font-size: 16px;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .header {
            margin-bottom: 3rem;
            padding: 2rem 0;
            border-bottom: 2px solid #e9ecef;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
        }
        
        .header h1 {
            font-size: 2.2rem;
            margin: 0;
            color: #2c3e50;
            font-weight: 700;
        }
        
        .admin-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
            font-size: 1rem;
            color: #6c757d;
        }
        
        .logout-link {
            padding: 0.5rem 1rem;
            background: #e74c3c;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .logout-link:hover {
            background: #c0392b;
            transform: translateY(-2px);
        }
        
        .main-content {
            display: grid;
            gap: 3rem;
        }
        
        .content-card {
            background: white;
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid #e9ecef;
            margin-bottom: 2rem;
        }
        
        .page-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid #f8f9fa;
        }
        
        .page-header .icon {
            font-size: 2rem;
            background: linear-gradient(135deg, #3498db, #2980b9);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .page-header h2 {
            margin: 0;
            font-size: 1.8rem;
            color: #2c3e50;
            font-weight: 600;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 1rem;
        }
        
        .stat-item {
            background: linear-gradient(135deg, #f8f9fa, #ffffff);
            padding: 2rem;
            border-radius: 12px;
            text-align: center;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }
        
        .stat-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        
        .stat-item.success {
            border-color: #27ae60;
            background: linear-gradient(135deg, #d5f4e6, #ffffff);
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            font-size: 1.1rem;
            color: #6c757d;
            font-weight: 500;
        }
        
        .table-responsive {
            margin-top: 1.5rem;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 1rem;
        }
        
        .data-table thead {
            background: linear-gradient(135deg, #34495e, #2c3e50);
            color: white;
        }
        
        .data-table th {
            padding: 1.5rem 1rem;
            text-align: left;
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        .data-table td {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid #e9ecef;
        }
        
        .data-table tbody tr:hover {
            background: #f8f9fa;
        }
        
        .data-table tbody tr:last-child td {
            border-bottom: none;
        }
        
        .no-data {
            text-align: center;
            padding: 3rem;
            color: #6c757d;
            font-size: 1.1rem;
            background: #f8f9fa;
            border-radius: 12px;
            margin-top: 1.5rem;
        }
        
        .admin-actions {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
            margin-bottom: 2.5rem;
        }
        
        .btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, #6c757d, #5a6268);
            color: white;
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
        }
        
        .btn-outline {
            background: white;
            color: #6c757d;
            border: 2px solid #6c757d;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.2);
        }
        
        .admin-info-box {
            background: linear-gradient(135deg, #ebf3fd, #ffffff);
            padding: 2rem;
            border-radius: 12px;
            border-left: 4px solid #3498db;
            margin-top: 2rem;
        }
        
        .admin-info-box h3 {
            margin-top: 0;
            margin-bottom: 1.5rem;
            color: #2c3e50;
            font-size: 1.3rem;
        }
        
        .admin-info-box ul {
            margin: 0;
            padding-left: 1.5rem;
        }
        
        .admin-info-box li {
            margin-bottom: 1rem;
            font-size: 1rem;
            line-height: 1.6;
        }
        
        .back-to-module {
            text-align: center;
            padding: 2rem;
            background: linear-gradient(135deg, #f1c40f, #f39c12);
            border-radius: 12px;
            color: white;
        }
        
        .back-to-module h3 {
            margin-top: 0;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }
        
        .back-to-module p {
            margin-bottom: 2rem;
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .success-message {
            background: linear-gradient(135deg, #27ae60, #229954);
            color: white;
            padding: 1.5rem 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            font-size: 1.1rem;
            font-weight: 500;
            box-shadow: 0 4px 15px rgba(39, 174, 96, 0.3);
        }
        
        .footer {
            margin-top: 4rem;
            padding: 2rem 0;
            text-align: center;
            border-top: 2px solid #e9ecef;
            color: #6c757d;
        }
        
        .attempt-badge, .status-badge, .score-badge {
            padding: 0.6rem 1.2rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-block;
            text-align: center;
            min-width: 60px;
        }
        
        .attempt-badge.attempt-1 {
            background: linear-gradient(135deg, #27ae60, #229954);
            color: white;
        }
        
        .attempt-badge.attempt-2 {
            background: linear-gradient(135deg, #f39c12, #e67e22);
            color: white;
        }
        
        .attempt-badge.attempt-3 {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
        }
        
        .status-badge.success {
            background: linear-gradient(135deg, #27ae60, #229954);
            color: white;
        }
        
        .status-badge.failed {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
        }
        
        .score-badge.perfect {
            background: linear-gradient(135deg, #27ae60, #229954);
            color: white;
        }
        
        .score-badge.good {
            background: linear-gradient(135deg, #f39c12, #e67e22);
            color: white;
        }
        
        .score-badge.poor {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
        }
        
        .name-cell {
            font-weight: 600;
            color: #2c3e50;
        }
        
        .score-cell {
            text-align: center;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            
            .header-content {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .admin-actions {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .content-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="header-content">
                <h1>👨‍🏫 Lehreransicht - Inflation verstehen</h1>
                <div class="admin-info">
                    <span class="timestamp">Stand: <?php echo date('d.m.Y H:i'); ?></span>
                    <span style="margin: 0 10px;">|</span>
                    <span class="login-status">✅ Eingeloggt seit <?php echo date('H:i', $_SESSION['admin_login_time']); ?></span>
                    <span style="margin: 0 10px;">|</span>
                    <a href="?logout=1" class="logout-link" 
                       onclick="return confirm('Wirklich abmelden?')"
                       style="color: #e74c3c; text-decoration: none; font-weight: 600;">
                        🚪 Abmelden
                    </a>
                </div>
            </div>
        </header>

        <main class="main-content">
            <?php if (isset($message)): ?>
                <div class="success-message">
                    <p>✅ <?php echo htmlspecialchars($message); ?></p>
                </div>
            <?php endif; ?>

            <!-- Statistik-Übersicht -->
            <div class="content-card">
                <div class="page-header">
                    <div class="icon">📊</div>
                    <h2>Statistik-Übersicht</h2>
                </div>

                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-number"><?php echo $stats['total_attempts']; ?></div>
                        <div class="stat-label">Gesamte Versuche</div>
                    </div>
                    <div class="stat-item success">
                        <div class="stat-number"><?php echo $stats['successful_completions']; ?></div>
                        <div class="stat-label">Erfolgreich abgeschlossen</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?php echo $stats['success_rate']; ?>%</div>
                        <div class="stat-label">Erfolgsquote</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?php echo $stats['average_attempts']; ?></div>
                        <div class="stat-label">⌀ Versuche bis Erfolg</div>
                    </div>
                </div>
            </div>

            <!-- Erfolgreich abgeschlossene Teilnehmer -->
            <div class="content-card">
                <div class="page-header">
                    <div class="icon">🏆</div>
                    <h2>Erfolgreich abgeschlossene Teilnehmer</h2>
                </div>

                <?php if (empty($teilnehmer)): ?>
                    <div class="no-data">
                        <p>Noch keine Teilnehmer haben das Quiz erfolgreich abgeschlossen.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Datum</th>
                                    <th>Uhrzeit</th>
                                    <th>Versuche benötigt</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($teilnehmer as $person): ?>
                                    <tr>
                                        <td class="name-cell"><?php echo htmlspecialchars($person['name']); ?></td>
                                        <td><?php echo htmlspecialchars($person['date']); ?></td>
                                        <td><?php echo htmlspecialchars($person['time']); ?></td>
                                        <td>
                                            <span class="attempt-badge attempt-<?php echo min($person['attempts'], 3); ?>">
                                                <?php echo $person['attempts']; ?>/3
                                            </span>
                                        </td>
                                        <td>
                                            <span class="status-badge success">✅ Bestanden</span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Detaillierte Quiz-Logs -->
            <div class="content-card">
                <div class="page-header">
                    <div class="icon">📋</div>
                    <h2>Detaillierte Quiz-Versuche</h2>
                </div>

                <?php if (empty($quiz_log)): ?>
                    <div class="no-data">
                        <p>Noch keine Quiz-Versuche vorhanden.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Datum</th>
                                    <th>Uhrzeit</th>
                                    <th>Versuch</th>
                                    <th>Punkte</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_reverse($quiz_log) as $entry): ?>
                                    <tr>
                                        <td class="name-cell"><?php echo htmlspecialchars($entry['name']); ?></td>
                                        <td><?php echo htmlspecialchars($entry['date']); ?></td>
                                        <td><?php echo htmlspecialchars($entry['time']); ?></td>
                                        <td>
                                            <span class="attempt-badge attempt-<?php echo min($entry['attempt'], 3); ?>">
                                                <?php echo $entry['attempt']; ?>
                                            </span>
                                        </td>
                                        <td class="score-cell">
                                            <span class="score-badge <?php echo $entry['score'] == 5 ? 'perfect' : ($entry['score'] >= 3 ? 'good' : 'poor'); ?>">
                                                <?php echo $entry['score']; ?>/5
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($entry['score'] == 5): ?>
                                                <span class="status-badge success">✅ Bestanden</span>
                                            <?php else: ?>
                                                <span class="status-badge failed">❌ Nicht bestanden</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Admin-Aktionen -->
            <div class="content-card">
                <div class="page-header">
                    <div class="icon">⚙️</div>
                    <h2>Admin-Aktionen</h2>
                </div>

                <div class="admin-actions">
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="action" value="export_csv">
                        <button type="submit" class="btn btn-secondary">
                            📊 Daten als CSV exportieren
                        </button>
                    </form>

                    <form method="post" style="display: inline;" 
                          onsubmit="return confirm('Sind Sie sicher, dass Sie alle Daten löschen möchten? Diese Aktion kann nicht rückgängig gemacht werden.')">
                        <input type="hidden" name="action" value="reset_all">
                        <button type="submit" class="btn btn-danger">
                            🗑️ Alle Daten löschen
                        </button>
                    </form>

                    <button onclick="window.location.reload()" class="btn btn-outline">
                        🔄 Seite aktualisieren
                    </button>
                </div>

                <div class="admin-info-box">
                    <h3>ℹ️ Informationen</h3>
                    <ul>
                        <li><strong>Quiz-System:</strong> Teilnehmer haben 3 Versuche für das Quiz</li>
                        <li><strong>Bestehen:</strong> Nur bei 5/5 Punkten wird ein Zertifikat ausgestellt</li>
                        <li><strong>Datensammlung:</strong> Alle Versuche werden für Auswertungen gespeichert</li>
                        <li><strong>Datenschutz:</strong> Nur Namen und Ergebnisse werden gespeichert</li>
                        <li><strong>Session-Timeout:</strong> Automatisches Abmelden nach 4 Stunden Inaktivität</li>
                    </ul>
                </div>
            </div>

            <!-- Navigation zurück zum Modul -->
            <div class="content-card">
                <div class="back-to-module">
                    <h3>🎓 Zurück zum Lernmodul</h3>
                    <p>Testen Sie das Modul selbst oder teilen Sie den Link mit Ihren Schülern.</p>
                    <a href="pages/start.php" class="btn btn-primary" target="_blank">
                        Lernmodul starten
                    </a>
                </div>
            </div>
        </main>

        <button id="back-to-top" class="back-to-top">↑</button>

        <footer class="footer">
            <p>&copy; 2025 Interaktives Lernmodul - Inflation | Admin-Bereich (Geschützt)</p>
        </footer>
    </div>

    <script src="assets/js/script.js"></script>
    <script>
        // Auto-Aktualisierung alle 5 Minuten
        setTimeout(function() {
            if (confirm('Daten aktualisieren? (Seite wird neu geladen)')) {
                window.location.reload();
            }
        }, 300000); // 5 Minuten

        // Moderne Tabellen-Funktionalität
        document.addEventListener('DOMContentLoaded', function() {
            const tables = document.querySelectorAll('.data-table');
            tables.forEach(table => {
                // Sortierung hinzufügen könnte hier implementiert werden
                table.classList.add('interactive-table');
            });
        });

        // Session-Warnung bei Inaktivität
        let inactivityTimer;
        function resetInactivityTimer() {
            clearTimeout(inactivityTimer);
            inactivityTimer = setTimeout(function() {
                if (confirm('Sie waren länger inaktiv. Möchten Sie eingeloggt bleiben?')) {
                    // Seite aktualisieren um Session zu verlängern
                    window.location.reload();
                }
            }, 3600000); // 1 Stunde Warnung
        }

        // Event-Listener für Benutzeraktivität
        ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart'].forEach(function(event) {
            document.addEventListener(event, resetInactivityTimer, true);
        });

        resetInactivityTimer(); // Timer starten
    </script>
</body>
</html>