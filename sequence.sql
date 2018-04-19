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
   ('0', 'Computer Science', '13.00'),
   ('1', 'Economics', '11.00'),
   ('2', 'Mathematics', '12.00');


CREATE TABLE Sequence (
  q_id INT UNSIGNED NOT NULL PRIMARY KEY,
  q_name ENUM('None', 'Computer Science', 'Financial Economics', 'Leadership'),
  credits FLOAT(3,2) NOT NULL
);

INSERT INTO Sequence (q_id, q_name, credits)
VALUES
    ('0', 'None', '0.00'),
    ('1', 'Computer Science', '6.00'),
    ('2', 'Financial Economics', '5.00'),
    ('3', 'Leadership', '5.00');

CREATE TABLE Courses (
  c_id INT UNSIGNED NOT NULL PRIMARY KEY,
  credits FLOAT(4,2) NOT NULL
);

CREATE TABLE Completed (
  s_id INT UNSIGNED NOT NULL,
	FOREIGN KEY (s_id) REFERENCES Students (s_id),
  c_id INT UNSIGNED NOT NULL,
  FOREIGN KEY (c_id) REFERENCES Courses (c_id),
  pass BIT NULL DEFAULT 0
);
