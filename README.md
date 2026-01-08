# Cabana Haven Backend

A modern Laravel 12 REST API backend for managing hotel bookings and reservations at Cabana Haven.

## Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Running the Application](#running-the-application)
- [API Endpoints](#api-endpoints)
- [Database](#database)
- [Testing](#testing)
- [Project Structure](#project-structure)

## Features

- 🏨 **Booking Management** - Create, read, update, and delete hotel bookings
- 👤 **User Authentication** - Secure user registration and login with Laravel Sanctum
- 🔐 **Admin Panel** - Administrative authentication and user management
- 🗄️ **Database Migrations** - Schema versioning for reliable database management
- 📝 **Soft Deletes** - Recover deleted bookings when needed
- ✅ **Data Validation** - Built-in request validation for API endpoints
- 🧪 **Testing** - PHPUnit test suite for feature and unit tests

## Tech Stack

- **Framework**: [Laravel 12](https://laravel.com/docs)
- **PHP**: ^8.2
- **Authentication**: [Laravel Sanctum](https://laravel.com/docs/sanctum) 4.0
- **Database**: MySQL/PostgreSQL (configured via `.env`)
- **Build Tool**: Vite
- **Testing**: PHPUnit 11
- **Linting**: Laravel Pint

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js 16+ and npm/yarn
- MySQL 8.0+ or PostgreSQL 12+

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/cabana-haven-backend.git
   cd cabana-haven-backend
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Update `.env` with your database credentials**
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=cabana_haven
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```

   This will create all tables and seed the database with an admin user.

## Configuration

Key configuration files are located in the `config/` directory:

- `app.php` - Application name and timezone settings
- `database.php` - Database connection configuration
- `auth.php` - Authentication guards and providers
- `sanctum.php` - API token configuration

## Running the Application

### Development Mode

Start the development server with hot reload:

```bash
composer run dev
```

This command starts:
- PHP artisan server
- Queue listener
- Pail logs
- Vite development server

### Production Server

```bash
php artisan serve
```

The API will be available at `http://localhost:8000`

## API Endpoints

### Bookings

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/bookings` | List all bookings |
| POST | `/api/bookings` | Create a new booking |
| GET | `/api/bookings/{id}` | Get booking details |
| PUT | `/api/bookings/{id}` | Update a booking |
| DELETE | `/api/bookings/{id}` | Delete a booking |
| GET | `/api/booking/status/{deleted}` | Filter bookings by status |

### Authentication

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/user` | Get current authenticated user |
| POST | `/api/admin/login` | Admin login |

### Booking Model

```php
{
    "name": "John Doe",
    "initials": "JD",
    "identity_number": "123456789",
    "contact": "+1234567890",
    "checking_date": "2026-01-15",
    "checkout_date": "2026-01-20",
    "room_type": "deluxe",
    "number_of_guest": 2,
    "status": "confirmed"
}
```

## Database

### Migrations

All database schema changes are managed through migrations in `database/migrations/`:

- `create_users_table.php` - User accounts
- `create_personal_access_tokens_table.php` - API tokens (Sanctum)
- `create_bookings_table.php` - Booking records
- `add_admin_fields_to_users_table.php` - Admin user fields

### Seeders

Database seeders are located in `database/seeders/`:

- `AdminUserSeeder.php` - Creates default admin user
- `DatabaseSeeder.php` - Main seeder orchestrator

**Reset Database:**
```bash
php artisan migrate:fresh --seed
```

## Testing

Run the test suite:

```bash
composer run test
```

Tests are organized in `tests/` directory:
- `Feature/` - Feature and integration tests
- `Unit/` - Unit tests

## Project Structure

```
├── app/
│   ├── Http/
│   │   ├── Controllers/        # API controllers
│   │   ├── Middleware/         # Custom middleware
│   │   └── Requests/           # Form request validation
│   ├── Models/                 # Eloquent models
│   └── Providers/              # Service providers
├── config/                     # Configuration files
├── database/
│   ├── migrations/             # Database migrations
│   ├── seeders/                # Database seeders
│   └── factories/              # Model factories for testing
├── routes/                     # Route definitions
│   ├── api.php                 # API routes
│   └── web.php                 # Web routes
├── tests/                      # Test suite
├── storage/                    # Logs, cache, uploads
├── .env.example                # Environment variables template
├── composer.json               # PHP dependencies
└── package.json                # JavaScript dependencies
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
