<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    use HasFactory;

    protected $fillable = ['user_id', 'category_id', 'title', 'image_path', 'description'];


    public function user()
    {

        return $this->belongsTo('App\Models\User');
    }

    public function category()
    {

        return $this->belongsTo('App\Models\Category');
    }
}
