<?php

namespace App\Http\Controllers;

use App\products;
use App\sections;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = products::all();
        $sections = sections::all();
        return view('products.products', compact('sections','products'));

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
        //
        $validatedData = $request->validate([
            'product_name' => 'required|unique:products|max:255',
            'section_id' => 'required',
            'description' => 'required',
        ],[
            'product_name.required' => 'يرجي ادخال أسم المنتج',
            'product_name.unique' => 'أسم المنتج مسجل مسبقا',
            'section_id.required' => 'يرجي أختيار البنك',
            'description.required' => 'يرجي ادخال التفاصيل',
        ]);
        products::create([
            'product_name' => $request->product_name,
            'section_id' => $request->section_id,
            'description' => $request->description,
        ]);
        session()->flash('Add', 'تم اضافة المنتج بنجاح ');
        return redirect('/products');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //

        $product_id = $request->id;

        $validatedData = $request->validate([
            'product_name' => 'required|max:255,product_name,'.$product_id,
            'section_name' => 'required',
            'description' => 'required',
        ],[
            'product_name.required' => 'يرجي ادخال أسم المنتج',
            'section_name.required' => 'يرجي أختيار البنك',
            'description.required' => 'يرجي ادخال التفاصيل',
        ]);



        $id = sections::where('section_name', $request->section_name)->first()->id;

        $products = products::findOrFail($request->product_id);
 
        $products->update([
        'product_name' => $request->product_name,
        'description' => $request->description,
        'section_id' => $id,
        ]);
 
        session()->flash('Edit', 'تم تعديل المنتج بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $products = products::findOrFail($request->product_id);
        $products->delete();
        session()->flash('delete', 'تم حذف المنتج بنجاح');
        return back();
    }
}
