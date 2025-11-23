# Freelancer Panel

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="320" alt="Laravel Logo"></a></p>

A self-hosted invoicing and customer management panel built on Laravel and Filament. This repository contains the backend and admin UI used to manage companies, customers, invoices, expenses, projects, and time records.

> Assumptions: project name inferred from repository folder `freelancer-panel`. Composer scripts in `composer.json` provide helpful setup commands (see `composer.json` for more).

## Quick overview

- Framework: Laravel ^12
- PHP: ^8.3
- Admin UI: Filament 4
- Testing: Pest
- Frontend build: Vite, Node/npm

## Requirements

- PHP 8.3 or newer
- Composer
- Node.js (16+) and npm or yarn
- Database: SQLite, MySQL, or PostgreSQL

## Getting started (development)

1. Clone the repository and enter the folder:

```bash
git clone https://github.com/pmcfernandes/freelancer-panel
cd freelancer-panel
```

2. Install PHP dependencies and frontend packages:

```bash
composer install
npm install
```

3. Copy the environment file and generate an application key:

```bash
# Windows (cmd.exe)
copy .env.example .env
# then
php artisan key:generate
```

4. Configure your `.env` (database, mail, queue). Example SQLite config (quick dev setup):

```dotenv
# .env
DB_CONNECTION=sqlite
DB_DATABASE=${PWD}\\database\\database.sqlite
```

You can also use MySQL / MariaDB:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=freelancer_panel
DB_USERNAME=root
DB_PASSWORD=secret
```

If you use SQLite, ensure the file exists:

```bash
# Create sqlite file (Windows)
php -r "file_exists('database\\database.sqlite') || touch('database\\database.sqlite');"
```

5. Run migrations (and seeders if desired):

```bash
php artisan migrate
php artisan db:seed
```

6. Build assets or start dev watcher:

```bash
# Build for production
npm run build
# Or start dev server with hot reload
npm run dev
```

7. Serve the application:

```bash
php artisan serve
# Visit http://127.0.0.1:8000
```

The repository also includes helper Composer scripts (see `composer.json`) such as `composer setup` which runs install, copies env, generates key, migrates, and builds assets.

## Testing

Run the project's test suite with Pest / PHPUnit:

```bash
php artisan test
# or
./vendor/bin/pest
```

## Common tasks

- Run database migrations: `php artisan migrate`
- Rollback last migration: `php artisan migrate:rollback`
- Create a new migration: `php artisan make:migration create_foo_table`
- Create a model + migration: `php artisan make:model Foo -m`
- Clear configuration cache: `php artisan config:clear`

## Environment variables (important)

Keep sensitive credentials out of version control. Typical `.env` values to check:

- APP_NAME, APP_ENV, APP_KEY, APP_URL
- DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
- MAIL_MAILER, MAIL_HOST, MAIL_PORT, MAIL_USERNAME, MAIL_PASSWORD, MAIL_FROM_ADDRESS
- QUEUE_CONNECTION

## Deployment notes

- Ensure `APP_ENV=production` and `APP_DEBUG=false` in production.
- Run `php artisan migrate --force` during deploy to apply migrations.
- Use a process manager (Supervisor, systemd) for queue workers.
- Configure a proper cache and session driver for production (Redis recommended).

## Contribution

Contributions are welcome. Please open issues or pull requests with clear descriptions. Keep changes small and focused; add tests for new behavior.

## License

This project is licensed under the MIT License. See the `LICENSE` file for details.

---

If you'd like, I can also:
- Add a minimal `.env.example` snippet with the most important variables.
- Create a short `CONTRIBUTING.md` with developer setup notes.
