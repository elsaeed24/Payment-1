<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $section = Section::all();

        return view('sections.section', compact('section'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*$input = $request->all();

        // التاكد من وجود القسم مسبقا

        $s_exists = Section::where('section_name','=',$input['section_name'])->exists();

        if($s_exists){
            session()->flash('Error','خطـأ القــسم مسجـل مسبقـا');
             return redirect('/section');
        }else{*/
            $validated = $request->validate([
                'section_name'  => 'required|unique:sections|max:255',
                'description'   => 'required',
            ],[
                'section_name.required' => 'يـرجي إدخال أســم القســم',
                'section_name.unique'   => '  أســم القســم مسجــل مسبقــا',
                'description.required'  => 'يـرجي إدخال البيـان',



            ]);
            Section::create([
                'section_name'=> $request->section_name,
                'description'=> $request->description,
                'created_by'=> (Auth::user()->name)
            ]);
            session()->flash('Add','تـم إضافة القـسم بنجـاح');
            return redirect('/section');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;

        $this->validate($request,[
            'section_name'  => 'required|unique:sections,section_name|max:255'.$id,
            'description'   => 'required',
        ],[
            'section_name.required' => 'يـرجي إدخال أســم القســم',
            'section_name.unique'   => '  أســم القســم مسجــل مسبقــا',
            'description.required'  => 'يـرجي إدخال البيـان',
        ]);
        $section = Section::find($id);
    $section->update([
            'section_name'  =>$request->section_name,
            'description'   =>$request->description,

        ]);
        session()->flash('edit','تـم تعـديل القســم بنجــاح');
            return redirect('/section');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id= $request->id;
        Section::find($id)->delete();
        session()->flash('delete','تـم حــذف القســـم بنجـاح');
            return redirect('/section');

    }
}
