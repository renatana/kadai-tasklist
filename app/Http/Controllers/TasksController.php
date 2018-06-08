<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Task;   

class TasksController extends Controller
{

    public function create()
    {
        if (\Auth::check()) {
            $user = \Auth::user();
        $task = new Task;
        return view('tasks.create', [
            'task' => $task,
            ]);
            
        }else {
            return view('welcome');
        }
    }


public function show($id){
        $task = Task::find($id);
            if (isset($task)){
                if (null !== \Auth::user() && \Auth::user()->id == $task->user_id){
                    return view('tasks.show', [ 'task' => $task,]);
                    
                }else{
                    return view('welcome');
                }
            }else{
              return view('welcome');
            }
    }

//     public function show($id)
//         {
//           { $task = Task::find($id);
     
//         if (\Auth::check()){
//                 if(!empty($task->id)){
//                     if (null !== \Auth::user() && \Auth::user()->id == $task->user_id)
       
//              return view('tasks.show', [
//                 'tasks' => $task,
            
//             ]);}else{
//                 return view('welcome');
//             }
//         }else{return view('/');
//             }
//          }
//  }

    // public function show($id)
    // {
    //     if (\Auth::check()) {
    //         $user = \Auth::user();
    //     $task = Task::find($id);
        
    //     return view('tasks.show', [
    //         'task' => $task,
    //     ]);
            
    //     }else {
    //         return view('welcome');
    //     }
    // }
    
    public function edit($id){
        $task = Task::find($id);
            if (isset($task)){
                if (null !== \Auth::user() && \Auth::user()->id == $task->user_id){
                    return view('tasks.edit', [ 'task' => $task,]);
                    
                }else{
                    return view('welcome');
                }
            }else{
              return view('welcome');
            }
    }
    
    // public function edit($id)
   
    // {
    //      { $task = Task::find($id);
     
    //     if (\Auth::check()){
    //         // if (null !== \Auth::user() && \Auth::user()->id == $task->user_id && !empty($task->id)){
    //                 if(!empty($task->id)){if (null !== \Auth::user() && \Auth::user()->id == $task->user_id)
       
    //     return view('tasks.edit', [
    //         'tasks' => $task,
            
    //   ]);}else{
    //             return view('welcome');
    //         }
    //     }else{return view('/');
    //         }
    //      }
       
    // }


    // public function edit($id)
    // {
    //     if (\Auth::check()) {
    //         $user = \Auth::user();
    //         $task = Task::find($id);
        
    //     return view('tasks.edit',[
    //         'task' => $task,
    //         ]);
            
    //     }else {
    //         return view('welcome');
    //     }   
    // }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|max:10', 
            'content' => 'required|max:191',
        ]);
        
        $task = Task::find($id);
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();

        return redirect('/');
    }

    
    public function index()
    {
        if (\Auth::check()) {
        $user=\Auth::user();
        $tasks=$user->tasks()->get();
        
        return view('tasks.index',[
            'tasks'=>$tasks,
            ]);
        }else {
            return view('welcome');
        }
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'status'=>'required|max:10',
            'content' => 'required|max:191',
        ]);

        $request->user()->tasks()->create([
            'status' => $request->status,
            'content' => $request->content,
        ]);

        return redirect('/');
    }
    
    public function destroy($id)
    {
        $tasklist = Task::find($id);
        $tasklist->delete();
        
        return redirect('/');
    }
    
}
