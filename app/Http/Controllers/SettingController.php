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
        'setting' => $this->setting()
        ]);
    }
    
    public function store(Request $request)
    {
      $rules = [
        'company_name' => 'required|min:3|string',
        'company_address' => 'nullable',
        'company_phone' => 'required',
        'logo' => 'nullable|mimetypes:image/png,image/jpg,image/jpeg|max:1024',
        'member_card' => 'nullable|mimetypes:image/png,image/jpg,image/jpeg,image/webp|max:1024',
      ];
      
      $validatedData = $request->validate($rules);
      
      $validatedData['note_type'] = $request->note_type;
      $validatedData['discount'] = $request->discount;
      
      if($request->logo !== null) {
        $validatedData['logo'] = time() . '_' . $request->logo->getClientOriginalName();
        
        $request->logo->move('.', $validatedData['logo']);
        unlink('./' . $request->logoLama);
      }
      else {
        $validatedData['logo'] = $request->logoLama;
      }
      
      if($request->member_card !== null) {
        $validatedData['member_card'] = time() . '_' . $request->member_card->getClientOriginalName();
        
        $request->member_card->move('.', $validatedData['member_card']);
        unlink('.' . $request->kartuLama);
      }
      else {
        $validatedData['member_card'] = $request->kartuLama;
      }
      
      Setting::first()->update($validatedData);
      
      return redirect('/setting')->with('success', 'Data berhasil diperbarui');
    }
}
