<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TodosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $lists = Todo::all();
            $message = 'todolists got successfully';
            $status = 200;
        } catch (\Throwable $th) {
            $message = 'ERROR DB connection NG';
            $status = 500;
        } finally {
            return response()->json([
                'data' => $lists,
                'message' => $message,
            ],$status);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $now = Carbon::now();
            $list = new Todo;
            $list->list = $request->list;
            $list->created_at = $now;
            $list->updated_at = $now;
            $list->save();
            $message = 'new list successfully add';
            $status = 200;
        } catch (\Throwable $th) {
            $message = 'ERROR DB connection NG';
            $status = 500;
        } finally {
            return response()->json([
                'data' => $list,
                'message' => $message
            ], $status);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */

    // public function update(Request $request)←これなら理解できるんだが・・・下記は
    public function update(Request $request, Todo $todo)
    {
        try {
            $now = Carbon::now();
            $list = Todo::where('id', $todo->id)->first();
            $list->list = $request->list;
            $list->updated_at = $now;
            $list->save();
            $message = 'list successfully updated';
            $status = 200;
        } catch (\Throwable $th) {
            $message = 'ERROR DB connection NG';
            $status = 500;
        } finally {
            return response()->json([
                'data' => $list,
                'message' => $message
            ], $status);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        try {
            Todo::where('id', $todo->id)->delete();
            $message = 'list successfully deleted';
            $status = 200;
        } catch (\Throwable $th) {
            $message = 'ERROR DB connection NG';
            $status = 500;
        } finally {
            return response()->json([
                'message' => $message
            ],$status);
        }
    }
}
