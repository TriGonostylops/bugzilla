# php-mvc

## Overview

This project is a mock PHP application demonstrating the Model-View-Controller (MVC) pattern. It aims to create a minimalist web application with basic database functionality using PHP and MySQL, without relying on any frameworks or CMS.

## Specifications

### Project Requirements

- **URL Mapping:** Utilizes `.htaccess` rewrite for clean URLs.
- **Architecture:** Based on the MVC pattern, ensuring separation of concerns and modularity.
- **Object-Oriented:** Implements Object-Oriented Programming (OOP) principles throughout the codebase.
- **Database Integration:** Includes two database tables:
    - `users` (id, name)
    - `advertisements` (id, userid, title)
- **Pages:**
    - `index.php`: Home page with links to user list and advertisement list.
    - `userList.php`: Displays a list of users from the database.
    - `advertisementList.php`: Displays a list of advertisements with associated user names.
- **Design:** Minimalist CSS for basic styling.

### Implementation Requirements

- **Object-Oriented Design:** Uses OOP for maintainability and scalability.
- **Layered Architecture:**
    - **Controller Layer:** Handles user requests and invokes appropriate actions.
    - **Service Layer:** Contains business logic and interacts with models.
    - **Model Layer:** Represents data structures and interacts with the database.
- **Model and Service Separation:** Clearly separates models (for data representation) and services (for business logic).
- **Documentation:** Well-documented code to ensure clarity and ease of maintenance.
- **CSS Styling:** Simple and minimalistic design for user interface.

## Project Structure

The project includes the following files and directories:

- `index.php`: Entry point of the application, providing navigation links.
- `views/`: Directory containing PHP views:
  - `userList.php`: View file that lists all users fetched from the database.
  - `advertisementList.php`: View file that displays all advertisements along with associated user names.
- `controllers/`: Directory containing PHP controllers:
    - `IndexController.php`
    - `UserController.php`
    - `AdvertisementController.php`
- `services/`: Directory containing PHP service classes:
    - `UserService.php`
    - `AdvertisementService.php`
- `models/`: Directory containing PHP model classes:
    - `User.php`
    - `Advertisement.php`
- `config/`: Directory containing configuration files:
    - `database.php`: Configures database connection using PDO.

## Usage

To run the application:

1. Ensure PHP and MySQL are installed and configured on your server.
2. Import the database schema (`users` and `advertisements` tables) into MySQL.
3. Configure `database.php` with your database credentials.
4. Place the project files in your web server directory (`htdocs` for XAMPP).
5. Access the application through the browser, starting from `index.php`.