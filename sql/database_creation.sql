CREATE TABLE admins(
	id INT NOT NULL AUTO_INCREMENT,

	login VARCHAR( 200 ) NOT NULL,
	password VARCHAR( 200 ) NOT NULL,

	PRIMARY KEY pk_admins( id )

);

CREATE TABLE countries (
	id INT NOT NULL AUTO_INCREMENT,
    
    country_name VARCHAR( 100 ) NOT NULL,
    
    PRIMARY KEY pk_countries( id )
);

CREATE TABLE locations (
	id INT NOT NULL AUTO_INCREMENT,
    
    name VARCHAR( 100 ) NOT NULL,
    
    PRIMARY KEY pk_locations( id )
);

CREATE TABLE organizations (
	id INT NOT NULL AUTO_INCREMENT,
    
    name VARCHAR( 100 ) NOT NULL,
    
    PRIMARY KEY pk_organizations( id )
);

CREATE TABLE associations (
	id INT NOT NULL AUTO_INCREMENT,
    
    name VARCHAR( 100 ) NOT NULL,
    
    PRIMARY KEY pk_association( id )
);

CREATE TABLE result_types (
	id INT NOT NULL AUTO_INCREMENT,
    
    description VARCHAR( 200 ) NOT NULL,
    
    PRIMARY KEY pk_result_type( id )
);

CREATE TABLE weightclasses (
	id INT NOT NULL AUTO_INCREMENT,
    
    lower_limit DECIMAL( 5, 2 ),
    upper_limit DECIMAL( 5, 2 ),
    name VARCHAR( 100 ),
    organization_id	INT NOT NULL,
    
    PRIMARY KEY pk_weightclasses( id ),
    
    FOREIGN KEY fk_weightclasses_organizations ( organization_id ) REFERENCES organizations ( id )
    ON DELETE CASCADE
);

CREATE TABLE fighters (
    	id INT NOT NULL AUTO_INCREMENT,
    
    first_name VARCHAR( 100 ) NOT NULL,
    last_name VARCHAR( 100 ) NOT NULL,
    nickname VARCHAR( 100 ) NOT NULL,
    
    birthdate DATE,
    height DECIMAL( 5, 2 ),
    weight DECIMAL( 5, 2 ),
    
    country_id INT,
    organization_id INT,
    association_id INT,
    
    PRIMARY KEY pk_fighters( id ),
    
    FOREIGN KEY fk_fighters_countries ( country_id ) REFERENCES countries ( id )
    ON DELETE CASCADE,
    
    FOREIGN KEY fk_fighters_organizations ( organization_id ) REFERENCES organizations ( id )
    ON DELETE CASCADE,
    
    FOREIGN KEY fk_fighters_associations ( association_id ) REFERENCES associations ( id )
    ON DELETE CASCADE
);

CREATE TABLE events (
    	id INT NOT NULL AUTO_INCREMENT,

    name VARCHAR( 200 ) NOT NULL,
    date DATE NOT NULL,
   
    location_id INT NOT NULL,
    organization_id INT NOT NULL,

    PRIMARY KEY pk_events( id ),
    
    FOREIGN KEY fk_events_locations ( location_id ) REFERENCES locations ( id )
    ON DELETE CASCADE,
   
    FOREIGN KEY fk_events_organizations ( organization_id ) REFERENCES organizations ( id )
    ON DELETE CASCADE
);

CREATE TABLE fights (
    	id INT NOT NULL AUTO_INCREMENT, 

    fighter_id INT NOT NULL,
    opponent_id INT NOT NULL,
    
    weightclass_id INT NOT NULL,
    event_id INT NOT NULL,
    
    result_type_id INT,
    
    winner_id INT,
    
    end_round INT,
    end_time TIME,

    PRIMARY KEY pk_fights ( id ),
    
    FOREIGN KEY fk_fights_fighter ( fighter_id ) REFERENCES fighters ( id )
    ON DELETE CASCADE,
   
    FOREIGN KEY fk_fights_opponent ( opponent_id ) REFERENCES fighters ( id )
    ON DELETE CASCADE,
    	
    FOREIGN KEY fk_fights_winner ( winner_id ) REFERENCES fighters ( id )
    ON DELETE CASCADE,
    
    FOREIGN KEY fk_fights_weightclasses ( weightclass_id ) REFERENCES weightclasses ( id )
    ON DELETE CASCADE,
   
    FOREIGN KEY fk_fights_events ( event_id ) REFERENCES events ( id )
    ON DELETE CASCADE,
    
    FOREIGN KEY fk_fights_results ( result_type_id ) REFERENCES result_types (id )
    ON DELETE CASCADE
);