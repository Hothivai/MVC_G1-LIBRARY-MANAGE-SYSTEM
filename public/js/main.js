/* Main JavaScript */

document.addEventListener('DOMContentLoaded', function() {
    console.log('Library Management System loaded');
    
    // Initialize tooltips, popovers, etc.
});

// Helper functions
function showAlert(message, type = 'info') {
    alert(`[${type.toUpperCase()}] ${message}`);
}

function showConfirmation(message, callback) {
    if (confirm(message)) {
        callback();
    }
}
