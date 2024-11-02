<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;


class AdminProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.profile.index');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:100'],
            'surname' => ['required', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email,' . Auth::user()->id],
            'phone' => ['required', 'max:15'],
            'image' => ['image', 'max:2048'],
        ]);

        $user = Auth::user();

        if ($request->hasFile('image')) {
            if(File::exists(public_path($user->image))){
                File::delete(public_path($user->image));
            }

            $image = $request->file('image');
            $imageName = rand() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads'), $imageName);

            $path ="/uploads/".$imageName;
            $user->image = $path;
        }

        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();

        toastr()->success('Profile Updated Successfully!');
        return redirect()->back();
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $request->user()->update([
            'password' => bcrypt($request->password)
        ]);

        toastr()->success('Password Updated Successfully!');

        return redirect()->back();
    }

}
