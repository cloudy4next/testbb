<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProjectRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Project;
use App\Models\Category;
use App\Models\Funded;
use Carbon\Carbon;
use File;

/**
 * Class ProjectCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProjectCrudController extends CrudController
{
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
        CRUD::setModel(\App\Models\Project::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/project');
        CRUD::setEntityNameStrings('project', 'projects');
    }

    protected function setupListOperation()
    {

        $this->crud->denyAccess(['show','create', ]);

        $this->crud->enableExportButtons();

        if(backpack_user()->hasPermissionTo('Project store')) {
            $this->crud->allowAccess(['create']);
        }

        if(!(backpack_user()->hasPermissionTo('Project delete'))) {
            $this->crud->denyAccess(['delete']);
        }

        if(!(backpack_user()->hasPermissionTo('Project edit'))) {
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

        return view('admin.project.create')
        ->withcategory($category)->withfunded($funded);
    }

    public function store(projectRequest $request)
    {
        $attachments = $request->image;
        if($attachments != NULL){
            $destinationPath = public_path() . "/uploads/project";
            $name = $attachments->getClientOriginalName();
            $fileName = time() . '_' . $name;
            $fileName = preg_replace('/\s+/', '_', $fileName);
            $attachments->move($destinationPath, $fileName);
        }
        $project = new project();
        $project->title = $request['title'];
        $project->description = $request['description'];
        $project->status = $request['status'];
        $project->category_id = $request['category_id'];
        $project->user_id = backpack_user()->id;
        $project->funded_id = $request->funded_id;
        $project->created_at = Carbon::now();
        $project->image = $fileName ?? NULL;
        $project->save();

        \Alert::success('project successfully created!')->flash();

        return redirect('admin/project');
    }

    public function edit($id)
    {
        $category = Category::pluck('name', 'id');
        $data = project::where('id', '=', $id)->first();
        $funded = Funded::pluck('name', 'id');

        return view('admin.project.edit')
        ->withcategory($category)
        ->withData($data)->withfunded($funded);
    }

    public function update(projectRequest $request, $id)
    {
        // dd($request->all());
        $data = Project::where('id', '=', $id)->first();

        if (File::exists(public_path('uploads/project/' . $data->image))) {
        File::delete(public_path('uploads/project/' . $data->image));
        }

        $attachments = $request->image;
        if($attachments != NULL){
            $destinationPath = public_path() . "/uploads/project";
            $name = $attachments->getClientOriginalName();
            $fileName = time() . '_' . $name;
            $fileName = preg_replace('/\s+/', '_', $fileName);
            $attachments->move($destinationPath, $fileName);
        }
        $project = Project::find($id);
        $project->title = $request['title'];
        $project->description = $request['description'];
        $project->status = $request['status'];
        $project->category_id = $request['category_id'];
        $project->user_id = backpack_user()->id;
        $project->funded_id = $request->funded_id;

        $project->created_at = Carbon::now();
        $project->image = $fileName ?? NULL;

        $project->save();

        \Alert::success('project successfully updated!')->flash();

        return redirect()->back()->withInput();
    }

}