<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/db/config.php';

$faker = Faker\Factory::create();

for ($i=0; $i < 100; $i++) {
    $title = $faker->sentence($nbWords = 10, $variableNbWords = true);
    $content = $faker->text($maxNbChars = 200);
    $date = $faker->dateTime($max = 'now', $timezone = 'Asia/Jakarta');
    $var_sql_insert = "
    INSERT INTO article(article_title, article_content, article_date) VALUES('{$title}', '{$content}', '{$date->format('Y-m-d H:i:s')}')
    ";
    $var_query_insert = mysqli_query($var_con, $var_sql_insert);
    $title = $faker->sentence($nbWords = 3, $variableNbWords = true);
    $var_sql_insert = "
    INSERT INTO category(category_name) VALUES('{$title}')
    ";
    $var_query_insert = mysqli_query($var_con, $var_sql_insert);
}
