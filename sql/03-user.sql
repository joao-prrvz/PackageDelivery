CREATE USER 'package-user'@'%' IDENTIFIED BY "Super";
GRANT ALL PRIVILEGES ON *.* TO 'package-user'@'%' WITH GRANT OPTION;