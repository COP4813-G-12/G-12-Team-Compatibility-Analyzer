# G-12-Team-Compatibility-Analyzer

A web application that matches users together based on a compatibility score 
determined by the 16 Myers-Briggs personality types.

## Project Structure

1. HTML scripts (4 files)
2. PHP scripts (8 files)
3. SQL script (1 file)

## Setup Instructions (localhost)

### 1. Software Requirements
----------------------------
1. PHP 7.0 or greater
2. Local MySQL/Apache Server (XAMPP Control Panel recommended)
3. Internet Web Browser

### 2. Database Setup
---------------------
1. Open the MySQL/Apache server.
2. Create a new database named 'team_compatibility'.
3. Import the 'init.sql' file into the created database.
   - Confirmation message should state: "Import has been successfully finished, 
     5 queries executed. (init.sql)".

### 3. Server Setup (if needed)
-------------------------------
1. Open the 'db.php' file.
2. Update the file information in accordance to the local MySQL/Apache server:
   
   $host = 'server_db_host';
   $dbname = 'server_db_name';
   $user = 'server_db_user';
   $pass = 'server_db_password';

### 3a. Troubleshooting Server Setup (if needed)
------------------------------------------------
1. Open the 'init.sql' file.
2. Delete the following code section:
   
   -- Create and use the database
   CREATE DATABASE IF NOT EXISTS team_compatibility;
   USE team_compatibility;

3. Save the 'init.sql' file.
4. Import the edited 'init.sql' file into the created database.
   - Confirmation message should state: "Import has been successfully finished, 
     3 queries executed. (init.sql)".

### 4. Hosting the Web Application
----------------------------------
1. Move project folders into the root directory of the local MySQL/Apache server.
   - C:\xampp\htdocs
3. Enable MySQL and Apache using the server control panel.
   - If using a built-in PHP server, run in the terminal: php -S localhost:8000
4. Enter in the following URL into the browser:
   
   http://localhost/your-project-folder/frontend/login.html
   
   - or for a built-in PHP server:
   
   http://localhost:8000/frontend/login.html

## Testing the Web Application

1. Login using the default login information: Username=admin, Password=password123
2. At the Admin Home page, click 'Register User' to register a new user:
   - Name=John Smith, Personality=INTP, Project Type: Software Development
3. Navigate back to Admin Home, click 'Register User' again for another user:
   - Name=Jane Doe, Personality=ESFJ, Project Type=Project Management
4. Navigate back to Admin Home, click 'View All Users' to view the users saved
   in the database.
5. Navigate back to Admin Home, click 'Match Users' to match the existing users
   together.
6. Navigate back to Admin Home, click 'View Matches' to view the matched users.
7. Navigate back to Admin Home, click 'Logout' to end the admin session.
