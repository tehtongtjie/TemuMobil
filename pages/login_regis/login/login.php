<?php
session_start();
require_once '../../../koneksi/link.php';

if (isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = "Username dan password harus diisi.";
    } else {
        // Cek user berdasarkan username
        $sql = "SELECT id, username, password, role, status FROM login WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) === 1) {
                mysqli_stmt_bind_result($stmt, $id, $user, $hashed_password, $role, $status);
                mysqli_stmt_fetch($stmt);

                if ($status !== 'aktif') {
                    $error = "Akun Anda belum aktif. Status saat ini: " . htmlspecialchars($status);
                } elseif (password_verify($password, $hashed_password)) {
                    $_SESSION['user_id'] = $id;
                    $_SESSION['username'] = $user;
                    $_SESSION['role'] = $role;

                    // Redirect berdasarkan role
                    if ($role === 'Inspektor') {
                        header("Location: /pages/inspektor/dashboard.php");
                    } elseif ($role === 'Pengguna') {
                        header("Location: /pages/pengguna/dashboard.php");
                    } elseif ($role === 'Admin') {
                        header("Location: /pages/admin/dashboard.php");
                    } else {
                        header("Location: ../dashboard.php");
                    }
                    exit;
                } else {
                    $error = "Password salah.";
                }
            } else {
                $error = "Username tidak ditemukan.";
            }

            mysqli_stmt_close($stmt);
        } else {
            $error = "Query gagal: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
    <link rel="stylesheet" href="login.css" />
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>

        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="" method="post" autocomplete="off">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required />

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required />

            <button type="submit">Masuk</button>
            <p>Belum punya akun? <a href="../regis/register.php">Daftar</a></p>
        </form>
    </div>
</body>
</html>
