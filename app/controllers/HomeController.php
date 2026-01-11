<?php

class HomeController extends Controller
{
    public function index()
    {
        return $this->view('home/index');
    }

    public function about()
    {
        return $this->view('home/about');
    }
}
