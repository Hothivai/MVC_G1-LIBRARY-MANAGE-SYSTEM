/* User JavaScript */

document.addEventListener('DOMContentLoaded', function() {
    // User-specific functionality
    console.log('User page loaded');
});

// Functions for user interactions
function borrowBook(bookId) {
    showConfirmation(`Are you sure you want to borrow this book?`, function() {
        // Handle borrow request
    });
}

function returnBook(bookId) {
    showConfirmation(`Are you sure you want to return this book?`, function() {
        // Handle return request
    });
}
