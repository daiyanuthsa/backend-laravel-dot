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

| Method | Endpoint              | Description                                |
|--------|-----------------------|--------------------------------------------|
| GET    | `/api/users`           | Get all users                              |
| POST   | `/api/users`           | Create a new user                          |
| GET    | `/api/categories`      | Get all categories                         |
| POST   | `/api/categories`      | Create a new category                      |
| GET    | `/api/categories/{id}` | Get a specific category                    |
| PUT    | `/api/categories/{id}` | Update a specific category                 |
| DELETE | `/api/categories/{id}` | Delete a specific category and its books   |
| GET    | `/api/books`           | Get all books                              |
| POST   | `/api/books`           | Create a new book                          |
| GET    | `/api/books/{id}`      | Get a specific book                        |
| PUT    | `/api/books/{id}`      | Update a specific book                     |
| DELETE | `/api/books/{id}`      | Delete a specific book                     |

### API Authentication

For secure access to the API, you can use Laravel Passport or Sanctum. By default, the API is open. To protect your API, you can configure authentication middleware.

## Dashboard

The dashboard allows users to perform CRUD operations on categories and books. After setting up the project, access the dashboard at `http://localhost:8000/dashboard`.

## License

This project is licensed under the MIT License.
