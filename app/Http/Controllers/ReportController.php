<?php

namespace App\Http\Controllers;

use App\Models\Rapport;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\ReportController;


class ReportController extends Controller
{
    // protected $openAIService;

    // public function __construct(OpenAIService $openAIService)
    // {
    //     $this->openAIService = $openAIService;
    // }

    // public function generate(Request $request)
    // {
    //     // Valider les données du formulaire
    //     $request->validate([
    //         'donateur' => 'required|string',
    //         'date_livraison' => 'required|date',
    //         'organisme' => 'required|string',
    //         'contact' => 'required|string',
    //         'adresse' => 'required|string',
    //         'orphelinat' => 'required|string',
    //         'details_don' => 'required|string',
    //     ]);

    //     // Récupérer les données de la requête
    //     $donData = [
    //         'donateur' => $request->input('donateur'),
    //         'date_livraison' => $request->input('date_livraison'),
    //         'organisme' => $request->input('organisme'),
    //         'contact' => $request->input('contact'),
    //         'adresse' => $request->input('adresse'),
    //         'orphelinat' => $request->input('orphelinat'),
    //         'details_don' => $request->input('details_don'),
    //     ];

    //     // Générer le rapport
    //     $generatedReport = $this->openAIService->generateReport($donData);

    //     // Retourner le rapport sous forme de JSON
    //     return response()->json([
    //         'status' => 'success',
    //         'report' => $generatedReport
    //     ], 200);
    // }


    public function generateReport($don)
{
    // Trouver la réservation associée au don
    $reservation = Reservation::where('don_id', $don->id)->first();
    $beneficiaire = $reservation->beneficiaire; // Bénéficiaire associé
    $donateur = $don->donateur; // Donateur associé

    // Récupérer les informations nécessaires
    $dateLivraison = now()->format('d/m/Y'); // Format de date
    $organisation = "Rahma Delivry"; // Nom de l'organisme
    $contact = "+221 77 003 09 21"; // Contact
    $adresse = "Yoff, Dakar, Sénégal"; // Adresse
    $orphelinatBeneficiaire = $beneficiaire->name; // Nom de l'orphelinat

    // Détails du don (ajuste selon ta logique pour récupérer les articles)
    $detailsDon = "2 sacs de riz\n2 lits (matlat)\nVêtements divers\nCéréales";

    // Création du contenu du rapport
    $contenu = "Rapport de Don à l'Orphelinat $orphelinatBeneficiaire\n\n";
    $contenu .= "Donateur : $donateur->name\n";
    $contenu .= "Date de la livraison : $dateLivraison\n";
    $contenu .= "Organisme de livraison : $organisation\n";
    $contenu .= "Contact : $contact\n";
    $contenu .= "Adresse : $adresse\n";
    $contenu .= "Orphelinat bénéficiaire : $orphelinatBeneficiaire\n\n";
    $contenu .= "Objet : Rapport sur la livraison de don\n";
    $contenu .= "Le $dateLivraison, nous avons reçu avec grande gratitude un don généreux de M. $donateur->name destiné à l'orphelinat $orphelinatBeneficiaire. Ce don a été soigneusement livré par l’organisme $organisation, reconnu pour son engagement envers les causes humanitaires.\n\n";
    $contenu .= "Détails du don :\n$detailsDon\n\n";
    $contenu .= "Réception du don\n";
    $contenu .= "La livraison s’est déroulée dans de bonnes conditions. Les équipes de $organismeLivraison ont fait preuve de professionnalisme et de diligence, assurant que chaque article soit bien remis aux responsables de l’orphelinat. Les bénévoles de $orphelinatBeneficiaire ont été présents pour accueillir les dons et ont exprimé leur sincère reconnaissance.\n\n";
    $contenu .= "Remerciements\n";
    $contenu .= "Nous tenons à adresser nos remerciements les plus chaleureux à M. $donateur->name pour son acte de noblesse et sa générosité. Son soutien contribue à améliorer le quotidien des enfants de l’orphelinat et à leur offrir un environnement plus confortable.\n\n";
    $contenu .= "Conclusion\n";
    $contenu .= "Ce geste bienveillant témoigne de l’importance de la solidarité dans notre communauté. Nous encourageons d'autres personnes à suivre l’exemple de M. $donateur->name pour continuer à apporter espoir et soutien aux plus vulnérables. L’orphelinat $orphelinatBeneficiaire se réjouit de cette collaboration et espère pouvoir compter sur des partenaires engagés pour l’avenir.\n\n";
    $contenu .= "Nous vous remercions encore une fois et restons à votre disposition pour toute future collaboration.";

    // Créer le rapport
    $rapport = Rapport::create([
        'contenu' => $contenu,
        'reservation_id' => $reservation->id,
    ]);

    return $rapport;
}

}
