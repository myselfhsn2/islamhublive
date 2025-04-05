<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Course.php';

/**
 * Home Controller
 * 
 * Handles main pages of the website
 */
class HomeController extends Controller {
    private $courseModel;
    
    public function __construct() {
        parent::__construct();
        $this->courseModel = new Course();
    }
    
    /**
     * Display the home page
     */
    public function index() {
        $courses = $this->courseModel->getAll();
        $this->render('home', [
            'title' => 'IslamHub - Online Islamic Learning Center',
            'courses' => $courses,
            'metaDescription' => 'IslamHub offers online courses in Quran Reading, Memorization, and Tafseer. Join our community of learners today.',
            'metaKeywords' => 'Islamic education, Quran courses, Quran learning, Tajweed, Quran memorization, Tafseer'
        ]);
    }
    
    /**
     * Display the about page
     */
    public function about() {
        $this->render('about', [
            'title' => 'About IslamHub',
            'metaDescription' => 'Learn about IslamHub\'s mission to provide accessible Islamic education online.',
            'metaKeywords' => 'about IslamHub, Islamic education, online Quran learning'
        ]);
    }
    
    /**
     * Display the contact page
     */
    public function contact() {
        $this->render('contact', [
            'title' => 'Contact IslamHub',
            'metaDescription' => 'Get in touch with IslamHub for questions about our courses and services.',
            'metaKeywords' => 'contact IslamHub, Islamic courses support'
        ]);
    }
    
    /**
     * Process contact form submission
     */
    public function submitContact() {
        if ($this->isAjax()) {
            $name = $this->post('name');
            $email = $this->post('email');
            $message = $this->post('message');
            
            // Validation
            if (empty($name) || empty($email) || empty($message)) {
                $this->json(['success' => false, 'message' => 'All fields are required'], 400);
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->json(['success' => false, 'message' => 'Invalid email format'], 400);
            }
            
            // Here you would normally send an email
            // For now, we'll just simulate success
            $this->json(['success' => true, 'message' => 'Thank you! Your message has been sent.']);
        } else {
            $this->redirect('/contact');
        }
    }
    
    /**
     * Display the pricing page
     */
    public function pricing() {
        $this->render('pricing', [
            'title' => 'IslamHub Pricing Plans',
            'metaDescription' => 'Explore IslamHub\'s flexible pricing plans for Quran learning.',
            'metaKeywords' => 'IslamHub pricing, Quran course pricing, Islamic education cost'
        ]);
    }
    
    /**
     * Display WhatsApp broadcast info page
     */
    public function broadcast() {
        $this->render('broadcast', [
            'title' => 'IslamHub WhatsApp Broadcast',
            'metaDescription' => 'Stay updated with IslamHub\'s WhatsApp broadcast for latest news and resources.',
            'metaKeywords' => 'IslamHub WhatsApp, Islamic education updates'
        ]);
    }
} 