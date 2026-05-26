# EcoStore: Full-Stack Laravel (Laragon) — Radically Transparent Sustainable Fashion

[![Build Status](https://img.shields.io/badge/build-passing-brightgreen)](https://example.com) [![License: MIT](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE) [![Coverage](https://img.shields.io/badge/coverage-unknown-lightgrey)](https://example.com)

EcoStore is a next-generation B2C e-commerce platform built to redefine the relationship between consumers and their apparel. This repository is a full-stack Laravel application with backend APIs, Blade/Livewire web UI, and frontend assets built with Vite + Tailwind.

Planning docs: See "Planning mode/Planning.md" for project planning and decisions.



EcoStore is a next-generation B2C e-commerce platform built to redefine the relationship between consumers and their apparel. This repository is a full-stack Laravel application with backend APIs, Blade/Livewire web UI, and frontend assets built with Vite + Tailwind.

This README has been expanded with full-stack developer instructions for local development, testing, and deployment (Laragon and general setups).

## Prerequisites

- PHP 8.3+
- Composer
- Node.js (18+)
- NPM or Yarn
- MySQL / MariaDB (or use SQLite for quick testing)
- (Recommended for Windows) Laragon or Valet for Mac

## Local Development (Laragon)

1. Clone the repository into your Laragon www folder.
2. Start Laragon and create a site or use the built-in virtual host.
3. From the project root, install dependencies:

```bash
composer install
npm install
```

4. Copy env and generate key:

```bash
cp .env.example .env
php artisan key:generate
```

5. Configure database in `.env` (Laragon defaults: DB_HOST=127.0.0.1, DB_DATABASE=your_db, DB_USERNAME=root, DB_PASSWORD=)

6. Run migrations and seeders:

```bash
php artisan migrate --seed
# or
php artisan migrate:fresh --seed --class=SampleProductSeeder
```

7. Build frontend assets and run dev server:

```bash
npm run dev   # for local development (vite)
npm run build # production build
```

8. Serve the app (Laragon will serve automatically via virtual host) or use:

```bash
php artisan serve --host=127.0.0.1 --port=8000
```

## Environment variables (important)

Add API keys and credentials to `.env`:

- OPENAI_API_KEY=your_key
- STRIPE_KEY and STRIPE_SECRET for payments
- MAIL_* settings for email delivery

Sensitive keys must never be committed.

## Testing

Run PHPUnit tests:

```bash
vendor/bin/phpunit
```

Run frontend tests or linters if configured:

```bash
npm run test
npm run lint
```

## Common Artisan Commands

- Send Impact Recaps:

```bash
php artisan app:send-impact-recap
```

- Reward Zero-Return Shoppers:

```bash
php artisan app:reward-zero-returns
```

## Deployment

- Ensure `APP_ENV=production` and `APP_DEBUG=false` in `.env`.
- Build assets with `npm run build`.
- Run `php artisan migrate --force` on production.
- Use a process manager for queue workers (supervisor, systemd) and ensure cron runs `php artisan schedule:run` every minute.

## Docker (Optional)

A Docker setup is not included by default. For containerized deployments, use standard PHP-FPM + Nginx images and include a database service and queue worker.

## Contributing

- Fork the repo, create a feature branch, open a PR with a clear description and tests where applicable.
- Follow PSR standards and run static analysis/tests before submitting.

## License

This project is MIT licensed. Modify as needed.

---

Built for the Planet. Radical Transparency. Ethical Style.

# EcoStore-Command-Center
