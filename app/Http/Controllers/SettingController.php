<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
      return view('admin.setting.index', [
        'title' => 'Setting',
        'setting' => Setting::first()
        ]);
    }
    
    public function store(Request $request)
    {
      $setting = Setting::first();
      
      $rules = [
        'company_name' => 'required|min:3|string',
        'company_address' => 'nullable',
        'company_phone' => 'required'
      ];
      
      //cek apakah ada logo 
      if(request()->hasFile('logo')) {
        $rules['logo'] = 'image|max:1024';
      }
      
      //cek apakah ada kartu member 
      if(request()->hasFile('member_card')) {
        $rules['member_card'] = 'image|max:1024';
      }
      
      $validatedData = $request->validate($rules);
      
      $validatedData['discount'] = $request->discount;
      
      if(request()->hasFile('logo')) {
        $logoName = time() . '_' . $request->logo->getClientOriginalName();
        
        $request->logo->move('image', $logoName);
        
        if($setting->logo !== 'logo.png' && $setting->logo !== null) {
          unlink("./image/$setting->logo");
        }
      }
      else {
        $logoName = $setting->logo;
      }
      
      if(request()->hasFile('member_card')) {
        $memberCardName = time() . '_' . $request->member_card->getClientOriginalName();
        
        $request->member_card->move('image', $memberCardName);
        
        if($setting->member_card !== 'member_card.jpg' && $setting->member_card !== null) {
          unlink("./image/$setting->member_card");
        }
      }
      else {
        $memberCardName = $setting->member_card;
      }

      $setting = Setting::first();
      $setting->company_name = $request->company_name;
      $setting->company_phone = $request->company_phone;
      $setting->company_address = $request->company_address;
      $setting->discount = $request->discount;
      $setting->logo = $logoName;
      $setting->member_card = $memberCardName;
      $setting->update();
      
      return response()->json(Setting::first());
    }
}
