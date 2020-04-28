<?php

namespace App\Http\Controllers\Admin;

use App\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\UpdateStoreTaskFormRequest;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return view('admin.tasks.tasks', ['tasks' => Task::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return view('admin.tasks.create-edit', ['edit' => false]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function store(UpdateStoreTaskFormRequest $request)
    {
        $data = $request->validated();
        $task = new Task();
        $task->fill($data)->save();
        $alert = ['type' => 'success', 'text' => 'Данные добавлены успешно.'];
        return redirect()->route('admin.tasks.index', $task)->with('alert', $alert);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     */
    public function show($some)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return view('admin.tasks.create-edit', ['task' => $task, 'edit' => true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function update(UpdateStoreTaskFormRequest $request, Task $task)
    {
        $data = $request->validated();
        $task->fill($data)->save();

        $alert = ['type' => 'success', 'text' => 'Данные изменены успешно.'];
        return redirect()->route('admin.tasks.index', $task)->with('alert', $alert);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy(Task $task)
    {
        $task->delete();
            $alert = ['type' => 'info', 'text' => 'Ресурс удалён.'];
        return redirect()->route('admin.tasks.index', $task)->with('alert', $alert);

    }
}
