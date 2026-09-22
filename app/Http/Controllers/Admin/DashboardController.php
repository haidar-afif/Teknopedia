<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminCmsService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected AdminCmsService $cmsService;

    public function __construct(AdminCmsService $cmsService)
    {
        $this->cmsService = $cmsService;
    }

    public function index()
    {
        $stats = $this->cmsService->getDashboardStats();
        return view('admin.dashboard', compact('stats'));
    }
}
