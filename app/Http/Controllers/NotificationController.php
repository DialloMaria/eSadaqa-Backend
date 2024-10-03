<?php
namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;

class NotificationController extends Controller
{
//     public function index()
//     {
//         // // Récupérer les notifications de l'utilisateur authentifié
//         $user = Auth::user();
//         $notifications = $user->notifications()->get();

//         // Formater les notifications pour extraire le contenu du champ `data`
//         $formattedNotifications = $notifications->map(function ($notification) {
//             return [
//                 'id' => $notification->id,
//                 'type' => $notification->type,
//                 'notifiable_id' => $notification->notifiable_id,
//                 'data' => $notification->data,  // Décoder les données JSON
//                 'read_at' => $notification->read_at,
//                 'created_at' => $notification->created_at,
//                 ''
//             ];
//         });

//         // Retourner les notifications formatées en JSON
//         return response()->json($formattedNotifications);
//     //     \Log::info('Authentication check', ['user' => auth()->user()]);

//     //     if (!auth()->check()) {
//     //         return response()->json(['message' => 'Unauthorized'], 401);
//     //     }

//     //     $notification = Notification::All();
//     //     return $this->customJsonResponse("Notifications retrieved successfully", $notification);
//     // }


// }
public function index()
{
    // Récupérer les notifications pour l'utilisateur authentifié
    $user = Auth::user();
    $notifications = $user->notifications()->with('notifiable')->get(); // Charger les notifications

    // Formater les notifications
    $formattedNotifications = $notifications->map(function ($notification) {
        // Récupérer les données de notification
        $data = $notification->data;

        // Récupérer la réservation associée au don
        $reservation = isset($data['reservation']) ? $data['reservation'] : null;

        return [
            'id' => $notification
        ];
        
    });

    return response()->json($formattedNotifications);
}




}
