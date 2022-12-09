<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

  public function index(){
    return inertia('Index');
  }
  public function login(Request $request){
    \Log::info($request['email']);
    return true;
  }
}
