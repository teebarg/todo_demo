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

}
