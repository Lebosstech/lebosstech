<?php
// FICHIER DE DEBUG - À SUPPRIMER APRÈS RÉSOLUTION
echo "<h2>DIAGNOSTIC LEBOSS TECH</h2>";

echo "<h3>1. Informations PHP</h3>";
echo "Version PHP: " . phpversion() . "<br>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Server Name: " . $_SERVER['SERVER_NAME'] . "<br>";

echo "<h3>2. Vérification des dossiers</h3>";
echo "Dossier app-files existe: " . (is_dir('../app-files') ? 'OUI ✅' : 'NON ❌') . "<br>";
echo "Fichier vendor/autoload.php existe: " . (file_exists('../app-files/vendor/autoload.php') ? 'OUI ✅' : 'NON ❌') . "<br>";
echo "Fichier bootstrap/app.php existe: " . (file_exists('../app-files/bootstrap/app.php') ? 'OUI ✅' : 'NON ❌') . "<br>";

echo "<h3>3. Permissions des dossiers</h3>";
$directories = [
    '../app-files/storage',
    '../app-files/storage/logs',
    '../app-files/bootstrap/cache'
];

foreach($directories as $dir) {
    if(is_dir($dir)) {
        $perms = substr(sprintf('%o', fileperms($dir)), -4);
        echo "Dossier $dir: $perms<br>";
    } else {
        echo "Dossier $dir: N'EXISTE PAS ❌<br>";
    }
}

echo "<h3>4. Test de connexion à la base de données</h3>";
$envFile = '../app-files/.env';
if(file_exists($envFile)) {
    echo "Fichier .env trouvé ✅<br>";
    // Ne pas afficher le contenu pour des raisons de sécurité
} else {
    echo "Fichier .env MANQUANT ❌<br>";
}

echo "<h3>5. Test simple d'inclusion</h3>";
try {
    if(file_exists('../app-files/vendor/autoload.php')) {
        require_once '../app-files/vendor/autoload.php';
        echo "Autoload chargé avec succès ✅<br>";
    } else {
        echo "Impossible de charger autoload ❌<br>";
    }
} catch(Exception $e) {
    echo "Erreur lors du chargement: " . $e->getMessage() . " ❌<br>";
}

echo "<p><strong>SUPPRIMEZ CE FICHIER après diagnostic !</strong></p>";
?> 