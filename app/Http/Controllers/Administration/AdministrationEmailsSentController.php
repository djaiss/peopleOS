<?php

declare(strict_types=1);

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\EmailSent;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdministrationEmailsSentController extends Controller
{
    public function index(): View
    {
        $emailsSent = EmailSent::where('user_id', Auth::user()->id)
            ->with('person')
            ->orderBy('sent_at', 'desc')
            ->cursorPaginate(10);

        return view('administration.emails-sent.index', [
            'emails_sent' => $emailsSent,
        ]);
    }
}
