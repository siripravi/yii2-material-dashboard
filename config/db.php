<?php

return [
   /* 'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=YOUR_DATABASE_PORT;port=YOUR_DATABASE_PORT;dbname=YOUR_DATABASE_NAME',
    'username' => 'YOUR_DATABASE_USERNAME',
    'password' => 'YOUR_DATABASE_PASSWORD',
    'charset' => 'utf8',*/
    'class' => 'yii\db\Connection',
    //'dsn' => 'mysql:host=localhost;dbname=stampdb',
    'dsn' => 'sqlite:@app/config/invoicedb.db',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
