<!-- Dashboard Page -->
<div class="container py-5">
    <div class="row">
        <div class="col-lg-3 mb-4">
            <!-- Sidebar Navigation -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="avatar-placeholder bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <?php
                            $initials = '';
                            $nameParts = explode(' ', $user['full_name']);
                            if (count($nameParts) >= 2) {
                                $initials = strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[count($nameParts) - 1], 0, 1));
                            } else {
                                $initials = strtoupper(substr($user['full_name'], 0, 2));
                            }
                            echo $initials;
                            ?>
                        </div>
                        <div>
                            <h5 class="mb-0"><?php echo $user['full_name']; ?></h5>
                            <small class="text-muted">@<?php echo $user['username']; ?></small>
                        </div>
                    </div>
                    
                    <nav class="nav flex-column">
                        <a class="nav-link active" href="<?php echo BASE_URL; ?>/dashboard">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/dashboard/profile">
                            <i class="fas fa-user me-2"></i> My Profile
                        </a>
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/courses">
                            <i class="fas fa-book me-2"></i> Browse Courses
                        </a>
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/auth/logout">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                    </nav>
                </div>
            </div>
        </div>
        
        <div class="col-lg-9">
            <!-- Main Content -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h4 mb-4">My Learning Dashboard</h2>
                    
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white h-100">
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h3 class="h5 mb-0">Enrolled Courses</h3>
                                        <i class="fas fa-book fa-2x opacity-50"></i>
                                    </div>
                                    <div class="mt-auto pt-3">
                                        <h4 class="h2 mb-0"><?php echo count($courses); ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card bg-success text-white h-100">
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h3 class="h5 mb-0">Completed</h3>
                                        <i class="fas fa-check-circle fa-2x opacity-50"></i>
                                    </div>
                                    <div class="mt-auto pt-3">
                                        <h4 class="h2 mb-0">
                                            <?php
                                            $completedCount = 0;
                                            foreach ($courses as $course) {
                                                if (isset($course['progress']) && $course['progress'] === 100) {
                                                    $completedCount++;
                                                }
                                            }
                                            echo $completedCount;
                                            ?>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card bg-info text-white h-100">
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h3 class="h5 mb-0">In Progress</h3>
                                        <i class="fas fa-spinner fa-2x opacity-50"></i>
                                    </div>
                                    <div class="mt-auto pt-3">
                                        <h4 class="h2 mb-0"><?php echo count($courses) - $completedCount; ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <h3 class="h5 mb-3">My Courses</h3>
            
            <?php if (count($courses) > 0): ?>
                <?php foreach ($courses as $course): ?>
                    <div class="card mb-3 shadow-sm">
                        <div class="row g-0">
                            <div class="col-md-3">
                                <img src="<?php echo $course['image']; ?>" class="img-fluid rounded-start h-100" alt="<?php echo $course['title']; ?>" style="object-fit: cover;">
                            </div>
                            <div class="col-md-9">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h4 class="h5 card-title mb-1"><?php echo $course['title']; ?></h4>
                                            <p class="card-text small text-muted mb-2"><?php echo $course['category']; ?></p>
                                        </div>
                                        <span class="badge bg-<?php echo isset($course['progress']) && $course['progress'] === 100 ? 'success' : 'warning'; ?>">
                                            <?php echo isset($course['progress']) && $course['progress'] === 100 ? 'Completed' : 'In Progress'; ?>
                                        </span>
                                    </div>
                                    
                                    <div class="progress mb-3" style="height: 10px;">
                                        <div class="progress-bar" role="progressbar" style="width: <?php echo isset($course['progress']) ? $course['progress'] : 0; ?>%;" 
                                             aria-valuenow="<?php echo isset($course['progress']) ? $course['progress'] : 0; ?>" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <?php echo isset($course['progress']) ? $course['progress'] : 0; ?>% complete
                                        </small>
                                        <a href="<?php echo BASE_URL; ?>/dashboard/course/<?php echo $course['id']; ?>" class="btn btn-sm btn-primary">
                                            Continue Learning
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                        <h4>You haven't enrolled in any courses yet</h4>
                        <p class="text-muted">Browse our courses and start your Islamic learning journey today!</p>
                        <a href="<?php echo BASE_URL; ?>/courses" class="btn btn-primary">Browse Courses</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div> 