# 🌸 Purity — Handmade Crochet & Embroidery Store

Purity is a full-stack e-commerce web application for a handmade crochet and hand embroidery products store. Built as a final-year project, it covers the complete customer shopping journey as well as a full admin management panel.

## ✨ Features

### Customer-Facing
- **Home, About & Contact pages** with a consistent handcrafted aesthetic
- **Shop with category & subcategory filtering** — Crochet and Hand Embroidery, each with multiple subcategories
- **Product detail pages** with image gallery, quantity selector, and product highlights
- **Wishlist** — toggle products as favorites (persists for logged-in users)
- **Cart** — add, update quantity, and remove items, with live totals
- **Checkout & order placement** — shipping details, payment method selection, and order confirmation
- **User authentication** — combined login/register page with secure password hashing
- **Contact form** — messages saved to the database

### Admin Panel
- **Dashboard** with key stats (products, orders, categories, revenue) and an order status chart
- **Product management** — add, edit, delete products with image upload
- **Order management** — view orders and update status (Pending / Delivered / Cancelled)
- **Category & subcategory management**
- **Customer messages** — view all contact form submissions
- **Registered users list**
- **Secure admin login**, separate from customer accounts

## 🛠️ Tech Stack

- **Frontend:** HTML, CSS, JavaScript
- **Backend:** PHP
- **Database:** MySQL
- **Other:** Chart.js (admin dashboard charts), Font Awesome (icons)

## 📂 Project Structure

```
Purity/
├── admin/              # Admin panel (dashboard, products, orders, etc.)
├── assets/
│   ├── css/            # Stylesheets
│   ├── js/             # JavaScript files
│   └── images/         # Product & site images
├── header.php / footer.php
├── db.php              # Database connection
├── index.php           # Homepage
├── shop.php            # Category landing page
├── crochet-sub.php / embroidery-sub.php   # Subcategory filtering
├── product.php         # Product detail page
├── cart.php / checkout.php / process-order.php
├── wishlist.php / toggle-wishlist.php
├── login.php           # Combined login/register
└── contact.php
```

## 🚀 Setup Instructions

1. Clone this repository into your local server's root directory (e.g. `htdocs` for XAMPP):
   ```
   git clone https://github.com/rohinikoli27/Purity-.git
   ```
2. Start Apache and MySQL (via XAMPP or similar).
3. Create a database named `purity_db` in phpMyAdmin.
4. Import the required tables: `products`, `orders`, `order_items`, `users`, `contact_messages`, `wishlist`, `categories`, `subcategories`.
5. Update `db.php` with your database credentials if different from the default.
6. Visit `http://localhost/Purity/` in your browser.

## 📌 Notes

This project was built incrementally, page by page, as a learning exercise in full-stack PHP/MySQL development — covering session handling, prepared statements, AJAX-driven interactions (wishlist/cart), and a complete admin CRUD system.

---

Made with 🧶 and 🪡 by Purity.
