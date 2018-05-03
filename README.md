# Twitter
Twitter application

This is project of simple twitter similar application.
 
To run this application you need configured local environment with:

    PHP
    Apache/Nginx
    MySQL

Steps :

1) Clone or download this project.

2) Create Database: twitter.

3) Import all tables to your database ( the directory of file :yourpath/twitter/src/backup.sql ).

4) Check if you have all tables in your database (there should be 4 tables: Comments, Messages, Tweets, Users ).

5) Change following properties according to your MySQL data in file "Database.php" (path: Twitter/src/Database.php):
 $username = 'root', 
 $password = 'yourPassword', 
 $host = 'localhost', 
 $database = 'Twitter'

6) You can test this application by log in to test account by using:
 email: test@gmail.com 
 password: test

7) Test all functionality : create account, make tweets, send massages to other users, check tweet, check your messages, comment tweet, change your username, password, email and delete your account.


Authors
Paulina
