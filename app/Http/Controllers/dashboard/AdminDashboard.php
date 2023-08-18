<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminDashboard extends Controller
{
      public function index(Request $request)
      {
            $data = ['title' => 'Dashboard'];
            return view('content.dashboard.admin-dashboard', $data);
      }
}
