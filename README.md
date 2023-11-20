# Project Name

Description of your project.

## Requirements
- PHP
- Composer
- Node.js
- npm
- Docker (if used)

## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/your-username/your-project.git
    `````

2. Change into the project directory:

    ```bash
    cd your-project
    composer install
    npm install
    cp .env.example .env
    `````

3. Configure your .env file with database and Redmine API settings.

4. Generate application key:

php artisan migrate

5. Compile assets:

npm run dev

6. Serve the application:

php artisan serve

7. Open your browser and visit http://localhost:8000.
