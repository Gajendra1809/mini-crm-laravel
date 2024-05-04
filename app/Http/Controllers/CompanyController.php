<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Notifications\NewCompanyRegistration;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Str;
use Storage;
use Notification;


class CompanyController extends Controller
{
     /**
     * Display a listing of the Companies.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */    public function index(Request $request)
    {
        if ($request->has('search')) {
            $search = strtolower($request->search);
            $company = Company::whereRaw('LOWER(name) like ?', ['%'.$search.'%'])->paginate(10);
            return view("companies", compact("company"));
        }
        $company = Company::paginate(10);
        return view("companies", compact("company"));
    }

    /**
     * Show the form for creating a new Company.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('addCompany');
    }

    /**
     * Store a newly created company in storage.
     *
     * @param  \App\Http\Requests\CompanyRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CompanyRequest $request,)
    {
        $request->validated();
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
        //Notification::route('mail', $company->email)->notify(new NewCompanyRegistration($name));
        return redirect()->back()->with('success', 'Company created successfully');
        }catch(\Exception $e){
        return redirect()->route('company.create')->withInput()->with('error', 'Company not created');
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
     * Update the specified company in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "name"=>"required|min:5",
            "email"=>"email",
            "logo"=>"file|mimes:png,jpg",
            "website"=>"required"
        ]);
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
        return redirect()->back()->with('error', 'Company not updated');
    }
    }

    /**
     * Remove(soft delete) the specified company from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return redirect()->route('company.index')->with('success', 'Company deleted successfully');
    }
}
