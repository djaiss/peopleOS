<?php

namespace App\Http\Controllers\Vaults;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VaultController extends Controller
{
    public function index(Request $request): View
    {
        return view('vaults.index', [
            'user' => $request->user(),
        ]);
    }

    public function new(): View
    {
        return view('vaults.new');
    }
}
