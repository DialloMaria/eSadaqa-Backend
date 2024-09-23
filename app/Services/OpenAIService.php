<?php

namespace App\Services;

use OpenAI\Client;

class OpenAIService
{
    protected $client;

    public function __construct()
    {
        $this->client = \OpenAI::client(config('services.openai.api_key'));
    }

    public function generateReport(array $donData): string
    {
        $prompt = "
        Rapport de Don à l'Orphelinat Keur Mariama\n
        Donateur : {$donData['donateur']}\n
        Date de la livraison : {$donData['date_livraison']}\n
        Organisme de livraison : {$donData['organisme']}\n
        Contact : {$donData['contact']}\n
        Adresse : {$donData['adresse']}\n
        Orphelinat bénéficiaire : {$donData['orphelinat']}\n
        \n
        Objet : Rapport sur la livraison de don\n
        Le {$donData['date_livraison']}, nous avons reçu avec grande gratitude un don généreux de M. {$donData['donateur']} destiné à l'orphelinat {$donData['orphelinat']}. Ce don a été soigneusement livré par l’organisme {$donData['organisme']}, reconnu pour son engagement envers les causes humanitaires.\n
        \n
        Détails du don :
        {$donData['details_don']}\n
        \n
        Réception du don\n
        La livraison s’est déroulée dans de bonnes conditions. Les équipes de {$donData['organisme']} ont fait preuve de professionnalisme et de diligence, assurant que chaque article soit bien remis aux responsables de l’orphelinat. Les bénévoles de {$donData['orphelinat']} ont été présents pour accueillir les dons et ont exprimé leur sincère reconnaissance.\n
        \n
        Remerciements\n
        Nous tenons à adresser nos remerciements les plus chaleureux à M. {$donData['donateur']} pour son acte de noblesse et sa générosité. Son soutien contribue à améliorer le quotidien des enfants de l’orphelinat et à leur offrir un environnement plus confortable.\n
        \n
        Conclusion\n
        Ce geste bienveillant témoigne de l’importance de la solidarité dans notre communauté. Nous encourageons d'autres personnes à suivre l’exemple de M. {$donData['donateur']} pour continuer à apporter espoir et soutien aux plus vulnérables. L’orphelinat {$donData['orphelinat']} se réjouit de cette collaboration et espère pouvoir compter sur des partenaires engagés pour l’avenir.\n
        \n
        Cordialement,\n
        [Nom du responsable]\n
        {$donData['orphelinat']}\n
        [Contact de l'orphelinat]
        ";

        // Optionnel : si tu veux que OpenAI améliore ou complète le contenu
        $response = $this->client->completions()->create([
            'model' => 'gpt-3.5-turbo',
            'prompt' => $prompt,
            'max_tokens' => 250,
        ]);

        return $response['choices'][0]['text'];
    }
}
