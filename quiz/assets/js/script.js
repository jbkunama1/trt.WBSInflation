// === DOM READY ===
document.addEventListener('DOMContentLoaded', function() {
    initializeProgressBar();
    initializeBackToTop();
    initializeButtonHoverEffects();
    initializeQuizInteractions();
});

// === PROGRESS BAR ===
function initializeProgressBar() {
    const progressFill = document.getElementById('progress-fill');
    const progressText = document.getElementById('progress-text');
    
    if (!progressFill || !progressText) return;
    
    // Aktuelle Seite aus dem Dateinamen ermitteln
    const currentPage = getCurrentPageNumber();
    const totalPages = 5;
    
    if (currentPage > 0 && currentPage <= totalPages) {
        // Fortschritt berechnen und animieren
        const progressPercentage = (currentPage / totalPages) * 100;
        
        setTimeout(() => {
            progressFill.style.width = progressPercentage + '%';
        }, 300);
        
        // Text aktualisieren
        progressText.textContent = `Seite ${currentPage} von ${totalPages}`;
    }
}

function getCurrentPageNumber() {
    const path = window.location.pathname;
    const filename = path.split('/').pop();
    
    // Seitennummer aus Dateiname extrahieren
    const pageMatch = filename.match(/page(\d+)\.php/);
    if (pageMatch) {
        return parseInt(pageMatch[1]);
    }
    
    return 0;
}

// === BACK TO TOP BUTTON ===
function initializeBackToTop() {
    const backToTopButton = document.getElementById('back-to-top');
    
    if (!backToTopButton) return;
    
    // Sichtbarkeit basierend auf Scroll-Position
    function toggleBackToTopVisibility() {
        if (window.pageYOffset > 300) {
            backToTopButton.classList.add('visible');
        } else {
            backToTopButton.classList.remove('visible');
        }
    }
    
    // Event Listeners
    window.addEventListener('scroll', toggleBackToTopVisibility);
    
    backToTopButton.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
    
    // Initiale Überprüfung
    toggleBackToTopVisibility();
}

// === BUTTON HOVER EFFECTS ===
function initializeButtonHoverEffects() {
    const buttons = document.querySelectorAll('.btn');
    
    buttons.forEach(button => {
        // Ripple-Effekt bei Klick
        button.addEventListener('click', function(e) {
            createRippleEffect(e, this);
        });
        
        // Hover-Animation verstärken
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
}

function createRippleEffect(event, element) {
    const ripple = document.createElement('span');
    const rect = element.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    const x = event.clientX - rect.left - size / 2;
    const y = event.clientY - rect.top - size / 2;
    
    ripple.style.cssText = `
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: scale(0);
        left: ${x}px;
        top: ${y}px;
        width: ${size}px;
        height: ${size}px;
        pointer-events: none;
        animation: ripple 0.6s linear;
    `;
    
    // Ripple-Animation CSS hinzufügen falls nicht vorhanden
    if (!document.querySelector('#ripple-style')) {
        const style = document.createElement('style');
        style.id = 'ripple-style';
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(2);
                    opacity: 0;
                }
            }
            .btn {
                position: relative;
                overflow: hidden;
            }
        `;
        document.head.appendChild(style);
    }
    
    element.appendChild(ripple);
    
    setTimeout(() => {
        ripple.remove();
    }, 600);
}

// === QUIZ INTERACTIONS ===
function initializeQuizInteractions() {
    const quizForm = document.querySelector('.quiz-form');
    const optionLabels = document.querySelectorAll('.option-label');
    
    if (!quizForm) return;
    
    // Visuelle Verbesserungen für Optionen
    optionLabels.forEach(label => {
        const radio = label.querySelector('input[type="radio"]');
        
        label.addEventListener('click', function() {
            // Alle Optionen der gleichen Gruppe zurücksetzen
            const name = radio.name;
            const sameGroup = document.querySelectorAll(`input[name="${name}"]`);
            
            sameGroup.forEach(input => {
                input.closest('.option-label').classList.remove('selected');
            });
            
            // Aktuelle Auswahl markieren
            this.classList.add('selected');
        });
        
        // Hover-Effekte
        label.addEventListener('mouseenter', function() {
            if (!this.classList.contains('selected')) {
                this.style.backgroundColor = '#f0f4ff';
                this.style.borderColor = '#b3d4ff';
            }
        });
        
        label.addEventListener('mouseleave', function() {
            if (!this.classList.contains('selected')) {
                this.style.backgroundColor = 'white';
                this.style.borderColor = '#e9ecef';
            }
        });
    });
    
    // Formular-Validierung verbessern
    quizForm.addEventListener('submit', function(e) {
        const requiredQuestions = document.querySelectorAll('.question-container');
        let allAnswered = true;
        
        requiredQuestions.forEach((question, index) => {
            const radios = question.querySelectorAll('input[type="radio"]');
            const isAnswered = Array.from(radios).some(radio => radio.checked);
            
            if (!isAnswered) {
                allAnswered = false;
                question.style.borderColor = '#dc3545';
                question.style.backgroundColor = '#fff5f5';
                
                // Fehlermeldung anzeigen
                let errorMsg = question.querySelector('.error-message');
                if (!errorMsg) {
                    errorMsg = document.createElement('div');
                    errorMsg.className = 'error-message';
                    errorMsg.style.cssText = 'color: #dc3545; font-size: 0.9rem; margin-top: 0.5rem; font-weight: 500;';
                    errorMsg.textContent = 'Bitte wählen Sie eine Antwort aus.';
                    question.appendChild(errorMsg);
                }
            } else {
                question.style.borderColor = '#dee2e6';
                question.style.backgroundColor = '#f8f9fa';
                const errorMsg = question.querySelector('.error-message');
                if (errorMsg) {
                    errorMsg.remove();
                }
            }
        });
        
        if (!allAnswered) {
            e.preventDefault();
            
            // Zum ersten unbeantworteten Frage scrollen
            const firstError = document.querySelector('.question-container[style*="border-color: rgb(220, 53, 69)"]');
            if (firstError) {
                firstError.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
            
            // Warnung anzeigen
            showNotification('Bitte beantworten Sie alle Fragen, bevor Sie fortfahren.', 'warning');
        }
    });
}

// === NOTIFICATIONS ===
function showNotification(message, type = 'info') {
    // Entferne existierende Notifications
    const existing = document.querySelector('.notification');
    if (existing) {
        existing.remove();
    }
    
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    
    const colors = {
        info: '#17a2b8',
        warning: '#ffc107',
        error: '#dc3545',
        success: '#28a745'
    };
    
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${colors[type] || colors.info};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        z-index: 10000;
        font-weight: 500;
        max-width: 300px;
        animation: slideIn 0.3s ease;
    `;
    
    notification.textContent = message;
    
    // Animation CSS hinzufügen
    if (!document.querySelector('#notification-style')) {
        const style = document.createElement('style');
        style.id = 'notification-style';
        style.textContent = `
            @keyframes slideIn {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
        `;
        document.head.appendChild(style);
    }
    
    document.body.appendChild(notification);
    
    // Automatisch entfernen
    setTimeout(() => {
        notification.style.animation = 'slideIn 0.3s ease reverse';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 300);
    }, 4000);
}

// === SMOOTH SCROLLING ===
function initializeSmoothScrolling() {
    const links = document.querySelectorAll('a[href^="#"]');
    
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href === '#' || href === '#top') {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                return;
            }
            
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// === LAZY LOADING FÜR BILDER ===
function initializeLazyLoading() {
    const images = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                observer.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
}

// === ACCESSIBILITY IMPROVEMENTS ===
function initializeAccessibility() {
    // Keyboard navigation für custom elements
    const customButtons = document.querySelectorAll('.option-label');
    
    customButtons.forEach((button, index) => {
        button.setAttribute('tabindex', '0');
        button.setAttribute('role', 'radio');
        
        button.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                const radio = this.querySelector('input[type="radio"]');
                if (radio) {
                    radio.checked = true;
                    radio.dispatchEvent(new Event('change'));
                    this.click();
                }
            }
        });
        
        button.addEventListener('focus', function() {
            this.style.outline = '2px solid #667eea';
            this.style.outlineOffset = '2px';
        });
        
        button.addEventListener('blur', function() {
            this.style.outline = 'none';
        });
    });
}

// === PERFORMANCE MONITORING ===
function initializePerformanceMonitoring() {
    // Einfaches Performance-Monitoring
    if ('performance' in window) {
        window.addEventListener('load', function() {
            const perfData = performance.getEntriesByType('navigation')[0];
            const loadTime = perfData.loadEventEnd - perfData.loadEventStart;
            
            if (loadTime > 3000) {
                console.warn('Seite lädt langsam:', loadTime + 'ms');
            }
        });
    }
}

// === FORM ENHANCEMENTS ===
function initializeFormEnhancements() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        const inputs = form.querySelectorAll('input, textarea, select');
        
        inputs.forEach(input => {
            // Autofocus für das erste sichtbare Eingabefeld
            if (!document.querySelector('input:focus') && input.type !== 'hidden') {
                input.focus();
                return;
            }
            
            // Eingabe-Validierung in Echtzeit
            input.addEventListener('input', function() {
                validateField(this);
            });
            
            input.addEventListener('blur', function() {
                validateField(this);
            });
        });
        
        // Verhindere doppelte Form-Submissions
        form.addEventListener('submit', function() {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn && !submitBtn.disabled) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Wird verarbeitet...';
                
                setTimeout(() => {
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.textContent = submitBtn.dataset.originalText || 'Absenden';
                    }
                }, 5000);
            }
        });
    });
}

function validateField(field) {
    const value = field.value.trim();
    let isValid = true;
    let errorMessage = '';
    
    // Verschiedene Validierungen
    if (field.required && !value) {
        isValid = false;
        errorMessage = 'Dieses Feld ist erforderlich.';
    } else if (field.type === 'email' && value && !isValidEmail(value)) {
        isValid = false;
        errorMessage = 'Bitte geben Sie eine gültige E-Mail-Adresse ein.';
    } else if (field.name === 'name' && value && value.length < 2) {
        isValid = false;
        errorMessage = 'Name muss mindestens 2 Zeichen lang sein.';
    }
    
    // Visuelle Rückmeldung
    const errorElement = field.parentNode.querySelector('.field-error');
    
    if (!isValid) {
        field.style.borderColor = '#dc3545';
        field.style.backgroundColor = '#fff5f5';
        
        if (!errorElement) {
            const error = document.createElement('div');
            error.className = 'field-error';
            error.style.cssText = 'color: #dc3545; font-size: 0.8rem; margin-top: 0.25rem;';
            error.textContent = errorMessage;
            field.parentNode.appendChild(error);
        } else {
            errorElement.textContent = errorMessage;
        }
    } else {
        field.style.borderColor = '#28a745';
        field.style.backgroundColor = '#f8fff9';
        
        if (errorElement) {
            errorElement.remove();
        }
    }
    
    return isValid;
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// === ANIMATION UTILITIES ===
function fadeIn(element, duration = 300) {
    element.style.opacity = '0';
    element.style.display = 'block';
    
    const start = performance.now();
    
    function animate(currentTime) {
        const elapsed = currentTime - start;
        const progress = Math.min(elapsed / duration, 1);
        
        element.style.opacity = progress;
        
        if (progress < 1) {
            requestAnimationFrame(animate);
        }
    }
    
    requestAnimationFrame(animate);
}

function fadeOut(element, duration = 300, callback) {
    const start = performance.now();
    const startOpacity = parseFloat(getComputedStyle(element).opacity);
    
    function animate(currentTime) {
        const elapsed = currentTime - start;
        const progress = Math.min(elapsed / duration, 1);
        
        element.style.opacity = startOpacity * (1 - progress);
        
        if (progress < 1) {
            requestAnimationFrame(animate);
        } else {
            element.style.display = 'none';
            if (callback) callback();
        }
    }
    
    requestAnimationFrame(animate);
}

// === CERTIFICATE INTERACTIONS ===
function initializeCertificateInteractions() {
    const certificate = document.getElementById('certificate');
    
    if (!certificate) return;
    
    // Hover-Effekt für Zertifikat
    certificate.addEventListener('mouseenter', function() {
        this.style.transform = 'scale(1.02)';
        this.style.transition = 'transform 0.3s ease';
    });
    
    certificate.addEventListener('mouseleave', function() {
        this.style.transform = 'scale(1)';
    });
}

// === DATA VISUALIZATION HELPERS ===
function createSimpleChart(containerId, data, type = 'bar') {
    const container = document.getElementById(containerId);
    if (!container) return;
    
    // Einfache ASCII-Art Charts für bessere Kompatibilität
    if (type === 'bar') {
        createAsciiBarChart(container, data);
    }
}

function createAsciiBarChart(container, data) {
    const maxValue = Math.max(...Object.values(data));
    const chartHtml = Object.entries(data).map(([label, value]) => {
        const percentage = (value / maxValue) * 100;
        return `
            <div class="ascii-bar-item">
                <span class="ascii-bar-label">${label}</span>
                <div class="ascii-bar-container">
                    <div class="ascii-bar-fill" style="width: ${percentage}%"></div>
                    <span class="ascii-bar-value">${value}</span>
                </div>
            </div>
        `;
    }).join('');
    
    container.innerHTML = `<div class="ascii-chart">${chartHtml}</div>`;
    
    // CSS für ASCII Chart hinzufügen
    if (!document.querySelector('#ascii-chart-style')) {
        const style = document.createElement('style');
        style.id = 'ascii-chart-style';
        style.textContent = `
            .ascii-chart {
                font-family: monospace;
                background: #f8f9fa;
                padding: 1rem;
                border-radius: 8px;
            }
            .ascii-bar-item {
                margin-bottom: 0.5rem;
                display: flex;
                align-items: center;
                gap: 1rem;
            }
            .ascii-bar-label {
                min-width: 100px;
                font-weight: bold;
            }
            .ascii-bar-container {
                flex: 1;
                position: relative;
                height: 20px;
                background: #dee2e6;
                border-radius: 4px;
                overflow: hidden;
            }
            .ascii-bar-fill {
                height: 100%;
                background: linear-gradient(90deg, #667eea, #764ba2);
                transition: width 0.5s ease;
            }
            .ascii-bar-value {
                position: absolute;
                right: 5px;
                top: 50%;
                transform: translateY(-50%);
                font-size: 0.8rem;
                color: #495057;
                font-weight: bold;
            }
        `;
        document.head.appendChild(style);
    }
}

// === LOCAL STORAGE HELPERS (falls verfügbar) ===
function saveToLocalStorage(key, data) {
    try {
        if (typeof Storage !== 'undefined') {
            localStorage.setItem(key, JSON.stringify(data));
            return true;
        }
    } catch (e) {
        console.warn('LocalStorage nicht verfügbar:', e);
    }
    return false;
}

function loadFromLocalStorage(key) {
    try {
        if (typeof Storage !== 'undefined') {
            const data = localStorage.getItem(key);
            return data ? JSON.parse(data) : null;
        }
    } catch (e) {
        console.warn('Fehler beim Laden aus LocalStorage:', e);
    }
    return null;
}

// === ERROR HANDLING ===
window.addEventListener('error', function(e) {
    console.error('JavaScript-Fehler:', e.error);
    
    // Benutzerfreundliche Fehlermeldung (nur in Development)
    if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
        showNotification('Ein Fehler ist aufgetreten. Bitte laden Sie die Seite neu.', 'error');
    }
});

// === INITIALIZATION ===
document.addEventListener('DOMContentLoaded', function() {
    // Alle Initialisierungsfunktionen aufrufen
    initializeProgressBar();
    initializeBackToTop();
    initializeButtonHoverEffects();
    initializeQuizInteractions();
    initializeSmoothScrolling();
    initializeLazyLoading();
    initializeAccessibility();
    initializePerformanceMonitoring();
    initializeFormEnhancements();
    initializeCertificateInteractions();
    
    // Erfolgreiche Initialisierung loggen
    console.log('🚀 Lernmodul erfolgreich initialisiert');
});

// === UTILITY FUNCTIONS ===
function debounce(func, wait, immediate) {
    let timeout;
    return function executedFunction() {
        const context = this;
        const args = arguments;
        const later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        const callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
}

function throttle(func, limit) {
    let lastFunc;
    let lastRan;
    return function() {
        const context = this;
        const args = arguments;
        if (!lastRan) {
            func.apply(context, args);
            lastRan = Date.now();
        } else {
            clearTimeout(lastFunc);
            lastFunc = setTimeout(function() {
                if ((Date.now() - lastRan) >= limit) {
                    func.apply(context, args);
                    lastRan = Date.now();
                }
            }, limit - (Date.now() - lastRan));
        }
    };
}

// === EXPORT FÜR MODULE (falls verwendet) ===
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        initializeProgressBar,
        initializeBackToTop,
        initializeButtonHoverEffects,
        initializeQuizInteractions,
        showNotification,
        createSimpleChart
    };
}
