Project Setup Instructions

Requirements:
- PHP >= 8.1
- Composer
- Node.js (v16.x or higher)
- NPM
- MySQL

Steps:

1. Clone the repository:
   git clone https://github.com/KumodParajuli/Laravel-and-Vuejs-Mini-Web-Builder.git
   cd Laravel-and-Vuejs-Mini-Web-Builder

2. Install PHP dependencies:
   composer install

3. Install Node dependencies:
   npm install

4. Copy .env.example to .env and configure the database:
   cp .env.example .env
   Update the following in your .env file:
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=your_database_name
     DB_USERNAME=your_db_user
     DB_PASSWORD=your_db_password

5. Generate application key:
   php artisan key:generate

6. Run migrations and seed the database:
   php artisan migrate --seed

7. Build frontend assets:
   npm run dev     (for development)
   npm run build   (for production)

8. Serve the Laravel application:
   php artisan serve

Application Access:

- Client Site (Frontend):
  http://127.0.0.1:8000/

- Admin Panel (Backend):
  http://127.0.0.1:8000/admin

Admin Panel Features:

- Pages:
  Add, edit, delete site pages and set individual page banners.

- Site Settings:
  Configure global settings like site title, footer, and homepage.

- Site Menu:
  Manage navigation items (add, edit, order, delete).
