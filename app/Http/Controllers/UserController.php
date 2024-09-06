<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UsagerRequest;
use Auth;
use Log;

use App\Models\Usager;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
public function index()
{
    $users=Usagers::all();
}

public function store (Request $request)
{

    
}

}
