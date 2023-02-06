<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\News;

class DashBoardController extends Controller
{
    public function dashboard(Request $request)
    {
        $totalArticle =  News::all();
        $totalProject= Project::all();

        // dd(count($totalArticle));
        $totalCountArticle =count($totalArticle);
        $totalCountProject =count($totalProject);

        return view('vendor.backpack.base.admin_dashboard',
        [ 'totalCountArticle' => $totalCountArticle,
        'totalCountProject' => $totalCountProject,
            ]);

    }
    public function myAccount(Request $request)
    {
        return view('admin.my_account');

    }
}
