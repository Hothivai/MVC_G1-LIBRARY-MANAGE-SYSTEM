<?php
require_once __DIR__ . '/../core/Controller.php';

class NotificationController extends Controller
{
    // ---------- ADMIN METHODS ----------

    // action: admin_notifications_index
    public function adminIndex()
    {
        $this->requireAdmin();
        $this->view('admin/notifications/index');
    }

    // action: admin_notifications_create
    public function adminCreate()
    {
        $this->requireAdmin();
        $this->view('admin/notifications/create');
    }

    // ---------- USER METHODS ----------

    // action: user_notifications_index
    public function userIndex()
    {
        $this->requireAuth();
        $this->view('user/notifications/index');
    }
}