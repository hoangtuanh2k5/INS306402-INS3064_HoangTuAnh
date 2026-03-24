
Part 1: Normalization Challenge

## Task 1 — Identify Violations

### 1. Columns causing redundancy
The following columns contain repeated data:

- **StudentName** → repeated for the same student (e.g., Nguyen An appears multiple times).
- **CourseName** → repeated for every student enrolled in that course.
- **ProfessorName** → repeated for each course record.
- **ProfessorEmail** → repeated whenever the same professor appears.

Example:  
"Dr. Le" and "le@uni.edu" appear multiple times because several students take the same course.

---

### 2. Possible Update Anomalies

**Email Change (ProfessorEmail)**  
If Dr. Le changes email, every row containing `le@uni.edu` must be updated.  
If one row is missed, the database becomes inconsistent.

**Course Rename (CourseName)**  
If "Database Systems" changes to "Advanced Database Systems", all rows must be updated.

**Student Name Correction**  
If Nguyen An's name is corrected, it must be changed in every row.

---

### 3. Transitive Dependency

There is a **transitive dependency**:

```
CourseID → ProfessorName → ProfessorEmail
```

This means:
- CourseID determines ProfessorName
- ProfessorName determines ProfessorEmail

But **ProfessorEmail does not depend directly on the primary key of the table**, which violates **Third Normal Form (3NF)**.

---

## Task 2 — Decompose to 3NF

To remove redundancy and anomalies, the table is decomposed into four tables.

---

### 1. Students Table

**Purpose:**  
Stores student information without repeating it in multiple rows.

| Column | Type | Constraint |
|------|------|------|
| student_id | INT | PRIMARY KEY |
| student_name | VARCHAR(100) | NOT NULL |

Explanation:  
Each student is stored once, avoiding repetition of student names.

---

### 2. Professors Table

**Purpose:**  
Stores professor information separately.

| Column | Type | Constraint |
|------|------|------|
| professor_id | INT | PRIMARY KEY |
| professor_name | VARCHAR(100) | NOT NULL |
| professor_email | VARCHAR(100) | UNIQUE |

Explanation:  
Separating professor data prevents repeating the professor's email in multiple rows.

---

### 3. Courses Table

**Purpose:**  
Stores course information and links each course to a professor.

| Column | Type | Constraint |
|------|------|------|
| course_id | INT | PRIMARY KEY |
| course_name | VARCHAR(100) | NOT NULL |
| professor_id | INT | FOREIGN KEY → Professors(professor_id) |

Explanation:  
A course belongs to one professor, so the table references the **Professors** table instead of repeating professor data.

---

### 4. Enrollments Table

**Purpose:**  
Links students and courses while storing grades.

| Column | Type | Constraint |
|------|------|------|
| student_id | INT | FOREIGN KEY → Students(student_id) |
| course_id | INT | FOREIGN KEY → Courses(course_id) |
| grade | VARCHAR(5) | |

Primary Key:

```
PRIMARY KEY (student_id, course_id)
```

Explanation:  
This table resolves the **many-to-many relationship** between students and courses and stores the grade for each enrollment.

---

### Result

After decomposition:

- No repeated student, course, or professor information.
- No update anomalies.
- All tables satisfy **Third Normal Form (3NF)**.




Part 2: Relationship Drills

### 1. Author — Book

Relationship Type: **One-to-Many (1:N)**  
FK Location: **Book table (author_id)**  

Explanation:  
Một author có thể viết nhiều book, nhưng mỗi book thường chỉ có một author.

---

### 2. Citizen — Passport

Relationship Type: **One-to-One (1:1)**  
FK Location: **Passport table (citizen_id)**  

Explanation:  
Một citizen chỉ có một passport và một passport chỉ thuộc về một citizen.

---

### 3. Customer — Order

Relationship Type: **One-to-Many (1:N)**  
FK Location: **Order table (customer_id)**  

Explanation:  
Một customer có thể tạo nhiều order, nhưng mỗi order chỉ thuộc về một customer.

---

### 4. Student — Class

Relationship Type: **Many-to-Many (N:N)**  
FK Location: **Enrollment / Student_Class table (student_id, class_id)**  

Explanation:  
Một student có thể học nhiều class và một class có nhiều student.  
Cần một bảng trung gian để lưu quan hệ.

---

### 5. Team — Player

Relationship Type: **One-to-Many (1:N)**  
FK Location: **Player table (team_id)**  

Explanation:  
Một team có nhiều player, nhưng mỗi player chỉ thuộc về một team.