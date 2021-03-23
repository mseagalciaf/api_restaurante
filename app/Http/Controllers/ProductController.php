<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return Product::get();
    }

    public function create()
    {
        return "Controlador Product: metodo create";
    }

    public function store()
    {
        return "Controlador Product: metodo store";
    }

    public function show()
    {
        return "Controlador Product: metodo show";
    }

    public function edit()
    {
        return "Controlador Product: metodo edit";
    }

    public function update()
    {
        return "Controlador Product: metodo update";
    }
    
    public function destroy()
    {
        return "Controlador Product: metodo destroy";
    }
}
