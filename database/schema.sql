-- IslamHub Database Schema

-- Drop tables if they exist
DROP TABLE IF EXISTS payments;
DROP TABLE IF EXISTS user_progress;
DROP TABLE IF EXISTS courses;
DROP TABLE IF EXISTS password_resets;
DROP TABLE IF EXISTS remember_tokens;
DROP TABLE IF EXISTS users;

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone_number VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    preferences JSON,
    is_active BOOLEAN DEFAULT TRUE
);

-- Remember Me tokens table
CREATE TABLE remember_tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token VARCHAR(255) NOT NULL,
    expires_at DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX (token),
    INDEX (user_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Password Reset tokens table
CREATE TABLE password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token VARCHAR(255) NOT NULL,
    expires_at DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX (token),
    INDEX (user_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Courses table
CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT NOT NULL,
    curriculum TEXT NOT NULL,
    image_path VARCHAR(255),
    whatsapp_group VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- User progress table
CREATE TABLE user_progress (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    progress_percentage DECIMAL(5,2) DEFAULT 0.00,
    last_activity TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    completed BOOLEAN DEFAULT FALSE,
    notes TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    UNIQUE KEY user_course (user_id, course_id)
);

-- Payments table
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    payment_method VARCHAR(50) NOT NULL,
    transaction_id VARCHAR(100),
    status VARCHAR(20) NOT NULL DEFAULT 'pending',
    plan_type ENUM('flexible', 'standard', 'premium') NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- Insert default courses
INSERT INTO courses (title, slug, description, curriculum, whatsapp_group) VALUES
('Quran Reading', 'quran-reading', 'Learn to read the Quran with proper tajweed rules.', 'Week 1: Introduction to Arabic alphabets\nWeek 2: Pronunciation of letters\nWeek 3: Connecting letters\nWeek 4: Introduction to Tajweed\nWeek 5-8: Reading practice', 'https://chat.whatsapp.com/quranreading'),
('Quran Memorization', 'quran-memorization', 'Memorize the Quran with proper understanding and revision techniques.', 'Week 1: Memorization techniques\nWeek 2: Setting goals and plans\nWeek 3-10: Structured memorization\nWeek 11-12: Revision techniques', 'https://chat.whatsapp.com/quranmemo'),
('Quran Translation and Tafseer', 'quran-tafseer', 'Understand the meaning and context of Quranic verses.', 'Week 1: Introduction to Tafseer\nWeek 2: Historical context\nWeek 3-4: Word-by-word translation\nWeek 5-12: Deep dive into selected surahs', 'https://chat.whatsapp.com/qurantafseer');

-- Create view for course enrollment stats
CREATE VIEW course_enrollment_stats AS
SELECT 
    c.id AS course_id,
    c.title AS course_title,
    COUNT(p.id) AS total_enrollments,
    SUM(CASE WHEN p.plan_type = 'flexible' THEN 1 ELSE 0 END) AS flexible_plan_count,
    SUM(CASE WHEN p.plan_type = 'standard' THEN 1 ELSE 0 END) AS standard_plan_count,
    SUM(CASE WHEN p.plan_type = 'premium' THEN 1 ELSE 0 END) AS premium_plan_count,
    AVG(p.amount) AS average_payment
FROM 
    courses c
LEFT JOIN 
    payments p ON c.id = p.course_id
WHERE 
    p.status = 'completed'
GROUP BY 
    c.id, c.title;

-- Stored procedure for user enrollment (without DELIMITER)
CREATE PROCEDURE enroll_user_in_course(
    IN p_user_id INT,
    IN p_course_id INT,
    IN p_amount DECIMAL(10,2),
    IN p_payment_method VARCHAR(50),
    IN p_plan_type VARCHAR(20)
)
BEGIN
    -- Insert payment record
    INSERT INTO payments (user_id, course_id, amount, payment_method, plan_type, status)
    VALUES (p_user_id, p_course_id, p_amount, p_payment_method, p_plan_type, 'completed');
    
    -- Create progress record
    INSERT INTO user_progress (user_id, course_id)
    VALUES (p_user_id, p_course_id)
    ON DUPLICATE KEY UPDATE last_activity = CURRENT_TIMESTAMP;
    
    -- Return success message
    SELECT 'User enrolled successfully' AS message;
END;

-- Stored procedure for user progress update (without DELIMITER)
CREATE PROCEDURE update_user_progress(
    IN p_user_id INT,
    IN p_course_id INT,
    IN p_progress_percentage DECIMAL(5,2)
)
BEGIN
    -- Update progress
    UPDATE user_progress
    SET 
        progress_percentage = p_progress_percentage,
        last_activity = CURRENT_TIMESTAMP,
        completed = CASE WHEN p_progress_percentage >= 100 THEN TRUE ELSE completed END
    WHERE 
        user_id = p_user_id AND course_id = p_course_id;
    
    -- Return updated progress
    SELECT 
        up.progress_percentage,
        up.completed,
        c.title AS course_title
    FROM 
        user_progress up
    JOIN 
        courses c ON up.course_id = c.id
    WHERE 
        up.user_id = p_user_id AND up.course_id = p_course_id;
END; 