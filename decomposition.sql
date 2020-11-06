DROP TABLE IF EXISTS accidents;
CREATE TABLE IF NOT EXISTS accidents (
	id VARCHAR(10) NOT NULL,
    src VARCHAR(15),
    tmc DECIMAL (5,2),
    severity TINYINT UNSIGNED,
    start_time DATETIME,
    end_time DATETIME,
    start_lat DECIMAL(15,10),
    start_lng DECIMAL(15,10),
    end_lat DECIMAL(15,10),
    end_lng DECIMAL(15,10),
    distance DECIMAL(20, 5),
    acc_description TEXT,
    street_num MEDIUMINT UNSIGNED,
    street VARCHAR(100),
    side VARCHAR(10) CHECK (side IN ('R', 'L', NULL)),
    city VARCHAR(50),
    county VARCHAR(50),
    state VARCHAR(2),
    zipcode MEDIUMINT UNSIGNED,
    country CHAR(5),
    timezone VARCHAR(50),
    airport_code VARCHAR(10),
    weather_timestamp DATETIME,
    PRIMARY KEY (id)
)ENGINE INNODB;

ALTER TABLE accidents ADD INDEX airport_code_idx(airport_code);
ALTER TABLE accidents ADD INDEX zipcode_idx(zipcode);

SET SESSION sql_mode = '';
INSERT INTO accidents
	SELECT id,
		NULLIF(src,''),
		NULLIF(tmc, ''),
		NULLIF(severity, ''),
		start_time,
		end_time,
		NULLIF(start_lat,''),
		NULLIF(start_lng,''),
		NULLIF(end_lat, ''),
		NULLIF(end_lng,''),
		NULLIF(distance,''),
		NULLIF(acc_description,''),
		NULLIF(street_num, ""),
		NULLIF(street,""),
		NULLIF(side,""),
		NULLIF(city,""),
		NULLIF(county,""),
		NULLIF(state,""),
		NULLIF(LEFT(zipcode,5),""),
		NULLIF(country,""),
		NULLIF(timezone,""),
		NULLIF(airport_code,""),
		NULLIF(weather_timestamp,"")
		FROM megatable;

DROP TABLE IF EXISTS weather_station;
CREATE TABLE IF NOT EXISTS weather_station (
	zipcode  MEDIUMINT UNSIGNED,
    airport_code VARCHAR(10),
    PRIMARY KEY (zipcode),
    FOREIGN KEY (zipcode)
		REFERENCES accidents(zipcode)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE INNODB;

INSERT INTO weather_station
	SELECT DISTINCT zipcode,
					airport_code
	FROM accidents
    WHERE zipcode IS NOT NULL;

DROP TABLE IF EXISTS weather_info;
CREATE TABLE IF NOT EXISTS weather_info (
	airport_code VARCHAR(10),
    weather_timestamp DATETIME,
    temperature DECIMAL (5,2),
    wind_chill DECIMAL (5,2),
    humidity DECIMAL(5,2),
    pressure DECIMAL(5,2),
    visibility DECIMAL(5,2),
    wind_direction VARCHAR(10),
    wind_speed DECIMAL(5,2),
    precipitation DECIMAL(5,2),
    weather_condition VARCHAR(40),
    FOREIGN KEY (airport_code)
		REFERENCES accidents(airport_code)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    PRIMARY KEY (airport_code, weather_timestamp)
) ENGINE INNODB;

INSERT INTO weather_info
	SELECT DISTINCT airport_code,
			weather_timestamp,
            CAST(NULLIF(temperature,'') AS DECIMAL (5,2)),
            CAST(NULLIF(wind_chill,'') AS DECIMAL (5,2)),
            CAST(NULLIF(humidity,'') AS DECIMAL (5,2)),
            CAST(NULLIF(pressure,'') AS DECIMAL (5,2)),
            CAST(NULLIF(visibility,'') AS DECIMAL (5,2)),
            NULLIF(wind_direction, ''),
            CAST(NULLIF(wind_speed,'') AS DECIMAL (5,2)),
            CAST(NULLIF(precipitation,'') AS DECIMAL (5,2)),
            NULLIF(weather_condition, '')
	FROM megatable
    WHERE airport_code IS NOT NULL AND NOT weather_timestamp = '';
