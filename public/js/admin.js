/* Admin JavaScript */

document.addEventListener('DOMContentLoaded', function() {
    // Admin-specific functionality
    console.log('Admin page loaded');
});

// Functions for admin interactions
function deleteItem(itemId, itemType) {
    showConfirmation(`Are you sure you want to delete this ${itemType}?`, function() {
        // Handle delete request
    });
}

function approveRequest(requestId) {
    showConfirmation(`Do you want to approve this request?`, function() {
        // Handle approval
    });
}

function rejectRequest(requestId) {
    showConfirmation(`Do you want to reject this request?`, function() {
        // Handle rejection
    });
}
