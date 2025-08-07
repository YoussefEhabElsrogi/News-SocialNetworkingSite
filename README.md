<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# News-SocialNetworkSite

**Duration:** September 2024 – December 2024  
**Location:** Remote – Personal Project (Developed from home)

## Overview
A modern social-news platform combining news feeds with social networking features. Built from scratch, it includes a custom authentication system, real-time interactions, admin and user panels, and performance enhancements using Redis.

## Live Demo
Visit the live demo: [News‑SocialNetworkSite](https://socialnetwork.scriptstars.com/home)

## Key Features
- Custom **user dashboard** and **admin panel** with tailored authentication.
- Real-time notifications and **Redis caching** for enhanced performance.
- Flexible, dynamic UX through a **RESTful API** and AJAX-powered updates.
- **Posts & Comments** management with guest restriction and user-blocking.
- Admin notification system for user inquiries, with email response capability.
- Database query optimization that reduced load time by approximately **20%**.

## Technologies Used
- **Backend:** PHP, Laravel  
- **Frontend Interactions:** AJAX, RESTful APIs  
- **Caching:** Redis  
- **Tools:** Git, Trello, Postman  

## Getting Started

### Prerequisites
Make sure you have the following installed:
- PHP >= 8.x  
- Composer  
- MySQL  
- Redis  
- Node.js & npm (if needed for frontend assets)

### ⚙️ Setup

1. Clone the repository:
   ```bash
   git clone https://github.com/YoussefEhabElsrogi/News-SocialNetworkingSite.git
   cd News-SocialNetworkingSite
   ```

2. Install Composer dependencies:
   ```bash
   composer install
   ```

3. Copy `.env` file and generate app key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Set up your database:
   - Create a new database (e.g., `socialnetwork_db`)
   - Update the `.env` file with your DB credentials:
     ```env
     DB_DATABASE=socialnetwork_db
     DB_USERNAME=root
     DB_PASSWORD=your_password
     ```

5. Run migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```

6. (Optional) Set up Redis & Queue (for notifications):
   - Install Redis locally
   - Set the following in `.env`:
     ```env
     CACHE_DRIVER=redis
     SESSION_DRIVER=redis
     QUEUE_CONNECTION=redis
     ```
   - Run the queue worker:
     ```bash
     php artisan queue:work
     ```

7. Serve the application:
   ```bash
   php artisan serve
   ```

8. Visit the app:
   - [http://localhost:8000](http://localhost:8000)
