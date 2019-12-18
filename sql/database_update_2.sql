ALTER TABLE locations ADD COLUMN country_id INT;
ALTER TABLE locations ADD CONSTRAINT fk_locations_countries FOREIGN KEY (country_id) REFERENCES countries( id ) ON DELETE CASCADE;