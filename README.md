# Inflation verstehen – Interaktives Lernmodul (WBS)

An interactive, web-based learning module on the topic of **inflation**, designed for secondary-school students in economics / WBS (Wirtschaft & Business Studies). Created by [TheRealTeacher.de](https://therealteacher.de).

---

## Features

- **5-page interactive lesson** covering inflation from definition to government countermeasures
- **Adaptive quiz** – 5 questions drawn randomly from a pool of 25 (multiple-choice & true/false)
- **Certificate generation** – personalised, printable, and PDF-exportable upon passing
- **Teacher admin panel** – password-protected overview of student results and statistics
- **Data-visualisation dashboard** – inflation-related economic charts with dark / light mode
- **Essay & infographics** – accompanying academic essay and printable infographic PDFs

---

## Project Structure

```
trtWBSInflation/
├── dashboard/
│   └── index.html          # Economic data-visualisation dashboard (Chart.js)
├── essay/
│   ├── 01_Essay_Inflation_WBS_1.0.pdf
│   ├── 01_Essay_Inflation_WBS_1.0.docx
│   └── Grafiken/           # Infographics (HTML & PDF)
└── quiz/
    ├── start.php            # Entry point – student name registration
    ├── pages/               # Lesson pages 1–5
    ├── quiz.php             # Quiz interface
    ├── result.php           # Results & certificate
    ├── admin.php            # Teacher admin panel
    ├── fragenpool_komplett.json  # Question pool (25 questions)
    ├── data/
    │   └── quiz_log.csv     # Quiz attempt log
    └── assets/
        ├── style.css
        └── js/script.js
```

---

## Technologies

| Layer | Technology |
|-------|-----------|
| Backend | PHP 7.0+ |
| Frontend | HTML5, CSS3, Vanilla JavaScript |
| Charts | [Chart.js](https://www.chartjs.org/) 4.4.0 |
| Fonts | Google Fonts (Inter) |
| Data | JSON (question pool), CSV (logging) |

---

## Getting Started

### Requirements

- A web server with **PHP 7.0+** (e.g., Apache, Nginx, or the built-in PHP development server)
- Write permission on `quiz/data/` so quiz results can be logged

### Quick start (PHP built-in server)

```bash
# From the repository root
php -S localhost:8080 -t quiz
```

Then open <http://localhost:8080/start.php> in your browser.

The dashboard can be opened directly in a browser without a server:

```
dashboard/index.html
```

### Admin panel

Navigate to `quiz/admin.php`.  
**Default password:** `therealteacher`

> ⚠️ Change the default password before deploying to a public server.  
> Edit `quiz/admin.php` and update the password constant at the top of the file.

---

## Quiz flow

1. Student enters their name on `start.php`.
2. The 5-page lesson is presented (`pages/page1.php` – `page5.php`).
3. After the lesson, `quiz.php` presents 5 randomly selected questions.
4. Students have **3 attempts** to achieve a perfect score (5 / 5).
5. On success, `result.php` displays a personalised certificate that can be printed or saved as a PDF.

---

## License

This project is licensed under the **MIT License** – see [LICENSE](LICENSE) for details.

Copyright © 2026 therealteacher
