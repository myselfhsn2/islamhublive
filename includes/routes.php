<?php
/**
 * Application Routes
 * 
 * Define all application routes here
 */

// Home routes
$router->get('/', ['HomeController', 'index']);
$router->get('/about', ['HomeController', 'about']);
$router->get('/contact', ['HomeController', 'contact']);
$router->post('/contact', ['HomeController', 'submitContact']);
$router->get('/pricing', ['HomeController', 'pricing']);
$router->get('/broadcast', ['HomeController', 'broadcast']);

// Course routes
$router->get('/courses', ['CourseController', 'index']);
$router->get('/courses/:slug', ['CourseController', 'details']);
$router->get('/courses/enroll/:id', ['CourseController', 'enroll']);
$router->post('/courses/enroll', ['CourseController', 'processEnrollment']);
$router->post('/courses/progress', ['CourseController', 'updateProgress']);

// Authentication routes
$router->get('/auth/login', ['AuthController', 'login']);
$router->post('/auth/login', ['AuthController', 'processLogin']);
$router->get('/auth/register', ['AuthController', 'register']);
$router->post('/auth/register', ['AuthController', 'processRegistration']);
$router->get('/auth/logout', ['AuthController', 'logout']);
$router->post('/auth/toggle-dark-mode', ['AuthController', 'toggleDarkMode']);
$router->get('/auth/forgot-password', ['AuthController', 'forgotPassword']);
$router->post('/auth/forgot-password', ['AuthController', 'processForgotPassword']);
$router->get('/auth/reset-password/:token', ['AuthController', 'resetPassword']);
$router->post('/auth/reset-password', ['AuthController', 'processResetPassword']);

// Dashboard routes
$router->get('/dashboard', ['DashboardController', 'index']);
$router->get('/dashboard/profile', ['DashboardController', 'profile']);
$router->post('/dashboard/profile', ['DashboardController', 'updateProfile']);
$router->post('/dashboard/change-password', ['DashboardController', 'changePassword']);
$router->get('/dashboard/course/:id', ['DashboardController', 'courseProgress']); 