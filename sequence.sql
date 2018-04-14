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
  major ENUM('CS', 'Economics', 'Mathematics'),
  sequence ENUM('None', 'CS', 'Financial-Economics', 'Leadership')
);

CREATE TABLE Major (
  m_id INT UNSIGNED NOT NULL PRIMARY KEY,
  credits FLOAT(3,2) NOT NULL,
  m_col ENUM('Claremont McKenna College','Harvey Mudd College','Scripps College') NOT NULL
);

CREATE TABLE Sequence (
  q_id INT UNSIGNED NOT NULL PRIMARY KEY,
  credits FLOAT(3,2) NOT NULL,
  q_col ENUM('Claremont McKenna College','Harvey Mudd College','Scripps College') NOT NULL
);

CREATE TABLE Courses (
  c_id INT UNSIGNED NOT NULL PRIMARY KEY,
  credits FLOAT(3,2) NOT NULL,
  c_col ENUM('Claremont McKenna College','Harvey Mudd College','Scripps College') NOT NULL
);

CREATE TABLE Completed (
  s_id INT UNSIGNED NOT NULL,
	FOREIGN KEY (s_id) REFERENCES Students (s_id),
  c_id INT UNSIGNED NOT NULL,
  FOREIGN KEY (c_id) REFERENCES Courses (c_id),
  pass BIT NULL DEFAULT 0
);
