<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\NoticeRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Notice;
use App\Models\Category;
use App\Models\Funded;
use App\Models\User;
use Carbon\Carbon;
use File;
use App\Notifications\NewUserRegisterNotification;

/**
 * Class NoticeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class NoticeCrudController extends CrudController
{
    public $module = 'Notice Title';

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
        CRUD::setModel(\App\Models\Notice::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/notice');
        CRUD::setEntityNameStrings('notice', 'notices');
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

        if(backpack_user()->hasPermissionTo('Notice store')) {
            $this->crud->allowAccess(['create']);
        }

        if(!(backpack_user()->hasPermissionTo('Notice delete'))) {
        $this->crud->denyAccess(['delete']);
        }

        if(!(backpack_user()->hasPermissionTo('Notice edit'))) {
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

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
   public function create()
   {
    $category = Category::pluck('name', 'id');
    $funded = Funded::pluck('name', 'id');

    return view('admin.notice.create')
    ->withcategory($category)->withfunded($funded);
   }

   public function store(noticeRequest $request)
   {
    $attachments = $request->image;
    if($attachments != NULL){
        $destinationPath = public_path() . "/uploads/notice";
        $name = $attachments->getClientOriginalName();
        $fileName = time() . '_' . $name;
        $fileName = preg_replace('/\s+/', '_', $fileName);
        $attachments->move($destinationPath, $fileName);
    }
    $notice = new Notice();
    $notice->title = $request['title'];
    $notice->description = $request['description'];
    $notice->status = $request['status'];
    $notice->category_id = $request['category_id'];
    $notice->user_id = backpack_user()->id;
    $notice->funded_id = $request->funded_id;
    $notice->created_at = Carbon::now();
    $notice->image = $fileName ?? NULL;
    $notice->save();

    //Notification start
    $type = 'Created';
    $notification = User::first();
    $notification->notify(new NewUserRegisterNotification($notice, $type, $this->module));
    //notification end

    \Alert::success('notice successfully created!')->flash();

    return redirect('admin/notice');
   }

   public function edit($id)
   {
    $category = Category::pluck('name', 'id');
    $data = Notice::where('id', '=', $id)->first();
    $funded = Funded::pluck('name', 'id');

    return view('admin.notice.edit')
    ->withcategory($category)
    ->withData($data)->withfunded($funded);
   }

   public function update(noticeRequest $request, $id)
   {
        // dd($request->all());
        $data = Notice::where('id', '=', $id)->first();

        if (File::exists(public_path('uploads/notice/' . $data->image))) {
            File::delete(public_path('uploads/notice/' . $data->image));
        }

        $attachments = $request->image;
        if($attachments != NULL){
            $destinationPath = public_path() . "/uploads/notice";
            $name = $attachments->getClientOriginalName();
            $fileName = time() . '_' . $name;
            $fileName = preg_replace('/\s+/', '_', $fileName);
            $attachments->move($destinationPath, $fileName);
        }
        $notice = Notice::find($id);
        $notice->title = $request['title'];
        $notice->description = $request['description'];
        $notice->status = $request['status'];
        $notice->category_id = $request['category_id'];
        $notice->user_id = backpack_user()->id;
        $notice->funded_id = $request->funded_id;

        $notice->created_at = Carbon::now();
        $notice->image = $fileName ?? NULL;

        $notice->save();

        //Notification start
        $type = 'Updated';
        $notification = User::first();
        $notification->notify(new NewUserRegisterNotification($notice, $type, $this->module));
        //notification end

        \Alert::success('notice successfully updated!')->flash();

        return redirect()->back()->withInput();
   }
}
