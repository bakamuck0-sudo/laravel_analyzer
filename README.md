# Analyzer (Website SEO Analyzer)

This is a Laravel web application designed for asynchronous SEO analysis of web pages.

A user submits a URL, the application queues the task, and asynchronously parses the site in the background, extracting the `h1`, `meta-description`, and other tags.

## 🚀 Key Technologies

This project demonstrates more than just a simple CRUD app; it showcases a complete, modern web architecture:

* **Docker:** The project is fully containerized with Docker Compose. The entire environment (`app`, `nginx`, `db`, `redis`, `worker`) spins up with a single command.
* **Queues:** All "heavy" work (parsing) is offloaded to background jobs using Laravel Queues and Redis, ensuring an instant UI response.
* **"Smart" Parser (Browsershot):** The parser is built with `spatie/browsershot` (Puppeteer/Headless Chrome), allowing it to execute JavaScript and parse complex SPAs (e.g., Google or YouTube). *(Note: Running the parser locally requires complex Linux environment configuration).*
* **TDD (Testing):** Key functionality (submitting a URL, database writes, queue dispatch) is covered by functional tests using PHPUnit.
* **CI/CD (GitHub Actions):** A workflow is configured to automatically run tests (`php artisan test`) on every `push` to the repository.

## ⚙️ Quick Start (Local Development)

This project uses Docker. Ensure you have `Docker` and `docker-compose` installed.

1.  **Clone the repository:**
    ```bash
    git clone [https://github.com/bakanucke/analyzer.git](https://github.com/bakanucke/analyzer.git)
    cd analyzer
    ```

2.  **Create your `.env` file:**
    ```bash
    cp .env.example .env
    ```
    *(Ensure your `.env` file has `DB_HOST=db` and `REDIS_HOST=redis` set)*

3.  **Build and run the Docker containers:**
    ```bash
    sudo docker-compose build
    sudo docker-compose up -d
    ```

4.  **Install Composer dependencies:**
    ```bash
    sudo docker-compose exec app composer install
    ```

5.  **Set up Laravel:**
    ```bash
    # Generate the application key
    sudo docker-compose exec app php artisan key:generate
    
    # Run the database migrations
    sudo docker-compose exec app php artisan migrate
    ```

6.  **Done!**
    Open `http://localhost:8000` in your browser.

## 🧪 Running Tests

To run the test suite (PHPUnit), execute:

```bash
sudo docker-compose exec app php artisan test
