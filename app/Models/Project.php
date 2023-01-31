<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;


    protected $fillable = ['user_id','funded_id','category_id', 'title', 'image', 'description'];

    protected $hidden = ['id'];

    public function user() {

        return $this->belongsTo('App\Models\User');

    }

    public function category() {

        return $this->belongsTo('App\Models\Category');

    }
    public function funded() {

        return $this->belongsTo('App\Models\Funded');

    }
}