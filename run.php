<?php

use wanghanwanghan\someUtils\moudles\laravelDB\laravelDB;

include './vendor/autoload.php';

$conn = [
    'mrxd' => [
        'driver' => 'mysql',
        'host' => 'rm-2zey1cx47igvj426hjo.mysql.rds.aliyuncs.com',
        'port' => '3306',
        'database' => 'mrxd',// database name
        'username' => 'wanghan',
        'password' => 'wanghan123',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_general_ci',
        'strict' => false,
        'prefix' => '',
    ],
    'ent' => [
        'driver' => 'mysql',
        'host' => 'rm-2zey1cx47igvj426hjo.mysql.rds.aliyuncs.com',
        'port' => '3306',
        'database' => 'ent_db',// database name
        'username' => 'wanghan',
        'password' => 'wanghan123',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_general_ci',
        'strict' => false,
        'prefix' => '',
    ],
];

$DB = laravelDB::getInstance($conn);

$info = $DB->connection('ent')->table('invoice_1')->get()->toArray();

foreach ($info as $one) {
    $one = json_decode(json_encode($one), true);

    if ($one['fpdm'] === '011001700107' && $one['fphm'] === '29109331') {
        $str = '01100170010729109331';
        $j = 0;
        for ($i = 0; $i < strlen($str); $i++) {
            is_numeric($str[$i]) ? $j += $str[$i] : $j += ord($str[$i]);
        }
        $suffix = $j % 10;

        var_dump($suffix);

    }


}






