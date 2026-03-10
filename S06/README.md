# Session 06 – Database Design

This repository contains the database design for Session 06, including normalization analysis, relationship explanation, ER diagrams, and SQL schema files.

---

# Part 1: Normalization

| Table Name | Primary Key | Foreign Key | Normal Form | Description |
| :--- | :--- | :--- | :--- | :--- |
| users | user_id | None | 3NF | Stores user account information |
| posts | post_id | user_id | 3NF | Stores blog posts created by users |
| categories | category_id | None | 3NF | Stores post categories |
| tags | tag_id | None | 3NF | Stores tag labels |
| post_tags | (post_id, tag_id) | post_id, tag_id | 3NF | Many-to-many relationship between posts and tags |
| comments | comment_id | post_id, user_id | 3NF | Stores comments on blog posts |
| patients | patient_id | None | 3NF | Stores patient information |
| doctors | doctor_id | None | 3NF | Stores doctor information |
| appointments | appointment_id | patient_id, doctor_id | 3NF | Stores appointment records |
| prescriptions | prescription_id | appointment_id | 3NF | Stores prescriptions issued during appointments |
| medicines | medicine_id | None | 3NF | Stores medicine information |
| prescription_medicines | (prescription_id, medicine_id) | prescription_id, medicine_id | 3NF | Many-to-many relationship between prescriptions and medicines |

---

# Part 2: Relationships

### Blog System

- **Users to Posts:** One-to-Many (1:N). A user can create multiple blog posts.
- **Posts to Comments:** One-to-Many (1:N). A post can have many comments.
- **Users to Comments:** One-to-Many (1:N). A user can write many comments.
- **Posts to Tags:** Many-to-Many (N:N). A post can have multiple tags and a tag can belong to multiple posts.

### Hospital System

- **Patients to Appointments:** One-to-Many (1:N). A patient can have multiple appointments.
- **Doctors to Appointments:** One-to-Many (1:N). A doctor can handle multiple appointments.
- **Appointments to Prescriptions:** One-to-One (1:1). Each appointment may generate one prescription.
- **Prescriptions to Medicines:** Many-to-Many (N:N). A prescription can contain multiple medicines.
