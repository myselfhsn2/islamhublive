    </main>
    
    <!-- Footer -->
    <footer class="bg-light py-5 mt-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="mb-3 text-primary">IslamHub</h5>
                    <p class="text-muted">IslamHub is dedicated to providing accessible Islamic education to Muslims worldwide through our online learning platform.</p>
                    <div class="d-flex gap-2 mt-3">
                        <a href="#" class="btn btn-sm btn-outline-primary rounded-circle">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-outline-primary rounded-circle">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-outline-primary rounded-circle">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-outline-primary rounded-circle">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-4 col-6">
                    <h5 class="fw-bold mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="<?php echo BASE_URL; ?>/" class="text-decoration-none text-muted">Home</a></li>
                        <li class="mb-2"><a href="<?php echo BASE_URL; ?>/about" class="text-decoration-none text-muted">About Us</a></li>
                        <li class="mb-2"><a href="<?php echo BASE_URL; ?>/courses" class="text-decoration-none text-muted">Courses</a></li>
                        <li class="mb-2"><a href="<?php echo BASE_URL; ?>/pricing" class="text-decoration-none text-muted">Pricing</a></li>
                        <li class="mb-2"><a href="<?php echo BASE_URL; ?>/contact" class="text-decoration-none text-muted">Contact</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-4 col-6">
                    <h5 class="fw-bold mb-3">Courses</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="<?php echo BASE_URL; ?>/courses" class="text-decoration-none text-muted">Quran Reading</a></li>
                        <li class="mb-2"><a href="<?php echo BASE_URL; ?>/courses" class="text-decoration-none text-muted">Tajweed</a></li>
                        <li class="mb-2"><a href="<?php echo BASE_URL; ?>/courses" class="text-decoration-none text-muted">Memorization</a></li>
                        <li class="mb-2"><a href="<?php echo BASE_URL; ?>/courses" class="text-decoration-none text-muted">Tafseer</a></li>
                        <li class="mb-2"><a href="<?php echo BASE_URL; ?>/courses" class="text-decoration-none text-muted">Islamic Studies</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-4 col-md-4">
                    <h5 class="fw-bold mb-3">Newsletter</h5>
                    <p class="text-muted">Subscribe to our newsletter for updates on new courses and Islamic resources.</p>
                    <form class="mt-3">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Your Email" aria-label="Your Email">
                            <button class="btn btn-primary" type="button">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="text-muted mb-0">&copy; <?php echo date('Y'); ?> IslamHub. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a href="#" class="text-muted text-decoration-none">Privacy Policy</a></li>
                        <li class="list-inline-item"><span class="text-muted">|</span></li>
                        <li class="list-inline-item"><a href="#" class="text-muted text-decoration-none">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- WhatsApp Float Button -->
    <a href="https://wa.me/923183607077" id="whatsappFloat" class="btn shadow rounded-circle" target="_blank" aria-label="Chat on WhatsApp">
        <i class="fab fa-whatsapp" style="font-size: 24px;"></i>
    </a>
    
    <!-- WhatsApp Float Message -->
    <div id="whatsappMessage" style="position: fixed; bottom: 20px; right: 90px; z-index: 999; background-color: white; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); padding: 15px; max-width: 300px; display: none;">
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
            <div style="background-color: #25D366; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                <i class="fab fa-whatsapp" style="color: white; font-size: 20px;"></i>
            </div>
            <div>
                <h5 style="margin: 0; font-size: 16px;">WhatsApp Support</h5>
                <p style="margin: 0; font-size: 12px; color: #666;">Typically replies within an hour</p>
            </div>
            <button id="closeWhatsappMessage" style="background: none; border: none; position: absolute; top: 5px; right: 5px; cursor: pointer; font-size: 16px; color: #666;">×</button>
        </div>
        <p style="margin-bottom: 10px; font-size: 14px;">Have questions? Chat with us on WhatsApp for quick assistance.</p>
        <a href="https://wa.me/923183607077" class="btn btn-success btn-sm" target="_blank" style="width: 100%; background-color: #25D366; border: none; margin-bottom: 8px;">
            Start Chat
        </a>
        <div style="border-top: 1px solid #eee; padding-top: 8px; margin-top: 5px;">
            <p style="margin-bottom: 8px; font-size: 14px; font-weight: 500;">Join our WhatsApp groups:</p>
            <div class="d-grid gap-2">
                <a href="https://whatsapp.com/channel/0029Vaaf3S6AjPXG6B0qsW1Y" class="btn btn-sm btn-outline-success" target="_blank" style="text-align: left; font-size: 12px;">
                    <i class="fab fa-whatsapp me-1"></i> Islam Hub Broadcast Channel
                </a>
                <a href="https://chat.whatsapp.com/BA1M2TqKO9GEg2dCLVWIT6" class="btn btn-sm btn-outline-success" target="_blank" style="text-align: left; font-size: 12px;">
                    <i class="fab fa-whatsapp me-1"></i> Quran Reading Course Group
                </a>
                <a href="https://chat.whatsapp.com/BezHXAtMs0Y7w2nd3KnmHn" class="btn btn-sm btn-outline-success" target="_blank" style="text-align: left; font-size: 12px;">
                    <i class="fab fa-whatsapp me-1"></i> Quran Memorization Group
                </a>
                <a href="https://chat.whatsapp.com/EPCJCl4Z3Q2F2jwbBdwUWm" class="btn btn-sm btn-outline-success" target="_blank" style="text-align: left; font-size: 12px;">
                    <i class="fab fa-whatsapp me-1"></i> Quran Translation & Tafseer
                </a>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Dark Mode Toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get all dark mode toggle buttons
            const darkModeToggles = document.querySelectorAll('#darkModeToggle, #darkModeToggle-desktop');
            
            function updateDarkModeUI() {
                const isDarkMode = document.documentElement.getAttribute('data-bs-theme') === 'dark';
                darkModeToggles.forEach(toggle => {
                    const icon = toggle.querySelector('i');
                    if (isDarkMode) {
                        icon.classList.remove('fa-moon');
                        icon.classList.add('fa-sun');
                    } else {
                        icon.classList.remove('fa-sun');
                        icon.classList.add('fa-moon');
                    }
                });
            }
            
            // Initial UI update
            updateDarkModeUI();
            
            // Handle dark mode toggle
            darkModeToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const isDarkMode = document.documentElement.getAttribute('data-bs-theme') === 'dark';
                    document.documentElement.setAttribute('data-bs-theme', isDarkMode ? 'light' : 'dark');
                    localStorage.setItem('darkMode', !isDarkMode);
                    updateDarkModeUI();
                });
            });
        });
    </script>
    
    <!-- Add CSS for theme transition and WhatsApp button -->
    <style>
        .theme-transition {
            transition: background-color 0.5s ease, color 0.5s ease;
        }
        
        .theme-transition * {
            transition: background-color 0.5s ease, color 0.5s ease, border-color 0.5s ease;
        }
        
        #darkModeToggle i {
            transition: transform 0.5s ease;
        }
        
        /* WhatsApp Float Button Styles */
        #whatsappFloat {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            background-color: #25D366;
            color: white;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulse 2s infinite;
            transition: all 0.3s ease;
        }
        
        #whatsappFloat:hover {
            transform: scale(1.1);
            box-shadow: 0 0 15px rgba(37, 211, 102, 0.5);
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(37, 211, 102, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0);
            }
        }
        
        /* Tooltip for WhatsApp button */
        #whatsappFloat::after {
            content: "Chat with us";
            position: absolute;
            bottom: 70px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #333;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            white-space: nowrap;
        }
        
        #whatsappFloat:hover::after {
            opacity: 1;
            visibility: visible;
        }
    </style>
    
    <!-- Any additional scripts -->
    <?php if (isset($additionalScripts)) echo $additionalScripts; ?>
    
    <script>
        // Show WhatsApp message after 5 seconds
        setTimeout(function() {
            document.getElementById('whatsappMessage').style.display = 'block';
        }, 5000);
        
        // Close WhatsApp message when close button is clicked
        document.getElementById('closeWhatsappMessage').addEventListener('click', function() {
            document.getElementById('whatsappMessage').style.display = 'none';
        });
    </script>
</body>
</html> 