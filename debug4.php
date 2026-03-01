<?php
// Script de diagnostic ultra-basique
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h2>DIAGNOSTIC BASIQUE VENDOR</h2>";

echo "<h3>Test existence des fichiers</h3>";

$files = [
    '../app-files/vendor/autoload.php' => 'Autoload principal',
    '../app-files/vendor/composer/autoload_real.php' => 'Autoload Composer',
    '../app-files/vendor/composer/autoload_classmap.php' => 'Classmap',
    '../app-files/vendor/composer/installed.json' => 'Packages installés'
];

foreach($files as $file => $desc) {
    if(file_exists($file)) {
        $size = filesize($file);
        echo "✅ $desc: $size octets<br>";
    } else {
        echo "❌ $desc: MANQUANT<br>";
    }
}

echo "<h3>Test de lecture du fichier autoload</h3>";
$autoloadPath = '../app-files/vendor/autoload.php';
if(file_exists($autoloadPath)) {
    $content = file_get_contents($autoloadPath);
    echo "Taille du fichier: " . strlen($content) . " octets<br>";
    echo "Premières lignes:<br>";
    echo "<pre>" . htmlspecialchars(substr($content, 0, 500)) . "</pre>";
    
    echo "<h3>Test d'inclusion simple</h3>";
    try {
        // Test sans require_once pour éviter les conflits
        include $autoloadPath;
        echo "✅ Inclusion réussie<br>";
    } catch(ParseError $e) {
        echo "❌ Erreur de syntaxe: " . $e->getMessage() . "<br>";
    } catch(Error $e) {
        echo "❌ Erreur fatale: " . $e->getMessage() . "<br>";
    } catch(Exception $e) {
        echo "❌ Exception: " . $e->getMessage() . "<br>";
    }
} else {
    echo "❌ Fichier autoload.php non trouvé<br>";
}

echo "<h3>Informations système</h3>";
echo "Limite mémoire PHP: " . ini_get('memory_limit') . "<br>";
echo "Temps max d'exécution: " . ini_get('max_execution_time') . "<br>";
echo "Version PHP: " . phpversion() . "<br>";

echo "<hr><p><strong>SUPPRIMEZ CE FICHIER après diagnostic !</strong></p>";
?> 