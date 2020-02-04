<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    //
    public function index(){
        $todos = Todo::all();
        return response()->json(
            [
               'status' => 'success',
                'todos' => $todos
            ]
        );
    }

    public function store(){
        $data = $this->validate(request(), [
            'todo'=>'required|min:1',
            'status' => 'required|boolean'
        ]);
       $result =  Todo::create($data);
       return response()->json([$result], 200);
    }
}
