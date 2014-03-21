 
 CREATE DATABASE moojicwebapp;
  
 use  moojicwebapp;
  
 CREATE TABLE response(
     p_id INT NOT NULL AUTO_INCREMENT, 
     consumerID varchar(255) NOT NULL,
     response varchar(255) NOT NULL,
     UNIQUE(consumerID),
     PRIMARY KEY (p_id)
    )ENGINE=InnoDB DEFAULT CHARSET=latin1;
 
 CREATE TABLE restaurant (
  restaurant_name varchar(200) NOT NULL,
  address varchar(255) NOT NULL,
  contact BIGINT(20) NOT NULL,
  UNIQUE(restaurant_name,contact)
  )ENGINE=InnoDB DEFAULT CHARSET=latin1;
  
 CREATE TABLE userdata(
    pid INT NOT NULL AUTO_INCREMENT,	
    userid varchar(255) NOT NULL,
    accesstoken varchar(255) NOT NULL,
    exptime BIGINT(20) NOT NULL,
    UNIQUE(userid,accesstoken),
    PRIMARY KEY (pid)
  )ENGINE=InnoDB DEFAULT CHARSET=latin1;
