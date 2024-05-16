<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Str;
use Storage;
use Illuminate\Support\Facades\Response;
use GuzzleHttp\Client;
use App\Jobs\NotificationJob;
use App\Http\Requests\CompanyUpdateRequest;

/**
 * Controller for handling Companies create, read, update, delete actions.
 * Also has export csv file and map functions
 */
class CompanyController extends Controller
{

     /**
     * Display a listing of the Companies.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->has('status')) {
            $status = strtolower($request->status);
            if($status=='active'){
                $company = Company::paginate(10);
            }elseif($status=='inactive'){
                $company = Company::onlyTrashed()->paginate(10);
            }else{
                $company = Company::withTrashed()->paginate(10);
            }
            return view("companies", compact("company"));
        }
        if ($request->has('search')) {
            $search = strtolower($request->search);
            if($search!=''){
                $company = Company::whereRaw('LOWER(name) like ?', ['%'.$search.'%'])->withTrashed()->paginate(10);
            }else{
                $company = Company::whereRaw('LOWER(name) like ?', ['%'.$search.'%'])->paginate(10);
            }
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

        $logo=$request->file("logo");

        $filename = Str::random(20) . '.' . $logo->getClientOriginalExtension();
        $path = $logo->storeAs('public', $filename);
        $url = Storage::url($path);

        $company = new Company();
        $company->name = $request->name;
        $company->email = $request->email;
        $company->logo = $url;
        $company->website = $request->website;
        $company->location=$request->location;
        
        try {
        $company->save();
        //NotificationJob::dispatch($company->email,$company->name);
        return redirect()->route('company.index')->with('success', 'Company created successfully');
        } catch(\Exception $e) {
        return redirect()->route('company.create')->withInput()->with('error', 'Company not created');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $company=Company::withTrashed()->withCount('employee')->findOrFail($id);
        return view('companyDetails',compact('company'));
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
    public function update(CompanyUpdateRequest $request, string $id)
    {
        $request->validated();
        $company= Company::find($id);
        $company->name = $request->name;
        $company->email = $request->email;
        $company->website=$request->website;
        $company->location=$request->location;

        if($request->file("logo")){
        $logo=$request->file("logo");
        $filename = Str::random(20) . '.' . $logo->getClientOriginalExtension();
        $path = $logo->storeAs('public', $filename);
        $url = Storage::url($path);
        $company->logo = $url;
      }

      try {
        $company->save();
        return redirect()->back()->with('success', 'Company updated successfully');
     } catch(\Exception $e) {
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
        $company = Company::withTrashed()->findOrFail($id);
        if($company->deleted_at!=null) {
            $company->forceDelete();
            return redirect()->route('company.index')->with('success', 'Company deleted Permanantly');
        } else {
            $company->delete();
            return redirect()->route('company.index')->with('success', 'Company deleted successfully');
        }
        
    }


    /**
     * Re-Store the soft deleted company from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Request $request)
    {
        $company = Company::withTrashed()->findOrFail($request->id);
        $company->restore();
        return redirect()->back()->with('success', 'Company Re-Stored successfully');
    }


    /**
    * Export companies data to a CSV file.
    *
    * This function exports the data of all companies to a CSV file.
    * @return \Illuminate\Http\Response
    */
    public function export()
    {
        $companies = Company::all();

        $csv = \League\Csv\Writer::createFromString('');
        $csv->insertOne(['ID', 'Name', 'Email', 'Website', 'Location']);

        foreach ($companies as $company) {
            $csv->insertOne([$company->id, $company->name, $company->email, $company->website, $company->location]);
        }

        $filename = 'companies.csv';

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }


     /**
     * Fetches latitude and longitude coordinates for a given city using the OpenWeatherMap API.
     *
     * @param  \Illuminate\Http\Request  $request
     * returns the latitude and longitude of the requested city in Json
     *
     */
     public function map(Request $request){
        $city=$request->location;
        $client = new Client();
        $url = 'http://api.openweathermap.org/geo/1.0/direct';

        // Parameters for the API call
        $params =[
            'query' =>[
                'q' => $city,
                'limit' => 5,
                'appid' => '353fd06db73e87078db855a3e3cae3be'
            ]
        ];

        // Make the API call
        try {
            $response = $client->request('GET', $url, $params);
            $data = json_decode($response->getBody(), true);
            $res=['lat'=>$data[0]['lat'],'lon'=>$data[0]['lon']];
            echo json_encode($res);
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    
}
