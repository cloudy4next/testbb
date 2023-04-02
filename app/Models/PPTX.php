<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class PPTX extends Model

{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    use LogsActivity;

    protected $fillable = ['name','path'];


    public function category() {

        return $this->belongsTo('App\Models\Category');

    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->useLogName('News')->logOnly([
        'title',
        'user_id',
        ])->setDescriptionForEvent(fn(string $eventName) => "This news has been {$eventName}");
    }
}
