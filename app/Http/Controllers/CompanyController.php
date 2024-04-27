<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Str;
use Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $company = Company::all();
        return view("companies", compact("company"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $name= $request->name;
        $email= $request->email;
        $logo=$request->file("logo");
        $website= $request->website;


    $filename = Str::random(20) . '.' . $logo->getClientOriginalExtension();

    $path = $logo->storeAs('public', $filename);
    $url = Storage::url($path);
    $company = new Company();
    $company->name = $name;
    $company->email = $email;
    $company->logo = $url;
    $company->website = $website;
    try{
    $company->save();
    return redirect()->route('home')->with('success', 'Company created successfully');
    }catch(\Exception $e){
    // Redirect or return response
    return redirect()->route('home')->with('error', 'Company not created');
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
      $company= Company::find($id);
      $company->name = $request->name;
      $company->email = $request->email;
      $company->website=$request->website;

      if($request->file("logo")){
      $logo=$request->file("logo");
      $filename = Str::random(20) . '.' . $logo->getClientOriginalExtension();
      $path = $logo->storeAs('public', $filename);
      $url = Storage::url($path);
      $company->logo = $url;
      }

      try{
      $company->save();
      return redirect()->back()->with('success', 'Company updated successfully');
    }catch(\Exception $e){
    // Redirect or return response\
    return redirect()->route('home')->with('error', 'Company not updated');
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    $company = Company::findOrFail($id);
    $company->delete();
    return redirect()->route('company.index')->with('success', 'Company deleted successfully');
    }
}
