<!DOCTYPE html>
<html lang="en" <?php echo isset($_SESSION['preferences']['dark_mode']) && $_SESSION['preferences']['dark_mode'] ? 'data-theme="dark"' : ''; ?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found - IslamHub</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #198754;
            --bg-light: #f8f9fa;
            --bg-dark: #212529;
            --text-light: #212529;
            --text-dark: #f8f9fa;
        }
        
        [data-bs-theme="dark"] {
            --bg-color: var(--bg-dark);
            --text-color: var(--text-dark);
        }
        
        [data-bs-theme="light"] {
            --bg-color: var(--bg-light);
            --text-color: var(--text-light);
        }
        
        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        .error-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
        }
        
        .error-code {
            font-size: 8rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 0;
        }
        
        .error-title {
            font-size: 2rem;
            margin-top: 0;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1 class="error-code">404</h1>
        <h2 class="error-title">Page Not Found</h2>
        
        <p class="my-4" style="max-width: 500px;">The page you're looking for doesn't exist or has been moved. Please check the URL or return to the homepage.</p>
        
        <div class="mt-4">
            <a href="<?php echo BASE_URL; ?>/" class="btn btn-primary">
                <i class="fas fa-home me-2"></i> Go to Homepage
            </a>
            <a href="<?php echo BASE_URL; ?>/courses" class="btn btn-outline-primary ms-2">
                <i class="fas fa-book me-2"></i> Browse Courses
            </a>
        </div>
    </div>
    
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Check for saved dark mode preference
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.setAttribute('data-bs-theme', 'dark');
        } else if (localStorage.getItem('darkMode') === 'false') {
            document.documentElement.setAttribute('data-bs-theme', 'light');
        } else {
            // If no preference saved, check system preference
            if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.setAttribute('data-bs-theme', 'dark');
            }
        }
    </script>
</body>
</html> 