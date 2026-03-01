# 🚀 GUIDE COMPLET DE DÉPLOIEMENT - LEBOSS TECH SUR INFINITYFREE

## 📋 PRÉPARATIFS AVANT DÉPLOIEMENT

### 1. ✅ VÉRIFICATIONS LOCALES
```bash
# Testez votre site localement
php artisan serve
# Vérifiez que tout fonctionne correctement
```

### 2. 📁 PRÉPARATION DES FICHIERS
- ✅ Assurez-vous que votre projet fonctionne parfaitement en local
- ✅ Vérifiez que toutes les images sont dans `public/images/`
- ✅ Testez toutes les fonctionnalités (création produit, affichage, etc.)

---

## 🌐 ÉTAPE 1: INSCRIPTION ET CONFIGURATION INFINITYFREE

### A. Créer un compte InfinityFree
1. Allez sur **https://www.infinityfree.net/**
2. Cliquez sur **"Create Account"**
3. Choisissez un sous-domaine: `lebosstech.epizy.com` ou similaire
4. Complétez l'inscription

### B. Accéder au Control Panel
1. Connectez-vous à votre compte
2. Cliquez sur **"Control Panel"** 
3. Notez vos informations FTP qui apparaissent

---

## 📂 ÉTAPE 2: PRÉPARER LES FICHIERS POUR L'UPLOAD

### A. Créer le dossier de déploiement
```
📁 lebosstech-deploy/
├── 📁 htdocs/          (contenu du dossier 'public')
├── 📁 app-files/       (tout le reste du projet Laravel)
└── 📄 .env.production  (fichier de configuration)
```

### B. Organiser les fichiers

#### 1️⃣ Dossier `htdocs` (sera uploadé dans htdocs sur le serveur)
```
Copiez TOUT le contenu de votre dossier 'public' dans htdocs/:
- index.php
- css/
- js/
- images/
- favicon.ico
- robots.txt
```

#### 2️⃣ Dossier `app-files` (sera uploadé hors de htdocs)
```
Copiez TOUS ces dossiers/fichiers dans app-files/:
- app/
- bootstrap/
- config/
- database/
- resources/
- routes/
- storage/
- vendor/
- artisan
- composer.json
- composer.lock
```

#### 3️⃣ Modifier index.php dans htdocs
Éditez `htdocs/index.php` et changez:
```php
// AVANT:
require_once __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

// APRÈS:
require_once __DIR__.'/../app-files/vendor/autoload.php';
$app = require_once __DIR__.'/../app-files/bootstrap/app.php';
```

#### 4️⃣ Créer le fichier .env.production
```env
APP_NAME="LEBOSS TECH MARKET"
APP_ENV=production
APP_KEY=base64:YOUR_KEY_HERE
APP_DEBUG=false
APP_URL=https://lebosstech.epizy.com

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

# Base de données InfinityFree
DB_CONNECTION=mysql
DB_HOST=sqlXXX.epizy.com
DB_PORT=3306
DB_DATABASE=epiz_XXXXXXX_lebosstech
DB_USERNAME=epiz_XXXXXXX
DB_PASSWORD=VOTRE_MOT_DE_PASSE

# Configuration mail (optionnel)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=votre-email@gmail.com
MAIL_PASSWORD=votre-mot-de-passe-app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=votre-email@gmail.com
MAIL_FROM_NAME="LEBOSS TECH"
```

---

## 🔄 ÉTAPE 3: UPLOAD VIA FTP

### A. Télécharger un client FTP
- **FileZilla** (gratuit): https://filezilla-project.org/
- **WinSCP** (Windows): https://winscp.net/

### B. Configuration FTP dans FileZilla
```
Hôte: ftpupload.net
Nom d'utilisateur: epiz_XXXXXXX (fourni par InfinityFree)
Mot de passe: (fourni par InfinityFree)
Port: 21
```

### C. Structure d'upload sur le serveur
```
📁 Serveur InfinityFree/
├── 📁 htdocs/                  ← Uploadez le contenu de votre dossier 'htdocs' ici
│   ├── index.php
│   ├── css/
│   ├── js/
│   ├── images/
│   └── ...
├── 📁 app-files/               ← Créez ce dossier et uploadez le contenu de 'app-files'
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   └── ...
└── 📄 .env                     ← Renommez .env.production en .env
```

### D. Processus d'upload
1. **Connectez-vous via FTP**
2. **Créez le dossier `app-files`** au niveau racine (même niveau que htdocs)
3. **Uploadez tout le contenu de votre dossier local `htdocs`** dans `htdocs/` sur le serveur
4. **Uploadez tout le contenu de votre dossier local `app-files`** dans `app-files/` sur le serveur
5. **Uploadez `.env.production`** et renommez-le en `.env` à la racine

⚠️ **ATTENTION**: L'upload peut prendre 30-60 minutes selon votre connexion !

---

## 🗄️ ÉTAPE 4: CONFIGURATION BASE DE DONNÉES

### A. Créer la base de données
1. Dans le Control Panel InfinityFree
2. Allez dans **"MySQL Databases"**
3. Créez une nouvelle base: `epiz_XXXXXXX_lebosstech`
4. Notez les informations de connexion

### B. Importer les données

#### Option 1: Via phpMyAdmin (RECOMMANDÉ)
1. Cliquez sur **"phpMyAdmin"** dans le Control Panel
2. Sélectionnez votre base de données
3. Cliquez sur **"Importer"**
4. Choisissez votre fichier `database.sql` exporté depuis votre XAMPP local

#### Option 2: Créer un script d'installation
Créez `htdocs/install.php`:
```php
<?php
// SCRIPT À SUPPRIMER APRÈS INSTALLATION !
require_once __DIR__.'/../app-files/vendor/autoload.php';

$app = require_once __DIR__.'/../app-files/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// Exécuter les migrations
$kernel->call('migrate:fresh');
$kernel->call('db:seed');

echo "Installation terminée ! SUPPRIMEZ CE FICHIER !";
?>
```

Puis allez sur: `https://lebosstech.epizy.com/install.php`

---

## ⚙️ ÉTAPE 5: CONFIGURATION FINALE

### A. Permissions des dossiers
Via FTP, vérifiez les permissions:
```
📁 app-files/storage/ → 755
📁 app-files/storage/logs/ → 755
📁 app-files/bootstrap/cache/ → 755
```

### B. Test de fonctionnement
1. Visitez: `https://lebosstech.epizy.com`
2. Testez l'admin: `https://lebosstech.epizy.com/admin`
3. Vérifiez l'upload d'images
4. Testez les produits

### C. Configuration des URLs
Si les liens ne fonctionnent pas, ajoutez dans `app-files/config/app.php`:
```php
'asset_url' => env('ASSET_URL', 'https://lebosstech.epizy.com'),
```

---

## 🔧 ÉTAPE 6: RÉSOLUTION DES PROBLÈMES COURANTS

### A. Erreur 500 - Internal Server Error
```
✅ Vérifiez le fichier .env
✅ Vérifiez les permissions des dossiers
✅ Consultez les logs dans Control Panel > Error Logs
```

### B. Images ne s'affichent pas
```php
// Dans les vues Blade, utilisez:
{{ asset('images/logo.jpg') }}
// Au lieu de chemins relatifs
```

### C. Base de données non accessible
```
✅ Vérifiez les informations DB dans .env
✅ Assurez-vous que DB_HOST correspond à celui fourni
✅ Testez la connexion via phpMyAdmin
```

### D. CSS/JS ne se chargent pas
```
✅ Vérifiez que les fichiers sont dans htdocs/css/ et htdocs/js/
✅ Utilisez {{ asset('css/app.css') }} dans les templates
```

---

## 📱 ÉTAPE 7: POST-DÉPLOIEMENT

### A. Supprimez les fichiers sensibles
```
❌ Supprimez htdocs/install.php (si créé)
❌ Supprimez les fichiers de test
```

### B. Configuration SSL (HTTPS)
1. Dans Control Panel InfinityFree
2. Allez dans **"SSL Certificates"**
3. Activez le SSL gratuit
4. Mettez à jour APP_URL dans .env

### C. Optimisations
```php
// Dans .env, optimisez pour la production:
APP_ENV=production
APP_DEBUG=false
LOG_LEVEL=error
```

---

## ✅ CHECKLIST FINALE

- [ ] ✅ Site accessible sur https://lebosstech.epizy.com
- [ ] ✅ Page d'accueil fonctionne
- [ ] ✅ Admin accessible (/admin)
- [ ] ✅ Login admin fonctionne
- [ ] ✅ Création de produits possible
- [ ] ✅ Upload d'images fonctionne
- [ ] ✅ Base de données connectée
- [ ] ✅ Images s'affichent correctement
- [ ] ✅ WhatsApp modal fonctionne
- [ ] ✅ SSL/HTTPS activé

---

## 📞 SUPPORT

### Si vous rencontrez des problèmes:
1. **Consultez les Error Logs** dans Control Panel
2. **Vérifiez le fichier .env**
3. **Testez étape par étape**

### Commandes utiles pour débugger:
```php
// Créez htdocs/debug.php pour tester
<?php
echo "PHP Version: " . phpversion() . "<br>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Server Name: " . $_SERVER['SERVER_NAME'] . "<br>";

// Test connexion DB
try {
    $pdo = new PDO('mysql:host=sqlXXX.epizy.com;dbname=epiz_XXXXXXX_lebosstech', 'username', 'password');
    echo "Connexion DB: OK";
} catch(PDOException $e) {
    echo "Erreur DB: " . $e->getMessage();
}
?>
```

🎉 **Votre site LEBOSS TECH sera maintenant déployé avec succès sur InfinityFree !** 