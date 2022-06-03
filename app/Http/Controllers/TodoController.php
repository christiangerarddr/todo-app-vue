<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Auth;
use Session;
use App\Http\Requests\TodoRequest;

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TodoRequest $request)
    {
        return Todo::create([
            'user_id' => Auth::user()->id,
            'title'   => $request->todo['title'],
            'desc'    => $request->todo['desc']
        ]);
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

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if ($existingTodo = Todo::where('id', $id)->withTrashed()->first()) {
            $existingTodo->restore();
            return "Todo restored";
        }

        return "Todo not found";
    }

}
