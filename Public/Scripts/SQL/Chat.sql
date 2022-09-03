-- Creating the Database
CREATE DATABASE Chat;
-- Creating the Users table
CREATE TABLE Chat.Users (
    UsersUsername VARCHAR(32) PRIMARY KEY,
    UsersMailAddress VARCHAR(64),
    UsersPassword VARCHAR(256),
    UsersProfilePicture VARCHAR(512)
);
-- Creating the Logins table
CREATE TABLE Chat.Logins (
    LoginsId INT PRIMARY KEY AUTO_INCREMENT,
    LoginsUser VARCHAR(32),
    LoginsTimeIn VARCHAR(32),
    LoginsTimeOut VARCHAR(32),
    CONSTRAINT fkLoginsUsers FOREIGN KEY (LoginsUser) REFERENCES Chat.Users (UsersUsername)
);
-- Creating the Contacts table
CREATE TABLE Chat.Contacts (
    ContactsId INT PRIMARY KEY AUTO_INCREMENT,
    ContactsUser VARCHAR(32),
    ContactsFriend VARCHAR(32),
    CONSTRAINT fkContactsUserUsersUsername FOREIGN KEY (ContactsUser) REFERENCES Chat.Users (UsersUsername),
    CONSTRAINT fkContactsFriendsUsersUsername FOREIGN KEY (ContactsFriend) REFERENCES Chat.Users (UsersUsername)
);