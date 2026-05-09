CREATE DATABASE IF NOT EXISTS `CyberSecurityWebsite`;
USE `CyberSecurityWebsite`;


Create TABLE IF NOT EXISTS `Users` (
	`UserID` INT PRIMARY KEY AUTO_INCREMENT,
	`Username` VARCHAR(50) NOT NULL  UNIQUE,
	`Email` VARCHAR(100) NOT NULL UNIQUE,
	`PASSWORD` VARCHAR(255) NOT NULL,
	`DateCreated` DATETIME
);
CREATE TABLE IF NOT EXISTS `Quiz` (
	`QuizID` INT PRIMARY KEY AUTO_INCREMENT,
	`QuizTitle` VARCHAR(100) NOT NULL,
	`Description` VARCHAR(255)
);
CREATE TABLE IF NOT EXISTS `Questions` ( 
    `QuestionID` INT PRIMARY KEY AUTO_INCREMENT,
    `QuizID` INT NOT NULL,
    `QuestionText` VARCHAR(500) NOT NULL,
    `DifficultyLevel` VARCHAR(20),

    FOREIGN KEY (`QuizID`)
        REFERENCES `Quiz`(`QuizID`)
        ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS `Answers` (
    `AnswerID` INT PRIMARY KEY AUTO_INCREMENT,
    `QuestionID` INT NOT NULL,
    `AnswerText` VARCHAR(255) NOT NULL,
    `IsCorrect` BIT DEFAULT 0,

    FOREIGN KEY (`QuestionID`)
        REFERENCES `Questions`(`QuestionID`)
        ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS `UserResponses` (
    `ResponseID` INT PRIMARY KEY AUTO_INCREMENT,
    `UserID` INT NOT NULL,
    `QuestionID` INT NOT NULL,
    `SelectedAnswerID` INT NOT NULL,
    `TimeAnswered` DATETIME,

    FOREIGN KEY (`UserID`)
        references `Users`(`UserID`)
        ON DELETE CASCADE,
        
    FOREIGN KEY (`QuestionID`)
        REFERENCES `Questions`(`QuestionID`),

    FOREIGN KEY (`SelectedAnswerID`)
        REFERENCES `Answers`(`AnswerID`)
);
CREATE TABLE IF NOT EXISTS `Results` (
	`ResultID` INT PRIMARY KEY AUTO_INCREMENT,
	`UserID` INT NOT NULL,
	`QuizID` INT NOT NULL,
	`Score` INT NOT NULL,
	`TotalQuestions` INT NOT NULL,
	`TimeCompleted` DATETIME,


	FOREIGN KEY (`UserID`)
		REFERENCES `Users`(`UserID`)
		ON DELETE CASCADE,

	FOREIGN KEY (`QuizID`)
		REFERENCES `Quiz`(`QuizID`)
);


INSERT INTO Quiz (QuizTitle,Description)
VALUES 
('Passwords','These questions will be about password security and what can be done to make stronger passwords'),
('Network','These questions are about networks and cyber security'),
('phishing','These questions will be about phishing attacks');

INSERT INTO Questions(QuizID, QuestionText, DifficultyLevel)
VALUES
(1,'what password Is the strongest?','Medium'),
(1,'what does MFA stand for?','Easy'),
(2,'what does VPN stand for','Medium'),
(2,'what device filters network traffic?','Medium'),
(3,'What is phising?','Easy'),
(3,'what are the main signs for a phising email','Easy');

INSERT INTO Answers(QuestionID, AnswerText, IsCorrect)
VALUES
(1,'12345678',0),
(1,'password',0),
(1,'QS!9DSA@KP',1),
(1,'abcdef',0);

INSERT INTO Answers(QuestionID, AnswerText, IsCorrect)
VALUES
(2,'Multi-Factor Authentication',1),
(2,'Main Firewall Access',0),
(2,'Microsoft File Asministrator',0),
(2,'Multiple Form Access',0);

INSERT INTO Answers(QuestionID, AnswerText, IsCorrect)
VALUES
(3,'Virtual Private Network',1),
(3,'Virtual Protected Node',0),
(3,'Verifited Public Network',0),
(3,'Variable Protection Network',0);

INSERT INTO Answers(QuestionID, AnswerText, IsCorrect)
VALUES
(4,'Printer',0),
(4,'Monitor',0),
(4,'Keyboard',0),
(4,'FireWall',1);

INSERT INTO Answers(QuestionID, AnswerText, IsCorrect)
VALUES
(5,'A Computer Monitor',0),
(5,'A fake attempt to steal information online',1),
(5,'an anti virus update',0),
(5,'a secure website',0);

INSERT INTO Answers(QuestionID, AnswerText, IsCorrect)
VALUES
(6,'Normal software updates',0),
(6,'Emails from teachers',0),
(6,'A fake attempt to steal information online',1),
(6,'Secure HTTPS sites',0);
