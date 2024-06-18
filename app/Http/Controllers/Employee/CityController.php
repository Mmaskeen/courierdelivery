<?php

namespace App\Http\Controllers\Employee;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
Use App\Traits\ShipmentDispatch;

class CityController extends Controller
{
    use ShipmentDispatch;
    public function allCity(Request $request)
    {
        if ($request->searchCity){
            $q = City::where('name','LIKE','%'.$request->searchCity.'%')->get();
        }else{
            $q  = City::all();
        }
        $cities = $q;

        return view('employee.city.all-city',compact('cities'));
    }

    public function create()
    {
        return view('employee.city.create-city');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $city = City::create([
            'name' => $request->name
        ]);

        return redirect(route('employee_all_city'))->with('success','City Created successfully');;
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $city = City::findOrFail($id);

        return view('employee.city.edit-city',compact('city'));
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
        $city = City::findOrFail($id);

        $city->update([
            'name' => $request->name
        ]);

        return redirect(route('employee_all_city'))->with('success','City updated successfully');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $city->delete();

        return redirect(route('employee_all_city'))->with('success','City deleted successfully');
    }

    public function dispatchCity(Request $request)
    {
        if ($request->type == 'Tcs' || $request->type == 'Stallion'){
            $cities = City::where('type',$request->type)->get();
        }else if($request->type=='PostEx'){
            $cities = $this->getCitiesByAPI('PostEx');
        }else if($request->type=='BlueEx'){
            $cities = $this->getCitiesByAPI('BlueEx');
        }else if($request->type=='StallionDelivery'){
            $cities = $this->getCitiesByAPI('StallionDelivery');
        }else{
            $cities = City::where('name','Karachi')->where('type','Tcs')->get();
        }

        return response()->json([
           'status' =>  'success',
           'cities' =>  $cities,
           'type'=>$request->type
        ]);
    }

}
