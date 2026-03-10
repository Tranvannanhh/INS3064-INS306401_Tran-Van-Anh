# Session 06 — Database Design

This repository contains the solutions for **Session 06: Database Design, Normalization, and ERD**.

---

# Part 1: Normalization

Original table: **Student_Grades_Raw**

Columns:

* StudentID
* StudentName
* CourseID
* CourseName
* ProfessorName
* ProfessorEmail
* Grade

Problems in the raw table:

* Redundant data (student name repeated)
* Course information repeated
* Professor information repeated
* Update anomalies and data inconsistency risks

The logical key is:

(StudentID, CourseID)

Normalization steps were applied to achieve **Third Normal Form (3NF)**.

| Table Name      | Primary Key             | Foreign Key           | Normal Form | Description                                 |
| --------------- | ----------------------- | --------------------- | ----------- | ------------------------------------------- |
| students        | student_id              | None                  | 3NF         | Stores student information                  |
| professors      | professor_id            | None                  | 3NF         | Stores professor information                |
| courses         | course_id               | professor_id          | 3NF         | Stores course data and professor assignment |
| student_courses | (student_id, course_id) | student_id, course_id | 3NF         | Stores student grades per course            |

Final schema removes redundancy and ensures data integrity.

---

# Part 2: Relationship Drills

### 1. Author — Book

Relationship Type: **One-to-Many (1:N)**
Foreign Key Location: **books.author_id**

Explanation: One author can write many books.

---

### 2. Citizen — Passport

Relationship Type: **One-to-One (1:1)**
Foreign Key Location: **passports.citizen_id**

Explanation: Each citizen has exactly one passport.

---

### 3. Customer — Order

Relationship Type: **One-to-Many (1:N)**
Foreign Key Location: **orders.customer_id**

Explanation: One customer can place multiple orders.

---

### 4. Student — Class

Relationship Type: **Many-to-Many (N:N)**

Implementation: Requires a **junction table**

Example:

student_classes

* student_id
* class_id

Explanation: Students can enroll in multiple classes, and each class has multiple students.

---

### 5. Team — Player

Relationship Type: **One-to-Many (1:N)**
Foreign Key Location: **players.team_id**

Explanation: One team has many players.

---

# Part 3: Blog Database Design

The Blog system includes the following entities:

* Users
* Posts
* Categories
* Tags
* Comments
* Post_Tags (junction table)

Relationship overview:

Users 1---N Posts
Users 1---N Comments
Posts 1---N Comments
Posts N---N Tags
Posts N---1 Categories

ERD diagram is available in:

/diagrams/blog_erd.png

SQL schema is available in:

/sql/blog_schema.sql

---

# Part 4: Hospital Management Database

Entities included:

* Patients
* Doctors
* Appointments
* Prescriptions
* Medicines
* Prescription_Medicines (junction table)

Relationship overview:

Patients 1---N Appointments
Doctors 1---N Appointments
Appointments 1---1 Prescriptions
Prescriptions N---N Medicines

ERD diagram is available in:

/diagrams/hospital_erd.png

SQL schema is available in:

/sql/hospital_schema.sql
