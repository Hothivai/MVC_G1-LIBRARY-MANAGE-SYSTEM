<?php
require_once __DIR__ . '/../core/Controller.php';

class NotificationController extends Controller
{
    public function index()
    {
        return $this->userIndex();
    }

    // ================= USER =================
    public function userIndex()
    {
        $userId = Auth::getUserId();

        if (!$userId) {
            return $this->view('user/notifications/index', [
                'notifications' => []
            ]);
        }

        $notificationModel = new Notification();
        $notifications = $notificationModel->getByUser($userId);

        return $this->view('user/notifications/index', [
            'notifications' => $notifications
        ]);
    }

    // ================= ADMIN =================
    public function adminIndex()
    {
        return $this->view('admin/notifications/index', [
            'notifications' => []
        ]);
    }

    public function adminCreate()
    {
        return $this->view('admin/notifications/create');
    }
}
