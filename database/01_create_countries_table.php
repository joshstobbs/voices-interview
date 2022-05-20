<?php

require __DIR__ . "/../lib/database.php";

$db = connectToDb();
$query = "
    CREATE TABLE IF NOT EXISTS countries (
        id INT NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        PRIMARY KEY (id)
    );
";

$statement = $db->prepare($query);
$statement->execute();
