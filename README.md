# LEBOSS TECH MARKET 🛒

Site de vente d'appareils électroniques développé avec Laravel. Application web moderne et responsive permettant aux visiteurs de consulter les produits et de commander facilement via WhatsApp.

## 🚀 Fonctionnalités

### 📱 Frontend Public
- **Page d'accueil** avec slider dynamique et produits vedettes
- **Catalogue produits** avec filtres avancés (catégorie, prix, stock)
- **Pages détail produit** avec galerie d'images et spécifications
- **Pages par catégorie** avec navigation intuitive
- **Page contact** avec formulaire et coordonnées
- **Commande via WhatsApp** avec tracking des clics
- **Design responsive** adapté à tous les écrans
- **SEO optimisé** avec meta tags personnalisés

### 🔐 Interface d'Administration
- **Dashboard** avec statistiques et KPIs
- **Gestion des produits** (CRUD complet)
- **Gestion des catégories** (CRUD complet)
- **Gestion des sliders** (CRUD complet)
- **Système d'authentification** sécurisé
- **Upload d'images** avec redimensionnement automatique
- **Suivi des clics WhatsApp**

## 🛠 Technologies Utilisées

- **Laravel 12** - Framework PHP
- **Laravel Breeze** - Authentification
- **TailwindCSS** - Framework CSS
- **Spatie MediaLibrary** - Gestion des médias
- **Livewire** - Composants interactifs
- **SQLite** - Base de données (développement)
- **Vite** - Build tool moderne

## 📋 Prérequis

- PHP 8.2 ou supérieur
- Composer
- Node.js et npm
- Extension PHP SQLite

## ⚡ Installation

1. **Cloner le projet**
```bash
git clone [URL_DU_REPO]
cd lebosstech
```

2. **Installer les dépendances PHP**
```bash
composer install
```

3. **Installer les dépendances JavaScript**
```bash
npm install
```

4. **Configuration de l'environnement**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Préparer la base de données**
```bash
touch database/database.sqlite
php artisan migrate --seed
```

6. **Compiler les assets**
```bash
npm run build
```

7. **Démarrer le serveur**
```bash
php artisan serve
```

L'application sera accessible sur `http://localhost:8000`

## 👤 Compte Administrateur

- **Email** : admin@lebosstech.ci
- **Mot de passe** : password

Accès admin : `http://localhost:8000/login`

## 📞 Informations de Contact

- **Entreprise** : LEBOSS TECH MARKET
- **Email** : contact@lebosstech.ci
- **Téléphone** : +225 05 66 82 16 09
- **WhatsApp** : +225 0566821609
- **Site** : www.lebosstech.ci
- **Adresse** : Macory Anoumabo, Abidjan

## 🎨 Structure du Projet

```
app/
├── Http/Controllers/
│   ├── Admin/               # Contrôleurs d'administration
│   ├── HomeController.php   # Page d'accueil
│   ├── ProductController.php # Produits publics
│   └── ContactController.php # Contact
├── Models/
│   ├── Category.php         # Modèle catégories
│   ├── Product.php          # Modèle produits
│   ├── Slider.php           # Modèle sliders
│   └── Contact.php          # Modèle contacts

resources/views/
├── layouts/
│   ├── app.blade.php        # Layout admin
│   └── public.blade.php     # Layout public
├── admin/                   # Vues administration
├── products/                # Vues produits
├── home.blade.php           # Page d'accueil
└── contact.blade.php        # Page contact

routes/
└── web.php                  # Routes de l'application
```

## 🔧 Fonctionnalités Techniques

### 🖼 Gestion des Images
- Upload multiple avec validation
- Redimensionnement automatique (thumb, main, banner)
- Optimisation pour le web
- Collections organisées par type

### 📱 Intégration WhatsApp
- Liens directs vers WhatsApp avec message pré-rempli
- Tracking des clics pour analytics
- Boutons d'action rapide

### 🔍 SEO & Performance
- URLs SEO-friendly (`/produits/nom-du-produit`)
- Meta tags dynamiques
- Optimisation des images
- Code minifié en production

### 🛡 Sécurité
- Protection CSRF activée
- Validation serveur stricte
- Authentification sécurisée
- Sanitisation des données

## 📊 Base de Données

### Tables Principales
- `users` - Utilisateurs administrateurs
- `categories` - Catégories de produits
- `products` - Produits avec spécifications
- `sliders` - Diaporama de la page d'accueil
- `contacts` - Messages de contact
- `media` - Fichiers médias (images)

## 🚀 Déploiement

### Production
1. Configurer le serveur web (Apache/Nginx)
2. Créer la base de données MySQL/PostgreSQL
3. Mettre à jour le `.env` avec les vraies valeurs
4. Exécuter les migrations
5. Configurer les permissions de stockage
6. Activer le cache et l'optimisation

### Variables d'Environnement Important
```env
APP_NAME="LEBOSS TECH MARKET"
APP_URL=https://www.lebosstech.ci
DB_CONNECTION=mysql
MAIL_FROM_ADDRESS=contact@lebosstech.ci
```

## 🤝 Fonctionnalités Bonus

- **Animations CSS** subtiles sur les interactions
- **Messages de confirmation** conviviaux  
- **Interface responsive** optimisée mobile
- **Dashboard analytique** avec métriques
- **Système de statut** produits (actif/inactif)
- **Gestion du stock** avec alertes
- **Bouton WhatsApp flottant**

## 📈 Analytics Intégrées

- Compteur de clics WhatsApp par produit
- Statistiques du dashboard admin
- Suivi des messages de contact
- Métriques de performance

## 🐛 Support & Maintenance

Pour tout problème ou question :
1. Vérifier les logs Laravel : `storage/logs/`
2. Contrôler la configuration `.env`
3. S'assurer que les permissions sont correctes
4. Contacter l'équipe de développement

## 📝 Licence

Projet développé pour LEBOSS TECH MARKET. Tous droits réservés.

---

**LEBOSS TECH MARKET** - Votre partenaire de confiance pour tous vos appareils électroniques ! 🚀
