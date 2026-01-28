<?php
require_once __DIR__ . '/../core/Controller.php';
use App\Models\Notification;
class NotificationController extends Controller
{
    public function index()
{
    $userId = Auth::id();
    $model = new Notification();

    return $this->view('user/notifications/index', [
        'notifications' => $model->getByUser($userId)
    ]);
}
}
