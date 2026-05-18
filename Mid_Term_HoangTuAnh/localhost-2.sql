CREATE DATABASE IF NOT EXISTS hospital_exam4;
USE hospital_exam4;

-- Drop tables if re-run
DROP TABLE IF EXISTS appointments;
DROP TABLE IF EXISTS patients;

-- 1. Patients table
CREATE TABLE patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_code VARCHAR(20) NOT NULL UNIQUE,
    full_name VARCHAR(100) NOT NULL,
    date_of_birth DATE NULL,
    gender ENUM('Male', 'Female', 'Other') DEFAULT 'Other',
    phone VARCHAR(20) NULL,
    address VARCHAR(200) NULL
);

-- 2. Appointments table
CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    doctor_name VARCHAR(100) NOT NULL,
    appointment_date DATETIME NOT NULL,
    department VARCHAR(100) NOT NULL,
    reason TEXT NULL,
    status ENUM('Scheduled', 'Completed', 'Cancelled') DEFAULT 'Scheduled',
    CONSTRAINT fk_patient_appointments
        FOREIGN KEY (patient_id) REFERENCES patients(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- Sample data for patients
INSERT INTO patients (patient_code, full_name, date_of_birth, gender, phone, address) VALUES
('P001', 'Nguyen Van An', '1998-05-12', 'Male', '0901234561', 'Ha Noi'),
('P002', 'Tran Thi Bich', '2000-08-21', 'Female', '0901234562', 'Hai Phong'),
('P003', 'Le Minh Khoa', '1995-11-02', 'Male', '0901234563', 'Da Nang'),
('P004', 'Pham Thu Ha', '2001-03-15', 'Female', '0901234564', 'Ha Noi'),
('P005', 'Vo Quang Huy', '1997-07-09', 'Male', '0901234565', 'Can Tho'),
('P006', 'Doan Ngoc Lan', '1999-12-25', 'Female', '0901234566', 'Hue'),
('P007', 'Bui Gia Bao', '2002-01-18', 'Male', '0901234567', 'Nghe An'),
('P008', 'Hoang My Linh', '1996-04-30', 'Female', '0901234568', 'Ho Chi Minh City'),
('P009', 'Dang Tuan Kiet', '1994-09-14', 'Male', '0901234569', 'Bac Ninh'),
('P010', 'Nguyen Kim Ngan', '2003-06-11', 'Female', '0901234570', 'Nam Dinh');

-- Sample data for appointments
INSERT INTO appointments (patient_id, doctor_name, appointment_date, department, reason, status) VALUES
(1, 'Dr. Tran Quoc Bao', '2026-04-01 08:30:00', 'Cardiology', 'Routine heart check-up', 'Scheduled'),
(2, 'Dr. Nguyen Thi Hoa', '2026-04-01 09:00:00', 'Dermatology', 'Skin allergy consultation', 'Completed'),
(3, 'Dr. Pham Duc Minh', '2026-04-01 10:15:00', 'Orthopedics', 'Knee pain examination', 'Scheduled'),
(4, 'Dr. Le Van Hung', '2026-04-01 11:00:00', 'ENT', 'Sore throat and cough', 'Cancelled'),
(5, 'Dr. Do Thi Mai', '2026-04-02 08:00:00', 'Neurology', 'Frequent headaches', 'Scheduled'),
(6, 'Dr. Tran Quoc Bao', '2026-04-02 09:30:00', 'Cardiology', 'Blood pressure follow-up', 'Completed'),
(7, 'Dr. Nguyen Thi Hoa', '2026-04-02 13:00:00', 'Dermatology', 'Acne treatment', 'Scheduled'),
(8, 'Dr. Pham Duc Minh', '2026-04-03 14:30:00', 'Orthopedics', 'Back pain consultation', 'Scheduled'),
(9, 'Dr. Le Van Hung', '2026-04-03 15:00:00', 'ENT', 'Ear infection check', 'Completed'),
(10, 'Dr. Do Thi Mai', '2026-04-04 16:00:00', 'Neurology', 'Migraine follow-up', 'Cancelled');