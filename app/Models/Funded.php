<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funded extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $fillable = ['name'];

    public function projects()
    {
        return $this->hasMany('App\Models\Project');
    }

    public function news()
    {
        return $this->hasMany('App\Models\News');
    }

    public function notices()
    {
        return $this->hasMany('App\Models\Notice');
    }
}