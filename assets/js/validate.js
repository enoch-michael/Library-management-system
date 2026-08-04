/**
 * Global site JS
 * -----------------
 * 1. Basic client-side form validation (any form with class "validate-form")
 * 2. Mobile sidebar toggle (hamburger menu on small screens)
 */

document.addEventListener("DOMContentLoaded", function () {

    // ---------- 1. Form validation ----------
    const forms = document.querySelectorAll(".validate-form");

    forms.forEach(function (form) {
        form.addEventListener("submit", function (e) {
            let isValid = true;

            form.querySelectorAll(".error").forEach(el => el.remove());

            form.querySelectorAll("[required]").forEach(function (field) {
                if (!field.value.trim()) {
                    isValid = false;
                    showError(field, "This field is required.");
                }
            });

            form.querySelectorAll('input[type="email"]').forEach(function (field) {
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (field.value.trim() && !emailPattern.test(field.value.trim())) {
                    isValid = false;
                    showError(field, "Enter a valid email address.");
                }
            });

            form.querySelectorAll('input[type="number"]').forEach(function (field) {
                if (field.value !== "" && Number(field.value) < 0) {
                    isValid = false;
                    showError(field, "Value cannot be negative.");
                }
            });

            if (!isValid) {
                e.preventDefault();
            }
        });
    });

    function showError(field, message) {
        const error = document.createElement("div");
        error.className = "error";
        error.textContent = message;
        field.insertAdjacentElement("afterend", error);
    }

    // ---------- 2. Mobile sidebar toggle ----------
    const sidebar = document.getElementById("sidebar");
    const toggleBtn = document.getElementById("sidebarToggle");
    const overlay = document.getElementById("sidebarOverlay");

    if (sidebar && toggleBtn && overlay) {
        function openSidebar() {
            sidebar.classList.add("open");
            overlay.classList.add("visible");
        }
        function closeSidebar() {
            sidebar.classList.remove("open");
            overlay.classList.remove("visible");
        }

        toggleBtn.addEventListener("click", function () {
            if (sidebar.classList.contains("open")) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });

        // Tapping the dark overlay closes the menu
        overlay.addEventListener("click", closeSidebar);

        // Close the menu automatically after tapping a nav link (mobile)
        sidebar.querySelectorAll("a").forEach(function (link) {
            link.addEventListener("click", closeSidebar);
        });
    }
});
