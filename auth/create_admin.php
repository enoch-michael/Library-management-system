<?php
session_start();

require_once __DIR__ . '/../config/db.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validate input
    if ($full_name === '' || $email === '' || $password === '') {
        $error = 'Please fill in all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters.';
    } else {

        // Check if email already exists
        $stmt = $conn->prepare(
            "SELECT admin_id FROM admins WHERE email = ? LIMIT 1"
        );

        if (!$stmt) {
            $error = 'Database error. Please try again.';
        } else {

            $stmt->bind_param("s", $email);
            $stmt->execute();

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {

                $error = 'An admin with this email already exists.';

            } else {

                // Hash the password securely
                $hashed_password = password_hash(
                    $password,
                    PASSWORD_DEFAULT
                );

                // Insert admin
                $stmt->close();

                $stmt = $conn->prepare(
                    "INSERT INTO admins (full_name, email, password)
                     VALUES (?, ?, ?)"
                );

                if (!$stmt) {

                    $error = 'Database error. Please try again.';

                } else {

                    $stmt->bind_param(
                        "sss",
                        $full_name,
                        $email,
                        $hashed_password
                    );

                    if ($stmt->execute()) {
                        $message = 'Admin account created successfully.';
                    } else {
                        $error = 'Unable to create admin account.';
                    }

                    $stmt->close();
                }
            }

            if (isset($stmt) && $stmt instanceof mysqli_stmt) {
                $stmt->close();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Create Admin - Library Management System</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 20px;

            background: #f8fafc;

            font-family:
                Arial,
                Helvetica,
                sans-serif;
        }

        .card {
            width: 100%;
            max-width: 430px;

            background: #ffffff;

            border: 1px solid #e5e7eb;

            border-radius: 16px;

            padding: 32px;

            box-shadow:
                0 4px 12px rgba(0, 0, 0, 0.06);
        }

        h1 {
            margin: 0 0 8px;

            font-size: 24px;

            color: #111827;
        }

        .subtitle {
            margin: 0 0 24px;

            color: #6b7280;

            font-size: 14px;
        }

        label {
            display: block;

            margin-bottom: 6px;

            font-size: 14px;

            font-weight: 600;

            color: #374151;
        }

        input {
            width: 100%;

            padding: 11px 12px;

            margin-bottom: 16px;

            border: 1px solid #d1d5db;

            border-radius: 8px;

            font-size: 14px;

            outline: none;
        }

        input:focus {
            border-color: #2563eb;

            box-shadow:
                0 0 0 2px rgba(37, 99, 235, 0.15);
        }

        button {
            width: 100%;

            padding: 11px;

            border: none;

            border-radius: 8px;

            background: #1d4ed8;

            color: #ffffff;

            font-size: 14px;

            font-weight: 600;

            cursor: pointer;
        }

        button:hover {
            background: #1e40af;
        }

        .success {
            margin-bottom: 16px;

            padding: 10px 12px;

            border-radius: 8px;

            background: #dcfce7;

            color: #166534;

            font-size: 14px;
        }

        .error {
            margin-bottom: 16px;

            padding: 10px 12px;

            border-radius: 8px;

            background: #fee2e2;

            color: #b91c1c;

            font-size: 14px;
        }

        .warning {
            margin-bottom: 20px;

            padding: 12px;

            border-radius: 8px;

            background: #fff7ed;

            border: 1px solid #fed7aa;

            color: #9a3412;

            font-size: 13px;

            line-height: 19px;
        }
    </style>
</head>

<body>

    <div class="card">

        <h1>Create Admin Account</h1>

        <p class="subtitle">
            Use this page to create the initial administrator account.
        </p>

        <div class="warning">
            <strong>Important:</strong>
            This page is only for initial setup.
            Delete <strong>create_admin.php</strong>
            after creating the admin account.
        </div>

        <?php if ($message): ?>
            <div class="success">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST">

            <label for="full_name">
                Full Name
            </label>

            <input
                type="text"
                id="full_name"
                name="full_name"
                placeholder="Enter admin name"
                required
            >

            <label for="email">
                Email
            </label>

            <input
                type="email"
                id="email"
                name="email"
                placeholder="Enter admin email"
                required
            >

            <label for="password">
                Password
            </label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Enter password"
                minlength="8"
                required
            >

            <button type="submit">
                Create Admin
            </button>

        </form>

    </div>

</body>

</html>
