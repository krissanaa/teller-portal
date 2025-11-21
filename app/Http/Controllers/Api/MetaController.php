<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BranchResource;
use App\Models\TellerPortal\Branch;
use Illuminate\Http\Request;

class MetaController extends Controller
{
    public function branches(Request $request)
    {
        $branches = Branch::with('units')
            ->orderBy('BRANCH_NAME')
            ->get();

        return BranchResource::collection($branches);
    }
}
