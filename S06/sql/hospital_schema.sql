CREATE DATABASE hospital_management;
USE hospital_management;

-- PATIENTS
CREATE TABLE patients (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  date_of_birth DATE,
  phone VARCHAR(20)
);

-- DOCTORS
CREATE TABLE doctors (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  specialization VARCHAR(150)
);

-- APPOINTMENTS
CREATE TABLE appointments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  patient_id INT NOT NULL,
  doctor_id INT NOT NULL,
  appointment_date DATETIME NOT NULL,

  FOREIGN KEY (patient_id)
    REFERENCES patients(id)
    ON DELETE CASCADE,

  FOREIGN KEY (doctor_id)
    REFERENCES doctors(id)
);

-- PRESCRIPTIONS
CREATE TABLE prescriptions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  appointment_id INT UNIQUE NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (appointment_id)
    REFERENCES appointments(id)
    ON DELETE CASCADE
);

-- MEDICINES
CREATE TABLE medicines (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  manufacturer VARCHAR(150)
);

-- PRESCRIPTION_MEDICINES (bridge table)
CREATE TABLE prescription_medicines (
  id INT AUTO_INCREMENT PRIMARY KEY,
  prescription_id INT NOT NULL,
  medicine_id INT NOT NULL,
  dosage VARCHAR(80),
  frequency VARCHAR(80),

  FOREIGN KEY (prescription_id)
    REFERENCES prescriptions(id)
    ON DELETE CASCADE,

  FOREIGN KEY (medicine_id)
    REFERENCES medicines(id),

  UNIQUE (prescription_id, medicine_id)
);
