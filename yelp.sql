drop table Business;
create table Business (
    Business_ID     VARCHAR(25) NOT NULL,
    Name            VARCHAR(20) NOT NULL,
    Address         VARCHAR(100),
    City            VARCHAR(15),
    State           VARCHAR(5),
    Latitude        DOUBLE,
    Longitude       DOUBLE,
    Stars           DOUBLE,
    PRIMARY KEY     (Business_ID)
);

drop table Business_Attributes;
create table Business_Attributes(
    Business_ID     VARCHAR(25) NOT NULL,
    Attribute       VARCHAR(50),
    Value           VARCHAR(10),
    PRIMARY KEY     (Business_ID, Attribute),
    FOREIGN KEY     (Business_ID)
        REFERENCES Business (Business_ID)
        ON DELETE CASCADE
);

drop table Business_Categories;
create table Business_Categories(
    Business_ID     VARCHAR(25) NOT NULL,
    Category        VARCHAR(100),
    PRIMARY KEY     (Business_ID, Category),
    FOREIGN KEY     (Business_ID)
        REFERENCES Business (Business_ID)
        ON DELETE CASCADE
);

drop table User;
create table User(
    User_ID         VARCHAR(25) NOT NULL,
    Name            VARCHAR(15) NOT NULL,
    Review_Count    INTEGER,
    Average_Stars   DOUBLE,
    Yelping_Since   DATE NOT NULL,
    Fans            INTEGER,
    PRIMARY KEY (User_ID)
);

drop table Business_Review;
create table Business_Review(
    Business_ID     VARCHAR(25) NOT NULL,
    User_ID         VARCHAR(25) NOT NULL,
    Stars           DOUBLE,
    Text            TEXT,
    Date            DATE,
    PRIMARY KEY     (Business_ID, User_ID),
    FOREIGN KEY     (User_ID)
        REFERENCES User (User_ID)
        ON DELETE CASCADE
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
    PRIMARY KEY     (Business_ID),
    FOREIGN KEY     (Business_ID)
        REFERENCES Business (Business_ID)
        ON DELETE CASCADE
);