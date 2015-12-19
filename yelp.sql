drop table Business;
create table Business (
    Business_ID     VARCHAR(25) NOT NULL,
    Address         VARCHAR(255),
    City            VARCHAR(50),
    State           VARCHAR(50),
    Latitude        DOUBLE,
    Longitude       DOUBLE,
    PRIMARY KEY (Business_ID)
);

drop table Business_Attributes;
create table Business_Attributes(
    Business_ID     VARCHAR(25) NOT NULL,
    Attribute       VARCHAR(50),
    PRIMARY KEY     (Business_ID)
);

drop table Business_Categories;
create table Business_Categories(
    Business_ID     VARCHAR(25) NOT NULL,
    Category        VARCHAR(100),
    PRIMARY KEY     (Business_ID)
);

drop table User;
create table User(
    User_ID         VARCHAR(25) NOT NULL,
    First_Name      VARCHAR(15) NOT NULL,
    Review_Count    INTEGER,
    Average_Stars   FLOAT,
    Yelping_Since   DATE NOT NULL,
    Fans            INTEGER,
    PRIMARY KEY (User_ID)
);

drop table Business_Review;
create table Business_Review(
    Business_ID     VARCHAR(25) NOT NULL,
    User_ID         VARCHAR(25) NOT NULL,
    Stars           FLOAT,
    Text            TEXT,
    Date            DATE,
    PRIMARY KEY     (Business_ID),
    FOREIGN KEY     (User_ID) REFERENCES User (User_ID)
);

drop table Check_In;
create table Check_In(
    Business_ID     VARCHAR(25) NOT NULL,
    Monday          INTEGER,
    Tuesday         INTEGER,
    Wednesday       INTEGER,
    Thursday        INTEGER,
    Friday          INTEGER,
    Saturday        INTEGER,
    Sunday          INTEGER,
    PRIMARY KEY     (Business_ID)
);