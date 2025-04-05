<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1>Learn Quran Online with Expert Teachers</h1>
            <p>Join IslamHub to embark on your journey of Quranic education with personalized courses for all ages and levels.</p>
            <a href="<?php echo BASE_URL; ?>/courses" class="btn btn-primary btn-lg">Explore Courses</a>
            
            <div class="whatsapp-broadcast">
                <a href="<?php echo BASE_URL; ?>/broadcast" class="btn btn-outline">
                    <i class="fab fa-whatsapp"></i> Join Our WhatsApp Broadcast
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Courses Section -->
<section class="container">
    <div class="section-header" style="text-align: center; margin: 3rem 0 2rem;">
        <h2>Our Courses</h2>
        <p>Choose from our selection of comprehensive Quranic courses</p>
    </div>
    
    <div class="courses-grid">
        <?php foreach ($courses as $course): ?>
            <div class="card course-card">
                <img src="<?php echo BASE_URL; ?>/assets/images/courses/<?php echo $course['slug']; ?>.jpg" 
                     alt="<?php echo $course['title']; ?>" 
                     onerror="this.src='<?php echo BASE_URL; ?>/assets/images/course-placeholder.jpg'">
                
                <div class="course-content">
                    <h3 class="course-title"><?php echo $course['title']; ?></h3>
                    <p class="course-description"><?php echo substr(strip_tags($course['description']), 0, 120); ?>...</p>
                    
                    <a href="<?php echo BASE_URL; ?>/courses/<?php echo $course['slug']; ?>" class="btn btn-primary">Learn More</a>
                    
                    <div class="course-whatsapp">
                        <i class="fab fa-whatsapp"></i>
                        <?php
                        $whatsappLink = "https://chat.whatsapp.com/BA1M2TqKO9GEg2dCLVWIT6"; // Default: Quran Reading
                        
                        if (stripos($course['title'], 'memorization') !== false) {
                            $whatsappLink = "https://chat.whatsapp.com/BezHXAtMs0Y7w2nd3KnmHn";
                        } elseif (stripos($course['title'], 'tafseer') !== false || stripos($course['title'], 'translation') !== false) {
                            $whatsappLink = "https://chat.whatsapp.com/EPCJCl4Z3Q2F2jwbBdwUWm";
                        }
                        ?>
                        <a href="<?php echo $whatsappLink; ?>" target="_blank">Join WhatsApp Group</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <div style="text-align: center; margin: 2rem 0;">
        <a href="<?php echo BASE_URL; ?>/courses" class="btn btn-outline">View All Courses</a>
    </div>
</section>

<!-- Features Section -->
<section style="background-color: var(--primary-color); color: white; padding: 4rem 0; margin: 3rem 0;">
    <div class="container">
        <div class="section-header" style="text-align: center; margin-bottom: 3rem;">
            <h2>Why Choose IslamHub?</h2>
            <p>We're committed to providing the best Quranic education experience</p>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            <div class="card" style="text-align: center; background-color: rgba(255, 255, 255, 0.1);">
                <i class="fas fa-user-tie" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                <h3>Expert Teachers</h3>
                <p>Learn from qualified and experienced Quran teachers who provide personalized attention.</p>
            </div>
            
            <div class="card" style="text-align: center; background-color: rgba(255, 255, 255, 0.1);">
                <i class="fas fa-laptop" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                <h3>Flexible Learning</h3>
                <p>Study at your own pace with schedules that fit your lifestyle and personal commitments.</p>
            </div>
            
            <div class="card" style="text-align: center; background-color: rgba(255, 255, 255, 0.1);">
                <i class="fas fa-hand-holding-usd" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                <h3>Affordable Pricing</h3>
                <p>Choose from multiple pricing options that suit your budget and learning needs.</p>
            </div>
        </div>
    </div>
</section>

<!-- Pricing Preview -->
<section class="container">
    <div class="section-header" style="text-align: center; margin: 3rem 0 2rem;">
        <h2>Affordable Pricing Plans</h2>
        <p>Choose the plan that works best for you</p>
    </div>
    
    <div class="pricing-plans">
        <div class="card pricing-card">
            <div class="pricing-header">
                <h3 class="pricing-title">Flexible Fee</h3>
                <div class="pricing-price">You Decide</div>
                <p>Perfect for those with basic requirements</p>
            </div>
            
            <ul class="pricing-features">
                <li><i class="fas fa-check"></i> Access to course materials</li>
                <li><i class="fas fa-check"></i> Join WhatsApp group</li>
                <li><i class="fas fa-check"></i> Track your progress</li>
                <li><i class="fas fa-times"></i> Personalized feedback</li>
                <li><i class="fas fa-times"></i> One-on-one sessions</li>
            </ul>
            
            <a href="<?php echo BASE_URL; ?>/pricing" class="btn btn-outline">Learn More</a>
        </div>
        
        <div class="card pricing-card premium-plan">
            <div class="pricing-header">
                <h3 class="pricing-title">Standard Plan</h3>
                <div class="pricing-price">$50</div>
                <p>Our most popular option</p>
            </div>
            
            <ul class="pricing-features">
                <li><i class="fas fa-check"></i> Everything in Flexible plan</li>
                <li><i class="fas fa-check"></i> Personalized feedback</li>
                <li><i class="fas fa-check"></i> Weekly progress reports</li>
                <li><i class="fas fa-check"></i> Priority support</li>
                <li><i class="fas fa-times"></i> One-on-one sessions</li>
            </ul>
            
            <a href="<?php echo BASE_URL; ?>/pricing" class="btn btn-outline">Learn More</a>
        </div>
        
        <div class="card pricing-card">
            <div class="pricing-header">
                <h3 class="pricing-title">Premium Plan</h3>
                <div class="pricing-price">$100</div>
                <p>The ultimate learning experience</p>
            </div>
            
            <ul class="pricing-features">
                <li><i class="fas fa-check"></i> Everything in Standard plan</li>
                <li><i class="fas fa-check"></i> One-on-one sessions</li>
                <li><i class="fas fa-check"></i> Customized learning path</li>
                <li><i class="fas fa-check"></i> 24/7 support access</li>
                <li><i class="fas fa-check"></i> Exclusive learning resources</li>
            </ul>
            
            <a href="<?php echo BASE_URL; ?>/pricing" class="btn btn-outline">Learn More</a>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section style="background-color: var(--bg-dark); padding: 4rem 0; margin: 3rem 0;">
    <div class="container">
        <div class="section-header" style="text-align: center; margin-bottom: 3rem;">
            <h2>What Our Students Say</h2>
            <p>Read testimonials from our satisfied students</p>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            <div class="card">
                <div style="margin-bottom: 1rem;">
                    <i class="fas fa-star" style="color: gold;"></i>
                    <i class="fas fa-star" style="color: gold;"></i>
                    <i class="fas fa-star" style="color: gold;"></i>
                    <i class="fas fa-star" style="color: gold;"></i>
                    <i class="fas fa-star" style="color: gold;"></i>
                </div>
                <p>"IslamHub has transformed my Quranic learning journey. The teachers are knowledgeable and patient, and the flexible scheduling works perfectly with my busy life."</p>
                <div style="margin-top: 1rem;">
                    <strong>Ahmed Hassan</strong><br>
                    <small>Quran Memorization Student</small>
                </div>
            </div>
            
            <div class="card">
                <div style="margin-bottom: 1rem;">
                    <i class="fas fa-star" style="color: gold;"></i>
                    <i class="fas fa-star" style="color: gold;"></i>
                    <i class="fas fa-star" style="color: gold;"></i>
                    <i class="fas fa-star" style="color: gold;"></i>
                    <i class="fas fa-star" style="color: gold;"></i>
                </div>
                <p>"My children have been studying with IslamHub for six months, and their Quran reading has improved dramatically. The WhatsApp groups are also a great way to stay connected."</p>
                <div style="margin-top: 1rem;">
                    <strong>Fatima Ahmed</strong><br>
                    <small>Parent of Quran Reading Students</small>
                </div>
            </div>
            
            <div class="card">
                <div style="margin-bottom: 1rem;">
                    <i class="fas fa-star" style="color: gold;"></i>
                    <i class="fas fa-star" style="color: gold;"></i>
                    <i class="fas fa-star" style="color: gold;"></i>
                    <i class="fas fa-star" style="color: gold;"></i>
                    <i class="fas fa-star-half-alt" style="color: gold;"></i>
                </div>
                <p>"The Tafseer course has given me a deeper understanding of the Quran. The teachers explain complex concepts clearly, and the course materials are comprehensive."</p>
                <div style="margin-top: 1rem;">
                    <strong>Mohammad Ali</strong><br>
                    <small>Quran Tafseer Student</small>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section style="background-color: var(--primary-color); color: white; padding: 4rem 0; text-align: center;">
    <div class="container">
        <h2>Ready to Begin Your Journey?</h2>
        <p style="max-width: 600px; margin: 1rem auto 2rem;">Join IslamHub today and take the first step towards mastering the Quran with our expert teachers and flexible learning options.</p>
        
        <a href="<?php echo BASE_URL; ?>/auth/register" class="btn btn-lg" style="background-color: white; color: var(--primary-color);">Register Now</a>
        <a href="<?php echo BASE_URL; ?>/contact" class="btn btn-outline btn-lg" style="color: white; border-color: white; margin-left: 1rem;">Contact Us</a>
    </div>
</section> 