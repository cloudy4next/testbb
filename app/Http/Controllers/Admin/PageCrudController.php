<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PageRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Page;
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
    use CreateOperation;
    use ListOperation;
    use ShowOperation;
    use UpdateOperation;
    use DeleteOperation;

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

        $this->crud->addColumn([
            'name' => 'row_number',
            'type' => 'row_number',
            'label' => '#',
            'orderable' => false,
        ])->makeFirstColumn();

        CRUD::column('title');
        // CRUD::column('user_id');
        $this->crud->addColumn([
            'name' => 'user_id',
            'label' => 'Publish By',
        ]);
        // CRUD::column('created_at');
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

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    // protected function setupUpdateOperation()
    // {
    //     $this->setupCreateOperation();
    // }

    public function create()
    {
        $category = Category::pluck('name', 'id');
        // dd($category);
        return view('admin.page.create')
            ->withcategory($category);
    }

    public function store(PageRequest $request)
    {
        $attachments = $request->image;
        $destinationPath = public_path() . "/uploads/page";
        $name = $attachments->getClientOriginalName();
        $fileName = time() . '_' . $name;
        $fileName = preg_replace('/\s+/', '_', $fileName);
        $attachments->move($destinationPath, $fileName);

        $page = new page();
        $page->title = $request['title'];
        $page->description = $request['description'];
        $page->status = $request['status'];
        $page->category_id = $request['category'];
        $page->user_id = backpack_user()->id;
        $page->created_at = Carbon::now();
        $page->image = $fileName ?? NULL;
        $page->save();

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
        $destinationPath = public_path() . "/uploads/page";
        $name = $attachments->getClientOriginalName();
        $fileName = time() . '_' . $name;
        $fileName = preg_replace('/\s+/', '_', $fileName);
        $attachments->move($destinationPath, $fileName);

        $page = page::find($id);
        $page->title = $request['title'];
        $page->description = $request['description'];
        $page->status = $request['status'];
        $page->category_id = $request['category'];
        $page->user_id = backpack_user()->id;
        $page->created_at = Carbon::now();
        $page->image = $fileName ?? NULL;

        $page->save();

        \Alert::success('page successfully updated!')->flash();

        return redirect()->back()->withInput();
    }
}
