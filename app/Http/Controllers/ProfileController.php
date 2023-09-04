<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        $imgName = Auth::user()->img;
        if ($request->img != '' || $request->img != null) {
            $path = public_path() . "\imgs\profile";
            //validation for product details
            $validate = [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'img' => 'max:10000|mimes:jpg, png, jpeg',
            ];
            $img = $request->img;
            $imgName = time() . $img->getClientOriginalName();
            $img->move(public_path() . '/imgs/profile', $imgName);

            //check if img not empty in db
            if ($imgName != '' || $imgName != null) {
                $imgOld = $path . '\\' . Auth::user()->img;
                unlink($imgOld);
            }

        }

            Auth::user()->img = $imgName;
            $request->user()->save();

        // $request->user()->fill($request->validated());

        // if ($request->user()->isDirty('email')) {
        //     $request->user()->email_verified_at = null;
        // }

        // $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
