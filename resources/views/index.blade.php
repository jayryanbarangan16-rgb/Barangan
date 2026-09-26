<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>My Personal Task Manager</h2>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">+ Add New Task</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center bg-white shadow-sm">
                <div class="card-body">
                    <h6>Total Tasks</h6>
                    <h3 class="fw-bold">{{ $total }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center bg-white shadow-sm">
                <div class="card-body text-warning">
                    <h6>Pending</h6>
                    <h3 class="fw-bold">{{ $pending }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center bg-white shadow-sm">
                <div class="card-body text-success">
                    <h6>Completed</h6>
                    <h3 class="fw-bold">{{ $completed }}</h3>
                </div>
            </div>
        </div>
    </div>


    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Task Name</th>
                        <th>Description</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th style="width: 260px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $task->task_name }}</td>
                            <td>{{ $task->description ?? 'No details provided.' }}</td>
                            <td>{{ $task->due_date ? date('M d, Y', strtotime($task->due_date)) : 'N/A' }}</td>
                            <td>
                                @if($task->status == 'Completed')
                                    <span class="badge bg-success">Completed</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <!-- Toggle Status Button -->
                                    <form action="{{ route('tasks.toggle', $task->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm {{ $task->status == 'Completed' ? 'btn-secondary' : 'btn-success' }}">
                                            {{ $task->status == 'Completed' ? 'Reopen' : 'Complete' }}
                                        </button>
                                    </form>

                                    <!-- Edit Button -->
                                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-primary">Edit</a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Delete this task?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No tasks found. Click "+ Add New Task" to create one!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>