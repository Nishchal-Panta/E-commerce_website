# E-Commerce Platform - Laravel 11 + MySQL

A comprehensive, production-ready e-commerce web application built with **Laravel 11**, **MySQL 8.0**, **Tailwind CSS**, and **Alpine.js**. Features include user authentication, product management, shopping cart, order processing, reviews, admin panel, and more.

---

## 📋 Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Configuration](#configuration)
- [Database Setup](#database-setup)
- [Running the Application](#running-the-application)
- [Default Credentials](#default-credentials)
- [Project Structure](#project-structure)
- [Key Features](#key-features)
- [Testing Checklist](#testing-checklist)
- [Deployment](#deployment)
- [Troubleshooting](#troubleshooting)
- [License](#license)

---

## ✨ Features

### Buyer/Customer Features
- ✅ User registration with profile photo upload
- ✅ Secure login with "Remember Me" functionality
- ✅ Password strength indicator during registration
- ✅ Product browsing with advanced filters (category, brand, color, size, price)
- ✅ Product search functionality
- ✅ Trending products carousel
- ✅ Detailed product pages with reviews and ratings
- ✅ Shopping cart with quantity management
- ✅ Checkout process with shipping address and payment method selection
- ✅ Order history and tracking
- ✅ Product reviews with photo uploads (only for purchased products)
- ✅ Account settings management
- ✅ FAQ page
- ✅ Bug/Issue reporting system
- ✅ Dark/Light mode toggle

### Admin Panel Features
- ✅ Comprehensive dashboard with statistics and charts
- ✅ Product management (CRUD operations)
- ✅ Multiple product image uploads
- ✅ Order management with status updates
- ✅ Inventory management with low stock alerts
- ✅ User management (view, block/unblock, delete)
- ✅ Bug report management
- ✅ Website settings configuration
- ✅ Best-selling products analytics

### Security Features
- ✅ Bcrypt password hashing
- ✅ CSRF protection
- ✅ SQL injection prevention (Eloquent ORM)
- ✅ XSS protection (Blade templating)
- ✅ Rate limiting on login attempts
- ✅ Role-based access control (Admin/Buyer)
- ✅ User blocking functionality
- ✅ Secure file uploads with validation

---

## 🛠 Tech Stack

**Backend:**
- Laravel 11.x
- PHP 8.2+
- MySQL 8.0+ (Dockerized)
- Eloquent ORM

**Frontend:**
- Blade Templates
- Tailwind CSS 3.4
- Alpine.js 3.x
- Font Awesome 6.4
- Chart.js (for admin analytics)

**Tools:**
- Docker & Docker Compose (for MySQL)
- Vite (asset bundling)
- Composer (PHP dependencies)
- NPM (frontend dependencies)

---

## 📦 Prerequisites

Before you begin, ensure you have the following installed:

- **PHP 8.2 or higher**
- **Composer** (latest version)
- **Node.js** (v18 or higher) and **NPM**
- **Docker** and **Docker Compose**
- **Git**

### Check your versions:
```bash
php -v
composer -V
node -v
npm -v
docker --version
docker-compose --version
```

---

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone <your-repository-url>
cd laravel_project
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node Dependencies

```bash
npm install
```

### 4. Environment Configuration

Copy the example environment file:

```bash
copy .env.example .env
```

**Windows PowerShell:**
```powershell
Copy-Item .env.example .env
```

---

## ⚙️ Configuration

### 1. Generate Application Key

```bash
php artisan key:generate
```

### 2. Configure Database

The `.env` file is already configured for the MySQL Docker container. Verify these settings:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce_db
DB_USERNAME=ecommerce_user
DB_PASSWORD=ecommerce_secure_pass_2026
```

### 3. Start MySQL Docker Container

```bash
docker-compose up -d
```

This will start a MySQL 8.0 container on port 3306.

**Verify the container is running:**
```bash
docker ps
```

---

## 🗄️ Database Setup

### 1. Run Migrations

```bash
php artisan migrate
```

This creates all necessary tables:
- users
- products
- product_images
- orders
- order_items
- carts
- reviews
- review_photos
- bug_reports
- faqs
- settings

### 2. Seed Database

```bash
php artisan db:seed
```

This will create:
- **Admin user:** admin@ecommerce.com / Admin@123
- **Sample buyer users:** john@example.com / Password@123
- **20 sample products** across various categories
- **15 FAQ entries**
- **Website settings**

### 3. Create Storage Link

```bash
php artisan storage:link
```

This creates a symbolic link from `public/storage` to `storage/app/public` for file uploads.

---

## ▶️ Running the Application

### 1. Build Frontend Assets

**Development mode:**
```bash
npm run dev
```

**Production mode:**
```bash
npm run build
```

### 2. Start Laravel Development Server

Open a new terminal and run:

```bash
php artisan serve
```

The application will be available at: **http://localhost:8000**

---

## 🔑 Default Credentials

### Admin Account
- **Email:** admin@ecommerce.com
- **Password:** Admin@123
- **Access:** http://localhost:8000/admin/dashboard

### Sample Buyer Account
- **Email:** john@example.com
- **Password:** Password@123

### MySQL Database (Docker)
- **Root Password:** root_secure_password_2026
- **Database:** ecommerce_db
- **Username:** ecommerce_user
- **Password:** ecommerce_secure_pass_2026
- **Port:** 3306

---

## 📁 Project Structure

```
laravel_project/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/          # Authentication controllers
│   │   │   ├── Admin/         # Admin panel controllers
│   │   │   └── ...            # Buyer controllers
│   │   └── Middleware/        # Custom middleware (IsAdmin, IsBuyer, CheckBlocked)
│   ├── Models/                # Eloquent models with relationships
│   └── Providers/             # Service providers
├── database/
│   ├── migrations/            # Database migration files
│   └── seeders/               # Database seeders
├── resources/
│   ├── views/
│   │   ├── layouts/           # Master layouts (app, admin, guest)
│   │   ├── auth/              # Login & registration views
│   │   ├── buyer/             # Customer-facing views
│   │   └── admin/             # Admin panel views
│   ├── css/
│   │   └── app.css            # Tailwind CSS configuration
│   └── js/
│       ├── app.js             # Alpine.js initialization
│       └── bootstrap.js       # Axios configuration
├── routes/
│   └── web.php                # Application routes
├── public/                    # Public assets
├── storage/                   # File uploads
├── docker-compose.yml         # MySQL Docker configuration
├── tailwind.config.js         # Tailwind CSS configuration
├── vite.config.js             # Vite configuration
├── composer.json              # PHP dependencies
└── package.json               # Node dependencies
```

---

## 🎯 Key Features

### Authentication System
- **Registration:** Profile photo upload, username validation, strong password requirements with strength indicator
- **Login:** Email/password with "Remember Me", rate limiting (5 attempts/minute)
- **Security:** Bcrypt hashing, CSRF protection, blocked user checking

### Product Management
- **Filters:** Category, brand, color, size, price range
- **Search:** Full-text search on name and description
- **Trending Products:** Auto-sliding carousel on homepage
- **Product Details:** Images, description, reviews, stock status, related products

### Shopping Cart & Checkout
- **Cart Operations:** Add, update quantity, remove items
- **Real-time Calculations:** Subtotal, tax (10%), shipping (free over $100)
- **Stock Validation:** Checks availability before checkout
- **Order Creation:** Database transaction ensures data integrity

### Reviews System
- **Purchase Verification:** Only purchasers can review
- **One Review Per User:** Prevents duplicate reviews
- **Photo Uploads:** Multiple photos per review
- **Rating Breakdown:** Visual percentage display

### Admin Dashboard
- **Statistics Cards:** Products, orders, revenue, pending orders
- **Charts:** Best-selling products with Chart.js
- **Low Stock Alerts:** Visual badges and notifications
- **Recent Orders:** Quick overview table

---

## ✅ Testing Checklist

Before deploying, verify:

- [ ] User registration with all validations works
- [ ] Login with "remember me" persists session
- [ ] Password strength indicator displays correctly
- [ ] Product search returns accurate results
- [ ] All filters (category, brand, color, price) function properly
- [ ] Shopping cart add/update/remove operations work
- [ ] Checkout creates order and updates inventory
- [ ] Reviews can only be submitted by purchasers
- [ ] Admin can add/edit/delete products
- [ ] Admin can update order status
- [ ] Low stock alerts appear in admin panel
- [ ] Admin can block/unblock users
- [ ] Blocked users cannot access buyer features
- [ ] File uploads (profile photos, product images, review photos) work
- [ ] Dark mode toggle functions correctly
- [ ] All pages are responsive on mobile devices
- [ ] Pagination works on product listings and admin tables

---

## 🌐 Deployment

### Prepare for Production

1. **Set Environment:**
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

2. **Optimize Laravel:**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

3. **Build Production Assets:**
```bash
npm run build
```

4. **Set Permissions:**
```bash
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage
```

5. **Configure Web Server:**
   - Point document root to `public/` folder
   - Enable URL rewriting (Apache: mod_rewrite, Nginx: try_files)
   - Set up SSL certificate (Let's Encrypt recommended)

6. **Database:**
   - Use production MySQL instance (not Docker in production)
   - Set strong passwords
   - Enable automated backups

### Environment Variables for Production

Update `.env`:
```env
APP_ENV=production
APP_DEBUG=false
DB_HOST=your-production-db-host
DB_DATABASE=your-production-database
DB_USERNAME=your-production-user
DB_PASSWORD=your-strong-password
```

---

## 🐛 Troubleshooting

### MySQL Connection Issues

**Error:** `SQLSTATE[HY000] [2002] Connection refused`

**Solution:**
1. Verify Docker container is running: `docker ps`
2. Check MySQL is listening: `docker-compose logs mysql`
3. Restart container: `docker-compose restart mysql`

### Migration Errors

**Error:** `Base table or view already exists`

**Solution:**
```bash
php artisan migrate:fresh --seed
```
**Warning:** This drops all tables and recreates them.

### Permission Errors

**Error:** `The stream or file could not be opened`

**Solution:**
```bash
chmod -R 775 storage bootstrap/cache
```

### Assets Not Loading

**Error:** CSS/JS files return 404

**Solution:**
1. Rebuild assets: `npm run build`
2. Clear cache: `php artisan cache:clear`
3. Recreate storage link: `php artisan storage:link`

### Vite Connection Refused

**Error:** `Failed to fetch dynamically imported module`

**Solution:**
- Run `npm run dev` in a separate terminal while developing
- For production, run `npm run build` before deploying

---

## 📝 Additional Commands

### Clear All Caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Database Fresh Start
```bash
php artisan migrate:fresh --seed
```

### Check Routes
```bash
php artisan route:list
```

### Stop MySQL Docker Container
```bash
docker-compose down
```

---

## 📚 Resources

- **Laravel Documentation:** https://laravel.com/docs/11.x
- **Tailwind CSS:** https://tailwindcss.com/docs
- **Alpine.js:** https://alpinejs.dev/
- **Docker:** https://docs.docker.com/

---

## 👨‍💻 Development Notes

### Code Principles
- Follow Laravel conventions and best practices
- Keep controllers thin, business logic in models
- Use Eloquent relationships instead of manual joins
- Leverage Laravel Collections for data manipulation
- Comment complex logic for maintainability

### Security Best Practices
- Never commit `.env` file to version control
- Use environment variables for sensitive data
- Validate all user inputs
- Sanitize file uploads
- Implement rate limiting on sensitive endpoints
- Keep Laravel and dependencies updated

---

## 📄 License

This project is open-source and available under the MIT License.

---

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch: `git checkout -b feature-name`
3. Commit changes: `git commit -m 'Add feature'`
4. Push to branch: `git push origin feature-name`
5. Submit a pull request

---

## 📧 Support

For issues or questions:
- Create an issue on GitHub
- Email: support@ecommerce.com

---

**Built with ❤️ using Laravel 11, Tailwind CSS, and Alpine.js**
