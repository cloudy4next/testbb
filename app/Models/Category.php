<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Spatie\Permission\Traits\HasRoles;use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class Category extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    // use HasFactory;
    use LogsActivity;
    use HasFactory;
    use CrudTrait;
    use HasRoles;


    protected $fillable = ['parent_id', 'name'];

    public function children()
    {
        return $this->hasMany('App\Models\Category', 'parent_id');
    }

    public function pages()
    {
        return $this->hasMany('App\Models\Page');
    }
    public function news()
    {
        return $this->hasMany('App\Models\News');
    }
    public function notices()
    {
        return $this->hasMany('App\Models\Notice');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->useLogName('Category')->logOnly([
        'name',
        ])->setDescriptionForEvent(fn(string $eventName) => "This category by has been {$eventName}");
    }

}