<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            border-radius: 12px;
            background-color: white;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<div class="login-card">
    <h2 class="mb-4 text-center">Ferrepacifico</h2>
    <h4 class="mb-4 text-center">Logistica</h4>
    
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger text-center p-2" role="alert">
            Usuario o contraseña incorrectos
        </div>
    <?php endif; ?>

    <form method="POST" action="autenticar.php">
        <div class="mb-3">
            <label class="form-label">Usuario:</label>
            <input type="text" name="usuario" class="form-control" required>
        </div>

        <div class="mb-4">
            <label class="form-label">Contraseña:</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Ingresar</button>
        </div>
    </form>
</div>

</body>
</html>
