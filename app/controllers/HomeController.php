<?php
class HomeController extends Controller
{
    public function index()
    {
        $user = $_SESSION['user'] ?? null;

        $this->view('home/index', [
            'user' => $user
        ]);
    }
}
?>