-- Creating the Database
CREATE DATABASE Chat;
-- Creating the Users table
CREATE TABLE Chat.Users (
    UsersUsername VARCHAR(32) PRIMARY KEY,
    UsersMailAddress VARCHAR(64),
    UsersPassword VARCHAR(256)
);
-- Test codes
SELECT * FROM Chat.Users;