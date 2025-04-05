<!-- Contact Page -->
<div class="container py-5">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <h1 class="text-center mb-5 fw-bold">Contact Us</h1>
            
            <div class="row g-4">
                <div class="col-lg-5 mb-4 mb-lg-0">
                    <div class="card h-100 shadow-sm border-0 rounded-3 hover-lift">
                        <div class="card-body p-4 p-lg-5">
                            <h2 class="h3 mb-4 fw-bold text-primary">Get In Touch</h2>
                            <p class="mb-4">Have questions about our courses or need assistance? Reach out to us using any of the following methods:</p>
                            
                            <div class="d-flex align-items-center mb-4">
                                <div class="bg-primary rounded-circle p-3 me-3 text-white d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <a href="mailto:info@islamhub.com" class="text-decoration-none fw-medium">info@islamhub.com</a>
                            </div>
                            
                            <div class="d-flex align-items-center mb-4">
                                <div class="bg-primary rounded-circle p-3 me-3 text-white d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <a href="tel:+12345678901" class="text-decoration-none fw-medium">+1 (234) 567-8901</a>
                            </div>
                            
                            <div class="d-flex align-items-center mb-4">
                                <div class="bg-primary rounded-circle p-3 me-3 text-white d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                    <i class="fab fa-whatsapp"></i>
                                </div>
                                <a href="https://wa.me/923183607077" target="_blank" class="text-decoration-none fw-medium">+92 318 3607077</a>
                            </div>
                            
                            <h3 class="h4 mt-5 mb-4 fw-bold">Follow Us</h3>
                            <div class="d-flex gap-3">
                                <a href="#" class="btn btn-outline-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="btn btn-outline-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="#" class="btn btn-outline-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                    <i class="fab fa-youtube"></i>
                                </a>
                                <a href="#" class="btn btn-outline-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                    <i class="fab fa-telegram"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-7">
                    <div class="card shadow-sm border-0 rounded-3 hover-lift">
                        <div class="card-body p-4 p-lg-5">
                            <h2 class="h3 mb-4 fw-bold text-primary">Send a Message</h2>
                            
                            <div id="contact-form-alert" class="alert d-none" role="alert"></div>
                            
                            <form id="contact-form">
                                <div class="mb-4">
                                    <label for="name" class="form-label fw-medium">Full Name</label>
                                    <input type="text" class="form-control form-control-lg border-0 bg-light" id="name" name="name" required>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="email" class="form-label fw-medium">Email Address</label>
                                    <input type="email" class="form-control form-control-lg border-0 bg-light" id="email" name="email" required>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="message" class="form-label fw-medium">Message</label>
                                    <textarea class="form-control form-control-lg border-0 bg-light" id="message" name="message" rows="5" required></textarea>
                                </div>
                                
                                <div class="d-grid mt-5">
                                    <button type="submit" class="btn btn-primary btn-lg py-3 fw-medium transition-all">
                                        Send Message
                                        <i class="fas fa-paper-plane ms-2"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contact-form');
    const alertBox = document.getElementById('contact-form-alert');
    
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form data
        const formData = new FormData(contactForm);
        const data = Object.fromEntries(formData);
        
        // Send AJAX request
        fetch('<?php echo BASE_URL; ?>/contact', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            // Show success message
            alertBox.classList.remove('d-none', 'alert-danger');
            alertBox.classList.add('alert-success');
            alertBox.textContent = data.message;
            
            // Reset form
            contactForm.reset();
        })
        .catch(error => {
            // Show error message
            alertBox.classList.remove('d-none', 'alert-success');
            alertBox.classList.add('alert-danger');
            alertBox.textContent = 'There was an error sending your message. Please try again.';
        });
    });
});
</script> 