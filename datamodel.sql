-- Create LibraryFinder database

CREATE DATABASE LibraryFinder;
USE LibraryFinder;

-- Create table Users that has ID auto incremented, name, gender, email, password, date of birth, and timestamp of created and updated date
CREATE TABLE `Users` ( 
    `Id` INT NOT NULL AUTO_INCREMENT , 
    `Name` VARCHAR(255) NOT NULL , 
    `Gender` INT NOT NULL , 
    `Email` VARCHAR(255) NOT NULL , 
    `Password` VARCHAR(255) NOT NULL , 
    `DateOfBirth` DATE NOT NULL , 
    `Created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    `Updated` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    PRIMARY KEY (`Id`)
    );

-- Create table Library that has ID auto incremented, name, latitude, longitude, description, image file path, video file path,
-- rating, userID that references the users table, and timestamp of created and updated date
CREATE TABLE `Library` ( 
    `Id` INT NOT NULL AUTO_INCREMENT , 
    `Name` VARCHAR(255) NOT NULL , 
    `Latitude` FLOAT NOT NULL , 
    `Longitude` FLOAT NOT NULL , 
    `Description` VARCHAR(2048) DEFAULT NULL , 
    `ImageFilePath` VARCHAR(255) DEFAULT NULL , 
    `VideoFilePath` VARCHAR(255) DEFAULT NULL , 
    `Rating` INT DEFAULT NULL ,
    `UserId` INT NOT NULL,
    `Created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    `Updated` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    PRIMARY KEY (`Id`),
    FOREIGN KEY (`UserId`) REFERENCES Users(`Id`)
    );

-- Create table Reviews that has ID auto incremented, LibraryId that references an Id from the Library table, and a UserId that references an Id from the users table,
-- Reivews, Rating, and timestamp of created and updated date
CREATE TABLE `Reviews` ( 
    `Id` INT NOT NULL AUTO_INCREMENT , 
    `LibraryId` INT NOT NULL, 
    `UserId` INT NOT NULL, 
    `Review` VARCHAR(2048) DEFAULT NULL ,
    `Rating` INT NOT NULL ,
    PRIMARY KEY (`Id`),
    FOREIGN KEY (`LibraryId`) REFERENCES Library(`Id`) ,
    FOREIGN KEY (`UserId`) REFERENCES Users(`Id`)
    );
