<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Storage; //add Student Model - Data is coming from the database via Model.

class ItemController extends Controller

{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function books()
    {
        $items = Item::all();
        $cat = Category::all();
        
        return view('items.books')->with('items', $items)->with('category', $cat);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function loan()
    {
        $items = Item::all();
        return view('items.loan')->with('items', $items);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::all();

        return view('items.index')->with('items', $items);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cat = Category::all();

        return view('items.create')->with('cat', $cat);
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
            'BookName'=> 'required',
            'Description'=> 'required',
            'Stock'=> 'required',
            'BookTypeID'=> 'required',
            'Publisher'=> 'required',
            'Year'=> 'required'
          ]);

        $input      = $request->all();
 

        $item_data = array(
            "BookName"     => $input['BookName'],
            'Description'  => $input['Description'],
            'BookTypeID'   => $input['BookTypeID'],
            'Stock'        => $input['Stock'],
            'Publisher'    => $input['Publisher'],
            'Year'         => $input['Year'],
        );

        Item::create($item_data);
        return redirect('item')->with('status', 'Item Addedd!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::find($id);
        return view('items.show')->with('items', $item);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {



        $item = Item::find($id);
        $cat = Category::all();

        return view('items.edit')->with('items', $item)->with('cat', $cat);
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
            'BookName'=> 'required',
            'Description'=> 'required',
            'Stock'=> 'required',
            'BookTypeID'=> 'required',
            'Publisher'=> 'required',
            'Year'=> 'required'
          ]);

        $item   = Item::find($id);
        $input  = $request->all();

        $item_data = array(
            "BookName"     => $input['BookName'],
            'Description'  => $input['Description'],
            'BookTypeID'   => $input['BookTypeID'],
            'Stock'        => $input['Stock'],
            'Publisher'    => $input['Publisher'],
            'Year'         => $input['Year'],
        );

        $item->update($item_data);
        return redirect('item')->with('status', 'Item Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Item::destroy($id);
        return redirect('item')->with('status', 'Item deleted!');
    }
}
