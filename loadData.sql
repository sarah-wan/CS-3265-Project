#Sarah Wan, Erin Hardnett
#sarah.wan@vanderbilt.edu
#Project 2

DROP DATABASE IF EXISTS accidentdb;
 
 #create database
 CREATE DATABASE IF NOT EXISTS accidentdb;
 USE accidentdb;
 
 CREATE TABLE IF NOT EXISTS megatable (
	id VARCHAR(10),
    src VARCHAR(15),
    tmc VARCHAR(15),
    severity TINYINT UNSIGNED,
    start_time DATETIME,
    end_time DATETIME,
    start_lat VARCHAR(15),
    start_lng VARCHAR(15),
    end_lat VARCHAR(15),
    end_lng VARCHAR(15),
    distance DECIMAL(20, 10),
    acc_description TEXT,
    street_num VARCHAR(10),
    street VARCHAR(100),
    side VARCHAR(10),
    city VARCHAR(50),
    county VARCHAR(50),
    state VARCHAR(20),
    zipcode VARCHAR(10),
    country CHAR(2),
    timezone VARCHAR(50),
    airport_code VARCHAR(10),
    weather_timestamp VARCHAR(50),
    temperature VARCHAR(10),
    wind_chill VARCHAR(5),
    humidity VARCHAR(5),
    pressure VARCHAR(5),
    visibility VARCHAR(5),
    wind_direction VARCHAR(10),
    wind_speed VARCHAR(5),
    precipitation VARCHAR(10),
    weather_condition VARCHAR(40),
    amenity VARCHAR(10),
    bump VARCHAR(5),
    crossing VARCHAR(5),
    give_way VARCHAR(5),
    junction VARCHAR(5),
    no_exit VARCHAR(5),
    railway VARCHAR(5),
    roundabout VARCHAR(5),
    station VARCHAR(5),
    stop_signal VARCHAR(5),
    traffic_calming VARCHAR(5),
    traffic_signal VARCHAR(5),
    turning_loop VARCHAR(5),
    sunrise_sunset VARCHAR(5),
    civil_twilight VARCHAR(5),
    nautical_twilight VARCHAR(5),
    astronomial_twilight VARCHAR(5)
 ) ENGINE INNODB;
 
 #import data from csv file
LOAD DATA INFILE 'c:/wamp64/tmp/US_Accidents_June20.csv' 
INTO TABLE megatable
FIELDS TERMINATED BY ',' 
LINES TERMINATED BY '\n'
IGNORE 1 LINES;