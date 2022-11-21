<?php

namespace App\Http\Controllers;

use App\models\Todo;
use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;
use Illuminate\Support\Facades\Auth;



class TodoController extends Controller
{
    protected $todos;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $todos = $request->user()->todos()->get();
        return view('index', compact('user','todos')); 
    }

    public function create(ClientRequest $request)
    {
        $request->user()->todos()->create([
            'text' => $request->text,
            'tag' => $request->tag,
        ]);
        return redirect()->back();
    }

    public function update(ClientRequest $request, Todo $id)
    {
        $this->authorize('update', $id);
        $id->fill([
            'text' => $request->text,
            'tag' => $request->tag,
        ])->save();
        return redirect()->back();
    }

    public function destroy(Request $request, Todo $id)
    {
        $this->authorize('destroy', $id);
        $id->delete();
        return redirect()->back();
    }

    public function find(Request $request)
    {
        $user = Auth::user();
        return view('find', compact('user')); 
    }

    public function search(Request $request)
    {
        // dd($request);
        $user = Auth::user();
        if(!$request->text && !$request->tag){
            $todos = $request->user()->todos()->get();
        }
        elseif($request->text && !$request->tag){
            $todos = $request->user()->todos()->where('text', 'LIKE', "%{$request->text}%")->get();
        }
        elseif(!$request->text && $request->tag){
            $todos = $request->user()->todos()->where('tag', ($request->tag))->get();
        }
        else{
            $todos = $request->user()->todos()->where('tag', ($request->tag))->where('text', 'LIKE', "%{$request->text}%")->get();
        }
        return view('find_result', compact('user','todos')); 
    }


}
