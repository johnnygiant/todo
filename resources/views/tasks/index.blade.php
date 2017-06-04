<!-- app/views/nerds/index.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>ToD Aplication</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>
<body>

<div class="col-4 col-lg-8">
    <div ><h3 class="text-decoration: line-through">Tasks List</h3></div>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>ID</td>
            <td>Title</td>
            <td>Body</td>
            <td>realize by User</td>
            <td>Created at</td>
            <td>status</td>
            <td>delete</td>
        </tr>
    </thead>
    <tbody>
    @foreach($tasks as $task)
        <tr>
            <td>{{ $task->id }}</td>
            <td>{{ $task->title }}</td>
            <td>{{ $task->body}}</td>
            <td>{{ $task->user->name}}</td>
            <td>{{ $task->created_at }} </td>
            <td>
                @if ($task->completed == 1)
                    completed
                @else
                   <form action="{{ url('/tasks/'.$task->id) }}" method="POST">
                      {!! csrf_field() !!}
                      {!! method_field('PATCH') !!}
                      <button>complet</button>
                    </form>
                @endif
            </td>
            <td>
              <form action="{{ url('/tasks/'.$task->id) }}" method="POST">
                 {!! csrf_field() !!}
                 {!! method_field('DELETE') !!}
                 <button>Delete</button>
               </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>

<div class="col-6 col-lg-3">
  <div ><h3>Create a task</h3></div>

{!! Form::open(['url' => 'tasks']) !!}
      {{ Form::token() }}

    <div class="form-group">
      {{ Form::label('Title', null, ['class' => 'control-label']) }}
      {{ Form::text('Title', null, ['class' => 'form-control']) }}

    </div>
    <div class="form-group">
      {{ Form::label('Body', null, ['class' => 'control-label']) }}
      {{ Form::textArea('Body', '', ['class' => 'form-control']) }}

    </div>
    <div class="form-group">
      {{ Form::label('User', null, ['class' => 'control-label']) }}
      {{ Form::select('user_id', $users, null, ['class'=>'form-control']) }}

    </div>

    <div class="form-group">
      {{ Form::submit('save') }}

    </div>

{!! Form::close() !!}


  </div>
</body>
</html>
