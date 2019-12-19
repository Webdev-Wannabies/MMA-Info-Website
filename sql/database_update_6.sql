CREATE TABLE news( 
	id INT NOT NULL AUTO_INCREMENT, 

	admin_id INT NOT NULL, 

	title VARCHAR( 255 ) NOT NULL, 
	body VARCHAR( 8192 ) NOT NULL, 

	creation_date DATETIME NOT NULL, 

	PRIMARY KEY pk_news( id ), 
	FOREIGN KEY fk_news_admins ( admin_id ) REFERENCES admins ( id ) 
);