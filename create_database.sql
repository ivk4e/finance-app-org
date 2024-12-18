CREATE DATABASE finance_app;
CREATE USER 'finance_user'@'localhost' IDENTIFIED BY 'secure_password';
GRANT ALL PRIVILEGES ON finance_app.* TO 'finance_user'@'localhost';
FLUSH PRIVILEGES;
