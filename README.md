# 📚 MakTutorials

MakTutorials is a PHP-based web application built with Laravel.  
It includes modules for student authentication, fee records, attendance, and batch management.

---

## 🚀 Features

- Student and Admin Authentication  
- Dashboard for Students and Admin  
- Fee Records Management  
- Attendance Tracking  
- Batch Assignment System  

---

## 📸 Screenshots

### 🏠 Home Page

![Home Page](screenshots/homepage.png)  
![Career Page](screenshots/career.png)  
![About Us Page](screenshots/aboutus.png)  
![Login Page 1](screenshots/login1.png)  
![Login Page 2](screenshots/login2.png)

### 📊 Admin Dashboard

![Admin Dashboard](screenshots/dashboard.png)  
![Student Management](screenshots/student.png)

### 🌐 Sample Test Image

![Test Image](https://upload.wikimedia.org/wikipedia/commons/thumb/3/3f/Walking_tiger_female.jpg/1200px-Walking_tiger_female.jpg)

---

## ⚙️ Requirements

- PHP >= 8.0  
- Laravel >= 9  
- MySQL  
- Composer  

---

## 🛠️ Setup Instructions

```bash
git clone https://github.com/yourusername/MakTutorials.git
cd MakTutorials
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
