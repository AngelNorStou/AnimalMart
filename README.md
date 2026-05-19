# 🐾 AnimalMart - Pet Services Appointment Booking System

[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D7.4-blue)](https://php.net)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

A modern, secure full-stack web application for booking pet-related services including grooming, veterinary checkups, and training sessions. Built with PHP following MVC architecture and best security practices.

![AnimalMart Banner]

## ✨ Features

- 🔐 **Secure Authentication** - Password hashing with bcrypt and PDO prepared statements
- 📅 **Smart Booking System** - View and book available appointment slots
- 🐶 **Multiple Pet Services** - Grooming, veterinary, training, and more
- 👤 **User Dashboard** - Manage your bookings and pet profiles
- 🛡️ **Admin Panel** - Service and appointment management
- 📱 **Responsive Design** - Works seamlessly on desktop and mobile
- 🎨 **Modern UI** - Clean, intuitive interface with smooth animations

## 🚀 Quick Start

### Prerequisites

- PHP >= 7.4
- MySQL/MariaDB
- Apache/Nginx
- Composer

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/AngelNorStou/AnimalMart.git
   cd AnimalMart
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Database Setup**
   ```bash
   # Import the database schema
   mysql -u root -p < SQL/animalmart.sql
   ```

4. **Configure Database**
   
   Edit `config/database.php`:
   ```php
   private $host = "localhost";
   private $db_name = "animalmart";
   private $username = "your_username";
   private $password = "your_password";
   ```

5. **Start Development Server**
   ```bash
   php -S localhost:8000 -t public
   ```

6. **Access the Application**
   
   Open your browser and navigate to: `http://localhost:8000/view/Home.php`



## 🔒 Security Features

- ✅ PDO Prepared Statements (SQL Injection Prevention)
- ✅ Password Hashing (bcrypt)
- ✅ CSRF Token Protection
- ✅ XSS Prevention
- ✅ Input Validation & Sanitization
- ✅ Session Security

## 🛠️ Technology Stack

| Technology | Purpose |
|------------|---------|
| **PHP 7.4+** | Backend logic |
| **MySQL** | Database |
| **PDO** | Secure database access |
| **HTML5/CSS3** | Frontend structure |
| **JavaScript** | Interactive features |
| **Composer** | Dependency management |

## 📖 Usage

### For Customers

1. **Register/Login** to your account
2. **Browse Services** available for your pets
3. **Select Date & Time** for your appointment
4. **Book** and receive confirmation
5. **Manage** your bookings from your dashboard

### For Administrators

1. Login with admin credentials
2. Add/edit/delete services
3. View all appointments
4. Manage user accounts
5. Generate reports

## 🧪 Testing

```bash
# Run PHPUnit tests
composer test
```

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request


## 🐛 Known Issues

See the [issues page](https://github.com/AngelNorStou/AnimalMart/issues) for a list of known issues and feature requests.

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👨‍💻 Author

**AngelNorStou**
- GitHub: [@AngelNorStou](https://github.com/AngelNorStou)

**sabrinapags**
- GitHub: [@sabrinapags](https://github.com/sabrinapags)


## 🙏 Acknowledgments

- Thanks to all contributors
- Inspired by modern pet service platforms
- Built with love for pet owners 🐾

## 📞 Support

If you encounter any issues or have questions:
- Open an [issue](https://github.com/AngelNorStou/AnimalMart/issues)

---

⭐ If you found this project helpful, please consider giving it a star!