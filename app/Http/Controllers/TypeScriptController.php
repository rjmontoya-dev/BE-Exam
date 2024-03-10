<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TypeScriptController extends Controller
{
    public function index(){
        return inertia('Admin/Typescript/main');
    }
}
