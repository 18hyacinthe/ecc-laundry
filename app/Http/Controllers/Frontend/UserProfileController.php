<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
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
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $user = Auth::user();

        if ($request->hasFile('image')) {
            if (\File::exists(public_path($user->image))) {
                \File::delete(public_path($user->image));
            }

            $image = $request->file('image');
            $imageName = rand() . '_' . $image->getClientOriginalName();
            $image->move(public_path('profile'), $imageName);

            $path = "/profile/" . $imageName;
            $user->image = $path;
        }

        $user->save();

        toastr()->success('Profile Updated Successfully!');
        return redirect()->back();
    }
}
