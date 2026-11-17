<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\User;
// use Illuminate\Support\Facades\Hash;

//use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{

   protected function getAllTasks(){
        $tasks= Task::join('users', 'tasks.user_id','=' ,'users.id')
        ->select('tasks.id', 'tasks.due_at', 'tasks.status', 'tasks.name','users.name as user_name')
        ->get();
        return $tasks;
    }


    public function allTasks(){
        $tasks=$this->getAllTasks();
        //tarefas do id 4
        // Task::TaskByUser(4);

        //chamar pela variável do modelo
        // Task::STATUS_COMPLETED;

        return view('tasks.allTasks', compact('tasks'));
    }

    public function addTasks () {
         $users = User::select('id', 'name')->get();
        return view('tasks.addTasks', compact('users'));
    }

    public function deleteTasks(int $id){
        Task::where('id',$id)->delete();
        return back();
    }


    public function editTasks(int $id){
        $taskInfo = Task::join('users', 'tasks.user_id','=' ,'users.id')->where('tasks.id', $id)->select('tasks.id', 'tasks.description','tasks.due_at', 'tasks.status', 'tasks.name','users.name as user_name')->first();
        return view('tasks.editTasks', compact('taskInfo'));
    }





  public function storeTask(Request $request){
           //validar os dados no servidor
        $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:500',
            'user_id' => 'required|integer|exists:users,id',

        ]);

     //depois de validados, inserir na bd
        Task::insert([
            'name'=> $request->name,
            'description'=> $request->description,
            'user_id' => $request->user_id,
        ]);

          return redirect()->route('tasks.all')->with('message', 'task adicionado com sucesso!');

    }

}
