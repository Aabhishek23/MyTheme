document.addEventListener('DOMContentLoaded', () => {
    // --- Mobile Drawer Controller (Highest Priority) ---
    // --- Mobile Drawer Controller (Highest Priority) ---
    const mobileBtn = document.getElementById('mobileMenuBtn');
    const closeBtn = document.getElementById('mobileCloseBtn');
    const siteNav = document.getElementById('siteNav');
    const overlay = document.getElementById('mobileOverlay');

    const openMenu = () => {
        if (!siteNav || !overlay) return;
        siteNav.classList.add('mobile-open');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden'; // Prevent scroll
    };

    const closeMenu = () => {
        if (!siteNav || !overlay) return;
        siteNav.classList.remove('mobile-open');
        overlay.classList.remove('active');
        document.body.style.overflow = ''; // Restore scroll
    };

    const initMobileMenu = () => {
        if (!mobileBtn || !siteNav || !overlay) return;

        mobileBtn.addEventListener('click', (e) => {
            e.preventDefault();
            openMenu();
        });
        if (closeBtn) closeBtn.addEventListener('click', closeMenu);
        overlay.addEventListener('click', closeMenu);
    };

    initMobileMenu();

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
            const href = this.getAttribute('href');
            if (href === '#') return; // Do nothing for empty hash links
            
            e.preventDefault();
            try {
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            } catch (err) {
                console.warn('Invalid selector:', href);
            }
        });
    });

    // Mega Menu Controller (Automatic wide-menu for all sub-items + Interaction Logic)
    const initAdvancedMenus = () => {
        // Target all items with children for mobile toggling (Robust detection)
        const allNavItems = document.querySelectorAll('.nav-menu li');
        const allNavItemsWithChildren = Array.from(allNavItems).filter(item => {
            return item.classList.contains('menu-item-has-children') || item.querySelector('ul');
        });

        const topNavItems = document.querySelectorAll('.nav-menu > li');
        
        // 1. Desktop Mega Menu Logic (Top-level only)
        topNavItems.forEach(item => {
            const subMenu = item.querySelector('.sub-menu, .mega-menu');
            if (subMenu) {
                const hasGrandchildren = subMenu.querySelector('li .sub-menu, li ul');
                if (item.classList.contains('mega') || hasGrandchildren) {
                    item.classList.add('mega');
                    if (window.innerWidth > 1024) {
                        item.style.position = 'static';
                        subMenu.style.display = 'flex';
                        subMenu.style.width = 'max-content';
                        subMenu.style.maxWidth = '92vw';
                    }
                }

                // Hover Logic (Desktop Only)
                item.addEventListener('mouseenter', () => {
                    if (window.innerWidth > 1024) {
                        if (item.hoverCloseTimeout) {
                            clearTimeout(item.hoverCloseTimeout);
                            item.hoverCloseTimeout = null;
                        }
                        document.querySelectorAll('.nav-menu > li.is-open').forEach(openItem => {
                            if (openItem !== item) {
                                openItem.classList.remove('is-open');
                            }
                        });
                        item.classList.add('is-open');
                        if (item.classList.contains('mega')) {
                            requestAnimationFrame(() => {
                                const itemRect = item.getBoundingClientRect();
                                const subRect = subMenu.getBoundingClientRect();
                                const caretPos = (itemRect.left + itemRect.width / 2) - subRect.left - 6;
                                if (caretPos > 10) {
                                    subMenu.style.setProperty('--caret-pos', `${caretPos}px`);
                                }
                            });
                        }
                    }
                });

                item.addEventListener('mouseleave', () => {
                    if (window.innerWidth > 1024) {
                        item.hoverCloseTimeout = setTimeout(() => {
                            item.classList.remove('is-open');
                            item.hoverCloseTimeout = null;
                        }, 300);
                    }
                });
            }
        });

        // 2. Mobile/Touch Click Logic (All levels)
        allNavItemsWithChildren.forEach(item => {
            // Attach the listener to the LI itself to catch clicks on text nodes, spans, or links
            item.addEventListener('click', (e) => {
                if (window.innerWidth <= 1024) {
                    const subMenu = item.querySelector(':scope > ul, :scope > .sub-menu');
                    if (!subMenu) return;

                    // If the user clicked a link inside the sub-menu, let it navigate
                    if (subMenu.contains(e.target) && e.target.closest('a')) {
                        const link = e.target.closest('a');
                        const href = link.getAttribute('href');
                        if (href && href !== '#') {
                            e.preventDefault();
                            e.stopPropagation();
                            closeMenu();
                            window.location.href = href;
                            return; 
                        }
                    }

                    // Otherwise, if they clicked the toggle area of this LI
                    e.preventDefault();
                    e.stopPropagation();

                    const isOpen = item.classList.contains('is-open');
                    
                    // Toggle this specific item
                    if (!isOpen) {
                        // Close siblings at the same level
                        const siblings = item.parentElement.querySelectorAll(':scope > li.is-open');
                        siblings.forEach(sib => sib.classList.remove('is-open'));
                        item.classList.add('is-open');
                    } else {
                        item.classList.remove('is-open');
                    }
                }
            });
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

    // --- News Carousel Script ---
    const initNewsCarousel = () => {
        const carousel = document.querySelector('.news-carousel');
        const btnPrev = document.querySelector('.news-prev');
        const btnNext = document.querySelector('.news-next');

        if (!carousel || !btnPrev || !btnNext) return;

        btnNext.addEventListener('click', () => {
            const cardWidth = carousel.querySelector('.news-card').offsetWidth;
            const gap = parseFloat(getComputedStyle(carousel).gap) || 0;
            carousel.scrollBy({ left: cardWidth + gap, behavior: 'smooth' });
        });

        btnPrev.addEventListener('click', () => {
            const cardWidth = carousel.querySelector('.news-card').offsetWidth;
            const gap = parseFloat(getComputedStyle(carousel).gap) || 0;
            carousel.scrollBy({ left: -(cardWidth + gap), behavior: 'smooth' });
        });
    };

    initNewsCarousel();

    // --- User Menu Dropdown (Desktop/Mobile) ---
    const initUserMenu = () => {
        const userBtn = document.getElementById('userMenuToggle');
        const userDropdown = document.getElementById('userDropdown');
        
        if (userBtn && userDropdown) {
            userBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                userDropdown.classList.toggle('open');
            });

            document.addEventListener('click', () => {
                userDropdown.classList.remove('open');
            });
        }
    };

    initUserMenu();
});
