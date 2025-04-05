/**
 * IslamHub - Main JavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const navLinks = document.querySelector('.nav-links');
    
    if (mobileMenuBtn && navLinks) {
        mobileMenuBtn.addEventListener('click', function() {
            navLinks.classList.toggle('active');
        });
    }
    
    // Dark mode toggle
    const darkModeToggle = document.querySelector('.dark-mode-toggle');
    
    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', function() {
            toggleDarkMode();
        });
        
        // Initialize dark mode based on user preference
        initDarkMode();
    }
    
    // Form validation
    const forms = document.querySelectorAll('form[data-validate="true"]');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const isValid = validateForm(form);
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    });
    
    // Initialize progress bars
    initProgressBars();
    
    // Initialize course progress tracking
    initCourseProgressTracking();
    
    // Contact form AJAX submission
    const contactForm = document.getElementById('contact-form');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            submitContactForm(contactForm);
        });
    }
    
    // Course enrollment form
    const enrollmentForm = document.getElementById('enrollment-form');
    
    if (enrollmentForm) {
        const planRadios = enrollmentForm.querySelectorAll('input[name="plan_type"]');
        const amountInput = enrollmentForm.querySelector('input[name="amount"]');
        
        planRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                updatePlanAmount(radio.value, amountInput);
            });
        });
        
        // Set initial amount based on selected plan
        const selectedPlan = enrollmentForm.querySelector('input[name="plan_type"]:checked');
        if (selectedPlan && amountInput) {
            updatePlanAmount(selectedPlan.value, amountInput);
        }
    }
});

/**
 * Initialize dark mode
 */
function initDarkMode() {
    // Check user preference in localStorage
    const darkMode = localStorage.getItem('darkMode') === 'true';
    
    if (darkMode) {
        document.documentElement.setAttribute('data-theme', 'dark');
    } else {
        document.documentElement.removeAttribute('data-theme');
    }
}

/**
 * Toggle dark mode
 */
function toggleDarkMode() {
    const currentTheme = document.documentElement.getAttribute('data-theme');
    const isDarkMode = currentTheme === 'dark';
    
    if (isDarkMode) {
        document.documentElement.removeAttribute('data-theme');
        localStorage.setItem('darkMode', 'false');
    } else {
        document.documentElement.setAttribute('data-theme', 'dark');
        localStorage.setItem('darkMode', 'true');
    }
    
    // If user is logged in, update preference via AJAX
    const userId = document.body.dataset.userId;
    if (userId) {
        fetch('/auth/toggle-dark-mode', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Dark mode preference updated:', data.dark_mode);
        })
        .catch(error => {
            console.error('Error updating dark mode preference:', error);
        });
    }
}

/**
 * Validate form inputs
 * 
 * @param {HTMLFormElement} form The form to validate
 * @return {boolean} Whether the form is valid
 */
function validateForm(form) {
    let isValid = true;
    const inputs = form.querySelectorAll('input, select, textarea');
    
    inputs.forEach(input => {
        // Reset error state
        const formGroup = input.closest('.form-group');
        const errorElement = formGroup ? formGroup.querySelector('.form-error') : null;
        
        if (errorElement) {
            errorElement.textContent = '';
        }
        
        // Skip inputs that don't need validation
        if (!input.hasAttribute('required') && input.value === '') {
            return;
        }
        
        // Validate by input type
        let errorMessage = '';
        
        switch (input.type) {
            case 'email':
                if (!validateEmail(input.value)) {
                    errorMessage = 'Please enter a valid email address';
                }
                break;
                
            case 'password':
                if (input.dataset.minLength && input.value.length < parseInt(input.dataset.minLength)) {
                    errorMessage = `Password must be at least ${input.dataset.minLength} characters`;
                }
                break;
                
            case 'tel':
                if (!validatePhone(input.value)) {
                    errorMessage = 'Please enter a valid phone number';
                }
                break;
                
            default:
                if (input.hasAttribute('required') && input.value.trim() === '') {
                    errorMessage = 'This field is required';
                }
        }
        
        // Check for password confirmation
        if (input.id === 'password_confirm') {
            const password = form.querySelector('#password');
            if (password && input.value !== password.value) {
                errorMessage = 'Passwords do not match';
            }
        }
        
        // Display error if any
        if (errorMessage && errorElement) {
            errorElement.textContent = errorMessage;
            isValid = false;
        }
    });
    
    return isValid;
}

/**
 * Validate email address
 * 
 * @param {string} email The email to validate
 * @return {boolean} Whether the email is valid
 */
function validateEmail(email) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

/**
 * Validate phone number
 * 
 * @param {string} phone The phone number to validate
 * @return {boolean} Whether the phone number is valid
 */
function validatePhone(phone) {
    // Basic validation - adjust based on your needs
    return phone.replace(/[^0-9]/g, '').length >= 10;
}

/**
 * Submit contact form via AJAX
 * 
 * @param {HTMLFormElement} form The form to submit
 */
function submitContactForm(form) {
    // Show loading state
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.textContent;
    submitBtn.textContent = 'Sending...';
    submitBtn.disabled = true;
    
    // Clear previous alerts
    const alertContainer = document.getElementById('form-alerts');
    if (alertContainer) {
        alertContainer.innerHTML = '';
    }
    
    // Get form data
    const formData = new FormData(form);
    
    // Send AJAX request
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        // Display success message
        if (data.success && alertContainer) {
            alertContainer.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
            form.reset();
        } else if (alertContainer) {
            alertContainer.innerHTML = `<div class="alert alert-error">${data.message}</div>`;
        }
    })
    .catch(error => {
        console.error('Error submitting form:', error);
        if (alertContainer) {
            alertContainer.innerHTML = '<div class="alert alert-error">An error occurred. Please try again later.</div>';
        }
    })
    .finally(() => {
        // Reset button state
        submitBtn.textContent = originalBtnText;
        submitBtn.disabled = false;
    });
}

/**
 * Initialize progress bars
 */
function initProgressBars() {
    const progressBars = document.querySelectorAll('.progress-bar');
    
    progressBars.forEach(bar => {
        const percentage = bar.dataset.progress || 0;
        bar.style.width = `${percentage}%`;
    });
}

/**
 * Initialize course progress tracking
 */
function initCourseProgressTracking() {
    const progressForm = document.getElementById('progress-form');
    
    if (progressForm) {
        const progressInput = progressForm.querySelector('input[name="progress"]');
        const progressValue = document.getElementById('progress-value');
        
        if (progressInput && progressValue) {
            progressInput.addEventListener('input', function() {
                progressValue.textContent = `${progressInput.value}%`;
                
                // Update progress bar
                const progressBar = document.querySelector('.progress-bar');
                if (progressBar) {
                    progressBar.style.width = `${progressInput.value}%`;
                }
            });
            
            progressForm.addEventListener('submit', function(e) {
                e.preventDefault();
                updateCourseProgress(progressForm);
            });
        }
    }
}

/**
 * Update course progress via AJAX
 * 
 * @param {HTMLFormElement} form The progress form
 */
function updateCourseProgress(form) {
    // Show loading state
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.textContent;
    submitBtn.textContent = 'Updating...';
    submitBtn.disabled = true;
    
    // Get form data
    const formData = new FormData(form);
    
    // Send AJAX request
    fetch('/courses/progress', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            const alertContainer = document.getElementById('progress-alerts');
            if (alertContainer) {
                alertContainer.innerHTML = '<div class="alert alert-success">Progress updated successfully</div>';
                
                // Auto-hide the alert after 3 seconds
                setTimeout(() => {
                    alertContainer.innerHTML = '';
                }, 3000);
            }
            
            // Update completed status if needed
            if (data.data.completed) {
                const completedBadge = document.getElementById('completed-badge');
                if (completedBadge) {
                    completedBadge.style.display = 'inline-block';
                }
            }
        } else {
            console.error('Error updating progress:', data.message);
        }
    })
    .catch(error => {
        console.error('Error updating progress:', error);
    })
    .finally(() => {
        // Reset button state
        submitBtn.textContent = originalBtnText;
        submitBtn.disabled = false;
    });
}

/**
 * Update plan amount based on selected plan
 * 
 * @param {string} planType The selected plan type
 * @param {HTMLInputElement} amountInput The amount input field
 */
function updatePlanAmount(planType, amountInput) {
    switch (planType) {
        case 'flexible':
            amountInput.value = '';
            amountInput.removeAttribute('readonly');
            amountInput.setAttribute('placeholder', 'Enter your preferred amount');
            break;
            
        case 'standard':
            amountInput.value = '50';
            amountInput.setAttribute('readonly', 'readonly');
            amountInput.removeAttribute('placeholder');
            break;
            
        case 'premium':
            amountInput.value = '100';
            amountInput.setAttribute('readonly', 'readonly');
            amountInput.removeAttribute('placeholder');
            break;
    }
} 