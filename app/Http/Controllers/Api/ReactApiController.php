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
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ReactApiController extends Controller
{
    public function getCategory(Request $request)
    {
        $categories = Category::with('children')->get();


        if($categories->count() == 0)
        {
            return response()->json(['error' => 'No Resource Found!'], 404);
        }

        return response()->json(['success' => $categories], 200);


    }

    public function getNotice(Request $request)
    {
        $notice = Notice::get();

        if($notice->count() == 0)
        {
            return response()->json(['error' => 'No Resource Found!'], 404);
        }

        return response()->json(['success' => $notice], 200);

    }


    public function getPages(Request $request)
    {
        $page = Page::get();

        if($page->count() == 0)
        {
            return response()->json(['error' => 'No Resource Found!'], 404);
        }

        return response()->json(['success' => $page], 200);

    }

    public function getProjects(Request $request)
    {

        $projects = Project::get();

        if($projects ->count() == 0)
        {
            return response()->json(['error' => 'No Resource Found!'], 404);
        }


        return response()->json(['success' => $projects], 200);

    }

    public function getNews(Request $request)
    {
        $news = News::get();

        if($news->count() == 0)
        {
            return response()->json(['error' => 'No Resource Found!'], 404);
        }


        return response()->json(['success' => $news], 200);

    }

    public function postQueries(Request $request)
    {
        // dd('ok');
        $validator = Validator::make($request->all(),
        ['name'=> 'required|string|max:255',
        'email'=> 'required|string|email|max:255',
        'phone'=> 'required|string|max:15',
        'title'=> 'required|string|max:255',
        'description'=> 'required|min:3|max:1000',
        ]);

        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $queryStore = new Query();
        $queryStore->name = $request->name;
        $queryStore->email = $request->email;
        $queryStore->phone = $request->phone;
        $queryStore->title = $request->title;
        $queryStore->description = $request->description;
        $queryStore->created_at = Carbon::now();
        $queryStore->save();

        return response()->json(['success' => 'Data Saved Successfully'], 200);

    }

}
