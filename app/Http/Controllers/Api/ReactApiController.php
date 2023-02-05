<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Notice;
use App\Models\Page;
use App\Models\Project;
use App\Models\News;
use App\Models\Query;

class ReactApiController extends Controller
{
    public function getCategory(Request $request)
    {
        $categories = Category::with('children')->get();

        return response()->json(['success' => $categories], 200);

        if(isset($procategoriesjects))
        {
            return response()->json(['error' => 'No Resource Found!'], 404);
        }

    }

    public function getNotice(Request $request)
    {
        $notice = Notice::get();

        if(isset($notice))
        {
            return response()->json(['error' => 'No Resource Found!'], 404);
        }

        return response()->json(['success' => $notice], 200);

    }


    public function getPages(Request $request)
    {
    $page = Page::get();

    if(isset($page))
    {
        return response()->json(['error' => 'No Resource Found!'], 404);
    }

    return response()->json(['success' => $page], 200);

    }

    public function getProjects(Request $request)
    {

    $projects = Project::get();

    if(isset($projects))
    {
        return response()->json(['error' => 'No Resource Found!'], 404);
    }


    return response()->json(['success' => $projects], 200);

    }

    public function getNews(Request $request)
    {
    $news = News::get();

    if(isset($news))
    {
        return response()->json(['error' => 'No Resource Found!'], 404);
    }


    return response()->json(['success' => $news], 200);

    }

}
