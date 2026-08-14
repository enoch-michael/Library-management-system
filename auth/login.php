<?php
session_start();

// If already logged in, skip straight to dashboard
if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = $_SESSION['login_error'] ?? '';
unset($_SESSION['login_error']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login - Library Management System</title>

    <link rel="stylesheet" href="../assets/css/login.css">
</head>

<body>

    <!-- Top bar -->
    <header class="top-bar">

        <svg xmlns="http://www.w3.org/2000/svg"
             class="top-bar-icon"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor"
             stroke-width="2">

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
        </svg>

        <span class="top-bar-title">
            Library Management System
        </span>

    </header>


    <!-- Main content -->
    <main class="main-content">

        <div class="login-card">

            <!-- Logo -->
            <div class="logo-container">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="logo-icon"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="1.5">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                </svg>

            </div>


            <h1>Admin Login</h1>

            <p class="subtitle">
                Sign in to access the admin dashboard
            </p>


            <!-- Admin access notice -->
            <div class="access-notice">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="notice-icon"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.286Z" />
                </svg>

                <div>
                    <p class="notice-title">
                        Admin Access Only
                    </p>

                    <p class="notice-text">
                        This area is restricted to administrators only.
                        Please login with your admin credentials.
                    </p>
                </div>

            </div>


            <!-- Error message -->
            <?php if ($error): ?>

                <div class="error-message">
                    <?php echo htmlspecialchars($error); ?>
                </div>

            <?php endif; ?>


            <!-- Login form -->
            <form action="login_handler.php"
                  method="POST"
                  class="login-form">

                <!-- Email -->
                <div class="input-wrapper">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="input-icon"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />

                    </svg>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Admin Email"
                        required
                        autofocus
                    >

                </div>


                <!-- Password -->
                <div class="input-wrapper">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="input-icon"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />

                    </svg>


                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Password"
                        required
                    >


                    <!-- Password visibility button -->
                    <button
                        type="button"
                        id="togglePassword"
                        class="toggle-password"
                    >

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="eye-icon"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="2">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />

                        </svg>

                    </button>

                </div>


                <!-- Remember me -->
                <label class="remember-me">

                    <input
                        type="checkbox"
                        name="remember"
                    >

                    <span>Remember me</span>

                </label>


                <!-- Login button -->
                <button
                    type="submit"
                    class="login-button"
                >
                    Login as Admin
                </button>

            </form>


            <!-- Bottom divider -->
            <div class="divider">

                <div class="divider-line"></div>

                <span>Admin access only</span>

                <div class="divider-line"></div>

            </div>

        </div>

    </main>


    <!-- Footer -->
    <footer class="footer">

        &copy; <?php echo date('Y'); ?>
        Library Management System &ndash; Group Project

    </footer>


    <!-- Password toggle logic -->
    <script>

        const toggle = document.getElementById('togglePassword');
        const pwd = document.getElementById('password');

        toggle.addEventListener('click', () => {

            pwd.type = pwd.type === 'password'
                ? 'text'
                : 'password';

        });

    </script>

</body>
</html>
