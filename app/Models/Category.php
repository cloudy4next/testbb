<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;


    protected $fillable = ['parent_id', 'name'];

    public function children()
    {
        return $this->hasMany('App\Models\Category', 'parent_id');
    }

    public function pages()
    {
        return $this->hasMany('App\Models\Page');
    }
}
