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

ALTER TABLE accidents ADD INDEX airport_code(airport_code);
ALTER TABLE accidents ADD INDEX start_position(start_lat, start_lng);
ALTER TABLE accidents ADD INDEX city(city, state, start_time);

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

DROP TABLE IF EXISTS area_description;
CREATE TABLE IF NOT EXISTS area_description (
	start_lat DECIMAL(15,10),
    start_lng DECIMAL(15,10),
    amenity VARCHAR(5) CHECK (amenity IN ('False', 'True', NULL)),
    bump VARCHAR(5) CHECK (bump IN ('False', 'True', NULL)),
    crossing VARCHAR(5) CHECK (crossing IN ('False', 'True', NULL)),
    give_way VARCHAR(5) CHECK (give_way IN ('False', 'True', NULL)),
    junction VARCHAR(5) CHECK (junction IN ('False', 'True', NULL)),
    no_exit VARCHAR(5) CHECK (no_exit IN ('False', 'True', NULL)),
    railway VARCHAR(5) CHECK (railway IN ('False', 'True', NULL)),
    roundabout VARCHAR(5) CHECK (roundabout IN ('False', 'True', NULL)),
    station VARCHAR(5) CHECK (station IN ('False', 'True', NULL)),
    stop_signal VARCHAR(5) CHECK (stop_signal IN ('False', 'True', NULL)),
    traffic_calming VARCHAR(5) CHECK (traffic_calming IN ('False', 'True', NULL)),
    traffic_signal VARCHAR(5) CHECK (traffic_signal IN ('False', 'True', NULL)),
    turning_loop VARCHAR(5) CHECK (turning_loop IN ('False', 'True', NULL)),
    PRIMARY KEY (start_lat, start_lng),
    CONSTRAINT position
		FOREIGN KEY (start_lat, start_lng)
		REFERENCES accidents(start_lat, start_lng)
        ON DELETE CASCADE
        ON UPDATE CASCADE
)ENGINE INNODB;

INSERT INTO area_description
	SELECT DISTINCT start_lat,
			start_lng,
            NULLIF(amenity,''),
            NULLIF(bump,''),
            NULLIF(crossing,''),
            NULLIF(give_way,''),
            NULLIF(junction,''),
            NULLIF(no_exit,''),
            NULLIF(railway,''),
            NULLIF(roundabout,''),
            NULLIF(station,''),
            NULLIF(stop_signal,''),
            NULLIF(traffic_calming,''),
            NULLIF(traffic_signal,''),
            NULLIF(turning_loop,'')
	FROM megatable
    WHERE NOT start_lat = '' AND NOT start_lng = '';

DROP TABLE IF EXISTS time_of_day;
CREATE TABLE IF NOT EXISTS time_of_day (
	city VARCHAR(50),
    state VARCHAR(2),
    start_time DATETIME,
    sunrise_sunset VARCHAR(6) CHECK (side IN ('False', 'True', NULL)),
    civil_twilight VARCHAR(6) CHECK (side IN ('False', 'True', NULL)),
    nautical_twilight VARCHAR(6) CHECK (side IN ('False', 'True', NULL)),
    astronomial_twilight VARCHAR(6) CHECK (side IN ('False', 'True', NULL)),
    PRIMARY KEY (city, state, start_time)
)ENGINE INNODB;

INSERT INTO time_of_day
	SELECT DISTINCT city,
			state,
            start_time,
            NULLIF(sunrise_sunset,''),
            NULLIF(civil_twilight,''),
            NULLIF(nautical_twilight,''),
            NULLIF(astronomial_twilight,'')
	FROM megatable
    WHERE NOT city = '' AND NOT state = '' AND start_time IS NOT NULL;


DROP VIEW IF EXISTS accident_weather;
CREATE VIEW accident_weather AS
	SELECT id,
			src,
            tmc,
			severity,
            start_time,
            end_time,
            start_lat,
            start_lng,
            end_lat,
            end_lng,
            distance,
            acc_description,
            street_num,
            street,
            city,
            county,
            state,
            zipcode,
            accidents.airport_code,
            accidents.weather_timestamp,
            temperature,
            wind_chill,
            humidity,
            pressure,
            visibility,
            wind_direction,
			wind_speed,
            precipitation,
            weather_condition
    FROM accidents 
		JOIN weather_info 
        ON accidents.airport_code = weather_info.airport_code AND
        accidents.weather_timestamp = weather_info.weather_timestamp;

DROP VIEW IF EXISTS accident_area;
CREATE VIEW accident_area AS
	SELECT  id,
			src,
            tmc,
			severity,
            start_time,
            end_time,
            accidents.start_lat,
            accidents.start_lng,
            end_lat,
            end_lng,
            distance,
            acc_description,
            street_num,
            street,
            city,
            county,
            state,
            zipcode,
            amenity,
            bump,
            crossing,
            give_way,
            junction,
            no_exit,
            roundabout,
            stop_signal,
            traffic_calming,
            traffic_signal,
            turning_loop
    FROM accidents 
		JOIN area_description 
        ON accidents.start_lat = area_description.start_lat AND
        accidents.start_lng = area_description.start_lng;
        
