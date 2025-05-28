document.addEventListener('DOMContentLoaded', function() {
    // ==================== ANIMATION FUNCTIONS ====================
    function fadeInUp(element, delay = 0) {
        if (!element) return;
        
        setTimeout(() => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(20px)';
            element.style.transition = 'opacity 0.8s ease-out, transform 0.8s ease-out';
            
            setTimeout(() => {
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }, 50);
        }, delay);
    }

    function floatAnimation(element) {
        if (!element) return;
        element.style.animation = 'float 4s ease-in-out infinite';
    }

    function pulseAnimation(element) {
        if (!element) return;
        element.style.animation = 'pulse 2s ease-in-out infinite';
    }

    function addHoverEffect(element) {
        if (!element) return;
        
        element.addEventListener('mouseenter', () => {
            element.style.transform = 'translateY(-10px) scale(1.02)';
            element.style.boxShadow = '0 20px 30px rgba(0, 0, 0, 0.3)';
            element.style.transition = 'transform 0.3s ease, box-shadow 0.3s ease';
        });
        
        element.addEventListener('mouseleave', () => {
            element.style.transform = '';
            element.style.boxShadow = '';
        });
    }

    // ==================== KEYFRAMES ====================
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Blue wave animation */
        @keyframes blueWaveMove {
            0% { transform: translateX(0) translateY(0); }
            25% { transform: translateX(-15px) translateY(5px); }
            50% { transform: translateX(0) translateY(10px); }
            75% { transform: translateX(15px) translateY(5px); }
            100% { transform: translateX(0) translateY(0); }
        }
        
        /* Grey wave animation */
        @keyframes greyWaveMove {
            0% { transform: translateX(0) translateY(0); }
            25% { transform: translateX(-8px) translateY(3px); }
            50% { transform: translateX(0) translateY(5px); }
            75% { transform: translateX(8px) translateY(3px); }
            100% { transform: translateX(0) translateY(0); }
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .blue-wave-element {
            will-change: transform;
            animation: blueWaveMove 7s ease-in-out infinite;
        }
        
        .grey-wave-element {
            will-change: transform;
            animation: greyWaveMove 9s ease-in-out infinite;
        }
        
        /* Text animation classes */
        .text-animate {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        
        .text-animate.show {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Delay classes for staggered animations */
        .delay-1 { transition-delay: 0.1s; }
        .delay-2 { transition-delay: 0.2s; }
        .delay-3 { transition-delay: 0.3s; }
        
        /* Scroll Animation Classes */
        .animate__animated {
            animation-duration: 1s;
            animation-fill-mode: both;
        }
        .animate__fadeInUp {
            animation-name: fadeInUp;
        }
    `;
    document.head.appendChild(style);

    // ==================== SCROLL OBSERVERS ====================
    // For regular elements
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
            } else {
                entry.target.classList.remove('show');
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

    // For text elements
    const textObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

    // ==================== INITIAL ANIMATIONS ====================
    // Header
    const header = document.querySelector('.header');
    fadeInUp(header);

    // Logo - Static
    const logo = document.querySelector('.GRAD-JOURNEY-LOGO');
    if (logo) logo.style.opacity = '1';

    // Hero Section
    const heroSection = document.querySelector('.frame-16');
    fadeInUp(heroSection, 200);

    const heading = document.querySelector('.heading');
    fadeInUp(heading, 400);

    const paragraph = document.querySelector('.paragraph');
    fadeInUp(paragraph, 600);

    // Login Button
    const loginButton = document.querySelector('.frame-18');
    fadeInUp(loginButton, 800);
    pulseAnimation(loginButton);

    // ==================== WAVE ANIMATIONS ====================
    document.querySelectorAll('.BLUE-WAVE, .blue-WAVE-wrapper').forEach(wave => {
        wave.classList.add('blue-wave-element');
        const waveImg = wave.querySelector('img');
        if (waveImg) waveImg.classList.add('blue-wave-element');
    });

    document.querySelectorAll('.GREY-WAVE, .WAVE-BACKGROUND-wrapper, .WAVE-BACKGROUND, .WAVE-BACKGROUND-2').forEach(wave => {
        wave.classList.add('grey-wave-element');
        const waveImg = wave.querySelector('img');
        if (waveImg) waveImg.classList.add('grey-wave-element');
    });

    // ==================== TEXT ANIMATIONS ====================
    const textElements = document.querySelectorAll(
        '.heading, .paragraph, .text-wrapper, .text-wrapper-2, ' +
        '.text-wrapper-3, .text-wrapper-4, .text-wrapper-5, ' +
        '.text-wrapper-6, .text-wrapper-7, .text-wrapper-8, ' +
        '.text, .text-2, .text-3, .text-4, .text-5, ' +
        '.text-6, .text-7, .text-8, .text-9, .text-10, ' +
        '.what-is-GRAD-journey, .what-are-the, .data-export, ' +
        '.p, .link, .link-2, .link-3, .link-4'
    );

    textElements.forEach((text, index) => {
        text.classList.add('text-animate');
        text.classList.add(`delay-${(index % 3) + 1}`);
        textObserver.observe(text);
    });

    // ==================== SETUP SCROLL ANIMATIONS ====================
    const animatableElements = document.querySelectorAll(
        '.frame-12, .frame-13, .frame-14, .frame-15, ' +
        '.frame-8, .frame-9, .frame-10, .frame-11, ' +
        '.frame-16, .frame-17, .frame-18, .frame-19'
    );
    
    animatableElements.forEach(el => {
        el.classList.add('animate-on-scroll');
        observer.observe(el);
    });

    // ==================== OTHER ELEMENTS ====================
    // Icons
    const icons = document.querySelectorAll('.img, .file-transfer, .LOGIN-VECTOR, .ADMIN-VECTOR, .DATA-COLECTION, .COMPLETE-TRACER');
    icons.forEach(icon => floatAnimation(icon));

    // Feature Cards
    const featureCards = document.querySelectorAll('.frame-9, .frame-10, .frame-11');
    featureCards.forEach((card, index) => {
        addHoverEffect(card);
    });

    // Navigation Items
    const navItems = document.querySelectorAll('.frame-21');
    navItems.forEach(item => {
        const text = item.querySelector('.text-wrapper-8');
        if (text) {
            text.style.transition = 'all 0.3s ease';
            
            item.addEventListener('mouseenter', () => {
                text.style.color = '#1fa3fd';
                text.style.transform = 'translateY(-3px)';
            });
            
            item.addEventListener('mouseleave', () => {
                text.style.color = '';
                text.style.transform = '';
            });
        }
    });

    // ==================== EVENT LISTENERS ====================
    // Wave Parallax Effect
    window.addEventListener('scroll', function() {
        const scrollY = window.scrollY;
        
        document.querySelectorAll('.blue-wave-element').forEach((wave, index) => {
            wave.style.transform = `translateY(${scrollY * (0.15 + index * 0.03)}px)`;
        });
        
        document.querySelectorAll('.grey-wave-element').forEach((wave, index) => {
            wave.style.transform = `translateY(${scrollY * (0.08 + index * 0.02)}px)`;
        });
    });

    // Login Button Hover Effect
    if (loginButton) {
        loginButton.addEventListener('mouseenter', () => {
            loginButton.style.transform = 'translateY(-3px)';
            loginButton.style.boxShadow = '0 10px 20px rgba(31, 163, 253, 0.3)';
        });
        
        loginButton.addEventListener('mouseleave', () => {
            loginButton.style.transform = '';
            loginButton.style.boxShadow = '';
        });
    }

    // Trigger animations for elements already in viewport
    animatableElements.forEach(el => {
        const rect = el.getBoundingClientRect();
        if (rect.top < window.innerHeight) {
            el.classList.add('show');
        }
    });

    textElements.forEach(text => {
        const rect = text.getBoundingClientRect();
        if (rect.top < window.innerHeight) {
            text.classList.add('show');
        }
    });
});
// Membuat div navigasi bisa diklik
document.querySelectorAll('.frame-20 .frame-21').forEach(button => {
    button.addEventListener('click', function() {
        const text = this.querySelector('.text-wrapper-8').textContent.toLowerCase();
        
        // Sesuaikan dengan kebutuhan Anda
        if(text === 'about') {
            window.location.href = '/about';
        } else if(text === 'f.a.q') {
            window.location.href = '/faq';
        } else if(text === 'contact') {
            window.location.href = '/contact';
        }
    });
    
    // Tambahkan efek keyboard accessibility
    button.addEventListener('keydown', function(e) {
        if(e.key === 'Enter' || e.key === ' ') {
            this.click();
        }
    });
    
    // Untuk accessibility
    button.setAttribute('role', 'button');
    button.setAttribute('tabindex', '0');
});