<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BibliotecarioController;


class BaseController extends Controller
{
    public function index_general()
    {
        return view('general');
    }
}
