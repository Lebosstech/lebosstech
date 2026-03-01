<?php
echo "<h2>DEBUG FICHIER .env - LEBOSS TECH</h2>";

echo "<h3>Recherche du fichier .env</h3>";

$locations = [
    '../.env' => 'Racine du serveur',
    '../app-files/.env' => 'Dans app-files (CORRECT)',
    './.env' => 'Dans htdocs',
    '.env' => 'Htdocs direct'
];

foreach($locations as $path => $description) {
    if(file_exists($path)) {
        echo "✅ $description ($path) - TROUVÉ<br>";
        echo "Taille: " . filesize($path) . " octets<br>";
        echo "Permissions: " . substr(sprintf('%o', fileperms($path)), -4) . "<br><br>";
    } else {
        echo "❌ $description ($path) - NON TROUVÉ<br><br>";
    }
}

echo "<h3>Test complet Laravel</h3>";
try {
    // Test 1: Chargement autoload
    if(file_exists('../app-files/vendor/autoload.php')) {
        require_once '../app-files/vendor/autoload.php';
        echo "✅ Autoload chargé<br>";
        
        // Test 2: Chargement app Laravel
        if(file_exists('../app-files/bootstrap/app.php')) {
            $app = require_once '../app-files/bootstrap/app.php';
            echo "✅ Application Laravel chargée<br>";
            
            // Test 3: Vérification .env
            if(file_exists('../app-files/.env')) {
                echo "✅ Fichier .env trouvé dans app-files<br>";
                echo "<p><strong>TOUT EST PRÊT ! Votre site devrait fonctionner.</strong></p>";
            } else {
                echo "❌ Fichier .env manquant dans app-files<br>";
                echo "<p><strong>DÉPLACEZ le fichier .env dans app-files/</strong></p>";
            }
        }
    }
} catch(Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "<br>";
}

echo "<hr><p><strong>SUPPRIMEZ CE FICHIER après diagnostic !</strong></p>";
?> 