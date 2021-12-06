CREATE DATABASE LibraryFinder;
USE LibraryFinder;

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


CREATE TABLE `Library` ( 
    `Id` INT NOT NULL AUTO_INCREMENT , 
    `Name` VARCHAR(255) NOT NULL , 
    `Latitude` FLOAT NOT NULL , 
    `Longitude` FLOAT NOT NULL , 
    `Description` VARCHAR(2048) DEFAULT NULL , 
    `ImageFilePath` VARCHAR(255) DEFAULT NULL , 
    `VideoFilePath` VARCHAR(255) DEFAULT NULL , 
    `Created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    `Updated` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    `UserId` INT,
    PRIMARY KEY (`Id`),
    FOREIGN KEY (`UserId`) REFERENCES Users(`Id`)
    );

CREATE TABLE `Reviews` ( 
    `Id` INT NOT NULL AUTO_INCREMENT , 
    `LibraryId` INT , 
    `UserId` INT , 
    `Review` VARCHAR(2048) DEFAULT NULL ,
    `Rating` INT NOT NULL ,
    PRIMARY KEY (`Id`),
    FOREIGN KEY (`LibraryId`) REFERENCES Library(`Id`) ,
    FOREIGN KEY (`UserId`) REFERENCES Users(`Id`)
    );
