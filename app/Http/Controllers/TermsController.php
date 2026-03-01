<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TermsController extends Controller
{
    /**
     * Affiche la page Conditions de Vente de LEBOSS TECH MARKET
     * Approche "Gagnant-Gagnant" / B2B
     */
    public function index()
    {
        // Sections principales des conditions de partenariat
        $sections = [
            [
                'id' => 'article-1',
                'title' => 'Article 1 - Notre Engagement Commun',
                'icon' => 'fas fa-handshake',
                'content' => [
                    'Chez LEBOSS TECH, nous croyons qu\'une relation commerciale durable repose sur la confiance et des intérêts partagés. Ces conditions définissent le cadre de notre partenariat gagnant-gagnant.',
                    'Notre objectif est de vous accompagner dans la réussite de vos projets technologiques en vous fournissant du matériel fiable et un service réactif.',
                    'Toute commande implique l\'adhésion à cet esprit de collaboration mutuelle, bien au-delà d\'une simple transaction.'
                ]
            ],
            [
                'id' => 'article-2',
                'title' => 'Article 2 - Qui Sommes-Nous ?',
                'icon' => 'fas fa-building',
                'content' => [
                    'Dénomination sociale : LEBOSS TECH MARKET',
                    'Registre de Commerce (RCCM) : CI-ABJ-03-2026-B12-00749',
                    'Siège social : Macory Anoumabo, Abidjan, Côte d\'Ivoire',
                    'Téléphone : +225 05 66 82 16 09',
                    'Email : contact@lebosstech.ci',
                    'Votre interlocuteur dédié : GOH TANGUY BRUNO'
                ]
            ],
            [
                'id' => 'article-3',
                'title' => 'Article 3 - Nos Solutions et Équipements',
                'icon' => 'fas fa-laptop-code',
                'content' => [
                    'Nous ne vendons pas seulement du matériel, nous proposons des solutions adaptées à vos besoins (ordinateurs, serveurs, imprimantes, réseaux, reconditionné premium).',
                    'Nos équipements reconditionnés passent par un processus strict en 5 étapes pour garantir une fiabilité équivalente au neuf, vous permettant d\'optimiser votre budget IT.',
                    'Nous assurons un devoir de conseil : nos experts vous aident à choisir exactement ce qu\'il vous faut, ni plus, ni moins.'
                ]
            ],
            [
                'id' => 'article-4',
                'title' => 'Article 4 - Collaborer et Commander',
                'icon' => 'fas fa-comments',
                'content' => [
                    'La simplicité est notre mot d\'ordre. Vos projets ou commandes peuvent être discutés directement via WhatsApp (+225 05 66 82 16 09) ou par email.',
                    'Pour les entreprises, nous établissons systématiquement un devis détaillé, clair et sans frais cachés.',
                    'Un accord clair : votre commande est validée dès votre acceptation du devis, lançant immédiatement la préparation par nos techniciens.'
                ]
            ],
            [
                'id' => 'article-5',
                'title' => 'Article 5 - Tarification et Flexibilité de Paiement',
                'icon' => 'fas fa-chart-pie',
                'content' => [
                    'Nos prix sont pensés pour être compétitifs tout en garantissant un haut niveau de service et de suivi post-déploiement.',
                    'Sur Abidjan, nous offrons la flexibilité d\'un paiement à la livraison, après vérification et validation par vos soins.',
                    'Pour nos partenaires en province, un paiement préalable sécurisé (Wave, Orange, MTN, virement bancaire) est requis avant expédition.',
                    'Pour les grands comptes et marchés publics, des conditions de paiement différé peuvent être étudiées sur dossier.'
                ]
            ],
            [
                'id' => 'article-6',
                'title' => 'Article 6 - Livraison et Déploiement',
                'icon' => 'fas fa-shipping-fast',
                'content' => [
                    'Votre temps est précieux : sur Abidjan, nous visons une livraison et/ou installation sous 24 à 48 heures.',
                    'Pour l\'intérieur du pays, nous expédions via des partenaires de confiance sous 2-3 jours ouvrés, avec un suivi rigoureux.',
                    'En cas d\'imprévu logistique, nous nous engageons à vous informer proactivement et à trouver une solution d\'urgence.'
                ]
            ],
            [
                'id' => 'article-7',
                'title' => 'Article 7 - Sérénité : Notre Garantie',
                'icon' => 'fas fa-shield-check',
                'content' => [
                    'Nous sommes certains de la qualité de nos produits. C\'est pourquoi nous offrons une garantie standard de 90 jours, extensible selon vos besoins B2B.',
                    'Notre Service Après-Vente n\'est pas un centre d\'appels anonyme, mais une équipe technique réactive basée à Abidjan.',
                    'Détails de couverture ? Consultez notre page dédiée à la Garantie Totale LEBOSS TECH.'
                ]
            ],
            [
                'id' => 'article-8',
                'title' => 'Article 8 - Droit à l\'Erreur (Retours)',
                'icon' => 'fas fa-exchange-alt',
                'content' => [
                    'Parce que les besoins peuvent évoluer, nous vous accordons un droit à l\'erreur de 3 jours calendaires pour changer d\'avis sur du matériel non utilisé.',
                    'Si l\'équipement ne convient pas à votre infrastructure malgré nos conseils, nous étudierons ensemble un échange pour la solution adéquate.',
                    'Notre but est que chaque équipement déployé soit utile et performant pour vos opérations.'
                ]
            ],
            [
                'id' => 'article-9',
                'title' => 'Article 9 - Confidentialité et Sécurité',
                'icon' => 'fas fa-user-lock',
                'content' => [
                    'Nous connaissons l\'importance de vos données. Toute information technique ou commerciale échangée reste strictement confidentielle.',
                    'Lors du reconditionnement, tous les supports de stockage sont effacés de manière sécurisée selon des standards militaires.',
                    'Vos données de contact ne seront jamais vendues. Nous ne vous contacterons que pour ce qui compte vraiment pour votre activité.'
                ]
            ],
            [
                'id' => 'article-10',
                'title' => 'Article 10 - Responsabilité Partagée',
                'icon' => 'fas fa-balance-scale',
                'content' => [
                    'Nous assumons pleinement la responsabilité de la qualité de notre matériel et de nos installations réseau.',
                    'De votre côté, la sécurisation de vos environnements informatiques (antivirus, onduleurs, sauvegardes) assure la pérennité de notre travail commun.',
                    'En cas de problème complexe, nous chercherons toujours la solution technique avant de chercher le coupable.'
                ]
            ],
            [
                'id' => 'article-11',
                'title' => 'Article 11 - Résolution Intelligente des Litiges',
                'icon' => 'fas fa-comments-dollar',
                'content' => [
                    'La voie judiciaire est un échec. En cas de désaccord, nous nous asseyons autour d\'une table pour trouver une solution amiable et commerciale.',
                    'Ce n\'est qu\'en dernier recours, après épuisement de tout dialogue, que les juridictions d\'Abidjan seraient saisies, sous l\'égide du droit ivoirien.'
                ]
            ]
        ];

        // Navigation rapide
        $navigation = [
            ['id' => 'article-1', 'title' => 'Notre Engagement'],
            ['id' => 'article-2', 'title' => 'Qui Sommes-Nous'],
            ['id' => 'article-3', 'title' => 'Nos Solutions'],
            ['id' => 'article-4', 'title' => 'Collaboration'],
            ['id' => 'article-5', 'title' => 'Tarifs & Paiement'],
            ['id' => 'article-6', 'title' => 'Déploiement'],
            ['id' => 'article-7', 'title' => 'Notre Garantie'],
            ['id' => 'article-8', 'title' => 'Droit à l\'Erreur'],
            ['id' => 'article-9', 'title' => 'Confidentialité'],
            ['id' => 'article-10', 'title' => 'Responsabilité'],
            ['id' => 'article-11', 'title' => 'Résolution Intelligente']
        ];

        return view('terms', compact('sections', 'navigation'));
    }

    /**
     * Affiche la nouvelle page des Informations de Garantie de LEBOSS TECH
     */
    public function warranty()
    {
        return view('warranty');
    }
}
