CREATE DATABASE test;

USE test;

CREATE TABLE registrations (
     id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    branch VARCHAR(255) NOT NULL,
    registration_id VARCHAR(255) NOT NULL,
    participant_course VARCHAR(255) NOT NULL,
    project_name VARCHAR(255) NOT NULL,
    project_type VARCHAR(255) NOT NULL,
    project_url VARCHAR(255) NOT NULL,
    project_domain VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
