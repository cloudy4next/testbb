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

    protected $fillable = [ 'category_id', 'title', 'image', 'description'];

    protected $casts = [
        'created_at' => 'integer',
        'updated_at' => 'integer',
        ];

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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->useLogName('Page')->logOnly([
        'title',
        'user_id',
        ])->setDescriptionForEvent(fn(string $eventName) => "This page has been {$eventName}");
    }
}