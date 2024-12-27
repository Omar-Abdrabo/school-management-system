<?php

namespace App\Http\Controllers;

use App\Http\Traits\AttachFilesTrait;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use AttachFilesTrait;

    public function index()
    {
        $collection = Setting::all();
        $setting = $collection->mapWithKeys(function ($setting) {
            return [$setting['key'] => $setting['value']];
        });
        return view('pages.setting.index', compact('setting'));
    }

    public function update(Request $request)
    {
        try {
            $info = $request->except('_token', '_method', 'logo');
            foreach ($info as $key => $value) {
                Setting::where('key', $key)->update(['value' => $value]);
            }
            if ($request->hasFile('logo')) {
                $logo_name = $request->file('logo')->getClientOriginalName();
                $this->deleteFile(Setting::where('key', 'logo')->first()->value, 'logo');
                Setting::where('key', 'logo')->update(['value' => $logo_name]);
                $this->uploadFile($request, 'logo', 'logo');
            }
            toastr()->success(trans('messages.Update'));
            return back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
