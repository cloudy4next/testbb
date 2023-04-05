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
use Illuminate\Support\Facades\DB;
use App\Models\Article;
use App\Models\Newsletter;
use App\Models\Research;

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
        $notice = Notice::orderBy('id', 'desc')->get()->toArray();

        if (empty($notice)) {

            return response()->json(['error' => 'No Resource Found!'], 404);
        }
        $lastFive  =  array_slice($notice,0, 5, true);

        return response()->json(['success' => $notice,'lastFive' => $lastFive], 200);

    }

    public function getArticles(Request $request)
    {

        $articles = Article::orderBy('id', 'desc')->get()->toArray(); // should be articles

        if (empty($articles)) {

            return response()->json(['error' => 'No Resource Found!'], 404);
        }
        $lastFive  =  array_slice($articles,0, 5, true);

        return response()->json(['success' => $articles,'lastFive' => $lastFive], 200);

    }

        public function getPptx(Request $request)
    {
        $pptx_array =[];
        $pptx = PPTX::orderBy('id', 'desc')->get()->toArray(); // should be articles

        if (empty($pptx)){

            return response()->json(['error' => 'No Resource Found!'], 404);
        }

        foreach($pptx as $pptx_data)
        {
            $pptx_array[] = [
                    'id' =>$pptx_data['id'],
                    'title' => $pptx_data['name'],
                    'image' =>'/cover'. $pptx_data['image'],
                    'pptx' =>'/pptx'. $pptx_data['pptx'],
                    'category_id' => $pptx_data['category_id'],
                    'user_id' => $pptx_data['user_id'],
                    'created_at' => $pptx_data['created_at'],


            ];

        }

        $lastFive  =  array_slice($pptx_array,0, 5, true);

        return response()->json(['success' => $pptx_array,'lastFive' => $lastFive], 200);

    }

    public function getNews(Request $request)
    {
        $news = News::orderBy('id', 'desc')->get()->toArray();

        if (empty($news)) {

            return response()->json(['error' => 'No Resource Found!'], 404);
        }
        $lastFive  =  array_slice($news,0, 5, true);

        return response()->json(['success' => $news,'lastFive' => $lastFive], 200);

    }

    public function getPages(Request $request)
    {
        $page = Page::orderBy('id', 'desc')->get()->toArray();
        // $view_count
        if (empty($page)) {

            return response()->json(['error' => 'No Resource Found!'], 404);
        }
        $lastFive  =  array_slice($page,0, 5, true);

        return response()->json(['success' => $page,'lastFive' => $lastFive], 200);

    }
    public function getProjects(Request $request)
    {

        $projects = Project::orderBy('id', 'desc')->get()->toArray();

        if (empty($projects)) {

            return response()->json(['error' => 'No Resource Found!'], 404);
        }
        $lastFive  =  array_slice($projects,0, 5, true);

        return response()->json(['success' => $projects,'lastFive' => $lastFive], 200);

    }



    public function getResearch(Request $request)
    {

        $research = Research::orderBy('id', 'desc')->get()->toArray();
        $removePath = [];

        foreach ($research as $key) {
            $tokens = explode('//', $key['image']);
            $img = trim(end($tokens));
            $removePath [] = [

                "id"=> $key["id"],
                "count"=>$key["count"],
                "user_id"=> $key["user_id"],
                "category_id"=> $key["category_id"],
                "funded_id"=> $key["funded_id"],
                "title"=> $key["title"],
                "description"=>$key["description"],
                "image"=>$img,
                "author"=> $key["author"],
                "status"=> $key["status"],
                "created_at"=> $key["created_at"],
                "updated_at"=> $key["updated_at"],
            ];
        }
        if (empty($removePath)) {

            return response()->json(['error' => 'No Resource Found!'], 404);
        }
        $lastFive  =  array_slice($removePath,0, 5, true);

        return response()->json(['success' => $removePath,'lastFive' => $lastFive], 200);

    }

        public function getQuery(Request $request)
    {

        $query = Query::all();

        if($query ->count() == 0)
        {
            return response()->json(['error' => 'No Resource Found!'], 404);
        }


        return response()->json(['success' => $query], 200);

    }



    public function postQueries(Request $request)
    {

        $validator = Validator::make($request->all(),
        ['name'=> 'required|string|max:255',
        'email'=> 'required|string|email|max:255',
        'mobile'=> 'required|string|max:15',
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
        $queryStore->mobile = $request->mobile;
        $queryStore->title = $request->title;
        $queryStore->description = $request->description;
        $queryStore->created_at = Carbon::now();
        $queryStore->save();

        return response()->json(['success' => 'Data Saved Successfully'], 200);

    }



    public function getSinglePage(Request $request)
    {
        $page = Page::where('id' ,$request->id)->first();
        if (empty($page)) {

            return response()->json(['error' => 'No Resource Found!'], 404);
        }
        $page->count += 1;
        $page->save();

        return response()->json(['success' => $page], 200);

    }
    public function getSingleResearch(Request $request)
    {
        $research = Research::where('id' ,$request->id)->first();
        if (empty($research)) {

            return response()->json(['error' => 'No Resource Found!'], 404);
        }
        $research->count += 1;
        $research->save();

        $tokens = explode('//', $research->image);
        $img = trim(end($tokens));

        $removePath [] = [
                "id"=> $research->id,
                "count"=>$research->count,
                "user_id"=> $research->user_id,
                "category_id"=> $research->category_id,
                "funded_id"=> $research->funded_id,
                "title"=> $research->title,
                "description"=>$research["description"],
                "image"=>$img,
                "author"=> $research->author,
                "status"=> $research->status,
                "created_at"=> $research->created_at,
            ];

        return response()->json(['success' => $removePath], 200);

    }
    public function getSingleNotice(Request $request)
    {
        $notice = notice::where('id' ,$request->id)->first();
        if (empty($notice)) {

            return response()->json(['error' => 'No Resource Found!'], 404);
        }
        $notice->count += 1;
        $notice->save();

        return response()->json(['success' => $notice], 200);

    }
    public function getSingleProject(Request $request)
    {
        $project = Project::where('id' ,$request->id)->first();
        if (empty($project)) {

            return response()->json(['error' => 'No Resource Found!'], 404);
        }
        $project->count += 1;
        $project->save();

        return response()->json(['success' => $project], 200);

    }
    public function getSingleNews(Request $request)
    {
        $news = News::where('id' ,$request->id)->first();
        if (empty($news)) {

            return response()->json(['error' => 'No Resource Found!'], 404);
        }
        $news->count += 1;
        $news->save();

        return response()->json(['success' => $news], 200);

    }
    public function getSingleAritcle(Request $request)
    {
        $article = Article::where('id' ,$request->id)->first();
        if (empty($article)) {

            return response()->json(['error' => 'No Resource Found!'], 404);
        }
        $article->count += 1;
        $article->save();

        return response()->json(['success' => $article], 200);

    }
    public function getSinglePptx(Request $request)
    {
        $pptx = PPTX::where('id' ,$request->id)->first();
        if (empty($pptx)) {

            return response()->json(['error' => 'No Resource Found!'], 404);
        }
        $pptx->count += 1;
        $pptx->save();

        $change_name_to_title =[
            "id"=> $pptx->id,
            "count"=> $pptx-> count,
            "user_id"=> $pptx->user_id,
            "category_id"=> $pptx->category_id,
            "title"=> $pptx->name,
            "image"=> $pptx->image,
            "created_at"=> $pptx->created_at,
            "pptx"=> $pptx->pptx,
        ];

        return response()->json(['success' => $change_name_to_title], 200);

    }

    public function getSearch(Request $request)
    {
    $searchTerm = $request->input('q');
        // dd($searchTerm);
        $select_array =['id', 'title', 'description','category_id','user_id','image','status', 'created_at', 'updated_at'];

        $results = DB::table('projects')
                        ->select($select_array)
                        ->where('title', 'like', '%'.$searchTerm.'%')
                        ->union(
                            DB::table('notices')
                                ->select($select_array)
                                ->where('title', 'like', '%'.$searchTerm.'%')
                        )
                        ->union(
                            DB::table('pages')
                                ->select($select_array)
                                ->where('title', 'like', '%'.$searchTerm.'%')
                        )->union(
                            DB::table('articles')
                                ->select($select_array)
                                ->where('title', 'like', '%'.$searchTerm.'%')
                        )->union(
                            DB::table('news')
                                ->select($select_array)
                                ->where('title', 'like', '%'.$searchTerm.'%')
                        )
                        ->orderBy('created_at', 'desc')
                        ->get();

        if(count($results)== 0)
        {
            return response()->json(['error' => 'Nothing Found'], 401);
        }

        return response()->json(['success' => $results], 200);

    }


    public function storeNewsletter(Request $request)
    {

        $validator = Validator::make($request->all(),
        [
        'email'=> 'required|string|email|max:255',
        ]);

        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $newsletter = new Newsletter();
        $newsletter->email = $request->email;
        $newsletter->save();

        return response()->json(['success' => 'Sucessfully Subscribed!'], 200);
    }


}
