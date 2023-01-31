<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Category;

/**
 * Class CategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CategoryCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Category::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/category');
        CRUD::setEntityNameStrings('category', 'categories');
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

        if(backpack_user()->hasPermissionTo('Category store')) {
            $this->crud->allowAccess(['create']);
        }

        if(!(backpack_user()->hasPermissionTo('Category delete'))) {
            $this->crud->denyAccess(['delete']);
        }

        if(!(backpack_user()->hasPermissionTo('Category edit'))) {
            $this->crud->denyAccess(['update']);
        }

        $data = $this->getParent();

        // CRUD::column('parent_id');
        CRUD::column('name');

        $this->crud->addColumn([
            'name' => 'parent_id',
            'label' => 'Parent',
            'type' => 'closure',
            'function' => function($entry) use ($data) {
            return $data[$entry->parent_id] ?? '--';
            }
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
        CRUD::setValidation(CategoryRequest::class);
        $data = $this->getParent();


        $this->crud->addField([
        'label' => "Parent",
        'name' => 'parent_id',
        'type' => 'select',
        'entity' => 'children',
        'attribute' => 'name',
        ]);

        CRUD::field('name');

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

    private function getParent(): array
    {
        $results = Category::select('id', 'name')->get()->toArray();
        $data = [];
        foreach ($results as $result) {
            $data[$result['id']] = $result['name'];
            }

        return $data;
    }
}