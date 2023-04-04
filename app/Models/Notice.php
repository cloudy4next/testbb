<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class Notice extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    use LogsActivity;

    protected $fillable = ['user_id','funded_id','category_id', 'title', 'image', 'description'];

    // protected $hidden = ['id'];

    public function user() {

    return $this->belongsTo('App\Models\User');

    }

    public function category() {

        return $this->belongsTo('App\Models\Category');

    }
    public function funded() {

        return $this->belongsTo('App\Models\Funded');

    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->useLogName('Notice')->logOnly([
        'title',
        'user_id',
        ])->setDescriptionForEvent(fn(string $eventName) => "This notice has been {$eventName}");
    }
}
