# Event Management System

## Description
Event Management System is a web application that allows users to register, log in, and manage events. The project is implemented using PHP and MySQL.

## Installation

### Requirements
- XAMPP (or any other server supporting PHP and MySQL)

### Installation Steps
1. **Clone the Repository or Download the Project:**
   - Clone the repository or download the project and extract it into the `htdocs` folder (e.g., `C:\xampp\htdocs\event_management_system`).

2. **Create the Database:**
   - Open [phpMyAdmin](http://localhost/phpmyadmin) in your browser.
   - Create a new database named `event_management`.
   - Import the following SQL queries to create the tables:
     ```sql
     CREATE TABLE users (
         id INT AUTO_INCREMENT PRIMARY KEY,
         username VARCHAR(50) NOT NULL UNIQUE,
         email VARCHAR(100) NOT NULL UNIQUE,
         password VARCHAR(255) NOT NULL
     );

     CREATE TABLE events (
         id INT AUTO_INCREMENT PRIMARY KEY,
         user_id INT,
         event_name VARCHAR(100),
         description TEXT,
         event_date DATETIME,
         location VARCHAR(100),
         FOREIGN KEY (user_id) REFERENCES users(id)
     );
     ```

## Running the Project

1. Open your browser and navigate to `http://localhost/event_management_system`.
2. Register a new user on the registration page.
3. Log in using the created credentials.
4. Create, view, edit, and delete events through the application interface.

## Project Structure

- `index.php`: Main page.
- `register.php`: Registration page.
- `login.php`: Login page.
- `logout.php`: Logout page.
- `add_event.php`: Page for adding events.
- `edit_event.php`: Page for editing events.
- `config.php`: Configuration file for database connection.
- `classes/`: Folder with classes (`Database.php`, `User.php`, `Event.php`, `Session.php`).

## Security

- Passwords are stored using `password_hash`.
- Login validation uses `password_verify`.
- Protection against CSRF, SQL Injection, and XSS attacks is implemented.

## Author

Atoullo Sohibzoda ID:48882	

