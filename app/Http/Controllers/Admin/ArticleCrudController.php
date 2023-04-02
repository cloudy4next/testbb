<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ArticleRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use App\Notifications\NewUserRegisterNotification;
use App\Models\Funded;
use Carbon\Carbon;
use File;

/**
 * Class ArticleCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ArticleCrudController extends CrudController
{
    public $module = 'Article Title';

    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Article::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/article');
        CRUD::setEntityNameStrings('article', 'articles');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {


        $this->crud->denyAccess(['show','create', ]);

        $this->crud->enableExportButtons();

        if(backpack_user()->hasPermissionTo('Article store')) {
            $this->crud->allowAccess(['create']);
        }

        if(!(backpack_user()->hasPermissionTo('Article delete'))) {
            $this->crud->denyAccess(['delete']);
        }

        if(!(backpack_user()->hasPermissionTo('Article edit'))) {
            $this->crud->denyAccess(['update']);
        }

          $this->crud->addColumn([
          'name' => 'row_number',
          'type' => 'row_number',
          'label' => '#',
          'orderable' => false,
          ])->makeFirstColumn();

          CRUD::column('title');

          $this->crud->addColumn([
          'name' => 'category_id',
          'label' => 'Category',
          ]);

          $this->crud->addColumn([
          'name' => 'funded_id',
          'label' => 'Funded By',
          ]);

          $this->crud->addColumn([
          'name' => 'user_id',
          'label' => 'Publish By',
          ]);

          $this->crud->addColumn([
          'name' => 'created_at',
          'label' => 'Date',
          ]);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }


    public function create()
    {
        $category = Category::pluck('name', 'id');
        $funded = Funded::pluck('name', 'id');

        return view('admin.articles.create')
        ->withcategory($category)->withfunded($funded);
    }

    public function store(ArticleRequest $request)
    {
        $attachments = $request->image;
        if($attachments != NULL){
            $destinationPath = public_path() . "/uploads/articles";
            $name = $attachments->getClientOriginalName();
            $fileName = time() . '_' . $name;
            $fileName = preg_replace('/\s+/', '_', $fileName);
            $attachments->move($destinationPath, $fileName);
        }
        $articles = new Article();
        $articles->title = $request['title'];
        $articles->description = $request['description'];
        $articles->status = $request['status'];
        $articles->category_id = $request['category_id'];
        $articles->user_id = backpack_user()->id;
        $articles->funded_id = $request->funded_id;
        $articles->created_at = Carbon::now();
        $articles->image = $fileName ?? NULL;
        $articles->save();

        //Notification start
        $type = 'Created';
        $notification = User::first();
        $notification->notify(new NewUserRegisterNotification($articles, $type, $this->module));
        //notification end

        \Alert::success('articles successfully created!')->flash();

        return redirect('admin/articles');
    }

    public function edit($id)
    {
        $category = Category::pluck('name', 'id');
        $data = Article::where('id', '=', $id)->first();
        $funded = Funded::pluck('name', 'id');

        return view('admin.articles.edit')
        ->withcategory($category)
        ->withData($data)->withfunded($funded);
    }

    public function update(ArticleRequest $request, $id)
    {
        $data = Article::where('id', '=', $id)->first();

        if (File::exists(public_path('uploads/articles/' . $data->image))) {
            File::delete(public_path('uploads/articles/' . $data->image));
        }

        $attachments = $request->image;
        if($attachments != NULL){
            $destinationPath = public_path() . "/uploads/articles";
            $name = $attachments->getClientOriginalName();
            $fileName = time() . '_' . $name;
            $fileName = preg_replace('/\s+/', '_', $fileName);
            $attachments->move($destinationPath, $fileName);
        }
        $articles = Article::find($id);
        $articles->title = $request['title'];
        $articles->description = $request['description'];
        $articles->status = $request['status'];
        $articles->category_id = $request['category_id'];
        $articles->user_id = backpack_user()->id;
        $articles->funded_id = $request->funded_id;

        $articles->created_at = Carbon::now();
        $articles->image = $fileName ?? NULL;

        $articles->save();

        //Notification start
        $type = 'Created';
        $notification = User::first();
        $notification->notify(new NewUserRegisterNotification($articles, $type, $this->module));
        //notification end

        \Alert::success('articles successfully updated!')->flash();

        return redirect()->back()->withInput();
    }
}
