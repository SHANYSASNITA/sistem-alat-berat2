<?php

namespace App\Http\Controllers; // Hapus "\Admin" di sini

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Karena filenya ada di resources/views/admin/dashboard/dashboard.blade.php
        return view('admin.dashboard.dashboard');
    }
}