<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SalesChannelsType;
use Illuminate\Http\Request;

class ShopTypeController extends Controller
{

    function __construct()
    {
        $this->page = 'shopType';
        $this->pages = 'shopTypes';
    }
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page =  $this->page;
        $pages =  $this->pages;
        $records = SalesChannelsType::get();
        return view('admin.sellChannels.sellChannelsTypes.index',compact('page','pages','records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = 'store';
        $page =  $this->page;
        $pages =  $this->pages;
        return view('admin.sellChannels.sellChannelsTypes.control',compact('action','page','pages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        SalesChannelsType::create([
            'title_en'=>$request->title_en,
            'title_ar'=>$request->title_ar
        ]);
        return redirect()->back()->with('success', $this->page . 'Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $action = 'update';
        $page =  $this->page;
        $pages =  $this->pages;
        $data = SalesChannelsType::find($id);
        return view('admin.sellChannels.sellChannelsTypes.control',compact('action','page','pages','data'));
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
        $data = SalesChannelsType::find($id);
        $data->update([
            'title_en'=>$request->title_en,
            'title_ar'=>$request->title_ar
        ]);
        return redirect()->back()->with('success', $this->page . 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
