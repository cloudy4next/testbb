<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class Funded extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    use LogsActivity;

    protected $fillable = ['name'];

    public function projects()
    {
        return $this->hasMany('App\Models\Project');
    }

    public function research()
    {
        return $this->hasMany('App\Models\Research');
    }

    public function news()
    {
        return $this->hasMany('App\Models\News');
    }

    public function notices()
    {
        return $this->hasMany('App\Models\Notice');
    }


    public function articles()
    {
        return $this->hasMany('App\Models\Article');
    }

    public function getActivitylogOptions(): LogOptions
    {
    return LogOptions::defaults()->useLogName('Funded By')->logOnly([
        'name',
    ])->setDescriptionForEvent(fn(string $eventName) => "This funded by has been {$eventName}");
    }

}
