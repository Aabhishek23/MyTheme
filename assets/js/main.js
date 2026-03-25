document.addEventListener('DOMContentLoaded', () => {
    // Reveal animations on scroll
    const reveals = document.querySelectorAll('.reveal');
    
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
                revealObserver.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1
    });

    reveals.forEach(reveal => {
        revealObserver.observe(reveal);
    });

    // Header scroll effect
    const header = document.querySelector('.main-header');
    if (header) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    }

    // Slider Drag/Scroll Logic (Optional Enhancement)
    const slider = document.querySelector('.slider-container');
    if (slider) {
        let isDown = false;
        let startX;
        let scrollLeft;

        slider.addEventListener('mousedown', (e) => {
            isDown = true;
            slider.classList.add('active');
            startX = e.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
        });
        slider.addEventListener('mouseleave', () => {
            isDown = false;
            slider.classList.remove('active');
        });
        slider.addEventListener('mouseup', () => {
            isDown = false;
            slider.classList.remove('active');
        });
        slider.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - slider.offsetLeft;
            const walk = (x - startX) * 2;
            slider.scrollLeft = scrollLeft - walk;
        });
    }

    // Hero Slider Logic
    const slides = document.querySelectorAll('.hero-slide');
    const navItems = document.querySelectorAll('.nav-slide-item');
    let currentSlide = 0;
    let slideInterval;
    const intervalTime = 6000; // 6 seconds

    function showSlide(index) {
        // Remove active class from all slides and nav items
        slides.forEach(slide => slide.classList.remove('active'));
        navItems.forEach(item => item.classList.remove('active'));

        // Add active class to target slide and nav item
        slides[index].classList.add('active');
        navItems[index].classList.add('active');
        currentSlide = index;
        
        // Reset and restart interval
        clearInterval(slideInterval);
        startSlideTimer();
    }

    function startSlideTimer() {
        slideInterval = setInterval(() => {
            let nextSlide = (currentSlide + 1) % slides.length;
            showSlide(nextSlide);
        }, intervalTime);
    }

    if (slides.length > 0) {
        // Initial start
        startSlideTimer();

        // Nav item clicks
        navItems.forEach((item, index) => {
            item.addEventListener('click', () => {
                showSlide(index);
            });
        });
    }

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

    // Mega Menu Controller (Automatic wide-menu for all sub-items + Interaction Logic)
    const initAdvancedMenus = () => {
        // ONLY target top-level items! Selecting sub-items causes nested hover conflicts.
        const topNavItems = document.querySelectorAll('.nav-menu > li');
        
        topNavItems.forEach(item => {
            const subMenu = item.querySelector('.sub-menu, .mega-menu');
            if (subMenu) {
                // Determine if this should be a Mega Menu
                // 1. If it already has the .mega class from WordPress Admin
                // 2. OR If it has grandchildren
                const hasGrandchildren = subMenu.querySelector('li .sub-menu, li ul');

                if (item.classList.contains('mega') || hasGrandchildren) {
                    item.classList.add('mega');
                    item.style.position = 'static';
                    subMenu.style.display = 'flex';
                    subMenu.style.width = 'max-content';
                    subMenu.style.maxWidth = '92vw';
                }

                // --- Interaction Logic: Pure Hover ---

                // Hover: Add class on enter
                item.addEventListener('mouseenter', () => {
                    // Clear the timeout for this specific item if it exists
                    if (item.hoverCloseTimeout) {
                        clearTimeout(item.hoverCloseTimeout);
                        item.hoverCloseTimeout = null;
                    }

                    // Close others immediately
                    document.querySelectorAll('.nav-menu > li.is-open').forEach(openItem => {
                        if (openItem !== item) {
                            openItem.classList.remove('is-open');
                            if (openItem.hoverCloseTimeout) {
                                clearTimeout(openItem.hoverCloseTimeout);
                                openItem.hoverCloseTimeout = null;
                            }
                        }
                    });
                    
                    item.classList.add('is-open');
                    
                    // Dynamically position the caret to align under hovered item text
                    if (item.classList.contains('mega')) {
                        // Request animation frame ensures the element's positioning has updated in DOM before reading rects
                        requestAnimationFrame(() => {
                            const itemRect = item.getBoundingClientRect();
                            const subRect = subMenu.getBoundingClientRect();
                            // If the mega menu has an active transition, the subRect position might be slightly off.
                            // But since the mega menu is simply centered and opacity transitioned, rect should be stable.
                            const caretPos = (itemRect.left + itemRect.width / 2) - subRect.left - 6; // -6 for half of 12px caret width
                            
                            // Prevent negative or miscalculated values if it goes off edge
                            if (caretPos > 10) {
                                subMenu.style.setProperty('--caret-pos', `${caretPos}px`);
                            }
                        });
                    }
                });

                // Hover: Remove class with a slight delay on leave
                item.addEventListener('mouseleave', () => {
                    // Small delay so the user has time to move their mouse from the menu item to the dropdown content
                    item.hoverCloseTimeout = setTimeout(() => {
                        item.classList.remove('is-open');
                        item.hoverCloseTimeout = null;
                    }, 300); // 300ms delay provides a smooth bridging gap
                });
            }
        });

        // Close when clicking outside (fallback for touch devices)
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.nav-menu')) {
                document.querySelectorAll('.nav-menu > li.is-open').forEach(item => {
                    item.classList.remove('is-open');
                });
            }
        });
    };

    initAdvancedMenus();
});
