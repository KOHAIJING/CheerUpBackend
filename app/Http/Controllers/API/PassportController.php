<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;

class PassportController extends Controller
{
  public $successStatus = 200;
  /**
   * login api
   *
   * @return \Illuminate\Http\Response
   */
   public function login(Request $request)
   {
      $validator = Validator::make($request->all(), [
          'email' => 'required|string',
          'password' => 'required|string|min:4|max:6',
      ]);
      if ($validator->fails()) {
          return response()->json(['error'=>$validator->errors(), 'message' => 'Invalid Email Or Password', 'status' => false], 401);
      }

      if(Auth::attempt(['email' => request('email'),'password' => request('password')])){
          $user = Auth::user();
          if ($user->tokens->count() > 0) {
          $user->tokens()->delete();
          }
          $token = $user->createToken('MyApp')->accessToken;
          return response()->json(['accessToken' => $token, 'message' => 'Login Successfully', 'status' => true], $this->successStatus);
      }
      else{
          return response()->json(['error'=>'Wrong Email Or Password', 'message' => 'Wrong Username Or Password', 'status' => false], 401);
      }
    }

  /**
   * Register api
   *
   * @return \Illuminate\Http\Response
   */
  public function register(Request $request)
  {
      $validator = Validator::make($request->all(), [
          'name' => 'required|string|unique:users',
          'email' => 'required|string|email|unique:users',
          'age' => 'required',
          'gender' => 'required',
          'country' => 'required',
          'race' => 'required',
          'height' => 'required',
          'weight' => 'required',
          'illness' => 'nullable',
          'password' => 'required|string|min:4|max:6',
          'c_password' => 'required|same:password',
      ]);
      if ($validator->fails()) {
          return response()->json(['error'=>$validator->errors(), 'message' => 'Invalid Input', 'status' => false], 401);
      }
      $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'age' => $request->age,
            'gender' => $request->gender,
            'country' => $request->country,
            'race' => $request->race,
            'height' => $request->height,
            'weight' => $request->weight,
            'illness' => $request->illness,
            'password' => bcrypt($request->password),
      ]);
      $user->save();
      return response()->json(['message' => 'User Registered Successfully', 'status' => true], $this->successStatus);
  }

  /**
   * details api
   *
   * @return \Illuminate\Http\Response
   */

  public function logout(Request $request) {
    $user = Auth::user()->token()->delete();
    return response()->json(['message' => 'Logged Out Successfully'], $this->successStatus);
  }

  public function user(Request $request) {
    return response()->json(Auth::User(), $this->successStatus);
  }

  public function users(Request $request) {
    $users = User::get();
    return response()->json($users, $this->successStatus);
  }

  public function resetPassword(Request $request) {
    $validator = Validator::make($request->all(), [
        'email' => 'required|string|email',
    ]);
    if ($validator->fails()) {
        return response()->json(['error'=>$validator->errors(), 'message' => 'Invalid Email', 'status' => false], 401);
    }
    $user = User::where('email', $request->email)->first();
    if ($user != null) {
      $newPass = str_random(6);
      $user->password = bcrypt($newPass);
      $user->save();
      try{
        Mail::to($user)->send(new ResetPassword($user->email, $newPass));
      }
      catch(Exception $e){
        return response()->json(['message' => 'Failed To Send Email To User', 'status' => false], 402);
      }
      return response()->json(['message' => 'User Password Reset Successfully. Please check your email.', 'status' => true], $this->successStatus);
    }
    else
    {
        return response()->json(['message' => 'Email has not been registered', 'status' => false], 401);
    }
  }

  public function changeProfile(Request $request) {
    $validator = Validator::make($request->all(), [
      'name' => 'required|string',
      'age' => 'required',
      'gender' => 'required',
      'country' => 'required',
      'race' => 'required',
      'height' => 'required',
      'weight' => 'required',
      'illness' => 'nullable',
    ]);
    if ($validator->fails()) {
        return response()->json(['error'=>$validator->errors(), 'message' => 'Invalid Input', 'status' => false], 401);
    }
    $user = Auth::User();
    $user->name = $request->name;
    $user->age = $request->age;
    $user->gender = $request->gender;
    $user->country = $request->country;
    $user->race = $request->race;
    $user->height = $request->height;
    $user->weight = $request->weight;
    $user->illness = $request->illness;
    $user->save();
    return response()->json(['message' => 'User Profile Updated Successfully', 'status' => true], $this->successStatus);
  }

  public function changePassword(Request $request) {
    $validator = Validator::make($request->all(), [
        'oldPassword' => 'required|string|min:4|max:6',
        'newPassword' => 'required|string|min:4|max:6',
        'c_newPassword' => 'required|same:newPassword'
    ]);
    if ($validator->fails()) {
        return response()->json(['error'=>$validator->errors(), 'message' => 'Invalid Input', 'status' => false], 401);
    }
      $user = Auth::User();
    if(Hash::check($request->oldPassword, $user->password)) {
        $user->password = bcrypt($request->newPassword);
        $user->save();
        $user->token()->delete();
      return response()->json(['message' => 'User Password Updated Successfully', 'status' => true], $this->successStatus);
    }
    else {
      return response()->json(['message' => 'Incorrect Old Password', 'status' => false], 402);
    }
  }
}
