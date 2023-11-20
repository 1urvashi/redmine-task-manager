# Task Management with Redmine Integration

This project is a task management system integrated with Redmine, built using Laravel and Vue.js.

## Table of Contents

- [Requirements](#requirements)
- [Getting Started](#getting-started)
  - [Setting Up Laravel and Docker](#setting-up-laravel-and-docker)
  - [Database Design](#database-design)
  - [Environment Variables](#environment-variables)
- [Usage](#usage)
  - [Main Page](#main-page)
  - [Task Search and Pagination](#task-search-and-pagination)
  - [Task Deletion](#task-deletion)
  - [Task Creation](#task-creation)
- [Evaluation Criteria](#evaluation-criteria)
- [Contributing](#contributing)

## Requirements

- PHP
- Composer
- Node.js
- npm
- Docker
- Redmine account or Redmine running in Docker

## Installation

## Getting Started

### Setting Up Laravel and Docker

1. Clone the repository:

   ```bash
   git clone https://github.com/1urvashi/redmine-task-manager.git
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
    ```bash
    php artisan migrate
    `````
5. Compile assets:
    `````
    npm run dev
    `````
6. Serve the application:
    `````
    php artisan serve
    `````
7. Open your browser and visit http://localhost:8000.

## Database Design

Design your database to store tasks. Consider using fields similar to Redmine tables (Issue, Project, Company) as examples.

## Environment Variables
Set environment variables in the .env file for database connection and Redmine API details.

## Usage

## Main Page

The main page displays tasks from Redmine or the local database.
Tasks are responsive and correctly displayed on various devices.

## Task Search and Pagination

Utilize the search filter to find tasks without page reloading.
Paginate through the results.

## Task Deletion

Implement task deletion functionality.

## Task Creation

Implement task creation functionality.


Feel free to email me, if you have any question.