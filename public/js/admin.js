// Main JavaScript File
document.addEventListener('DOMContentLoaded', function() {
    
    // User menu dropdown
    const userMenuBtn = document.getElementById('user-menu-btn');
    const userDropdown = document.getElementById('user-dropdown');
    
    if (userMenuBtn && userDropdown) {
        userMenuBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdown.classList.toggle('show');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!userMenuBtn.contains(e.target) && !userDropdown.contains(e.target)) {
                userDropdown.classList.remove('show');
            }
        });
    }
    
    // Auto-search functionality
    const searchInput = document.getElementById('search-input');
    const searchResults = document.getElementById('search-results');
    const searchForm = document.getElementById('search-form');
    
    if (searchInput && searchResults && searchForm) {
        let searchTimeout;
        let currentSearchQuery = '';
        
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();
            
            if (query.length < 2) {
                hideSearchResults();
                return;
            }
            
            if (query === currentSearchQuery) return;
            currentSearchQuery = query;
            
            searchTimeout = setTimeout(() => {
                fetchSearchResults(query);
            }, 300);
        });
        
        // Close search results when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchForm.contains(e.target)) {
                hideSearchResults();
            }
        });
        
        // Handle search form submission
        searchForm.addEventListener('submit', function(e) {
            const query = searchInput.value.trim();
            if (!query) {
                e.preventDefault();
                searchInput.focus();
            }
        });
        
        // Handle Enter key in search
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && this.value.trim()) {
                hideSearchResults();
            }
        });
    }
    
    // Auto-hide alerts
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.remove();
                }
            }, 500);
        }, 5000);
    });
    
    // Book card hover effects
    const bookCards = document.querySelectorAll('.book-card');
    bookCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 8px 24px rgba(0, 0, 0, 0.15)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.1)';
        });
    });
    
    // Category card hover effects
    const categoryCards = document.querySelectorAll('.category-card');
    categoryCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 8px 24px rgba(0, 0, 0, 0.15)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.1)';
        });
    });
    
    // Notification button click
    const notificationBtn = document.getElementById('notification-btn');
    if (notificationBtn) {
        notificationBtn.addEventListener('click', function() {
            window.location.href = BASE_URL + '/notification';
        });
    }
    
    // Initialize tooltips
    const tooltips = document.querySelectorAll('[data-tooltip]');
    tooltips.forEach(element => {
        element.addEventListener('mouseenter', function() {
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = this.dataset.tooltip;
            document.body.appendChild(tooltip);
            
            const rect = this.getBoundingClientRect();
            tooltip.style.position = 'fixed';
            tooltip.style.left = rect.left + 'px';
            tooltip.style.top = (rect.top - tooltip.offsetHeight - 10) + 'px';
            
            this.tooltipElement = tooltip;
        });
        
        element.addEventListener('mouseleave', function() {
            if (this.tooltipElement) {
                this.tooltipElement.remove();
                this.tooltipElement = null;
            }
        });
    });
});

// Fetch search results for auto-suggest
function fetchSearchResults(query) {
    const searchResults = document.getElementById('search-results');
    
    if (!searchResults) return;
    
    fetch(`${BASE_URL}/api/books/search?q=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.results && data.results.length > 0) {
                updateSearchResults(data.results);
                showSearchResults();
            } else {
                hideSearchResults();
            }
        })
        .catch(error => {
            console.error('Search error:', error);
            hideSearchResults();
        });
}

// Update search results dropdown
function updateSearchResults(results) {
    const searchResults = document.getElementById('search-results');
    
    if (!searchResults) return;
    
    searchResults.innerHTML = results.map(book => `
        <a href="${book.url}" class="search-result-item">
            <div style="display: flex; gap: 12px; align-items: center;">
                <div style="width: 40px; height: 40px; background: #f0f0f0; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                    <span style="font-weight: bold; color: #666;">${book.title.charAt(0)}</span>
                </div>
                <div style="flex: 1;">
                    <div style="font-weight: 600; margin-bottom: 4px; color: #2c3e50;">${escapeHtml(book.title)}</div>
                    <div style="font-size: 0.875rem; color: #7f8c8d; margin-bottom: 4px;">
                        by ${escapeHtml(book.author)}
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.75rem;">
                        <span style="color: #3498db;">${escapeHtml(book.category)}</span>
                        <span style="color: ${book.available > 0 ? '#27ae60' : '#e74c3c'};">
                            ${book.available} available
                        </span>
                    </div>
                </div>
            </div>
        </a>
    `).join('');
}

// Show search results
function showSearchResults() {
    const searchResults = document.getElementById('search-results');
    if (searchResults) {
        searchResults.classList.add('show');
    }
}

// Hide search results
function hideSearchResults() {
    const searchResults = document.getElementById('search-results');
    if (searchResults) {
        searchResults.classList.remove('show');
    }
}

// Utility function to escape HTML
function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Add CSS for tooltips
const tooltipStyle = document.createElement('style');
tooltipStyle.textContent = `
    .tooltip {
        position: absolute;
        background: #2c3e50;
        color: white;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 0.875rem;
        z-index: 9999;
        white-space: nowrap;
        pointer-events: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }
    
    .tooltip:before {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        border: 6px solid transparent;
        border-top-color: #2c3e50;
    }
`;
document.head.appendChild(tooltipStyle);

// Global BASE_URL (defined in footer.php)
if (typeof BASE_URL === 'undefined') {
    console.warn('BASE_URL is not defined. Make sure it is set in the footer.php file.');
}

// Expose functions for other scripts
window.utils = {
    escapeHtml,
    fetchSearchResults,
    showSearchResults,
    hideSearchResults
};