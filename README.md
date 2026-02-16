```markdown
# Electronic Store Project 🛒🔌

Welcome to the **Electronic Store Project**, a modern e-commerce web application designed to provide a seamless, scalable shopping experience for electronics and tech gadgets. 

## 🚀 Overview

This platform is engineered to handle end-to-end e-commerce operations, from product browsing to order management. Built with a focus on long-term scalability and commercial operation, the architecture is structured to support continuous business growth and accommodate future expansions well beyond the initial launch.

## ✨ Core Features
* **Dynamic Product Catalog**: Browse, filter, and view detailed specifications for various electronic devices.
* **Shopping Cart & Checkout Flow**: Intuitive cart management and secure order processing.
* **User Authentication**: Secure user registration, login, and profile management.
* **Responsive UI**: Fully optimized for desktop, tablet, and mobile environments.

## 🛠️ Tech Stack
* **Backend Framework**: PHP / Laravel
* **Frontend**: Blade Templating, JavaScript, CSS (Tailwind CSS)
* **Build Tools**: Vite
* **Database**: MySQL (via Laravel Eloquent ORM)

## ⚙️ Installation & Local Setup

To get the project up and running on your local machine, follow these steps:

1. **Clone the repository:**
   ```bash
   git clone [https://github.com/Mohannad-Mahdi-Dev/electronic-store-project.git](https://github.com/Mohannad-Mahdi-Dev/electronic-store-project.git)

```

2. **Navigate to the directory:**
```bash
cd electronic-store-project

```


3. **Install PHP and Node dependencies:**
```bash
composer install
npm install

```


4. **Environment Configuration:**
Copy the `.env.example` file to create your own `.env` file, then generate the application key:
```bash
cp .env.example .env
php artisan key:generate

```


5. **Database Setup:**
Update the `.env` file with your local database credentials (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`), then run the migrations and seeders:
```bash
php artisan migrate
and
php artisan nugrate --seed
or 
php artisan db:seed
```


6. **Start the Development Servers:**
You will need two terminal windows to run both the frontend build process and the backend server:
```bash

# Terminal 2: Start the Laravel PHP server
php artisan serve

```



---

## 🏗️ Technical Documentation

### 1. System Architecture

The application is built upon the **MVC (Model-View-Controller)** design pattern provided by the Laravel framework:

* **Models (Data Layer)**: Manage the business logic and database interactions. They utilize Laravel's Eloquent ORM to handle relationships (e.g., a `User` has many `Orders`, an `Order` contains many `Products`).
* **Views (Presentation Layer)**: Rendered using Laravel Blade, integrating JavaScript and Tailwind CSS for a reactive and styled user interface. Vite is used for rapid asset bundling.
* **Controllers (Logic Layer)**: Act as the intermediary, receiving HTTP requests, processing them via the appropriate Models, and returning the correct View or JSON response.

### 2. Directory Structure Highlights

* `app/Models/`: Contains the Eloquent data models.
* `app/Http/Controllers/`: Contains the application controllers managing route logic.
* `database/migrations/`: Contains the database schema definitions.
* `database/seeders/`: Contains scripts for populating the database with initial dummy data for products and users.
* `resources/views/`: Contains the Blade templates for the user interface.
* `routes/web.php`: Defines the web-accessible endpoints.

### 3. Database Schema (Core Entities)

While the database will evolve, the foundational tables include:

* **`users`**: Stores customer and admin authentication details (name, email, password, role).
* **`products`**: Stores electronic item details (name, description, price, stock_quantity, category_id, image_path).
* **`orders`**: Tracks user purchases (user_id, total_amount, status, payment_method).
* **`order_items`**: Pivot table associating products with specific orders (order_id, product_id, quantity, price_at_purchase).

### 4. Frontend Asset Management

The project utilizes **Vite** for fast and efficient frontend development.

* CSS styling is managed via **Tailwind CSS**, configured in `tailwind.config.js`.
* PostCSS is utilized for CSS transformations (`postcss.config.js`).
* To compile assets for a production environment, run `npm run build`.

### 5. Security Protocols

* **CSRF Protection**: All form submissions are protected using Laravel's built-in `@csrf` token verification.
* **SQL Injection Prevention**: Eloquent ORM utilizes PDO parameter binding to protect against SQL injections.
* **Authentication**: Password hashing and secure session management are handled by Laravel's core auth scaffolding.

---

## 🗺️ Roadmap

The project is designed for continuous operational deployment. Upcoming phases include:

* Integration of third-party payment gateways.
* Advanced inventory and stock tracking.
* Comprehensive admin dashboard for sales analytics.

## 👥 Contributors

* **Omar** - Developer
* **Abriham** - Developer
* **hossyn** - Developer
* **Abdullah* - Developer
* **Mohannad** - Developer

## 📄 License

This project is open-source and licensed under the compuny : YemenTech.
