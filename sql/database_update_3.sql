CREATE TABLE sessions (
	id INT NOT NULL AUTO_INCREMENT,
	
	admin_id INT NOT NULL,
	
	session_start  DATETIME,
	session_end DATETIME,
	
	PRIMARY KEY sessions_pk( id ),
	
	FOREIGN KEY fk_sessions_admins ( admin_id ) REFERENCES admins( id )
		ON DELETE CASCADE
	

);