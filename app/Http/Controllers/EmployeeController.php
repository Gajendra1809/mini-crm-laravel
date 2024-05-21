<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\EmpUpdateRequest;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Company;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

/**
 * Controller for handling Employees create, read, update, delete actions.
 * Also has export csv file function
 */
class EmployeeController extends Controller
{
 
    /**
    * Display a listing of employees.
    *
    * This method retrieves either all employees or employees belonging to a specific company,
    * depending on whether a company ID is provided in the request. If the request is made via AJAX,
    * the data is formatted as JSON using DataTables for easy rendering in the front end.
    * If no company ID is provided, the method returns a view for the employee dashboard.
    *
    * @param  \Illuminate\Http\Request  $request
    *
    */
    public function index(Request $request)
    {
        $companyId = $request->id;
        if ($companyId) {
            $company=Company::withTrashed()->find($companyId);
            if ($request->ajax()) {
                $data = Employee::where('company_id', $companyId)->get();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        return '<button onclick="openform('.htmlspecialchars(json_encode($row)).')">Edit</button> <button onclick="deletefun('.$row->id.')">Delete</button>';
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
                        return '<button onclick="openform('.htmlspecialchars(json_encode($row)).')">Edit</button> <button onclick="deletefun('.$row->id.')">Delete</button>';
                    })
                    ->addColumn('company_name',function($row){
                        return $row->company?$row->company->name:'Company not found';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('employeedash');
        }
    }


    /**
     * Show the form for creating a new employee.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        if($request->has('id')){
            $companyData=Company::where('id',$request->id)->first();
            $company = Company::all();
            return view("addEmployee", compact("company","companyData"));
        }
        $companyData="";
        $company = Company::all();
        return view("addEmployee", compact("company","companyData"));
    }


    /**
     * Store a newly created employee in storage.
     *
     * @param  \App\Http\Requests\EmployeeRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(EmployeeRequest $request)
    {
        $request->validated();

        $employee = new Employee();
        $employee->fname = $request->fname;
        $employee->lname = $request->lname;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->company_id = $request->company_id;

        session::put('url',url()->previous());
        try {
        $employee->save();
        return redirect()->route('employee.index',['id' => $request->company_id])->with('success', 'Employee created successfully');
        } catch(\Exception $e) {
        return redirect(session::get('url'))->withInput()->with('error', 'Employee not created, Email already exists...');
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
     * Update the specified employee in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(EmpUpdateRequest $request, string $id)
    {
        $request->validated();
        $emp= Employee::find($id);
        $emp->fname = $request->fname;
        $emp->lname = $request->lname;
        $emp->email = $request->email;
        $emp->phone = $request->phone;
        try {
            $emp->save();
            return redirect()->back()->with('success', 'Employee updated successfully');
          } catch(\Exception $e) {
            return redirect()->back()->with('error', 'Employee not updated');
          }
    }


    /**
     * Remove(soft delete) the specified employee from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        $employee = Employee::find($id);
        $employee->delete();
        return redirect()->back()->with('success','Employee deleted');
    }

    
    /**
    * Export employees data to a CSV file.
    *
    * This function exports the data of all/specified employees to a CSV file.
    * @return \Illuminate\Http\Response
    */
    public function export(Request $request)
    {
        if($request->has('id')){
            $employees = Employee::where('company_id',$request->id)->get();
        }else{
        $employees = Employee::all();
        }
        $csv = \League\Csv\Writer::createFromString('');
        $csv->insertOne(['ID', 'First Name', 'Last Name', 'Email', 'Company', 'Phone']);

        foreach ($employees as $employee) {
           $csv->insertOne([$employee->id, $employee->fname, $employee->lname, $employee->email, $employee->company->name, $employee->phone]);
        }

        $filename = 'employees.csv';

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }
    
}
