/**
 * Global site JS
 * -----------------
 * 1. Basic client-side form validation (any form with class "validate-form")
 * 2. Sidebar toggle — off-canvas drawer on mobile, collapse on desktop
 * 3. User menu dropdown (topbar)
 * 4. Password show/hide toggle (login/register pages)
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

    // ---------- 2. Sidebar toggle ----------
    const sidebar = document.getElementById("sidebar");
    const toggleBtn = document.getElementById("sidebarToggle");
    const overlay = document.getElementById("sidebarOverlay");

    if (sidebar && toggleBtn) {
        toggleBtn.addEventListener("click", function () {
            const isMobile = window.innerWidth <= 768;

            if (isMobile) {
                sidebar.classList.toggle("open");
                if (overlay) overlay.classList.toggle("visible");
            } else {
                document.body.classList.toggle("sidebar-collapsed");
            }
        });

        if (overlay) {
            overlay.addEventListener("click", function () {
                sidebar.classList.remove("open");
                overlay.classList.remove("visible");
            });
        }

        // Close the mobile drawer automatically after tapping a nav link
        sidebar.querySelectorAll("a").forEach(function (link) {
            link.addEventListener("click", function () {
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove("open");
                    if (overlay) overlay.classList.remove("visible");
                }
            });
        });
    }

    // ---------- 3. User menu dropdown ----------
    const userMenu = document.getElementById("userMenu");
    const userMenuTrigger = document.getElementById("userMenuTrigger");

    if (userMenu && userMenuTrigger) {
        function setMenuOpen(isOpen) {
            userMenu.classList.toggle("open", isOpen);
            userMenuTrigger.setAttribute("aria-expanded", isOpen ? "true" : "false");
        }

        userMenuTrigger.addEventListener("click", function (e) {
            e.stopPropagation();
            setMenuOpen(!userMenu.classList.contains("open"));
        });

        // Click anywhere else on the page closes the dropdown
        document.addEventListener("click", function (e) {
            if (!userMenu.contains(e.target)) {
                setMenuOpen(false);
            }
        });

        // Escape key closes the dropdown and returns focus to the trigger
        document.addEventListener("keydown", function (e) {
            if (e.key === "Escape" && userMenu.classList.contains("open")) {
                setMenuOpen(false);
                userMenuTrigger.focus();
            }
        });
    }

    // ---------- 4. Password show/hide toggle ----------
    document.querySelectorAll(".password-toggle").forEach(function (btn) {
        btn.addEventListener("click", function () {
            const input = document.getElementById(btn.dataset.target);
            if (!input) return;

            if (input.type === "password") {
                input.type = "text";
                btn.classList.add("showing");
            } else {
                input.type = "password";
                btn.classList.remove("showing");
            }
        });
    });
});
