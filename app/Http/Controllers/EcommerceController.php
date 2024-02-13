<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EcommerceController extends Controller
{
    public function index () {
        return inertia('Admin/Ecommerce/Index');
    }
}
