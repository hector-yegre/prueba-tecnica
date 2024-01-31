<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTask;
use Illuminate\Http\Request;
use App\Http\Responses\ApiResponse;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
 
 

class TaskController extends Controller
{
   
    public function index(Request $request){
        try{
            $user = User::find(Auth::user()->id);
            $tasks = Task::whereHas('user', function ($query) use ($user) {
                $query->where('user_id', Auth::user()->id);
            })
            ->with('user')
            ->where('task_status',1)
            ->where('task_delete',1)
            ->where('task_name','like',"%$request->title%")
            ->orderBy('id',"desc")
            ->paginate(6);
            return ApiResponse::success('Lista de tareas',200,$tasks);
        }catch(\Exception $e){
            return response()->json([
                'msg'=> 'Contact Your Administrator'.$e->getMessage() 
            ],500);
        }
       

    }
    public function store(StoreTask $request){

        try {
            $task = new Task();
            $task->user_id = Auth::user()->id;
            $task->task_name = $request->task_name;
            $task->task_description = $request->task_description;
            $task->save();
            return ApiResponse::success('Tarea registrada exitosamente !',201,$task);
        } catch (\Exception $e) {
            return response()->json([
                'msg'=> 'Contact Your Administrator'.$e->getMessage() 
            ],500);
        }
    }
    public function show(Request $request,$id){
         
        try{
            if(!$id){
                return ApiResponse::error("El id de la tarea es requerido",404);
            }
            $task = Task::find($id);
            if(!$task){
                return ApiResponse::error("Tarea con el id {$id} no encontrada",404);
            }
            return ApiResponse::success('success',200,$task);

        }catch(\Exception $e){
            return ApiResponse::error('contacte con su administrador:'.$e->getMessage(),500,);
        }
        
    }
    public function update(StoreTask $request,$id){
      
        try {

            if(!$id){
                return ApiResponse::error("El id de la tarea es requerido",404);
            }

            $task = Task::find($id);

            if(!$task){
                return ApiResponse::error("Tarea con el id {$task} encontrada",404);
            }
            $task->update($request->all());
            return ApiResponse::success('Tarea actualizada correctamente !',200,$task);
            
        } catch (\Exception $e) {
            return ApiResponse::error('contacte con su administrador: '.$e->getMessage(),500,);
        }
    }
    public function destroy(Request $request,$id){
        try{
            if(!$id){
                return ApiResponse::error('El id es requerido',404);
            }
            $task = Task::find($id);
            if(!$task){
                return ApiResponse::error('No se econtro tareas con el id: '.$id,404);
            }
            $task->task_delete = 0;
            $task->save();
            return ApiResponse::success('Tarea Eliminada Correctamente',200,  $task);
        }catch(\Exception $e){
            return ApiResponse::error('contacte con su administrador: '.$e->getMessage(),500,);
        }

    }

    public function complete(Request $request,$id){
        try{
            if(!$id){
                return ApiResponse::error('El id es requerido',404);
            }
            $task = Task::find($id);
            if(!$task){
                return ApiResponse::error('No se econtro tareas con el id: '.$id,404);
            }
            $task->task_status = 0;
            $task->save();
            return ApiResponse::success('Tarea completada',200,  $task);
        }catch(\Exception $e){
            return ApiResponse::error('contacte con su administrador: '.$e->getMessage(),500,);
        }

    }

    
}
