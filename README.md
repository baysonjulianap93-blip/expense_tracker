# Expense Tracker

## Live system

https://julianabayson.infinityfree.me

## Project Overview

Expense Tracker is a web application for recording personal income and expenses. Users can organize transactions by category, set monthly budgets, and review their finances. The project uses a PHP MVC structure with a MySQL database.

## Key Features

- Register, log in, and manage a personal account
- Add, edit, delete, and filter income and expense transactions by type or month
- Create and manage transaction categories
- Set and update monthly budgets
- View a dashboard with income, expense, balance, and recent transaction summaries
- Review monthly reports, including spending by category and recent monthly totals

## Technologies Used

- PHP
- MySQL or MariaDB, accessed through PDO
- HTML and CSS
- Bootstrap 5
- XAMPP for local development

## Installation and Setup

1. Place the project folder in the XAMPP `htdocs` directory.
2. In phpMyAdmin, create a database named `expense_tracker_db`.
3. Import `database.schema.sql` into the new database.
4. Copy `config/database.example.php` to `config/database.php`.
5. Update the database connection details in `config/database.php` if they differ from your local settings.

## How to Run

1. Start Apache and MySQL from the XAMPP Control Panel.
2. Open [http://localhost/expense_tracker/](http://localhost/expense_tracker/) in your browser.
3. Register an account to start using the application.
