document.addEventListener('DOMContentLoaded', function() {
    console.log("QTA Bimbel: Script kustom dimuat.");

    // Fungsi Reusable untuk Toggle Password
    function setupPasswordToggle(buttonId, inputId, iconId) {
        const toggleButton = document.getElementById(buttonId);
        const passwordInput = document.getElementById(inputId);
        const eyeIcon = document.getElementById(iconId);

        if (toggleButton && passwordInput && eyeIcon) {
            toggleButton.addEventListener('click', function(e) {
                e.preventDefault(); 
                
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                if (type === 'text') {
                    eyeIcon.classList.remove('fa-eye-slash'); 
                    eyeIcon.classList.add('fa-eye'); 
                } else {
                    eyeIcon.classList.remove('fa-eye');
                    eyeIcon.classList.add('fa-eye-slash');
                }
            });
        }
    }

    // ----------------------------------------------------
    // 1. SMOOTH SCROLLING
    // ----------------------------------------------------
    const anchorLinks = document.querySelectorAll('a[href^="#"]');

    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();

            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);

            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth'
                });

                if (history.pushState) {
                    history.pushState(null, null, targetId);
                } else {
                    location.hash = targetId;
                }
            }
        });
    });

    const elementsToAnimate = document.querySelectorAll('.animate-on-scroll');
    const observerOptions = {
        threshold: 0.1, 
        rootMargin: '0px 0px -50px 0px' 
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    elementsToAnimate.forEach((element, index) => {
        const delay = element.dataset.delay || index * 100; 
        
        if (element.parentElement && element.parentElement.classList.contains('row')) {
            element.style.transitionDelay = `${index * 0.1}s`;
        } else {
            element.style.transitionDelay = `${delay}ms`;
        }
        
        observer.observe(element);
    });

    setupPasswordToggle('togglePassword', 'password_input', 'eyeIcon');

    setupPasswordToggle('togglePasswordLogin', 'password_login_input', 'eyeIconLogin');

});