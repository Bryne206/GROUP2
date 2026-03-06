****🎟️ GROUP2 - Event Registration System****
A platform to create, manage, and track event registrations efficiently.

**📋 Table of Contents**
About The Project

Features

Technologies Used

Project Structure

Challenges We Faced

How To Run (XAMPP)

File Contents

Screenshots

Group Members

**📖 About The Project**
This is a complete Event Registration System built as a group project. Users can create accounts, browse events, register for events, and manage their registrations through a personal dashboard.

The system is built with PHP for backend logic and HTML/CSS/JavaScript for the frontend. It runs on Apache server using XAMPP.

**✨ Features**
✅ User Registration with profile image upload

✅ Secure Login/Logout system

✅ Session management

✅ Browse events with search and category filters

✅ Event registration with capacity checking

✅ View registered events

✅ Cancel registrations

✅ Personal dashboard with user info

✅ Responsive design

**🛠️ Technologies Used**
Technology	Purpose
PHP	Backend logic, session handling, form processing
HTML5	Page structure
CSS3	Styling and layout
JavaScript	Dynamic content, form validation, API calls
Apache	Web server (via XAMPP)

**FILE STRRUCTURE**
event-registration/
|
├── assets/
│   ├── css/
│   │   └── style.css
│   └── js/
│       └── main.js
|
├── includes/
│   ├── auth.php
│   ├── config.php
│   ├── footer.php
│   └── header.php
|
├── uploads/
│   └── profiles/
|
├── .gitignore
├── dashboard.php
├── events.php
├── index.php
├── login.php
├── logout.php
├── my_registrations.php
├── README.md
└── register.php


😅 Challenges We Faced
During development, we encountered several difficulties:

1. 500 Internal Server Errors
Issue: The site kept showing 500 errors

Cause: Missing config.php file and incorrect file paths

Solution: Created proper configuration file and fixed all require_once paths

_2. Session Management_
Issue: Users getting logged out unexpectedly

Cause: Session not started on some pages

Solution: Added session_start() in config.php and included it everywhere

_3. File Upload Permissions_
Issue: Profile images wouldn't upload

Cause: uploads/profiles/ folder didn't exist or lacked write permissions

Solution: Created folder with proper permissions and added directory check in code

_4. Form Submission Loops_
Issue: Forms resubmitting on page refresh

Cause: POST data persisting after form submission

Solution: Implemented PRG (Post-Redirect-Get) pattern using header redirects

_5. Event Capacity Logic_
Issue: Users could register beyond event capacity

Cause: Race conditions in registration checking

Solution: Added real-time capacity verification before insert

_6. XAMHP Configuration_
Issue: Some PHP extensions weren't enabled

Cause: Default XAMPP setup

Solution: Enabled gd extension for image handling in php.ini

_7. File Path Issues_
Issue: CSS/JS files not loading

Cause: Incorrect relative paths

Solution: Used root-relative paths and fixed all includes

**🚀 How To Run (XAMPP)**
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

SCREENSHOTS

<img width="1916" height="877" alt="image" src="https://github.com/user-attachments/assets/c2868e96-2af2-4661-8192-e24e87083c8d" />

<img width="1895" height="870" alt="image" src="https://github.com/user-attachments/assets/93102f80-ab1b-49ea-bef3-39dd7b0eb28a" />

<img width="1919" height="883" alt="image" src="https://github.com/user-attachments/assets/cd7b63a6-f738-44d3-b325-496e112d9caa" />

<img width="1895" height="880" alt="image" src="https://github.com/user-attachments/assets/5a45095d-804d-422f-bdb7-3f3e2812079e" />

<img width="1896" height="881" alt="image" src="https://github.com/user-attachments/assets/e327f487-d1f5-4753-ae11-de0c00cad4d0" />

<img width="1896" height="886" alt="image" src="https://github.com/user-attachments/assets/f1cf68c1-08ff-4387-87d0-917485fbbf70" />

******GROUP MEMBERS******

1.	Agyapong Clifford - 052441360057
2.	FaithLord Kojo Afful - 052441360314
3.	Abdullah Murtala – 052441360302
4.	Baligi Simon -  052441360215
5.	Frank Opoku Acheampong – 052441360303
6.	Mohammed Faiza - 052441360240
7.	Boakye Prince - 052541360358
8.	Amoateng Mensah Felix - 052441360044
   





