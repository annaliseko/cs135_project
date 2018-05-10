# cs135_project
## Sequence Tracker
Final Project for CS135 Spring 2018
This project allows students at the Claremont Colleges to see what sequences they are close to finishing using mySQL, PHP, HTML, CSS and Javascript.  

### File Director/Structure
The sequence.sql file contains the tables of the database: courses, completed, student, major, sequence. 

The myprogress.php contains the progress page which details how much progress the student has made towards the major. This is the page that displays the results of querying the database to determine recommended sequences based off of what the student is studying and has taken so far.

The welcome.php page contains the front end and server side validation for the user's information, including name, college, major, sequence, graduation year, student id, email, password. It also includes the login portion which allows users to log in and out of the platform.

The queries.php page establishes the connection to the database that allows the student's information to be entered into the database and the connection between the webpage and the database to occur which then allows the queries to be executed.

The logout.php page destroys the session variables, safely ending the user's time logged into the page.

The dbconn.php file connects to the sequence.sql database.

The major.php lists the required courses remaining for the student, displaying the results of the queries to the database. 

### Instructions
Test features as new user
1. Go to welcome.php
2. Register as a new user
3. Add courses as you complete them
4. See changes be reflected on My Progress and Major page
5. Logout

Test features as an existing user
1. Go to welcome.php
2. Log in using valid credentials
3. Add courses as you complete them
4. See changes be reflected on My Progress and Major page
5. Logout

Test features as our test student
1. Import our sequence.sql table
2. Go to welcome.php
3. Log in with Student ID: 00000000 and Password: password1
4. Add courses as you complete them
5. See changes be reflected on My Progress and Major page
6. Logout
