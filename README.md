# Civic Sense: Urgent Need of Society

A comprehensive full-stack web application designed to address problems caused by the lack of civic sense in society and provide solutions, awareness, and a communication platform with authorities.

## 🌟 Features

### Core Functionality
- **User Authentication System** - Sign up, login, logout with secure password hashing
- **Problem Reporting** - Report civic issues with categories, locations, and priority levels
- **Solution Sharing** - Share and discover solutions to civic problems
- **Community Forum** - Interactive discussions with like and comment system
- **Educational Resources** - Guidelines, case studies, videos, and interactive learning
- **Contact & Support** - Direct communication with administrators

### Key Sections
1. **Home Page** - Introduction and main issues overview
2. **Problems Section** - Road discipline, transport, cleanliness, education, etc.
3. **Solutions Section** - Best practices and international examples
4. **Forum** - Community discussions and idea sharing
5. **Resources** - Educational content and learning materials
6. **Contact** - Issue reporting and communication forms

## 🛠️ Technology Stack

- **Backend**: PHP (Native)
- **Database**: MySQL
- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **UI Framework**: Bootstrap 5.3.0
- **Icons**: Font Awesome 6.4.0
- **Fonts**: Google Fonts (Poppins)
- **Responsive Design**: Mobile-first approach

## 📁 Project Structure

```
civic-sense-app/
├── index.php                 # Main entry point and routing
├── config/
│   └── database.php         # Database configuration and table creation
├── includes/
│   ├── header.php           # HTML head and navigation
│   ├── footer.php           # Footer and JavaScript includes
│   ├── navigation.php       # Navigation component
│   └── functions.php        # Utility functions and database operations
├── pages/
│   ├── home.php             # Homepage with hero section
│   ├── problems.php         # Problem reporting and listing
│   ├── solutions.php        # Solutions and best practices
│   ├── forum.php            # Community discussion forum
│   ├── resources.php        # Educational resources
│   ├── contact.php          # Contact forms and issue reporting
│   ├── login.php            # User authentication
│   └── register.php         # User registration
├── assets/
│   ├── css/
│   │   └── style.css        # Custom stylesheets
│   └── js/
│       └── main.js          # Main JavaScript functionality
└── README.md                # Project documentation
```

## 🚀 Installation & Setup

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx) or PHP built-in server
- Modern web browser

### Step 1: Clone/Download Project
```bash
# Clone the repository
git clone <repository-url>
cd civic-sense-app

# Or download and extract the ZIP file
```

### Step 2: Database Setup
1. Create a MySQL database:
```sql
CREATE DATABASE civic_sense_db;
```

2. Update database credentials in `config/database.php`:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'civic_sense_db');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
```

3. The application will automatically create all necessary tables on first run.

### Step 3: Web Server Configuration

#### Option A: PHP Built-in Server (Development)
```bash
# Navigate to project directory
cd civic-sense-app

# Start PHP server
php -S localhost:8000

# Open browser and visit: http://localhost:8000
```

#### Option B: Apache/Nginx (Production)
1. Copy project files to your web server directory
2. Ensure PHP and MySQL are properly configured
3. Set appropriate file permissions
4. Configure virtual host if needed

### Step 4: Access Application
Open your web browser and navigate to:
- **Local Development**: `http://localhost:8000`
- **Production**: `http://your-domain.com`

## 🔧 Configuration

### Database Tables
The application automatically creates these tables:
- `users` - User accounts and authentication
- `problems` - Reported civic issues
- `solutions` - Solutions to problems
- `forum_posts` - Forum discussions
- `comments` - User comments on posts
- `likes` - User likes on posts
- `contact_submissions` - Contact form submissions
- `issue_reports` - Detailed issue reports

### Customization
- **Colors**: Modify CSS variables in `includes/header.php`
- **Content**: Edit page content in respective PHP files
- **Categories**: Update problem categories in `includes/functions.php`
- **Features**: Add new functionality by extending the existing structure

## 📱 Features Overview

### User Management
- Secure user registration and login
- Password hashing with PHP's built-in functions
- Session-based authentication
- User roles (user/admin)

### Problem Reporting
- Categorized issue reporting
- Location-based problem tracking
- Priority levels (low, medium, high, urgent)
- Status tracking (open, in progress, resolved)

### Community Features
- Interactive forum with posts and comments
- Like/unlike functionality
- Search and filter capabilities
- User engagement tracking

### Educational Content
- Civic sense guidelines
- International case studies
- Interactive quizzes and scenarios
- Downloadable resources
- Video content integration

## 🔒 Security Features

- **SQL Injection Protection**: Prepared statements with PDO
- **XSS Prevention**: Input sanitization and output escaping
- **CSRF Protection**: Form validation and session management
- **Password Security**: Secure hashing with PASSWORD_DEFAULT
- **Input Validation**: Server-side validation for all forms

## 📱 Responsive Design

- Mobile-first approach
- Bootstrap 5 responsive grid system
- Optimized for all device sizes
- Touch-friendly interface elements
- Progressive enhancement

## 🚀 Future Enhancements

### Planned Features
- **Multilingual Support** - Multiple language options
- **Google Maps Integration** - Location-based problem reporting
- **Real-time Notifications** - Push notifications for updates
- **Mobile App** - Native mobile applications
- **Analytics Dashboard** - User engagement and issue tracking
- **API Development** - RESTful API for third-party integration

### Campaign Features
- **Awareness Campaigns** - Educational campaigns
- **Community Events** - Local event organization
- **Volunteer Management** - Community service coordination
- **Progress Tracking** - Issue resolution monitoring

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📄 License

This project is open source and available under the [MIT License](LICENSE).

## 📞 Support

For support and questions:
- **Email**: info@civicsense.org
- **Website**: [civicsense.org](https://civicsenseproject-production.up.railway.app/)
- **Documentation**: Check this README and inline code comments

## 🙏 Acknowledgments

- Bootstrap team for the excellent UI framework
- Font Awesome for beautiful icons
- Google Fonts for typography
- PHP community for robust backend solutions
- All contributors and community members

---

**Made with ❤️ for a better society**

*Building civic responsibility through technology and community engagement.*

