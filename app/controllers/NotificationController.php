<?php
require_once __DIR__ . '/../core/Controller.php';

use App\Models\Notification;

class NotificationController extends Controller
{
    public function userIndex()
    {
        $userId = Auth::id();

        $notificationModel = new Notification();
        $notifications = $notificationModel->getByUser($userId);

        return $this->view('user/notifications/index', [
            'notifications' => $notifications
        ]);
    }
}
