<?php

namespace App\Http\Controllers;

use App\DataTables\ProjectsDataTable;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Yajra\DataTables\DataTables;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Contracts\View\View
     */
    public function index(ProjectsDataTable $dataTable)
    {
        if (request()->ajax()) {
            return DataTables::of(Project::select('*'))->toJson();
        }
        return view('projects.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreProjectRequest $request)
    {
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('/assets/images/projects'), $imageName);

        $project = new Project;
        $project->name = $request->name;
        $project->status = $request->status;
        $project->image = url('/assets/images/projects/' . $imageName);
        $success = $project->save();

        return response()->json([
            'message' => $success ? 'Project saved successfully' : 'Project failed to save',
            'success' => $success
        ], $success ? 201 : 400);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {

        $project->name = $request->name;
        $project->status = $request->status;

        if ($request->image) {
            $this->deleteImageByUrl($project->image);

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('/assets/images/projects'), $imageName);
            $project->image = url('/assets/images/projects/' . $imageName);
        }

        $success = $project->save();

        return response()->json([
            'message' => $success ? 'Project updated successfully' : 'Project failed to update',
            'success' => $success
        ], $success ? 201 : 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Project $project)
    {
        $this->deleteImageByUrl($project->image);

        $project->tasks()->get()->map(function ($task) {
            $this->deleteImageByUrl($task->image);
            $task->delete();
        });

        $success = $project->delete();

        return response()->json([
            'message' => $success ? 'Project deleted successfully' : 'Project failed to delete',
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