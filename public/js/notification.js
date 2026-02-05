/* Notification JavaScript */

// function showNotification(title, message, type = 'info') {
//     // Display notification to user
//     const notification = document.createElement('div');
//     notification.className = `notification notification-${type}`;
//     notification.innerHTML = `
//         <div class="notification-content">
//             <h4>${title}</h4>
//             <p>${message}</p>
//         </div>
//     `;
//     document.body.appendChild(notification);
    
//     // Auto-remove after 5 seconds
//     setTimeout(() => {
//         notification.remove();
//     }, 5000);
// }

function markNotificationAsRead(notificationId) {
    // Mark notification as read
    fetch(`/api/notifications/${notificationId}/read`, {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        console.log('Notification marked as read');
    })
    .catch(error => console.error('Error:', error));
}
document.addEventListener('DOMContentLoaded', function () {
    const badge = document.querySelector('.notification-badge');
    if (badge && badge.innerText === '0') {
        badge.style.display = 'none';
    }
});
