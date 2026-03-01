<?php
echo "<h2>TEST MINIMAL LARAVEL</h2>";

echo "<h3>Étape 1: Test autoload</h3>";
try {
    require_once '../app-files/vendor/autoload.php';
    echo "✅ Autoload chargé avec succès<br>";
} catch(Exception $e) {
    echo "❌ Erreur autoload: " . $e->getMessage() . "<br>";
    exit;
}

echo "<h3>Étape 2: Test bootstrap</h3>";
try {
    $app = require_once '../app-files/bootstrap/app.php';
    echo "✅ Bootstrap chargé avec succès<br>";
    echo "Type d'app: " . get_class($app) . "<br>";
} catch(Exception $e) {
    echo "❌ Erreur bootstrap: " . $e->getMessage() . "<br>";
    echo "Trace: " . $e->getTraceAsString() . "<br>";
    exit;
}

echo "<h3>Étape 3: Test fichier .env</h3>";
$envPath = '../app-files/.env';
if(file_exists($envPath)) {
    echo "✅ Fichier .env existe<br>";
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    echo "Nombre de lignes: " . count($lines) . "<br>";
    
    // Vérification des variables critiques
    $envContent = file_get_contents($envPath);
    $criticalVars = ['APP_KEY', 'DB_CONNECTION', 'DB_HOST', 'DB_DATABASE'];
    foreach($criticalVars as $var) {
        if(strpos($envContent, $var) !== false) {
            echo "✅ $var trouvé<br>";
        } else {
            echo "❌ $var manquant<br>";
        }
    }
} else {
    echo "❌ Fichier .env non trouvé<br>";
}

echo "<h3>Étape 4: Test base de données</h3>";
try {
    // Lecture des variables d'environnement depuis .env
    $envVars = [];
    if(file_exists('../app-files/.env')) {
        $lines = file('../app-files/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach($lines as $line) {
            if(strpos($line, '=') !== false && !str_starts_with($line, '#')) {
                list($key, $value) = explode('=', $line, 2);
                $envVars[trim($key)] = trim($value);
            }
        }
    }
    
    if(isset($envVars['DB_HOST']) && isset($envVars['DB_DATABASE'])) {
        echo "Variables DB trouvées dans .env<br>";
        echo "DB_HOST: " . $envVars['DB_HOST'] . "<br>";
        echo "DB_DATABASE: " . $envVars['DB_DATABASE'] . "<br>";
        
        // Test de connexion
        try {
            $pdo = new PDO(
                "mysql:host={$envVars['DB_HOST']};dbname={$envVars['DB_DATABASE']}", 
                $envVars['DB_USERNAME'] ?? '', 
                $envVars['DB_PASSWORD'] ?? ''
            );
            echo "✅ Connexion base de données réussie<br>";
        } catch(PDOException $e) {
            echo "❌ Erreur connexion DB: " . $e->getMessage() . "<br>";
        }
    } else {
        echo "❌ Variables DB manquantes dans .env<br>";
    }
} catch(Exception $e) {
    echo "❌ Erreur test DB: " . $e->getMessage() . "<br>";
}

echo "<hr><p><strong>SUPPRIMEZ CE FICHIER après diagnostic !</strong></p>";
?> 