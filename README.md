# E-Commerce Platform — Built for a Nepal-focused wholesale-to-retail business

A production-ready e-commerce application built with Laravel 11 and MySQL, styled with Tailwind CSS and enhanced with Alpine.js. This project was created as the technical foundation for a real business idea: selling products online in Nepal by sourcing them in bulk from China. The codebase implements buyer-facing storefront functionality and a full-featured admin panel so you can manage products, inventory, orders, users and analytics — everything needed to start an online retail business that scales.

This README summarizes what the code contains, how to run it locally, and practical recommendations and next steps to turn this project into a live, sellable product in Nepal.

---

Table of Contents
- Overview & Business Motive
- What’s implemented (features & code analysis)
- Tech stack & project layout
- Quick setup (local / dev)
- Production & deployment notes
- Business / operational recommendations for Nepal (payments, shipping, imports)
- What’s next to make it “sell-ready”
- Testing & QA checklist
- Contributing, support & license

---

Overview & business motive

This repository is more than a demo — it’s the engineering backbone for a small wholesale-to-retail e-commerce operation. The intended business model is:

- Buy products in bulk from China (sourcing & importing).
- List and sell those products online to Nepalese customers.
- Keep lean operations with a simple admin panel for inventory/order management and analytics to guide purchasing decisions.

The application is structured to support that model: product catalog with multiple images, inventory management / low-stock alerts, orders and order items, cart + checkout flow, reviews, admin analytics, and tools for managing site settings, FAQs and bug reports.

---

What’s implemented — features & code analysis

Key implemented features (buyer/customer)
- Product catalog with product detail pages and multiple product images.
- Shopping cart and checkout flow (order creation, order detail pages).
- User registration and authentication (with role separation).
- Reviews system (product reviews + optional review photos).
- Account pages: orders, order details, account settings, FAQs and a report-issue flow.
- Responsive Blade-based frontend with Tailwind CSS and Alpine.js + dark mode support.

Key implemented features (admin panel)
- Admin dashboard with statistics and charts (Chart.js used for analytics).
- Product management (CRUD), including multiple image uploads and product forms.
- Order management with status updates.
- Inventory management with low-stock alerts and inventory view.
- User management (view, block/unblock, delete).
- Bug report and FAQ management.
- Website settings (text that appears in footer, contact, etc.).
- Best-selling products & reporting pages.

Security, stability, and performance
- Bcrypt password hashing, CSRF protection, XSS protection (Blade escaping).
- Eloquent ORM to avoid raw SQL and reduce SQL injection risk.
- Rate limiting on login attempts and role-based access control using middleware.
- Secure file upload validation.
- Production optimizations included in the checklist: Vite, Tailwind purging, route/config/view caching, eager loading for common relationships.

Code composition and notable files
- Laravel 11 backend (PHP 8.2+ expected)
- routes/web.php — organizes routes including buyer and admin routes and a debug /api/test endpoint
- resources/views/ — Blade views split into buyer (guest/app) and admin folders
- app/Http/Controllers — multiple controllers (Auth, buyer controllers, admin controllers)
- app/Models — Eloquent models implementing relationships (products, users, orders, reviews, carts, etc.)
- database/migrations — 12 migrations including products, product_images, orders, order_items, carts, reviews, review_photos, faqs, settings, bug_reports
- database/seeders — seeders for users, products, FAQs and settings
- storage/ — file uploads and compiled views
- docker-compose.yml — ready-made MySQL docker configuration
- tailwind.config.js & vite.config.js — frontend build tooling
- package.json & composer.json — node and PHP dependency manifests

Development observations
- Middleware files include IsAdmin, IsBuyer, CheckBlocked to implement role enforcement and blocking behavior.
- There are 10+ controllers split between auth, buyer and admin responsibilities.
- Admin UI includes charts and visual cues for low stock and reports.
- Frontend uses Alpine.js, Tailwind, Font Awesome and is built with Vite for fast local development.

---

Tech stack

Backend
- Laravel 11, PHP 8.2+
- MySQL 8.0 (Dockerized)
- Eloquent ORM, migrations, seeders

Frontend
- Blade templating
- Tailwind CSS (with dark mode)
- Alpine.js
- Chart.js for admin analytics
- Font Awesome

Tools
- Vite build pipeline
- Docker + docker-compose (for MySQL)
- Composer, NPM

---

Quick setup (development)

Prerequisites
- PHP 8.2+, Composer
- Node.js v18+ and npm
- Docker & Docker Compose
- Git

Quick start (standard dev flow)
1. Clone the repo:
   git clone https://github.com/Nishchal-Panta/E-commerce_website.git
   cd E-commerce_website

2. Install backend dependencies:
   composer install

3. Install frontend dependencies and build assets:
   npm install
   npm run dev   # or `npm run build` for production bundles

4. Copy .env and set app configuration:
   cp .env.example .env
   # update DB connection to use docker container if desired (see docker-compose.yml)

5. Start MySQL (docker-compose is provided):
   docker-compose up -d
   # ensure DB host, user and password in .env match docker-compose settings

6. Migrate and seed:
   php artisan key:generate
   php artisan migrate --seed

7. Run the dev server:
   php artisan serve

Useful artisan commands
- Clear caches:
  php artisan cache:clear
  php artisan config:clear
  php artisan route:clear
  php artisan view:clear

- Fresh database (destructive):
  php artisan migrate:fresh --seed

- Route list:
  php artisan route:list

---

Production & deployment notes

Important production steps
- Configure .env for production (APP_ENV=production, secure APP_KEY, set DB credentials).
- Use queue workers for long-running tasks (emails, image processing).
- Configure cache & session driver (Redis recommended).
- Use HTTPS everywhere and set up an SSL certificate (Let’s Encrypt).
- Set appropriate file permissions for storage/ and bootstrap/cache/.
- Use backups for DB and storage; implement regular snapshotting.
- Monitor errors and performance (Sentry, NewRelic, or similar).

Suggested hosting & infra
- Use a VPS or cloud provider (DigitalOcean, AWS, GCP) with managed DB or a secure instance.
- Use a CDN for static assets for speed in Nepal.
- Consider object storage (S3 or S3-compatible) for images if you expect many uploads.

Database & scaling
- Add Redis for cache/session and to offload rate-limiting counters and queues.
- Use database indexes for heavy queries (orders, product searches).
- Use pagination and eager loading to prevent N+1 issues.

---

Business & operational recommendations for selling in Nepal

Payments
- Integrate Nepal-specific payment gateways: eSewa, Khalti, IME Pay, ConnectIPS if possible, plus local bank integrations and card payments (Stripe may not service Nepal directly).
- Offer cash-on-delivery as many customers in Nepal still prefer COD.
- Implement invoicing and receipts in Nepali/English; consider multi-currency display but settle in NPR.

Shipping & logistics
- Partner with local courier companies for domestic delivery (e.g., Nepal Post, private couriers).
- Build shipping rate rules (weight/volume, zones).
- Include expected delivery times and tracking (if available).

Import & sourcing (China → Nepal)
- Account for lead time, customs duties, VAT, and import process when setting pricing.
- Maintain an importer-facing inventory/purchase order workflow so you know when to reorder in bulk.
- Keep a spreadsheet or simple subsystem to compare landed costs per SKU (unit price + shipping + import fees + taxes).

Localization & compliance
- Use Nepali language support (Unicode UTF-8), local date/time, currency formatting (NPR).
- Ensure return policy, T&Cs and privacy policy are clearly visible.
- Comply with local regulations for e-commerce and taxes.

Pricing & catalog strategy
- Use margin calculators; show cost, markup and suggested retail price in admin.
- Start with a curated catalog (top-selling low-risk SKUs) rather than everything to simplify operations.

Marketing & growth
- Add social logins and email marketing integration (Mailchimp, similar).
- SEO-friendly product pages, meta tags and schema.org markup help organic discovery.
- Track analytics (Google Analytics) and use admin charts to drive purchase decisions.

---

What’s next to make it sell-ready (technical + operational)

Top-priority technical tasks
- Integrate at least one local payment gateway (eSewa or Khalti) and COD flow.
- Add order email notifications and SMS notifications (order confirmations, shipping updates).
- Add multi-warehouse or supplier indicators if you plan to manage stock across importer & retail inventory.
- Implement product import tooling (CSV/XLSX) for bulk product additions from supplier catalogs.
- Add basic audit logs for inventory / price changes.
- Set up scheduled tasks and queues for background processing.

Operational steps
- Finalize supplier relationships and define reorder points (use the inventory low-stock alerts already in the admin).
- Prepare product photography guidelines and ensure good image quality for listing trust.
- Create returns & refunds SOP and include it in site settings.

Monetization & sellability
- Add invoicing, order export for accounting, and exportable reports (CSV/PDF).
- Add admin role and permission granularity if other teammates will operate the site.

---

Testing & QA checklist (summary)

From the project’s TESTING_CHECKLIST.md and code review:
- Backend migrations & seeders executed and validated (completed).
- Frontend views and layout tested for responsiveness and dark mode (completed).
- Route & auth protection verified (IsAdmin / IsBuyer / CheckBlocked middleware in place).
- File upload validation and image resizing / validation present (confirm on staging).
- Performance: Vite, Tailwind purging, view/route/config caching applied; recommend load testing.

Recommended tests before production
- End-to-end checkout test (including payment gateway & order lifecycle).
- Import and inventory reconciliation test (supplier → admin → store).
- Security review: penetration test for file uploads, auth, rate limits.
- Backup & restore test (database + uploads).

---

Contributing
- Fork the repo, create a feature branch, and open a PR with a clear description and testing steps.
- For major features (payment gateways, shipping integration, supplier import), discuss proposed design in an issue first.
