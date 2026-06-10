<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — InvSys</title>
    <link href="assets/bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            min-height: 100vh;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        .auth-wrapper {
            width: 100%;
            max-width: 420px;
            padding: 16px;
        }

        .auth-brand {
            text-align: center;
            margin-bottom: 28px;
        }

        .auth-brand-icon {
            width: 52px;
            height: 52px;
            background: #3b82f6;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 24px;
            margin-bottom: 12px;
        }

        .auth-brand-name {
            font-size: 22px;
            font-weight: 700;
            color: #0f172a;
        }

        .auth-brand-sub {
            font-size: 13px;
            color: #94a3b8;
        }

        .auth-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
            padding: 32px 28px;
        }

        .auth-card h5 {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .auth-card p {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 24px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 5px;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border-color: #d1d5db;
            font-size: 13.5px;
            padding: 9px 12px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
        }

        .input-group-text {
            border-radius: 8px 0 0 8px;
            background: #f8fafc;
            border-color: #d1d5db;
            color: #94a3b8;
        }

        .input-group .form-control {
            border-radius: 0 8px 8px 0;
        }

        .btn-register {
            background: #3b82f6;
            border: none;
            border-radius: 8px;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            padding: 10px;
            width: 100%;
            transition: background 0.15s;
        }

        .btn-register:hover {
            background: #2563eb;
            color: #fff;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border: none;
            border-radius: 8px;
            font-size: 13px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: none;
            border-radius: 8px;
            font-size: 13px;
        }

        .auth-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #64748b;
        }

        .auth-footer a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="auth-wrapper">
        <div class="auth-brand">
            <div class="auth-brand-icon"><i class="bi bi-box-seam"></i></div>
            <div class="auth-brand-name">InvSys</div>
            <div class="auth-brand-sub">Create a new account</div>
        </div>

        <div class="auth-card">
            <h5>Register</h5>
            <p>Fill in the details below to get started</p>

            <form action="" method="post">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="username" name="username" class="form-control" placeholder="username" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit" class="btn-register">Create Account</button>
            </form>
        </div>

        <div class="auth-footer">
            Already have an account? <a href="login.php">Sign in</a>
        </div>
    </div>
</body>

</html>