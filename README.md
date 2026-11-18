# 🎓 Smart School Management System (ERP)

A modern **ERP-based School Management System** built with **Laravel**, designed to simplify and manage the academic, administrative, and financial operations of educational institutions.

The system provides role-based access, session-based student management, academic administration, attendance tracking, examination and result processing, fee collection, teacher assignments, and classroom scheduling.

---

## 🚀 Features

### 👨‍🎓 Student Management
- Student Admission
- Student Profile Management
- Student Photo Upload
- Session-Based Student Management
- Student Promotion (Promote / Repeat / Hold)
- Student Roll Assignment
- Student Search & Filter
- Mobile Responsive Student Cards

### 👨‍🏫 Teacher Management
- Teacher Registration
- Employee ID Auto Generation
- Teacher Profile Photo
- Qualification & Subject Specialization
- Teacher CRUD Operations
- Responsive Teacher Directory

### 📚 Academic Management
- Academic Session Management
- Session-Based Student Architecture
- Class Management
- Section Management
- Subject Management
- Teacher Assignment Management
- Class, Section & Subject-Based Teacher Assignment

### 🏫 Classroom & Schedule Management
- Classroom Management (CRUD)
- Classroom Information Management
- Classroom Thumbnail Upload
- VR Model Path Support
- Teacher Assignment-Based Schedule Management
- Multiple Schedules Under One Teacher Assignment
- Day-Based Class Scheduling
- Classroom Allocation
- Teacher Schedule Conflict Detection
- Classroom Booking Conflict Detection
- Schedule Create, Edit & Delete Operations

### 📅 Attendance Management
- Daily Attendance
- Attendance Taking & Editing
- Class & Section-Based Attendance
- Monthly Attendance Report
- Attendance Percentage Calculation
- Student Attendance Calendar

### 📝 Examination & Result Management
- Exam Management
- Multiple Exam Types
- Marks Entry & Update
- Result Management
- Automatic Grade Generation
- Student Result View
- Marksheet Generation
- Printable Result Sheet

### 💰 Fee Management
- Student Fee Management
- Fee Collection
- Fee Payment Management
- Payment History
- Due Calculation
- Fee Receipt Generation
- Student Ledger
- Fee Defaulter Tracking

### 📈 Student Academic Progression
- Student Promotion Wizard
- Promote / Repeat / Hold Management
- Roll Assignment
- Session-Based Student Progression

### 🔐 Authentication & Authorization
- Secure Authentication
- Role & Permission Management
- Spatie Laravel Permission Integration
- Admin Role
- Teacher Role
- Student Role
- Accountant Role
- Permission-Based Access Control

### 📊 Dashboard & Reports
- Responsive Admin Dashboard
- Student Academic Information
- Attendance Reports
- Monthly Attendance Statistics
- Fee & Payment Information

### 🌐 API
- REST API Support
- Class API
- Section API
- Attendance API

---

## 🛠 Tech Stack

| Technology | Purpose |
|---|---|
| Laravel 10 | Backend Framework |
| PHP | Server-Side Programming |
| MySQL | Database |
| Bootstrap 5 | UI Framework |
| JavaScript | Frontend Interactivity |
| jQuery | DOM Manipulation |
| AJAX | Asynchronous Requests |
| Chart.js | Data Visualization |
| Spatie Laravel Permission | Role & Permission Management |

---

## 📦 Installation

### 1. Clone Repository

```bash
git clone https://github.com/Joynalabedins24/Smart-School-Management-System.git
```

### 2. Go to Project Directory

```bash
cd Smart-School-Management-System
```

### 3. Install Dependencies

```bash
composer install
```

```bash
npm install
```

### 4. Create Environment File

```bash
cp .env.example .env
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Configure Database

Update your `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Run Migration & Seeder

```bash
php artisan migrate --seed
```

### 8. Start Development Server

```bash
php artisan serve
```

### 9. Run Vite

```bash
npm run dev
```

Open your browser:

```text
http://127.0.0.1:8000
```

---

## 📸 Screenshots

### Attendance Management

<img width="1915" height="867" alt="Create or Edit Attendance" src="https://github.com/user-attachments/assets/ca040cb9-5f57-4929-b591-649894bf36c0" />

### Attendance Report

<img width="1912" height="862" alt="Attendance Report" src="https://github.com/user-attachments/assets/79b46d19-135e-4f15-bb7f-7dcc7f14e6a5" />

### Monthly Attendance Report

<img width="1917" height="867" alt="Monthly Attendance Report" src="https://github.com/user-attachments/assets/3471ff38-0ad8-4fcd-ae1d-57249e9e93d6" />

<img width="1910" height="864" alt="Attendance Management Interface" src="https://github.com/user-attachments/assets/8ac18431-eada-4270-be4a-7a82491cc372" />

---

## 📌 Upcoming Features

- Weekly Class Routine Generation
- Class & Section-Wise Routine View
- Teacher-Wise Weekly Routine
- Parent Management
- SMS Notifications
- Email Notifications
- Online Admission
- Online Fee Payment
- Library Management
- Inventory Management
- Advanced Dashboard Analytics
- PDF & Excel Report Export
- AI-Based Student Performance Prediction
- Smart Classroom Attendance & Engagement Estimation

---

## 🤝 Contributing

Contributions are welcome!

Feel free to fork this repository, make improvements, and submit pull requests.

---

## 👨‍💻 Developer

**Joynal Abedin**

- GitHub: [Joynalabedins24](https://github.com/Joynalabedins24)

---

⭐ If you find this project useful, don't forget to give it a star!
