# 🛍️ AliMSA - E-commerce Shop (Laravel + TailwindCSS)

A modern, responsive and full-featured e-commerce platform built using Laravel and Tailwind CSS. This project includes essential e-commerce functionalities along with admin and user panels. It’s designed for real-world shop usage and ready for deployment or further enhancement.

---

## 📌 Table of Contents

- [📖 Introduction](#-introduction)
- [✨ Features](#-features)
- [🛠️ Tools & Technologies](#-tools--technologies-used)
- [🧑‍💼 Admin Panel](#-admin-panel)
- [👨‍💻 User Panel](#-user-panel)
- [⚙️ Installation Guide](#-installation-guide)
- [📱 Responsive Design](#-responsive-design)
- [📸 Screenshots](#-screenshots)
- [📂 Folder Structure](#-folder-structure)
- [📃 License](#-license)

---

## 📖 Introduction

AliMSA is a complete Laravel-based e-commerce web application designed to help local shops manage products and online sales. With a beautiful frontend using TailwindCSS and a feature-rich backend, it includes everything a shop needs: from product listing to order management, user authentication to admin controls.

---

## ✨ Features

- User registration and login system
- Fully responsive frontend using Tailwind CSS
- Product browsing with category filters
- Product details page with image preview
- Add to cart & checkout functionality
- Order placement and order history
- Admin dashboard with analytics
- CRUD for products, categories, orders, and users
- Inventory management
- SEO-friendly URLs
- Email notifications

---

## 🛠️ Tools & Technologies Used

| Category         | Stack/Tools                        |
|------------------|------------------------------------|
| **Framework**    | Laravel                            |
| **Styling**      | Tailwind CSS                       |
| **Build Tool**   | Vite                               |
| **Database**     | MySQL                              |
| **Authentication**| Laravel Breeze (Optional)        |
| **Icons**        | Heroicons / FontAwesome           |
| **Package Manager**| Composer & NPM                   |
| **Version Control** | Git + GitHub                    |

---

## 🧑‍💼 Admin Panel

- Secure login for Admin
- Dashboard overview (orders, users, products, etc.)
- Add/Edit/Delete Products
- Manage Categories
- Manage Customers
- Manage Orders & Track Status
- View Sales Reports
- Settings (Site details, payment setup)

---

## 👨‍💻 User Panel

- Register/Login
- Browse products by category
- Search functionality
- Product detail view
- Add to cart & checkout
- View order history
- Edit profile information

---

## ⚙️ Installation Guide

```bash
# 1. Clone the repository
git clone https://github.com/SakhiLarik/alimsa.git
cd alimsa

# 2. Install PHP dependencies
composer install

# 3. Install NPM packages
npm install

# 4. Create a copy of .env
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Set up your database credentials in .env

# 7. Run migrations (optional: add --seed to seed initial data)
php artisan migrate

# 8. Compile CSS & JS using Vite
npm run build   # or use npm run dev for development

# 9. Serve the app
php artisan serve

```

## 📱 Responsive Design

The UI is designed mobile-first using Tailwind CSS. It adapts to screen sizes from mobile phones to large desktops with full support for responsiveness and accessibility.

## 📂 Folder Structure (Core)

```
alimsa/
├── app/
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
├── routes/
│   └── web.php
├── .env
└── vite.config.js
```
## 📃 License
This project is licensed under the MIT License. You are free to use, modify, and distribute it with attribution.

## 🙌 Credits
Developed by Sakhawat Ali Larik
For professional contact or support, please reach out via [LinkedIn](https://www.linkedin.com/in/sakhawat-ali-larik/) or [Email](mailto:sakhawatalilarik@gmail.com)

## ⭐ GitHub
If you found this project useful or inspiring, consider giving it a ⭐ on [GitHub](https://github.com/SakhiLarik/).
