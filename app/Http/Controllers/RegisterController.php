<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
        {
            // $newCheckUser = new User;
            // $newCheckUser = $newCheckUser->where('email', $email)->first();
            // if($newCheckUser)
            // {
            // Session::flash('error-message','Email '.$email.' đã tồn tại');
            // return Redirect::to('/register');
            // }
            try {
                    $credentials = request(['name','email', 'password','sdt','dob']);
                    $credentials['password'] = bcrypt($credentials['password']);
                    User::create($credentials);
                    // $newUser = new User;
                    // $pass = $request->input('password');
                    // $newUser->name = $request->input('name');
                    // $newUser->email = $request->input('email');
                    // $newUser->password = bcrypt($pass);
                    // $newUser->dob = $request->input('dob');
                    // $newUser->sdt = $request->input('sdt');
                    // $newUser->save();

                    return response()->json([
                        'success' => true,
                        'message' => 'create user successfull',
                    ], 200);
            } catch (Exception $error) {
                return response()->json([
                    'success' => false,
                    'message' => $error->getMessage(),
                ]);
            }
        }
}