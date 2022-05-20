<?php

function connectToDb() {
    try {
        return new PDO("mysql:dbname=voices_test;host=127.0.0.1;port=3306;charset=utf8", "ploi", "IcTTw0RbrznZUXCTCSII");
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}
