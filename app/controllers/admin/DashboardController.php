<?php

class Admin_DashboardController extends Controller
{
    public function index()
    {
        // Tổng quan hệ thống
        return $this->view('admin/dashboard/index');
    }
}
