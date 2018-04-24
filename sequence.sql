DROP DATABASE IF EXISTS sequence;

CREATE DATABASE sequence;

USE sequence;

CREATE TABLE Students (
  s_id INT(8) UNSIGNED NOT NULL PRIMARY KEY,
  firstname VARCHAR(256) NOT NULL,
  lastname VARCHAR(256) NOT NULL,
  pwd VARCHAR(256) NOT NULL,
  college ENUM('Claremont McKenna College','Harvey Mudd College','Scripps College') NOT NULL,
  grad INT(4) UNSIGNED NOT NULL,
  major ENUM('Computer Science', 'Economics', 'Mathematics'),
  sequence ENUM('None', 'Computer Science', 'Financial Economics', 'Leadership')
);

CREATE TABLE Major (
  m_id INT UNSIGNED NOT NULL PRIMARY KEY,
  m_name ENUM('Computer Science', 'Economics', 'Mathematics'),
  credits FLOAT(4,2) NOT NULL
);

INSERT INTO Major (m_id, m_name, credits)
VALUES
   (0, 'Computer Science', 13.00),
   (1, 'Economics', 11.00),
   (2, 'Mathematics', 11.00);

CREATE TABLE Sequence (
  q_id INT UNSIGNED NOT NULL PRIMARY KEY,
  q_name ENUM('None', 'Computer Science', 'Financial Economics'),
  credits FLOAT(3,2) NOT NULL
);

INSERT INTO Sequence (q_id, q_name, credits)
VALUES
    (0, 'None', 0.00),
    (1, 'Computer Science', 6.00),
    (2, 'Financial Economics', 5.00),
    (3, 'Leadership', 5.00);

CREATE TABLE Courses (
    c_id FLOAT(4,3) NOT NULL PRIMARY KEY,
    credits FLOAT(3,2) NOT NULL,
    m_id INT(1) UNSIGNED NOT NULL,
    FOREIGN KEY (m_id) REFERENCES Major (m_id),
    q_id INT(1) UNSIGNED NOT NULL,
    FOREIGN KEY (q_id) REFERENCES Sequence (q_id),
    is_required BIT NULL DEFAULT 0
);

CREATE TABLE Completed (
    s_id INT UNSIGNED NOT NULL,
  	FOREIGN KEY (s_id) REFERENCES Students (s_id),
    c_id FLOAT(4,3) UNSIGNED NOT NULL,
    FOREIGN KEY (c_id) REFERENCES Courses (c_id),
    pass BIT NULL DEFAULT 0
);

-- Computer Science courses
INSERT INTO Courses (c_id, credits, m_id, q_id, is_required)
VALUES
    (0.005, 1.00, 0, 0, 0),
    (0.060, 1.00, 0, 0, 1),
    (0.070, 1.00, 0, 0, 1),
    (0.055, 1.00, 0, 0, 1),
    (0.081, 1.00, 0, 0, 1),
    (0.105, 1.00, 0, 0, 1),
    (0.121, 1.00, 0, 0, 1),
    (0.131, 1.00, 0, 0, 1),
    (0.140, 1.00, 0, 0, 1),
    (0.106, 1.00, 0, 0, 0),
    (0.111, 1.00, 0, 0, 0),
    (0.124, 1.00, 0, 0, 0),
    (0.125, 1.00, 0, 0, 0),
    (0.132, 1.00, 0, 0, 0),
    (0.133, 1.00, 0, 0, 0),
    (0.134, 1.00, 0, 0, 0),
    (0.136, 1.00, 0, 0, 0),
    (0.137, 1.00, 0, 0, 0),
    (0.141, 1.00, 0, 0, 0),
    (0.142, 1.00, 0, 0, 0),
    (0.144, 1.00, 0, 0, 0),
    (0.147, 1.00, 0, 0, 0),
    (0.151, 1.00, 0, 0, 0),
    (0.152, 1.00, 0, 0, 0),
    (0.153, 1.00, 0, 0, 0),
    (0.154, 1.00, 0, 0, 0),
    (0.155, 1.00, 0, 0, 0),
    (0.156, 1.00, 0, 0, 0),
    (0.157, 1.00, 0, 0, 0),
    (0.158, 1.00, 0, 0, 0),
    (0.159, 1.00, 0, 0, 0),
    (0.181, 1.00, 0, 0, 0),
    (0.189, 1.00, 0, 0, 0),
    (0.183, 1.00, 0, 0, 1),
    (0.184, 1.00, 0, 0, 1),
    (0.195, 0.00, 0, 0, 1);

-- Economics courses
INSERT INTO Courses (c_id, credits, m_id, q_id, is_required)
VALUES
    (1.050, 1.00, 1, 0, 1),
    (1.101, 1.00, 1, 0, 1),
    (1.102, 1.00, 1, 0, 1),
    (1.125, 1.00, 1, 0, 1),
    (1.180, 1.00, 1, 0, 1),
    (1.103, 1.00, 1, 0, 0),
    (1.107, 1.00, 1, 0, 0),
    (1.109, 1.00, 1, 0, 0),
    (1.120, 1.00, 1, 0, 0),
    (1.129, 1.00, 1, 0, 0),
    (1.070, 1.00, 1, 0, 0),
    (1.134, 1.00, 1, 0, 0),
    (1.135, 1.00, 1, 0, 0),
    (1.136, 1.00, 1, 0, 0),
    (1.137, 1.00, 1, 0, 0),
    (1.139, 1.00, 1, 0, 0),
    (1.193, 1.00, 1, 0, 0),
    (1.118, 1.00, 1, 0, 0),
    (1.140, 1.00, 1, 0, 0),
    (1.141, 1.00, 1, 0, 0),
    (1.142, 1.00, 1, 0, 0),
    (1.143, 1.00, 1, 0, 0),
    (1.145, 1.00, 1, 0, 0),
    (1.165, 1.00, 1, 0, 0),
    (1.167, 1.00, 1, 0, 0),
    (1.171, 1.00, 1, 0, 0),
    (1.173, 1.00, 1, 0, 0),
    (1.174, 1.00, 1, 0, 0),
    (1.175, 1.00, 1, 0, 0),
    (1.097, 1.00, 1, 0, 0),
    (1.186, 1.00, 1, 0, 0),
    (1.187, 1.00, 1, 0, 0);

-- Mathematics courses
INSERT INTO Courses (c_id, credits, m_id, q_id, is_required)
VALUES
    (2.032, 1.00, 2, 0, 1),
    (2.060, 1.00, 2, 0, 1),
    (2.131, 1.00, 2, 0, 1),
    (2.135, 1.00, 2, 0, 1),
    (2.171, 1.00, 2, 0, 1),
    (2.140, 1.00, 2, 0, 0),
    (2.144, 1.00, 2, 0, 0),
    (2.149, 1.00, 2, 0, 0),
    (2.132, 1.00, 2, 0, 0),
    (2.137, 1.00, 2, 0, 0),
    (2.138, 1.00, 2, 0, 0),
    (2.139, 1.00, 2, 0, 0),
    (2.151, 1.00, 2, 0, 0),
    (2.152, 1.00, 2, 0, 0),
    (2.156, 1.00, 2, 0, 0),
    (2.157, 1.00, 2, 0, 0),
    (2.158, 1.00, 2, 0, 0),
    (2.172, 1.00, 2, 0, 0),
    (2.173, 1.00, 2, 0, 0),
    (2.175, 1.00, 2, 0, 0);
