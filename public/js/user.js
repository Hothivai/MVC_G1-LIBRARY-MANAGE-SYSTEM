/* User JavaScript */

document.addEventListener('DOMContentLoaded', function() {
    // User-specific functionality
    console.log('User page loaded');

    // Đóng modal khi click ra ngoài vùng modal-content
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('passwordModal');
        if (event.target == modal) {
            closePasswordModal();
        }
        
    });
});

// Các hàm tương tác cho Password Modal
function openPasswordModal() {
    const modal = document.getElementById('passwordModal');
    if (modal) {
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden'; // Ngăn cuộn trang khi mở modal
    }
}

function closePasswordModal() {
    const modal = document.getElementById('passwordModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto'; // Cho phép cuộn trang lại
    }
}

// Giữ nguyên các hàm cũ của bạn
function borrowBook(bookId) {
    showConfirmation(`Are you sure you want to borrow this book?`, function() {
        // Handle borrow request
    });
}