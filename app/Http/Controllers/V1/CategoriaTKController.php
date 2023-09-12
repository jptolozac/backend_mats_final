<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\CategoriaTK;
use Illuminate\Http\Request;

class CategoriaTKController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $categoriaTK)
    {
        return CategoriaTK::find($categoriaTK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategoriaTK $categoriaTK)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoriaTK $categoriaTK)
    {
        //
    }
}
