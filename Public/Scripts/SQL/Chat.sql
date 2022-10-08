-- Creating the Database
CREATE DATABASE Chat;
-- Creating the Passwords table
CREATE TABLE Chat.Passwords (
    PasswordsId INT PRIMARY KEY AUTO_INCREMENT,
    PasswordsSalt VARCHAR(8),
    PasswordsHash VARCHAR(256)
);
-- Creating the Users table
CREATE TABLE Chat.Users (
    UsersUsername VARCHAR(32) PRIMARY KEY,
    UsersMailAddress VARCHAR(64),
    UsersPassword INT,
    UsersProfilePicture VARCHAR(512),
    CONSTRAINT fkPasswordsUsers FOREIGN KEY (UsersPassword) REFERENCES Chat.Passwords (PasswordsId)
);
-- Creating the Logins table
CREATE TABLE Chat.Logins (
    LoginsId INT PRIMARY KEY AUTO_INCREMENT,
    LoginsUser VARCHAR(32),
    LoginsTimeIn VARCHAR(32),
    LoginsTimeOut VARCHAR(32),
    CONSTRAINT fkLoginsUsers FOREIGN KEY (LoginsUser) REFERENCES Chat.Users (UsersUsername)
);
-- Creating the Groups table
CREATE TABLE Chat.Groups (
    GroupsId INT PRIMARY KEY AUTO_INCREMENT,
    GroupsName VARCHAR(64)
);
-- Creating the Contacts table
CREATE TABLE Chat.Contacts (
    ContactsId INT PRIMARY KEY AUTO_INCREMENT,
    ContactsUser VARCHAR(32),
    ContactsFriend VARCHAR(32),
    CONSTRAINT fkContactsUserUsersUsername FOREIGN KEY (ContactsUser) REFERENCES Chat.Users (UsersUsername),
    CONSTRAINT fkContactsFriendsUsersUsername FOREIGN KEY (ContactsFriend) REFERENCES Chat.Users (UsersUsername)
);
-- Creating the Group Members table
CREATE TABLE Chat.GroupMembers (
    GroupMembersId INT PRIMARY KEY AUTO_INCREMENT,
    GroupMembersUser VARCHAR(32),
    GroupMembersGroup INT,
    CONSTRAINT fkGroupMembersUserUsersUsername FOREIGN KEY (GroupMembersUser) REFERENCES Chat.Users (UsersUsername),
    CONSTRAINT fkGroupMembersGroupGroupsId FOREIGN KEY (GroupMembersGroup) REFERENCES Chat.Groups (GroupsId)
);
-- Creating the Conversations table
CREATE TABLE Chat.Conversations (
    ConversationsId INT PRIMARY KEY AUTO_INCREMENT,
    ConversationsContact INT NULL,
    ConversationsGroupMember INT NULL,
    CONSTRAINT fkConversationsContactContactsId FOREIGN KEY (ConversationsContact) REFERENCES Chat.Contacts (ContactsId),
    CONSTRAINT fkConversationsGroupMemberGroupMembersId FOREIGN KEY (ConversationsGroupMember) REFERENCES Chat.GroupMembers (GroupMembersId)
);
-- Creating the Messages table
CREATE TABLE Chat.Messages (
    MessagesId INT PRIMARY KEY AUTO_INCREMENT,
    MessagesConversation INT,
    MessagesCipher VARCHAR(512),
    MessagesSender VARCHAR(32),
    MessagesTimestamp VARCHAR(32),
    CONSTRAINT fkMessagesConversationConversationsId FOREIGN KEY (MessagesConversation) REFERENCES Chat.Conversations (ConversationsId)
);