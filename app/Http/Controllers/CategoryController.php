<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage; //add Student Model - Data is coming from the database via Model.

class CategoryController extends Controller

{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Category::all();
        return view('category.index')->with('items', $items);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

          $request->validate([
          'BookType'=> 'required'
        ]);
        $input      = $request->all();
       

        $item_data = array(
            "BookType"     => $input['BookType'],
        
        );

        Category::create($item_data);
        return redirect('category')->with('status', 'Category Addedd!');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Category::find($id);

        return view('category.edit')->with('items', $item);
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

        $request->validate([
            'BookType'=> 'required'
          ]);
        $item   = Category::find($id);
        $input  = $request->all();

      
        $item_data = array(
            "BookType"     => $input['BookType']
        );

        $item->update($item_data);
        return redirect('category')->with('status', 'Jenis Buku Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::destroy($id);
        return redirect('category')->with('status', 'Item deleted!');
    }
}
