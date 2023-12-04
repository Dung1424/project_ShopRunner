<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProfileController
{
    public function Profile()
    {
        return view("pages.customer.Profile.profile");
    }
    public function EditProfile(){
        return view("pages.customer.Profile.edit-profile");
    }
    public function updateProfile (Request $request)
    {
        // Validate the form input
        $request->validate([
            "name"=>"required|min:6",
            "address"=>"required",
            "tel"=> "required|min:9|max:11",
            "email"=>"required",
            //   'thumbnail' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust file types and size limit as needed
        ]);

        try {
            $user = Auth::user();

            $thumbnail = $user->thumbnail;

            // Handle file upload
            if ($request->hasFile("thumbnail")) {
                $path = public_path("images");
                $file = $request->file("thumbnail");
                $file_name = Str::random(5) . time() . Str::random(5) . "." . $file->getClientOriginalExtension();
                $file->move($path, $file_name);
                $thumbnail = "/images/" . $file_name;
            }

            $user->update([
                "name" => $request->input("name"),
                "email" => $request->input("email"),
                "tel" => $request->input("tel"),
                "address" => $request->input("address"),
                "thumbnail" => $thumbnail,
            ]);

            return redirect()->to('/profile'); // Redirect to the profile page after successful update
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage()); // Pass the error message to the view
        }
    }
}
