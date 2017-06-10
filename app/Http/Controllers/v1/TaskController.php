<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\v1\TaskService;



class TaskController extends Controller
{
    protected $tasks;

    public function __construct(TaskService $service){

        $this->tasks = $service;

        $this->middleware('auth:api',['only'=>['store','update','destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()//Tasks $task
    {
      //dd($task);
      //return $task->all();
      //$tasks = new \App\Services\Tasks;

      //return $tasks->all();

        $parameters = request()->input();
        //dump($parameters);
        $data = $this->tasks->getTasks($parameters);
        return response()->json($data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $valid = $this->tasks->validate($request->all());
      if ($valid->fails()) {
        return response()->json(['message' => $valid->errors()->first()], 422);
      }

      try {
        $task = $this->tasks->createTask($request);
        return response()->json($task, 201);

      } catch (Exception $e) {
        return  response()->json(['message' => $e->getMessage()], 500);
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->tasks->getTask($id);

        return response()->json($data);
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
      $valid = $this->tasks->validate($request->all());
      if ($valid->fails()) {
        return response()->json(['message' => $valid->errors()->first()], 422);
      }
      try {
        $task = $this->tasks->updateTask($request, $id);
        return response()->json($task, 200);

      } catch (ModelNotFoundException $ex) {
        throw $ex;
      }

      catch (Exception $e) {
        return  response()->json(['message' => $e->getMessage()], 500);
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      try {
        $task = $this->tasks->deleteTask($id);
        return response()->make('', 204);

      } catch (ModelNotFoundException $ex) {
        throw $ex;
      }

      catch (Exception $e) {
        return  response()->json(['message' => $e->getMessage()], 500);
      }
    }
}
