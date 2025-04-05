<div class="container" style="max-width: 800px; margin: 3rem auto;">
    <div class="card">
        <h1 style="text-align: center; margin-bottom: 2rem;">Enroll in <?php echo $course['title']; ?></h1>
        
        <div style="background-color: var(--primary-light); color: white; padding: 1.5rem; border-radius: var(--border-radius-md); margin-bottom: 2rem;">
            <h3>Course Details</h3>
            <p><?php echo substr(strip_tags($course['description']), 0, 150); ?>...</p>
            <a href="<?php echo BASE_URL; ?>/courses/<?php echo $course['slug']; ?>" style="color: white; text-decoration: underline;">View Full Course Details</a>
        </div>
        
        <form id="enrollment-form" action="<?php echo BASE_URL; ?>/courses/enroll" method="POST" data-validate="true">
            <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
            
            <h3>Select Your Plan</h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin: 1.5rem 0;">
                <div class="card" style="text-align: center; cursor: pointer; border: 2px solid transparent;" id="plan-flexible" onclick="selectPlan('flexible')">
                    <h3>Flexible Fee</h3>
                    <p>You decide how much to pay</p>
                    <div style="margin-top: 1rem;">
                        <input type="radio" name="plan_type" id="plan_flexible" value="flexible" checked>
                        <label for="plan_flexible">Select</label>
                    </div>
                </div>
                
                <div class="card" style="text-align: center; cursor: pointer; border: 2px solid transparent;" id="plan-standard" onclick="selectPlan('standard')">
                    <h3>Standard Plan</h3>
                    <p>$50</p>
                    <div style="margin-top: 1rem;">
                        <input type="radio" name="plan_type" id="plan_standard" value="standard">
                        <label for="plan_standard">Select</label>
                    </div>
                </div>
                
                <div class="card" style="text-align: center; cursor: pointer; border: 2px solid transparent;" id="plan-premium" onclick="selectPlan('premium')">
                    <h3>Premium Plan</h3>
                    <p>$100</p>
                    <div style="margin-top: 1rem;">
                        <input type="radio" name="plan_type" id="plan_premium" value="premium">
                        <label for="plan_premium">Select</label>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="amount">Payment Amount ($)</label>
                <input type="number" id="amount" name="amount" min="1" step="0.01" placeholder="Enter your preferred amount">
                <div class="form-error"></div>
            </div>
            
            <div class="form-group">
                <label for="payment_method">Payment Method</label>
                <select id="payment_method" name="payment_method" required>
                    <option value="">Select a payment method</option>
                    <option value="credit_card">Credit Card</option>
                    <option value="paypal">PayPal</option>
                    <option value="bank_transfer">Bank Transfer</option>
                </select>
                <div class="form-error"></div>
            </div>
            
            <div style="margin-top: 2rem; text-align: right;">
                <a href="<?php echo BASE_URL; ?>/courses/<?php echo $course['slug']; ?>" class="btn btn-outline" style="margin-right: 1rem;">Cancel</a>
                <button type="submit" class="btn btn-primary">Complete Enrollment</button>
            </div>
        </form>
    </div>
</div>

<script>
    function selectPlan(plan) {
        // Update radio button
        document.getElementById('plan_' + plan).checked = true;
        
        // Update visual selection
        document.getElementById('plan-flexible').style.borderColor = 'transparent';
        document.getElementById('plan-standard').style.borderColor = 'transparent';
        document.getElementById('plan-premium').style.borderColor = 'transparent';
        document.getElementById('plan-' + plan).style.borderColor = 'var(--primary-color)';
        
        // Trigger the change event for the radio button to update amount
        const event = new Event('change');
        document.getElementById('plan_' + plan).dispatchEvent(event);
    }
    
    // Set initial selection
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const plan = urlParams.get('plan');
        
        if (plan && ['flexible', 'standard', 'premium'].includes(plan)) {
            selectPlan(plan);
        } else {
            selectPlan('flexible');
        }
    });
</script> 