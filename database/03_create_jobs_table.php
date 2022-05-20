<?php

require __DIR__ . "/../lib/database.php";

$db = connectToDb();
$query = "
    CREATE TABLE IF NOT EXISTS jobs (
        id INT NOT NULL AUTO_INCREMENT,
        job_title varchar(255) NOT NULL,
        job_additional_info TEXT,
        country_id INT NOT NULL,
        region_id INT NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (country_id) REFERENCES countries(id),
        FOREIGN KEY (region_id) REFERENCES regions(id)
    );
";

$statement = $db->prepare($query);
$statement->execute();
