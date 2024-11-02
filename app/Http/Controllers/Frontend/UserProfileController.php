<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Traits\ImageUploadTrait;

class UserProfileController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('frontend.profile.index');
    }

    /**
     * Update the specified resource in storage.
     */

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:15'],
        ]);

        $user = Auth::user();
        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');

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
