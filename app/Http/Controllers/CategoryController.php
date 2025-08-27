<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // Alleen ingelogde gebruikers mogen categories ophalen
    public function index(Request $request)
    {
        return Category::all();
    }
}