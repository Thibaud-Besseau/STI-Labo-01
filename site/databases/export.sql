BEGIN TRANSACTION;
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
	`Id`	INTEGER PRIMARY KEY AUTOINCREMENT UNIQUE,
	`First_Name`	TEXT NOT NULL,
	`Last_Name`	TEXT NOT NULL,
	`Email`	TEXT NOT NULL UNIQUE,
	`Password`	TEXT NOT NULL,
	`Enable`	INTEGER NOT NULL,
	`Role`	INTEGER NOT NULL
);
INSERT INTO `user` (Id,First_Name,Last_Name,Email,Password,Enable,Role) VALUES (1,'Thibaud','Besseau','thibaud.besseau@heig-vd.ch','HelloWorld',1,0);
INSERT INTO `user` (Id,First_Name,Last_Name,Email,Password,Enable,Role) VALUES (2,'Admin','STI','admin@sti.ch','Admin',1,1);
DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
	`Id`	INTEGER PRIMARY KEY AUTOINCREMENT UNIQUE,
	`Sender`	INTEGER NOT NULL,
	`Recipient`	INTEGER NOT NULL,
	`Subject`	TEXT,
	`Message`	TEXT,
	`Date`	INTEGER NOT NULL,
	 FOREIGN KEY (`Sender`) REFERENCES User(`Id`),
	 FOREIGN KEY (`Recipient`) REFERENCES User(`Id`)


);
INSERT INTO `message` (Id,Sender,Recipient
,Subject,Message,Date) VALUES (1,0,1,'FeedBack','Hi, I love your App. Thanks',1540315951700);
INSERT INTO `message` (Id,Sender,Recipient
,Subject,Message,Date) VALUES (2,1,0,'You are Welcome',NULL,1540315951720);
COMMIT;
