<?php

namespace App\Http\Controllers\landing_page;

use Illuminate\Http\Request;
use App\Services\BeritaService;
use App\Services\LandingWebService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class BlogController extends Controller
{
    protected $servicesLanding;
    private $route;
    protected $beritaService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->servicesLanding = new LandingWebService;
        $this->beritaService = new BeritaService;
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
            'title' => 'Blog',
            'blogs' => $this->beritaService->getBerita()
        ];
        return view('content.landing-page.blog', $data);
    }

    public function show(Request $request, $slug)
    {
        $data = [
            'title' => 'Post',
            'berita' => $this->beritaService->getDataBeritaSlug($slug),
            'blogs' => $this->beritaService->getBerita()
        ];
        return view('content.landing-page.show-blog', $data);
    }
}
