<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;

class CountriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Country::get();
        return view('admin.countries.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.countries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Country::create([
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'currency' => $request->currency,
            'currency_symbol' => $request->currency_symbol
        ]);
        return redirect()->back()->with('success', 'Country Added Successfully');
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
        $record = Country::find($id);
        return view('admin.countries.edit', compact('id', 'record'));
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
        $country  = Country::find($id);
        $country->update([
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
            'currency' => $request->currency,
            'currency_symbol' => $request->currency_symbol
        ]);
        return redirect()->back()->with('success', 'Done Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cities = City::where('country_id', $id)->count();
        if ($cities > 0) {
            return redirect()->back()->with('error', 'Country in use');
        }
        Country::destroy($id);
        return redirect()->back()->with('success', 'Country Delete Successfully');
    }
}
