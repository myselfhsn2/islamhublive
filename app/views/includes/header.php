<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'IslamHub - Online Islamic Learning Center'; ?></title>
    <meta name="description" content="<?php echo isset($metaDescription) ? $metaDescription : 'IslamHub is an online Islamic learning center offering courses in Quran reading, memorization, and Islamic studies.'; ?>">
    <meta name="keywords" content="<?php echo isset($metaKeywords) ? $metaKeywords : 'Islamic education, Quran learning, online Islamic courses'; ?>">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    <link href="<?php echo BASE_URL; ?>/assets/css/style.css" rel="stylesheet">
    
    <!-- Dark mode preference -->
    <script>
        // Check for saved dark mode preference or respect OS preference
        if (localStorage.getItem('darkMode') === 'true' || 
            (window.matchMedia('(prefers-color-scheme: dark)').matches && 
             localStorage.getItem('darkMode') === null)) {
            document.documentElement.setAttribute('data-bs-theme', 'dark');
        }
    </script>
</head>
<body>
    <!-- Header/Navbar -->
    <header class="bg-light shadow-sm sticky-top">
        <nav class="navbar navbar-expand-lg py-3">
            <div class="container">
                <!-- Brand (Text only) -->
                <a class="navbar-brand fw-bold text-primary" href="<?php echo BASE_URL; ?>/">
                    IslamHub
                </a>
                
                <div class="d-flex align-items-center">
                    <!-- Dark Mode Toggle - Always visible -->
                    <div class="nav-item d-flex align-items-center me-2 d-lg-none">
                        <button id="darkModeToggle" class="btn btn-outline-secondary rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-moon"></i>
                        </button>
                    </div>
                    
                    <!-- Toggle Button -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                
                <!-- Navbar Links -->
                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="navbar-nav">
                        <?php
                        // Define navigation items
                        $navItems = [
                            ['url' => '/', 'title' => 'Home'],
                            ['url' => '/courses', 'title' => 'Courses'],
                            ['url' => '/pricing', 'title' => 'Pricing'],
                            ['url' => '/about', 'title' => 'About'],
                            ['url' => '/contact', 'title' => 'Contact'],
                            ['url' => '/broadcast', 'title' => 'WhatsApp Broadcast']
                        ];
                        
                        // Get current URI to determine active item
                        $currentUri = $_SERVER['REQUEST_URI'];
                        $currentUri = preg_replace('#^' . BASE_PATH . '#', '', $currentUri);
                        if (strpos($currentUri, '?') !== false) {
                            $currentUri = substr($currentUri, 0, strpos($currentUri, '?'));
                        }
                        
                        // Output navigation items
                        foreach ($navItems as $item) {
                            $isActive = $currentUri === $item['url'] || ($currentUri !== '/' && strpos($currentUri, $item['url']) === 0 && $item['url'] !== '/');
                            echo '<li class="nav-item mx-2">';
                            echo '<a class="nav-link position-relative fw-medium' . ($isActive ? ' active' : '') . '" href="' . BASE_URL . $item['url'] . '" style="font-size: 1.1rem;">';
                            echo $item['title'];
                            echo '</a>';
                            echo '</li>';
                        }
                        ?>
                    </ul>
                    
                    <div class="d-flex align-items-center ms-auto">
                        <!-- Dark Mode Toggle (Only shown on desktop) -->
                        <div class="nav-item d-none d-lg-flex align-items-center me-3">
                            <button id="darkModeToggle-desktop" class="btn btn-outline-secondary rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-moon"></i>
                            </button>
                        </div>
                        
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <!-- Logged in user -->
                            <div class="dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo isset($_SESSION['full_name']) ? $_SESSION['full_name'] : 'My Account'; ?>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border" aria-labelledby="userDropdown">
                                    <li>
                                        <a class="dropdown-item" href="<?php echo BASE_URL; ?>/dashboard">
                                            <i class="fas fa-tachometer-alt me-2 text-primary"></i> Dashboard
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?php echo BASE_URL; ?>/dashboard/profile">
                                            <i class="fas fa-user me-2 text-primary"></i> My Profile
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="<?php echo BASE_URL; ?>/auth/logout">
                                            <i class="fas fa-sign-out-alt me-2 text-primary"></i> Logout
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <!-- Guest user -->
                            <a href="<?php echo BASE_URL; ?>/auth/login" class="btn btn-outline-primary me-2 transition-all hover-lift">Login</a>
                            <a href="<?php echo BASE_URL; ?>/auth/register" class="btn btn-primary transition-all hover-lift">Sign Up</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    
    <!-- Main Content -->
    <main>
        <!-- Flash Messages -->
        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="container mt-3 animate-fade-in">
                <div class="alert alert-<?php echo $_SESSION['flash_type'] ?? 'info'; ?> alert-dismissible fade show shadow-sm" role="alert">
                    <?php echo $_SESSION['flash_message']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            <?php unset($_SESSION['flash_message']); ?>
            <?php unset($_SESSION['flash_type']); ?>
        <?php endif; ?> 