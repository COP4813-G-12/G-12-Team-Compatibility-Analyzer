# G-12-Team-Compatibility-Analyzer

A web application that matches users together based on a compatibility score 
determined by the 16 Myers-Briggs personality types.

Online-hosted version: https://fsu-cop4813-g12-tca.infinityfreeapp.com/

## Project Structure

1. HTML scripts (8 files)
2. PHP scripts (25 files)
3. SQL script (2 files)

## Setup Instructions (localhost)

### 1. Software Requirements
----------------------------
1. PHP 7.0 or greater
2. Local MySQL/Apache Server (XAMPP Control Panel recommended)
3. Internet Web Browser

### 2. Database Setup (skip step 3/3a if no issues arise)
---------------------------------------------------------
1. Open the MySQL/Apache server.
2. Create a new database named 'team_compatibility'.
3. Import the 'init.sql' file into the created database.
   - NOTE: the 'init.sql' file has test data already incorporated in it.
   - Use the 'init.sql_empty' file if no incorporated test data is desired.

### 3. Server Setup (not needed, only follow if having trouble)
---------------------------------------------------------------
1. Open the 'db.php' file.
2. Update the file information in accordance to the local MySQL/Apache server:
   
   $host = 'server_db_host';
   $dbname = 'server_db_name';
   $user = 'server_db_user';
   $pass = 'server_db_password';

### 3a. Troubleshooting Server Setup (not needed, only follow if having trouble)
--------------------------------------------------------------------------------
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
   
   http://localhost/team_compatibility/frontend/login.html
   
   - or for a built-in PHP server:
   
   http://localhost:8000/frontend/login.html

## Testing the Web Application

Initial login steps: 
1. Enter in the following URL into the browser:
   - ../backend/create_admin.php
   - This will create the initial default admin login credentials to be used with the web application.
2. Navigate back to the ../frontend/login.html webpage and enter in the following admin login credentials:
   - Username = admin, Password = admin123

Web Application Features:
1. Admin Login (Authentication Required): Admins are securely logged in with role-based access.
2. User Management: Admins can view, add, edit, delete, activate/deactivate users.
3. Content Moderation: Admins can view, approve, reject, or flag user-submitted posts.
4. Data Entry
   - Admins can add and delete project roles, user matches, and assigned roles.
   - Admins can use the "Match Users" feature to calculate compatibility scores based on Myers-Briggs types.
   - Matches are accessible via the "Admin Panel".
5. Admin Analytics Dashboard: Accessible via the "Admin Panel".
   User Statistics:
   - Total number of users displayed dynamically.
   - Graph showing daily registration trends over time.
   - Pie chart showing active vs. inactive user distribution.
   Activity Overview:
   - Total number of posts that users have submitted to the platform.
   - Pie graphs, bar charts, and tables featuring most common categories, criteria, etc.
   - Table showing user compatibility matching rate results among users.
   Graphical Insights (Charts/Tables): Multiple visualizations showing category breakdowns for:
   - User Registrations Over Time (Time-based trends)
   - Active vs Inactive Users
   - Personality Type Distribution
   - User Project Preferences
   - Project Role Listings
   - User Compatibility Matches
   - Most Common Personality Types
   - Top Post Categories (Time-based trends)
   - Most Used Features
   - User Assigned Roles
   Search and Filter Tools:
   - Admins can filter dashboard data (User Registrations Over Time graph & Top Post Categories table only) by a custom date range using calendar fields at the top of the dashboard.

It is advised to test the web application with various placeholder users/admins/posts/matches/project roles, assign them different statuses and descriptions, and test out different configurations in order to become familiar with how the web application works.
