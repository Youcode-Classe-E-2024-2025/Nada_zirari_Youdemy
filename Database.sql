CREATE DATABASE youdemy2;

USE youdemy2;

-- Table pour les utilisateurs
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('student','admin', 'teacher') NOT NULL
   
);





-- Table pour les cours
CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    teacher_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    content TEXT NOT NULL,
    category VARCHAR(100),
    tags VARCHAR(255),
    -- created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    -- updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (teacher_id) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL, -- L'étudiant
    course_id INT NOT NULL, -- Le cours
    enrollment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Date d'inscription
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

CREATE TABLE tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);
-- Insérer des tags dans la table tags
INSERT INTO tags (name) VALUES
('PHP'),
('JavaScript'),
('MySQL'),
('HTML'),
('CSS'),
('Python'),
('React'),
('Node.js'),
('Laravel'),
('Vue.js');

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);
CREATE TABLE course_statistics (
    course_id INT NOT NULL,
    student_count INT DEFAULT 0,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

INSERT INTO users (name, email, password, role) VALUES ('student', 'student1@gmail.com','123456','student');
ALTER TABLE courses 
ADD COLUMN category_id INT,
ADD FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL;
ALTER TABLE users ADD COLUMN status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending';
ALTER TABLE courses ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP;
INSERT INTO categories (name) VALUES ('Dévellopement');