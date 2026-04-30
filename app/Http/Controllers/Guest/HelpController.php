<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;

class HelpController extends Controller
{
    public function index()
    {
        return view('guest.help.index');
    }
}
