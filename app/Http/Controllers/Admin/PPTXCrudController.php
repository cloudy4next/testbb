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
use FFMpeg\FFProbe;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Video\X264;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Media\Video;
use FFMpeg\Filters\Video\ResizeFilter;
/**
 * Class PPTXCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PPTXCrudController extends CrudController
{
    public $module = 'E-Learning Uploaded ';

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
        CRUD::setEntityNameStrings('e-learning', 'E-Learning');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {

        $this->crud->denyAccess(['edit','show','update']);
        CRUD::column('category_id');
        CRUD::column('name');
        CRUD::column('image');
        CRUD::column('pptx');
        // CRUD::column('image');

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

    public function storeService($attachments,$path)
    {
        if($attachments != NULL){
            $destinationPath = public_path() . "/uploads/pptx/". $path;
            $name = $attachments->getClientOriginalName();
            $fileName = time() . '_' . $name;
            $fileName = preg_replace('/\s+/', '_', $fileName);
            $attachments->move($destinationPath, $fileName);
        }
        return $fileName ;
    }


    public function store(PPTXRequest $request)
    {
        $image_filename = $this->storeService($request->image,'cover');

        $file = $request->file('pptx');
        // dd($file);
        if ($file->getClientOriginalExtension() === 'mp4' || $file->getClientOriginalExtension() === 'avi' || $file->getClientOriginalExtension() === 'mov') {

            $pptx_filename = $this->optimize($file);

        } else {

            $pptx_filename = $this->storeService($request->pptx,'pptx');
        }



        $pptx = new PPTX();
        $pptx->category_id = $request['category_id'];
        $pptx->name = $request['name'];
        $pptx->user_id = backpack_user()->id;
        $pptx->created_at = Carbon::now();
        $pptx->image = $image_filename ?? NULL;
        $pptx->pptx = $pptx_filename ?? NULL;

        $pptx->save();

        //Notification start
        $type = 'Uploaded';
        $notification = User::first();
        $notification->notify(new NewUserRegisterNotification($pptx, $type, $this->module));
        //notification end

        \Alert::success('File successfully uploded!')->flash();

        return redirect('admin/pptx');
    }

        public function optimize($video)
    {
        $ffmpeg = FFMpeg::create();

        $videoFile = $ffmpeg->open($video->getRealPath());

        $dimension = new Dimension(426, 240);
        $resizeFilter = new ResizeFilter($dimension, null, ResizeFilter::RESIZEMODE_INSET);
        $videoFile->addFilter($resizeFilter);

        $format = new X264('aac');
        $format->setKiloBitrate(500);

        $name = $video->getClientOriginalName();
        $fileName = time() . '_' . $name;
        $fileName = preg_replace('/\s+/', '_', $fileName);


        $outputFile = public_path("/uploads/pptx/pptx/" . $fileName);
        $videoFile->save($format, $outputFile);

        return $fileName;
    }
}
