<div class="container" style="margin: 2rem auto;">
    <!-- Course Header -->
    <div class="card" style="padding: 0; overflow: hidden;">
        <div style="position: relative;">
            <img src="<?php echo BASE_URL; ?>/assets/images/courses/<?php echo !empty($course['image_path']) ? $course['image_path'] : $course['slug'] . '.jpg'; ?>" 
                 alt="<?php echo htmlspecialchars($course['title']); ?>" 
                 style="width: 100%; height: 300px; object-fit: cover;"
                 onerror="this.src='<?php echo BASE_URL; ?>/assets/images/course-placeholder.jpg'">
                 
            <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 2rem; background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                <h1 style="color: white; margin-bottom: 0.5rem;"><?php echo htmlspecialchars($course['title']); ?></h1>
                
                <?php if (isset($userProgress)): ?>
                    <div class="progress-info">
                        <span style="color: white;">Your Progress: <?php echo number_format($userProgress['progress_percentage'], 1); ?>%</span>
                        <?php if ($userProgress['completed']): ?>
                            <span class="badge" style="background-color: var(--success-color); color: white; padding: 0.25rem 0.5rem; border-radius: 1rem; font-size: 0.75rem;">Completed</span>
                        <?php endif; ?>
                    </div>
                    <div class="progress-container" style="margin-top: 0.75rem; background-color: rgba(255,255,255,0.3); height: 10px; border-radius: 5px;">
                        <div class="progress-bar" style="height: 100%; border-radius: 5px; background-color: var(--success-color); width: <?php echo $userProgress['progress_percentage']; ?>%;"></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div style="padding: 2rem;">
            <div style="display: flex; justify-content: space-between; flex-wrap: wrap; margin-bottom: 2rem;">
                <div style="flex: 1; min-width: 300px; margin-right: 2rem;">
                    <h2>Course Description</h2>
                    <p><?php echo nl2br(htmlspecialchars($course['description'])); ?></p>
                </div>
                
                <div style="flex-basis: 300px; margin-top: 1rem;">
                    <div class="card" style="background-color: var(--primary-color); color: white; padding: 1.5rem;">
                        <h3>Join this Course</h3>
                        <p>Enroll now to start your learning journey</p>
                        
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <?php if (isset($userProgress)): ?>
                                <a href="<?php echo BASE_URL; ?>/dashboard/course/<?php echo $course['id']; ?>" class="btn" style="background-color: white; color: var(--primary-color); width: 100%; margin-top: 1rem;">Go to Course</a>
                            <?php else: ?>
                                <a href="<?php echo BASE_URL; ?>/courses/enroll/<?php echo $course['id']; ?>" class="btn" style="background-color: white; color: var(--primary-color); width: 100%; margin-top: 1rem;">Enroll Now</a>
                            <?php endif; ?>
                        <?php else: ?>
                            <a href="<?php echo BASE_URL; ?>/auth/login" class="btn" style="background-color: white; color: var(--primary-color); width: 100%; margin-top: 1rem;">Login to Enroll</a>
                            <p style="font-size: 0.875rem; margin-top: 0.5rem; text-align: center;">Don't have an account? <a href="<?php echo BASE_URL; ?>/auth/register" style="color: white; text-decoration: underline;">Register</a></p>
                        <?php endif; ?>
                        
                        <div style="margin-top: 1.5rem; text-align: center;">
                            <p><i class="fab fa-whatsapp" style="font-size: 1.5rem;"></i></p>
                            <p style="margin: 0.5rem 0;">Join our WhatsApp group for updates and discussions</p>
                            <?php
                            $whatsappLink = "https://chat.whatsapp.com/BA1M2TqKO9GEg2dCLVWIT6"; // Default: Quran Reading
                            
                            if (stripos($course['title'], 'memorization') !== false) {
                                $whatsappLink = "https://chat.whatsapp.com/BezHXAtMs0Y7w2nd3KnmHn";
                            } elseif (stripos($course['title'], 'tafseer') !== false || stripos($course['title'], 'translation') !== false) {
                                $whatsappLink = "https://chat.whatsapp.com/EPCJCl4Z3Q2F2jwbBdwUWm";
                            }
                            ?>
                            <a href="<?php echo $whatsappLink; ?>" target="_blank" class="btn btn-outline" style="border-color: white; color: white; width: 100%;">Join WhatsApp Group</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr style="border-color: var(--border-color); margin: 2rem 0;">
            
            <h2>Course Curriculum</h2>
            <div style="white-space: pre-line;"><?php echo nl2br(htmlspecialchars($course['curriculum'])); ?></div>
            
            <hr style="border-color: var(--border-color); margin: 2rem 0;">
            
            <h2>Course Pricing</h2>
            <div class="pricing-plans" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin: 2rem 0;">
                <div class="card pricing-card" style="padding: 1.5rem; border-radius: var(--border-radius);">
                    <div class="pricing-header" style="text-align: center; margin-bottom: 1.5rem;">
                        <h3 class="pricing-title">Flexible Fee</h3>
                        <div class="pricing-price" style="font-size: 1.75rem; font-weight: bold; margin: 0.75rem 0;">You Decide</div>
                        <p>Perfect for those with basic requirements</p>
                    </div>
                    
                    <ul class="pricing-features" style="list-style: none; padding: 0; margin-bottom: 1.5rem;">
                        <li style="padding: 0.5rem 0;"><i class="fas fa-check text-success"></i> Access to course materials</li>
                        <li style="padding: 0.5rem 0;"><i class="fas fa-check text-success"></i> Join WhatsApp group</li>
                        <li style="padding: 0.5rem 0;"><i class="fas fa-check text-success"></i> Track your progress</li>
                        <li style="padding: 0.5rem 0;"><i class="fas fa-times text-danger"></i> Personalized feedback</li>
                        <li style="padding: 0.5rem 0;"><i class="fas fa-times text-danger"></i> One-on-one sessions</li>
                    </ul>
                    
                    <?php if (isset($_SESSION['user_id']) && !isset($userProgress)): ?>
                        <a href="<?php echo BASE_URL; ?>/courses/enroll/<?php echo $course['id']; ?>?plan=flexible" class="btn btn-outline-primary" style="width: 100%;">Select Plan</a>
                    <?php elseif (!isset($_SESSION['user_id'])): ?>
                        <a href="<?php echo BASE_URL; ?>/auth/login" class="btn btn-outline-primary" style="width: 100%;">Login to Select</a>
                    <?php endif; ?>
                </div>
                
                <div class="card pricing-card premium-plan" style="padding: 1.5rem; border-radius: var(--border-radius); border-color: var(--primary-color); box-shadow: var(--shadow);">
                    <div class="pricing-header" style="text-align: center; margin-bottom: 1.5rem;">
                        <h3 class="pricing-title">Standard Plan</h3>
                        <div class="pricing-price" style="font-size: 1.75rem; font-weight: bold; margin: 0.75rem 0;">$50</div>
                        <p>Our most popular option</p>
                    </div>
                    
                    <ul class="pricing-features" style="list-style: none; padding: 0; margin-bottom: 1.5rem;">
                        <li style="padding: 0.5rem 0;"><i class="fas fa-check text-success"></i> Everything in Flexible plan</li>
                        <li style="padding: 0.5rem 0;"><i class="fas fa-check text-success"></i> Personalized feedback</li>
                        <li style="padding: 0.5rem 0;"><i class="fas fa-check text-success"></i> Weekly progress reports</li>
                        <li style="padding: 0.5rem 0;"><i class="fas fa-check text-success"></i> Priority support</li>
                        <li style="padding: 0.5rem 0;"><i class="fas fa-times text-danger"></i> One-on-one sessions</li>
                    </ul>
                    
                    <?php if (isset($_SESSION['user_id']) && !isset($userProgress)): ?>
                        <a href="<?php echo BASE_URL; ?>/courses/enroll/<?php echo $course['id']; ?>?plan=standard" class="btn btn-primary" style="width: 100%;">Select Plan</a>
                    <?php elseif (!isset($_SESSION['user_id'])): ?>
                        <a href="<?php echo BASE_URL; ?>/auth/login" class="btn btn-primary" style="width: 100%;">Login to Select</a>
                    <?php endif; ?>
                </div>
                
                <div class="card pricing-card" style="padding: 1.5rem; border-radius: var(--border-radius);">
                    <div class="pricing-header" style="text-align: center; margin-bottom: 1.5rem;">
                        <h3 class="pricing-title">Premium Plan</h3>
                        <div class="pricing-price" style="font-size: 1.75rem; font-weight: bold; margin: 0.75rem 0;">$100</div>
                        <p>The ultimate learning experience</p>
                    </div>
                    
                    <ul class="pricing-features" style="list-style: none; padding: 0; margin-bottom: 1.5rem;">
                        <li style="padding: 0.5rem 0;"><i class="fas fa-check text-success"></i> Everything in Standard plan</li>
                        <li style="padding: 0.5rem 0;"><i class="fas fa-check text-success"></i> One-on-one sessions</li>
                        <li style="padding: 0.5rem 0;"><i class="fas fa-check text-success"></i> Customized learning path</li>
                        <li style="padding: 0.5rem 0;"><i class="fas fa-check text-success"></i> 24/7 support access</li>
                        <li style="padding: 0.5rem 0;"><i class="fas fa-check text-success"></i> Exclusive learning resources</li>
                    </ul>
                    
                    <?php if (isset($_SESSION['user_id']) && !isset($userProgress)): ?>
                        <a href="<?php echo BASE_URL; ?>/courses/enroll/<?php echo $course['id']; ?>?plan=premium" class="btn btn-outline-primary" style="width: 100%;">Select Plan</a>
                    <?php elseif (!isset($_SESSION['user_id'])): ?>
                        <a href="<?php echo BASE_URL; ?>/auth/login" class="btn btn-outline-primary" style="width: 100%;">Login to Select</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div> 