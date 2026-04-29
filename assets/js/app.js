/**
 * GAINS 2026 App - Main JavaScript
 * Initialize Lucide Icons and handle active navigation
 */

document.addEventListener('DOMContentLoaded', function () {
    // Initialize Lucide Icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Set current year in footer
    const yearElement = document.getElementById('current-year');
    if (yearElement) {
        yearElement.textContent = new Date().getFullYear();
    }

    // Update active nav link based on current URL
    updateActiveNav();

    // Set click handler untuk instant active state
    setupNavClickHandlers();
});

/**
 * Update active navigation link based on current URL
 */
function updateActiveNav() {
    const currentPath = window.location.pathname;

    // Determine current page from URL
    let currentPage = 'home'; // default

    if (currentPath.includes('/about')) {
        currentPage = 'about';
    } else if (currentPath.includes('/competitions/irpc')) {
        currentPage = 'irpc';
    } else if (currentPath.includes('/competitions/bppa')) {
        currentPage = 'bppa';
    } else if (currentPath.includes('/competitions/ahic')) {
        currentPage = 'ahic';
    } else if (currentPath.includes('/competitions/e2ipbc')) {
        currentPage = 'e2ipbc';
    } else if (currentPath.includes('/timeline')) {
        currentPage = 'timeline';
    } else if (currentPath.includes('/reviewers')) {
        currentPage = 'reviewers';
    } else if (currentPath.includes('/auth')) {
        currentPage = 'auth';
    } else if (currentPath.includes('/dashboard')) {
        currentPage = 'dashboard';
    } else if (currentPath.includes('/home')) {
        currentPage = 'home';
    }

    // Remove active from all nav links
    document.querySelectorAll('a[data-page]').forEach(link => {
        link.classList.remove('active');
    });

    // Add active to matching link
    const activeLink = document.querySelector(`a[data-page="${currentPage}"]`);
    if (activeLink) {
        activeLink.classList.add('active');
    }
}

/**
 * Setup click handlers for nav links
 */
function setupNavClickHandlers() {
    document.querySelectorAll('a[data-page]').forEach(link => {
        link.addEventListener('click', function (e) {
            // Remove active from all
            document.querySelectorAll('a[data-page]').forEach(l => {
                l.classList.remove('active');
            });
            // Add active to clicked
            this.classList.add('active');
        });
    });
}

/**
 * Utility: Close dropdown menus when clicking outside
 */
document.addEventListener('click', function (event) {
    if (!event.target.closest('.dropdown')) {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            // Dropdown handling if needed
        });
    }
});
