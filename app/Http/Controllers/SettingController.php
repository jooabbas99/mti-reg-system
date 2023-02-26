<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use Validator;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::get();
        $data['result'] = ['method' => 'add'];
        return view('dashboard.Settings.form', $data, compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSettingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'logo' => 'required|mimes:jpeg,png,jpg,gif,svg',
            'favicon' => 'required',
            'footer_text' => 'required',
        ]);
        dd($request->all());

        if ($request->hasFile('logo')) {
            
            $logo = $request->file('logo');
            // dd($logo);
            $path = public_path('assets/images');
            $name = time() . rand(1, 99999) . "." . $logo->getClientOriginalExtension();
            // dd($name);
            $logo->move($path, $name);
        }

        if ($request->hasFile('favicon')) {
            //
            $favicon = $request->file('favicon');
            $path1 = public_path('assets/images');
            $name1 = time() . rand(1, 99999) . "." . $favicon->getClientOriginalExtension();
            $favicon->move($path1, $name1);
        }
        
        $settings = Setting::where('id', '1');
        $settings->logo = isset($name) ? $name : "";
        $settings->favicon = isset($name1) ? $name1 : "";
        $settings->footer_text = $request->footer_text;
        $settings->save();

        return redirect()->route('setting.index')->with('success', '<i class="icon-tick"></i><strong>Well done!</strong>, Success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSettingRequest  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'logo' => 'mimes:jpeg,png,jpg,gif,svg',
            'favicon' => 'mimes:jpeg,png,jpg,gif',
            'footer_text' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
            // return response()->json(['error' => $validator->errors()->all()]);
        } else {
        if ($request->hasFile('logo')) {
            
            $logo = $request->file('logo');
            // dd($logo);
            $path = public_path('assets/images');
            $name = time() . rand(1, 99999) . "." . $logo->getClientOriginalExtension();
            // dd($name);
            $logo->move($path, $name);
        }

        if ($request->hasFile('favicon')) {
            //
            $favicon = $request->file('favicon');
            $path1 = public_path('assets/images');
            $name1 = time() . rand(1, 99999) . "." . $favicon->getClientOriginalExtension();
            $favicon->move($path1, $name1);
        }

        $settings = Setting::where('id', '1')->first();
        if(isset($name) && !empty($name))
            $settings->logo = $name;
        if(isset($name1) && !empty($name1))
            $settings->favicon = $name1;
        $settings->footer_text = $request->footer_text;
        $settings->save();

        return redirect()->route('setting.index')->with('error', '<i class="icon-warning2"></i>Oh snap!, You can not edit this in demo version.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
