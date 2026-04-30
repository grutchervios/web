// =============================================
// VIDEOGAME HUB - MAIN JAVASCRIPT
// =============================================

document.addEventListener('DOMContentLoaded', function() {

    // ========== 1. DARK / LIGHT MODE TOGGLE ==========
    const themeToggleBtn = document.getElementById('theme-toggle');
    
    if (themeToggleBtn) {
        // Comprobar si el usuario ya tenía un tema guardado
        const savedTheme = localStorage.getItem('vgHubTheme');
        if (savedTheme === 'light') {
            document.body.classList.add('light-mode');
            themeToggleBtn.textContent = '☀️';
        }
        
        themeToggleBtn.addEventListener('click', function() {
            document.body.classList.toggle('light-mode');
            
            if (document.body.classList.contains('light-mode')) {
                themeToggleBtn.textContent = '☀️';
                localStorage.setItem('vgHubTheme', 'light');
            } else {
                themeToggleBtn.textContent = '🌙';
                localStorage.setItem('vgHubTheme', 'dark');
            }
        });
    }

    // ========== 2. SEARCH FILTER (Solo en Reviews) ==========
    const searchInput = document.getElementById('review-search');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const filter = this.value.toLowerCase().trim();
            const reviewRows = document.querySelectorAll('.review-row');
            
            reviewRows.forEach(function(row) {
                const title = row.querySelector('h3').textContent.toLowerCase();
                const text = row.querySelector('p').textContent.toLowerCase();
                
                if (title.includes(filter) || text.includes(filter)) {
                    row.style.display = 'flex';
                    row.style.animation = 'fadeIn 0.4s ease forwards';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    // ========== 3. SMOOTH SCROLL PARA ENLACES INTERNOS ==========
    document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            
            if (targetId !== '#') {
                e.preventDefault();
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });

    // ========== 4. ANIMACIÓN DE ENTRADA PARA CARDS ==========
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observar game cards, guide cards, news items
    document.querySelectorAll('.game-card, .guide-card, .news-item, .forum-card').forEach(function(card) {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });

});