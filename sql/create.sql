drop table if exists API_KEY;
CREATE TABLE API_KEY
(
    KEY_VALUE                       VARCHAR(32),
	NAME							VARCHAR(128),
    CREATE_DATE               		DATETIME,
	REQUESTS						INTEGER UNSIGNED DEFAULT 0
);

drop table if exists COMPLAINT;
CREATE TABLE COMPLAINT
(
	ID								INTEGER UNSIGNED PRIMARY KEY,
	CREATE_DATE						DATETIME,
	CLOSED_DATE						DATETIME,
	AGENCY							VARCHAR(32),
	TYPE							VARCHAR(128),
	DESCRIPTION						VARCHAR(256),	
	CITY							VARCHAR(256),		
	DUE_DATE						DATETIME,	
	LAT								FLOAT,	
	LNG								FLOAT
);
