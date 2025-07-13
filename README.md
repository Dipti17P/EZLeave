# 🎓 EZLeave - Advanced Student Leave Management System

Welcome to **EZLeave** — a modern, simple and powerful student leave application system designed for colleges and universities.  
It helps students apply for leaves online, track leave history, and provides admin tools for leave approval, reporting, and calendar management.


## 🚀 Features

✅ Modern UI with Responsive Design  
✅ Student Leave Application (with type & reason)
✅ Admin Approval Panel  
✅ Leave Reports  
✅ Calendar View (Exams, Holidays, Leaves)  
✅ Password Reset (direct change on system)  
✅ Simple Database — Easy to Setup  
✅ Built with **PHP + MySQL + Bootstrap 5**


## 🏗️ Tech Stack

- **Frontend**: HTML, CSS, Bootstrap 5  
- **Backend**: PHP 8.0+, MySQL (MariaDB 10.4)  
- **Database**: MySQL (`student_leave.sql`)  
- **Dev Tools**: XAMPP / phpMyAdmin  



## 📂 Project Structure


EZLeave/
│
├── admin/              → Admin dashboard files
├── student/            → Student dashboard files
├── common/             → Shared PHP files (db.php, header.php)
├── assets/             → CSS, JS, images
│
├── index.php           → Main landing page / login
├── register.php        → New student registration
├── forgot_password.php → Password reset form
├── calendar_data.php   → Calendar API (for events)
├── exam_conflict.php   → Exam conflict checker
│
├── student_leave.sql   → 💾 Database schema file
├── README.md           → 📖 Project documentation
└── ...



⚙️ Setup Instructions
1️⃣ Clone or download the project
2️⃣ Import student_leave.sql into your MySQL using phpMyAdmin:

Go to phpMyAdmin

Create database: student_leave

Import → Select student_leave.sql → Go

3️⃣ Configure common/db.php with your database credentials:

$host = "localhost";
$username = "root";
$password = "";
$database = "student_leave";

4️⃣ Run XAMPP (Apache + MySQL)
5️⃣ Open browser → http://localhost/EZLeave/ 🚀

🧑‍💻 Default Admin Login
Email: dp3133486@gmai.com
Password: 789

💡 Future Ideas
Email notifications to Admin & Students

Export Leave Reports (PDF/Excel)

Multi-user roles (Faculty / Department Head)

Advanced Exam-Leave Clash Prevention

Mobile-first UI

🤝 Contributing
Feel free to fork and contribute! If you have ideas for new features — open an issue or send a pull request 🚀

📄 License
This project is open-source for academic learning use 🎓

Made with ❤️ by Dipti Patil
SVKM’s Institute of Technology