<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tasks = Task::where('status', false)->get();
        
        return view('tasks.index', compact('tasks'));
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
        //
        // $task_name = $request->input('task_name');
        // dd($task_name);

        $rule = [
            'task_name' => 'required|max:100',
        ];

        $messages = ['required' => '必須項目です', 'max' => '100文字以下にしてください。'];

        Validator::make($request->all(), $rule, $messages)->validate();

        // モデルをインスタンス化
        $task = new Task;

        // モデル->カラム名 = 値 で、データを割り当てる
        $task->name = $request->input('task_name');

        // データベースに保存
        $task->save();

        // リダイレクト
        return redirect('/tasks');
        
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
        $task = Task::find($id);
        return view('tasks.edit', compact('task'));
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
        //
        // dd($request->status);

        if($request -> status === null) {
            // 編集するを押した時
            $rules = [
                'task_name' => 'required|max:100',
            ];
    
            $messages = ['required' => '必須項目です', 'max' => '100文字以下にしてください'];
    
            Validator::make($request->all(), $rules, $messages) -> validate();
    
            // 該当のタスク検索
            $task = Task::find($id);
    
            // モデル->カラム名 = 値　でデータを割り当てる
            $task->name = $request->input('task_name');
    
            // データベースに保存
            $task->save();
        } else {
            // 完了を押した時

            // 該当のタスクを検索
            $task = Task::find($id);

            // モデル->カラム名 = 値　でデータを割り当てる
            $task->status = true;

            // データベースに保存
            $task->save();
        }

        // リダイレクト
        return redirect('/tasks');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Task::find($id)->delete();

        return redirect('/tasks');
    }
}
