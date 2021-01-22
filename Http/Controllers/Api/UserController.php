<?php

    namespace App\Http\Controllers\Api;

    use App\User;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Collection;
    use JWTAuth;
    use Tymon\JWTAuth\Exceptions\JWTException;
    use Tymon\JWTAuth\Contracts\JWTSubject;
    use DB;
    use JWTFactory;
    use Response;

    class UserController extends Controller
    {
        public function authenticate(Request $request)
        {
            $username = $request->input('username');
            $password = $request->input('password');
            $psw = md5($password);

            $validator = Validator::make($request->all(), [
               
                'username' => 'required|string|email|max:255',
                'password' => 'required|string',
                
            ]);

            if($validator->fails()){
                    return response()->json($validator->errors()->toJson(), 400);
            }

            $user = User::where(['email' => $username,'password' => $psw])->whereNotNull('org_id')->first();

           
            if(isset($user)){


             $check_org = DB::table('grc_organization')->where('id',$user->org_id??0)->count();
             if($check_org == 0 && $user->id != 1){
                  return response()->json(['status' => 400,'msg' => 'Organization is not assign'], 400); 
             }

            if(($user->status != 1)){

            return response()->json(['status' => 400,'msg' => 'Your Account is Dectivated'], 400);

            }elseif (empty($user->org_id)) {

            return response()->json(['status' => 400,'msg' => 'Organization Not Assign so contact System Admin'], 400);

             }elseif (!isset($user)) {

                 return response()->json(['status' => 400,'error' => 'Invaild credentials'], 400);

            }
            }else{
                
                 return response()->json(['status' => 400,'error' => 'Invaild credentials'], 400);
                
            }

    $customClaims = ['user_id' => $user->id ,'name' => $user->user_name, 'email' => $user->email,'role' =>$user->role,'type' =>$request->type,'token' => $request->token ];

            try {
              //  if (! $token = JWTAuth::attempt($credentials)) {

              	if (!$token = JWTAuth::fromUser($user, $customClaims)) {
                    
                     return response()->json(['status' => 400,'error' => 'invalid_credentials'], 400);
                }
            } catch (JWTException $e) {
                return response()->json(['status' => 400,'error' => 'could_not_create_token'], 500);
            }

            return response()->json(compact('token','customClaims'));
        }

        public function register(Request $request)
        {
                $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);

            if($validator->fails()){
                    return response()->json($validator->errors()->toJson(), 400);
            }

            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
            ]);

            $token = JWTAuth::fromUser($user);

            return response()->json(compact('user','token'),201);
        }

        public function getAuthenticatedUser()
            {
                    try {

                            // if (! $user = JWTAuth::parseToken()->authenticate()) {
                            //         return response()->json(['user_not_found'], 404);
                            // }

                          if (! $user = JWTAuth::parseToken()->authenticate()) {
                            throw new Exception('user_not_found',404);
                            }else{
                               $user = $user;
                            }

                    } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

                            return response()->json(['token_expired'], $e->getStatusCode());

                    } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

                            return response()->json(['token_invalid'], $e->getStatusCode());

                    } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

                            return response()->json(['token_absent'], $e->getStatusCode());

                    }

                    return response()->json(compact('user'));
            }



           
    }
