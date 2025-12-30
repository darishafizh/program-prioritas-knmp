/**
 * KKP Theme - Application Scripts
 * Handles Bootstrap components, theme utilities, and UI interactions
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    // Initialize all Bootstrap components
    initBootstrapComponents();
    
    // Initialize dropdown menus
    initDropdowns();
    
    // Initialize mobile navigation
    initMobileNav();
    
    // Initialize password toggle
    initPasswordToggle();
    
    // Initialize rightbar/sidebar toggle
    initRightbar();
});

/**
 * Initialize Bootstrap Components
 */
function initBootstrapComponents() {
    // Tooltips
    var tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipTriggerList.forEach(function(el) {
        try {
            if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                var instance = bootstrap.Tooltip.getInstance(el);
                if (instance) instance.dispose();
                new bootstrap.Tooltip(el, { container: 'body', trigger: 'hover' });
            }
        } catch (e) {
            console.warn('Tooltip init skipped:', e);
        }
    });

    // Popovers
    var popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
    popoverTriggerList.forEach(function(el) {
        try {
            if (typeof bootstrap !== 'undefined' && bootstrap.Popover) {
                var instance = bootstrap.Popover.getInstance(el);
                if (instance) instance.dispose();
                new bootstrap.Popover(el, { container: 'body', trigger: 'focus' });
            }
        } catch (e) {
            console.warn('Popover init skipped:', e);
        }
    });

    // Offcanvas
    document.querySelectorAll('.offcanvas').forEach(function(el) {
        try {
            if (typeof bootstrap !== 'undefined' && bootstrap.Offcanvas) {
                var instance = bootstrap.Offcanvas.getInstance(el);
                if (!instance) new bootstrap.Offcanvas(el);
            }
        } catch (e) {
            console.warn('Offcanvas init skipped:', e);
        }
    });

    // Alert dismissal
    document.querySelectorAll('.btn-close').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var alert = this.closest('.alert');
            if (alert) {
                alert.style.opacity = '0';
                setTimeout(function() { alert.remove(); }, 150);
            }
        });
    });
}

/**
 * Initialize Dropdowns
 */
function initDropdowns() {
    // Toggle dropdown on click
    document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(function(toggle) {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            var menu = this.nextElementSibling;
            if (!menu || !menu.classList.contains('dropdown-menu')) {
                menu = this.parentElement.querySelector('.dropdown-menu');
            }
            
            if (menu) {
                // Close other open dropdowns
                document.querySelectorAll('.dropdown-menu.show').forEach(function(m) {
                    if (m !== menu) m.classList.remove('show');
                });
                
                menu.classList.toggle('show');
            }
        });
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-menu.show').forEach(function(menu) {
                menu.classList.remove('show');
            });
        }
    });
}

/**
 * Initialize Mobile Navigation
 */
function initMobileNav() {
    var toggler = document.querySelector('.navbar-toggler');
    var collapse = document.querySelector('.navbar-collapse');
    
    if (toggler && collapse) {
        toggler.addEventListener('click', function() {
            collapse.classList.toggle('show');
        });
    }
}

/**
 * Initialize Password Toggle
 */
function initPasswordToggle() {
    document.querySelectorAll('.input-group-merge .input-group-text').forEach(function(toggle) {
        toggle.addEventListener('click', function() {
            var input = this.parentElement.querySelector('input');
            if (input) {
                if (input.type === 'password') {
                    input.type = 'text';
                    this.setAttribute('data-password', 'true');
                } else {
                    input.type = 'password';
                    this.setAttribute('data-password', 'false');
                }
            }
        });
    });
}

/**
 * Initialize Rightbar/Settings Panel
 */
function initRightbar() {
    var toggle = document.querySelector('.end-bar-toggle');
    var rightbar = document.querySelector('.end-bar, .offcanvas-end');
    var overlay = document.querySelector('.rightbar-overlay');
    
    if (toggle && rightbar) {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            rightbar.classList.toggle('show');
            if (overlay) overlay.style.display = rightbar.classList.contains('show') ? 'block' : 'none';
        });
    }
    
    if (overlay) {
        overlay.addEventListener('click', function() {
            if (rightbar) rightbar.classList.remove('show');
            this.style.display = 'none';
        });
    }
}

/**
 * Utility: Show loading state on button
 */
function showButtonLoading(btn, text) {
    btn.disabled = true;
    btn.dataset.originalText = btn.innerHTML;
    btn.innerHTML = '<span class="spinner"></span> ' + (text || 'Loading...');
}

/**
 * Utility: Hide loading state on button
 */
function hideButtonLoading(btn) {
    btn.disabled = false;
    if (btn.dataset.originalText) {
        btn.innerHTML = btn.dataset.originalText;
    }
}

/**
 * Utility: Format number with thousands separator
 */
function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

// Remove loading class from body
window.addEventListener('load', function() {
    document.body.classList.remove('loading');
});
