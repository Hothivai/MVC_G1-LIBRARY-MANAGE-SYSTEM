// Main JavaScript
$(document).ready(function() {
    // Auto-hide alerts
    $('.alert').delay(5000).fadeOut(400);
    
    // Confirm actions
    $('.confirm-action').on('click', function(e) {
        if (!confirm($(this).data('confirm') || 'Bạn có chắc chắn muốn thực hiện hành động này?')) {
            e.preventDefault();
        }
    });
    
    // Form validation
    $('form').submit(function() {
        var $submitBtn = $(this).find('button[type="submit"]');
        $submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Đang xử lý...');
    });
    
    // Tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Back to top button
    var $backToTop = $('<button class="btn btn-primary back-to-top"><i class="fa fa-chevron-up"></i></button>');
    $('body').append($backToTop);
    
    $backToTop.hide().click(function() {
        $('html, body').animate({scrollTop: 0}, 300);
    });
    
    $(window).scroll(function() {
        if ($(this).scrollTop() > 300) {
            $backToTop.fadeIn();
        } else {
            $backToTop.fadeOut();
        }
    });
    
    // Book search autocomplete
    $('.book-search').typeahead({
        source: function(query, process) {
            return $.get('/api/books/autocomplete?q=' + query, function(data) {
                return process(data);
            });
        },
        minLength: 2
    });
    
    // Image error handling
    $('img').on('error', function() {
        if (!$(this).hasClass('no-fallback')) {
            $(this).attr('src', '/images/books/default.jpg');
        }
    });
    
    // Modal handling
    $('.modal').on('shown.bs.modal', function() {
        $(this).find('input[type="text"]:first').focus();
    });
    
    // Smooth scrolling for anchor links
    $('a[href^="#"]').on('click', function(e) {
        var target = $(this.getAttribute('href'));
        if (target.length) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top - 70
            }, 1000);
        }
    });
});

// Utility functions
function formatDate(dateString) {
    var date = new Date(dateString);
    return date.toLocaleDateString('vi-VN');
}

function showToast(message, type = 'info') {
    var toast = $('<div class="toast-alert alert alert-' + type + '">' + message + '</div>');
    $('body').append(toast);
    
    toast.css({
        position: 'fixed',
        top: '20px',
        right: '20px',
        zIndex: 9999,
        minWidth: '300px'
    });
    
    setTimeout(function() {
        toast.fadeOut(400, function() {
            $(this).remove();
        });
    }, 5000);
}

// AJAX helper
function ajaxRequest(url, method, data, successCallback, errorCallback) {
    $.ajax({
        url: url,
        method: method,
        data: data,
        dataType: 'json',
        success: successCallback,
        error: function(xhr, status, error) {
            if (errorCallback) errorCallback(xhr);
            else showToast('Có lỗi xảy ra: ' + error, 'danger');
        }
    });
}