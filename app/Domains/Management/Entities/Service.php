<?php

namespace App\Domains\Management\Entities;

use App\Domains\Management\Entities\ModelBase;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends ModelBase 

{
    use SoftDeletes;

    public $module = 'Management';

    protected $table = 'services';
    public $timestamps = false ;
    protected $guarded = [];

    protected $fillable = [
        'id',
        'name',
        'price',
        'description',
        'deleted_at',
    ];


    protected $dates = [
        'deleted_at'
    ];


}
