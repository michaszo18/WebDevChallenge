<?php


$db = new SQLite3('test.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);

$db->query('CREATE TABLE IF NOT EXISTS "visits"(
    "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    "user_id" INTEGER,
    "url" VARCHAR,
    "time" DATATIME
    )');

$db->exec('BEGIN');
$db->query('INSERT INTO "visits" ("user_id", "url", "time")
            VALUES (42, "/test", "2017-01-14 10:11:23")');
$db->query('INSERT INTO "visits" ("user_id", "url", "time")
            VALUES (42, "/test2", "2017-01-14 10:11:45")');
$db->exec('COMMIT');

