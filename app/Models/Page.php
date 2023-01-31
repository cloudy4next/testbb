<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

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
}