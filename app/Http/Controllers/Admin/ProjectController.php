<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Models\Type;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        return view('admin.projects.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();
        $newProject = new Project();
        $newProject->fill($data);
        if (isset($data['image'])) {
            $newProject->image = Storage::put('uploads', $data['image']);
        }
        $newProject->save();
        return to_route('admin.projects.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {   
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        return view('admin.projects.edit',compact('project','types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $data = $request->validated();
        if(!$request->boolean('set_image')){
            if($project->image){
                Storage::delete($project->image);
                $data['image'] = null;
            }
        } else {
            if (isset($data['image'])) {
                if($project->image){
                    Storage::delete($project->image);
                }
                $data['image'] = Storage::put('uploads', $data['image']);
            }
        }
        $project->update($data);
        return to_route('admin.projects.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {   
        if($project->image){
            Storage::delete($project->image);
        }
        $project->delete();
        return to_route('admin.projects.index');
    }
}