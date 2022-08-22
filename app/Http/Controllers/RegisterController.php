<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Models\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken(env('TOKEN_KEY'))->plainTextToken;
        $success['name'] = $user->name;

        return $this->sendResponse($success, 'User register successfully');
    }

    public function login(Request $request)
    {
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 403);
        }

        $user = Auth::user();
        $success = [];
        $success['token'] = $user->createToken(env('TOKEN_KEY'))->plainTextToken;
        $success['name'] = $user->name;

        return $this->sendResponse($success, 'User login successfully');
    }
}
