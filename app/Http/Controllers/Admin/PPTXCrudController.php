<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PPTXRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\PPTX;
use App\Models\Category;
use App\Models\User;
use App\Notifications\NewUserRegisterNotification;
use App\Models\Funded;
use Carbon\Carbon;
use File;

/**
 * Class PPTXCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PPTXCrudController extends CrudController
{
    public $module = 'PPTX Uploaded ';

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
        CRUD::setModel(\App\Models\PPTX::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/pptx');
        CRUD::setEntityNameStrings('pptx', 'PPTX');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('category_id');
        CRUD::column('name');
        CRUD::column('path');
        CRUD::column('created_at');
        CRUD::column('updated_at');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    public function create()
    {
        $category = Category::pluck('name', 'id');

        return view('admin.pptx.create')
        ->withcategory($category);
    }

    public function store(PPTXRequest $request)
    {
        // dd($request->all());
        $attachments = $request->image;
        if($attachments != NULL){
            $destinationPath = public_path() . "/uploads/pptx";
            $name = $attachments->getClientOriginalName();
            $fileName = time() . '_' . $name;
            $fileName = preg_replace('/\s+/', '_', $fileName);
            $attachments->move($destinationPath, $fileName);
        }
        $pptx = new PPTX();
        $pptx->category_id = $request['category_id'];
        $pptx->name = $request['name'];
        $pptx->user_id = backpack_user()->id;
        $pptx->created_at = Carbon::now();
        $pptx->path = $fileName ?? NULL;
        $pptx->save();

        //Notification start
        $type = 'Uploaded';
        $notification = User::first();
        $notification->notify(new NewUserRegisterNotification($pptx, $type, $this->module));
        //notification end

        \Alert::success('pptx successfully uploded!')->flash();

        return redirect('admin/pptx');
    }
}
