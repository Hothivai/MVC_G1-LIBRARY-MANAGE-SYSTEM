/**
 * Main JavaScript for Library Management System
 */

// Wait for DOM to load
document.addEventListener("DOMContentLoaded", function () {
  // Auto-hide alerts after 5 seconds
  const alerts = document.querySelectorAll(".alert");
  alerts.forEach((alert) => {
    setTimeout(() => {
      alert.style.transition = "opacity 0.5s";
      alert.style.opacity = "0";
      setTimeout(() => alert.remove(), 500);
    }, 5000);
  });

  // Confirm delete actions
  const deleteButtons = document.querySelectorAll(".btn-delete, .delete-btn");
  deleteButtons.forEach((button) => {
    button.addEventListener("click", function (e) {
      if (
        !confirm(
          "Are you sure you want to delete this item? This action cannot be undone."
        )
      ) {
        e.preventDefault();
      }
    });
  });

  // Form validation example
  const forms = document.querySelectorAll("form[data-validate]");
  forms.forEach((form) => {
    form.addEventListener("submit", function (e) {
      const requiredFields = form.querySelectorAll("[required]");
      let isValid = true;

      requiredFields.forEach((field) => {
        if (!field.value.trim()) {
          isValid = false;
          field.style.borderColor = "#e74c3c";
        } else {
          field.style.borderColor = "#bdc3c7";
        }
      });

      if (!isValid) {
        e.preventDefault();
        alert("Please fill in all required fields.");
      }
    });
  });

  // Search functionality (if search input exists)
  const searchInput = document.getElementById("search");
  if (searchInput) {
    searchInput.addEventListener("input", function (e) {
      const searchTerm = e.target.value.toLowerCase();
      const tableRows = document.querySelectorAll("tbody tr");

      tableRows.forEach((row) => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? "" : "none";
      });
    });
  }

  // Active navigation highlighting
  const currentPath = window.location.pathname;
  const navLinks = document.querySelectorAll("nav a");
  navLinks.forEach((link) => {
    if (
      link.getAttribute("href") === currentPath ||
      (currentPath.includes(link.getAttribute("href")) &&
        link.getAttribute("href") !== "/")
    ) {
      link.classList.add("active");
    }
  });
});

/**
 * Show confirmation dialog
 * @param {string} message - Message to display
 * @returns {boolean}
 */
function confirmAction(message) {
  return confirm(message || "Are you sure you want to proceed?");
}

/**
 * Display a notification
 * @param {string} message - Message to display
 * @param {string} type - Type of alert (success, error, info, warning)
 */
function showNotification(message, type = "info") {
  const alert = document.createElement("div");
  alert.className = `alert alert-${type}`;
  alert.textContent = message;

  const main = document.querySelector("main .container");
  if (main) {
    main.insertBefore(alert, main.firstChild);

    // Auto-hide after 5 seconds
    setTimeout(() => {
      alert.style.transition = "opacity 0.5s";
      alert.style.opacity = "0";
      setTimeout(() => alert.remove(), 500);
    }, 5000);
  }
}
