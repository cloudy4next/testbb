<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;


    public function additionalDataUpdateButton($crud = false)
    {
    return '<a href="' . route('admin.show.detail', $this->id) . '" class="btn btn-sm btn-link"><i
            class="las la-eye"></i> Show Details</a>';
    }


}
