# Deployment Guide: Digital Foundry

This application is built with **Laravel 11**, **Inertia.js**, and **Vue 3**. It requires a standard LEMP/LAMP stack to run in production.

## 1. Server Requirements
Ensure your Linux VPS (Ubuntu 22.04 recommended) has the following software:

- **PHP 8.2+** (Extensions: bcmath, ctype, fileinfo, json, mbstring, openssl, pdo, tokenizer, xml)
- **Nginx** or Apache
- **MySQL 8.0+** or MariaDB 10+
- **Composer** (PHP Dependency Manager)
- **Node.js 20+** & **NPM** (For building frontend assets)
- **Supervisor** (To keep queue workers running, optional but recommended)

## 2. Environment Setup
1. **Clone the repository** to your web root (e.g., `/var/www/portfolio`).
2. **Permissions:** Ensure storage and cache are writable:
   ```bash
   chmod -R 775 storage bootstrap/cache
   chown -R www-data:www-data storage bootstrap/cache
   ```
3. **Environment Config:**
   - Copy `.env.example` to `.env`.
   - Set `APP_ENV=production`.
   - Set `APP_DEBUG=false`.
   - Configure `DB_*` settings for your production database.
   - Set `APP_URL=https://your-domain.com`.

## 3. Installation Steps
Run the following commands in your project root:

```bash
# 1. Install PHP dependencies
composer install --optimize-autoloader --no-dev

# 2. Generate Application Key
php artisan key:generate

# 3. Migrate Database (and Seed Admin if fresh install)
php artisan migrate --force
# Only run this ONCE to create the admin user:
php artisan db:seed --class=AdminSeeder

# 4. Install Node dependencies
npm ci

# 5. Build Frontend Assets (CRITICAL)
npm run build
```

> **Note:** `npm run build` generates the static JS/CSS files in `public/build`. Without this, the site will look broken.

## 4. Web Server Configuration (Nginx Example)
Point your Nginx root to the `public` directory.

```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/portfolio/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## 5. Storage Link
Create the symbolic link for uploaded images:
```bash
php artisan storage:link
```

## 6. Optimization (Post-Deploy)
```bash
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache
```
