<?php
try {
    $endpoint = explode('.', 'ep-plain-frog-a4v9qws1.aws-us-east-1.pg.laravel.cloud')[0];
    $password = 'endpoint=' . $endpoint . ';npg_IOFsTa6p5Rhn';
    $dsn = 'pgsql:host=ep-plain-frog-a4v9qws1.aws-us-east-1.pg.laravel.cloud;port=5432;dbname=postgres;sslmode=require';
    $pdo = new PDO($dsn, 'laravel', $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_TIMEOUT => 5]);
    $stmt = $pdo->query('SELECT datname FROM pg_database WHERE datistemplate = false;');
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['datname'] . "\n";
    }
} catch (PDOException $e) {
    echo "Connection to postgres db failed: " . $e->getMessage() . "\n";
    
    // Maybe try 'defaultdb' (common for some providers)
    try {
        $dsn = 'pgsql:host=ep-plain-frog-a4v9qws1.aws-us-east-1.pg.laravel.cloud;port=5432;dbname=defaultdb;sslmode=require';
        $pdo = new PDO($dsn, 'laravel', $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_TIMEOUT => 5]);
        $stmt = $pdo->query('SELECT datname FROM pg_database WHERE datistemplate = false;');
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo $row['datname'] . "\n";
        }
    } catch (PDOException $e) {
        echo "Connection to defaultdb failed: " . $e->getMessage() . "\n";
    }
}
