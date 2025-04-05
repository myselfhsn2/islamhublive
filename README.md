# IslamHub - Islamic Learning Center Website

IslamHub is a modern, responsive website for an online Islamic learning center. The platform offers various Quranic courses with multiple pricing plans, user authentication, progress tracking, and WhatsApp integration for community engagement.

## Features

- **Course Management**: Detailed pages for Quran Reading, Memorization, and Translation/Tafseer courses
- **Flexible Pricing**: Three-tier payment system ($Flexible, $50, $100)
- **User Authentication**: Secure login and registration system
- **Progress Tracking**: Students can track their course progress
- **Dark Mode**: Toggle between light and dark themes
- **WhatsApp Integration**: Course-specific WhatsApp groups and broadcast channel
- **Responsive Design**: Fully mobile-friendly interface
- **SEO Optimized**: Proper meta tags and fast loading

## Technology Stack

- PHP (custom MVC architecture)
- MySQL (with SQL procedures and views)
- JavaScript (Ajax for dynamic content)
- HTML5 & CSS3
- Responsive design (mobile-first approach)

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/islamhub.git
   cd islamhub
   ```

2. Create a MySQL database named `islamhub`

3. Import the database schema:
   ```bash
   mysql -u username -p islamhub < database/schema.sql
   ```

4. Configure the database connection in `includes/config.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'your_username');
   define('DB_PASS', 'your_password');
   define('DB_NAME', 'islamhub');
   ```

5. Set up a virtual host or use PHP's built-in server:
   ```bash
   cd public
   php -S localhost:8000
   ```

6. Access the website at http://localhost:8000

## Project Structure

- `/app` - Application files
  - `/controllers` - Controller classes
  - `/models` - Database models
  - `/views` - View templates
- `/database` - Database schema and migrations
- `/includes` - Configuration and utility files
- `/public` - Publicly accessible files
  - `/assets` - CSS, JavaScript, and image files
  - `index.php` - Entry point

## Features to be Added

- Payment gateway integration
- Admin dashboard
- Video conferencing integration
- Downloadable course materials
- Mobile app integration

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Contact

For questions or support, please contact info@islamhub.org 