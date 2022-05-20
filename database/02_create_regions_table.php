<?php

require __DIR__ . "/../lib/database.php";

$db = connectToDb();
$query = "
    CREATE TABLE IF NOT EXISTS regions (
        id INT NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        country_id INT NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (country_id) REFERENCES countries(id)
    );
";

$statement = $db->prepare($query);
$statement->execute();
