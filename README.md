# Laravel Project with Dashboard and API

This is a Laravel project that implements a simple book management system with categories, user management, and a dashboard. The project also includes API endpoints for external access to the data.

## Features

- User management (with categories and books).
- One-to-many relationship between users and categories.
- One-to-many relationship between categories and books.
- CRUD (Create, Read, Update, Delete) operations for users, categories, and books.
- API to interact with users, categories, and books.
- Simple dashboard to manage categories and books.
  
## Database Structure

### users

| Column       | Type      | Description                |
|--------------|-----------|----------------------------|
| id           | string    | Primary Key                |
| email        | string    | User's email               |
| password     | string    | User's password            |
| name         | string    | User's name                |
| created      | timestamp | Timestamp of creation      |
| lastUpdated  | timestamp | Timestamp of last update   |

### category

| Column       | Type      | Description                |
|--------------|-----------|----------------------------|
| id           | string    | Primary Key                |
| userId       | string    | Foreign Key to `users.id`   |
| name         | string    | Category name              |
| created_at   | timestamp | Timestamp of creation      |
| updated_at   | timestamp | Timestamp of last update   |
| deleted_at   | timestamp | Timestamp of deletion      |

### book

| Column       | Type      | Description                |
|--------------|-----------|----------------------------|
| id           | integer   | Primary Key                |
| categoryId   | string    | Foreign Key to `category.id`|
| name         | string    | Book name                  |
| year         | clob      | Book year                  |
| author       | decimal   | Book author (decimal)      |
| created_at   | timestamp | Timestamp of creation      |
| updated_at   | timestamp | Timestamp of last update   |
| deleted_at   | timestamp | Timestamp of deletion      |

## Relationships

- **One-to-Many**: A user can have many categories.
- **One-to-Many**: A category can have many books.

## Installation

1. Clone the repository.

    ```bash
    git clone <repository-url>
    cd <project-folder>
    ```

2. Install the dependencies.

    ```bash
    composer install
    ```

3. Set up the `.env` file.

    ```bash
    cp .env.example .env
    ```

    Update your database credentials in the `.env` file.

4. Generate the application key.

    ```bash
    php artisan key:generate
    ```

5. Run the migrations to create the necessary database tables.

    ```bash
    php artisan migrate
    ```

6. Seed the database (optional).

    ```bash
    php artisan db:seed
    ```

7. Run the application.

    ```bash
    php artisan serve
    ```

    The application will run at `http://localhost:8000`.

## API Endpoints


| HTTP Method | URL                     | Description                       | Authentication Required |
|-------------|-------------------------|-----------------------------------|-------------------------|
| POST        | `/register`              | Register a new user               | No                      |
| POST        | `/login`                 | Log in a user                     | No                      |
| POST        | `/user/delete`           | Delete the authenticated user     | Yes                     |
| GET         | `/category`              | Get a list of all categories      | Yes                     |
| POST        | `/category/create`       | Create a new category             | Yes                     |
| PUT         | `/category/edit/{id}`    | Update a category by ID           | Yes                     |
| DELETE      | `/category/delete/{id}`  | Delete a category by ID           | Yes                     |
| GET         | `/book`                  | Get a list of all books           | Yes                     |
| POST        | `/book/create`           | Create a new book                 | Yes                     |
| PUT         | `/book/edit/{id}`        | Update a book by ID               | Yes                     |
| DELETE      | `/book/delete/{id}`      | Delete a book by ID               | Yes                     |

---


## Libraries Used

The following libraries are utilized in this project:
  
- **laravel/breeze**: `1.9.2`
  - Breeze provides a minimal and simple authentication system for Laravel applications, including registration, login, and password reset features.

- **laravel/sanctum**: `^2.15`
  - Sanctum provides a simple authentication system for SPA (Single Page Applications) or simple token-based APIs.

- **ramsey/uuid**: `^4.7`
  - A library for generating UUIDs in PHP, used for unique identification of records in the database.

- **yajra/laravel-datatables**: `^1.5`
  - A library that helps create advanced table features, such as searching, pagination, and sorting, with Eloquent models and database queries in Laravel.

## Dashboard

The dashboard allows users to perform CRUD operations on categories and books. After setting up the project, access the dashboard at `http://localhost:8000/dashboard`.

## License

This project is licensed under the MIT License.
