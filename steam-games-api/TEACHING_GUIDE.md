# 🎓 Steam Games API — Complete Teaching Guide

This project is a comprehensive educational lab designed to teach modern RESTful API development using Laravel. It covers the full lifecycle of a backend project, from database design to a fully interactive frontend.

---

## 1. Project Architecture (The Big Picture)
This application follows the **MVC (Model-View-Controller)** pattern with an added **API Layer**.

1.  **User/UI**: Sends a request (e.g., "Give me all RPG games").
2.  **Routes**: Directs the request to the correct Controller.
3.  **Middleware**: Checks if the user is logged in (Sanctum) and if they are sending too many requests (Throttle).
4.  **Controller**: The "Brain". It handles logic, checks the **Cache**, and talks to the **Model**.
5.  **Model**: The "Data Manager". It interacts with the **Database** using Eloquent ORM.
6.  **Resource**: The "Filter". It cleans the data before sending it back as JSON.

---

## 2. Database Design & Relationships
### Many-to-Many Relationship
In this project, **Games** and **Genres** have a many-to-many relationship.
*   **Problem**: A game has many genres, and a genre has many games.
*   **Solution**: We use a **Pivot Table** called `game_genre`. 
*   **Eloquent Logic**:
    *   In `Game.php`: `return $this->belongsToMany(Genre::class);`
    *   In `Genre.php`: `return $this->belongsToMany(Game::class);`

### JSON Seeding
To simulate real-world data migration, we import data from `games.json`.
*   **Sync Method**: We use `$game->genres()->sync($ids)`. This is a "teaching favorite" because it handles adding and removing links in one step, ensuring the database matches the JSON exactly.

---

## 3. The API Layer
### API Resources
We use `GamesResource`. Instead of sending raw database rows, we transform the data.
*   **Security**: We hide sensitive internal fields.
*   **Formatting**: We ensure dates are returned in a consistent `YYYY-MM-DD` format.
*   **Relationships**: We use `whenLoaded()` to prevent "N+1" query problems, only loading genres when they are actually needed.

### Response Caching
To teach performance optimization, we implemented `Cache::remember`.
*   **Key Concept**: If the database doesn't change, we shouldn't ask it for the same data twice. We store the result in RAM (Cache) for 1 hour.
*   **Invalidation**: When a game is added or deleted, we use `Cache::flush()` to clear the old data.

---

## 4. Authentication (Sanctum)
This project uses **Token-Based Authentication**.
1.  **Login**: User sends credentials; server returns a `plainTextToken`.
2.  **Storage**: The browser stores this token in `localStorage`.
3.  **Authorization**: For every request, the browser sends a header: `Authorization: Bearer <token>`.
4.  **Validation**: Sanctum checks the token against the `personal_access_tokens` table.

---

## 5. The Frontend (UI)
The UI is a "Single Page" interface built with **Vanilla Javascript**.
*   **Fetch API**: Used to communicate with the Laravel backend.
*   **State Management**: The JS dynamically hides/shows the login screen based on whether a token exists.
*   **Glassmorphism**: A modern design trend using `backdrop-filter: blur()` to create a premium, translucent look.

---

## 6. How to Run (Instructional Steps)
1.  `composer install` - Install dependencies.
2.  `php artisan install:api` - Setup Sanctum.
3.  `php artisan migrate:fresh --seed` - Setup database and initial data.
4.  `php artisan scribe:generate` - Generate API documentation.
5.  `php artisan serve` - Start the application.

---

## 7. Testing Strategy
We use **Feature Tests** in `GameTest.php`.
*   **In-Memory DB**: Tests run in RAM using `:memory:` SQLite for speed.
*   **ActingAs**: We simulate a logged-in user to test protected routes.
*   **Assertions**: We verify that the API returns the correct status codes (200, 201, 204).
