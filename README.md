🎟️ GROUP2 - Event Registration System
A platform to create, manage, and track event registrations efficiently.

📋 Table of Contents
About The Project

Features

Technologies Used

Project Structure

Challenges We Faced

How To Run (XAMPP)

File Contents

Screenshots

Group Members

📖 About The Project
This is a complete Event Registration System built as a group project. Users can create accounts, browse events, register for events, and manage their registrations through a personal dashboard.

The system is built with PHP for backend logic and HTML/CSS/JavaScript for the frontend. It runs on Apache server using XAMPP.

✨ Features
✅ User Registration with profile image upload

✅ Secure Login/Logout system

✅ Session management

✅ Browse events with search and category filters

✅ Event registration with capacity checking

✅ View registered events

✅ Cancel registrations

✅ Personal dashboard with user info

✅ Responsive design

🛠️ Technologies Used
Technology	Purpose
PHP	Backend logic, session handling, form processing
HTML5	Page structure
CSS3	Styling and layout
JavaScript	Dynamic content, form validation, API calls
Apache	Web server (via XAMPP)
File System	Store profile images locally
📁 Project Structure
text
event-registration/
│
├── assets/
│   ├── css/
│   │   └── style.css
│   └── js/
│       └── main.js
│
├── includes/
│   ├── header.php
│   ├── footer.php
│   ├── config.php
│   └── auth.php
│
├── uploads/
│   └── profiles/
│
├── index.php
├── register.php
├── login.php
├── dashboard.php
├── events.php
├── my_registrations.php
├── logout.php
└── README.md
😅 Challenges We Faced
During development, we encountered several difficulties:

1. 500 Internal Server Errors
Issue: The site kept showing 500 errors

Cause: Missing config.php file and incorrect file paths

Solution: Created proper configuration file and fixed all require_once paths

2. Session Management
Issue: Users getting logged out unexpectedly

Cause: Session not started on some pages

Solution: Added session_start() in config.php and included it everywhere

3. File Upload Permissions
Issue: Profile images wouldn't upload

Cause: uploads/profiles/ folder didn't exist or lacked write permissions

Solution: Created folder with proper permissions and added directory check in code

4. Form Submission Loops
Issue: Forms resubmitting on page refresh

Cause: POST data persisting after form submission

Solution: Implemented PRG (Post-Redirect-Get) pattern using header redirects

5. Event Capacity Logic
Issue: Users could register beyond event capacity

Cause: Race conditions in registration checking

Solution: Added real-time capacity verification before insert

6. XAMHP Configuration
Issue: Some PHP extensions weren't enabled

Cause: Default XAMPP setup

Solution: Enabled gd extension for image handling in php.ini

7. File Path Issues
Issue: CSS/JS files not loading

Cause: Incorrect relative paths

Solution: Used root-relative paths and fixed all includes

🚀 How To Run (XAMPP)
Step 1: Install XAMPP
Download and install XAMPP from https://www.apachefriends.org/

Step 2: Start Apache
Open XAMPP Control Panel

Click Start for Apache

Step 3: Copy Project Files
Navigate to C:\xampp\htdocs\

Create a folder called event-registration

Copy ALL project files into this folder

Step 4: Create Uploads Folder
Inside your project folder, create: uploads/profiles/

Right-click → Properties → make sure it's writable

Step 5: Run The Project
Open your browser

Go to: http://localhost/event-registration/

You should see the homepage!

*Step 6: Test The System*
Click Create Account to register

-Upload a profile image (JPG/PNG, max 2MB)

-Login with your credentials

-Browse events and register

-Check "My Registrations" to view/cancel
