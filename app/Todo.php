<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    //
    protected $fillable = ['name', 'status'];

    public static function form() :iterable{
        return [
            'name' => '',
            'status' => false
        ];
    }
}
