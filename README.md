# ShopEase - Laravel E-Commerce Application

A simple e-commerce web app built with **Laravel (MVC)**, **Blade + Bootstrap 5** and **MySQL**.
Users can browse products, log in with an **email OTP**, manage a cart and wishlist, pay through a **demo SSLCommerz gateway**, and view their order history.

## Project Presentation Video

Project walkthrough (maximum 3–3.5 minutes): [Watch the ShopEase presentation](https://drive.google.com/file/d/1cxQ62zxmUA6Hjnflg5AX3tlgepA8j67U/view?usp=drive_link)

## Features

| Module | What it does |
| --- | --- |
| Home | Hero slider, brand list, category list, latest products, featured products |
| Products | Product list, details, browse by brand and by category (name, image, price, description) |
| Authentication | OTP login (session auth for the web UI, **Laravel Sanctum** tokens for the JSON API), profile, logout |
| Cart | Add, update quantity, remove, cart total |
| Wishlist | Add and remove products |
| Checkout | Shipping details, demo SSLCommerz payment (success / fail / cancel), order placement |
| Orders | Order history and order details |

## Database Tables

`users`, `otp_verifications`, `brands`, `categories`, `products`, `sliders`, `wishlists`, `cart_items`, `orders`, `order_items`
(plus Laravel's `sessions` and Sanctum's `personal_access_tokens`).

Relationships: Brand/Category `hasMany` Products; User `hasMany` CartItems and Orders and `belongsToMany` Products (wishlist); Order `hasMany` OrderItems; OrderItem `belongsTo` Product.

## Setup

Requirements: PHP 8.3+, Composer, MySQL.

```bash
composer install
cp .env.example .env
php artisan key:generate
# create an empty MySQL database named "shopease" (or edit DB_* in .env)
php artisan migrate --seed
php artisan serve
```

Open http://localhost:8000.

## How OTP login works

1. Enter any email on `/login` (new emails are registered automatically; seeded user: `demo@example.com`).
2. A 6-digit code is generated and mailed (`MAIL_MAILER=log` writes it to `storage/logs/laravel.log`).
3. For easy demos, `SHOP_SHOW_DEMO_OTP=true` also shows the code on screen. Set it to `false` in production.
4. Codes expire after 5 minutes and can be used once.

### JSON API (Sanctum)

| Method | Endpoint | Description |
| --- | --- | --- |
| POST | `/api/auth/otp` | `{ "email": "..." }` - send OTP |
| POST | `/api/auth/verify` | `{ "email": "...", "code": "123456" }` - returns bearer token |
| GET | `/api/auth/profile` | Current user (Bearer token) |
| POST | `/api/auth/logout` | Revoke current token |

## Demo payment flow

Checkout creates a pending order and redirects to a simulated SSLCommerz page (`/payment/gateway/{transaction}`) where you can choose **Pay Now**, **Simulate Failure** or **Cancel**. Only successful payments mark the order as paid, clear the cart and show up in order history.

## Structure

- `app/Http/Controllers` - Home, Product, Auth, Cart, Wishlist, Checkout, Order (+ `Api/AuthController`)
- `app/Services` - `OtpService`, `DemoPaymentGateway`
- `app/Models` - Eloquent models with relationships
- `database/migrations`, `database/seeders` - schema and demo data
- `resources/views` - Blade templates (responsive Bootstrap UI)
