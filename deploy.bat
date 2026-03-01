@echo off
echo ========================================
echo   LEBOSS TECH - PREPARATION DEPLOIEMENT
echo ========================================
echo.

echo [1/5] Nettoyage du cache Laravel...
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

echo.
echo [2/5] Compilation des assets...
call npm run build

echo.
echo [3/5] Optimisation pour la production...
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo.
echo [4/5] Export de la base de données...
mysqldump -u root lebosstech > lebosstech_backup.sql
if exist lebosstech_backup.sql (
    echo Base de données exportée : lebosstech_backup.sql
) else (
    echo ERREUR: Impossible d'exporter la base de données
)

echo.
echo [5/5] Création du package de déploiement...
if not exist "deploy" mkdir deploy
xcopy /E /I /H /Y app deploy\app
xcopy /E /I /H /Y bootstrap deploy\bootstrap
xcopy /E /I /H /Y config deploy\config
xcopy /E /I /H /Y database deploy\database
xcopy /E /I /H /Y public deploy\public
xcopy /E /I /H /Y resources deploy\resources
xcopy /E /I /H /Y routes deploy\routes
xcopy /E /I /H /Y storage deploy\storage
xcopy /E /I /H /Y vendor deploy\vendor

copy .env.production deploy\.env
copy artisan deploy\artisan
copy composer.json deploy\composer.json
copy composer.lock deploy\composer.lock
if exist lebosstech_backup.sql copy lebosstech_backup.sql deploy\

echo.
echo ========================================
echo   DEPLOIEMENT PRET !
echo ========================================
echo.
echo Prochaines étapes :
echo 1. Compressez le dossier 'deploy' en ZIP
echo 2. Uploadez sur InfinityFree via cPanel
echo 3. Décompressez dans htdocs/
echo 4. Importez lebosstech_backup.sql via phpMyAdmin
echo 5. Vérifiez les permissions des dossiers
echo.
echo Guide complet : GUIDE_DEPLOIEMENT.md
echo.
pause 