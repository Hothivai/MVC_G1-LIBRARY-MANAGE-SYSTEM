<?php
require_once __DIR__ . '/../core/Controller.php';

class NotificationController extends Controller
{
    // ================= USER =================
    public function userIndex()
    {
        $userId = Auth::getUserId();

        // nếu chưa đăng nhập
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
    // CHƯA làm admin notifications 
    public function adminIndex()
    {
        return $this->view('admin/notifications/index', [
            'notifications' => []
        ]);
    }

    // Form tạo notification (nếu chưa dùng thì vẫn OK)
    public function adminCreate()
    {
        return $this->view('admin/notifications/create');
    }
}
