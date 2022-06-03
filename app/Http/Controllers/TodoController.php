<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Auth;
use Session;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todo = Todo::select(['id', 'title', 'desc', 'deleted_at'])->where('user_id', Auth::user()->id);

        if(session()->get('withTrashed')) $todo->withTrashed();

        return $todo->get();
    }

    public function toggleWithTrashed()
    {
        $withFinished = session()->get('withTrashed');
        if(null == $withFinished){
            session()->put('withTrashed', true);
        };

        session()->put('withTrashed', !$withFinished);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newTodo = new Todo;
        $newTodo->user_id = Auth::user()->id;
        $newTodo->title   = $request->todo['title'];
        $newTodo->desc    = $request->todo['desc'];
        $newTodo->save();

        return $newTodo;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $existingTodo = Todo::find($id);

        if ($existingTodo) {
            $existingTodo->title = $request->todo['title'];
            $existingTodo->desc  = $request->todo['desc'];
            $existingTodo->update();
            return $existingTodo;
        }

        return "Todo not found";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $permanent)
    {
        if ($existingTodo = Todo::find($id)) {
            $existingTodo->delete();
            return "Todo deleted";
        }

        if($permanent) {
            Todo::where('id', $id)->withTrashed()->first()->forceDelete();
        }

        return "Todo not found";
    }

    public function restore($id)
    {
        if ($existingTodo = Todo::where('id', $id)->withTrashed()->first()) {
            $existingTodo->restore();
            return "Todo restored";
        }

        return "Todo not found";
    }

}
