<h1 align="center">📚 Booken – Online Bookstore Admin Dashboard</h1>

<p align="center">
  <img src="https://img.shields.io/badge/Language-PHP-blue?style=for-the-badge"/>
  <img src="https://img.shields.io/badge/Database-MySQL-orange?style=for-the-badge"/>
  <img src="https://img.shields.io/badge/Frontend-HTML%20%7C%20CSS%20%7C%20JS-green?style=for-the-badge"/>
</p>

<p align="center">
  A clean and simple <b>Admin Dashboard</b> built with PHP & MySQL for managing bookstore products.  
  Add, update, delete, and display books with image support — all from one place.
</p>

---

## 🖥️ Overview

**Booken** is a web-based bookstore management system designed for administrators.  
It allows admins to manage products (books) efficiently — from adding new ones with images, to editing prices or deleting old listings.  
The dashboard is designed with simplicity, responsiveness, and smooth workflow in mind.

---

## ✨ Features

✅ **Add Products** – Upload a new book with name, price, and cover image  
✅ **Update Products** – Modify book details or replace the image  
✅ **Delete Products** – Remove unwanted or outdated listings  
✅ **Product Display** – View all books in a responsive grid layout  
✅ **Image Upload Support** – Each book has its own visual representation  
✅ **MySQL Integration** – Data stored securely in a structured database  
✅ **Admin Navigation** – Quick access to Add Product, Home, and Logout  

---

## 🗂️ Project Structure

booken-master/
│
├── assets/
│ ├── images/ # Uploaded book images
│
├── db/
│ └── booken_database.sql # MySQL database export
│
├── config.php # Database connection file
├── admin_products.php # Main admin dashboard (add/update/delete)
├── addproduct.php # Alternative product add page
├── logout.php # Admin logout functionality
├── index.php # Landing page (optional)
│
├── README.md
└── .gitignore

yaml
Copy code

---

## ⚙️ Installation Guide

### 🧩 Prerequisites
- [XAMPP](https://www.apachefriends.org/) or [WAMP](https://www.wampserver.com/)
- PHP ≥ 7.4
- MySQL Database
- Git (for cloning the repo)

---

### 🪜 Steps to Run Locally

1. **Clone the Repository**
   ```bash
   git clone https://github.com/vishvashah07/booken-master.git
2.Move it to your Localhost Directory

Move "booken-master" → C:\xampp\htdocs\

3.Start Apache & MySQL

Open XAMPP Control Panel

Start Apache and MySQL

4.Import the Database

Open phpMyAdmin

Create a database named booken_db

Import the SQL file located at:


db/booken_database.sql
5.Configure the Database Connection
Make sure config.php contains:

<?php
$conn = mysqli_connect("localhost", "root", "", "booken_db");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
6.Run the Project
Visit in your browser:http://localhost/booken-master/login.php
🗃️ Database Schema
Table Name: products

Column Name	Type	Description
id	INT (AUTO_INCREMENT)	Unique product ID
name	VARCHAR(255)	Book name/title
price	INT	Book price (in ₹)
image	VARCHAR(255)	Uploaded image filename

🧠 You can import db/booken_database.sql to auto-create this table with sample data.


🧰 Tech Stack
Layer	Technology
Frontend	HTML5, CSS3, JavaScript
Backend	PHP
Database	MySQL
Server	Apache (via XAMPP)
Version Control	Git & GitHub


🤝 Contributing
Contributions are welcome!
If you’d like to add a new feature or fix a bug:

Fork the repo

Create your feature branch

Submit a pull request 🚀

📜 License
This project is open-source and available under the MIT License.

💬 Author
Vishva Shah
📍 Developer | Designer | Tech Explorer
🔗 GitHub • LinkedIn

⭐ If you like this project, don’t forget to give it a star!








