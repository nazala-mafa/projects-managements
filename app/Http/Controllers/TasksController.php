<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\User;
use Yajra\DataTables\DataTables;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Contracts\View\View
     */
    public function index(Project $project)
    {
        if (request()->ajax()) {
            if (auth()->user()->role === 'admin') {
                $source = Task::select('*')->where('project_id', $project->id)->with('users')->get();
            } else {
                $source = Task::select('*')->where('project_id', $project->id)->where('user_assign', auth()->user()->id)->with('users')->get();
            }

            return DataTables::of($source)
                ->addColumn('user_assign_name', function ($task) {
                    return $task->users->name;
                })
                ->toJson();
        }

        return view('tasks.index', [
            'users' => User::where('role', 'user')->select(['id', 'name'])->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTaskRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTaskRequest $request, Project $project)
    {
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path("/assets/images/projects/$project->id/tasks"), $imageName);

        $task = new Task;
        $task->project_id = $project->id;
        $task->user_assign = $request->user_assign;
        $task->name = $request->name;
        $task->description = $request->description;
        $task->deadline = $request->deadline;
        $task->image = url("/assets/images/projects/$project->id/tasks/" . $imageName);
        $success = $task->save();

        return response()->json([
            'message' => $success ? 'Task saved successfully' : 'Task failed to save',
            'success' => $success
        ], $success ? 201 : 400);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTaskRequest  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateTaskRequest $request, Project $project, Task $task)
    {
        $task->name = $request->name;
        $task->description = $request->description;
        $task->deadline = $request->deadline;
        $task->user_assign = $request->user_assign;

        if ($request->image) {
            $this->deleteImageByUrl($task->image);

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path("/assets/images/projects/$project->id/tasks"), $imageName);
            $task->image = url("/assets/images/projects/$project->id/tasks/" . $imageName);
        }

        $success = $task->save();

        return response()->json([
            'message' => $success ? 'Task updated successfully' : 'Task failed to save',
            'success' => $success
        ], $success ? 201 : 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Project $project, Task $task)
    {
        $this->deleteImageByUrl($task->image);

        $success = $task->delete();

        return response()->json([
            'message' => $success ? 'Task deleted successfully' : 'Task failed to delete',
            'success' => $success
        ], $success ? 201 : 400);
    }
    private function deleteImageByUrl($url)
    {
        $filepath = public_path(str_replace(url('/'), '', $url));

        if (file_exists($filepath) && $url !== url('/assets/images/default-image.jpg')) {
            unlink($filepath);
        }
    }
}