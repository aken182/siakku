<?php

namespace App\Http\Controllers\landing_page;

use Illuminate\Http\Request;
use App\Services\LandingWebService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class BlogController extends Controller
{
    protected $servicesLanding;
    private $route;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->servicesLanding = new LandingWebService;
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
            'title' => 'Blog'
        ];
        return view('content.landing-page.blog', $data);
    }
}
