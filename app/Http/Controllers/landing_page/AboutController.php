<?php

namespace App\Http\Controllers\landing_page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ProfilKpriService;
use Illuminate\Support\Facades\Route;

class AboutController extends Controller
{

    protected $profilService;
    private $route;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->profilService = new ProfilKpriService;
        $this->route = Route::currentRouteName();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = [
            'title' => 'Profil',
            'profil' => $this->profilService->getAllData(1)
        ];
        return view('content.landing-page.profil', $data);
    }
}
