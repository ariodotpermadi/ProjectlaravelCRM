<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        return '<h1>Saya siswa dari controller</h1>';
    }

    public function detail($id)
    {
        return "<h1>Saya siswa dari controller dengan ID $id</h1>";
    }
}
