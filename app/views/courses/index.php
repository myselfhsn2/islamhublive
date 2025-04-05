<!-- Courses Page -->
<div class="container py-5">
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="mb-3">Our Courses</h1>
            <p class="lead">Explore our range of courses designed to enhance your Islamic knowledge</p>
        </div>
    </div>
    
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search courses..." id="course-search">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="col-md-4">
            <select class="form-select" id="course-filter">
                <option value="">All Categories</option>
                <option value="quran-reading">Quran Reading</option>
                <option value="tajweed">Tajweed</option>
                <option value="memorization">Memorization</option>
                <option value="tafseer">Tafseer</option>
            </select>
        </div>
    </div>
    
    <div class="row g-4" id="course-list">
        <?php if (count($courses) > 0): ?>
            <?php foreach ($courses as $course): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm course-card">
                        <?php if (isset($course['featured']) && $course['featured']): ?>
                            <div class="badge bg-primary position-absolute top-0 end-0 mt-2 me-2">Featured</div>
                        <?php endif; ?>
                        
                        <img src="<?php echo BASE_URL; ?>/assets/images/courses/<?php echo !empty($course['image_path']) ? $course['image_path'] : $course['slug'] . '.jpg'; ?>" 
                             class="card-img-top" 
                             alt="<?php echo htmlspecialchars($course['title']); ?> Course"
                             onerror="this.src='<?php echo BASE_URL; ?>/assets/images/course-placeholder.jpg'">
                        
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-light text-dark">
                                    <?php echo isset($course['category']) ? htmlspecialchars($course['category']) : 'Islamic Studies'; ?>
                                </span>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-star text-warning me-1"></i>
                                    <span><?php echo isset($course['rating']) ? $course['rating'] : '4.5'; ?> (<?php echo isset($course['reviews']) ? $course['reviews'] : '0'; ?>)</span>
                                </div>
                            </div>
                            
                            <h2 class="h5 card-title"><?php echo htmlspecialchars($course['title']); ?></h2>
                            <p class="card-text text-muted small"><?php echo substr(htmlspecialchars($course['description']), 0, 100); ?>...</p>
                            
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="fw-bold"><?php echo isset($course['price']) && $course['price'] > 0 ? '$' . $course['price'] : 'Free'; ?></span>
                                <span class="text-muted small">
                                    <i class="fas fa-book-open me-1"></i>
                                    <?php echo isset($course['lessons']) ? $course['lessons'] : '12'; ?> lessons
                                </span>
                            </div>
                        </div>
                        
                        <div class="card-footer bg-white border-top-0">
                            <a href="<?php echo BASE_URL; ?>/courses/<?php echo htmlspecialchars($course['slug']); ?>" class="btn btn-outline-primary d-block">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    No courses found. Please check back later.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('course-search');
    const filterSelect = document.getElementById('course-filter');
    const courseCards = document.querySelectorAll('.course-card');
    
    // Simple search functionality
    searchInput.addEventListener('input', filterCourses);
    filterSelect.addEventListener('change', filterCourses);
    
    function filterCourses() {
        const searchTerm = searchInput.value.toLowerCase();
        const filterValue = filterSelect.value.toLowerCase();
        
        courseCards.forEach(card => {
            const title = card.querySelector('.card-title').textContent.toLowerCase();
            const category = card.querySelector('.badge.bg-light').textContent.trim().toLowerCase();
            const description = card.querySelector('.card-text').textContent.toLowerCase();
            
            const matchesSearch = title.includes(searchTerm) || description.includes(searchTerm);
            const matchesFilter = filterValue === '' || category.includes(filterValue);
            
            card.closest('.col-md-6').style.display = (matchesSearch && matchesFilter) ? 'block' : 'none';
        });
    }
});
</script> 