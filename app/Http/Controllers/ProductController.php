<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $section = Section::all();
        $product = Product::all();
        return view('products.product', compact('section','product'));
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
       /* $validated = $request->validate([
            'product_name'  => 'required|unique:sections|max:255',
            'section_id'  => 'required',
            'description'   => 'required',
        ],[
            'product_name.required' => 'يـرجي إدخال أســم المنتــج',
            'product_name.unique'   => '  أســم المنتــج مسجــل مسبقــا',
            'section_id.required' => 'يـرجي إدخال أســم القســم',
            'description.required'  => 'يـرجي إدخال البيـان',


        ]);*/
        Product::create([
            'Product_name'  => $request->Product_name,
            'section_id'    => $request->section_id,
            'description'   => $request->description,
        ]);
        session()->flash('Add', 'تم اضافة المنتج بنجاح ');
        return redirect('/product');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      // fetch id الخــاص ب section_name
      $id = Section::where('section_name',$request->section_name)->first()->id;
      $product = Product::findOrFail($request->pro_id);

      $product->update([
        'Product_name'  => $request->Product_name,
        'description'   => $request->description,
        'section_id'    => $id,
    ]);
    session()->flash('edit', 'تم تـعديل المنتج بنجاح ');
    return redirect('/product');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
       $product= Product::findOrFail($request->pro_id);
       $product->delete();
        session()->flash('delete','تـم حــذف المنتــج بنجـاح');
            return redirect('/product');

    }
}
