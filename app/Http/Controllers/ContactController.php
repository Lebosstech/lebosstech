<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Affiche la page de contact de LEBOSS TECH MARKET
     */
    public function index()
    {
        // Informations de contact
        $contactInfo = [
            'company' => 'LEBOSS TECH MARKET',
            'tagline' => 'Votre partenaire informatique de confiance',
            'address' => 'Macory Anoumabo, Abidjan, Côte d\'Ivoire',
            'phone' => '+225 05 66 82 16 09',
            'email' => 'contact@lebosstech.ci',
            'website' => 'www.lebosstech.ci',
            'whatsapp' => '2250566821609'
        ];

        // Horaires d'ouverture
        $schedule = [
            'Lundi - Vendredi' => '08h00 - 18h00',
            'Samedi' => '09h00 - 17h00',
            'Dimanche' => '10h00 - 15h00'
        ];

        // Services de contact
        $contactMethods = [
            [
                'icon' => 'fab fa-whatsapp',
                'title' => 'WhatsApp',
                'description' => 'Réponse immédiate 7j/7',
                'value' => '+225 05 66 82 16 09',
                'link' => 'https://wa.me/2250566821609',
                'color' => 'green'
            ],
            [
                'icon' => 'fas fa-phone',
                'title' => 'Téléphone',
                'description' => 'Appelez-nous directement',
                'value' => '+225 05 66 82 16 09',
                'link' => 'tel:+2250566821609',
                'color' => 'blue'
            ],
            [
                'icon' => 'fas fa-envelope',
                'title' => 'Email',
                'description' => 'Réponse sous 24h',
                'value' => 'contact@lebosstech.ci',
                'link' => 'mailto:contact@lebosstech.ci',
                'color' => 'orange'
            ],
            [
                'icon' => 'fas fa-map-marker-alt',
                'title' => 'Adresse',
                'description' => 'Visitez notre showroom',
                'value' => 'Macory Anoumabo, Abidjan',
                'link' => '#map-section',
                'color' => 'purple'
            ]
        ];

        // FAQ Contact
        $faq = [
            [
                'question' => 'Comment passer une commande ?',
                'answer' => 'Vous pouvez commander via WhatsApp, téléphone ou email. Nous confirmons chaque commande avant traitement.'
            ],
            [
                'question' => 'Quels sont les délais de livraison ?',
                'answer' => 'Abidjan : 24-48h. Intérieur du pays : 2-3 jours après confirmation de paiement.'
            ],
            [
                'question' => 'Quels moyens de paiement acceptez-vous ?',
                'answer' => 'Wave, Orange Money, MTN Money, Moov Money. Paiement à la livraison possible sur Abidjan.'
            ],
            [
                'question' => 'Proposez-vous une garantie ?',
                'answer' => 'Oui, tous nos produits reconditionnés bénéficient d\'une garantie de 90 jours.'
            ],
            [
                'question' => 'Puis-je visiter votre magasin ?',
                'answer' => 'Bien sûr ! Notre showroom est ouvert du lundi au dimanche. Consultez nos horaires ci-dessous.'
            ]
        ];

        // Raisons de nous contacter
        $reasons = [
            [
                'icon' => 'fas fa-shopping-cart',
                'title' => 'Passer Commande',
                'description' => 'Commandez vos équipements informatiques'
            ],
            [
                'icon' => 'fas fa-question-circle',
                'title' => 'Support Technique',
                'description' => 'Assistance et conseils techniques'
            ],
            [
                'icon' => 'fas fa-tools',
                'title' => 'SAV & Garantie',
                'description' => 'Service après-vente et garantie'
            ],
            [
                'icon' => 'fas fa-info-circle',
                'title' => 'Informations',
                'description' => 'Questions sur nos produits et services'
            ]
        ];

        return view('contact', compact('contactInfo', 'schedule', 'contactMethods', 'faq', 'reasons'));
    }
    
    /**
     * Traite l'envoi du formulaire de contact
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
            'contact_method' => 'required|in:whatsapp,email,phone,visit'
        ], [
            'name.required' => 'Le nom est obligatoire.',
            'email.required' => 'L\'email est obligatoire.',
            'email.email' => 'Veuillez saisir un email valide.',
            'subject.required' => 'Le sujet est obligatoire.',
            'message.required' => 'Le message est obligatoire.',
            'message.min' => 'Le message doit contenir au moins 10 caractères.',
            'contact_method.required' => 'Veuillez choisir un moyen de contact préféré.'
        ]);
        
        // Enregistrer le contact
        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'contact_method' => $request->contact_method,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        // Message de succès personnalisé selon le moyen de contact
        $successMessages = [
            'whatsapp' => 'Merci ! Nous vous répondrons via WhatsApp dans les plus brefs délais.',
            'email' => 'Merci ! Nous vous répondrons par email sous 24h maximum.',
            'phone' => 'Merci ! Nous vous rappellerons dans les plus brefs délais.',
            'visit' => 'Merci ! Nous vous attendons dans notre showroom aux horaires indiqués.'
        ];
        
        return redirect()->route('contact.index')
            ->with('success', $successMessages[$request->contact_method] ?? 'Votre message a été envoyé avec succès.');
    }
}
