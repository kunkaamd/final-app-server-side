<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\User;
use JWTAuth;
use JWTAuthException;
use Hash;
use App\Http\Requests\RegisterUserRequest;
class ApiUserController extends Controller
{
  private $user;

  public function __construct(User $user){
      $this->user = $user;
  }

  public function register(Request $request){
      $validator = Validator::make($request->all(),[
          'name' => 'required|between:6,255',
          'email' => 'required|email|unique:users,email',
          'password' => 'required|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/'
      ],[
          'name.required' => 'A name is required',
          'email.required'  => 'A email is required',
          'password.required'  => 'A password is required',
          'email.unique' => 'A email has already been taken',
          'email.email' => 'A email is not E-MAIL',
          'name.between' => 'A name is between 6 - 255 characters',
          'password.regex' => 'Password is minimum 8 characters, at least 1 letter and 1 number'
      ]);
      if ($validator->fails()) {
        return response()->json([
            'status'=> 400,
            'message'=> 'Something error happens',
            'errors'=>$validator->errors(),
        ],400);
      }
      $user = $this->user->create([
        'name' => $request->get('name'),
        'email' => $request->get('email'),
        'password' => Hash::make($request->get('password')),
        'avatar' => 'avatar-none.png',
      ]);
      $token = JWTAuth::fromUser($user);
      return response()->json([
          'status'=> 200,
          'message'=> 'User created successfully',
          'user'=>$user,
          'token'=>$token
      ]);
  }

  public function login(Request $request){
      $credentials = $request->only('email', 'password');
      $token = null;
      try {
         if (!$token = JWTAuth::attempt($credentials)) {
          return response()->json('invalid email or password', 422);
         }
      } catch (JWTAuthException $e) {
          return response()->json('failed to create token', 500);
      }
      $user = JWTAuth::toUser($token);
      return response()->json([
          'status'=> 200,
          'message'=> 'Login successfully',
          'user'=>$user,
          'token' => $token,
      ]);
  }

  public function getUserInfo(Request $request){
      return $request->get('user');
  }
}
