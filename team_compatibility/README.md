# G-12 Team Compatibility Analyzer

A web application that matches users based on compatibility scores derived from the 16 Myers-Briggs personality types. This version includes a secure Admin Panel for managing users, moderating posts, and manually adding content.

## Project Structure

- `frontend/`: HTML and interface files  
- `backend/`: PHP scripts for authentication, user handling, matching, moderation, and data entry  
- `sql/`: SQL setup file for database schema (`init.sql`)  

## Setup Instructions (Localhost)

### 1. Software Requirements
- PHP 7.0 or greater  
- MySQL and Apache server (XAMPP recommended)  
- Web browser  

### 2. Database Setup
1. Start MySQL and Apache in the XAMPP Control Panel.  
2. Create a database named `team_compatibility`.  
3. Import `sql/init.sql` into that database.  
   - Success message should confirm five queries executed.  

### 3. Optional Server Configuration
If you encounter issues connecting to the database:  
- Open `backend/db.php`  
- Update the `$host`, `$dbname`, `$user`, and `$pass` values to match your environment.  

If import errors occur, you can edit `init.sql` to remove the `CREATE DATABASE` and `USE` statements and re-import the file.

### 4. Hosting the Web Application
1. Move all project folders into `C:\xampp\htdocs`.  
2. Start Apache and MySQL in XAMPP.  
3. Navigate to:  
   `http://localhost/team_compatibility/frontend/admin_login.php`  

## Testing the Admin Panel

1. Log in using default admin credentials:  
   - Username: `admin`  
   - Password: `password123`  
2. Use the Admin Panel to:
   - Register users  
   - View, edit, or delete users  
   - Activate or deactivate accounts  
   - Add new posts manually  
   - Moderate user-submitted posts  
3. All navigation is centralized in `admin_panel.html` for ease of use.
