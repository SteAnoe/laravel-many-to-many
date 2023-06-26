<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin\Type;
use App\Models\Admin\Technology;

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
        return view('admin.project.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view ('admin.project.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|unique:projects',
                'description' => 'required',
                'img' => 'nullable|image',
                'type_id' => 'nullable|exists:types,id',
                'technologies' => 'exists:technologies,id'
            ],
            [
                'name.required' => 'Il campo name deve essere compilato',
                'name.unique' => 'Esiste già un project con quel nome',
                'description.required' => 'Il campo Description deve essere compilato',
                'type_id.exists' => 'Non esiste'
            ]
        );

        $form_data = $request->all();

        if($request->hasFile('img')){
            $path = Storage::disk('public')->put('project_images', $request->img);
            $form_data['img'] = $path;
        }


        $slug = Project::generateSlug($request->name);

        $form_data['slug'] = $slug;

        

        $new_project = new Project();

        $new_project->fill($form_data);
        
        $new_project->save();

        if($request->has('technologies')){
            $new_project->technologies()->attach($request->technologies);
        }

        return redirect()->route('admin.project.index')->with('success', "Project $new_project->name creato");;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin.project.show', compact( 'project' ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.project.edit', compact( 'project' , 'types' , 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        
        $request->validate(
            [
                'name' => 'required',
                'description' => 'required',
                'img' => 'nullable|image',
                'type_id' => 'nullable|exists:types,id',
                'technologies' => 'exists:technologies,id'
            ],
            [
                'name.required' => 'Il campo name deve essere compilato',
                'name.unique' => 'Esiste già un project con quel nome',
                'description.required' => 'Il campo Description deve essere compilato',
                'type_id.exists' => 'Non esiste'
            ]
        );

        $form_data = $request->all();

        if($request->hasFile('img')){
            if( $project->img ){
                Storage::delete($project->img);
            }
            $path = Storage::disk('public')->put('project_images', $request->img);
            $form_data['img'] = $path;
        }

        $slug = Project::generateSlug($request->name);

        $form_data['slug'] = $slug;

        $project->update($form_data);

        if($request->has('technologies')){
            $project->technologies()->sync($request->technologies);
        }

        return redirect()->route('admin.project.index')->with('success', "Project $project->name modificato");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        $project->technologies()->sync([]);
        return redirect()->route('admin.project.index');
    }
}
