<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use App\Models\Course;
use App\Models\User;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:coordinator.index')->only('create', 'edit', 'destroy');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::all();
        return view('courses.index')->with('courses', $courses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Muestra el límite de cupos disponibles
        $limit = "50";
        return view('courses.create')->with('limit', $limit);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:30'],
            'quotas' => ['required', 'numeric', 'max:50'],
            'description' => ['required', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpg', 'max:1024'],
        ], [
            'quotas.max' => 'El campo cupos no debe ser mayor a :max',
            'description.max' => 'El campo descripción no debe ser mayor a :max carácteres',
            'image.max' => 'La imagen no debe pesar más de 1 MB.',
            'image.mimes' => 'La imagen debe ser un archivo de tipo: :values.',
        ]);

        if ($validator->fails()) {
            return redirect('cursos/create')->withErrors($validator)->withInput();
        };

        if ($request->hasFile('image')) {
            $image = $request->file('image')->storeAs('uploads', date('Y-m-d').$request->get('name').'.jpg', 'public');
        }

        $course = new Course();
        
        $course->name = $request->get('name');
        $course->professor = 'Sin asignar';
        $course->quotas_available = $request->get('quotas');
        $course->quotas = $course->quotas_available;
        $course->category = 'Sin asignar';
        $course->type = 'Sin asignar';
        $course->description = $request->get('description');
        $course->image = $image;
        
        $course->save();
        return redirect('cursos')->with('create', 'created'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $users = User::all();
        $course = Course::findOrFail($id);
        return view('courses.show', ['course' => $course, 'users' => $users]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $course = Course::findOrFail($id);
        return view('courses.edit', ['course' => $course]);
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
        $data = request()->except(['_token', '_method']);

        if ($request->hasFile('image')) {
            $course = Course::findOrFail($id);

            Storage::delete('public/'.$course->image);

            $data['image'] = $request->file('image')->storeAs('uploads', date('Y-m-d').$request->get('name').'.jpg', 'public');
        }

        Course::where('id', '=', $id)->update($data);
        $course = Course::findOrFail($id);

        return redirect('cursos')->with('update', 'updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);

        $course->delete();

        return redirect('cursos');
    }
}
