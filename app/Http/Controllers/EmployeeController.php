<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $companyId = $request->id;
        if ($companyId) {
            $employees = Employee::where('company_id', $companyId)->get();
        } else {
            $employees = Employee::all();
        }
    
        return view("employees", ['emp' => $employees]);
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
        $fname= $request->fname;
        $lname= $request->lname;
        $email= $request->email;
        $phone= $request->phone;
        $company_id= $request->company_id;

        $employee = new Employee();
        $employee->fname = $fname;
        $employee->lname = $lname;
        $employee->email = $email;
        $employee->phone = $phone;
        $employee->company_id = $company_id;
        try{
        $employee->save();
        return redirect()->route('home')->with('success', 'Employee created successfully');
        }catch(\Exception $e){
        // Redirect or return response
        return redirect()->route('home')->with('error', $e->getMessage());
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
        $emp= Employee::find($id);
        $emp->fname = $request->fname;
        $emp->lname = $request->lname;
        $emp->email = $request->email;
        $emp->phone = $request->phone;
        try{
            $emp->save();
            return redirect()->back()->with('success', 'Employee updated successfully');
          }catch(\Exception $e){
          // Redirect or return response\
          return $e->getMessage();
          return redirect()->route('home')->with('error', 'Employee not updated');
          }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::find($id);
        $employee->delete();
        return redirect()->back()->with('success','Employee deleted');
    }
}
