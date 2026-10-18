<?php

namespace App\Http\Controllers\Exoskeletons;

use App\Http\Controllers\Controller;
use App\Models\Scheme;
use Inertia\Response;

class ExoskeletonController extends Controller
{

    public function index()
    {
        return Scheme::where("official", true)->where("completed", true);
    }
}
