<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\User;
use JWTAuth;
use JWTAuthException;
use Hash;
use Mail;
use App\Post;
use App\Series;
use Illuminate\Support\Facades\DB;
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
      //save user
      $user = $this->user->create([
        'name' => $request->get('name'),
        'email' => $request->get('email'),
        'password' => Hash::make($request->get('password')),
        'avatar' => 'avatar-none.png',
        'confirm' => 0,
      ]);
      $this->sendMail($request,$user->id);
      return response()->json([
          'status'=> 200,
          'message'=> 'User created successfully',
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
          'permission' => $this->getPermissionOfUser($user->id)
      ]);
  }
  public function getUserInfo(Request $request){
      return $request->get('user');
  }
  private function getPermissionOfUser($id){
    return DB::select('SELECT permission.name FROM permission WHERE permission.id IN (SELECT userpermission.permission_id FROM users INNER JOIN userpermission on users.id = userpermission.user_id WHERE users.id= :user_id1) OR permission.id IN (SELECT grouppermisstion.permission_id FROM usergroup INNER JOIN grouppermisstion ON grouppermisstion.group_id = usergroup.group_id WHERE usergroup.user_id=:user_id2)', ["user_id1"=>$id,"user_id2"=>$id]);
  }
  public function getUserHot(){
    $data = DB::select('SELECT users.id,users.name,users.email,users.avatar,temp.postnumber FROM users INNER JOIN (SELECT COUNT(*) as postnumber,user_id FROM post GROUP BY user_id ORDER BY postnumber DESC LIMIT 10) AS temp ON temp.user_id = users.id');
    return response()->json([
        'status'=> 200,
        'message'=> 'successfully',
        'data'=> $data
    ]);
  }

  public function reSendMail(Request $request){
    $this->sendMail($request,$request->get('user')->id);
    return response()->json([
        'message'=> 'successfully'
    ]);
  }
  private function sendMail(Request $req,$id){
    $user = User::find($id);
    $token = JWTAuth::fromUser($user);
    Mail::send('verify-email', ['code' => $token,'name'=> $user->name,'user' => $user], function($message) use ($user) {
      $message->from('kunkaamd.rambo@gmail.com','Application');
      $message->to($user->email, $user->name)->subject('Xác thực email');
    });
    return response()->json([
        'message'=> 'successfully'
    ]);
  }
  public function confirmUser(Request $req){
      $token = $req->code;
      try {
          $user = JWTAuth::toUser($token);
      }catch (JWTException $e) {
          if($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
              return view('verifynotication', ['message' => 'Mã xác thực đã hết hạn']);
          }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
              return view('verifynotication', ['message' => 'Mã xác không đúng']);
          }else{
              return view('verifynotication', ['message' => 'Mã xác không tồn tại']);
          }
      }
      $user->confirm = 1;
      $user->save();
      return view('verifynotication', ['message' => 'Đăng ký thành công, Thanks']);
  }
  public function informationOfUser(Request $request,$id){
    $user = User::find($id);
    $post = Post::select('id','title','image','view_count','created_at','user_id')->where('published','=','yes')->where('user_id','=',$id)->with(['user','tag'])->get();
    $series = Series::where('user_id','=',$id)->get();
    return response()->json([
        'status'=> 200,
        'message'=> 'successfully',
        'data'=>['post' => $post,'user' => $user,'series' => $series]
    ]);
  }

}
