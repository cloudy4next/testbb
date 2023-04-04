<?php

namespace App\Http\Controllers\Admin;

use App\Notifications\NewUserRegisterNotification;
use App\Http\Requests\PageRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Page;
use App\Models\User;
use App\Models\Category;
use App\Repositories\page\pageInterface;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Illuminate\Http\Request;
use Carbon\Carbon;
use File;

/**
 * Class PageCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PageCrudController extends CrudController
{
    public  $module = 'Page Title';

    use CreateOperation;
    use ListOperation;
    use ShowOperation;
    use UpdateOperation;
    use DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Page::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/page');
        CRUD::setEntityNameStrings('page', 'pages');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->denyAccess(['show', 'create',]);

        $this->crud->enableExportButtons();

        if (backpack_user()->hasPermissionTo('Page store')) {
            $this->crud->allowAccess(['create']);
        }

        if (!(backpack_user()->hasPermissionTo('Page delete'))) {
            $this->crud->denyAccess(['delete']);
        }

        if (!(backpack_user()->hasPermissionTo('Page edit'))) {
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

        return view('admin.page.create')
            ->withcategory($category);
    }

    public function store(PageRequest $request)
    {
        $attachments = $request->image;
        if ($attachments != NULL) {
            $destinationPath = public_path() . "/uploads/pages";
            $name = $attachments->getClientOriginalName();
            $fileName = time() . '_' . $name;
            $fileName = preg_replace('/\s+/', '_', $fileName);
            $attachments->move($destinationPath, $fileName);
        }
        $page = new page();
        $page->title = $request['title'];
        $page->description = $request['description'];
        $page->status = $request['status'];
        $page->category_id = $request['category_id'];
        $page->user_id = backpack_user()->id;
        $page->created_at = Carbon::now();
        $page->image = $fileName ?? NULL;
        $page->save();

        //Notification start
        $type = 'Created';
        $notification = User::first();
        $notification->notify(new NewUserRegisterNotification($page, $type, $this->module));
        //notification end

        \Alert::success('page successfully created!')->flash();

        return redirect('admin/page');
    }

    public function edit($id)
    {
        $category = Category::pluck('name', 'id');
        $data = Page::where('id', '=', $id)->first();

        return view('admin.page.edit')
            ->withcategory($category)
            ->withData($data);
    }

    public function update(pageRequest $request, $id)
    {
        $data = Page::where('id', '=', $id)->first();

        if (File::exists(public_path('uploads/page/' . $data->image))) {
            File::delete(public_path('uploads/page/' . $data->image));
        }

        $attachments = $request->image;
        if ($attachments != NULL) {
            $destinationPath = public_path() . "/uploads/page";
            $name = $attachments->getClientOriginalName();
            $fileName = time() . '_' . $name;
            $fileName = preg_replace('/\s+/', '_', $fileName);
            $attachments->move($destinationPath, $fileName);
        }
        $page = page::find($id);
        $page->title = $request['title'];
        $page->description = $request['description'];
        $page->status = $request['status'];
        $page->category_id = $request['category_id'];
        $page->user_id = backpack_user()->id;
        $page->created_at = Carbon::now();
        $page->image = $fileName ?? NULL;

        $page->save();

        //Notification start
        $type = 'Updated';
        $notification = User::first();
        $notification->notify(new NewUserRegisterNotification($page, $type, $this->module));
        //notification end
        \Alert::success('page successfully updated!')->flash();

        return redirect()->back()->withInput();
    }
}
