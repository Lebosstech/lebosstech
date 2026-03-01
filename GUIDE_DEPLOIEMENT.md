# 🚀 GUIDE DE DÉPLOIEMENT - LEBOSS TECH MARKET

## 📋 **PROBLÈME IDENTIFIÉ**

InfinityFree ne permet **PAS** les connexions MySQL externes. La base de données `if0_39284533_leboss` ne peut être utilisée que depuis leurs serveurs.

## 💡 **SOLUTION RECOMMANDÉE**

### **Phase 1 : Développement Local**
Continuez à développer en local avec XAMPP :
- ✅ Base locale : `lebosstech` 
- ✅ Serveur : `127.0.0.1`
- ✅ Utilisateur : `root`

### **Phase 2 : Déploiement sur InfinityFree**

#### **Étape 1 : Préparer les fichiers**
```bash
# 1. Compiler les assets
npm run build

# 2. Optimiser pour la production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### **Étape 2 : Upload des fichiers**
1. **Connectez-vous à votre cPanel InfinityFree**
2. **Gestionnaire de fichiers** → `htdocs/`
3. **Uploadez tous les fichiers** sauf :
   - `node_modules/`
   - `.env` (utilisez `.env.production`)
   - `storage/logs/`

#### **Étape 3 : Configuration en ligne**
1. **Renommez** `.env.production` en `.env`
2. **Vérifiez les permissions** des dossiers :
   - `storage/` → 755
   - `bootstrap/cache/` → 755

#### **Étape 4 : Migration de la base de données**
```bash
# Sur le serveur InfinityFree (via terminal si disponible)
php artisan migrate --force
php artisan db:seed --force
```

---

## 🔧 **CONFIGURATION ACTUELLE**

### **Local (.env)**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lebosstech
DB_USERNAME=root
DB_PASSWORD=
```

### **Production (.env.production)**
```env
DB_CONNECTION=mysql
DB_HOST=sql102.infinityfree.com
DB_PORT=3306
DB_DATABASE=if0_39284533_leboss
DB_USERNAME=if0_39284533
DB_PASSWORD=@1yy1H3Vt3
```

---

## 📊 **MIGRATION DES DONNÉES**

### **Option A : Export/Import SQL**
```bash
# 1. Exporter la base locale
mysqldump -u root lebosstech > lebosstech_backup.sql

# 2. Importer via phpMyAdmin sur InfinityFree
# - Connectez-vous à phpMyAdmin
# - Sélectionnez if0_39284533_leboss
# - Importez lebosstech_backup.sql
```

### **Option B : Seeders Laravel**
```bash
# 1. Créer des seeders avec vos données
php artisan make:seeder ProductionDataSeeder

# 2. Exécuter sur le serveur
php artisan db:seed --class=ProductionDataSeeder
```

---

## 🌐 **STRUCTURE DE DÉPLOIEMENT**

```
InfinityFree/
├── htdocs/
│   ├── public/          # Dossier racine du site
│   │   ├── index.php
│   │   ├── css/
│   │   ├── js/
│   │   └── images/
│   ├── app/
│   ├── config/
│   ├── database/
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   ├── vendor/
│   ├── .env             # Configuration production
│   └── artisan
```

---

## 🔒 **SÉCURITÉ**

### **Fichiers à NE PAS uploader :**
- `.env.example`
- `.git/`
- `node_modules/`
- `tests/`
- `README.md`
- Ce guide de déploiement

### **Permissions importantes :**
```bash
chmod 755 storage/
chmod 755 storage/app/
chmod 755 storage/framework/
chmod 755 storage/logs/
chmod 755 bootstrap/cache/
```

---

## 🚨 **DÉPANNAGE**

### **Erreur 500 :**
1. Vérifiez les permissions
2. Consultez `storage/logs/laravel.log`
3. Vérifiez la configuration `.env`

### **Base de données inaccessible :**
1. Vérifiez les identifiants MySQL
2. Assurez-vous que les migrations sont exécutées
3. Vérifiez que la base existe sur InfinityFree

### **Assets manquants :**
1. Exécutez `npm run build` avant l'upload
2. Vérifiez que `public/build/` est uploadé
3. Configurez `APP_URL` correctement

---

## ✅ **CHECKLIST DE DÉPLOIEMENT**

- [ ] Code testé en local
- [ ] Assets compilés (`npm run build`)
- [ ] Configuration production (.env.production)
- [ ] Fichiers uploadés sur InfinityFree
- [ ] Permissions configurées
- [ ] Base de données migrée
- [ ] Site accessible et fonctionnel

---

## 📞 **SUPPORT**

Si vous rencontrez des problèmes :
1. Vérifiez les logs : `storage/logs/laravel.log`
2. Testez étape par étape
3. Consultez la documentation InfinityFree

---

*Guide créé le 21 Juin 2025 - LEBOSS TECH MARKET* 