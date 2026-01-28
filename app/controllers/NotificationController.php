<?php
require_once __DIR__ . '/../core/Controller.php';

use App\Models\Notification;

class NotificationController extends Controller
{
    // 👇 THÊM HÀM NÀY (QUAN TRỌNG)
    public function userIndex()
    {
        return $this->index();
    }

    // Hàm xử lý chính
    public function index()
    {
        $userId = Auth::id();
        $model = new Notification();

        return $this->view('user/notifications/index', [
            'notifications' => $model->getByUser($userId)
        ]);
    }
}
