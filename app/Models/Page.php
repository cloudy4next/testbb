<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Page extends Model
{
    use LogsActivity;

    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $fillable = ['user_id', 'category_id', 'title', 'image', 'description'];


    public function user() {

        return $this->belongsTo('App\Models\User');

    }

    public function category() {

        return $this->belongsTo('App\Models\Category');

    }

    public function additionalDataUpdateButton($crud = false)
    {
        return '<a href="'.route('admin.page.edit', $this->id).'" class="btn btn-sm btn-link"><i
            class="la la-edit"></i>Edit</a>';
    }


    /* start activity log */
    protected static $logAttributes = [
                'name',
                'created_by',
                'updated_by',
                ];

    protected static $logName = 'Page Created';

    public function getDescriptionForEvent(string $eventName): LogOptions
    {
        return "This user has been {$eventName}";
    }

     public function getActivitylogOptions(): LogOptions
     {
        return LogOptions::All();
     }
    /* end activity log */
}