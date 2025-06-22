# School Management System
A web-based Student Information System (SIS) that mimics the core functionalities of a university's academic automation system. This PHP and MySQL-based system allows students, lecturers, and administrators to manage courses, view grades, and track attendance in a centralized, user-friendly interface.

## Project Overview

This system is developed to:
- Simplify the management of student and course data.
- Provide dashboards for students, lecturers, and admins.
- Track attendance weekly for each course.
- Store and display student grades (midterm/final).
- Enable editing and deletion of student/course records.

## Technologies Used

- **Frontend:** HTML5, CSS, JavaScript
- **Backend:** PHP
- **Database:** MySQL (via phpMyAdmin)
- **IDE:** Visual Studio Code
- **Deployment:** WAMP Server (Local) 
- **File structure includes:** `.php` files, `.sql` database file, image assets, and utility scripts.

##  Project Structure
SchoolManagement/
├── Code/
│ ├── index.php
│ ├── studentDashboard.php
│ ├── adminLogin.php
│ ├── lecturerLogin.php
│ ├── create.php
│ ├── editStudent.php
│ ├── delete.php
│ ├── update.php
│ └── ...
├── db/
│ └── school.sql
├── assets/
│ └── images, styles
└── README.md

##  Features

-  **Student Login & Dashboard**: View attendance, courses, and grades.
-  **Lecturer Login**: View student lists, update grades.
-  **Admin Panel**: Add/edit/delete student/course records.
-  **Course Tables**: Web Programming, Advanced Programming, Machine Learning.
-  **Attendance Tracking**: Weekly attendance per student per course.
-  Basic session control for user access types.

##  Login Credentials

###  Student Login
- Just enter the **Name and Surname** of the student (e.g., `Melike Demir`, `Melike Işıl Utal`, `Mehmet Can Cantaş`)

###  Lecturer Login
| Lecturer Name       | Username              | Password      |
|---------------------|------------------------|---------------|
| Alparslan Horasan   | `Alparslan Horasan`    | `ahorasan34`  |
| Melda Yücel         | `Melda Yücel`          | `myucel07`    |
| Selçuk Şener        | `Selçuk Şener`         | `ssener01`    |

###  Admin Login
- **Username:** `admin`
- **Password:** `admin123`

## Setup Instructions

### 1. Clone the Repository
git clone https://github.com/melikeisil/school-management-system.git

### 2. Move Project to WAMP Directory
Place the project inside your WAMP www directory:
C:\wamp64\www\SchoolManagement

### 3. Import the MySQL Database
Open http://localhost/phpmyadmin
Create a new database (e.g. school)
Go to the Import tab
Select the file: db/school.sql
Click Go

### 4. Run the Project
Navigate to:
http://localhost/SchoolManagement
Use the login pages to test each user role.(from database students table that mentioned above as "student login")








