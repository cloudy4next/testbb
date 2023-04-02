<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Notice;
use App\Models\Page;
use App\Models\Project;
use App\Models\News;
use App\Models\PPTX;
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
        $notice = Notice::all();

        if($notice->count() == 0)
        {
            return response()->json(['error' => 'No Resource Found!'], 404);
        }

        return response()->json(['success' => $notice], 200);

    }

    public function getArticles(Request $request)
    {

        $articles = News::all()->toArray(); // should be articles

        if (empty($articles)) {

            return response()->json(['error' => 'No Resource Found!'], 404);
        }
        $lastFive  =  array_slice($articles, -5);

        return response()->json(['success' => $articles,'articles' => $lastFive], 200);

    }

        public function getPptx(Request $request)
    {

        $pptx = PPTX::all(); // should be articles

        if (empty($pptx)) {

            return response()->json(['error' => 'No Resource Found!'], 404);
        }

        foreach($pptx as $pptx_data)
        {
            // dd($pptx_data);
            $pptx_array[] = [
                    'name' => $pptx_data->name,
                    'image' =>url('uploads/pptx/'.$pptx_data->path),
                    'category_id' =>$pptx_data->category_id,

            ];

        }

        $lastFive  =  array_slice($pptx_array, -5);

        return response()->json(['success' => $pptx_array,'articles' => $lastFive], 200);

    }

    public function getNews(Request $request)
    {
        $news = News::all()->toArray();

        if (empty($news)) {

            return response()->json(['error' => 'No Resource Found!'], 404);
        }
        $lastFive  =  array_slice($news, -5);

        return response()->json(['success' => $news,'lastFive' => $lastFive], 200);

    }

    public function getPages(Request $request)
    {
        $page = Page::all();

        if($page->count() == 0)
        {
            return response()->json(['error' => 'No Resource Found!'], 404);
        }

        return response()->json(['success' => $page], 200);

    }

    public function getProjects(Request $request)
    {

        $projects = Project::all();

        if($projects ->count() == 0)
        {
            return response()->json(['error' => 'No Resource Found!'], 404);
        }


        return response()->json(['success' => $projects], 200);

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
