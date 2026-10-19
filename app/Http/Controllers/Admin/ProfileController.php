<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\DataStore;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $u = Auth::user() ?? User::first();
        $dsProfile = DataStore::getCollection('admin_profile');
        $dsData = !empty($dsProfile) ? (array)end($dsProfile) : [];
        $sessionData = session('admin_profile_data', []);

        $merged = array_merge([
            'id' => 1,
            'first_name' => 'Shahzade',
            'last_name' => 'Alam',
            'email' => 'shahzade.alam707@gmail.com',
            'phone' => '+91 9648777223',
            'designation' => 'Platform Lead & Administrator',
            'company' => 'DewaSharif Management',
            'field' => 'Individual',
            'gender' => 'Male',
            'address' => 'Dewa Sharif, Barabanki, UP - 225301',
            'postal_code' => '225301',
            'bio' => 'DewaSharif portal lead and community manager.',
            'photo' => null,
            'is_active' => true,
        ], $dsData, $sessionData);

        if ($u) {
            foreach ($merged as $k => $v) {
                if (!empty($u->$k)) {
                    $merged[$k] = $u->$k;
                }
            }
        }

        $user = (object)$merged;

        return view('admin.profile.index', compact('user'));
    }

    public function update(Request $request, $id = null)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:5120',
        ]);

        $user = Auth::user() ?? User::find($id) ?? User::first();

        $data = $request->only([
            'first_name', 'last_name', 'phone', 'field', 'gender',
            'designation', 'company', 'address', 'postal_code', 'bio'
        ]);

        // If user exists, get current photo
        $existingPhoto = $user ? ($user->photo ?? null) : null;
        if (!$existingPhoto) {
            $ds = DataStore::getCollection('admin_profile');
            $existingPhoto = !empty($ds) ? (end($ds)['photo'] ?? null) : null;
        }

        if ($request->hasFile('photo')) {
            try {
                $file = $request->file('photo');
                $destinationPath = public_path('uploads/profile');

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                if ($existingPhoto && file_exists(public_path($existingPhoto))) {
                    @unlink(public_path($existingPhoto));
                }

                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $fileName);
                $data['photo'] = 'uploads/profile/' . $fileName;
            } catch (\Throwable $e) {
                // Fallback to existing photo
                if ($existingPhoto) {
                    $data['photo'] = $existingPhoto;
                }
            }
        } else {
            if ($existingPhoto) {
                $data['photo'] = $existingPhoto;
            }
        }

        // Update DB User model if available
        if ($user) {
            try {
                $data['name'] = trim(($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? ''));
                $user->fill($data);
                $user->save();
            } catch (\Throwable $e) {}
        } else {
            // Create user in DB if none exists
            try {
                $data['name'] = trim(($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? ''));
                $data['email'] = 'shahzade.alam707@gmail.com';
                $data['password'] = bcrypt('password');
                $user = User::create($data);
                Auth::login($user);
            } catch (\Throwable $e) {}
        }

        // Persist to DataStore JSON fallback
        $dsList = DataStore::getCollection('admin_profile');
        if (!empty($dsList)) {
            DataStore::updateItem('admin_profile', 1, $data);
        } else {
            $data['id'] = 1;
            DataStore::addItem('admin_profile', $data);
        }

        // Save into session for immediate UI updates
        session(['admin_profile_data' => array_merge(session('admin_profile_data', []), $data)]);

        return redirect()
            ->route('admin.profile.index')
            ->with('success', 'Profile photo and information updated successfully.');
    }
}

