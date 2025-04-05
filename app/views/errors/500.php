<!DOCTYPE html>
<html lang="en" <?php echo isset($_SESSION['preferences']['dark_mode']) && $_SESSION['preferences']['dark_mode'] ? 'data-theme="dark"' : ''; ?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Error - IslamHub</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
</head>
<body>
    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100vh; text-align: center; padding: 1rem;">
        <h1 style="font-size: 6rem; margin-bottom: 0; color: var(--error-color);">500</h1>
        <h2 style="margin-top: 0;">Server Error</h2>
        
        <p style="max-width: 500px; margin: 2rem auto;">Something went wrong on our server. We're working to fix the issue. Please try again later.</p>
        
        <div style="margin-top: 2rem;">
            <a href="<?php echo BASE_URL; ?>/" class="btn btn-primary">Go to Homepage</a>
            <a href="javascript:history.back()" class="btn btn-outline" style="margin-left: 1rem;">Go Back</a>
        </div>
    </div>
    
    <!-- Main JavaScript -->
    <script src="<?php echo BASE_URL; ?>/assets/js/main.js"></script>
</body>
</html> 