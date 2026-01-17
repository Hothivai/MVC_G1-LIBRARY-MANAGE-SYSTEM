// Book-specific JavaScript

document.addEventListener('DOMContentLoaded', function() {
    
    // Book availability check
    checkBookAvailability();
    
    // Copy ISBN to clipboard
    setupCopyISBN();
    
    // Share book functionality
    setupShareBook();
    
    // Preview book description
    setupDescriptionPreview();
    
    // Related books carousel
    setupRelatedBooksCarousel();
    
    // Reading progress (for logged-in users)
    setupReadingProgress();
});

// Check real-time book availability
function checkBookAvailability() {
    const availabilityBadge = document.querySelector('.availability-badge');
    if (!availabilityBadge) return;
    
    const bookId = availabilityBadge.dataset.bookId;
    if (!bookId) return;
    
    // Check availability every 30 seconds
    setInterval(() => {
        fetch(`${BASE_URL}api/books/${bookId}/availability`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateAvailabilityBadge(availabilityBadge, data.available_copies);
                }
            })
            .catch(error => console.error('Availability check error:', error));
    }, 30000);
}

function updateAvailabilityBadge(badgeElement, availableCopies) {
    const badge = badgeElement.querySelector('.badge');
    const borrowButton = document.querySelector('.borrow-btn');
    
    if (availableCopies > 0) {
        badge.className = 'badge bg-success p-2';
        badge.innerHTML = `<i class="fas fa-check-circle"></i> Available (${availableCopies} copies)`;
        
        if (borrowButton) {
            borrowButton.disabled = false;
            borrowButton.innerHTML = '<i class="fas fa-book-reader"></i> Borrow This Book';
        }
    } else {
        badge.className = 'badge bg-danger p-2';
        badge.innerHTML = '<i class="fas fa-times-circle"></i> Currently Unavailable';
        
        if (borrowButton) {
            borrowButton.disabled = true;
            borrowButton.innerHTML = '<i class="fas fa-clock"></i> Notify When Available';
        }
    }
}

// Copy ISBN to clipboard
function setupCopyISBN() {
    const copyISBNBtn = document.getElementById('copyISBN');
    if (!copyISBNBtn) return;
    
    copyISBNBtn.addEventListener('click', function() {
        const isbn = this.dataset.isbn;
        
        navigator.clipboard.writeText(isbn)
            .then(() => {
                const originalHTML = this.innerHTML;
                this.innerHTML = '<i class="fas fa-check"></i> Copied!';
                
                setTimeout(() => {
                    this.innerHTML = originalHTML;
                }, 2000);
                
                showToast('ISBN copied to clipboard', 'success');
            })
            .catch(err => {
                console.error('Copy failed:', err);
                showToast('Failed to copy ISBN', 'error');
            });
    });
}

// Share book functionality
function setupShareBook() {
    const shareBtn = document.getElementById('shareBook');
    if (!shareBtn) return;
    
    shareBtn.addEventListener('click', function() {
        const bookTitle = encodeURIComponent(document.querySelector('.book-title').textContent);
        const bookUrl = window.location.href;
        const bookAuthor = encodeURIComponent(document.querySelector('.book-author').textContent);
        
        const shareText = `Check out "${bookTitle}" by ${bookAuthor} at our library!`;
        
        if (navigator.share) {
            navigator.share({
                title: bookTitle,
                text: shareText,
                url: bookUrl
            })
            .catch(error => console.log('Sharing cancelled:', error));
        } else {
            // Fallback: copy to clipboard
            navigator.clipboard.writeText(`${shareText}\n\n${bookUrl}`)
                .then(() => showToast('Link copied to clipboard!', 'success'))
                .catch(err => showToast('Failed to share', 'error'));
        }
    });
}

// Preview book description (show more/less)
function setupDescriptionPreview() {
    const descriptionElement = document.querySelector('.book-description');
    if (!descriptionElement) return;
    
    const fullDescription = descriptionElement.textContent;
    const maxLength = 300;
    
    if (fullDescription.length > maxLength) {
        const shortDescription = fullDescription.substring(0, maxLength) + '...';
        const readMoreBtn = document.createElement('button');
        
        descriptionElement.textContent = shortDescription;
        readMoreBtn.className = 'btn btn-link p-0';
        readMoreBtn.textContent = 'Read more';
        readMoreBtn.style.fontSize = '0.9rem';
        
        readMoreBtn.addEventListener('click', function() {
            if (descriptionElement.textContent.length <= maxLength + 10) {
                descriptionElement.textContent = fullDescription;
                this.textContent = 'Show less';
            } else {
                descriptionElement.textContent = shortDescription;
                this.textContent = 'Read more';
            }
        });
        
        descriptionElement.parentNode.appendChild(readMoreBtn);
    }
}

// Related books carousel
function setupRelatedBooksCarousel() {
    const relatedBooksContainer = document.querySelector('.related-books-carousel');
    if (!relatedBooksContainer) return;
    
    const carousel = new bootstrap.Carousel(relatedBooksContainer, {
        interval: 5000,
        wrap: true
    });
    
    // Pause on hover
    relatedBooksContainer.addEventListener('mouseenter', () => {
        carousel.pause();
    });
    
    relatedBooksContainer.addEventListener('mouseleave', () => {
        carousel.cycle();
    });
}

// Reading progress tracking
function setupReadingProgress() {
    const readingProgressBtn = document.getElementById('trackReading');
    if (!readingProgressBtn || !isUserLoggedIn()) return;
    
    readingProgressBtn.addEventListener('click', function() {
        const bookId = this.dataset.bookId;
        const modal = new bootstrap.Modal(document.getElementById('readingProgressModal'));
        
        // Load current progress if exists
        fetch(`${BASE_URL}api/reading-progress/${bookId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('currentPage').value = data.current_page || '';
                    document.getElementById('totalPages').value = data.total_pages || '';
                    document.getElementById('progressPercentage').value = data.percentage || 0;
                    updateProgressDisplay(data.percentage);
                }
            })
            .catch(error => console.error('Load progress error:', error));
        
        modal.show();
    });
    
    // Update progress display
    const progressInput = document.getElementById('progressPercentage');
    if (progressInput) {
        progressInput.addEventListener('input', function() {
            updateProgressDisplay(this.value);
        });
    }
    
    // Save progress
    const saveProgressBtn = document.getElementById('saveProgress');
    if (saveProgressBtn) {
        saveProgressBtn.addEventListener('click', saveReadingProgress);
    }
}

function updateProgressDisplay(percentage) {
    const progressBar = document.querySelector('.progress-bar');
    const percentageText = document.querySelector('.progress-percentage');
    
    if (progressBar) {
        progressBar.style.width = `${percentage}%`;
        progressBar.textContent = `${percentage}%`;
    }
    
    if (percentageText) {
        percentageText.textContent = `${percentage}% Complete`;
    }
}

function saveReadingProgress() {
    const bookId = document.getElementById('trackReading')?.dataset.bookId;
    const currentPage = document.getElementById('currentPage').value;
    const totalPages = document.getElementById('totalPages').value;
    const percentage = document.getElementById('progressPercentage').value;
    
    const data = {
        book_id: bookId,
        current_page: currentPage,
        total_pages: totalPages,
        percentage: percentage
    };
    
    fetch(`${BASE_URL}api/reading-progress/save`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-Token': getCSRFToken()
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Reading progress saved!', 'success');
            bootstrap.Modal.getInstance(document.getElementById('readingProgressModal')).hide();
        } else {
            showToast(data.message || 'Save failed', 'error');
        }
    })
    .catch(error => {
        console.error('Save progress error:', error);
        showToast('An error occurred', 'error');
    });
}

// Keyboard shortcuts for book pages
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + F to focus search
    if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
        e.preventDefault();
        const searchInput = document.querySelector('input[name="keyword"]');
        if (searchInput) {
            searchInput.focus();
        }
    }
    
    // Escape to clear search
    if (e.key === 'Escape') {
        const searchInput = document.querySelector('input[name="keyword"]');
        if (searchInput && document.activeElement === searchInput) {
            searchInput.value = '';
            searchInput.blur();
        }
    }
});