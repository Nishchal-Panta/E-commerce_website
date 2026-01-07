# Admin Panel Access Guide

## Accessing the Admin Panel

The admin panel is accessible at: **http://127.0.0.1:8000/admin/dashboard**

### Default Admin Credentials

```
Email: admin@ecommerce.com
Password: Admin@123
```

## Admin Authorization Methods

There are two ways to grant admin access:

### 1. Database Role Method
Users with `role = 'admin'` in the database automatically have admin access.

### 2. ACL (Access Control List) Method
You can authorize specific email addresses by adding them to the ACL configuration file.

#### Adding Admin Emails via ACL

Edit the file: `config/acl.php`

```php
return [
    'authorized_admin_emails' => [
        'admin@ecommerce.com',
        'your.email@example.com',  // Add your email here
        'another.admin@company.com',
    ],

    'super_admin_emails' => [
        'admin@ecommerce.com',
        // Super admins have full system access
    ],
];
```

**After editing the ACL file, clear the config cache:**
```bash
php artisan config:clear
```

## Admin Panel Features

### Dashboard (`/admin/dashboard`)
- System overview
- Statistics and metrics
- Quick actions

### Products Management (`/admin/products`)
- View all products
- Add new products
- Edit product details
- Manage inventory
- Delete products

### Orders Management (`/admin/orders`)
- View all orders
- Update order status
- Manage payments
- View order details

### User Management (`/admin/users`)
- View all users
- Block/unblock users
- Change user roles
- View user activity

### Settings (`/admin/settings`)
- Site configuration
- General settings
- System preferences

### Reports (`/admin/reports`)
- Bug reports from users
- System analytics
- Issue management

### Inventory (`/admin/inventory`)
- Stock management
- Low stock alerts
- Inventory tracking

## Admin Middleware

The admin routes are protected by the `IsAdmin` middleware which checks:

1. If the user is authenticated
2. If the user's role is 'admin' OR
3. If the user's email is in the ACL authorized list

## Creating New Admin Users

### Option 1: Via Database Seeder
Edit `database/seeders/AdminSeeder.php` and add:

```php
User::create([
    'username' => 'newadmin',
    'email' => 'newadmin@example.com',
    'password' => Hash::make('SecurePassword123'),
    'role' => 'admin',
    'is_active' => true,
    'is_blocked' => false,
    'email_verified_at' => now(),
]);
```

Then run: `php artisan db:seed --class=AdminSeeder`

### Option 2: Via Tinker
```bash
php artisan tinker
```

```php
$user = new App\Models\User();
$user->username = 'newadmin';
$user->email = 'newadmin@example.com';
$user->password = Hash::make('SecurePassword123');
$user->role = 'admin';
$user->is_active = true;
$user->is_blocked = false;
$user->email_verified_at = now();
$user->save();
```

### Option 3: Via ACL (Recommended for existing users)
Simply add the user's email to `config/acl.php` and clear the config cache.

## Security Best Practices

1. **Change default passwords** immediately after setup
2. **Use strong passwords** (minimum 12 characters with mixed case, numbers, and symbols)
3. **Limit admin emails** in the ACL to trusted addresses only
4. **Review admin access** regularly
5. **Use Super Admin** sparingly for users who need full system access

## Troubleshooting

### "403 Unauthorized" Error
- Check if your email is in the ACL list
- Verify your user role in the database
- Clear config cache: `php artisan config:clear`
- Ensure you're logged in

### Can't Access Admin Routes
- Verify middleware is registered in `bootstrap/app.php`
- Check if routes are defined in `routes/web.php`
- Clear route cache: `php artisan route:clear`

### Admin Panel Not Loading
- Check if controllers exist in `app/Http/Controllers/Admin/`
- Verify views exist in `resources/views/admin/`
- Check browser console for JavaScript errors

## Admin Route List

Run this command to see all admin routes:
```bash
php artisan route:list --name=admin
```

## Need Help?

If you encounter issues:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Enable debug mode in `.env`: `APP_DEBUG=true`
3. Clear all caches: `php artisan optimize:clear`
