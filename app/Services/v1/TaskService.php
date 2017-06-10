<?php

namespace App\Services\v1;

use Illuminate\Http\Request;
use App\Task;
use App\User;
use Validator;

/**
 *
 */
class TaskService {

  protected $supportedIncludes = [
    'User' => 'owner'
  ];

  //protected $clauseProperties = [
  //  'status',
  //];

  protected $rules = [

    'title' => 'required',
    'body' => 'required',
    'completed' => 'required|taskstatus',
  ];

  public function validate($task){

    return $validator = Validator::make($task, $this->rules);

  }

  public function getTasks($parameters){

    if (empty($parameters)) {

      return $this->filterTasks(Task::all());
    }
    $withKeys = $this->getWithKeys($parameters);
    //dump(Task::with($withKeys)->get();
    $task = Task::with($withKeys)->get();
    return $this->filterTasks($task->toArray(),$withKeys); //$withKey
  }


  public function getTask($taskId){

    return $this->filterTasks(Task::where('id', $taskId)->get());
  }

  public function createTask($req){

    //$user = User::where('id', $userId)->get();
    //dd((int) $req->input('user.user_id'));
    $task = new Task();
    $task->title = $req->input('title');
    $task->body = $req->input('body');
    $task->completed = $req->input('completed');
    $task->user_id = (int) $req->input('user.user_id');

    $task->save();

    //return $task;
    return $this->filterTasks([$task]);

  }

  public function updateTask($req, $id){

    //dd(Task::where('id', $id)->firstOrFail());

    $task = Task::where('id', $id)->firstOrFail();

    $task->title = $req->input('title');
    $task->body = $req->input('body');
    $task->completed = $req->input('completed');
    $task->user_id = (int) $req->input('user.user_id');

    $task->save();

    //return $task;
    return $this->filterTasks([$task]);

  }

  public function deleteTask($id){

    $task = Task::where('id', $id)->firstOrFail();

    $task->delete();

  }

  protected function filterTasks($tasks, $keys = []){

    $data = [];

    foreach ($tasks as $task){
    //  dump($task->User->name);
      $entry = [
          'title' => $task['title'],
          'body'  => $task['body'],
          'status' => $task['completed'],
          'href' => route('tasks.show', ['id' => $task['id']])
      ];
      if (in_array('User', $keys)){
          $entry['owner'] = [
              'name' => $task['user']['name'],
              'email' => $task['user']['email']
          ];
          //dd($task->User->name);
      }
      $data[] = $entry;
    }
    return $data;
  }



  protected function getWithKeys($parameters){

    $withKeys = [];

    if (isset($parameters['include'])){
      $includeParams = explode(',',$parameters['include']);
      $includes = array_intersect($this->supportedIncludes,$includeParams);
      $withKeys = array_keys($includes);
    }
    return $withKeys;
  }
}
