<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Ecards extends Model
{
    use SoftDeletes;

    protected $table = "ecards";
    protected $primarykey = "id";

    protected $guarded = [
        'id'
    ];
}
