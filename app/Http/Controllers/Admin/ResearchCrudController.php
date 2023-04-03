<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ResearchRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ResearchCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ResearchCrudController extends CrudController
{
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
        CRUD::setModel(\App\Models\Research::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/research');
        CRUD::setEntityNameStrings('research', 'research');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::column('user_id');
        // CRUD::column('category_id');
        // CRUD::column('funded_id');
        // CRUD::column('title');
        // CRUD::column('description');
        // CRUD::column('image');
        // CRUD::column('author');
        // CRUD::column('status');
        // CRUD::column('created_at');
        // CRUD::column('updated_at');

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

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ResearchRequest::class);

        CRUD::field('category_id');
        CRUD::field('funded_id');
        CRUD::field('title');
        // CRUD::field('description');
        // CRUD::field('author');
        $this->crud->addField([
            'name'            => 'status',
            'label'           => "Status",
            'type'            => 'select_from_array',
            'options'         => ['Published' => 'Published', 'Unpublished' => 'Unpublished'],
            // 'allows_null'     => false,
            // 'allows_multiple' => true,
            // 'tab'             => 'Tab name here',
        ]);
        $this->crud->addField([
            'name' => 'user_id',
            'label' => 'User',
            'type' => 'hidden',
            'function' => function($entry) {
                    return backpack_user()->id();
            }
            ]);
        $this->crud->addField([
                'name'  => 'description',
                'label' => 'Description',
                'type'  => 'easymde',
            ]);

        // CRUD::field('image');
        $this->crud->addField([
            'label' => "Choose Image",
            'name' => "image",
            'type' => 'image',
        ]);
        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

///////////////////////--------------- dont touch if it's not nessesary---------------////////////
    // public function create()
    // {
    //     $category = Category::pluck('name', 'id');
    //     $funded = Funded::pluck('name', 'id');

    //     return view('admin.research.create')
    //     ->withcategory($category)->withfunded($funded);
    // }

    // public function store(ResearchRequest $request)
    // {
    //     $attachments = $request->image;
    //     if($attachments != NULL){
    //         $destinationPath = public_path() . "/uploads/articles";
    //         $name = $attachments->getClientOriginalName();
    //         $fileName = time() . '_' . $name;
    //         $fileName = preg_replace('/\s+/', '_', $fileName);
    //         $attachments->move($destinationPath, $fileName);
    //     }
    //     $articles = new Research();
    //     $articles->title = $request['title'];
    //     $articles->description = $request['description'];
    //     $articles->status = $request['status'];
    //     $articles->category_id = $request['category_id'];
    //     $articles->user_id = backpack_user()->id;
    //     $articles->funded_id = $request->funded_id;
    //     $articles->created_at = Carbon::now();
    //     $articles->image = $fileName ?? NULL;
    //     $articles->save();

    //     //Notification start
    //     $type = 'Created';
    //     $notification = User::first();
    //     $notification->notify(new NewUserRegisterNotification($articles, $type, $this->module));
    //     //notification end

    //     \Alert::success('research successfully created!')->flash();

    //     return redirect('admin/article');
    // }

    // public function edit($id)
    // {
    //     $category = Category::pluck('name', 'id');
    //     $data = Research::where('id', '=', $id)->first();
    //     $funded = Funded::pluck('name', 'id');

    //     return view('admin.research.edit')
    //     ->withcategory($category)
    //     ->withData($data)->withfunded($funded);
    // }

    // public function update(ResearchRequest $request, $id)
    // {
    //     $data = Research::where('id', '=', $id)->first();

    //     if (File::exists(public_path('uploads/articles/' . $data->image))) {
    //         File::delete(public_path('uploads/articles/' . $data->image));
    //     }

    //     $attachments = $request->image;
    //     if($attachments != NULL){
    //         $destinationPath = public_path() . "/uploads/articles";
    //         $name = $attachments->getClientOriginalName();
    //         $fileName = time() . '_' . $name;
    //         $fileName = preg_replace('/\s+/', '_', $fileName);
    //         $attachments->move($destinationPath, $fileName);
    //     }
    //     $articles = Research::find($id);
    //     $articles->title = $request['title'];
    //     $articles->description = $request['description'];
    //     $articles->status = $request['status'];
    //     $articles->category_id = $request['category_id'];
    //     $articles->user_id = backpack_user()->id;
    //     $articles->funded_id = $request->funded_id;

    //     $articles->created_at = Carbon::now();
    //     $articles->image = $fileName ?? NULL;

    //     $articles->save();

    //     //Notification start
    //     $type = 'Created';
    //     $notification = User::first();
    //     $notification->notify(new NewUserRegisterNotification($articles, $type, $this->module));
    //     //notification end

    //     \Alert::success('articles successfully updated!')->flash();

    //     return redirect()->back()->withInput();
    // }
}
