# Library Management System

A comprehensive MVC-based library management system built with PHP.

## Project Structure

This project follows the MVC (Model-View-Controller) architectural pattern with the following structure:

### Directories

- **app/** - Application core
  - **controllers/** - Request handlers
    - **user/** - User-specific controllers
    - **admin/** - Admin-specific controllers
  - **models/** - Data models
  - **views/** - View templates
    - **layouts/** - Common layout files
    - **home/** - Public pages
    - **auth/** - Authentication pages
    - **user/** - User interface
    - **admin/** - Admin interface
  - **core/** - Framework core files

- **public/** - Web root (document root)
  - **css/** - Stylesheets
  - **js/** - JavaScript files
  - **images/** - Images and assets
  - **uploads/** - User uploads

- **config/** - Configuration files

## Installation

1. Clone the repository
2. Configure database in `config/database.php`
3. Create the required database
4. Set up your web server to point to the `public/` directory

## Features

### User Features
- Browse and search books
- Borrow books
- View borrow history
- Manage profile
- Receive notifications

### Admin Features
- Book management (CRUD)
- Category management
- User management
- Transaction management
- Notification system

## Technology Stack

- **Backend**: PHP 7.4+
- **Frontend**: HTML5, CSS3, JavaScript
- **Database**: MySQL

## License

MIT License
