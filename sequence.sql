DROP DATABASE IF EXISTS sequence;

CREATE DATABASE sequence;

USE sequence;

CREATE TABLE Students (
  s_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(256) NOT NULL,
  password VARCHAR(256) NOT NULL,
  college ENUM('CMC','HMC','Scripps') NOT NULL,
  year INT(4) UNSIGNED NOT NULL,
  major ENUM('CS', 'Economics', 'Mathematics'),
  sequence ENUM('None', 'CS', 'Financial-Economics', 'Leadership')
);

CREATE TABLE Major (
  m_id INT UNSIGNED NOT NULL PRIMARY KEY,
  credits FLOAT(3,2) NOT NULL,
  college ENUM('CMC','HMC','Scripps') NOT NULL
);

CREATE TABLE Sequence (
  q_id INT UNSIGNED NOT NULL PRIMARY KEY,
  credits FLOAT(3,2) NOT NULL
  college ENUM('CMC','HMC','Scripps') NOT NULL
);

CREATE TABLE Courses (
  c_id INT UNSIGNED NOT NULL PRIMARY KEY,
  credits FLOAT(3,2) NOT NULL,
  college ENUM('CMC', 'HMC','Scripps') NOT NULL
);

CREATE TABLE Completed (
  s_id INT UNSIGNED NOT NULL,
	FOREIGN KEY (s_id) REFERENCES Students (s_id),
  c_id INT UNSIGNED NOT NULL,
  FOREIGN KEY (c_id) REFERENCES Courses (c_id),
  pass BIT NULL DEFAULT 0
);
