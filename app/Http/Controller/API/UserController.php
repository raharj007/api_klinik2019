<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
class UserController extends Controller
{
    public $successStatus = 200;

    public function login(){
        if(Auth::attempt(['name' => request('name'), 'password' => request('password')])){
            $auth = Auth::user();
            $user["id"] = $auth->id;
            $user["role"] = $auth->roles;
            $user["token"] = $auth->createToken('MyApp')->accessToken;
            return response()->json($user, $this->successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
        
        return response()->json(['success'=>$success], $this->successStatus);
    }

    public function details()
    {
        // $user = Auth::user();
        $user = user::all();
        return response()->json(['success' => $user], $this->successStatus);
    }
}
