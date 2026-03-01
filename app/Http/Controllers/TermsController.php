<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TermsController extends Controller
{
    /**
     * Affiche la page Conditions de Vente de LEBOSS TECH MARKET
     */
    public function index()
    {
        // Sections principales des conditions de vente
        $sections = [
            [
                'id' => 'article-1',
                'title' => 'Article 1 - Objet et Champ d\'Application',
                'icon' => 'fas fa-file-contract',
                'content' => [
                    'Les présentes Conditions Générales de Vente (CGV) régissent les relations contractuelles entre LEBOSS TECH MARKET, société spécialisée dans la vente d\'équipements informatiques reconditionnés, et ses clients.',
                    'Toute commande implique l\'acceptation pleine et entière des présentes conditions.',
                    'LEBOSS TECH MARKET se réserve le droit de modifier ces conditions à tout moment, les conditions applicables étant celles en vigueur à la date de la commande.'
                ]
            ],
            [
                'id' => 'article-2',
                'title' => 'Article 2 - Identification de l\'Entreprise',
                'icon' => 'fas fa-building',
                'content' => [
                    'Dénomination sociale : LEBOSS TECH MARKET',
                    'Forme juridique : Société A Responsabilité Limitée',
                    'Siège social : Macory Anoumabo, Abidjan, Côte d\'Ivoire',
                    'Téléphone : +225 05 66 82 16 09',
                    'Email : contact@lebosstech.ci',
                    'Directeur de publication : GOH TANGUY BRUNO'
                ]
            ],
            [
                'id' => 'article-3',
                'title' => 'Article 3 - Produits et Services',
                'icon' => 'fas fa-laptop',
                'content' => [
                    'LEBOSS TECH MARKET commercialise des équipements informatiques reconditionnés : ordinateurs de bureau, ordinateurs portables, imprimantes laser, écrans, moniteurs, accessoires informatiques et composants PC.',
                    'Tous nos produits sont reconditionnés selon un processus rigoureux de 5 étapes : sélection, tests approfondis, nettoyage complet, contrôle qualité et validation finale.',
                    'Les produits sont présentés avec leurs caractéristiques techniques, photos et prix sur notre site web.',
                    'Les prix sont exprimés en Francs CFA (FCFA) toutes taxes comprises.'
                ]
            ],
            [
                'id' => 'article-4',
                'title' => 'Article 4 - Commandes et Confirmation',
                'icon' => 'fas fa-shopping-cart',
                'content' => [
                    'Les commandes peuvent être passées via WhatsApp au +225 05 66 82 16 09 ou par email à contact@lebosstech.ci.',
                    'Toute commande doit préciser : nom et prénoms, adresse de livraison, numéro de téléphone, produits souhaités.',
                    'Une confirmation de commande sera envoyée par WhatsApp ou email avec récapitulatif et montant total.',
                    'La commande n\'est définitive qu\'après confirmation écrite de LEBOSS TECH MARKET.'
                ]
            ],
            [
                'id' => 'article-5',
                'title' => 'Article 5 - Prix et Modalités de Paiement',
                'icon' => 'fas fa-money-bill-wave',
                'content' => [
                    'Les prix sont indiqués en Francs CFA (FCFA) et peuvent être modifiés sans préavis.',
                    'Pour Abidjan : Paiement à la livraison (espèces ou mobile money)',
                    'Pour l\'intérieur du pays : Paiement obligatoire avant expédition via Wave, Orange Money, MTN Money ou Moov Money',
                    'Aucune commande ne sera expédiée sans paiement préalable pour les livraisons hors Abidjan.',
                    'Un reçu ou facture sera fourni pour chaque transaction.'
                ]
            ],
            [
                'id' => 'article-6',
                'title' => 'Article 6 - Livraison',
                'icon' => 'fas fa-truck',
                'content' => [
                    'Zone Abidjan : Livraison à domicile sous 24-48h ouvrées, paiement à la livraison possible',
                    'Intérieur Côte d\'Ivoire : Expédition sous 2-3 jours ouvrés après réception du paiement',
                    'Transport via compagnies agréées (UTB, STIF, etc.) aux frais du client',
                    'Délais indicatifs pouvant varier selon disponibilité et conditions de transport',
                    'Le client doit vérifier l\'état du colis en présence du livreur et signaler tout dommage immédiatement.'
                ]
            ],
            [
                'id' => 'article-7',
                'title' => 'Article 7 - Garantie 90 Jours',
                'icon' => 'fas fa-shield-alt',
                'content' => [
                    'Tous nos produits reconditionnés bénéficient d\'une garantie de 90 jours à compter de la date de livraison.',
                    'La garantie couvre les défauts de fonctionnement et vices cachés non apparents lors de la livraison.',
                    'Sont exclus de la garantie : dommages dus à une mauvaise utilisation, chute, oxydation, virus informatiques.',
                    'La garantie s\'exerce par retour du produit défaillant accompagné de la facture d\'achat.',
                    'LEBOSS TECH MARKET s\'engage à réparer ou remplacer le produit défaillant dans un délai de 7 jours ouvrés.'
                ]
            ],
            [
                'id' => 'article-8',
                'title' => 'Article 8 - Droit de Rétractation et Retours',
                'icon' => 'fas fa-undo',
                'content' => [
                    'Le client dispose d\'un délai de 3 jours calendaires à compter de la réception pour exercer son droit de rétractation.',
                    'Le produit doit être retourné dans son état d\'origine, avec tous ses accessoires et emballages.',
                    'Les frais de retour sont à la charge du client sauf en cas de produit défaillant.',
                    'Le remboursement sera effectué dans un délai de 7 jours ouvrés après réception du produit retourné.',
                    'Aucun retour ne sera accepté passé le délai de 3 jours, sauf cas de garantie.'
                ]
            ],
            [
                'id' => 'article-9',
                'title' => 'Article 9 - Protection des Données Personnelles',
                'icon' => 'fas fa-user-shield',
                'content' => [
                    'LEBOSS TECH MARKET s\'engage à protéger les données personnelles de ses clients conformément au RGPD.',
                    'Les données collectées (nom, téléphone, adresse) servent uniquement au traitement des commandes.',
                    'Aucune donnée n\'est transmise à des tiers sans consentement explicite du client.',
                    'Le client dispose d\'un droit d\'accès, de rectification et de suppression de ses données.',
                    'Pour exercer ces droits : contact@lebosstech.ci'
                ]
            ],
            [
                'id' => 'article-10',
                'title' => 'Article 10 - Responsabilité',
                'icon' => 'fas fa-balance-scale',
                'content' => [
                    'LEBOSS TECH MARKET ne saurait être tenue responsable des dommages indirects ou immatériels.',
                    'Notre responsabilité est limitée au montant de la commande concernée.',
                    'Le client est responsable de la vérification de la compatibilité des produits avec son matériel existant.',
                    'LEBOSS TECH MARKET ne peut être tenue responsable des retards de livraison dus à des causes extérieures.'
                ]
            ],
            [
                'id' => 'article-11',
                'title' => 'Article 11 - Résolution des Litiges',
                'icon' => 'fas fa-gavel',
                'content' => [
                    'En cas de litige, une solution amiable sera recherchée en priorité.',
                    'Le client peut nous contacter par WhatsApp (+225 05 66 82 16 09) ou email (contact@lebosstech.ci).',
                    'À défaut d\'accord amiable, les tribunaux d\'Abidjan seront seuls compétents.',
                    'Le droit ivoirien s\'applique aux présentes conditions de vente.',
                    'Médiation possible via les associations de consommateurs ivoiriennes.'
                ]
            ],
            [
                'id' => 'article-12',
                'title' => 'Article 12 - Mentions Légales',
                'icon' => 'fas fa-info-circle',
                'content' => [
                    'Site web : www.lebosstech.ci',
                    'Hébergement : [À préciser selon hébergeur choisi]',
                    'Conformité : Respect de la réglementation ivoirienne sur le e-commerce',
                    'TVA : Non assujetti (régime micro-entreprise)',
                    'Dernière mise à jour : ' . date('d/m/Y')
                ]
            ]
        ];

        // Navigation rapide
        $navigation = [
            ['id' => 'article-1', 'title' => 'Objet et Application'],
            ['id' => 'article-2', 'title' => 'Identification'],
            ['id' => 'article-3', 'title' => 'Produits et Services'],
            ['id' => 'article-4', 'title' => 'Commandes'],
            ['id' => 'article-5', 'title' => 'Prix et Paiement'],
            ['id' => 'article-6', 'title' => 'Livraison'],
            ['id' => 'article-7', 'title' => 'Garantie 90 Jours'],
            ['id' => 'article-8', 'title' => 'Retours'],
            ['id' => 'article-9', 'title' => 'Données Personnelles'],
            ['id' => 'article-10', 'title' => 'Responsabilité'],
            ['id' => 'article-11', 'title' => 'Litiges'],
            ['id' => 'article-12', 'title' => 'Mentions Légales']
        ];

        return view('terms', compact('sections', 'navigation'));
    }
}
