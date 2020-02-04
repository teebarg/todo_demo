<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function store(){
        $this->validate(request(), [
            'todo'=>'required|min:1',
            'status' => 'required|boolean'
        ]);
       $result =  Todo::create(\request(['todo', 'status']));
       return response()->json([$result], 200);
    }
}
