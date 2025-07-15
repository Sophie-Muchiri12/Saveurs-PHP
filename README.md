# Saveurs - Restaurant Management System

A comprehensive restaurant management system built with PHP and MySQL, designed to streamline restaurant operations and enhance customer experience.

## 🍽️ Features

### Customer Features
- **Online Menu Browsing**: Browse through categorized menu items with detailed descriptions and prices
- **Table Reservation System**: Book tables for dining with preferred time slots
- **Order Management**: Place orders online for pickup or delivery
- **User Account Management**: Register, login, and manage personal profiles
- **Order History**: Track previous orders and reorder favorite items

### Admin Features
- **Menu Management**: Add, edit, delete, and categorize menu items
- **Order Processing**: View and manage incoming orders with status updates
- **Table Management**: Manage table reservations and availability
- **Customer Management**: View customer information and order history
- **Inventory Tracking**: Monitor stock levels and ingredient availability
- **Sales Analytics**: Generate reports on sales performance and popular items
- **Staff Management**: Manage employee accounts and permissions

### Restaurant Staff Features
- **Order Fulfillment**: Process orders and update order status
- **Table Service**: Manage table assignments and customer service
- **Kitchen Display**: View incoming orders with preparation details
- **Inventory Updates**: Update stock levels and notify of low inventory

## 🚀 Technology Stack

- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript
- **Framework**: Bootstrap 4/5 for responsive design
- **Additional Libraries**: jQuery, Font Awesome

## 📋 Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- Web browser (Chrome, Firefox, Safari, Edge)

## 🔧 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/Sophie-Muchiri12/Saveurs-PHP.git
   cd Saveurs-PHP
   ```

2. **Database Setup**
   - Create a MySQL database named `saveurs_db`
   - Import the SQL file: `database/saveurs_db.sql`
   - Update database credentials in `config/database.php`

3. **Configure Environment**
   ```php
   // config/database.php
   $servername = "localhost";
   $username = "your_username";
   $password = "your_password";
   $dbname = "saveurs_db";
   ```

4. **Web Server Setup**
   - Place the project folder in your web server directory (htdocs for XAMPP, www for WAMP)
   - Start Apache and MySQL services
   - Access the application at `http://localhost/Saveurs-PHP`

5. **Admin Access**
   - Default admin credentials:
     - Username: `admin`
     - Password: `admin123`
   - Change these credentials after first login

## 🎯 Usage

### For Customers
1. **Registration**: Create an account to place orders and make reservations
2. **Browse Menu**: Explore available dishes organized by categories
3. **Place Orders**: Add items to cart and proceed to checkout
4. **Make Reservations**: Book tables for your preferred date and time
5. **Track Orders**: Monitor order status and delivery updates

### For Administrators
1. **Dashboard**: Access comprehensive analytics and system overview
2. **Menu Management**: Add new dishes, update prices, and manage categories
3. **Order Processing**: Review, approve, and track all customer orders
4. **Reservation Management**: Manage table bookings and availability
5. **Reports**: Generate sales reports and customer analytics

## 📁 Project Structure

```
Saveurs-PHP/
├── admin/              # Admin panel files
├── assets/             # CSS, JS, images
├── config/             # Database configuration
├── customer/           # Customer interface
├── database/           # SQL files
├── includes/           # Common PHP files
├── staff/              # Staff interface
├── uploads/            # Image uploads
└── index.php           # Main entry point
```

## 🔐 Security Features

- Input validation and sanitization
- SQL injection prevention
- Session management
- Password hashing
- Role-based access control
- CSRF protection

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👥 Authors

- **Sophie Muchiri** - *Lead Developer* - [Sophie-Muchiri12](https://github.com/Sophie-Muchiri12)

## 🙏 Acknowledgments

- Thanks to all contributors and testers
- Bootstrap team for the responsive framework
- Font Awesome for icons
- The PHP community for excellent documentation

## 📧 Support

For support, email sophie.muchiri@example.com or create an issue in the repository.

## 🔄 Updates

- **Version 1.0.0**: Initial release with core functionality
- **Version 1.1.0**: Added inventory management
- **Version 1.2.0**: Enhanced reporting features

---

**Saveurs** - Bringing digital efficiency to restaurant management 🍽️✨
