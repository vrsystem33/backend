# ERP SaaS API

This project provides a RESTful API built with Laravel 10 for a multi-tenant ERP platform. The API follows clean architecture principles and uses the repository and service layers for business logic.

## Requirements
- PHP 8.1+
- Composer
- MySQL or compatible database

## Setup
1. Clone the repository and install the dependencies:
   ```bash
   git clone https://github.com/vrsystem33/backend.git
   cd backend
   composer install
   ```
2. Copy the example environment file and generate the application key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
3. Configure your database credentials in `.env` and run the migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```
4. Install Passport for API authentication:
   ```bash
   php artisan passport:install
   ```
5. Start the local development server:
   ```bash
   php artisan serve
   ```

## Testing
Run the automated tests using PHPUnit:
```bash
php artisan test
```

## Coding standards
- Controllers delegate logic to Services.
- Repositories encapsulate persistence operations.
- Requests handle validation with friendly error messages.

## Contributing
Pull requests are welcome. For major changes, open an issue first to discuss what you would like to change.

