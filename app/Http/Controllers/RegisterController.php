<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
        {

            try {
                    $credentials = request(['name','email', 'password','sdt','dob']);
                    $credentials['password'] = bcrypt($credentials['password']);
                    User::create($credentials);

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