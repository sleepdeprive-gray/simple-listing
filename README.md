# Simple Listing

A simple item management web application built with Laravel, PostgreSQL, and Tailwind CSS.

## Overview & Implemented Features

### 1. Database Migration
- **File**: [`database/migrations/create_items_table.php`](database/migrations/create_items_table.php)
- Defines the `items` table schema with PostgreSQL raw SQL:
  - `id`: Primary key (`BIGINT GENERATED ALWAYS AS IDENTITY`)
  - `name`: Item name (`VARCHAR(255)`)
  - `quantity`: Item count (`INT CHECK (quantity >= 0)`)
  - `deleted_at`: Soft delete timestamp (`TIMESTAMP WITH TIME ZONE`)
  - `created_at` & `updated_at`: Timestamps

### 2. Item Controller
- **File**: [`app/Http/Controllers/ItemController.php`](app/Http/Controllers/ItemController.php)
- Handles item operations using raw SQL queries:
  - `index()`: Lists active and soft-deleted items
  - `store()`: Validates input and creates a new item
  - `updateName()`: Updates an existing item's name
  - `decrement()`: Decrements item quantity down to a minimum of 0
  - `restore()`: Restores a soft-deleted item

### 3. Views
- **File**: [`resources/views/index.blade.php`](resources/views/index.blade.php)
- Blade template styled with Tailwind CSS for:
  - Form to add items
  - List of active items
  - List of trashed items

### 4. Routes
- **File**: [`routes/web.php`](routes/web.php)
- Application endpoints:

| Method | Endpoint | Action | Route Name |
| :--- | :--- | :--- | :--- |
| `GET` | `/` | List items and trashed items | `items.index` |
| `POST` | `/items` | Create item | `items.store` |
| `PATCH` | `/items/{id}/update-name` | Update item name | `items.updateName` |
| `PATCH` | `/items/{id}/decrement` | Decrement item quantity | `items.decrement` |
| `DELETE` | `/items/{id}` | Soft delete item | `items.delete` |
| `PATCH` | `/items/{id}/restore` | Restore soft-deleted item | `items.restore` |

### 5. Repository Configuration
- **File**: [`.gitignore`](.gitignore)
- Git ignore rules for environment files, Windows OS files, dependencies, and editor configurations.

## Tech Stack

- **Backend**: Laravel 11
- **Database**: PostgreSQL (Supabase)
- **Frontend**: Blade, Tailwind CSS, React, Vite

## Getting Started

### Prerequisites
- PHP >= 8.2 (with `pdo_pgsql`)
- Composer
- Node.js & npm

### Setup

1. **Clone the repository**:
   ```bash
   git clone https://github.com/sleepdeprive-gray/simple-listing.git
   cd simple-listing
   ```

2. **Install dependencies**:
   ```bash
   composer install
   npm install
   ```

3. **Configure environment**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Set your PostgreSQL database credentials in `.env`:
   ```env
   DB_CONNECTION=pgsql
   DB_HOST=aws-0-ap-southeast-1.pooler.supabase.com
   DB_PORT=5432
   DB_DATABASE=postgres
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_database_password
   ```

4. **Run migrations**:
   ```bash
   php artisan migrate
   ```

5. **Run application**:
   ```bash
   # Terminal 1
   php artisan serve

   # Terminal 2
   npm run dev
   ```
