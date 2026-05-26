# EcoStore: Radically Transparent Sustainable Fashion

[![Build Status](https://img.shields.io/badge/build-passing-brightgreen)](https://github.com/NiessenWaffer/EcoStore-Command-Center) [![License: MIT](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

EcoStore is a next-generation B2C e-commerce platform built to redefine the relationship between consumers and their apparel. This repository contains the full-stack Laravel application, featuring backend APIs, a Blade/Livewire web UI, and frontend assets built with Vite + Tailwind CSS.

## 🌟 Key Features (The 19-Plan Ecosystem)

We have successfully implemented a comprehensive circular economy platform. Key highlights include:

- **Circular Leasing Model:** Product-as-a-service with recurring Stripe billing and condition-tracking returns.
- **Immutable Trust Layer (Product Passports):** Cryptographic verification of product origin, factory audits, and transit carbon impact.
- **Resale & Trade-in Portal:** Automated store credit for returning past items to Local Hubs.
- **Decentralized Governance:** Quadratic voting for community-led resource allocation and feature direction.
- **Gamified Ambassador Network:** Tiered referral system and zero-return rewards.
- **Dynamic Carbon Gate Fees:** Real-time distance-based shipping penalties calculated via Haversine logic.

*Note: For detailed architectural blueprints and user workflows for all 20 plans, see the `List plan/` directory.*

## 🚀 Local Development (Laragon)

### Prerequisites
- PHP 8.3+
- Composer & Node.js (18+)
- MySQL / MariaDB
- Laragon (Recommended for Windows) or Laravel Valet (Mac)

### Setup Instructions

1. Clone the repository into your Laragon `www` folder.
2. Install PHP and Node dependencies:
   ```bash
   composer install
   npm install
   ```
3. Setup your environment variables:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Configure your database in `.env` (Laragon defaults: DB_HOST=127.0.0.1, DB_DATABASE=your_db, DB_USERNAME=root, DB_PASSWORD=)
5. Run migrations and seed the ecosystem (Brands, Hubs, Products, Passports):
   ```bash
   php artisan migrate:fresh --seed
   ```
6. Build frontend assets:
   ```bash
   npm run build
   ```
7. Access your application via Laragon's virtual host (e.g., `http://ecostore.test`) or use:
   ```bash
   php artisan serve
   ```

## ⚙️ Environment Variables (Important)

Add your API keys and credentials to `.env`:
- `OPENAI_API_KEY`: For the AI Stylist feature.
- `STRIPE_KEY` and `STRIPE_SECRET`: For payments and leasing subscriptions.
- `MAIL_*`: Settings for email delivery (Impact Recaps).

*Sensitive keys must never be committed to version control.*

## 🧪 Testing

Run the full PHPUnit integration suite:
```bash
php artisan test
```

## 🛠️ Common Artisan Commands

- **Send Impact Recaps:**
  ```bash
  php artisan app:send-impact-recap
  ```
- **Reward Zero-Return Shoppers:**
  ```bash
  php artisan app:reward-zero-returns
  ```

## 📜 License

This project is open-sourced software licensed under the **MIT license**.

---

**Built for the Planet. Radical Transparency. Ethical Style.**