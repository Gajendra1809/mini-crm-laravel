<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Company;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $companyId = $request->id;
        if ($companyId) {
            //$employees = Employee::where('company_id', $companyId)->get();
            $company=Company::find($companyId);
            if ($request->ajax()) {
                $data = Employee::where('company_id', $companyId)->get();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $actionBtn = '<button onclick="openform('.htmlspecialchars(json_encode($row)).')">Edit</button> <button onclick="deletefun('.$row->id.')">Delete</button>';
                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('employees',compact('company'));
        } else {
            if ($request->ajax()) {
                $data = Employee::latest()->get();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $actionBtn = '<button onclick="openform('.htmlspecialchars(json_encode($row)).')">Edit</button> <button onclick="deletefun('.$row->id.')">Delete</button>';
                        return $actionBtn;
                    })
                    ->addColumn('company',function($row){
                        return $row->company->name;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('employeeDash');
        }

        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $company = Company::all();
        return view("addEmployee", compact("company"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request)
    {
        $request->validated();
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
        return redirect()->route('employee.create')->with('success', 'Employee created successfully');
        }catch(\Exception $e){
        return redirect()->route('employee.create')->withInput()->with('error', 'Employee not created');
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
        $request->validate([
            "fname"=>"required",
            "lname"=>"required",
            "email"=>"email",
            "phone"=>"required|min:10"
        ]);
        $emp= Employee::find($id);
        $emp->fname = $request->fname;
        $emp->lname = $request->lname;
        $emp->email = $request->email;
        $emp->phone = $request->phone;
        try{
            $emp->save();
            return redirect()->back()->with('success', 'Employee updated successfully');
          }catch(\Exception $e){
          return redirect()->back()->with('error', 'Employee not updated');
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
