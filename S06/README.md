# Session 06 – Database Design

This repository contains the database design for Session 06 including normalization analysis, ER diagrams, and SQL schema files.

---

# Part 1: Normalization

| Table Name | Primary Key | Foreign Key | Normal Form | Description |
| :--- | :--- | :--- | :--- | :--- |
| users | user_id | None | 3NF | Stores user account information |
| posts | post_id | user_id | 3NF | Stores blog posts |
| categories | category_id | None | 3NF | Stores blog categories |
| tags | tag_id | None | 3NF | Stores tags |
| post_tags | (post_id, tag_id) | post_id, tag_id | 3NF | Post-Tag relationship |
| comments | comment_id | post_id, user_id | 3NF | Stores post comments |
| patients | patient_id | None | 3NF | Stores patient information |
| doctors | doctor_id | None | 3NF | Stores doctor information |
| appointments | appointment_id | patient_id, doctor_id | 3NF | Appointment records |
| prescriptions | prescription_id | appointment_id | 3NF | Medical prescriptions |
| medicines | medicine_id | None | 3NF | Medicine list |
| prescription_medicines | (prescription_id, medicine_id) | prescription_id, medicine_id | 3NF | Prescription-Medicine relationship |

---

# Part 2: Relationships

## Blog System

- Users → Posts: One-to-Many
- Posts → Comments: One-to-Many
- Users → Comments: One-to-Many
- Posts → Tags: Many-to-Many

## Hospital System

- Patients → Appointments: One-to-Many
- Doctors → Appointments: One-to-Many
- Appointments → Prescriptions: One-to-One
- Prescriptions → Medicines: Many-to-Many
