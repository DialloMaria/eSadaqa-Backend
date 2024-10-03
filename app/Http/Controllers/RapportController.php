<?php

namespace App\Http\Controllers;

use App\Models\Don;
use App\Models\Rapport;
use App\Models\Donateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Assurez-vous que le modèle User est importé
use App\Models\Reservation; // Assurez-vous que le modèle Reservation est importé
use App\Notifications\DonDistribuer; // Assurez-vous que la notification est importée

class RapportController extends Controller
{


    public function generateReport(Request $request)
    {
            // Vérifier si l'utilisateur est connecté et a le rôle 'beneficiaire'
            $user = Auth::user();
            if (!$user || !$user->hasRole('beneficiaire')) {
                return response()->json(['message' => 'Accès refusé. Vous devez être connecté en tant qu\'beneficiaire.'], 403);
            }

            // Récupérer la réservation via l'ID passé en paramètre
            $reservation = Reservation::find($request->input('reservation_id'));
            if (!$reservation) {
                return response()->json(['error' => 'Réservation introuvable.'], 404);
            }
                // Récupérer la réservation via l'ID passé en paramètre
            // $reservation = Reservation::find($reservation_id);
            // if (!$reservation) {
            //     return response()->json(['error' => 'Réservation introuvable.'], 404);
            // }


            // Récupérer les relations
            $donateur = User::find($reservation->created_by);
            $beneficiaire = $reservation->beneficiaire;
            $organisation = $reservation->organisation;
            $namedonateur = $reservation->creator->organisation->nomstructure;
            // $namedonateu = $reservation->creator->donateur->nomstructure;


            $namedonateu = $reservation->don->creator->nom;
            $namedonateu = $reservation->don->creator->donateur->nomstructure;;

            $donateur->nomstructure;


            // Vérifier si le donateur et le bénéficiaire existent
            if (!$donateur) {
                return response()->json(['error' => 'Donateur introuvable.'], 404);
            }

            if (!$beneficiaire) {
                return response()->json(['error' => 'Bénéficiaire introuvable.'], 404);
            }

            // $dateLivraison = now()->format('d/m/Y');
            // $organisationNom = $organisation->nom ?? "Rahma Delivry";
            $contact = $organisation->contact ?? "+221 77 003 09 21";
            $adresse = $organisation->adresse ?? "Yoff, Dakar, Sénégal";

            // Détails du don (ajuster selon la logique métier)
            $detailsDon = "Détails à récupérer depuis le modèle Don, si nécessaire.";

            // Création du contenu du rapport
            $contenu = "Rapport de Don à l'Orphelinat $beneficiaire->nomstructure";
            $contenu .= "Donateur : $donateur->nomstructure";
            // $contenu .= "Date de la livraison : $dateLivraison";
            $contenu .= "Organisme de livraison : $organisation->nomstructure";
            $contenu .= "Contact : $contact";
            $contenu .= "Adresse : $beneficiaire->adresse";
            $contenu .= "Orphelinat bénéficiaire : $beneficiaire->nomstructure";
            $contenu .= "Objet : Rapport sur la livraison de don";
            $contenu .= "Le , nous avons reçu avec grande gratitude un don généreux de M. $namedonateu destiné à l'orphelinat $beneficiaire->nomstructure. Ce don a été soigneusement livré par l’organisme $organisation->nomstructure, reconnu pour son engagement envers les causes humanitaires.";
            $contenu .= "Détails du don :$detailsDon";
            $contenu .= "Réception du don";
            $contenu .= "La livraison s’est déroulée dans de bonnes conditions. Les équipes de l'organisation $organisation->nomstructure ont fait preuve de professionnalisme et de diligence, assurant que chaque article soit bien remis aux responsables de l’orphelinat. Les bénévoles de $beneficiaire->nomstructure ont été présents pour accueillir les dons et ont exprimé leur sincère reconnaissance.";
            $contenu .= "Remerciements";
            $contenu .= "Nous tenons à adresser nos remerciements les plus chaleureux à M. $namedonateu pour son acte de noblesse et sa générosité. Son soutien contribue à améliorer le quotidien des enfants de l’orphelinat et à leur offrir un environnement plus confortable.";
            $contenu .= "Conclusion";
            $contenu .= "Ce geste bienveillant témoigne de l’importance de la solidarité dans notre communauté. Nous encourageons d'autres personnes à suivre l’exemple de M. $namedonateur pour continuer à apporter espoir et soutien aux plus vulnérables. L’orphelinat $beneficiaire->nomstructure se réjouit de cette collaboration et espère pouvoir compter sur des partenaires engagés pour l’avenir.";
            $contenu .= "Nous vous remercions encore une fois et restons à votre disposition pour toute future collaboration.";

            // Créer le rapport
            $rapport = Rapport::create([
                'contenu' => $contenu,
                'reservation_id' => $reservation->id,
                'created_by' => $user->id,
                'beneficiaire_id' => $beneficiaire->id,
                'donateur_id' => $donateur->id, // Utilisez l'ID du donateur

            ]);

            // Retourner les informations en JSON
            return response()->json([
                'organisation' => $reservation->organisation,
                'creator' => $reservation->creator,
                'nom ' => $reservation->creator->nom,
                'nom ' => $reservation->creator->organisation->nomstructure,
                'nom OR' => $reservation->organisation->nomstructure,
                'rapport' => $rapport,
                'creator' => $reservation->creator,
                'beneficiaire' => $beneficiaire->nomstructure,
                // 'dateLivraison' => $dateLivraison,
                'organisation' => $organisation,
                'contact' => $contact,
                'adresse' => $adresse,
                'detailsDon' => $detailsDon,
                'contenu' => $contenu,
                'message' => 'Rapport généré avec succès.'
            ]);
    }

}




// public function generateReport(Don $don, Reservation $reservation, Donateur $donateur)
    // {
    //     // Trouver la réservation associée au don
    //     // $reservation = Reservation::where('don_id', $don->id)->first();
    //     $reservation -> donateur = $donateur -> id ;
    //     // // Vérifier si une réservation existe
    //     // if (!$reservation) {
    //     //     return response()->json([
    //     //         'error' => 'Aucune réservation trouvée pour ce don.'
    //     //     ], 404);
    //     // }

    //     $user = Auth::user();
    //     if (!$user || !$user->hasRole('beneficiaire')) {
    //         return response()->json(['message' => 'Accès refusé. Vous devez être connecté en tant qu\'beneficiare.'], 403);
    //     }

    //     $beneficiaire = $reservation->beneficiaire; // Bénéficiaire associé
    //     $donateur = $don->donateur; // Donateur associé

    //     $dateLivraison = now()->format('d/m/Y');
    //     $organisation = "Rahma Delivery";
    //     $contact = "+221 77 003 09 21";
    //     $adresse = "Yoff, Dakar, Sénégal";

    //     // Détails du don (ajuste selon ta logique pour récupérer les articles)
    //     $detailsDon = "2 sacs de riz\n2 lits (matlat)\nVêtements divers\nCéréales";

    //     $donateur = $reservation->donateur;

    //     // Création du contenu du rapport
    //     $contenu = "Rapport de Don à l'Orphelinat $beneficiaire";
    //     $contenu = "Donateur : $donateur->nomstructure\n";
    //     $contenu .= "Date de la livraison : $dateLivraison\n";
    //     $contenu .= "Organisme de livraison : $organisation\n";
    //     $contenu .= "Contact : $contact\n";
    //     $contenu .= "Adresse : $adresse\n";
    //     $contenu .= "Orphelinat bénéficiaire : $beneficiaire";
    //     $contenu .= "Objet : Rapport sur la livraison de don\n";
    //     $contenu .= "Le $dateLivraison, nous avons reçu avec grande gratitude un don généreux de M. $donateur->name destiné à l'orphelinat $beneficiaire. Ce don a été soigneusement livré par l’organisme $organisation, reconnu pour son engagement envers les causes humanitaires.\n\n";
    //     $contenu .= "Détails du don :\n$detailsDon\n\n";
    //     $contenu .= "Réception du don\n";
    //     $contenu .= "La livraison s’est déroulée dans de bonnes conditions. Les équipes de $organisation ont fait preuve de professionnalisme et de diligence, assurant que chaque article soit bien remis aux responsables de l’orphelinat. Les bénévoles de $beneficiaire ont été présents pour accueillir les dons et ont exprimé leur sincère reconnaissance.\n\n";
    //     $contenu .= "Remerciements\n";
    //     $contenu .= "Nous tenons à adresser nos remerciements les plus chaleureux à M. $donateur->name pour son acte de noblesse et sa générosité. Son soutien contribue à améliorer le quotidien des enfants de l’orphelinat et à leur offrir un environnement plus confortable.\n\n";
    //     $contenu .= "Conclusion\n";
    //     $contenu .= "Ce geste bienveillant témoigne de l’importance de la solidarité dans notre communauté. Nous encourageons d'autres personnes à suivre l’exemple de M. $donateur->name pour continuer à apporter espoir et soutien aux plus vulnérables. L’orphelinat $beneficiaire se réjouit de cette collaboration et espère pouvoir compter sur des partenaires engagés pour l’avenir.\n\n";
    //     $contenu .= "Nous vous remercions encore une fois et restons à votre disposition pour toute future collaboration.";


    //     // Créer le rapport
    //     $rapport = Rapport::create([
    //         'contenu' => $contenu,
    //         'reservation_id' => $reservation->id,
    //         'created_by' => $user->id,
    //         'beneficiaire_id' => $beneficiaire->id,
    //         'donateur_id' => $donateur->id,
    //         'donateur_id' => $donateur->nomstructure,
    //     ]);



    //     // Retourner les informations en JSON
    //     return response()->json([
    //         'rapport' => $rapport,
    //         'donateur' => $donateur->name,
    //         'beneficiaire' => $orphelinatBeneficiaire,
    //         'dateLivraison' => $dateLivraison,
    //         'organisation' => $organisation,
    //         'contact' => $contact,
    //         'adresse' => $adresse,
    //         'detailsDon' => $detailsDon,
    //         'contenu' => $contenu,
    //         'message' => 'Rapport généré avec succès.'
    //     ]);
    // }

    // public function generateReport(Don $don, Reservation $reservation, Donateur $donateur)
    // {
    //     // Vérifier si l'utilisateur est connecté et a le rôle 'beneficiaire'
    //     $user = Auth::user();
    //     if (!$user || !$user->hasRole('beneficiaire')) {
    //         return response()->json(['message' => 'Accès refusé. Vous devez être connecté en tant qu\'beneficiare.'], 403);
    //     }

    //     // Récupérer les relations
    //     $beneficiaire = $reservation->beneficiaire;
    //     $donateur = $reservation->donateur;

    //     // Vérifier si le donateur et le bénéficiaire existent
    //     if (!$donateur) {
    //         return response()->json(['error' => 'Donateur introuvable.'], 404);
    //     }

    //     if (!$beneficiaire) {
    //         return response()->json(['error' => 'Bénéficiaire introuvable.'], 404);
    //     }

    //     // Informations de livraison
    //     $dateLivraison = now()->format('d/m/Y');
    //     $organisation = "Rahma Delivery";
    //     $contact = "+221 77 003 09 21";
    //     $adresse = "Yoff, Dakar, Sénégal";

    //     // Détails du don
    //     $detailsDon = "2 sacs de riz\n2 lits (matlat)\nVêtements divers\nCéréales";

    //     // Création du contenu du rapport
    //     $contenu = "Rapport de Don à l'Orphelinat $beneficiaire->nomstructure\n\n";
    //     $contenu .= "Donateur : $donateur->nomstructure\n";
    //     $contenu .= "Date de la livraison : $dateLivraison\n";
    //     $contenu .= "Organisme de livraison : $organisation\n";
    //     $contenu .= "Contact : $contact\n";
    //     $contenu .= "Adresse : $adresse\n";
    //     $contenu .= "Orphelinat bénéficiaire : $beneficiaire->nomstructure\n\n";
    //     $contenu .= "Objet : Rapport sur la livraison de don\n";
    //     $contenu .= "Le $dateLivraison, nous avons reçu avec grande gratitude un don généreux de M. $donateur->name destiné à l'orphelinat $beneficiaire->nomstructure. Ce don a été soigneusement livré par l’organisme $organisation, reconnu pour son engagement envers les causes humanitaires.\n\n";
    //     $contenu .= "Détails du don :\n$detailsDon\n\n";
    //     $contenu .= "Réception du don\n";
    //     $contenu .= "La livraison s’est déroulée dans de bonnes conditions. Les équipes de $organisation ont fait preuve de professionnalisme et de diligence, assurant que chaque article soit bien remis aux responsables de l’orphelinat. Les bénévoles de $beneficiaire->nomstructure ont été présents pour accueillir les dons et ont exprimé leur sincère reconnaissance.\n\n";
    //     $contenu .= "Remerciements\n";
    //     $contenu .= "Nous tenons à adresser nos remerciements les plus chaleureux à M. $donateur->name pour son acte de noblesse et sa générosité. Son soutien contribue à améliorer le quotidien des enfants de l’orphelinat et à leur offrir un environnement plus confortable.\n\n";
    //     $contenu .= "Conclusion\n";
    //     $contenu .= "Ce geste bienveillant témoigne de l’importance de la solidarité dans notre communauté. Nous encourageons d'autres personnes à suivre l’exemple de M. $donateur->name pour continuer à apporter espoir et soutien aux plus vulnérables. L’orphelinat $beneficiaire->nomstructure se réjouit de cette collaboration et espère pouvoir compter sur des partenaires engagés pour l’avenir.\n\n";
    //     $contenu .= "Nous vous remercions encore une fois et restons à votre disposition pour toute future collaboration.";

    //     // Créer le rapport
    //     $rapport = Rapport::create([
    //         'contenu' => $contenu,
    //         'reservation_id' => $reservation->id,
    //         'created_by' => $user->id,
    //         'beneficiaire_id' => $beneficiaire->id,
    //         'donateur_id' => $donateur->id, // Utilisez l'ID du donateur
    //     ]);

    //     // Retourner les informations en JSON
    //     return response()->json([
    //         'rapport' => $rapport,
    //         'donateur' => $donateur->name,
    //         'beneficiaire' => $beneficiaire->nomstructure,
    //         'dateLivraison' => $dateLivraison,
    //         'organisation' => $organisation,
    //         'contact' => $contact,
    //         'adresse' => $adresse,
    //         'detailsDon' => $detailsDon,
    //         'contenu' => $contenu,
    //         'message' => 'Rapport généré avec succès.'
    //     ]);
    // }
