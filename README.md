# Simple Listing Application

A lightweight inventory and item management web application built with **Laravel**, **PostgreSQL**, and **Tailwind CSS**.

---

## 📌 Project Overview & Implemented Features

This project provides item listing and tracking capabilities with direct SQL queries and soft-deletion support. Below are the core components and custom implementations:

### 1. Database Schema & Migration
- **File**: [`database/migrations/create_items_table.php`](database/migrations/create_items_table.php)
- **Description**: Defines the PostgreSQL `items` table schema using raw SQL statements:
  - `id`: Auto-generated identity primary key (`BIGINT GENERATED ALWAYS AS IDENTITY`).
  - `name`: Item title / designation (`VARCHAR(255)`).
  - `quantity`: Item count with non-negative check constraint (`INT CHECK (quantity >= 0)`).
  - `deleted_at`: Soft delete timestamp (`TIMESTAMP WITH TIME ZONE`).
  - `created_at` & `updated_at`: Audit timestamps.

### 2. Business Logic & Controller
- **File**: [`app/Http/Controllers/ItemController.php`](app/Http/Controllers/ItemController.php)
- **Description**: Handles CRUD operations and state changes using `Illuminate\Support\Facades\DB`:
  - `index()`: Retrieves active items (`deleted_at IS NULL`) and trashed items (`deleted_at IS NOT NULL`).
  - `store()`: Validates request data and inserts new item records.
  - `updateName()`: Renames an existing active item.
  - `decrement()`: Decrements item quantity down to a minimum of 0 (`GREATEST(0, quantity - 1)`).
  - `restore()`: Restores soft-deleted items by resetting `deleted_at = NULL`.

### 3. User Interface & Views
- **File**: [`resources/views/index.blade.php`](resources/views/index.blade.php)
- **Description**: Blade view styled with Tailwind CSS providing:
  - Form to create and add new items (`name` and `quantity`).
  - Active items list with remaining quantities.
  - Trashed items overview.

### 4. Application Routes
- **File**: [`routes/web.php`](routes/web.php)
- **Description**: Routing map for web endpoints:

| Method | Endpoint | Action | Route Name |
| :--- | :--- | :--- | :--- |
| `GET` | `/` | List items and trashed items | `items.index` |
| `POST` | `/items` | Create new item | `items.store` |
| `PATCH` | `/items/{id}/update-name` | Rename item | `items.updateName` |
| `PATCH` | `/items/{id}/decrement` | Decrement item quantity | `items.decrement` |
| `DELETE` | `/items/{id}` | Soft delete item | `items.delete` |
| `PATCH` | `/items/{id}/restore` | Restore soft-deleted item | `items.restore` |

### 5. Repository Configuration
- **File**: [`.gitignore`](.gitignore)
- **Description**: Configured repository ignore rules protecting sensitive credentials (`.env`, `.env.*.local`), Windows operating system files (`Thumbs.db`, `Desktop.ini`), package caches (`/vendor`, `/node_modules`), and editor settings.

---

## 🛠️ Tech Stack

- **Backend Framework**: [Laravel 11](https://laravel.com/)
- **Database**: [PostgreSQL](https://www.postgresql.org/) (hosted on [Supabase](https://supabase.com/))
- **Frontend / Styling**: [Blade](https://laravel.com/docs/blade) & [Tailwind CSS](https://tailwindcss.com/)
- **Frontend Assets**: Vite, TypeScript, React

---

## 🚀 Getting Started

### Prerequisites
- PHP >= 8.2 with `pdo_pgsql` extension enabled
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/) & npm

### Installation

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

3. **Configure Environment**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Update your database credentials in `.env`:
   ```env
   DB_CONNECTION=pgsql
   DB_HOST=aws-0-ap-southeast-1.pooler.supabase.com
   DB_PORT=5432
   DB_DATABASE=postgres
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_database_password
   ```

4. **Run Migrations**:
   ```bash
   php artisan migrate
   ```

5. **Start Development Servers**:
   ```bash
   # Terminal 1 - Laravel server
   php artisan serve

   # Terminal 2 - Frontend assets
   npm run dev
   ```
   Open [http://localhost:8000](http://localhost:8000) in your browser.
