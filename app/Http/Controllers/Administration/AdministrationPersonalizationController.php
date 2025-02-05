<?php

declare(strict_types=1);

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\Gender;
use App\Models\MaritalStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdministrationPersonalizationController extends Controller
{
    public function index(): View
    {
        $genders = Gender::where('account_id', Auth::user()->account_id)
            ->orderBy('position')
            ->get()
            ->map(fn (Gender $gender): array => [
                'id' => $gender->id,
                'name' => $gender->name,
            ]);

        $maritalStatuses = MaritalStatus::where('account_id', Auth::user()->account_id)
            ->orderBy('position')
            ->get()
            ->map(fn (MaritalStatus $maritalStatus): array => [
                'id' => $maritalStatus->id,
                'name' => $maritalStatus->name,
                'can_be_deleted' => $maritalStatus->can_be_deleted,
            ]);

        return view('administration.personalization.index', [
            'genders' => $genders,
            'maritalStatuses' => $maritalStatuses,
        ]);
    }
}
