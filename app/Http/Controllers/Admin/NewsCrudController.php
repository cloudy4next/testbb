<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\NewsRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\News;
use App\Models\Category;
use App\Models\User;
use App\Notifications\NewUserRegisterNotification;
use App\Models\Funded;
use Carbon\Carbon;
use File;

/**
 * Class NewsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class NewsCrudController extends CrudController
{
        public $module = 'News Title';
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\News::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/news');
        CRUD::setEntityNameStrings('news', 'news');
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

        if(backpack_user()->hasPermissionTo('News store')) {
            $this->crud->allowAccess(['create']);
        }

        if(!(backpack_user()->hasPermissionTo('News delete'))) {
            $this->crud->denyAccess(['delete']);
        }

        if(!(backpack_user()->hasPermissionTo('News edit'))) {
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
    }

    public function create()
    {
        $category = Category::pluck('name', 'id');
        $funded = Funded::pluck('name', 'id');

        return view('admin.news.create')
        ->withcategory($category)->withfunded($funded);
    }

    public function store(newsRequest $request)
    {
        $attachments = $request->image;
        if($attachments != NULL){
            $destinationPath = public_path() . "/uploads/news";
            $name = $attachments->getClientOriginalName();
            $fileName = time() . '_' . $name;
            $fileName = preg_replace('/\s+/', '_', $fileName);
            $attachments->move($destinationPath, $fileName);
        }
        $news = new News();
        $news->title = $request['title'];
        $news->description = $request['description'];
        $news->status = $request['status'];
        $news->category_id = $request['category_id'];
        $news->user_id = backpack_user()->id;
        $news->funded_id = $request->funded_id;
        $news->created_at = Carbon::now();
        $news->image = $fileName ?? NULL;
        $news->save();

        //Notification start
        $type = 'Created';
        $notification = User::first();
        $notification->notify(new NewUserRegisterNotification($news, $type, $this->module));
        //notification end

        \Alert::success('news successfully created!')->flash();

        return redirect('admin/news');
    }

    public function edit($id)
    {
        $category = Category::pluck('name', 'id');
        $data = News::where('id', '=', $id)->first();
        $funded = Funded::pluck('name', 'id');

        return view('admin.news.edit')
        ->withcategory($category)
        ->withData($data)->withfunded($funded);
    }

    public function update(newsRequest $request, $id)
    {
        $data = News::where('id', '=', $id)->first();

        if (File::exists(public_path('uploads/news/' . $data->image))) {
            File::delete(public_path('uploads/news/' . $data->image));
        }

        $attachments = $request->image;
        if($attachments != NULL){
            $destinationPath = public_path() . "/uploads/news";
            $name = $attachments->getClientOriginalName();
            $fileName = time() . '_' . $name;
            $fileName = preg_replace('/\s+/', '_', $fileName);
            $attachments->move($destinationPath, $fileName);
        }
        $news = News::find($id);
        $news->title = $request['title'];
        $news->description = $request['description'];
        $news->status = $request['status'];
        $news->category_id = $request['category_id'];
        $news->user_id = backpack_user()->id;
        $news->funded_id = $request->funded_id;

        $news->created_at = Carbon::now();
        $news->image = $fileName ?? NULL;

        $news->save();

        //Notification start
        $type = 'Created';
        $notification = User::first();
        $notification->notify(new NewUserRegisterNotification($news, $type, $this->module));
        //notification end

        \Alert::success('news successfully updated!')->flash();

        return redirect()->back()->withInput();
    }

}
