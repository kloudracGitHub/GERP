<?php



namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;

use App\Mail\SendMailable;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Validator;

use DB;

use Session;

use Redirect;

use Response;

use PDF;

use URL;

use DateTime;





//use Input;



class SuperAdminController extends Controller

{



 public function __construct()

    {

        date_default_timezone_set('Asia/Kolkata');

    }



   public function superadmin_dashboard(){

       

      $usercount = $usercount = DB::table('grc_user')->where('id','!=',session('userId'));

      

     



       if(session('role') == 'project_Manager'){



             $usercount->where('created_by',session('userId')); 



           }else{

         if(session('role') != 'superadmin'){

           $usercount->where('created_by',session('userId'));    

          }

        }

      $usercount = $usercount->whereIN('role',['Employee','project_Manager','admin'])->count();

      //dd($usercount);

      $orgnagationcount = DB::table('grc_organization');

      

        if(session('role') != 'superadmin'){

           $orgnagationcount->where('id',session('org_id'));    

      }

      

      $orgnagationcount = $orgnagationcount->count();

      

      

      $projectcount = DB::table('grc_project')->join('alm_states','grc_project.state','=','alm_states.id')

         ->join('alm_cities','grc_project.city','=','alm_cities.id')

         ->join('main_currency','grc_project.currency_id','=','main_currency.id')

         ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')

         ->join('grc_sector','grc_project.sector','=','grc_sector.id')

         ->join('grc_user','grc_project.project_manager','=','grc_user.id');



           if(session('role') == 'project_Manager'){



             $projectcount->where('grc_project.project_manager',session('userId')); 



           }else{

         if(session('role') != 'superadmin'){

           $projectcount->where('grc_project.organization_id',session('org_id'));    

          }

        }

      

      

      $projectcount = $projectcount->count();

      

      

      

      $usertask = DB::table('grc_task');

      

         if(session('role') != 'superadmin'){

           $usertask->where('org_id',session('org_id'));    

      }

      

      $usertask = $usertask->get();

       $grc_circular = DB::table('grc_circular')->where('status',1);

       

         if(session('role') != 'superadmin'){

           $grc_circular->whereIn('org_id',[session('org_id'),1]);    

      }

       

      $grc_circular= $grc_circular->orderBy('id','DESC');



       if(session('role') != 'superadmin'){

              $grc_circular->where('org_id',session('org_id')); 

          }







    $grc_circular = $grc_circular->get();





      return view('superadmin.superadmin_dashboard',['usercount' => $usercount,'orgnagationcount' =>  $orgnagationcount,'projectcount' => $projectcount,'usertask' =>$usertask,'circular' =>  $grc_circular]);

    }

    

    private function customMsg(){

        

        return $customMessages = [

        

        'required' => 'This  field is required.',

        'emailaddress.required' => 'this is Email for required',

        

    ];

    }



     public function superadmin_login(Request $request){

















         if($request->isMethod('post')) 

       { 

           

          

           

           $customMessages = [

        'required' => 'This field is required.'

    ];

           

           $validator = Validator::make($request->all(), [

            'username' => 'required|email',

            'password' => 'required',

            

        ],$this->customMsg());



         if ($validator->fails()) {

            return redirect()->back()

                        ->withErrors($validator)

                        ->withInput();

        }

           

       $username = $request->input('username');

       $password = $request-> input ('password');

       $psw = md5($password);

       /*$remember_me = $request-> input ('remember');*/

       // echo $remember_me; die('dfsd');

       if(!empty($username) && !empty($password))

        {

          $count = DB::table('grc_user')->where('email',$username)->where('password','=',$psw)->count();

          

            if ($count == 1)

            {   

                 $user = DB::table('grc_user')->where('email',$username)->

                where('status', 1)->whereNotNull('org_id')->first();

                

                $check_org = DB::table('grc_organization')->where('id',$user->org_id)->count();



                $checkuser = DB::table('grc_user')->where('email',$username)->first();

                

                 if($check_org == 0 && $checkuser->id != 1){

                   $request->session()->flash('warning', 'Organization is not assign');

                  return redirect('/login');

                 }

                

                if(isset($user)){

                    

                  



                  Session::put('userId', $user->id);

                  Session::put('email', $user->email);

                  Session::put('username',$user->user_name);

                  Session::put('password',$user->password);

                  Session::put('role',$user->role);

                  Session::put('org_id',$user->org_id);

                  Session::put('created_by',$user->created_by);

                  Session::put('type',$request->input('type')??'');

                    // if($remember_me=='1' || $remember_me=='on')

                    //   {

                    //   $hour = time() + 3600 * 24 * 30;

                    //   setcookie('username', $username, $hour);

                    //   setcookie('password', $psw, $hour);

                    //   }

                   

                   

  

                  $request->session()->flash('login', 'Login Successfully.');

                  return redirect('/dashboard');



                   }elseif($checkuser->status != 1){



                   	$request->session()->flash('warning', 'User is Deactived. Please contact the System Admin');

                     return redirect('/login');



                }elseif(empty($checkuser->org_id)){



                  $request->session()->flash('warning', 'ORG Not Allotted Please Contact your System Admin');

                  return redirect('/login');





                }else{



                  $request->session()->flash('warning', 'Email or Password is Invalid!');

                  return redirect('/login');



                }





               

            } else{

                $request->session()->flash('warning', 'Email or Password is Invalid!');

               return redirect('/login');

                 }  

         }else{

                $request->session()->flash('warning', 'Email or Password is Invalid');

                return redirect('/login');

               } 



        }





           if($request->isMethod('GET')) 

       { 

           

       $username = $request->input('username');

       $password = $request-> input ('password');

       $psw = md5($password);

       /*$remember_me = $request-> input ('remember');*/

       // echo $remember_me; die('dfsd');

       if(!empty($username) && !empty($password))

        {

          $count = DB::table('grc_user')->where('email',$username)->where('password','=',$psw)->count();

          

            if ($count == 1)

            {   

                 $user = DB::table('grc_user')->where('email',$username)->

                where('status', 1)->whereNotNull('org_id')->first();

               



                $checkuser = DB::table('grc_user')->where('email',$username)->first();

                

                if(isset($user)){



                  Session::put('userId', $user->id);

                  Session::put('email', $user->email);

                  Session::put('username',$user->user_name);

                  Session::put('password',$user->password);

                  Session::put('role',$user->role);

                  Session::put('org_id',$user->org_id);

                  Session::put('created_by',$user->created_by);

                  Session::put('type',$request->input('type')??'');

                  /*  if($remember_me=='1' || $remember_me=='on')

                      {

                      $hour = time() + 3600 * 24 * 30;

                      setcookie('username', $username, $hour);

                      setcookie('password', $psw, $hour);

                      }*/

  

                  $request->session()->flash('login', 'Login Successfully.');

                  return redirect('/dashboard');



                   }elseif($checkuser->status != 1){



                    $request->session()->flash('warning', 'Your Account is Deactived');

                  return redirect('/login');



                }elseif(empty($checkuser->org_id)){



                  $request->session()->flash('warning', 'ORG Not Allotted Please Contact your System Admin');

                  return redirect('/login');





                }else{



                  $request->session()->flash('warning', 'Email or Password is Invalid!');

                  return redirect('/login');



                }





               

            } else{

                $request->session()->flash('warning', 'Email or Password is Invalid!');

               return redirect('/login');

                 }  

         }



      return view('superadmin.superadmin_login');



        }





        



      return view('superadmin.superadmin_login');

    }







     /*public function superadmin_forget_pass(Request $request) {

       if($request->isMethod('post')) 

       { 

          $email = $request->input('email');

          $count = DB::table('grc_user')->where('email',$email)->where('role','superadmin')->where('status', 1)->where('role','=','superadmin')->count();



          if($count == 1){

            return view('superadmin.superadmin_forget_pass');

          }



       }

     return view('superadmin.superadmin_forget_pass');

    }*/



   public function superadmin_logout(Request $request) {

      $request->session()->flush();

      return redirect('/login');

    }



    public function organizationlist(Request $request) {



     $orglist = DB::table('grc_organization')

            // ->select('*','grc_organization.id as organizationid')

            // ->leftjoin('alm_countries','grc_organization.country','=','alm_countries.id');



            ->leftjoin('alm_countries','grc_organization.country','=','alm_countries.id')

            ->leftjoin('alm_states','grc_organization.state','=','alm_states.id')

            ->leftjoin('alm_cities','grc_organization.city','=','alm_cities.id')

             ->leftjoin('grc_user','grc_organization.org_admin','=','grc_user.id')

            ->orderBy('grc_organization.id','desc')

              ->select('grc_organization.*','alm_countries.name','grc_organization.id as organizationid');



            if(isset($_GET['org_id'])){

             $orglist->where('grc_organization.org_unique_id', 'like', '%' . $_GET['org_id'] . '%'); 

            }



              if(isset($_GET['org_name'])){

             $orglist->where('grc_organization.org_name', 'like', '%' . $_GET['org_name'] . '%'); 

            }



               if(isset($_GET['org_email'])){

             $orglist->where('grc_organization.org_email', 'like', '%' . $_GET['org_email'] . '%'); 

            }





               if(isset($_GET['org_status'])){

             $orglist->where('grc_organization.org_status', 'like', '%' . $_GET['org_status'] . '%'); 

            }



              if(isset($_GET['last_date'])){

             $orglist->where('grc_organization.created_date', 'like', '%' . $_GET['last_date'] . '%'); 

            }





              if(isset($_GET['org_country'])){

             $orglist->where('alm_countries.name', 'like', '%' . $_GET['org_country'] . '%'); 

            }

            

             if(isset($request->dateStart) && isset($request->dateEnd)){

             $orglist->whereBetween(DB::raw("(DATE_FORMAT(grc_organization.created_date,'%Y-%m-%d'))"), [$request->dateStart, $request->dateEnd]);

          }



              $orglist  = $orglist->orderBy('grc_organization.id','desc')->get();

     

          

          

          

           if(!empty($request->export)){

          

       

          

            $columns = array('S.No', 'ORG ID', 'ORG Name', 'ORG Email', 'Country','Date');



    

    $filename = public_path("uploads/csv/ORG_'".time()."'_report.csv");

    $handle = fopen($filename, 'w+');

    fputcsv($handle, $columns);



         $i = 1;

        foreach($orglist as $user_datas) {



           fputcsv($handle, array($i++, 'ORG-'.$user_datas->org_unique_id,ucwords($user_datas->org_name),$user_datas->org_email,$user_datas->name,$user_datas->created_date));

        }

        

       fclose($handle);



       $headers = array(

        'Content-Type' => 'text/csv'

       

        );





    return Response()->download($filename);



      }

    



         

     return view('superadmin.organization_list',['Data' =>  $orglist]);

    }

    

    

    

     public function organizationadd(Request $request) {

    if($request->isMethod('post')) 

       { 





         if(isset($request->org_id) && !empty($request->org_id)){



          $validator = Validator::make($request->all(), [

            'orgname' => 'required|max:255',

           // 'orgemail' => 'required',

         

            // 'orgemail' => 'required|email',

            // 'adminname' =>'required',

           

           // 'orgalterno' => 'required|max:10',

           // 'orglogo' => 'mimes:jpeg,jpg,png,gif,PNG,GIF,JPG,JPEG|required|max:10000',

            'orgcountry' => 'required',

            'orgstate' => 'required',

            

            'orgcity' => 'required',

            'orgpincode' => 'required|max:6',

            

            'orgaddress' => 'required|max:200',

        ],$this->customMsg());

        



         }else{

   $validator = Validator::make($request->all(), [

            'orgname' => 'unique:grc_organization,org_name|required|max:255',

           // 'orgemail' => 'required',

             'org_email' => 'unique:grc_organization,org_email|required',

            // 'orgemail' => 'required|email',

             'adminname' =>'required',

            'org_mobile' => 'unique:grc_organization,mobile_no|max:10|required',

           // 'orgalterno' => 'required|max:10',

           // 'orglogo' => 'mimes:jpeg,jpg,png,gif,PNG,GIF,JPG,JPEG|required|max:10000',

            'orgcountry' => 'required',

            'orgstate' => 'required',

           

            'orgcity' => 'required',

            'orgpincode' => 'required|max:6',

            

            'orgaddress' => 'required|max:200',

        ],$this->customMsg());

        

       }



        if ($validator->fails()) {

            return redirect()->back()

                        ->withErrors($validator)

                        ->withInput();

        }

        if(filter_var($request->org_email, FILTER_VALIDATE_EMAIL)=== false){

            $request->session()->flash('required-org', 'Enter Email in correct format.');

                return redirect()->back();

              }else{

      $count = DB::table('grc_organization')->select('*')->where('org_unique_id',$request->orgname)->count();

            if($count == 0){

              $uniqueID = mt_rand(1000, 9999);

              $autogenerateId = 'GRC-'.$uniqueID;



                $orgArr = array();

               if ($request->file('orglogo')) {

                    $destinationPath = public_path('org_uploads');

                    $extension = $request->file('orglogo')->getClientOriginalExtension();

                    $fileName = uniqid().'.'.$extension;

                    $request->file('orglogo')->move($destinationPath, $fileName);

                     $orgArr['logo'] = $fileName;

                }

               

             if(isset($request->org_id) && !empty($request->org_id)){



                    

                            

                              $orgArr['org_name'] = $request->orgname;

                              $orgArr['org_email'] = $request->org_email;

                              $orgArr['pre_mob'] = $request->pre_mob;

                              

                              $orgArr['mobile_no'] = $request->org_mobile;

                              $orgArr['alternate_no'] = $request->orgalterno;

                              

                              //$orgArr['org_admin'] = $request->adminname;

                              $orgArr['country'] = $request->orgcountry;

                              $orgArr['state'] = $request->orgstate;

                              $orgArr['city'] = $request->orgcity;

                              $orgArr['pincode'] = $request->orgpincode;

                             

                              $orgArr['address'] = $request->orgaddress;

                              $orgArr['created_date'] = date('Y-m-d H:i:s');

                              $orgArr['modified_date'] = date('Y-m-d H:i:s');

                              $orgArr['status'] = 1;

                             



                 $update = DB::table('grc_organization')->where('id',$request->org_id)

                    ->update($orgArr); 



                     DB::table('notification')

                    ->insert([

                              'user_id' => session('userId'),

                              'org_id' => $request->org_id,

                              'msg' => 'Updated ORG '.$request->orgname,

                              'created_by' => session('userId'),

                             

                             ]); 

                     

                    return redirect('/Organization-list')->with('msg','Successfully Update');





             }else{

                 

                          $orgArr['org_unique_id'] = org_increment();

                              $orgArr['org_name'] =  $request->orgname;

                              $orgArr['org_email'] =  $request->org_email;

                              //'user_name' => $request->uname,

                              $orgArr['pre_mob'] =  $request->pre_mob;

                              $orgArr['mobile_no'] =  $request->org_mobile;

                              $orgArr['alternate_no'] =  $request->orgalterno;

                             

                              $orgArr['org_admin'] =  $request->adminname;

                              $orgArr['country'] =  $request->orgcountry;

                              $orgArr['state'] =  $request->orgstate;

                             $orgArr[ 'city'] =  $request->orgcity;

                              $orgArr['pincode'] =  $request->orgpincode;

                         

                              $orgArr['address'] =  $request->orgaddress;

                              $orgArr['created_date'] =  date('Y-m-d H:i:s');

                              $orgArr['modified_date'] =  date('Y-m-d H:i:s');

                             $orgArr[ 'status'] =  1;

                             



            $update = DB::table('grc_organization')

                    ->insert($orgArr); 



              $ogid = DB::getPdo()->lastInsertId();



               DB::table('notification')

                    ->insert([

                              'user_id' => session('userId'),

                              'org_id' => $ogid,

                              'msg' => 'Created ORG '.$request->orgname,

                              'created_by' => session('userId'),

                             

                             ]); 



               $update = DB::table('grc_user')->where('id',$request->adminname)

                    ->update([

                              'org_id' => $ogid,

                              'updated_at' => date('Y-m-d H:i:s'),

                              'status' => 1

                             ]);

              $update = DB::table('grc_relation')

                    ->insert(['org_id' => $ogid,

                              'user_id' => $request->adminname,

                              'created_date' => date('Y-m-d H:i:s'),

                              'modified_date' => date('Y-m-d H:i:s'),

                              'status' => 1

                             ]); 



              $user = DB::table('grc_user')->where('id',$request->adminname)->

                where('status', 1)->first();



                $useremail =  $user->email;       

                   //echo $useremail; die('hdgghs');

            $msg = '<!DOCTYPE html>

<html>

<body style="background-color: #f6f6f6;">

<table

  style="padding-bottom:40px;margin-top:10px;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;"

  cellspacing="0" cellpadding="0" border="0" align="center">

  <tbody>

    <tr

      style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">

      <td class="container" width="600"

        style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"

        valign="top">

        <table style=" margin-top:30px;" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">

          <tbody>

            <tr>

              <table width="100%" border="0" cellpadding="0" style="border-collapse: collapse;border:1px solid #e9e9e9">

                <td style="

                        background: #fff;

                        padding: 5px;"><img

                    src="https://projectdemoonline.com/grcgreentest/public/assets/images/grc.png" width="60"></td>

                <td style="text-align: right;

                        background: #fff;

                        padding: 5px;"><img

                    src="https://projectdemoonline.com/grcgreentest/public/assets/images/green_erp_logo.png"

                    width="100"></td>

              </table>

      </td>

    </tr>

    <tr>

      <td width="600" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;">

        <table style=" margin-top:5px;" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">

          <tr>

            <td colspan="2" style=" background:#fff; vertical-align: bottom; margin:0; padding:0;">

              <div style="padding: 22px;  position:relative; float: left; width: 100%; box-sizing: border-box;">



                <div style="float:left; width:100%;margin-bottom: 20px;">

                  <div style=" margin:0px auto;   ">

                   <div

                      style="float: left; background: #3CC6ED none repeat scroll 0% 0%; padding: 55px 45px 35px; margin-bottom: 0px;">

                  <h3 style="color: rgb(0, 0, 0); font-family: Tahoma,sans-serif; font-size: 20px; line-height: 25px; margin-top: 0;">Welcome to GRC,</h3>

                 

                  

                   <p style="color: #fff; font-family: helvetica,sans-serif; font-size: 17px; line-height: 22px; margin: 0  0 25px; text-align: left;">We gives you access to all our features and tools available in our plan. So get started today ! .</p>

                 

                   <h3 style="color: #fff;  font-size: 18px; text-align: left; margin: 0 0 40px;">Assign organization is: '.$request->orgname.'By' .session('username').'</h3>

                 

                    

                   <a style="background: #fff ; color: #3CC6ED; display: block;  font-weight: bold; font-size: 15px; margin: 0 auto; padding: 20px; text-align: center; text-decoration: none; width: 248px; text-transform: uppercase; " href='.URL::to('/login/').'>Login For GRC</a>

                  </div>

                 </div>

                 </div>

               </div>

              </td>

             </tr>

            </tbody></table>

           </td>

          </tr>

           </tbody></table>';

            $to = $useremail;

            $sub = "Assign organization";

            $from = "dsaini@kloudrac.com";

            $fromname = "Not_To_Reply";

            // $response = $this->sendMail($sub,$msg,$to,$from,$fromname);

            // $response = $this->sendMail($sub,$msg,$request->org_email,$from,$fromname);

            // $response = $this->sendMail($sub,$msg,session('email'),$from,$fromname);



              $sendEmailId = array(session('email'),$to,$request->org_email);

            

        MultiSendEmail(array_unique($sendEmailId),$sub,$from,$fromname,$msg);

           /* if($response){

              echo "Mail Send";

            }else{

              echo "Mail not send";

            }*/

          //  $request->session()->flash('update', 'Organization add Successfully And Check Your Mail'); 

             









                 $lastid = DB::getPdo()->lastInsertId();

              $request->session()->flash('msg', 'Organization add Successfully.');

                //$this->sendMail($sub,$msg,$to,$from,$fromname);

                $orglist = DB::table('grc_organization')->where('status',1)

            ->select('*','grc_organization.id as organizationid')

            ->join('alm_countries','grc_organization.country','=','alm_countries.id')

            ->get();

      $Data = array();

      foreach ($orglist as $value) {

        $val['org_unique_id'] = isset($value->org_unique_id)?$value->org_unique_id:'';

        $val['org_name'] = isset($value->org_name)?$value->org_name:'';

        $val['org_email'] = isset($value->org_email)?$value->org_email:'';

        $val['countryname'] = isset($value->name)?$value->name:'';

        $val['org_status'] = isset($value->org_status)?$value->org_status:'';

        $val['created_date'] = isset($value->created_date)?$value->created_date:'';

        $val['status'] = isset($value->status)?$value->status:'';

        $val['organizationid'] = isset($value->organizationid)?$value->organizationid:'';



        $Data[] = $val;

      }

     $key = 1;  

     }               

                    

             return redirect('/Organization-list')->with('Data','key')->with('msg', 'Organization add Successfully.');

            }else{

              return back()->with('warning-org','Organization already exist!');

            }

          }

          }

          $superCountry = DB::table('grc_superadmin_country_list')->select('alm_countries.name as countryname','grc_superadmin_country_list.created_date as createdate','grc_superadmin_country_list.country_id as countryid')

                        ->join('alm_countries','alm_countries.id','=','grc_superadmin_country_list.country_id')->get();

           $CData = array();

            foreach ($superCountry as $value) {

                $res['countryname'] = isset($value->countryname)?$value->countryname:'';

                $res['createdate'] = isset($value->createdate)?$value->createdate:'';

                $res['countryid'] = isset($value->countryid)?$value->countryid:'';

                $CData[] = $res;                         

         }

      

         if(!empty($_GET['org'])){



          $edit_org = DB::table('grc_organization')->where('id',$_GET['org'])->first();



         



          return view('superadmin.organization_add',compact('CData','edit_org'));



         }else{



          return view('superadmin.organization_add',compact('CData'));



         }



     

    }



    function org_delele($id){

     



     $get_org =  DB::table('grc_organization')->where('id',$id)->first();

        DB::table('notification')

                    ->insert([

                              'user_id' => session('userId'),

                              'org_id' => $get_org->id,

                              'msg' => 'Delete ORG '.$get_org->org_name,

                              'created_by' => session('userId'),

                             

                             ]); 



      DB::table('grc_organization')->where('id',$id)->delete();

      DB::table('grc_project')->where('organization_id',$id)->delete();

      DB::table('grc_task')->where('org_id',$id)->delete();



      return redirect('/Organization-list')->with('msg','Successfully Delete ORG');

    }



        function pro_delele($id){





     $get_project =  DB::table('grc_project')->where('id',$id)->first();

        DB::table('notification')

                    ->insert([

                              'user_id' => session('userId'),

                              'org_id' => $get_project->organization_id,

                              'msg' => 'Delete Project '.$get_project->project_name,

                              'created_by' => session('userId'),

                             

                             ]); 



        

      

      DB::table('grc_project')->where('id',$id)->delete();

      DB::table('grc_task')->where('project_id',$id)->delete();



      return redirect('/Project-list')->with('msg','Successfully Delete Project');

    }



    function task_delele($id){





     $grc_task =  DB::table('grc_task')->where('id',$id)->first();

        DB::table('notification')

                    ->insert([

                              'user_id' => session('userId'),

                              'org_id' => $grc_task->org_id,

                              'msg' => 'Delete Task '.$grc_task->task_name,

                              'created_by' => session('userId'),

                             

                             ]); 



       DB::table('grc_task')->where('id',$id)->delete();

       return redirect('/Task-list')->with('msg','Successfully Delete Task');



    }

    function user_delele($id){



         $org = DB::table('grc_organization')->where('org_admin',$id)->count();

       $project = DB::table('grc_project')->where('project_manager',$id)->count();

        $task = DB::table('grc_task')->where('user_id',$id)->count();



        if($org > 0){

        //  return response()->json(['status' => 400 ,'msg' => 'organization Assgin This User So can not be delete'], 400);

           return redirect('/Users-list')->with('msg','organization Assgin This User can not be delete');

        }

         if($project > 0){

          return redirect('/Users-list')->with('msg','Project Assgin This User  can not be delete');

        }

         if($task > 0){

           return redirect('/Users-list')->with('msg','Task Assgin This User  can not be delete');

        }

 

     $grc_user =  DB::table('grc_user')->where('id',$id)->first();

        DB::table('notification')

                    ->insert([

                              'user_id' => session('userId'),

                              'org_id' => $grc_user->org_id,

                              'msg' => 'Delete User '.$grc_user->user_name,

                              'created_by' => session('userId'),

                             

                             ]); 



       DB::table('grc_user')->where('id',$id)->delete();

       return redirect('/Users-list')->with('msg','Successfully Delete User');

    }

    



//     public function organizationadd(Request $request) {

//     if($request->isMethod('post')) 

//       { 

//   $validator = Validator::make($request->all(), [

//             'orgname' => 'required|max:255',

//           // 'orgemail' => 'required',

//              'orgemail' => 'required|email',

            

//             'orgmobile' => 'required|max:10',

           

//             'orglogo' => 'mimes:jpeg,jpg,png,gif,PNG,GIF,JPG,JPEG|required|max:10000',

//             'orgcountry' => 'required',

//             'orgstate' => 'required',

//             'orgcity' => 'required',

//             'orgpincode' => 'required|max:6',

            

//             'orgaddress' => 'required|max:200',

//         ]);

        

       



//         if ($validator->fails()) {

//             return redirect('/Organization-add')

//                         ->withErrors($validator)

//                         ->withInput();

//         }

     

                  

//                     try {

//                 if ($request->hasFile('orglogo')) {

//                     $destinationPath = public_path('uploads');

//                     //dd($destinationPath);

//                     $extension = $request->file('orglogo')->getClientOriginalExtension();

//                     $fileName = uniqid().'.'.$extension;

//                     $request->file('orglogo')->move($destinationPath, $fileName);

//                 }else{

//                   $fileName = '0'; 

//                 }



//                   } catch (\Exception $e) {

//                       dd($e);

//                       }

                      

//                       //dd($request->all());

                  

//                     $uniqueID = mt_rand(1000, 9999);

//                     $autogenerateId = 'GRC-'.$uniqueID;

                    

//                     $arr = ['org_unique_id' => $autogenerateId,

//                               'org_name' => $request->orgname,

//                               'org_email' => $request->orgemail,

                             

//                               'mobile_no' => $request->orgmobile,

//                               'alternate_no' => $request->orgalterno,

//                               'logo' => $fileName,

//                               'org_admin' => $request->adminname,

//                               'country' => $request->orgcountry,

//                               'state' => $request->orgstate,

//                               'city' => $request->orgcity,

//                               'pincode' => $request->orgpincode,

//                               'org_status' => $request->orgstatus,

//                               'address' => $request->orgaddress,

//                               'created_date' => date('Y-m-d H:i:s'),

//                               'modified_date' => date('Y-m-d H:i:s'),

//                               'status' => 1

//                              ];

                    

//                       $update = DB::table('grc_organization')

//                     ->insert($arr);  

                  

//                 //  dd($update);

                  

//                   $msg = '<table style="width:100%; background:#F1FDF6;  " cellspacing="0" cellpadding="0" border="0" align="center">

//           <tbody><tr>

//           <td>

//             <table style=" margin-top:30px;" width="845" cellspacing="0" cellpadding="0" border="0" align="center">

//              <tbody>

//               <tr>

//               <td>

              

//               </td>

//              </tr>

//              <tr>

//               <td style=" background:#fff; vertical-align: bottom; margin0; padding:0;">

//               <div style="padding: 22px;  position:relative; float: left; width: 100%; box-sizing: border-box;">



//                 <div style="float:left; width:100%;">

//                  <div style="width:688px; margin:52px auto;   ">

//                  <div style="float: left; background: #3CC6ED none repeat scroll 0% 0%; padding: 55px 45px 35px; margin-bottom: 50px;">

//                   <h3 style="color: rgb(0, 0, 0); font-family: Tahoma,sans-serif; font-size: 20px; line-height: 25px; margin-top: 0;">Welcome to GRC,</h3>

                 

                  

//                   <p style="color: #fff; font-family: helvetica,sans-serif; font-size: 17px; line-height: 22px; margin: 0  0 25px; text-align: left;">We gives you access to all our features and tools available in our plan. So get started today ! .</p>

                 

//                   <h3 style="color: #fff;  font-size: 18px; text-align: left; margin: 0 0 40px;">Assign organization is: '.$request->orgname.'</h3>

                 

                    

                 

//                   </div>

//                  </div>

//                  </div>

//               </div>

//               </td>

//              </tr>

//             </tbody></table>

//           </td>

//           </tr>

//           </tbody></table>';

//           //  $to = $useremail;

//             $sub = "Assign organization";

//             $from = "dsaini@kloudrac.com";

//             $fromname = "Not_To_Reply";

           

//             $response = $this->sendMail($sub,$msg,$request->orgemail,$from,$fromname);

          

                  

                  

                  

          

//              return redirect('/Organization-list')->with('msg','Successfully Created');

            

          

//           }

//           $superCountry = DB::table('grc_superadmin_country_list')->select('alm_countries.name as countryname','grc_superadmin_country_list.created_date as createdate','grc_superadmin_country_list.country_id as countryid')

//                         ->join('alm_countries','alm_countries.id','=','grc_superadmin_country_list.country_id')->get();

//           $CData = array();

//             foreach ($superCountry as $value) {

//                 $res['countryname'] = isset($value->countryname)?$value->countryname:'';

//                 $res['createdate'] = isset($value->createdate)?$value->createdate:'';

//                 $res['countryid'] = isset($value->countryid)?$value->countryid:'';

//                 $CData[] = $res;                         

//          }                           

//      return view('superadmin.organization_add',compact('CData'));

//     }



    public function orgstatus($id){



      



      $orgcount = DB::table('grc_organization')->where('id',$id)->count();

      $orgstatus = DB::table('grc_organization')->where('grc_organization.id',$id)->select('grc_organization.*')->first();

        

      if($orgcount==1){

       

        $status = $orgstatus->status;



       



        if($status == 1){



          DB::table('notification')

          ->insert([

                    'user_id' => session('userId'),

                    'org_id' => $orgstatus->id,

                    'msg' => 'Deactive ORG '.$orgstatus->org_name,

                    'created_by' => session('userId'),

                   

                   ]);  

                   

                   DB::table('grc_user')->where('org_id', $orgstatus->id)

                   ->update([

                             'status' => 0

                            ]);



                  $update = DB::table('grc_organization')->where('id',$id)

                    ->update([

                              'status' => 0

                             ]); 

          $orglist = DB::table('grc_organization')->select('*','grc_organization.status as orgstatus','grc_organization.id as orgid')

              ->join('alm_countries','grc_organization.country','=','alm_countries.id')->get();

         $key = 1;

         

         

         

       

            

            //$response = $this->sendMail($sub,$msg,$orgstatus->org_email,$from,$fromname);

            // $response = $this->sendMail($sub,$msg,session('email'),$from,$fromname);

            // if(isset($orgstatus->org_email)){

            // $response = $this->sendMail($sub,$msg,$orgstatus->org_email,$from,$fromname);

            // }

            

          

         

         

         

        return response()->json(['status' => 200, 'msg' => 'DeActive ORG successfully']);

        }else{



          DB::table('notification')

          ->insert([

                    'user_id' => session('userId'),

                    'org_id' => $orgstatus->id,

                    'msg' => 'Active ORG '.$orgstatus->org_name,

                    'created_by' => session('userId'),

                   

                   ]);  



                   DB::table('grc_user')->where('org_id', $orgstatus->id)

                   ->update([

                             'status' => 1

                            ]);

            $update = DB::table('grc_organization')->where('id',$id)

                    ->update([

                              'status' => 1

                             ]);

              $orglist = DB::table('grc_organization')->select('*','grc_organization.status as orgstatus','grc_organization.id as orgid')

              ->join('alm_countries','grc_organization.country','=','alm_countries.id')->get();

         $key = 1;

         

         

         

       

            

            

            // $response = $this->sendMail($sub,$msg,$orgstatus->org_email,$from,$fromname);

            // $response = $this->sendMail($sub,$msg,session('email'),$from,$fromname);

         

         

         

            return response()->json(['status' => 200, 'msg' => 'Active ORG successfully']);

     

        }

      }else{



          return response()->json(['status' => 200, 'msg' => "This organization doesn't exist in database"]);

     

    

      }



      

    }



    function org_status_email($org_id){



       $orgstatus = DB::table('grc_organization')->join('grc_user','grc_user.id','=','grc_organization.org_admin')->where('grc_organization.id',$org_id)->select('grc_organization.*','grc_user.email')->first();





       if($orgstatus->status == 1){



        $class = 'Actived';



       }else{



        $class = 'DeActived';



       }

      

              $msg = '<!DOCTYPE html>

<html>

<body style="background-color: #f6f6f6;">

<table

  style="padding-bottom:40px;margin-top:10px;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;"

  cellspacing="0" cellpadding="0" border="0" align="center">

  <tbody>

    <tr

      style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">

      <td class="container" width="600"

        style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"

        valign="top">

        <table style=" margin-top:30px;" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">

          <tbody>

            <tr>

              <table width="100%" border="0" cellpadding="0" style="border-collapse: collapse;border:1px solid #e9e9e9">

                <td style="

                        background: #fff;

                        padding: 5px;"><img

                    src="https://projectdemoonline.com/grcgreentest/public/assets/images/grc.png" width="60"></td>

                <td style="text-align: right;

                        background: #fff;

                        padding: 5px;"><img

                    src="https://projectdemoonline.com/grcgreentest/public/assets/images/green_erp_logo.png"

                    width="100"></td>

              </table>

      </td>

    </tr>

    <tr>

      <td width="600" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;">

        <table style=" margin-top:5px;" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">

          <tr>

            <td colspan="2" style=" background:#fff; vertical-align: bottom; margin:0; padding:0;">

              <div style="padding: 22px;  position:relative; float: left; width: 100%; box-sizing: border-box;">



                <div style="float:left; width:100%;margin-bottom: 20px;">

                  <div style=" margin:0px auto;   ">

                   <div

                      style="float: left; background: #3CC6ED none repeat scroll 0% 0%; padding: 55px 45px 35px; margin-bottom: 0px;">

                  <h3 style="color: rgb(0, 0, 0); font-family: Tahoma,sans-serif; font-size: 20px; line-height: 25px; margin-top: 0;">Welcome to GRC,</h3>

                 

                  

                   <p style="color: #fff; font-family: helvetica,sans-serif; font-size: 17px; line-height: 22px; margin: 0  0 25px; text-align: left;">We gives you access to all our features and tools available in our plan. So get started today ! .</p>

                 

                   <h3 style="color: #fff;  font-size: 18px; text-align: left; margin: 0 0 40px;"> Organization is '.$class.': '.$orgstatus->org_name.'</h3>

                 

                    

                 

                  </div>

                 </div>

                 </div>

               </div>

              </td>

             </tr>

            </tbody></table>

           </td>

          </tr>

           </tbody></table>';

           

            $sub = " organization Details";

            $from = "dsaini@kloudrac.com";

            $fromname = "Not_To_Reply";



              $sendEmailId = array(session('email'),$orgstatus->org_email,$orgstatus->email);

            

          MultiSendEmail(array_unique($sendEmailId),$sub,$from,$fromname,$msg);

        return response()->json(['status' => 200, 'msg' => $class.' ORG successfully Send email']);



    }





    public function superadmin_orgview($id =''){

        

        if(isset($id) && !empty($id)){

             $org = $id;

      

        }else{

            

             $org = session('org_id'); 

            

        }



          $organizationview = DB::table('grc_organization')->select('*','alm_countries.name as countryname','alm_states.name as statename','alm_cities.name as cityname','grc_organization.id as orgid','grc_organization.status as ogstatus','grc_user.first_name' ,'grc_user.middle_name','grc_user.last_name','grc_organization.pincode as orgpincode','grc_organization.address as org_address','grc_organization.mobile_no as org_mobile','grc_organization.alternate_no as altno')

                          ->leftjoin('alm_countries','grc_organization.country','=','alm_countries.id')

                          ->leftjoin('alm_states','grc_organization.state','=','alm_states.id')

                          ->leftjoin('alm_cities','grc_organization.city','=','alm_cities.id')

                          ->leftjoin('grc_user','grc_organization.org_admin','=','grc_user.id')

                          ->where('grc_organization.id',$org)

                          ->first();





        return view('superadmin.organization_view',compact('organizationview','id'));

    }



 public function projectlist(Request $request){



     // dd($request->all());

      if(session('role') == 'project_Manager'){

        $projectlist = DB::table('grc_project')

          ->join('alm_states','grc_project.state','=','alm_states.id')

         ->join('alm_cities','grc_project.city','=','alm_cities.id')

         ->join('main_currency','grc_project.currency_id','=','main_currency.id')

         ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')

         ->join('grc_sector','grc_project.sector','=','grc_sector.id')

         ->join('grc_user','grc_project.project_manager','=','grc_user.id')

          ->where('grc_project.project_manager',session('userId'));



   



          if(isset($request->project_id)  && !empty($request->project_id)){



        //  $projectlist->where('project_id',$request->projectid);

             $projectlist->where('project_id', 'like', '%' . $request->project_id . '%');



         }

          if(isset($request->project_name)  && !empty($request->project_name)){



             $projectlist->where('project_name', 'like', '%' . $request->project_name . '%');



          

         }

          if(isset($request->type)  && !empty($request->type)){



              $projectlist->where('project_type',$request->type);

          

         }

          if(isset($request->status)  && !empty($request->status)){



             $projectlist->where('project_status',$request->status);

          

         }



                

      }elseif(session('role') == 'admin'){

        $projectlist = DB::table('grc_project')



       ->join('alm_states','grc_project.state','=','alm_states.id')

         ->join('alm_cities','grc_project.city','=','alm_cities.id')

         ->join('main_currency','grc_project.currency_id','=','main_currency.id')

         ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')

         ->join('grc_sector','grc_project.sector','=','grc_sector.id')

         ->join('grc_user','grc_project.project_manager','=','grc_user.id')->where('grc_project.organization_id',session('org_id'));

        





        

          if(isset($request->project_id)  && !empty($request->project_id)){



        //  $projectlist->where('project_id',$request->projectid);

             $projectlist->where('grc_project.project_id', 'like', '%' . $request->project_id . '%');



         }

          if(isset($request->project_name)  && !empty($request->project_name)){



             $projectlist->where('grc_project.project_name', 'like', '%' . $request->project_name . '%');



          

         }

          if(isset($request->type)  && !empty($request->type)){



              $projectlist->where('grc_project.project_type',$request->type);

          

         }

          if(isset($request->status)  && !empty($request->status)){



             $projectlist->where('grc_project.project_status',$request->status);

          

         }



                 

      }elseif(session('role') == 'employee'){

 

      $project = [];

       $task_list = DB::table('grc_task')->where('user_id',session('userId'))->get();

       foreach ($task_list as $key => $task_lists) {

          $project[] = $task_lists->project_id;

       }

        

        



          $projectlist = DB::table('grc_project')

        ->join('alm_states','grc_project.state','=','alm_states.id')

        ->join('alm_cities','grc_project.city','=','alm_cities.id')

        ->join('main_currency','grc_project.currency_id','=','main_currency.id')

        ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')

        ->join('grc_sector','grc_project.sector','=','grc_sector.id')

        ->join('grc_user','grc_project.project_manager','=','grc_user.id')

      

        ->whereIn('grc_project.id',$project);

       

       

      

          if(isset($request->project_id)  && !empty($request->project_id)){



        //  $projectlist->where('project_id',$request->projectid);

             $projectlist->where('grc_project.project_id', 'like', '%' . $request->project_id . '%');



         }

          if(isset($request->project_name)  && !empty($request->project_name)){



             $projectlist->where('grc_projectproject_name', 'like', '%' . $request->project_name . '%');



          

         }

          if(isset($request->type)  && !empty($request->type)){



              $projectlist->where('grc_project.project_type',$request->type);

          

         }

          if(isset($request->status)  && !empty($request->status)){



             $projectlist->where('grc_project.project_status',$request->status);

          

         }

                 

      }else{

         $projectlist = DB::table('grc_project')



         ->join('alm_states','grc_project.state','=','alm_states.id')

         ->join('alm_cities','grc_project.city','=','alm_cities.id')

         ->join('main_currency','grc_project.currency_id','=','main_currency.id')

         ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')

         ->join('grc_sector','grc_project.sector','=','grc_sector.id')

         ->join('grc_user','grc_project.project_manager','=','grc_user.id');

                                



          if(isset($request->project_id)  && !empty($request->project_id)){



        //  $projectlist->where('project_id',$request->projectid);

             $projectlist->where('grc_project.project_id', 'like', '%' . $request->project_id . '%');



         }

          if(isset($request->project_name)  && !empty($request->project_name)){



             $projectlist->where('grc_project.project_name', 'like', '%' . $request->project_name . '%');



          

         }

          if(isset($request->type)  && !empty($request->type)){



              $projectlist->where('grc_project.project_type',$request->type);

          

         }

          if(isset($request->status)  && !empty($request->status)){



             $projectlist->where('grc_project.project_status',$request->status);

          

         }

                 

      }

      



       if(isset($request->dateStart) && isset($request->dateEnd)){

             $projectlist->whereBetween(DB::raw("(DATE_FORMAT(grc_project.created_date,'%Y-%m-%d'))"), [$request->dateStart, $request->dateEnd]);; 

          }

   

        

          $project =  $projectlist->orderBy('grc_project.id','desc')->select('grc_project.*')->get();



        

        

        

        if(!empty($request->export)){

          



          

          

          // $user_data  =  $user_list->get();

           

        

          

            $columns = array('S.No', 'Project Code', 'Project Name', 'Project Type', 'Stage','Status','Date');



    

    $filename = public_path("uploads/csv/project_'".time()."'_report.csv");

    $handle = fopen($filename, 'w+');

    fputcsv($handle, $columns);



         $i = 1;

        foreach($project as $user_datas) {



           fputcsv($handle, array($i++, $user_datas->project_id,ucwords($user_datas->project_name),ucwords($user_datas->project_type),$user_datas->project_stage,$user_datas->project_status,$user_datas->created_date));

        }

        

       fclose($handle);



       $headers = array(

        'Content-Type' => 'text/csv'

       

        );





    return Response()->download($filename);



      }

      

        

        return view('superadmin.project_list',['projectlist' => $project]);

    }





 function projectedit($id){



   $superstate = DB::table('alm_states')->select('*','alm_states.id as stateid')

                          ->join('grc_superadmin_country_list','grc_superadmin_country_list.country_id','=','alm_states.country_id')

                          

                          ->get();

                 //dd($superstate);         

                $CData = array();

                foreach ($superstate as $value) {

                $res['statename'] = isset($value->name)?$value->name:'';

                $res['stateid'] = isset($value->stateid)?$value->stateid:'';

                $CData[] = $res; 

              }

        

        $currency = DB::table('main_currency')->where('isactive')->get();

        

        $orgname = DB::table('grc_organization')->where('status',1)->get();

      

        $projectEdit = DB::table('grc_project')->where('id',$id)->first();







  return view('superadmin.project_edit',compact('CData','currency','orgname','projectEdit'));



}



    public function projectadd(Request $request){

     // dd($request->all());

       $year = date('m-Y');

      if($request->isMethod('post')) 

       { 

           

            



    if(!isset($request->project_id)){

    $validator = Validator::make($request->all(), [

            'projectname' => 'unique:grc_project,project_name|required|max:255',

            'letter_no' => 'required',

            'projectalias' => 'required',

            'projectmanager' => 'required',

              'organizationname'=> 'required',

            'projecttype' => 'required',

            'projectstage' => 'required',

            'pincode' => 'required',

            'sector' => 'required',

            

            'landmark' => 'required',

            'projectstate' => 'required',

            'projectcity' => 'required',

           

            'prDescription' => 'required',

            'projectcurrency' => 'required',

            'estimatedhrs' => 'required',

            'projectstart' => 'required',

            'projectend' => 'required',

            'prstatus' => 'required',

           

        ],$this->customMsg());



        if ($validator->fails()) {

            return redirect('/Project-add')

                        ->withErrors($validator)

                        ->withInput();

        }

    }

    

    

        

      $count = DB::table('grc_project')->select('*')->where('project_name',$request->projectname)->where('organization_id',$request->organizationname)->count();

           

              $count1 = DB::table('grc_project')->orderBy('id','DESC')->first();

              

              

              if(isset($request->organizationname)){

                  $id = $request->organizationname;

                  

                   $org = DB::table('grc_organization')->where('id',$id)->select('org_name')->first();

                  

              }else{

                  

                  $org = DB::table('grc_organization')->where('id',session('org_id'))->select('org_name')->first();

                  

              }

              

              

             

   

   // $ID = ;

    

    // if($count1->id == '') {

    //   $exportId = "01"; 

    // }else{

    //      $ID = $count1->id;     

    //   $results = $ID + 1;

    //   $exportId = sprintf("%'.04d", $results); 

    // }

    

    if(isset($count1)){

        

        $ID = $count1->id;     

      $results = $ID + 1;

      $exportId = sprintf("%'.04d", $results); 

        

    }else{

        

         $exportId = "01"; 

        

    }

    

              $uniqueID = mt_rand(1000, 9999);

              $autogenerateId = $org->org_name.'/'.$request->projectname.'/'.$request->projectstage.'/'.date("F").'/'.date("Y").'/'.$exportId;

                //$uniqueID = mt_rand(1000, 9999);

            //    $autogenerateId = $request->organizationname.$request->projectname.'/'.$request->projectstage.'/'.$year./.$exportId;

              if(session('role') == 'admin'){

                $org = session('org_id');

               }else{

                $org = $request->organizationname;

               }

            



              if ($request->file('task_upload')) {

                    $destinationPath = public_path('uploads');

                    $extension = $request->file('task_upload')->getClientOriginalExtension();

                    $fileName = $request->file('task_upload').'@'.$uniqueID.'.'.$extension;

                    $request->file('task_upload')->move($destinationPath, $fileName);

                }else{

                   $fileName = '0'; 

                }



                DB::table('notification')

                ->insert([

                          'user_id' => session('userId'),

                          'org_id' => $org,

                          'msg' => 'Created Project '.$request->projectname,

                          'created_by' => session('userId'),

                         

                         ]); 

                         

                         

                         

                        



                if(isset($request->project_id) && !empty(($request->project_id))){





                       

                    

                    $update = DB::table('grc_project')->where('id',$request->project_id)

                    ->update(['organization_id' => $org,

                              'project_name' => $request->projectname,

                              'letter_no' => $request->letter_no,

                              'project_alias' => $request->projectalias,

                              'project_type' => $request->projecttype,

                              'project_stage' => $request->projectstage,

                              'cat' => $request->project_category,

                              'sector' => $request->sector,

                              'project_manager' => $request->projectmanager,

                              'state' => $request->projectstate,

                              'city' => $request->projectcity,

                              'landmark' => $request->landmark,

                              'description' => $request->prDescription,

                              'currency_id' => $request->projectcurrency,

                              'estimated_hrs' => $request->estimatedhrs,

                              'start_date' => $request->projectstart,

                              'project_id' => project_increment(),

                              'end_date' => $request->projectend,

                              'created_by' => session('userId'),

                              'pincode' => $request->pincode,

                              'modified_by' =>session('userId'),

                              'created_date' => date('Y-m-d H:i:s'),

                              'last_modified_date' => date('Y-m-d H:i:s'),

                              'project_status' => $request->prstatus,

                              'status' => 1

                             ]); 



                    return redirect('/Project-list')->with('msg','Project Updated');



                }else{



            $update = DB::table('grc_project')

                    ->insert(['organization_id' => $org,

                              'project_name' => $request->projectname,

                              'letter_no' => $request->letter_no,

                              'project_alias' => $request->projectalias,

                              'project_type' => $request->projecttype,

                              'project_stage' => $request->projectstage,

                              'sector' => $request->sector,

                              'project_manager' => $request->projectmanager,

                              'state' => $request->projectstate,

                              'city' => $request->projectcity,

                              'landmark' => $request->landmark,

                              'description' => $request->prDescription,

                              'currency_id' => $request->projectcurrency,

                              'estimated_hrs' => $request->estimatedhrs,

                              'start_date' => $request->projectstart,

                              'project_id' => $autogenerateId,

                              'end_date' => $request->projectend,

                              'created_by' => session('userId'),

                              'pincode' => $request->pincode,

                              'modified_by' =>session('userId'),

                              'created_date' => date('Y-m-d H:i:s'),

                              'last_modified_date' => date('Y-m-d H:i:s'),

                              'project_status' => $request->prstatus,

                              'status' => 1

                             ]); 



                    $lastid = DB::getPdo()->lastInsertId();



       $docname = DB::table('grc_document')->where('state',$request->projectstate)->where('sector',$request->sector)->count(); 



       //echo $docname; die('df');

                    if ($docname > 0) {



                      $Data = DB::table('grc_document')->where('state',$request->projectstate)->where('sector',$request->sector)->get();

                      foreach ($Data as $value) {

                        $update = DB::table('grc_project_condition_doc')

                              ->insert(['category_section' => $value->category,

                              'project_id' => $lastid,

                              'condition_number' => $value->condition_no,

                              'doc_type' => $value->type,

                              'user_id' => $request->projectmanager,

                              'state_id' => $value->state,

                              'sector_name' => $value->sector,

                              'document_statement' => $value->document,

                              'created_by' => session('userId'),

                              'modified_by' =>session('userId'),

                              'created_date' =>date('Y-m-d H:i:s'),

                              'modified_date' =>date('Y-m-d H:i:s'),

                              'status' => 1

                             ]);

                      }

                      

                    }



                // $updatetask = DB::table('grc_project_condition_doc')->where('project_id',$lastid)->count();

                // if($updatetask>0){



                   



                //    $Datatask = DB::table('grc_project_condition_doc')->where('project_id',$lastid)->get();

                //       foreach ($Datatask as $value) {

                //         $uniqueID = mt_rand(1000, 9999);

                //         $autogenerateId = 'TSK-'.$uniqueID;

                //         $update = DB::table('grc_task')

                //               ->insert(['org_id' => $org,

                //               'add_condition_id' => $value->id,

                //               'task_id' => $autogenerateId,

                //               'project_id' => $lastid,

                //               'task_name' => $value->document_statement,

                //               'category' => $value->category_section,

                //               'user_id' => $request->user_id,

                //               'state_id' => $value->state_id,

                //               'sector' => $value->sector_name,

                //               'condition_no' => $value->condition_number,

                //               'type' => $value->doc_type,

                //               'estimated_hrs' => $value->time_limit,

                //               //'start_date' => $value->time_limit,

                //               //'end_date' => $value->time_limit,

                //               'created_by' => session('userId'),

                //               'modified_by' =>session('userId'),

                //               'created_date' =>date('Y-m-d H:i:s'),

                //               'modified_date' =>date('Y-m-d H:i:s'),

                //               'task_status' => 'New',

                //               'status' => 1

                //              ]);

                //       }

                      

                //     }





              $updates = DB::table('grc_user')->where('id',$request->projectmanager)

                    ->update(['org_id' => $org,

                              'updated_at' => date('Y-m-d H:i:s'),

                              'status' => 1

                             ]);



              $update = DB::table('grc_relation')

                    ->insert(['project_id' => $lastid,

                              'org_id' => $org,

                              'user_id' => $request->projectmanager,

                              'created_date' => date('Y-m-d H:i:s'),

                              'modified_date' => date('Y-m-d H:i:s'),

                              'status' => 1

                             ]); 

              if(isset($request->projectmanager) && !empty($request->projectmanager)){

              $user = DB::table('grc_user')->where('id',$request->projectmanager)->

                where('status', 1)->first();

                 $superadmin = DB::table('grc_user')->where('id',1)->

                where('status', 1)->first();

                

                $useremail =  $user->email;  

               // print_r($useremail); die('sddddddddd');

                 $msg = '<!DOCTYPE html>

<html>

<body style="background-color: #f6f6f6;">

<table

  style="padding-bottom:40px;margin-top:10px;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;"

  cellspacing="0" cellpadding="0" border="0" align="center">

  <tbody>

    <tr

      style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">

      <td class="container" width="600"

        style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"

        valign="top">

        <table style=" margin-top:30px;" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">

          <tbody>

            <tr>

              <table width="100%" border="0" cellpadding="0" style="border-collapse: collapse;border:1px solid #e9e9e9">

                <td style="

                        background: #fff;

                        padding: 5px;"><img

                    src="https://projectdemoonline.com/grcgreentest/public/assets/images/grc.png" width="60"></td>

                <td style="text-align: right;

                        background: #fff;

                        padding: 5px;"><img

                    src="https://projectdemoonline.com/grcgreentest/public/assets/images/green_erp_logo.png"

                    width="100"></td>

              </table>

      </td>

    </tr>

    <tr>

      <td width="600" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;">

        <table style=" margin-top:5px;" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">

          <tr>

            <td colspan="2" style=" background:#fff; vertical-align: bottom; margin:0; padding:0;">

              <div style="padding: 22px;  position:relative; float: left; width: 100%; box-sizing: border-box;">



                <div style="float:left; width:100%;margin-bottom: 20px;">

                  <div style=" margin:0px auto;   ">

                   <div

                      style="float: left; background: #3CC6ED none repeat scroll 0% 0%; padding: 55px 45px 35px; margin-bottom: 0px;">

                  <h3 style="color: rgb(0, 0, 0); font-family: Tahoma,sans-serif; font-size: 20px; line-height: 25px; margin-top: 0;">Welcome to GRC,</h3>

                 

                  

                   <p style="color: #fff; font-family: helvetica,sans-serif; font-size: 17px; line-height: 22px; margin: 0  0 25px; text-align: left;">We gives you access to all our features and tools available in our plan. So get started today ! .</p>

                 

                   <h3 style="color: #fff;  font-size: 18px; text-align: left; margin: 0 0 40px;">Your Registered email is: '.$user->user_name.'</h3>

                 

                    <h3 style="color: #fff;  font-size: 18px; text-align: left; margin: 0 0 40px;">Project is: '.$request->projectname.'</h3>

                 

                  

                     </div>

                 </div>

                 </div>

               </div>

              </td>

             </tr>

            </tbody></table>

           </td>

          </tr>

           </tbody></table>';

            $to = $useremail;

            $sub = "Project Assign";

            $from = "dsaini@kloudrac.com";

            $fromname = "Not_To_Reply";

             $sendEmailId = array($to,$superadmin->email);

            

      $response =  MultiSendEmail(array_unique($sendEmailId),$sub,$from,$fromname,$msg);

       

          

      

              }

                        

              $request->session()->flash('project-success', 'Project add Successfully.');

             

              $superstate = DB::table('alm_states')->where('country_id',101)->select('*','alm_states.id as stateid')

                         

                          

                          ->get();

                 //dd($superstate);         

                $CData = array();

                foreach ($superstate as $value) {

                $res['statename'] = isset($value->name)?$value->name:'';

                $res['stateid'] = isset($value->stateid)?$value->stateid:'';

                $CData[] = $res;                         

         } 

            

            }

            //$orgname = DB::table('grc_organization')->get();



            //$currency = DB::table('main_currency')->get();

            

          return redirect('/Project-list')->with('msg','Project Created');

            

         }else{

           $orgname = DB::table('grc_organization')->where('status',1)->get();

            

            $currency = DB::table('main_currency')->where('isactive')->get();

             $superstate =DB::table('alm_states')->where('country_id',101)->select('*','alm_states.id as stateid');

                     

                        if(session('role') != 'superadmin'){

                            $orgcontry = DB::table('grc_organization')->where('id',session('org_id'))->where('status',1)->first();

                            $superstate->where('alm_states.country_id', $orgcontry->country??0);   

                        }

                        

                         $superstate = $superstate->get();

                        // dd($superstate);

           $CData = array();

            foreach ($superstate as $value) {

                $res['statename'] = isset($value->name)?$value->name:'';

                $res['stateid'] = isset($value->id)?$value->id:'';

                $CData[] = $res;                         

         } 

        return view('superadmin.project_add',compact('CData','currency','orgname'));

      }

    }



    public function project_status($id){

       $userEmail = [];

      $projectcount = DB::table('grc_project')->where('id',$id)->count();

      $projectstatus = DB::table('grc_project')->where('id',$id)->first();

      $useremail = DB::table('grc_user')->where('org_id',$projectstatus->organization_id)->where('status',1)->pluck('email');

      foreach ($useremail as $key => $value) {

      $userEmail[] = $value; 

      }

     

      $taskstatus = DB::table('grc_task')->where('project_id',$projectstatus->id)->get();



       $projecttask_user = [];

       $projecttask_user[] = $projectstatus->project_manager;



       foreach($taskstatus as $taskstatuss){

        $projecttask_user[] = $taskstatuss->user_id;

       }



       if (($key = array_search(1, $projecttask_user)) !== false) {

        unset($projecttask_user[$key]);

    }



    

      if($projectcount==1){

       

       //$project_task_status = DB::table('grc_task')->where('project_id',$id)->get();

        //print_r($projectstatus); die('sds');

        $status = $projectstatus->status;



        if($status == 1){



          DB::table('notification')

          ->insert([

                    'user_id' => session('userId'),

                    'org_id' => $projectstatus->id,

                    'msg' => 'Active ORG '.$projectstatus->project_name,

                    'created_by' => session('userId'),

                   

                   ]); 



                   $update = DB::table('grc_user')->whereIn('id',$projecttask_user)

                   ->update([

                             'status' => 0

                            ]);



                  $update = DB::table('grc_project')->where('id',$id)

                    ->update([

                              'status' => 0

                             ]);

                             

          

                

                $update = DB::table('grc_task')->where('project_id',$id)

                    ->update([

                              'status' => 0

                             ]);

                

       

  

            

                             

       return response()->json(['status' => 200, 'msg' => 'Successfully Deactive Project']);

    

      



       

        }else{



          $update = DB::table('grc_user')->whereIn('id',$projecttask_user)

          ->update([

                    'status' => 1

                   ]);

         

             $update = DB::table('grc_project')->where('id',$id)

                    ->update([

                              'status' => 1

                             ]);

                             

                              $update = DB::table('grc_task')->where('project_id',$id)

                    ->update([

                              'status' => 1

                             ]);

                



      

            



                           return response()->json(['status' => 200, 'msg' => 'Successfully Active Project']);

    

     

        }

      }else{



           return response()->json(['status' => 200, 'msg' => "This project doesn't exist in database"]);

     

      }

      $projectlist = DB::table('grc_project')

                    ->get();

    



     return redirect('/Project-list')->with('projectlist');

    }







    function project_status_email($id){



        $userEmail = [];

       $projectstatus = DB::table('grc_project')->where('id',$id)->first();

      $useremail = DB::table('grc_user')->where('org_id',$projectstatus->organization_id)->where('status',1)->pluck('email');

      foreach ($useremail as $key => $value) {

      $userEmail[] = $value; 

      }



      if($projectstatus->status == 1){

        $class = 'Actived';

      }else{



        $class  = 'DeActived';



      }



              $msg = '<!DOCTYPE html>

<html>

<body style="background-color: #f6f6f6;">

<table

  style="padding-bottom:40px;margin-top:10px;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;"

  cellspacing="0" cellpadding="0" border="0" align="center">

  <tbody>

    <tr

      style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">

      <td class="container" width="600"

        style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"

        valign="top">

        <table style=" margin-top:30px;" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">

          <tbody>

            <tr>

              <table width="100%" border="0" cellpadding="0" style="border-collapse: collapse;border:1px solid #e9e9e9">

                <td style="

                        background: #fff;

                        padding: 5px;"><img

                    src="https://projectdemoonline.com/grcgreentest/public/assets/images/grc.png" width="60"></td>

                <td style="text-align: right;

                        background: #fff;

                        padding: 5px;"><img

                    src="https://projectdemoonline.com/grcgreentest/public/assets/images/green_erp_logo.png"

                    width="100"></td>

              </table>

      </td>

    </tr>

    <tr>

      <td width="600" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;">

        <table style=" margin-top:5px;" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">

          <tr>

            <td colspan="2" style=" background:#fff; vertical-align: bottom; margin:0; padding:0;">

              <div style="padding: 22px;  position:relative; float: left; width: 100%; box-sizing: border-box;">



                <div style="float:left; width:100%;margin-bottom: 20px;">

                  <div style=" margin:0px auto;   ">

                   <div

                      style="float: left; background: #3CC6ED none repeat scroll 0% 0%; padding: 55px 45px 35px; margin-bottom: 0px;">

                  <h3 style="color: rgb(0, 0, 0); font-family: Tahoma,sans-serif; font-size: 20px; line-height: 25px; margin-top: 0;">Welcome to GRC,</h3>

                 

                  

                   <p style="color: #fff; font-family: helvetica,sans-serif; font-size: 17px; line-height: 22px; margin: 0  0 25px; text-align: left;">We gives you access to all our features and tools available in our plan. So get started today ! .</p>

                 

                   <h3 style="color: #fff;  font-size: 18px; text-align: left; margin: 0 0 40px;"> Project is '.$class.': '.$projectstatus->project_name.'</h3>

                 

                    

                 

                  </div>

                 </div>

                 </div>

               </div>

              </td>

             </tr>

            </tbody></table>

           </td>

          </tr>

           </tbody></table>';

           

            $sub = "Project Details";

            $from = "dsaini@kloudrac.com";

            $fromname = "Not_To_Reply";



       

        MultiSendEmail(array_unique($userEmail),$sub,$from,$fromname,$msg);



        return response()->json(['status' => 200, 'msg' => 'Send Successfully']);



    }







     

     public function project_detail($id){



      $projectDet = DB::table('grc_project')->where('id',$id)

                    ->first();



                 $stateid = $projectDet->state;

                  $sectorid = $projectDet->sector;

         $sector = DB::table('grc_sector')->where('id',$sectorid)->first();       

      

      

      



     $con1 = DB::table('grc_project_condition_doc')->select('*','grc_project_condition_doc.id as conid','grc_user.id as userId')

          ->leftJoin('grc_user','grc_project_condition_doc.user_id','=','grc_user.id')

      ->where('grc_project_condition_doc.state_id',$stateid)->where('grc_project_condition_doc.sector_name',$sectorid)->where('grc_project_condition_doc.project_id',$id)->where('grc_project_condition_doc.doc_type','EC')->orderBy('grc_project_condition_doc.condition_number','ASC');

              

               if(session('role') != 'superadmin'){

                 

                  $con1->where('grc_user.org_id',session('org_id'));  

                   

               }

                $con1 = $con1->get();

              $con_arr = array();

              foreach ($con1 as $key => $con11) {

               $con_arr[] = $con11->document_statement;

              }



    // $project_condition_ec = DB::table('grc_document')->whereNotIn('document',$con_arr)->where('state',$stateid)->where('sector',$sector->id)->where('type','EC')->get();

     

          

        //$project_condition_cto = DB::table('grc_document')->where('state',$stateid)->where('sector',$sector->id)->where('type','CTO')->get();

              

      $con2 = DB::table('grc_project_condition_doc')->select('*','grc_project_condition_doc.id as conid','grc_user.id as userId')->leftJoin('grc_user','grc_project_condition_doc.user_id','=','grc_user.id')

      ->where('grc_project_condition_doc.state_id',$stateid)->where('grc_project_condition_doc.sector_name',$sectorid)->where('grc_project_condition_doc.project_id',$id)->where('grc_project_condition_doc.doc_type','CTO')->orderBy('grc_project_condition_doc.condition_number','ASC');

                    

                     if(session('role') != 'superadmin'){

                 

                  $con2->where('grc_user.org_id',session('org_id'));  

                   

               }

                    

                    $con2= $con2->get();



    // $project_condition_cte = DB::table('grc_document')->where('state',$stateid)->where('sector',$sector->id)->where('type','CTE')->get();

                    

      $con3 = DB::table('grc_project_condition_doc')->select('*','grc_project_condition_doc.id as conid','grc_user.id as userId')->leftJoin('grc_user','grc_project_condition_doc.user_id','=','grc_user.id')

      ->where('grc_project_condition_doc.state_id',$stateid)->where('grc_project_condition_doc.sector_name',$sectorid)->where('grc_project_condition_doc.project_id',$id)->where('grc_project_condition_doc.doc_type','CTE')->orderBy('grc_project_condition_doc.condition_number','ASC');

                    

                      if(session('role') != 'superadmin'){

                 

                  $con3->where('grc_user.org_id',session('org_id'));  

                   

               }

                    

                    $con3= $con3->get();





             //      $project_condition_gb = DB::table('grc_document')->where('state',$stateid)->where('sector',$sector->id)->where('type','GB')->get();

                    

      $con4 = DB::table('grc_project_condition_doc')->select('*','grc_project_condition_doc.id as conid','grc_user.id as userId')->leftJoin('grc_user','grc_project_condition_doc.user_id','=','grc_user.id')

      ->where('grc_project_condition_doc.state_id',$stateid)->where('grc_project_condition_doc.sector_name',$sectorid)->where('grc_project_condition_doc.project_id',$id)->where('grc_project_condition_doc.doc_type','GB')->orderBy('grc_project_condition_doc.condition_number','ASC');

                    

                     if(session('role') != 'superadmin'){

                 

                  $con4->where('grc_user.org_id',session('org_id'));  

                   

               }

                    

                    $con4 = $con4->get();

                    

        $userlist = DB::table('grc_user')->where('status',1);

        

                     if(session('role') != 'superadmin'){

                 

                  $userlist->where('grc_user.org_id',session('org_id'));  

                   

               }

                    $userlist = $userlist->where('role','Employee')->get();                         



          $projectshow = DB::table('grc_project')->where('id',$id)->first();

        //echo "<pre>";  print_r($con1); die('dsfs');

      return view('superadmin.project_detail',compact('userlist','id','con1','con2','con3','con4','stateid','sectorid','projectshow'));

    }



    public function project_condition_add(Request $request,$id){

      if($request->isMethod('post')) 

         {

           //  dd($request->all());

             

            $count = DB::table('grc_project_condition_doc')->where('document_statement',$request->compliance)->where('project_id',$id)->where('doc_type',$request->type)->count();

            if($count == 0){

                

         $date1 = new DateTime(date('Y-m-d'));

          $date2 = new DateTime($request->timeFrame);



         $diff = $date2->diff($date1);



         $hours = $diff->h;

        $hours = $hours + ($diff->days*24);

                

                

            $condition =     ['category_section' => $request->category,

                              'project_id' => $id,

                              'condition_number' => $request->condition_no,

                              'doc_type' => $request->type,

                              'user_id' => $request->userid,

                              'state_id' => $request->stateid,

                              'sector_name' => $request->sectorid,

                              'document_statement' => $request->compliance,

                              'created_by' => session('userId'),

                              'modified_by' =>session('userId'),

                              'created_date' =>date('Y-m-d H:i:s'),

                              'modified_date' =>date('Y-m-d H:i:s'),

                              'status' => 1

                             ];

                

                   $con_id = DB::table('grc_project_condition_doc')

                    ->insertGetId($condition);

                             

                             

                             $assign = [//'category_section' => $request->category,

                              'doc_id' => $con_id,

                              'condition_number' => $request->condition_no,

                              'doc_type' => $request->type,

                              'project_id' => $id,

                              'category_section' => $request->category,

                              'user_id' => $request->userid,

                              'state_id' => $request->stateid,

                              'sector_name' => $request->sectorid,

                              'document_statement' => $request->compliance,

                              'created_by' => session('userId'),

                              'modified_by' =>session('userId'),

                              'created_date' =>date('Y-m-d H:i:s'),

                              'modified_date' =>date('Y-m-d H:i:s'),

                              'status' => 1,

                              'last_date_task' => $request->timeFrame,

                              'condtion_status' => 2,

                             ];

                        



                        $assin = DB::table('grc_project_condition_doc_assign')->insert($assign);

                       

                    

                             

                            

         

        $tast_id = DB::table('grc_task')

                              ->insertGetId(['task_name' => $request->compliance,

                              'user_id' => $request->userid,

                              'task_id' => task_increment(),

                              'org_id' => session('org_id'),

                              'project_id' => $id,

                              'state_id' =>  $request->stateid,

                              'category' => $request->category,

                              'sector' =>  $request->sectorid,

                              'condition_no' => $request->condition_no,

                              

                              'type' => $request->type,

                              'estimated_hrs' => $hours??0,

                              'start_date' => date('Y-m-d H:i:s'),

                              'end_date' => $request->timeFrame,

                              'created_by' => session('userId'),

                              'modified_by' =>session('userId'),

                              'created_date' =>date('Y-m-d H:i:s'),

                              'modified_date' =>date('Y-m-d H:i:s'),

                              'task_status' => 'New',

                              'status' => 1,

                              'task_condition_status' => $con_id,

                             ]);



                                

       return redirect('/Project-detail/'.$id)->with('msg','Successfully Added And Assign Condition');

    }else{

      return redirect()->back()->with('add-pro-detail','This compliance already exist for this project');

    }

  }else{

    $projectDet = DB::table('grc_project')->where('id',$id)

                    ->first();

                  $stateid = $projectDet->state;

                  $sectorid = $projectDet->sector;



      





  $con1 = DB::table('grc_project_condition_doc')->select('*','grc_project_condition_doc.id as conid','grc_user.id as userId')

          ->leftJoin('grc_user','grc_project_condition_doc.user_id','=','grc_user.id')

      ->where('grc_project_condition_doc.state_id',$stateid)->where('grc_project_condition_doc.sector_name',$sectorid)->where('grc_project_condition_doc.project_id',$id)->where('grc_project_condition_doc.doc_type','EC');

              

               if(session('role') != 'superadmin'){

                 

                  $con1->where('grc_user.org_id',session('org_id'));  

                   

               }

                $con1 = $con1->get();

                

      $con2 = DB::table('grc_project_condition_doc')->select('*','grc_project_condition_doc.id as conid','grc_user.id as userId')->leftJoin('grc_user','grc_project_condition_doc.user_id','=','grc_user.id')

      ->where('grc_project_condition_doc.state_id',$stateid)->where('grc_project_condition_doc.sector_name',$sectorid)->where('grc_project_condition_doc.project_id',$id)->where('grc_project_condition_doc.doc_type','CTO');

                    

                     if(session('role') != 'superadmin'){

                 

                  $con2->where('grc_user.org_id',session('org_id'));  

                   

               }

                    

                    $con2= $con2->get();

                    

      $con3 = DB::table('grc_project_condition_doc')->select('*','grc_project_condition_doc.id as conid','grc_user.id as userId')->leftJoin('grc_user','grc_project_condition_doc.user_id','=','grc_user.id')

      ->where('grc_project_condition_doc.state_id',$stateid)->where('grc_project_condition_doc.sector_name',$sectorid)->where('grc_project_condition_doc.project_id',$id)->where('grc_project_condition_doc.doc_type','CTE');

                    

                      if(session('role') != 'superadmin'){

                 

                  $con3->where('grc_user.org_id',session('org_id'));  

                   

               }

                    

                    $con3= $con3->get();

                    

      $con4 = DB::table('grc_project_condition_doc')->select('*','grc_project_condition_doc.id as conid','grc_user.id as userId')->leftJoin('grc_user','grc_project_condition_doc.user_id','=','grc_user.id')

      ->where('grc_project_condition_doc.state_id',$stateid)->where('grc_project_condition_doc.sector_name',$sectorid)->where('grc_project_condition_doc.project_id',$id)->where('grc_project_condition_doc.doc_type','GB');

                    

                     if(session('role') != 'superadmin'){

                 

                  $con4->where('grc_user.org_id',session('org_id'));  

                   

               }

                    

                    $con4 = $con4->get();

                    

        $userlist = DB::table('grc_user');

        

                     if(session('role') != 'superadmin'){

                 

                  $userlist->where('grc_user.org_id',session('org_id'));  

                   

               }

                    $userlist = $userlist->get();                                  

     return view('superadmin.project_detail',compact('userlist','id','con1','con2','con3','con4','stateid','sectorid'));

  }

    }





public function project_condition_edit(Request $request,$id){



      if($request->isMethod('post')) 

         {

             

            

        

            $count = DB::table('grc_project_condition_doc')->where('id',$request->type)->count();

           

            if($count == 1){

              

              

            // echo $ID; die('sdsz');

             $documentData = DB::table('grc_project_condition_doc')->where('id',$request->type)

                    ->update([//'category_section' => $request->category,

                              //'condition_number' => $request->condition_no,

                              //'doc_type' => $request->type,

                              'user_id' => $request->userid,

                              //'state_id' => $request->stateid,

                              //'sector_name' => $request->sectorid,

                              'document_statement' => $request->compliance,

                              'created_by' => session('userId'),

                              'modified_by' =>session('userId'),

                              //'created_date' =>date('Y-m-d H:i:s'),

                              'modified_date' =>date('Y-m-d H:i:s'),

                              'status' => 1

                             ]);

                             

                             $documentData = DB::table('grc_project_condition_doc_assign')->where('doc_id',$request->type)

                    ->update([//'category_section' => $request->category,

                              //'condition_number' => $request->condition_no,

                              //'doc_type' => $request->type,

                              'user_id' => $request->userid,

                              //'state_id' => $request->stateid,

                              //'sector_name' => $request->sectorid,

                              'document_statement' => $request->compliance,

                              'created_by' => session('userId'),

                              'modified_by' =>session('userId'),

                              //'created_date' =>date('Y-m-d H:i:s'),

                              'modified_date' =>date('Y-m-d H:i:s'),

                              'status' => 1

                             ]);

         

        $update = DB::table('grc_task')->where('task_condition_status',$request->type)->where('project_id',$id)

                              ->update(['task_name' => $request->compliance,

                              'user_id' => $request->userid,

                             //'estimated_hrs' => $value->time_limit,

                              //'start_date' => $value->time_limit,

                              //'end_date' => $value->time_limit,

                              'created_by' => session('userId'),

                              'modified_by' =>session('userId'),

                              //'created_date' =>date('Y-m-d H:i:s'),

                              'modified_date' =>date('Y-m-d H:i:s'),

                              //'task_status' => 'New',

                              'status' => 1

                             ]);



                    $updaterealid = DB::table('grc_task')->where('add_condition_id',$request->type)->where('project_id',$id)->first();

                   

                       if(isset($updaterealid->id)){

                        $taskid = $updaterealid->id;



                              $updaterr = DB::table('grc_relation')

                    ->insert(['project_id' => $id,

                              'org_id' => session('org_id'),

                              'user_id' => $request->userid,

                              'task_id' => $taskid,

                              'created_date' => date('Y-m-d H:i:s'),

                              'modified_date' => date('Y-m-d H:i:s'),

                              'status' => 1

                             ]); 



                         }







                         

       return redirect('/Project-detail/'.$id)->with('userlist','id' ,'con1','con2','con3','con4','stateid','sectorid')->with('msg','This compliance updated');;

    }else{



      // $get_condition = DB::table('grc_document')->where('id',$request->type)->first();

      // $get_sector = DB::table('grc_sector')->where('id',$get_condition->sector)->first();



      //  $documentData = DB::table('grc_project_condition_doc')

      //               ->insert([//'category_section' => $request->category,

      //                         'condition_number' => $get_condition->condition_no,

      //                         'doc_type' => $get_condition->type,

      //                         'project_id' => $id,

      //                         'category_section' => $get_condition->category,

      //                         'user_id' => $request->userid,

      //                         'state_id' => $get_condition->state,

      //                         'sector_name' => $get_sector->sector_name,

      //                         'document_statement' => $request->compliance,

      //                         'created_by' => session('userId'),

      //                         'modified_by' =>session('userId'),

      //                         'created_date' =>date('Y-m-d H:i:s'),

      //                         'modified_date' =>date('Y-m-d H:i:s'),

      //                         'status' => 1

      //                        ]);

         

      //   $tast_id = DB::table('grc_task')

      //                         ->insertGetId(['task_name' => $request->compliance,

      //                         'user_id' => $request->userid,

      //                         'task_id' => 'TSK-'.mt_rand(1000,9999),

      //                         'org_id' => session('org_id'),

      //                         'project_id' => $id,

      //                         'state_id' => $get_condition->state,

      //                         'category' => $get_condition->category,

      //                         'sector' => $get_sector->sector_name,

      //                         'condition_no' => $get_condition->condition_no,

      //                         'user_id' => $request->userid,

      //                         'type' => $get_condition->type,

      //                        //'estimated_hrs' => $value->time_limit,

      //                         //'start_date' => $value->time_limit,

      //                         //'end_date' => $value->time_limit,

      //                         'created_by' => session('userId'),

      //                         'modified_by' =>session('userId'),

      //                         'created_date' =>date('Y-m-d H:i:s'),

      //                         'modified_date' =>date('Y-m-d H:i:s'),

      //                         'task_status' => 'New',

      //                         'status' => 1

      //                        ]);



                  



      //                         $updaterr = DB::table('grc_relation')

      //               ->insert(['project_id' => $id,

      //                         'org_id' => session('org_id'),

      //                         'user_id' => $request->userid,

      //                         'task_id' => $tast_id,

      //                         'created_date' => date('Y-m-d H:i:s'),

      //                         'modified_date' => date('Y-m-d H:i:s'),

      //                         'status' => 1

      //                        ]); 





      // return redirect()->back()->with('add-pro-detail','Successfully Assign Users');



      return redirect()->back()->with('add-pro-detail','This compliance already exist for this project');

    }

  }else{

    $projectDet = DB::table('grc_project')->where('id',$id)

                    ->first();

                  $stateid = $projectDet->state;

                  $sectorid = $projectDet->sector;



     





           $con1 = DB::table('grc_project_condition_doc')->select('*','grc_project_condition_doc.id as conid','grc_user.id as userId')

          ->leftJoin('grc_user','grc_project_condition_doc.user_id','=','grc_user.id')

      ->where('grc_project_condition_doc.state_id',$stateid)->where('grc_project_condition_doc.sector_name',$sectorid)->where('grc_project_condition_doc.project_id',$id)->where('grc_project_condition_doc.doc_type','EC');

              

               if(session('role') != 'superadmin'){

                 

                  $con1->where('grc_user.org_id',session('org_id'));  

                   

               }

                $con1 = $con1->get();

                

      $con2 = DB::table('grc_project_condition_doc')->select('*','grc_project_condition_doc.id as conid','grc_user.id as userId')->leftJoin('grc_user','grc_project_condition_doc.user_id','=','grc_user.id')

      ->where('grc_project_condition_doc.state_id',$stateid)->where('grc_project_condition_doc.sector_name',$sectorid)->where('grc_project_condition_doc.project_id',$id)->where('grc_project_condition_doc.doc_type','CTO');

                    

                     if(session('role') != 'superadmin'){

                 

                  $con2->where('grc_user.org_id',session('org_id'));  

                   

               }

                    

                    $con2= $con2->get();

                    

      $con3 = DB::table('grc_project_condition_doc')->select('*','grc_project_condition_doc.id as conid','grc_user.id as userId')->leftJoin('grc_user','grc_project_condition_doc.user_id','=','grc_user.id')

      ->where('grc_project_condition_doc.state_id',$stateid)->where('grc_project_condition_doc.sector_name',$sectorid)->where('grc_project_condition_doc.project_id',$id)->where('grc_project_condition_doc.doc_type','CTE');

                    

                      if(session('role') != 'superadmin'){

                 

                  $con3->where('grc_user.org_id',session('org_id'));  

                   

               }

                    

                    $con3= $con3->get();

                    

      $con4 = DB::table('grc_project_condition_doc')->select('*','grc_project_condition_doc.id as conid','grc_user.id as userId')->leftJoin('grc_user','grc_project_condition_doc.user_id','=','grc_user.id')

      ->where('grc_project_condition_doc.state_id',$stateid)->where('grc_project_condition_doc.sector_name',$sectorid)->where('grc_project_condition_doc.project_id',$id)->where('grc_project_condition_doc.doc_type','GB');

                    

                     if(session('role') != 'superadmin'){

                 

                  $con4->where('grc_user.org_id',session('org_id'));  

                   

               }

                    

                    $con4 = $con4->get();

                    

        $userlist = DB::table('grc_user');

        

                     if(session('role') != 'superadmin'){

                 

                  $userlist->where('grc_user.org_id',session('org_id'));  

                   

               }

                    $userlist = $userlist->get();         

     return view('superadmin.project_detail',compact('userlist','id','con1','con2','con3','con4','stateid','sectorid'));

  }

    }



    public function project_condition_delete(Request $request){

//echo $request->type; die('sdsz');





    //echo $dataid; die('fgd');

      if($request->isMethod('post')) 

         {

       

      

           foreach ($request->selected as $value) {

            $documentData = DB::table('grc_project_condition_doc')->where('id',$value)->delete();

            $documentData = DB::table('grc_project_condition_doc_assign')->where('doc_id',$value)->delete();

           }

             $update = DB::table('grc_task')->where('add_condition_id',$value)->delete();

              $request->session()->flash('msg', 'Condition Delete Successfully.');

       return ('Successfully');           

     }

    }



    public function additional_projectstage(Request $request,$id){



      if($request->isMethod('post')) 

         {

             

            

             

           $validator = Validator::make($request->all(), [

            'addCondition' => 'required|max:100',

            

        ],$this->customMsg());



        if ($validator->fails()) {

            return redirect()->back()

                        ->withErrors($validator)

                        ->withInput();

        }

            $count = DB::table('grc_project_additional_condition')->where('stage_name',$request->addCondition)->count();

            // echo $count; die('sdsz');

            if($count == 0){

              

            $documentData = DB::table('grc_project_additional_condition')

                    ->insert(['stage_name' => $request->addCondition,

                              'project_id' => $id,

                              'created_by' => session('userId'),

                              'modified_by' =>session('userId'),

                              'created_date' =>date('Y-m-d H:i:s'),

                              'modified_date' =>date('Y-m-d H:i:s'),

                              'status' => 1

                             ]);

                  

      $projectDet = DB::table('grc_project')->where('id',$id)

                    ->first();

                  $stateid = $projectDet->state;

                  $sectorid = $projectDet->sector;



      



  $con1 = DB::table('grc_project_condition_doc')->select('*','grc_project_condition_doc.id as conid','grc_user.id as userId')

           ->leftJoin('grc_user','grc_project_condition_doc.user_id','=','grc_user.id')

      ->where('grc_project_condition_doc.state_id',$stateid)->where('grc_project_condition_doc.sector_name',$sectorid)->where('grc_project_condition_doc.project_id',$id)->where('grc_project_condition_doc.doc_type','EC')

                    ->get();

      $con2 = DB::table('grc_project_condition_doc')->select('*','grc_project_condition_doc.id as conid','grc_user.id as userId')->leftJoin('grc_user','grc_project_condition_doc.user_id','=','grc_user.id')

      ->where('grc_project_condition_doc.state_id',$stateid)->where('grc_project_condition_doc.sector_name',$sectorid)->where('grc_project_condition_doc.project_id',$id)->where('grc_project_condition_doc.doc_type','CTO')

                    ->get();

      $con3 = DB::table('grc_project_condition_doc')->select('*','grc_project_condition_doc.id as conid','grc_user.id as userId')->leftJoin('grc_user','grc_project_condition_doc.user_id','=','grc_user.id')

      ->where('grc_project_condition_doc.state_id',$stateid)->where('grc_project_condition_doc.sector_name',$sectorid)->where('grc_project_condition_doc.project_id',$id)->where('grc_project_condition_doc.doc_type','CTE')

                    ->get();

      $con4 = DB::table('grc_project_condition_doc')->select('*','grc_project_condition_doc.id as conid','grc_user.id as userId')->leftJoin('grc_user','grc_project_condition_doc.user_id','=','grc_user.id')

      ->where('grc_project_condition_doc.state_id',$stateid)->where('grc_project_condition_doc.sector_name',$sectorid)->where('grc_project_condition_doc.project_id',$id)->where('grc_project_condition_doc.doc_type','GB')

                    ->get(); 

                    $userlist = DB::table('grc_user')

                    ->get();           

       return redirect('/Project-detail/'.$id)->with('userlist','id' ,'con1','con2','con3','con4','stateid','sectorid')->with('msg','Added New Condition');

    }else{

      return redirect()->back()->with('msg','This compliance already exist for this project');

    }

  }else{

    $projectDet = DB::table('grc_project')->where('id',$id)

                    ->first();

                  $stateid = $projectDet->state;

                  $sectorid = $projectDet->sector;



    





       $con1 = DB::table('grc_project_condition_doc')->select('*','grc_project_condition_doc.id as conid','grc_user.id as userId')->leftJoin('grc_user','grc_project_condition_doc.user_id','=','grc_user.id')

      ->where('grc_project_condition_doc.state_id',$stateid)->where('grc_project_condition_doc.sector_name',$sectorid)->where('grc_project_condition_doc.project_id',$id)->where('grc_project_condition_doc.doc_type','EC')

                    ->get();

      $con2 = DB::table('grc_project_condition_doc')->select('*','grc_project_condition_doc.id as conid','grc_user.id as userId')->leftJoin('grc_user','grc_project_condition_doc.user_id','=','grc_user.id')

      ->where('grc_project_condition_doc.state_id',$stateid)->where('grc_project_condition_doc.sector_name',$sectorid)->where('grc_project_condition_doc.project_id',$id)->where('grc_project_condition_doc.doc_type','CTO')

                    ->get();

      $con3 = DB::table('grc_project_condition_doc')->select('*','grc_project_condition_doc.id as conid','grc_user.id as userId')->leftJoin('grc_user','grc_project_condition_doc.user_id','=','grc_user.id')

      ->where('grc_project_condition_doc.state_id',$stateid)->where('grc_project_condition_doc.sector_name',$sectorid)->where('grc_project_condition_doc.project_id',$id)->where('grc_project_condition_doc.doc_type','CTE')

                    ->get();

      $con4 = DB::table('grc_project_condition_doc')->select('*','grc_project_condition_doc.id as conid','grc_user.id as userId')->leftJoin('grc_user','grc_project_condition_doc.user_id','=','grc_user.id')

      ->where('grc_project_condition_doc.state_id',$stateid)->where('grc_project_condition_doc.sector_name',$sectorid)->where('grc_project_condition_doc.project_id',$id)->where('grc_project_condition_doc.doc_type','GB')

                    ->get();

                    $userlist = DB::table('grc_user')

                    ->get();           

     return view('superadmin.project_detail',compact('userlist','id','con1','con2','con3','con4','stateid','sectorid'));

  }

    }

 public function project_assignuser(Request $request,$id){



// dd($request->all());

  //echo $request->conditionrealid; die('dsfsf');

  if($request->isMethod('post')) 

         {

         

         $projectDetails = DB::table('grc_project')->where('id',$id)->first();



        //   $uniq_order = count(array_unique($request->order));

        //   $order_no = count($request->order);

        //   if($order_no != $uniq_order){

              

        //       return redirect()->back()->with('error','Order No Not Unique');



        //   }

           

           DB::table('grc_project_condition_doc_assign')->where('project_id',$id)->where('doc_type',$request->doc_type)->delete();

            DB::table('grc_task')->where('project_id',$id)->where('type',$request->doc_type)->delete();

          
           $i = 1;
          foreach ($request->conditionrealid as $key => $con_id) {





            $date1 = new DateTime(date('Y-m-d'));

          $date2 = new DateTime($request->timeFrame[$key]);



         $diff = $date2->diff($date1);



         $hours = $diff->h;

        $hours = $hours + ($diff->days*24);



          

           $get_doc_condition = DB::table('grc_project_condition_doc')->where('id',$con_id)->first();

          

           if(isset($get_doc_condition)){

            

           

            //DB::table('grc_task')->where('project_id',$id)->where('type',$get_doc_condition->doc_type)->delete();

 

              $assign = [//'category_section' => $request->category,

                              'doc_id' => $con_id,

                              'condition_number' => $i,

                              'doc_type' => $get_doc_condition->doc_type,

                              'project_id' => $id,

                              'category_section' => $get_doc_condition->category_section,

                              'user_id' => $request->username[$key],

                              'state_id' => $get_doc_condition->state_id??0,

                              'sector_name' => $get_doc_condition->sector_name??'',

                              'document_statement' => $request->document[$key],

                              'created_by' => session('userId'),

                              'modified_by' =>session('userId'),

                              'created_date' =>date('Y-m-d H:i:s'),

                              'modified_date' =>date('Y-m-d H:i:s'),

                              'status' => 1,

                              'last_date_task' => $request->timeFrame[$key],

                              'condtion_status' => 2,

                             ];

                        

                                  DB::table('grc_project_condition_doc')->where('id',$con_id)->update(['condition_number' => $i]);

                        $assin = DB::table('grc_project_condition_doc_assign')->insert($assign);

                       

                    

                             

                            

         

        $tast_id = DB::table('grc_task')

                              ->insertGetId(['task_name' => $request->document[$key],

                              'user_id' => $request->username[$key],

                              'task_id' => task_increment(),

                              'org_id' => $projectDetails->organization_id,

                              'project_id' => $id,

                              'state_id' => $get_doc_condition->state_id??0,

                              'category' => $get_doc_condition->category_section,

                              'sector' => $get_doc_condition->sector_name,

                              'condition_no' =>  $i,

                              'user_id' => $request->username[$key],

                              'type' => $get_doc_condition->doc_type,

                              'estimated_hrs' => $hours??0,

                              'start_date' => date('Y-m-d H:i:s'),

                              'end_date' => $request->timeFrame[$key],

                              'created_by' => session('userId'),

                              'modified_by' =>session('userId'),

                              'created_date' =>date('Y-m-d H:i:s'),

                              'modified_date' =>date('Y-m-d H:i:s'),

                              'task_status' => 'New',

                              'status' => 1,

                              'task_condition_status' => $con_id,

                             ]);



                  



                              $updaterr = DB::table('grc_relation')

                    ->insert(['project_id' => $id,

                              'org_id' => session('org_id'),

                              'user_id' => $request->username[$key],

                              'task_id' => $tast_id,

                              'created_date' => date('Y-m-d H:i:s'),

                              'modified_date' => date('Y-m-d H:i:s'),

                              'status' => 1

                             ]); 



           }

            $i++;

          }

                      }





      return redirect()->back()->with('msg','Successfully Assign Users');



       





   

 }

   

    public function superadmin_proview($id){



      $projectview = DB::table('grc_project')->select('*','alm_states.name as statename','alm_cities.name as cityname','grc_project.description as prodescription','grc_project.id as proid','grc_project.pincode as propincode','grc_user.first_name','grc_user.middle_name','grc_user.last_name','grc_sector.sector_name')

                          ->leftjoin('grc_organization','grc_project.organization_id','=','grc_organization.id')

                          ->leftjoin('main_currency','grc_project.currency_id','=','main_currency.id')

                          ->leftjoin('alm_states','grc_project.state','=','alm_states.id')

                          ->leftjoin('grc_sector','grc_sector.id','=','grc_project.sector')

                          ->leftjoin('alm_cities','grc_project.city','=','alm_cities.id')

                          ->leftjoin('grc_user','grc_project.project_manager','=','grc_user.id')

                          ->where('grc_project.id',$id)

                          ->first();

        

        

                          



      return view('superadmin.project_view',compact('projectview','id'));

    }  





        public function project_document(Request $request,$id){

            if($request->isMethod('post')) 

         { 



           $validator = Validator::make($request->all(), [

            'task_upload' =>  'required|max:500000|mimes:doc,docx,pdf,jpg,gif,jpeg,png',

            'selectcatefory' => 'required',

            

        ],$this->customMsg());



        if ($validator->fails()) {

            return redirect()->back()

                        ->withErrors($validator)

                        ->withInput();

        }



       

           if ($request->file('task_upload')) {

                    $destinationPath = public_path('uploads');

                    $extension = $request->file('task_upload')->getClientOriginalExtension();

                    $fileName = uniqid().'.'.$extension;

                    $request->file('task_upload')->move($destinationPath, $fileName);

                }else{

                   $fileName = '0'; 

                }

          

       // dd($request->all());



          $documentData = DB::table('project_document')

                    ->insert(['document' => $fileName,

                              'category' => $request->selectcatefory,

                              'project_id' => $id,

                              'created_by' => session('userId'),

                              'modified_by' =>session('userId'),

                              'status' => 1

                             ]);



    //     $projectview = DB::table('grc_project')->select('*','alm_states.name as statename','alm_cities.name as cityname','grc_project.description as prodescription','grc_project.id as proid')

    //                       ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')

    //                       ->join('main_currency','grc_project.currency_id','=','main_currency.id')

    //                       ->join('alm_states','grc_project.state','=','alm_states.id')

    //                       ->join('alm_cities','grc_project.city','=','alm_cities.id')

    //                       ->where('grc_project.id',$id)

    //                       ->first();



    //         $projectdoc = DB::table('project_document')->where('project_id',$id)->get();         



    //   return view('superadmin.project_view',compact('projectview','projectdoc'));

    

         return redirect()->back()->with('msg','Successfully Uploaded Doc');

    

       }else{

        $projectview = DB::table('grc_project')->select('*','alm_states.name as statename','alm_cities.name as cityname','grc_project.description as prodescription','grc_project.id as proid')

                          ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')

                          ->join('main_currency','grc_project.currency_id','=','main_currency.id')

                          ->join('alm_states','grc_project.state','=','alm_states.id')

                          ->join('alm_cities','grc_project.city','=','alm_cities.id')

                          ->where('grc_project.id',$id)

                          ->first();



                           



      return view('superadmin.project_view',compact('projectview'));

       }

      }



 public function project_document_delete(Request $request,$id) {



       $count = DB::table('project_document')->where('id',$id)->count();



       if($count == 1){

        $deletecountry = DB::table('project_document')->where('id',$id)->delete();



          return back()->with('doc-deleted','Data deleted!');

         //return redirect('/country');

       }else{

        return back()->with('docnot','Data not deleted!');

       }

    

    }





     public function countryadd(Request $request) {

         

         

        if($request->isMethod('post')) 

       {      

           

           //dd($request->all());

           

               $validator = Validator::make($request->all(), [

            'countryname' => 'required',

            

            

        ],$this->customMsg());



        if ($validator->fails()) {

            return redirect('/country')

                        ->withErrors($validator)

                        ->withInput();

        }

        

        

        

        



             //$country = array();

              // $country['cname'] = $request->countryname;

             

          foreach ($request->countryname as $value)

           {

          

            $update = DB::table('grc_superadmin_country_list')

                    ->insert(['country_id' => $value,

                              'created_date' => date('Y-m-d H:i:s'),

                              'modified_date' => date('Y-m-d H:i:s'),

                              'status' => 1

                             ]);  

           



          }

          

 

         $request->session()->flash('alert-success', 'Data add Successfully.'); 

         return redirect()->back();

       }else{



        $superCountry = DB::table('grc_superadmin_country_list')->select('alm_countries.name as countryname','grc_superadmin_country_list.created_date as createdate','grc_superadmin_country_list.id as countryid')

                        ->join('alm_countries','alm_countries.id','=','grc_superadmin_country_list.country_id')->get();

           $CData = array();

           $existcountryid = [];

            foreach ($superCountry as $value) {

                $res['countryname'] = isset($value->countryname)?$value->countryname:'';

                $res['createdate'] = isset($value->createdate)?$value->createdate:'';

                $res['countryid'] = isset($value->countryid)?$value->countryid:'';

                $existcountryid[] = isset($value->countryid)?$value->countryid:'';

                $CData[] = $res;                         

         } 



//dd($existcountryid);

    

     

      $Country = DB::table('alm_countries')->get();

      $Data = array();

            foreach ($Country as $value) {

                $res['name'] = isset($value->name)?$value->name:'';

                $res['id'] = isset($value->id)?$value->id:'';

                $Data[] = $res;                         

         }                          

     return view('superadmin.country_add',compact('Data','CData','existcountryid'));

   }

    }





     public function countrydelete(Request $request,$id) {



      // $count = DB::table('grc_superadmin_country_list')->where('country_id',$id)->count();

       

        $deletecountry = DB::table('grc_superadmin_country_list')->where('id',$id)->delete();



    //   if($count == 1){

    //     $deletecountry = DB::table('grc_superadmin_country_list')->where('country_id',$id)->delete();



    //      $request->session()->flash('delete-country', 'Data deleted Successfully.');

    //      return redirect('/country');

    //   }else{

    //     return back()->with('countries-deleted','Data not deleted!');

    //   }

     return redirect()->back();

    }



public function statelist($countryid)

{    

    $state = array();

            $statelist = DB::table('alm_states')

                      ->select('*')

                      ->where('country_id',$countryid)

                      ->get();

        foreach ($statelist as $key => $value) {

        $val['id'] = isset($value->id)?$value->id:'';

        $val['name'] = isset($value->name)?$value->name:'';

       

        $state[] = $val;

       }

    return $state;

   

   }



   function mng_list($org_id){







    $user = DB::table('grc_user')->where('role','project_Manager')->where('status',1)->where('org_id',$org_id)->get();

  

   $mng = array();

     foreach ($user as $key => $value) {

        $val['id'] = isset($value->id)?$value->id:'';

        $val['name'] = isset($value->first_name)?$value->first_name . ' ' .$value->last_name:'';

       

        $mng[] = $val;

       }

      

    return $mng;



   }



   function project_type($condition,$projectid){

     $get_project = DB::table('grc_project')->where('id',$projectid)->first();



     $update = DB::table('grc_project')->where('id',$projectid)->update(['project_stage' =>$condition]);



           return response()->json(['status' => 200, 'msg' => 'Successfully Updated']);

        

   }



   public function citylist($stateid)

{    

    

    //dd($stateid);

    $city = array();

            $statelist = DB::table('alm_cities')

                      ->select('*')

                      ->where('state_id',$stateid)

                      ->get();

        foreach ($statelist as $key => $value) {

        $val['id'] = isset($value->id)?$value->id:'';

        $val['name'] = isset($value->name)?$value->name:'';

       

        $city[] = $val;

       }

    return $city;

   

   }



   function get_project($org_id){



         

            $org= DB::table('grc_project')

            ->join('alm_states','grc_project.state','=','alm_states.id')

         ->join('alm_cities','grc_project.city','=','alm_cities.id')

         ->join('main_currency','grc_project.currency_id','=','main_currency.id')

         ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')

         ->join('grc_sector','grc_project.sector','=','grc_sector.id')

         ->join('grc_user','grc_project.project_manager','=','grc_user.id')

                      ->select('grc_project.*')

                      ->where('grc_project.organization_id',$org_id)

                      ->get();

      

    return $org;

   



   }



   public function statusadd(Request $request){



  $status_list = DB::table('grc_status')->get();

   $status_edit = [];

  if(!empty($_GET['edit'])){

    $status_edit = DB::table('grc_status')->where('id',$_GET['edit'])->first(); 

  }



if(!empty($request->status_id)){

       $update = DB::table('grc_status')->where('id',$request->status_id)

                    ->update(['status_name' => $request->status,

                              'createdby' => session('userId'),

                              'modifiedby' => session('userId'),

                              'created_date' => date('Y-m-d H:i:s'),

                              'modified_date' => date('Y-m-d H:i:s'),

                              'status' => 1

                             ]);



      return redirect('status-management')->with('warning-status','Successfully Updated');

  }





     if($request->isMethod('post')) 

       {  



        $countcurrency = DB::table('grc_status')->where('status_name',$request->status)->count();

          if($countcurrency == 0){

          $update = DB::table('grc_status')

                    ->insert(['status_name' => $request->status,

                              'createdby' => session('userId'),

                              'modifiedby' => session('userId'),

                              'created_date' => date('Y-m-d H:i:s'),

                              'modified_date' => date('Y-m-d H:i:s'),

                              'status' => 1

                             ]);



      $request->session()->flash('alert-status', 'Data add Successfully.');

       return redirect()->back();

    }else{

      return redirect()->back()->with('warning-status','Status already exist');

    }

    }else{



      //$request->session()->flash('war-status', 'Data not added.');

      return view('superadmin.status_add',['status_list' => $status_list,'status_edit' => $status_edit]);

    }

    }



    public function sectoradd(Request $request){



$sector_list = DB::table('grc_sector')->get();

$sector_edit = [];





if(!empty($_GET['edit'])){



  $sector_edit  = DB::table('grc_sector')->where('id',$_GET['edit'])->first();





}



 if($request->isMethod('post')) 

       {





         $validator = Validator::make($request->all(), [

            'sector' => 'required',

            

            

        ],$this->customMsg());



        if ($validator->fails()) {

            return redirect()->back()

                        ->withErrors($validator)

                        ->withInput();

        }



if(!empty($request->sector_id)){







   $update = DB::table('grc_sector')->where('id',$request->sector_id)

                    ->update(['sector_name' => $request->sector,

                              'created_by' => session('userId'),

                              'modified_by' => session('userId'),

                              'created_date' => date('Y-m-d H:i:s'),

                              'modified_date' => date('Y-m-d H:i:s'),

                              'status' => 1

                             ]);



                     return redirect('sector-management')->with('msg','Successfully Updated');

}



      



     

          $countcurrency = DB::table('grc_sector')->where('sector_name',$request->sector)->count();

          if($countcurrency == 0){

          $update = DB::table('grc_sector')

                    ->insert(['sector_name' => $request->sector,

                              'created_by' => session('userId'),

                              'modified_by' => session('userId'),

                              'created_date' => date('Y-m-d H:i:s'),

                              'modified_date' => date('Y-m-d H:i:s'),

                              'status' => 1

                             ]);



      $request->session()->flash('alert-sector', 'Data add Successfully.');

      return redirect('sector-management');

       }else{

        return redirect()->back()->with('warning-sector','Data already exist');

       }

    }else{



      //$request->session()->flash('war-status', 'Data not added.');

      return view('superadmin.sector_add',['sector_list' => $sector_list,'sector_edit' => $sector_edit ]);

    }

    }



    public function typeadd(Request $request){



       $type = DB::table('grc_type')->get();

        $type_edit = [];

       if(!empty($_GET['edit'])){



         $type_edit = DB::table('grc_type')->where('id',$_GET['edit'])->first();



       }



 

       



      if($request->isMethod('post')) 

       { 













          $validator = Validator::make($request->all(), [

            'type_name' => 'required',

            

            

        ]);



        if ($validator->fails()) {

            return redirect('/type-management')

                        ->withErrors($validator)

                        ->withInput();

        }





                   if(!empty($request->type_id)){



          $update = DB::table('grc_type')->where('id',$request->type_id)

                    ->update(['type_name' => $request->type,

                              'createdby' => session('userId'),

                              'modifiedby' => session('userId'),

                              'created_date' => date('Y-m-d H:i:s'),

                              'modified_date' => date('Y-m-d H:i:s'),

                              'status' => 1

                             ]);

       return redirect('type-management')->with('msg','Successfully updated');

       }





          $countcurrency = DB::table('grc_type')->where('type_name',$request->type)->count();

          if($countcurrency == 0){

          $update = DB::table('grc_type')

                    ->insert(['type_name' => $request->type,

                              'createdby' => session('userId'),

                              'modifiedby' => session('userId'),

                              'created_date' => date('Y-m-d H:i:s'),

                              'modified_date' => date('Y-m-d H:i:s'),

                              'status' => 1

                             ]);



      $request->session()->flash('alert-type', 'Data add Successfully.');

      return redirect()->back();

       }else{

        return redirect()->back()->with('warning-type','Data already exist');

       }

    }else{



      //$request->session()->flash('war-status', 'Data not added.');

      return view('superadmin.type_add',['type' => $type,'type_edit' =>  $type_edit]);

    }

    }



    public function currencyadd(Request $request){



      $currency_list = DB::table('main_currency')->get();

       $currency_edit = [];

      if(!empty($_GET['edit'])){

        $currency_edit = DB::table('main_currency')->where('id',$_GET['edit'])->first(); 

      }



      if($request->isMethod('post')) 

       { 



        $validator = Validator::make($request->all(), [

            'currency' => 'required',

            'currency_code' => 'required',

            

            

        ],$this->customMsg());



        if ($validator->fails()) {

            return redirect('/currency-management')

                        ->withErrors($validator)

                        ->withInput();

        }



              if(!empty($request->currency_id)){

            $update = DB::table('main_currency')->where('id',$request->currency_id)

                    ->update(['currencyname' => $request->currency,

                              'currencycode' => $request->currency_code,

                              'createdby' => session('userId'),

                              'modifiedby' => session('userId'),

                              'createddate' => date('Y-m-d H:i:s'),

                              'modifieddate' => date('Y-m-d H:i:s'),

                              'isactive' => 1

                             ]);



            return redirect('currency-management')->with('warning-currency','Successfully Updated');



                  }

          $countcurrency = DB::table('main_currency')->where('currencyname',$request->currency)->where('currencycode',$request->currency_code)->count();

          if($countcurrency == 0){

          $update = DB::table('main_currency')

                    ->insert(['currencyname' => $request->currency,

                              'currencycode' => $request->currency_code,

                              'createdby' => session('userId'),

                              'modifiedby' => session('userId'),

                              'createddate' => date('Y-m-d H:i:s'),

                              'modifieddate' => date('Y-m-d H:i:s'),

                              'isactive' => 1

                             ]);



      $request->session()->flash('alert-currency', 'Data add Successfully.');

      return redirect()->back();

       }else{

        return redirect()->back()->with('warning-currency','Currency already exist');

       }

    }else{



      //$request->session()->flash('war-status', 'Data not added.');

      return view('superadmin.currency_add',['currency_list'=>$currency_list,'currency_edit' => $currency_edit]);

    }

    }



    public function stageadd(Request $request){



      $stage_list = DB::table('grc_stages')->get();

      $stage_edit = [];

      if(!empty($_GET['edit'])){

        $stage_edit = DB::table('grc_stages')->where('id',$_GET['edit'])->first();

      }



     



      



      if($request->isMethod('post')) 

       { 





          $validator = Validator::make($request->all(), [

            'stage' => 'required',

           

            

            

        ],$this->customMsg());



        if ($validator->fails()) {

            return redirect()->back()

                        ->withErrors($validator)

                        ->withInput();

        }





         if(!empty($request->stage_id)){

       $update = DB::table('grc_stages')->where('id',$request->stage_id)

                    ->update(['stage_name' => $request->stage,

                              'createdby' => session('userId'),

                              'modifiedby' => session('userId'),

                              'createdate' => date('Y-m-d H:i:s'),

                              'modifieddate' => date('Y-m-d H:i:s'),

                              'status' => 1

                             ]);



       return redirect('stage-management')->with('msg','Successfully Updated');

      }

          $countcurrency = DB::table('grc_stages')->where('stage_name',$request->stage)->count();

          if($countcurrency == 0){

          $update = DB::table('grc_stages')

                    ->insert(['stage_name' => $request->stage,

                              'createdby' => session('userId'),

                              'modifiedby' => session('userId'),

                              'createdate' => date('Y-m-d H:i:s'),

                              'modifieddate' => date('Y-m-d H:i:s'),

                              'status' => 1

                             ]);



      $request->session()->flash('msg', 'Data add Successfully.');

      return redirect()->back();

       }else{

        return redirect()->back()->with('warning-stage','Stage already exist');

       }

    }else{



      //$request->session()->flash('war-status', 'Data not added.');

      return view('superadmin.stage_add',['stage_list' => $stage_list,'stage_edit' =>  $stage_edit]);

    }

    }

    public function userlist(Request $request){

        

       



      if (session('role') == 'project_Manager') {

       // $user_list = DB::table('grc_user')->where('role','Employee')->where('created_by',session('userId'));





        $user_list = DB::table('grc_user')->where('grc_user.role','Employee')->join('alm_countries','grc_user.country','=','alm_countries.id')->join('alm_states','grc_user.state','=','alm_states.id')->join('alm_cities','grc_user.city','=','alm_cities.id')->where('grc_user.created_by',session('userId'))->select('grc_user.*','alm_countries.name as country_name','alm_states.name as state_name','alm_cities.name as city_name')->where('grc_user.id','!=',session('userId'));





        if(isset($request->users)){

$user_list->where('grc_user.employee_id', 'like', '%' . $request->users . '%')->orWhere('grc_user.first_name', 'like', '%' . $request->users . '%')->orWhere('grc_user.last_name', 'like', '%' . $request->users . '%')->orWhere('grc_user.email', 'like', '%' . $request->users . '%');

            

        }





    $user_list  =  $user_list->orderBy('grc_user.id','DESC')->get();

    

      }else{

       $user_list = DB::table('grc_user')->where('id','!=',session('userId'));

       

       if(session('role') !='superadmin'){

           $user_list ->where('created_by',session('userId'));

       }

      $user_list =  $user_list->whereIN('role',['Employee','project_Manager','admin']);



         if(isset($request->users)){

$user_list->where('employee_id', 'like', '%' . $request->users . '%')->orWhere('first_name', 'like', '%' . $request->users . '%')->orWhere('last_name', 'like', '%' . $request->users . '%')->orWhere('email', 'like', '%' . $request->users . '%');

            

        }



      $user_list  =  $user_list->orderBy('id','DESC')->get();

      }

      

      if(!empty($request->export)){

          

                 $user_list = DB::table('grc_user')->where('id','!=',session('userId'));

       

       if(session('role') !='superadmin'){

           $user_list ->where('org_id',session('org_id'));

       }

      $user_list =  $user_list->whereIN('role',['Employee','project_Manager','admin']);



         if(isset($request->users)){

$user_list->where('employee_id', 'like', '%' . $request->users . '%')->orWhere('first_name', 'like', '%' . $request->users . '%')->orWhere('last_name', 'like', '%' . $request->users . '%')->orWhere('email', 'like', '%' . $request->users . '%');

            

        }



      $user_data  =  $user_list->orderBy('id','DESC')->get();

          

          

          

          // $user_data  =  $user_list->get();

           

        

          

            $columns = array('S.No', 'EMP Code', 'First Name', 'last Name', 'Email','Phone','Role');



    

    $filename = public_path("uploads/csv/user_'".time()."'_report.csv");

    $handle = fopen($filename, 'w+');

    fputcsv($handle, $columns);



         $i = 1;

        foreach($user_data as $user_datas) {



           fputcsv($handle, array($i++, 'EMP-'.$user_datas->employee_id,ucwords($user_datas->first_name),ucwords($user_datas->last_name),$user_datas->email,$user_datas->mobile_no,$user_datas->role));

        }

        

       fclose($handle);



       $headers = array(

        'Content-Type' => 'text/csv'

       

        );





    return Response()->download($filename);



      }

      

      

      

      return view('superadmin.user_list',compact('user_list'));

    }



    

    public function user_add(Request $request){

      //echo $request->org_name; die('fsdfs');

       if($request->isMethod('post')) 

       { 

       // dd($request->all());





    if(isset($request->user_id)){



            $userArr = array();

           if($request->hasFile('profileimage')) {

             $file = $request->file('profileimage');



             $original_name = strtolower(trim($file->getClientOriginalName()));



             $getFileExt   = $file->getClientOriginalExtension();

             $uploadedFile =   time().'.'.$getFileExt;

             

             $name = $uploadedFile;

             $path = public_path('/uploads_profileimg');

             

            $file->move($path, $name);

            $fileName = $name;

          // dd($fileName);

             $userArr['photo'] = $fileName;

             }





                              $userArr['first_name'] = $request->fname;

                              $userArr['middle_name'] = $request->mname;

                              $userArr['last_name'] = $request->lname;

                              $userArr['pre_alt_mob'] = $request->pre_alt_mob;

                              $userArr['pre_mob'] = $request->pre_mob;

                              $userArr['role'] = $request->role;

                              $userArr['desgination'] = $request->designation;

                              $userArr['email'] = $request->emailaddress;

                              $userArr['alt_email'] = $request->alt_emailaddress;

                              $userArr['mobile_no'] = $request->mobile;

                              $userArr['alternate_no'] = $request->alternate;

                              $userArr['pancard_no'] = $request->pancard;

                              $userArr['adhaar_card'] = $request->adhaar;

                              $userArr['dob'] = $request->dob;

                              $userArr['gender'] = $request->gender;

                              

                              $userArr['country'] = $request->country;

                              $userArr['state'] = $request->state;

                              $userArr['city'] = $request->city;

                              $userArr['pincode'] = $request->pincode;

                              $userArr['landmark'] =$request->landmark;

                              $userArr['address'] = $request->address;

                              $userArr['created_by'] = session('userId');

                              $userArr['update_by'] = session('userId');

                              $userArr['created_at'] = date('Y-m-d H:i:s');

                              $userArr['updated_at'] = date('Y-m-d H:i:s');

                              $userArr['status'] = 1;



      $update = DB::table('grc_user')->where('id',$request->user_id)

                    ->update($userArr); 



                     return redirect()->back()->with('msg','Successfully Updated');

                             

    }



           $validator = Validator::make($request->all(), [

            

            'fname' => 'required|max:150',

            

            'lname' => 'required',

            

            'role' => 'required',

            

            'emailaddress' => 'unique:grc_user,email|required|email',

            'mobile' => 'required',

             'address' => 'required',

            'pancard' => 'required',

            'adhaar' => 'required',

            'dob' => 'required',

            'gender' => 'required',

            

            'country' => 'required',

            'state' => 'required',

            'city' => 'required',

            'pincode' => 'required|max:6',

            

            'address' => 'required',

            

        ],$this->customMsg());



        if ($validator->fails()) {

            return redirect('/Users-add')

                        ->withErrors($validator)

                        ->withInput();

        }





      $count = DB::table('grc_user')->select('*')->where('email',$request->emailaddress)->count();

     // dd($count);

            if($count == 0){

              $uniqueID = mt_rand(1000, 9999);

              $autogenerateId = 'EMP-'.$uniqueID;

              

              if($request->role == 'admin'){

                  $pass = 'Admin@'.$uniqueID;



                }else if($request->role == 'project_Manager'){

                  $pass = 'ProjectManager_'.$uniqueID;

                }else{

                  $pass = 'Employee_'.$uniqueID;

                }



                  if((session('role') == 'admin') || (session('role') == 'project_Manager')){

                    $org = session('org_id');

                    }else{



                      if( $request->role != 'admin'){



                       $org = $request->org_id??null;



                      }else{



                        $org = null;



                      }

                    }



            //   if ($request->file('profileimage')) {

            //         $destinationPath = public_path('uploads_profileimg');

            //         $extension = $request->file('profileimage')->getClientOriginalExtension();

            //         $fileName = uniqid().'.'.$extension;

            //         $request->file('profileimage')->move($destinationPath, $fileName);

            //     }else{

            //       $fileName = '0'; 

            //     }

                

                 if($request->hasFile('profileimage')) {

             $file = $request->file('profileimage');



             $original_name = strtolower(trim($file->getClientOriginalName()));



             $getFileExt   = $file->getClientOriginalExtension();

             $uploadedFile =   time().'.'.$getFileExt;

             

             $name = $uploadedFile;

             $path = public_path('/uploads_profileimg');

             

            $file->move($path, $name);

            $fileName = $name;

          // dd($fileName);

             }else{



              $fileName  = '';



             }





       

             

                   /* $destinationPath = public_path('uploads_profileimg');

              $extension = $request->file('image')->getClientOriginalExtension();

                    $fileName = uniqid().'.'.$extension;

                    $request->file('image')->move($destinationPath, $fileName);*/

               /* }else{

                   $newname = '0'; 

                }

                */



                DB::table('notification')

                ->insert([

                          'user_id' => session('userId'),

                          'org_id' => $org,

                          'msg' => 'User Created '.$request->fname,

                          'created_by' => session('userId'),

                         

                         ]);  

              

            $update = DB::table('grc_user')

                    ->insertGetId(['employee_id' => user_increment(),

                               'org_id' => $org??'',

                                'pro_id' => $request->pro_name,

                              'first_name' => $request->fname,

                              'middle_name' => $request->mname,

                              'last_name' => $request->lname,

                              'pre_alt_mob' => $request->pre_alt_mob,

                              'pre_mob' => $request->pre_mob,

                              'password' => md5($pass),

                              'role' => $request->role,

                              'desgination' => $request->designation,

                              'email' => $request->emailaddress,

                              'alt_email' => $request->alt_emailaddress,

                              'mobile_no' => $request->mobile,

                              'alternate_no' => $request->alternate,

                              'pancard_no' => $request->pancard,

                              'adhaar_card' => $request->adhaar,

                              'dob' => $request->dob,

                              'gender' => $request->gender,

                             'photo' => $fileName??'',

                              'country' => $request->country,

                              'state' => $request->state,

                              'city' => $request->city,

                              'pincode' => $request->pincode,

                              'landmark' =>$request->landmark,

                              'address' => $request->address,

                              'created_by' => session('userId'),

                              'update_by' => session('userId'),

                              'created_at' => date('Y-m-d H:i:s'),

                              'updated_at' => date('Y-m-d H:i:s'),

                              'status' => 1

                             ]); 

                             

                             if($request->role == 'admin'){

                                 DB::table('grc_organization')->where('id',$org)->update(['org_admin' =>$update ]);

                             }else if($request->role == 'project_Manager'){

                                    DB::table('grc_project')->where('id',$request->pro_name)->update(['project_manager' =>$update ]);

                             }

                            // dd($update);

            $msg = '<!DOCTYPE html>

<html>

<body style="background-color: #f6f6f6;">

<table

  style="padding-bottom:40px;margin-top:10px;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;"

  cellspacing="0" cellpadding="0" border="0" align="center">

  <tbody>

    <tr

      style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">

      <td class="container" width="600"

        style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"

        valign="top">

        <table style=" margin-top:30px;" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">

          <tbody>

            <tr>

              <table width="100%" border="0" cellpadding="0" style="border-collapse: collapse;border:1px solid #e9e9e9">

                <td style="

                        background: #fff;

                        padding: 5px;"><img

                    src="https://projectdemoonline.com/grcgreentest/public/assets/images/grc.png" width="60"></td>

                <td style="text-align: right;

                        background: #fff;

                        padding: 5px;"><img

                    src="https://projectdemoonline.com/grcgreentest/public/assets/images/green_erp_logo.png"

                    width="100"></td>

              </table>

      </td>

    </tr>

    <tr>

      <td width="600" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;">

        <table style=" margin-top:5px;" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">

          <tr>

            <td colspan="2" style=" background:#fff; vertical-align: bottom; margin:0; padding:0;">

              <div style="padding: 22px;  position:relative; float: left; width: 100%; box-sizing: border-box;">



                <div style="float:left; width:100%;margin-bottom: 20px;">

                  <div style=" margin:0px auto;   ">

                   <div

                      style="float: left; background: #3CC6ED none repeat scroll 0% 0%; padding: 55px 45px 35px; margin-bottom: 0px;">

                  <h3 style="color: rgb(0, 0, 0); font-family: Tahoma,sans-serif; font-size: 20px; line-height: 25px; margin-top: 0;">Welcome to GRC,</h3>

                 

                  

                   <p style="color: #fff; font-family: helvetica,sans-serif; font-size: 17px; line-height: 22px; margin: 0  0 25px; text-align: left;">We gives you access to all our features and tools available in our plan. So get started today ! .</p>

                 

                   <h3 style="color: #fff;  font-size: 18px; text-align: left; margin: 0 0 40px;">Your Registered email is: '.$request->emailaddress.'</h3>

                 

                    <h3 style="color: #fff;  font-size: 18px; text-align: left; margin: 0 0 40px;">Your Password is:'.$pass.'</h3>

                   <a style="background: #fff ; color: #3CC6ED; display: block;  font-weight: bold; font-size: 15px; margin: 0 auto; padding: 20px; text-align: center; text-decoration: none; width: 248px; text-transform: uppercase; " href="'.URL::to('/login').'">Login For GRC</a>

                  </div>

                 </div>

                 </div>

               </div>

              </td>

             </tr>

            </tbody></table>

           </td>

          </tr>

           </tbody></table>';

            $to = $request->emailaddress;

            $sub = "Registered Successfully";

            $from = "dsaini@kloudrac.com";

            $fromname = "NOT_To_REPLY";

            // $response = $this->sendMail($sub,$msg,$to,$from,$fromname);

            // $response = $this->sendMail($sub,$msg,session('email'),$from,$fromname);

              $sendEmailId = array(session('email'),$to);

            

               MultiSendEmail(array_unique($sendEmailId),$sub,$from,$fromname,$msg);

           

                  

                 

             // $request->session()->flash('org-success', 'Organization add Successfully.');

    

            // return view('superadmin.user_add');

            return redirect('Users-list')->with('msg','Added Successfully ');

            }else{

              return redirect()->back()->with('msg','Organization already exist!');

            }

          

        }else{

        return view('superadmin.user_add');

      }

    }



    public function userstatus($id){







      $projectcount = DB::table('grc_user')->where('id',$id)->count();

        $projectstatus = DB::table('grc_user')->where('id',$id)->first();



         $userdata = DB::table('grc_user')->where('org_id',$projectstatus->org_id)->where('role','admin')->first();

      if($projectcount==1){

      

   

        

       

        

       // print_r($projectstatus); die('sds');

        $status = $projectstatus->status;



        if($status == 1){

                  $update = DB::table('grc_user')->where('id',$id)

                    ->update([

                              'status' => 0

                             ]);

                             

                                       //   if(isset($userdata->email)){

          //   $response = $this->sendMail($sub,$msg,$userdata->email,$from,$fromname);  

          //   }

          //   if(isset($projectstatus->email)){

          //   $response = $this->sendMail($sub,$msg,$projectstatus->email,$from,$fromname);

          // }

          // if(!empty(session('email'))){

          //   $response = $this->sendMail($sub,$msg,session('email'),$from,$fromname);

          // }



      $user_list = DB::table('grc_user')->where('role','Employee')->get();



      return response()->json(['status' => 200, 'msg' => 'Updated successfully']);

     

    // return view('superadmin.user_list',compact('user_list'));

        }else{

         

             $update = DB::table('grc_user')->where('id',$id)

                    ->update([

                              'status' => 1

                             ]);

                             



                             



            

            

          //   if(isset($userdata->email)){

          //   $response = $this->sendMail($sub,$msg,$userdata->email??'',$from,$fromname);

          //   }

          

          

          //   if(isset($projectstatus->email)){

          //   $response = $this->sendMail($sub,$msg,$projectstatus->email,$from,$fromname);

          // }

          // if(!empty(session('email'))){

          //   $response = $this->sendMail($sub,$msg,session('email'),$from,$fromname);

          // }





       $user_list = DB::table('grc_user')->where('role','Employee')->get();

      return response()->json(['status' => 200, 'msg' => 'Updated successfully']);

        }

      }else{



   return response()->json(['status' => 200, 'msg' => 'This project doesn exist in database']);

      

      }

      $user_list = DB::table('grc_user')->where('role','Employee')->get();

       return response()->json(['status' => 200, 'msg' => 'This project doesn exist in database']);

    }



    function user_status_email($id){



       $projectstatus = DB::table('grc_user')->where('id',$id)->first();



         $userdata = DB::table('grc_user')->where('org_id',$projectstatus->org_id)->where('role','admin')->first();



         if($projectstatus->status == 1){



          $class = "Actived";



         }else{



          $class = "DeActived";



         }







                                                 $msg = '<!DOCTYPE html>

<html>

<body style="background-color: #f6f6f6;">

<table

  style="padding-bottom:40px;margin-top:10px;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;"

  cellspacing="0" cellpadding="0" border="0" align="center">

  <tbody>

    <tr

      style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">

      <td class="container" width="600"

        style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"

        valign="top">

        <table style=" margin-top:30px;" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">

          <tbody>

            <tr>

              <table width="100%" border="0" cellpadding="0" style="border-collapse: collapse;border:1px solid #e9e9e9">

                <td style="

                        background: #fff;

                        padding: 5px;"><img

                    src="https://projectdemoonline.com/grcgreentest/public/assets/images/grc.png" width="60"></td>

                <td style="text-align: right;

                        background: #fff;

                        padding: 5px;"><img

                    src="https://projectdemoonline.com/grcgreentest/public/assets/images/green_erp_logo.png"

                    width="100"></td>

              </table>

      </td>

    </tr>

    <tr>

      <td width="600" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;">

        <table style=" margin-top:5px;" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">

          <tr>

            <td colspan="2" style=" background:#fff; vertical-align: bottom; margin:0; padding:0;">

              <div style="padding: 22px;  position:relative; float: left; width: 100%; box-sizing: border-box;">



                <div style="float:left; width:100%;margin-bottom: 20px;">

                  <div style=" margin:0px auto;   ">

                   <div

                      style="float: left; background: #3CC6ED none repeat scroll 0% 0%; padding: 55px 45px 35px; margin-bottom: 0px;">

                  <h3 style="color: rgb(0, 0, 0); font-family: Tahoma,sans-serif; font-size: 20px; line-height: 25px; margin-top: 0;">Welcome to GRC,</h3>

                 

                  

                   <p style="color: #fff; font-family: helvetica,sans-serif; font-size: 17px; line-height: 22px; margin: 0  0 25px; text-align: left;">We gives you access to all our features and tools available in our plan. So get started today ! .</p>

                 

                   <h3 style="color: #fff;  font-size: 18px; text-align: left; margin: 0 0 40px;"> Uses is '.$class.': '.$projectstatus->user_name.'</h3>

                 

                    

                 

                  </div>

                 </div>

                 </div>

               </div>

              </td>

             </tr>

            </tbody></table>

           </td>

          </tr>

           </tbody></table>';

           

            $sub = "USERS Activation";

            $from = "dsaini@kloudrac.com";

            $fromname = "Not_To_Reply";



     $sendEmailId = array($userdata->email,$projectstatus->email,session('email'));

            

        MultiSendEmail(array_unique($sendEmailId),$sub,$from,$fromname,$msg);



         return response()->json(['status' => 200, 'msg' => 'Send successfully']);



    }





 public function userview($id){



      $userData = DB::table('grc_user')->select('grc_user.*','grc_user.pincode as upincode','grc_user.landmark as ulandmark','grc_project.project_name','alm_countries.name as county','alm_countries.phonecode','alm_states.name as state','alm_cities.name as city')

                ->leftjoin('grc_project','grc_user.id','=','grc_project.project_manager')->leftjoin('grc_task','grc_task.project_id','=','grc_project.id')->leftjoin('alm_countries','grc_user.country','=','alm_countries.id')->leftjoin('alm_states','grc_user.state','=','alm_states.id')->leftjoin('alm_cities','grc_user.city','=','alm_cities.id')->where('grc_user.id',$id)->first();



                

               // dd($userData);

      return view('superadmin.user_view',compact('userData','id'));

    }



    public function tasklist(Request $request){



 



   //   if(!empty(session('org_id'))){

          

               if(session('role')=='project_Manager'){

       // $pro_list = DB::table('grc_project')->get();

          

        $task_list = DB::table('grc_task')->select('*','grc_task.id as id','grc_user.first_name','grc_user.middle_name','grc_user.last_name','grc_organization.org_name','grc_project.project_name')

                    ->join('grc_sector','grc_task.sector','=','grc_sector.id')

                   ->join('grc_project','grc_task.project_id','=','grc_project.id')

                   ->join('grc_user','grc_task.user_id','=','grc_user.id')

                   ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')

                   ->join('alm_states','grc_task.state_id','=','alm_states.id')

                   ->where('grc_project.project_manager',session('userId'))->orderBy('grc_task.id','desc')

                   ->get();



       



      }elseif(session('role')=='admin'){

        //dd(session('org_id'));

        $task_list = DB::table('grc_task')

        ->join('grc_sector','grc_task.sector','=','grc_sector.id')

        ->join('grc_user','grc_task.user_id','=','grc_user.id')

        ->join('grc_project','grc_task.project_id','=','grc_project.id')

         ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')

        ->join('alm_states','grc_task.state_id','=','alm_states.id')

        ->where('grc_task.org_id',session('org_id'))

        ->orderBy('grc_task.id','desc')

      ->select('grc_task.*','grc_user.first_name','grc_user.middle_name','grc_user.last_name','grc_organization.org_name','grc_project.project_name')->get();

     

      }elseif(session('role')=='employee'){



        $task_list = DB::table('grc_task')



          ->join('grc_sector','grc_task.sector','=','grc_sector.id')

        ->join('grc_user','grc_task.user_id','=','grc_user.id')

        ->join('grc_project','grc_task.project_id','=','grc_project.id')

        ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')

        ->join('alm_states','grc_task.state_id','=','alm_states.id')



           

        ->where('grc_task.user_id',session('userId'))->where('grc_organization.id',session('org_id'))->orderBy('grc_task.id','desc')

        ->select('grc_task.*','grc_user.first_name','grc_user.middle_name','grc_user.last_name','grc_organization.org_name','grc_project.project_name')->get();

      }else{

        $task_list = DB::table('grc_task')

        ->join('grc_sector','grc_task.sector','=','grc_sector.id')

        ->join('grc_user','grc_task.user_id','=','grc_user.id')

        ->join('grc_project','grc_task.project_id','=','grc_project.id')

        ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')

        ->join('alm_states','grc_task.state_id','=','alm_states.id')

        ->orderBy('grc_task.id','desc')->select('grc_task.*','grc_user.first_name','grc_user.middle_name','grc_user.last_name','grc_organization.org_name','grc_project.project_name','alm_states.name as state_name','grc_sector.sector_name')->get();

    

      }



      if($request->isMethod('post'))

       {

  

     $task_list = [];

 

   $task_list = DB::table('grc_task')->select('*','grc_task.id as id','grc_user.first_name','grc_user.middle_name','grc_user.last_name','grc_organization.org_name','grc_project.project_name')

                   ->leftjoin('grc_project','grc_task.project_id','=','grc_project.id')

                   ->leftjoin('grc_user','grc_task.user_id','=','grc_user.id')

                   ->leftjoin('grc_organization','grc_task.org_id','=','grc_organization.id');



                    if(session('role') =='project_Manager'){

                   $task_list->where('grc_project.project_manager',session('userId'));

                 }else if(session('role')=='admin'){

                  $task_list->where('grc_task.org_id',session('org_id'));

                }else if(session('role')=='employee'){

                  $task_list->where('grc_task.org_id',session('org_id'));

                }



                   if(!empty($request->tast_id)){

                    

                    $task_list->where('grc_task.task_id', 'like', '%' . $request->tast_id . '%');



                   }



                       if(!empty($request->tast_name)){

                    

                    $task_list->where('grc_task.task_name', 'like', '%' . $request->tast_name . '%');



                   }



                  if(!empty($request->project_name)){

                    

                 $task_list->where('grc_project.project_name', 'like', '%' . $request->project_name . '%');

                   

                   }



                   if(!empty($request->emp_name)){

                  

                     $task_list->where('grc_user.first_name', 'like', '%' . $request->emp_name . '%');



                   }



                    if(!empty($request->category)){

                  

                     $task_list->where('grc_task.category', 'like', '%' . $request->category . '%');



                   }



                     if(!empty($request->type)){

                  

                     $task_list->where('grc_task.type', 'like', '%' . $request->type . '%');



                   }

                     if(!empty($request->last_date)){

                  

                     $task_list->where('grc_task.end_date', 'like', '%' . $request->last_date . '%');



                   }



                   if(!empty($request->status)){

                  

                     $task_list->where('grc_task.task_status', 'like', '%' . $request->status . '%');



                   }

     

                   $task_list = $task_list->get();

                    //dd($task_list);

               



                  return view('superadmin.task_list',compact('task_list'));

       } 



        if(!empty($request->export)){

          

           

               if(session('role')=='project_Manager'){

       // $pro_list = DB::table('grc_project')->get();

          

        $task_list = DB::table('grc_task')->select('*','grc_task.id as id','grc_user.first_name','grc_user.middle_name','grc_user.last_name','grc_organization.org_name','grc_project.project_name')

                    ->join('grc_sector','grc_task.sector','=','grc_sector.id')

                   ->join('grc_project','grc_task.project_id','=','grc_project.id')

                   ->join('grc_user','grc_task.user_id','=','grc_user.id')

                   ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')

                   ->join('alm_states','grc_task.state_id','=','alm_states.id')

                   ->where('grc_project.project_manager',session('userId'))->orderBy('grc_task.id','desc')

                   ->get();



       



      }elseif(session('role')=='admin'){

        //dd(session('org_id'));

        $task_list = DB::table('grc_task')

        ->join('grc_sector','grc_task.sector','=','grc_sector.id')

        ->join('grc_user','grc_task.user_id','=','grc_user.id')

        ->join('grc_project','grc_task.project_id','=','grc_project.id')

         ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')

        ->join('alm_states','grc_task.state_id','=','alm_states.id')

        ->where('grc_task.org_id',session('org_id'))

        ->orderBy('grc_task.id','desc')

      ->select('grc_task.*','grc_user.first_name','grc_user.middle_name','grc_user.last_name','grc_organization.org_name','grc_project.project_name')->get();

     

      }elseif(session('role')=='employee'){



        $task_list = DB::table('grc_task')



          ->join('grc_sector','grc_task.sector','=','grc_sector.id')

        ->join('grc_user','grc_task.user_id','=','grc_user.id')

        ->join('grc_project','grc_task.project_id','=','grc_project.id')

        ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')

        ->join('alm_states','grc_task.state_id','=','alm_states.id')



           

        ->where('grc_task.user_id',session('userId'))->where('grc_organization.id',session('org_id'))->orderBy('grc_task.id','desc')

        ->select('grc_task.*','grc_user.first_name','grc_user.middle_name','grc_user.last_name','grc_organization.org_name','grc_project.project_name')->get();

      }else{

        $task_list = DB::table('grc_task')

        ->join('grc_sector','grc_task.sector','=','grc_sector.id')

        ->join('grc_user','grc_task.user_id','=','grc_user.id')

        ->join('grc_project','grc_task.project_id','=','grc_project.id')

        ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')

        ->join('alm_states','grc_task.state_id','=','alm_states.id')

        ->orderBy('grc_task.id','desc')->select('grc_task.*','grc_user.first_name','grc_user.middle_name','grc_user.last_name','grc_organization.org_name','grc_project.project_name','alm_states.name as state_name','grc_sector.sector_name')->get();

    

      }

          

          

          

          // $user_data  =  $user_list->get();

           

        

          

            $columns = array('S.No', 'Task ID', 'Task Name', 'Project Name', 'Employee','Category','Type','Date');



    

    $filename = public_path("uploads/csv/Task_'".time()."'_report.csv");

    $handle = fopen($filename, 'w+');

    fputcsv($handle, $columns);



         $i = 1;

        foreach($task_list as $user_datas) {



           fputcsv($handle, array($i++, 'TSK-'.$user_datas->task_id,ucwords($user_datas->task_name),ucwords($user_datas->project_name),$user_datas->first_name.' '.$user_datas->last_name,$user_datas->category,$user_datas->type,$user_datas->end_date));

        }

        

       fclose($handle);



       $headers = array(

        'Content-Type' => 'text/csv'

       

        );





    return Response()->download($filename);



      }

      

     

    

       return view('superadmin.task_list',compact('task_list'));

          

    //   }else{

          

    //       return view('superadmin.task_list',['task_list' => '']);

          

    //   }



 



     

    }



    public function taskadd(Request $request){

      if($request->isMethod('post'))

       {

  

         $validator = Validator::make($request->all(), [

            'projectId' => 'required',

            'taskname' => 'required',

            'projectstate' => 'required',

            'category' => 'required',

            'sector' => 'required',

            'conditionno' => 'required',

            'user_name' => 'required',

            'tasktype' => 'required',

            'taskstatus' => 'required',

            'startdate' => 'required',

            'endDate' => 'required',

            'taskDescription' => 'required',

            'estimatedhours' => 'required',

            

            

        ],$this->customMsg());



        if ($validator->fails()) {

            return redirect('/Task-add')

                        ->withErrors($validator)

                        ->withInput();

        }

        

       // dd($request->all());

         

      $count = DB::table('grc_task')->select('*')->where('task_name',$request->taskname)->count();

           if($count == 0){



              $uniqueID = mt_rand(1000, 9999);

              $autogenerateId = 'TSK-'.$uniqueID;

              

             $getorg = DB::table('grc_project')->where('id',$request->projectId)->first();

              

             $org_id = $getorg->organization_id??'';





              DB::table('notification')

              ->insert([

                        'user_id' => session('userId'),

                        'org_id' => $org_id,

                        'msg' => 'Created Task '.$request->taskname,

                        'created_by' => session('userId'),

                       

                       ]);  







            $date1 = new DateTime($request->startdate);

          $date2 = new DateTime($request->endDate);



         $diff = $date2->diff($date1);



         $hours = $diff->h;

        $hours = $hours + ($diff->days*24);

                

                

            $condition =     ['category_section' => $request->category,

                              'project_id' => $request->projectId,

                              'condition_number' => $request->conditionno,

                              'doc_type' => $request->tasktype,

                              'user_id' => $request->user_name,

                              'state_id' => $request->projectstate,

                              'sector_name' => $request->sector,

                              'document_statement' => $request->taskname,

                              'created_by' => session('userId'),

                              'modified_by' =>session('userId'),

                              'created_date' =>date('Y-m-d H:i:s'),

                              'modified_date' =>date('Y-m-d H:i:s'),

                              'status' => 1

                             ];

                

                   $con_id = DB::table('grc_project_condition_doc')

                    ->insertGetId($condition);

                             

                             

                             $assign = [//'category_section' => $request->category,

                              'doc_id' => $con_id,

                              'condition_number' => $request->conditionno,

                              'doc_type' => $request->tasktype,

                              'project_id' =>$request->projectId,

                              'category_section' => $request->category,

                              'user_id' => $request->user_name,

                              'state_id' => $request->projectstate,

                              'sector_name' => $request->sector,

                              'document_statement' => $request->taskname,

                              'created_by' => session('userId'),

                              'modified_by' =>session('userId'),

                              'created_date' =>date('Y-m-d H:i:s'),

                              'modified_date' =>date('Y-m-d H:i:s'),

                              'status' => 1,

                              'last_date_task' => $request->endDate,

                              'condtion_status' => 2,

                             ];

                        



                        $assin = DB::table('grc_project_condition_doc_assign')->insert($assign);

                       

                    

                             

           















            $taskadd = DB::table('grc_task')

                    ->insertGetId(['project_id' => $request->projectId,

                              'org_id' => $org_id,

                              'task_id'=> task_increment(),

                              'task_name' => $request->taskname,

                              'condition_no' => $request->conditionno,

                              'category' => $request->category,

                              'type' => $request->tasktype,

                              'sector' => $request->sector,

                              'user_id' =>$request->user_name,

                              'state_id' => $request->projectstate,

                              'description' => $request->taskDescription,

                              'estimated_hrs' => $request->estimatedhours,

                              'start_date' => $request->startdate,

                              'end_date' => $request->endDate,

                              'task_status' => $request->taskstatus,

                              'created_by' => session('userId'),

                              'modified_by' => session('userId'),

                              'created_date' => date('Y-m-d H:i:s'),

                              'modified_date' => date('Y-m-d H:i:s'),

                              'status' => 1

                             ]);



                    // $taskid = DB::getPdo()->lastInsertId();

                     $update = DB::table('grc_relation')

                    ->insert(['project_id' => $request->projectId,

                              'org_id' => session('org_id'),

                              'user_id' => $request->user_name,

                              'task_id' => $taskadd,

                              'created_date' => date('Y-m-d H:i:s'),

                              'modified_date' => date('Y-m-d H:i:s'),

                              'status' => 1

                             ]); 



                     $update = DB::table('grc_user')->where('id',$request->user_name)

                    ->update([

                              'org_id' => $org_id,

                            

                              'updated_at' => date('Y-m-d H:i:s'),

                             

                              'status' => 1

                             ]); 



      //$proname = DB::table('grc_project')->get();

      // $statelist = DB::table('alm_states')->select('*','alm_states.id as stateid')->join('grc_superadmin_country_list','alm_states.country_id','=','grc_superadmin_country_list.country_id')->get();

      // $stagesname = DB::table('grc_stages')->get();

      // $typename = DB::table('grc_type')->get();

      // $sectorname = DB::table('grc_sector')->get();

      // $statusname = DB::table('grc_status')->get();

      // $username = DB::table('grc_user')->where('role','Employee')->get();

      

      

      

      $getuserEmp = DB::table('grc_user')->where('org_id',$org_id)->where('id',$request->user_name)->where('role','employee')->first();

      

         if(isset($getuserEmp->email)){

             

              $EMPemail = $getuserEmp->email;

             

             

              $msg = '<!DOCTYPE html>

<html>

<body style="background-color: #f6f6f6;">

<table

  style="padding-bottom:40px;margin-top:10px;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;"

  cellspacing="0" cellpadding="0" border="0" align="center">

  <tbody>

    <tr

      style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">

      <td class="container" width="600"

        style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"

        valign="top">

        <table style=" margin-top:30px;" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">

          <tbody>

            <tr>

              <table width="100%" border="0" cellpadding="0" style="border-collapse: collapse;border:1px solid #e9e9e9">

                <td style="

                        background: #fff;

                        padding: 5px;"><img

                    src="https://projectdemoonline.com/grcgreentest/public/assets/images/grc.png" width="60"></td>

                <td style="text-align: right;

                        background: #fff;

                        padding: 5px;"><img

                    src="https://projectdemoonline.com/grcgreentest/public/assets/images/green_erp_logo.png"

                    width="100"></td>

              </table>

      </td>

    </tr>

    <tr>

      <td width="600" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;">

        <table style=" margin-top:5px;" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">

          <tr>

            <td colspan="2" style=" background:#fff; vertical-align: bottom; margin:0; padding:0;">

              <div style="padding: 22px;  position:relative; float: left; width: 100%; box-sizing: border-box;">



                <div style="float:left; width:100%;margin-bottom: 20px;">

                  <div style=" margin:0px auto;   ">

                   <div

                      style="float: left; background: #3CC6ED none repeat scroll 0% 0%; padding: 55px 45px 35px; margin-bottom: 0px;">

                  <h3 style="color: rgb(0, 0, 0); font-family: Tahoma,sans-serif; font-size: 20px; line-height: 25px; margin-top: 0;">Welcome to GRC,</h3>

                 

                  

                   <p style="color: #fff; font-family: helvetica,sans-serif; font-size: 17px; line-height: 22px; margin: 0  0 25px; text-align: left;">We gives you access to all our features and tools available in our plan. So get started today ! .</p>

                 

                   <h3 style="color: #fff;  font-size: 18px; text-align: left; margin: 0 0 40px;">Your Registered email is: '.$EMPemail.'</h3>

                 

                  <h3 style="color: #fff;  font-size: 18px; text-align: left; margin: 0 0 40px;">Project is: '.$getorg->project_name.'</h3>

                    <h3 style="color: #fff;  font-size: 18px; text-align: left; margin: 0 0 40px;">Project is: '.$request->taskname.'</h3>

                 

                  

                     </div>

                 </div>

                 </div>

               </div>

              </td>

             </tr>

            </tbody></table>

           </td>

          </tr>

           </tbody></table>';

            

            $sub = "Task Assign";

            $from = "dsaini@kloudrac.com";

            $fromname = "Not_To_Reply";

            // $response = $this->sendMail($sub,$msg,$EMPemail,$from,$fromname);

            // $response = $this->sendMail($sub,$msg,session('email'),$from,$fromname);



              $sendEmailId = array(session('email'),$EMPemail);

            

        MultiSendEmail(array_unique($sendEmailId),$sub,$from,$fromname,$msg);

             

         }

        





       return redirect('Task-list/')->with('msg','Successfully Add Task');

     // return view('superadmin.task_add',compact('proname','statelist','stagesname','typename','statusname','username','sectorname'));

       }else{



      return redirect()->back()->with('task-war','Task already exist');

    }

    }else{

      $proname = DB::table('grc_project')->get();

      $statelist = DB::table('alm_states')->select('*','alm_states.id as stateid')->join('grc_superadmin_country_list','alm_states.country_id','=','grc_superadmin_country_list.country_id');

      

       if(session('role') != 'superadmin'){

                            $orgcontry = DB::table('grc_organization')->where('id',session('org_id'))->where('status',1)->first();

                            $statelist->where('alm_states.country_id', $orgcontry->country??0);   

                        }

      

      $statelist = $statelist->get();

      $stagesname = DB::table('grc_stages')->get();

      $typename = DB::table('grc_type')->get();

      $statusname = DB::table('grc_status')->get();

      $username = DB::table('grc_user')->where('status',1);

      if(session('role') != 'superadmin'){

          $username->where('created_by',session('userId'));

      }

      

      $username = $username->where('role','Employee')->get();

      $sectorname = DB::table('grc_sector')->get();

      return view('superadmin.task_add',compact('proname','statelist','stagesname','typename','statusname','username','sectorname'));

    }

  }

    public function taskdetail(Request $request,$id){

      $taskdoc = array();

      $task_remarklist = DB::table('grc_task_remarks')->select('*','grc_task_remarks.created_date as cdate')

                 ->Join('grc_project_task_document','grc_task_remarks.id','=','grc_project_task_document.task_remark_id')

                ->where('grc_task_remarks.task_id',$id)->orderby('grc_task_remarks.created_date','DESC')->get();

      foreach ($task_remarklist as $value) {

         $tdoc['document'] = isset($value->document)?$value->document:'';

         $tdoc['task_remark'] = isset($value->task_remark)?$value->task_remark:'';

          $tdoc['hints'] = isset($value->hints)?$value->hints:'';

         $tdoc['task_status'] = isset($value->task_status)?$value->task_status:'';

         $tdoc['figure_at_site'] = isset($value->figure_at_site)?$value->figure_at_site:'';

         $tdoc['actual_at_site'] = isset($value->actual_at_site)?$value->actual_at_site:'';

         $tdoc['Probability'] = isset($value->Probability)?$value->Probability:'';

         $tdoc['cdate'] = isset($value->created_date)?$value->created_date:'';

         $taskdoc[] = $tdoc;

      }

        

    

        $task_list = DB::table('grc_task')->where('id',$id)->first();

        $projectshow = DB::table('grc_project')->leftjoin('grc_task','grc_project.id','=','grc_task.project_id')->where('grc_task.id',$id)->select('grc_project.project_name')->first();

        

     

        $taskData = array();

        $tk['task_name'] = isset($task_list->task_name)?$task_list->task_name:'';

          $tk['condition_no'] = isset($task_list->condition_no)?$task_list->condition_no:'';

        $tk['estimated_hrs'] = isset($task_list->estimated_hrs)?$task_list->estimated_hrs:'';

        $tk['end_date'] = isset($task_list->end_date)?$task_list->end_date:'';

        $tk['task_status'] = isset($task_list->task_status)?$task_list->task_status:'';

        $tk['Probability'] = isset($task_list->Probability)?$task_list->Probability:'';

        $tk['user_id'] = isset($task_list->user_id)?$task_list->user_id:'';



        $tk['actual'] = isset($task_list->actual)?$task_list->actual:'';

        $tk['figure'] = isset($task_list->figure)?$task_list->figure:'';

        $tk['hints'] = isset($task_list->hints)?$task_list->hints:'';





        $taskData[] = $tk;

        

        $hints = DB::table('task_hints')->where('task_id',$id)->get();

         $files = DB::table('task_files')->where('task_id',$id)->get();

        

        

       // echo "<pre>"; print_r($taskData); die('sdfd');

      return view('superadmin.task_detail',compact('taskData','id','taskdoc','projectshow','hints','files'));

   

  }

  

  function get_hint_id(Request $request){

      

     $get_hint = DB::table('task_hints')->where('id',$request->hint_id)->first();

     

     return response()->json(['status' => 200, 'hint' => $get_hint->hints]);

      

  }

  function delete_task_file($id){

      DB::table('task_files')->where('id',$id)->delete();

      

      return redirect()->back()->with('alert-success','Successfully Deleted');

  }

    function delete_hint($id){

      DB::table('task_hints')->where('id',$id)->delete();

      

      return redirect()->back()->with('alert-success','Successfully Deleted');

  }



 function update_task_data(Request $request){





if($request->num_text == 1){

  DB::table('grc_task')->where('id',$request->id)->update(['figure' => $request->data_text]);

  return response()->json(['status' => 200, 'msg' => 'Figure Updated Successfully']);



}else if($request->num_text == 2){



   DB::table('grc_task')->where('id',$request->id)->update(['actual' => $request->data_text]);

   return response()->json(['status' => 200, 'msg' => 'Actual Updated Successfully']);



}else if($request->num_text == 3){



   DB::table('grc_task')->where('id',$request->id)->update(['hints' => $request->data_text]);



   return response()->json(['status' => 200, 'msg' => 'Hints Updated Successfully']);

}

   



 }









    public function task_editdetail(Request $request,$id){

       if($request->isMethod('post'))

       { 



       /* $validator = Validator::make($request->all(), [

            'task_remark' => 'required',

            'figure_at_site' => 'required',

            'actual_at_site' => 'required',

            'task_status' => 'required',

            'Probability' => 'required',

            

        ]);



        if ($validator->fails()) {

            return redirect('/Task-detail/'.$id)->with('taskData')

                        ->withErrors($validator)

                        ->withInput();

        }*/

           $count11 = DB::table('grc_task')->where('id',$id)->count();

          //  print_r($count11); die('vsdxds');

            if($count11 == 1){        

         

                $taskadds = DB::table('grc_task')->where('id',$id)

                    ->update(['task_status' => $request->taskstatus,

                              'Probability' => $request->pro,

                              'modified_date' => date('Y-m-d H:i:s')

                            ]); 

             }

        $count = DB::table('grc_task_remarks')->where('task_id',$id)->where('task_status',$request->taskstatus)->where('Probability',$request->pro)->count();

        if($count == 0){

        $taskadd = DB::table('grc_task_remarks')

                    ->insert(['task_id' => $id,

                              'task_remark' => $request->taskRemarks,

                              'hints' => $request->hints,

                              'user_id' => session('userId'),

                              'figure_at_site' => $request->figuresite,

                              'actual_at_site' => $request->actualsite,

                              'task_status' => $request->taskstatus,

                              'Probability' => $request->pro,

                              'created_date' => date('Y-m-d H:i:s')

                             ]);



                   

               $lastid = DB::getPdo()->lastInsertId();

               

                   $uniqueID = mt_rand(1000, 9999);

                   $images = [];

                    if ($request->file('task_upload')) {

                    $files = $request->file('task_upload');

                      foreach($files as $file){

                    $originalfile = $file->getClientOriginalName();

                    $destinationPath = public_path('uploads_remarkdoc');

                    $extension = $file->getClientOriginalExtension();

                    $fileName = $uniqueID.'.'.$extension;

                    $file->move($destinationPath, $fileName);

                    $images[]=$fileName;

                     $IMG = implode("|",$images);

                      }

                }else{

                   $images = ''; 

                   $IMG = '';

                }

                

                

            $tastint = array(

                

                

                'task_id' => $id,

                              'task_remark_id' => $lastid,

                              'user_id' => session('userId'),

                              'document' =>$IMG,

                              'created_date' => date('Y-m-d H:i:s'),

                              'modified_date' => date('Y-m-d H:i:s')

                             

                );

                

           $taskadd = DB::table('grc_project_task_document')

                    ->insert($tastint); 

            

        $task_list = DB::table('grc_task')->where('id',$id)->first();

      

        $taskData = array();

        $tk['task_name'] = isset($task_list->task_name)?$task_list->task_name:'';

          $tk['condition_no'] = isset($task_list->condition_no)?$task_list->condition_no:'';

        $tk['estimated_hrs'] = isset($task_list->estimated_hrs)?$task_list->estimated_hrs:'';

        $tk['task_status'] = isset($task_list->task_status)?$task_list->task_status:'';

        $tk['Probability'] = isset($task_list->Probability)?$task_list->Probability:'';

        $tk['user_id'] = isset($task_list->user_id)?$task_list->user_id:'';



        $taskData[] = $tk;

        

        

        if($request->taskstatus == 'Completed'){

             $sendEmailId = array();

            $getuser = DB::table('grc_user')->where('org_id',$task_list->org_id)->get();

            foreach ($getuser as $key => $user) {

              $sendEmailId[] = $user->id;

            }

             $msg = '<!DOCTYPE html>

<html>

<body style="background-color: #f6f6f6;">

<table

  style="padding-bottom:40px;margin-top:10px;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;"

  cellspacing="0" cellpadding="0" border="0" align="center">

  <tbody>

    <tr

      style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">

      <td class="container" width="600"

        style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"

        valign="top">

        <table style=" margin-top:30px;" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">

          <tbody>

            <tr>

              <table width="100%" border="0" cellpadding="0" style="border-collapse: collapse;border:1px solid #e9e9e9">

                <td style="

                        background: #fff;

                        padding: 5px;"><img

                    src="https://projectdemoonline.com/grcgreentest/public/assets/images/grc.png" width="60"></td>

                <td style="text-align: right;

                        background: #fff;

                        padding: 5px;"><img

                    src="https://projectdemoonline.com/grcgreentest/public/assets/images/green_erp_logo.png"

                    width="100"></td>

              </table>

      </td>

    </tr>

    <tr>

      <td width="600" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;">

        <table style=" margin-top:5px;" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">

          <tr>

            <td colspan="2" style=" background:#fff; vertical-align: bottom; margin:0; padding:0;">

              <div style="padding: 22px;  position:relative; float: left; width: 100%; box-sizing: border-box;">



                <div style="float:left; width:100%;margin-bottom: 20px;">

                  <div style=" margin:0px auto;   ">

                   <div

                      style="float: left; background: #3CC6ED none repeat scroll 0% 0%; padding: 55px 45px 35px; margin-bottom: 0px;">

                  <h3 style="color: rgb(0, 0, 0); font-family: Tahoma,sans-serif; font-size: 20px; line-height: 25px; margin-top: 0;">Welcome to GRC,</h3>

                 

                  

                   <p style="color: #fff; font-family: helvetica,sans-serif; font-size: 17px; line-height: 22px; margin: 0  0 25px; text-align: left;">We gives you access to all our features and tools available in our plan. So get started today ! .</p>

                 

                   <h3 style="color: #fff;  font-size: 18px; text-align: left; margin: 0 0 40px;">Your Registered email is: '.$task_list->task_name.'</h3>

                 

                   

                   <a style="background: #fff ; color: #3CC6ED; display: block;  font-weight: bold; font-size: 15px; margin: 0 auto; padding: 20px; text-align: center; text-decoration: none; width: 248px; text-transform: uppercase; " href="#">Login For GRC</a>

                  </div>

                 </div>

                 </div>

               </div>

              </td>

             </tr>

            </tbody></table>

           </td>

          </tr>

           </tbody></table>';

           // $to = $request->emailaddress;

            $sub = "Task" .$task_list->task_name. 'Completed';

            $from = "dsaini@kloudrac.com";

            $fromname = "NOT_To_REPLY";

            // $response = $this->sendMail($sub,$msg,$getuser->email,$from,$fromname);

            // $response = $this->sendMail($sub,$msg,session('email'),$from,$fromname);



      

            

        MultiSendEmail(array_unique($sendEmailId),$sub,$from,$fromname,$msg);







            

        }

        



         return redirect('/Task-detail/'.$id)->with('taskData','id');

                   }else{

                    return redirect()->back()->with('warn-edit-task-detail','Please Increase Probability and Status');

                   }

     }else{

       $task_list = DB::table('grc_task')->where('id',$id)->first();

       $projectshow = DB::table('grc_project')->leftjoin('grc_task','grc_project.id','=','grc_task.project_id')->where('grc_task.id',$id)->select('grc_project.project_name')->first();

      //  dd($projectshow);

        $taskData = array();

        $tk['task_name'] = isset($task_list->task_name)?$task_list->task_name:'';

        $tk['condition_no'] = isset($task_list->condition_no)?$task_list->condition_no:'';

        $tk['estimated_hrs'] = isset($task_list->estimated_hrs)?$task_list->estimated_hrs:'';

        $tk['end_date'] = isset($task_list->end_date)?$task_list->end_date:'';

        $tk['task_status'] = isset($task_list->task_status)?$task_list->task_status:'';

        $tk['Probability'] = isset($task_list->Probability)?$task_list->Probability:'';

        $tk['user_id'] = isset($task_list->user_id)?$task_list->user_id:'';



        $taskData[] = $tk;

      return view('superadmin.task_edit_detail',compact('taskData','id','projectshow'));

    }

    }

 public function task_documentdownload(Request $request,$filename){



        // Check if file exists in app/storage/file folder

        $pathToFile = public_path().'/uploads_remarkdoc/'.$filename;  

      

       if ( file_exists( $pathToFile ) ) {

            // Send Download

          return Response::download($pathToFile);

            //redirect('/joblist');

       } else {

            // Error

            exit( 'Requested file does not exist on our server!' );

        }

     }

    public function document(Request $request){

      if($request->isMethod('post'))

       {





         $stateid = $request->stateid;

         $sectorid = $request->sectorid;



         $data = array();

            

               

      $data['docData1'] = DB::table('grc_document')->join('grc_sector','grc_document.sector','=','grc_sector.id')->where('grc_document.state',$stateid)->where('grc_document.sector',$sectorid)->where('grc_document.type','EC')->select('grc_document.*','grc_sector.sector_name')->get();

      $data['docData2'] = DB::table('grc_document')->join('grc_sector','grc_document.sector','=','grc_sector.id')->where('grc_document.state',$stateid)->where('grc_document.sector',$sectorid)->where('grc_document.type','CTO')->select('grc_document.*','grc_sector.sector_name')->get();

      $data['docData3'] = DB::table('grc_document')->join('grc_sector','grc_document.sector','=','grc_sector.id')->where('grc_document.state',$stateid)->where('grc_document.sector',$sectorid)->where('grc_document.type','CTE')->select('grc_document.*','grc_sector.sector_name')->get();

      $data['docData4'] = DB::table('grc_document')->join('grc_sector','grc_document.sector','=','grc_sector.id')->where('grc_document.state',$stateid)->where('grc_document.sector',$sectorid)->where('grc_document.type','GB')->select('grc_document.*','grc_sector.sector_name')->get(); 

      //print_r($docData1); die('ghfbg'); 

    //  return view('superadmin.document',compact('docData1','docData2','docData3','docData4'));

       

    //dd($data['docData1']);



       return (['data'=>$data]);



       }else{



        $docData1 = DB::table('grc_document')->where('type','EC')->get();

      $docData2 = DB::table('grc_document')->where('type','CTO')->get();

      $docData3 = DB::table('grc_document')->where('type','CTE')->get();

      $docData4 = DB::table('grc_document')->where('type','GB')->get(); 

      return view('superadmin.document',compact('docData1','docData2','docData3','docData4'));



       }

    }

   public function profileadd(){

      $userprofile = DB::table('grc_user')->select('*','alm_countries.name as cname','alm_states.name as sname','alm_cities.name as ctname')

                                   ->leftjoin('alm_countries','grc_user.country','=','alm_countries.id')

                                   ->leftjoin('alm_states','grc_user.state','=','alm_states.id')

                                   ->leftjoin('alm_cities','grc_user.city','=','alm_cities.id')

                                   ->where('grc_user.id',session('userId'))->where('grc_user.status', 1)->first(); 



   

      return view('superadmin.profile_add',compact('userprofile'));

    }

    public function profileedit(Request $request,$id){

    if($request->isMethod('post'))

       {



        $userupdate = DB::table('grc_user')->where('id',$id)->count();

        if($userupdate == 1){

            

             if ($request->file('profilepic')) {

                    $destinationPath = public_path('uploads_profileimg');

                    $extension = $request->file('profilepic')->getClientOriginalExtension();

                    $fileName = uniqid().'.'.$extension;

                    $request->file('profilepic')->move($destinationPath, $fileName);

                      $taskadd = DB::table('grc_user')->where('id',$id)

                    ->update(['state' => $request->state,

                              'first_name' => $request->fname,

                              'last_name' => $request->lname,

                              'mobile_no' =>$request->phonenumber,

                              'dob' => $request->dob,

                              'landmark' => $request->landmark,

                              'gender' => $request->gender,

                              'role' => $request->role,

                              'country' => $request->country,

                              'state' => $request->state,

                              'city' => $request->city,

                              'photo' =>$fileName,

                              'pincode'=> $request->pincode,

                              //'created_at' => date('Y-m-d H:i:s'),

                              'updated_at' => date('Y-m-d H:i:s')

                             ]); 

                }else{

                     $taskadd = DB::table('grc_user')->where('id',$id)

                    ->update(['state' => $request->state,

                              'first_name' => $request->fname,

                              'last_name' => $request->lname,

                              'mobile_no' =>$request->phonenumber,

                              'dob' => $request->dob,

                              'landmark' => $request->landmark,

                              'gender' => $request->gender,

                              'country' => $request->country,

                              'state' => $request->state,

                              'city' => $request->city,

                              

                              'pincode'=> $request->pincode,

                              //'created_at' => date('Y-m-d H:i:s'),

                              'updated_at' => date('Y-m-d H:i:s')

                             ]); 

                }

            

                DB::table('notification')

                ->insert([

                          'user_id' => session('userId'),

                          'org_id' => session('org'),

                          'msg' => 'Edit  User '.$request->fname,

                          'created_by' => session('userId'),

                         

                         ]); 

        

                   

                //   $userprofile = DB::table('grc_user')->select('*','alm_countries.name as cname','alm_states.name as sname','alm_cities.name as ctname')

                //                   ->leftjoin('alm_countries','grc_user.country','=','alm_countries.id')

                //                   ->leftjoin('alm_states','grc_user.state','=','alm_states.id')

                //                   ->leftjoin('alm_cities','grc_user.city','=','alm_cities.id')

                //                   ->where('grc_user.id',$id)->where('grc_user.status', 1)->first();



                //     $usercon = DB::table('alm_countries')->select('*')->get();



                //     $userstat = DB::table('alm_states')->select('*')->get();

                //     $usercit = DB::table('alm_cities')->select('*')->get();

         return redirect()->back()->with('msg','Update Successfully')->with('alert','primary');

        }else{

          return redirect()->back()->with('msg','User not exist');

        }

           

      }else{

        $userprofile = DB::table('grc_user')->select('grc_user.*','grc_user.pincode as upincode','grc_user.landmark as ulandmark','grc_project.project_name','alm_countries.name as county','alm_states.name as state_name','alm_cities.name as city_name')

                ->leftjoin('grc_project','grc_user.id','=','grc_project.project_manager')->leftjoin('alm_countries','grc_user.country','=','alm_countries.id')->leftjoin('alm_states','grc_user.state','=','alm_states.id')->leftjoin('alm_cities','grc_user.city','=','alm_cities.id')->where('grc_user.id',$id)->first();



                                  



                    $usercon = DB::table('alm_countries')->select('*')->get();



                    $userstat = DB::table('alm_states')->where('country_id',$userprofile->country)->select('*')->get();

                    $usercit = DB::table('alm_cities')->where('state_id',$userprofile->state)->select('*')->get();

         return view('superadmin.profile_edit',compact('userprofile','usercon','userstat','usercit','id'));

      }

     

    } 



function sendMail($sub,$msg,$to,$from,$fromname)

   {

       try {

           $mail = Mail::send([], [], function ($message) use ($sub,$msg,$to,$from,$fromname) {



               $message->from($from, $fromname);

               $message->to($to);

               $message->subject($sub);

               $message->setBody($msg, 'text/html'); // for HTML rich messages

           });



           if ($mail) {

               return true;

           } else {

               return false;

           }

       } catch (Exception $e) {

           throw new HttpException(500, $e->getMessage());

       }

   }

  public function changepass(Request $request){

     $userId = session('userId');

      if(empty($userId)){

         return redirect('/login');

      }

        $userId = Session('userId');

         $db_pass =  Session('password'); 

         if($request->isMethod('post')) {

            $opwd = $request->opwd;

            $npwd = $request->npwd;

            $cpwd = $request->cpwd;

            

            if ((md5($opwd) == $db_pass)) {



                if($opwd==$npwd)

                {

                   return back()->with('warning-pass','New Password and Old Password should not be same.');

                    return redirect('/change-password/'.$userId);

                }

                else if($npwd==$cpwd)

                {

                    $update = DB::table('grc_user')

                    ->where('id',$userId)

                    ->update(['password' => md5($npwd),

                    ]); 

                     $request->session()->flash('change_passwordd', 'Password changed Successfully.'); 

                     return redirect('/change-password/'.$userId);

                      

                }else{

                        return back()->with('warning-cp','New password and Confirm password do not match.');

                        return redirect('/change-password/'.$userId);

                    }

            }else{

                    return back()->with('warninggs','Current Password did not match.');

                    return redirect('/change-password/'.$userId);

            }

        }else{

            return view('superadmin.change_password');

        } 

    

     

    }

     public function email_verification(Request $request){

       if($request->isMethod('post')) {

           

          $validator = Validator::make($request->all(), [

            'email' => 'required|email',

            

           

        ],$this->customMsg());



        if ($validator->fails()) {

            return redirect()->back()

                        ->withErrors($validator)

                        ->withInput();

        } 

           

           

           

        $rand_token=  base64_encode(rand());

        $email = $request->input('email');



        $find_email = DB::table('grc_user')

            ->select('email')

            ->where('email','=', $email)

            ->count(); 

           



       if($find_email > 0)

        {

           $update_user = DB::table('grc_user')

               ->where('email',$email)

            ->update(['remember_token' => $rand_token]);



        $msg = '<table border="0" cellpadding="0" cellspacing="0" width="100%">

        <!-- LOGO -->

        <tr>

            <td bgcolor="#40b3f4" align="center">

                <table border="0" cellpadding="0" cellspacing="0" width="480" >

                    <tr>

                        <td align="center" valign="top" style="padding: 40px 10px 40px 10px;">

                            <a href="index.html" target="_blank">

                                <img alt="Logo" src="'.URL::to('assets/images/green_erp_logo.png').'" width="300" height="300" style="display: block;  font-family: Lato, Helvetica, Arial, sans-serif; color: #ffffff; font-size: 18px;" border="0">

                            </a>

                        </td>

                    </tr>

                </table>

            </td>

        </tr>

        <!-- HERO -->

        <tr>

            <td bgcolor="#40b3f4" align="center" style="padding: 0px 10px 0px 10px;">

                <table border="0" cellpadding="0" cellspacing="0" width="480" >

                    <tr>

                        <td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: Lato, Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;">

                            <h1 style="font-size: 32px; font-weight: 400; margin: 0;">Trouble signing in?</h1>

                        </td>

                    </tr>

                </table>

            </td>

        </tr>

        <!-- COPY BLOCK -->

        <tr>

            <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">

                <table border="0" cellpadding="0" cellspacing="0" width="480" >

                    <!-- COPY -->

                    <tr>

                        <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: Lato, Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;" >

                            <p style="margin: 0;">Resetting your password is easy. Just press the button below and follow the instructions. Well have you up and running in no time. </p>

                        </td>

                    </tr>

                    <!-- BULLETPROOF BUTTON -->

                    <tr>

                        <td bgcolor="#ffffff" align="left" style="border-bottom: 3px solid #d4dadf;">

                            <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                <tr>

                                    <td bgcolor="#ffffff" align="center" style="padding: 20px 30px 60px 30px;">

                                        <table border="0" cellspacing="0" cellpadding="0">

                                            <tr>

                                              

                                             <h3 style="color:black;  font-size: 12px; text-align: left; margin: 0 0 40px;">Link: '.URL::to('/new-password/'.$rand_token).'</h3> 

                                              

                                                <td align="center" style="border-radius: 3px;" bgcolor="#40b3f4"></td>

                                            </tr>

                                        </table>

                                    </td>

                                </tr>

                            </table>

                        </td>

                    </tr>

                </table>

            </td>

        </tr>

        <!-- FOOTER -->

        <tr>

            <td bgcolor="#f4f4f4" align="center" style="padding: 10px 10px 0px 10px;">

                <table border="0" cellpadding="0" cellspacing="0" width="480" >



                    <!-- PERMISSION REMINDER -->

                    <tr>

                        <td bgcolor="#f4f4f4" align="left" style="padding: 0px 30px 30px 30px; color: #666666; font-family: Lato, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 18px;" >

                            <p style="margin: 0;">You received this email because you requested a password reset. If you did not, <a href="index.html" target="_blank" style="color: #111111; font-weight: 700;">please contact us.</a>.</p>

                        </td>

                    </tr>



                    <!-- ADDRESS -->

                    <tr>

                        <td bgcolor="#f4f4f4" align="center" style="padding: 0px 30px 30px 30px; color: #666666; font-family: Lato, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 18px;" >

                            <p style="margin: 0;">GRC India Sector 63</p>

                        </td>

                    </tr>

                </table>

            </td>

        </tr>

    </table>';

            $to = $email;

            $sub = "Email Verification";

            $from = "dsaini@kloudrac.com";

            $fromname = "NOT_To_Reply";

            $response = $this->verifysendMail($sub,$msg,$to,$from,$fromname);

            return redirect('/login')->with('warning', 'Confirmation Email has been sent');

       // }

        //else{

            //Session::put('find_mail', 2);

           // return view('forget.email'); 

           }else{

            //Session::put('find_mail', 2);

             $request->session()->flash('warning', 'Wrong  E-mail Id!');

            return view('superadmin.email_verify');

           }

       

          }else{

      return view('superadmin.email_verify');

    }

    }

function new_password(Request $request, $title)



    

   {

       

         $user = DB::table('grc_user')->where('remember_token', $title)->first();

      if(!isset($user)){

          return redirect('/email-verify/')->with('warning','Token Invalid');

      }

      //$email = $request->email;

        $password = $request->newpassword;

        $password_confirmation = $request->repeatpassword;

       //print_r("title: ".$title); die;

        if($request->isMethod('post')){

            $user = DB::table('grc_user')->where('remember_token', $title)->first();

            $useremail = $user->email;

            $count = DB::table('grc_user')->where('remember_token', $title)->count();



            //print_r($user); echo $user->token; die('tttt');

           

            if($count > 0){

                $user_token = $user->remember_token;

              

               if($password != $password_confirmation) {

                return redirect()->back()->with('warning', 'Please enter same Password');

                } 

                

                if($user_token == $title){





                    $update = DB::table('grc_user')->where('email', $useremail)

                    ->update([

                        'password'=> md5($password),

                        'remember_token'=> ""

                    ]);



                        $msg = '<table style="width:100%; background:#F1FDF6;  " cellspacing="0" cellpadding="0" border="0" align="center">

                      <tbody><tr>

                       <td>

                        <table style=" margin-top:30px;" width="845" cellspacing="0" cellpadding="0" border="0" align="center">

                         <tbody>



                            <tr>

                              <td>

                               <img src="http://GRC.com/public/uploads/GRC_2.png">

                              </td>

                            </tr>

                         

                         <tr>

                          <td style=" background:#fff; vertical-align: bottom; margin0; padding:0;">

                           <div style="padding: 22px;  position:relative; float: left; width: 100%; box-sizing: border-box;">



                            <div style="float:left; width:100%;">

                             <div style="width:688px; margin:52px auto;">

                             <div style="float: left; background: #3CC6ED none repeat scroll 0% 0%; padding: 55px 45px 35px; margin-bottom: 50px;">

                              <h3 style="color: rgb(0, 0, 0); font-family: Tahoma,sans-serif; font-size: 20px; line-height: 25px; margin-top: 0;">Welcome to GRC,</h3>

                              

                               <p style="color: #fff; font-family: helvetica,sans-serif; font-size: 17px; line-height: 22px; margin: 0  0 25px; text-align: left;">This notice confirms that your password was changed on GRC.<br> If you did not change your password, please contact the Site Administrator.</p>

                               

                              </div>

                             </div>

                             </div>

                            

                            

                           </div>

                          </td>

                         </tr>

                         

                        </tbody></table>

                       </td>

                      </tr>

                       </tbody></table>';

                                 $to = $useremail;

                                 $sub = "Change Password Successfully";

                                 $from = "usrivastava@kloudrac.com";

                                 $fromname = "Not_To_Reply";

                                 $response = $this->verifysendMail($sub,$msg,$to,$from,$fromname);





                    return redirect('/login')->with('rsuccess', 'Successfully Password Change.');

                }

                else{

                     $request->session()->flash('war', 'Please Genrate New Link!');

                    return view('superadmin.new_password');

                }

            }

            else{

               return view('superadmin.new_password');

            }

        }

       return view('superadmin.new_password');

    

   }

    function verifysendMail($sub,$msg,$to,$from,$fromname)

   {

       try {

           $mail = Mail::send([], [], function ($message) use ($sub,$msg,$to,$from,$fromname) {



               $message->from($from, $fromname);

               $message->to($to);

               $message->subject($sub);

               $message->setBody($msg, 'text/html'); // for HTML rich messages

           });



           if ($mail) {

               return true;

           } else {

               return false;

           }

       } catch (Exception $e) {

           throw new HttpException(500, $e->getMessage());

       }

   }



    public function circulars(Request $request){

      if($request->isMethod('post'))

       {

         $validator = Validator::make($request->all(), [

            'addCircular' => 'required',

            'circularimage' => 'max:10000'

            

        ],$this->customMsg());



        if ($validator->fails()) {

            return redirect('/circular')->with('msg',$validator->errors()->first());

                        // ->withErrors($validator)

                        // ->withInput();

        }



        if($request->hasFile('circularimage')) {

          $file = $request->file('circularimage');

         

          $original_name =str_replace(' ', '_', strtolower(trim($file->getClientOriginalName())));

          $name = $original_name;

          $path = public_path('/attachement');

          

         $file->move($path, $name);

         $fileName = $name;

       // dd($fileName);

          }else{



            $fileName = '';



          }



        

                     $update = DB::table('grc_circular')

                    ->insert(['circular_name' => $request->addCircular,

                    'attachment' => $fileName,

                              'created_by' => session('userId'),

                              'org_id' => session('org_id'),

                              'created_date' => date('Y-m-d H:i:s'),

                              'modified_date' => date('Y-m-d H:i:s'),

                              'status' => 1

                             ]); 

               return redirect()->back()->with('msg','Successfully Added Circular');

              //$updateData = DB::table('grc_circular')->get();      

                   // return view('superadmin.circular',compact('updateData'));

       }else{

          $updateData = DB::table('grc_circular');

          if(session('role') != 'superadmin'){

              $updateData->where('org_id',session('org_id')); 

          }

       

          if(isset($request->dateStart) && isset($request->dateEnd)){

             $updateData->whereBetween(DB::raw("(DATE_FORMAT(grc_circular.created_date,'%Y-%m-%d'))"), [$request->dateStart, $request->dateEnd]);; 

          }

         

          

        $updateData = $updateData->orderBy('id','DESC')->get();

       

        return view('superadmin.circular',compact('updateData'));

       }

      

    }



     public function circulars_delete(Request $request,$id){

     

        $updateDataas = DB::table('grc_circular')->where('id',$id)->delete();

                    

       

          $updateData = DB::table('grc_circular')->get();  

       return redirect('/circular')->with('updateData');

     

      

    }



    function check_projectlastdate(Request $request,$id)

   {  //echo $id; die('jjkk');

       

        $updateDataas = DB::table('grc_task')->where('id',$id)->first();

                            $proid = $updateDataas->project_id;

                                                     

                                                    $pro = DB::table('grc_project')->where('id',$proid)->first();

                                                    $user = $pro->project_manager;

                                                    $pro = DB::table('grc_user')->where('id',$user)->first();

                                                    $useremail = $pro->email;

                                                   $rand_token=  base64_encode(rand());



                                                    $msg = '<table style="width:100%; background:#F1FDF6;  " cellspacing="0" cellpadding="0" border="0" align="center">

                      <tbody><tr>

                       <td>

                        <table style=" margin-top:30px;" width="845" cellspacing="0" cellpadding="0" border="0" align="center">

                         <tbody>

                         <tr>

                          <td style=" background:#fff; vertical-align: bottom; margin0; padding:0;">

                           <div style="padding: 22px;  position:relative; float: left; width: 100%; box-sizing: border-box;">



                            <div style="float:left; width:100%;">

                             <div style="width:688px; margin:52px auto;">

                             <div style="float: left; background: #3CC6ED none repeat scroll 0% 0%; padding: 55px 45px 35px; margin-bottom: 50px;">

                              <h3 style="color: rgb(0, 0, 0); font-family: Tahoma,sans-serif; font-size: 20px; line-height: 25px; margin-top: 0;">Welcome to GRC,</h3>

                              

                               <p style="color: #fff; font-family: helvetica,sans-serif; font-size: 17px; line-height: 22px; margin: 0  0 25px; text-align: left;">This notice confirms that your project cross enddate.<br> If you take action on it confirm your activity on clicking this link.</p>

                               Link: http://localhost/grc/public/projectmanageraction/'.$rand_token.'

                               

                              </div>

                             </div>

                             </div>

                            

                            

                           </div>

                          </td>

                         </tr>

                         

                        </tbody></table>

                       </td>

                      </tr>

                       </tbody></table>';

                                 $to = $useremail;

                                 $sub = "Project delay notification";

                                 $from = "usrivastava@kloudrac.com";

                                 $fromname = "Not_To_Reply";

                                 $response = $this->verifysendMail($sub,$msg,$to,$from,$fromname);

            $updation = DB::table('grc_task')->where('id',$id)

                       ->update(['red_mark_status' => 1,

                              'modified_date' => date('Y-m-d H:i:s')

                            ]);



                       $updationuser = DB::table('grc_user')->where('id',$user)

                       ->update(['remember_token' => $rand_token,

                            ]);

 





         return redirect('/Task-list');

    

   }



    function projectmanager_activity(Request $request,$title = null)

   {                                          

                       $updationuser = DB::table('grc_user')->where('remember_token',$title)

                       ->update(['remember_token' => '',

                            ]);

 





         return view('superadmin.project_manageractivity');

    

   }



   function taskcannotcompleted(Request $request,$id)

   {  //echo $id; die('jjkk');

       

        $updateDataas = DB::table('grc_task')->where('id',$id)->first();

                            $proid = $updateDataas->project_id;

                                                     

        $pro = DB::table('grc_project')->where('id',$proid)->first();

                                                    $user = $pro->project_manager;

                                                    $pro = DB::table('grc_user')->where('id',$user)->first();

                                                    $useremail = $pro->email;

                                                   



                                                    $msg = '<table cellpadding="0" cellspacing="0" style="width: 100%; height: 100%; background-color: #ffffff; text-align: center;">

    <tbody>

      <tr>

        <td style="width: 100%; height: 100px; background-color: #ffffff; opacity: 0.81"></td>

      </tr>

      <tr>

        <td style="text-align: center;">

          <table align="center" cellpadding="0" cellspacing="0" id="body" style="background-color: #ececec; width: 100%; max-width: 680px; height: 100%;">

            <tbody>

              <tr>

                <td>

                  <table align="center" cellpadding="0" cellspacing="0" class="page-center" style="text-align: left; padding: 40px 70px 50px;">

                    <tbody>

                      <tr>

                        <td style="text-align: center;">

                          <a href="index.html" target="_blank"><img src="assets/images/grc_new_logo.png" style="width: 200px;"></a>

                        </td>

                      </tr>

                      <tr>

                        <td style="-ms-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: 100%; color: #9095a2; font-family: Helvetica, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, sans-serif; font-size: 18px; font-smoothing: always; font-style: normal; font-weight: 400; letter-spacing: -0.18px; line-height: 24px; mso-line-height-rule: exactly; text-decoration: none; vertical-align: top; width: 100%; padding-top: 30px;">

                          This is regarding the task can not be completed on time due to the following reason -

                        </td>

                      </tr>

                      <tr>

                        <td align="left" valign="top">

                          <ul class="reason_list" style="-ms-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: 100%; color: #333333; font-family: Helvetica, -apple-system, BlinkMacSystemFont, Segoe UI,Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, sans-serif; font-size: 14px; font-smoothing: always; font-style: normal; font-weight: 400; letter-spacing: -0.18px; line-height: 20px; mso-line-height-rule: exactly;vertical-align: top; width: 100%; list-style-position: inside; text-align: justify;">

                            <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</li>

                            <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</li>

                            <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</li>

                          </ul>

                        </td>

                      </tr>

                    </tbody>

                  </table>

                </td>

              </tr>

            </tbody>

          </table>';

                                 $to = $useremail;

                                 $sub = "Task Cannot Be Completed";

                                 $from = "usrivastava@kloudrac.com";

                                 $fromname = "Not_To_Reply";

                                 $response = $this->verifysendMail($sub,$msg,$to,$from,$fromname);

            $updation = DB::table('grc_task')->where('id',$id)

                       ->update(['task_not_completed' => 1,

                              'modified_date' => date('Y-m-d H:i:s')

                            ]);

/*

                       $updationuser = DB::table('grc_user')->where('id',$user)

                       ->update(['remember_token' => $rand_token,

                            ]);*/

 





         return redirect('/Task-list');

    

   }

   

   

    public function getdeails_user(Request $request){



     



   $getuser = DB::table('grc_task')->where('user_id',$request->userid)->get();



   return json_encode($getuser);



 }

 

   public function import_csv_data(Request $request){







    if ($request->input('upload') != null ){



      $file = $request->file('task_upload');

      

      // File Details 

      $filename = $file->getClientOriginalName();

      $extension = $file->getClientOriginalExtension();

      $tempPath = $file->getRealPath();

      $fileSize = $file->getSize();

      $mimeType = $file->getMimeType();



       



      // Valid File Extensions

      $valid_extension = array("csv");



      



      // 2MB in Bytes

      $maxFileSize = 2097152; 



      // Check file extension

      if(in_array(strtolower($extension),$valid_extension)){



        // Check file size

        if($fileSize <= $maxFileSize){



          // File upload location

          $location = 'uploadcsv';



          $filename =   time().'.'.$extension;

          



          // Upload file

          //$file->move(public_path($location),$filename);

          $file->move(public_path().'/uploadcsv/', $filename);

          // Import CSV to Database

          $filepath = public_path($location."/".$filename);

         

          // Reading file

          $file = fopen($filepath,"r");

         

          $importData_arr = array();

          $i = 0;



          while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {

             $num = count($filedata);

             

             // Skip first row (Remove below comment if you want to skip the first row)

             if($i == 0){

                $i++;

                continue; 

             }

             for ($c=0; $c < $num; $c++) {

                $importData_arr[$i][] = $filedata [$c];

             }

             $i++;

          }

          fclose($file);



  



          // Insert to MySQL database



          try {

          

          foreach($importData_arr as $importData){



         

              

              if(count($importData) <=3 ){

                  

                  Session::flash('message','Invalid Format');

                  return redirect()->back();

                  

              }





            $insertData = array(

               "condition_no"=>$importData[0]??'',

               "category"=>$importData[1]??'',

               "type"=>$request->selectcategory??'',

               "document"=>isset($importData[2])?$this->RemoveSpecialChar($importData[2]):'',

               "state"=>$request->selectstate??'',

               "sector"=>$request->selectsector??'',

               'hints' => isset($importData[3])?$this->RemoveSpecialChar($importData[3]):'',

              

              );



         

         

         $int = DB::table('grc_document')->insert($insertData);

           

           



          }

          }  catch (\Exception $ex) {



            Session::flash('message','please remove this special charactor');

          return redirect()->back();

       // dd($ex);

       // report($ex);

       // return false;

          }

            

            //dd($insertData);



          Session::flash('message','Import Successful.');

          return redirect()->back();

         

        }else{

          Session::flash('message','File too large. File must be less than 2MB.');

          return redirect()->back();

        }



      }else{

         Session::flash('message','Invalid File Extension.');

         return redirect()->back();

      }



      // Redirect to index

    return redirect()->back();



    }



  }



  function RemoveSpecialChar($str) { 

      

    // Using str_replace() function  

    // to replace the word  

    $res = str_replace( array( '\'', '"', 

    ',' , ';', '<', '>','&','*',"'",'“','”'), ' ', $str); 

      

    // Returning the result  

    return $res; 

    } 



  

  

    public function report_search(Request $request){



    $role = session('role');

    $userId = session('userId');

    $projectReportlist  = array();

    $curentdatae= date('Y-m');



     $sixmonthpreviews = date('Y-m',strtotime('-6 months'));

     $onemonthpreviews = date('Y-m',strtotime('-1 months'));

   // dd($curentdatae);



    $project = DB::table('grc_project');

    if($userId !=1){

      $project->where('created_by',$userId);

    }

    if(isset($request->orgdropdown)){

      $project->where('organization_id',$request->orgdropdown);

    }



     $projectlist = $project->select('id','project_name')->get();

   

  if($request->submit == 'Search' && isset($request->submit)){



     $projecReport = DB::table('grc_project')->where('id','=',$request->projectdropdown)->where('status',1);



  

   



     $projectReportlist =  $projecReport->get();

 

   foreach ($projectReportlist as $key => $projectReportlists) {



    $projectReportlists->condiction = DB::table('grc_project_condition_doc')->where('project_id',$projectReportlists->id)->get();

    

    



     $projectReportlistsall = DB::table('grc_task');

     

       if($request->typeofreport == 'monthlyreport'){

           

             

    if($request->condition != 'all'){

        $projectReportlistsall->where('grc_task.type',$request->condition);

         }



        $projectReportlistsall->whereBetween(DB::raw("(DATE_FORMAT(grc_task.created_date,'%Y-%m'))"), [$onemonthpreviews, $curentdatae]);

       

       

         

     }else{

         

          if($request->condition != 'all'){

        $projectReportlistsall->where('grc_task.type',$request->condition);

         }



      $projectReportlistsall->whereBetween(DB::raw("(DATE_FORMAT(grc_task.created_date,'%Y-%m'))"), [$sixmonthpreviews, $curentdatae]);

       //$projecReport->where(DB::raw("(DATE_FORMAT(grc_project.created_date,'%Y-%m'))"), '>=', $sixmonthpreviews)

      //->where(DB::raw("(DATE_FORMAT(grc_project.created_date,'%Y-%m'))"), '<=', $curentdatae);

      

    //   if($request->condition != 'All'){

    //     $projectReportlistsall->where('grc_task.type',$request->condition);

    //      }



     }

     

    $projectReportlists->task   =  $projectReportlistsall->where('project_id',$projectReportlists->id)->where('status',1)->get();



    

    

   }

    

  }

  //dd($projectReportlist);



    return view('superadmin.report',['project' =>  $projectlist,'projectReportlist' => $projectReportlist]);

  }



function pdf(Request $request)

    {

        

        $customPaper = array(0,0,720,700);

        

         $data = $this->report_data_to_html($request->projectdropdown,$request->typeofreport,$request->condition);

        

        // Send data to the view using loadView function of PDF facade

    $pdf = PDF::loadView('superadmin.report_templete',['report' => $data,'type_report' => $request->typeofreport])->setPaper($customPaper, 'landscape');

    // If you want to store the generated pdf to the server then you can use the store function

    $pdf->save(public_path().'_filename.pdf');

   // $pdf->save(public_path($pdfpath));

    // Finally, you can download the file using download function

    return $pdf->download($data[0]->project_name.'.pdf');

        

        

    //  // dd($this->report_data_to_html($request->projectdropdown,$request->typeofreport,$request->condition));

    // $pdf =  PDF::loadHtml('superadmin.report_templete')->setPaper('legal');

    //  // $pdf = \App::make('dompdf.wrapper');

    //  // $pdf->loadHTML($this->report_data_to_html($request->projectdropdown,$request->typeofreport,$request->condition));

    //       $pdfpath = 'uploads_remarkdoc/pdf/'.'pdf_Report.pdf';

         

    //   try{

    //     $pdf->save(public_path($pdfpath));

    //   }catch(Exception $e){



    //   return redirect()->back()->withErrors('FNF');

    //   }

    //   return $pdf->stream();

    //   //return $pdf->download('tuts_notes.pdf');

    }







function export_csv(Request $request)

    {



         

      try{



        $org_all_data = $this->csv_data();



       



          

            $columns = array('S.No', 'Project Name', 'Project Date/Month/Year', 'Project ID', 'Project Manager','Organization Name','Project State/Location','Conditions(Completed)','Conditions(Other)');



    

    $filename = public_path("uploads/csv/project_'".time()."'_report.csv");

    $handle = fopen($filename, 'w+');

    fputcsv($handle, $columns);



               $i = 1;

           foreach ($org_all_data as  $org_all_datas) {

         



                foreach ($org_all_datas->project_list as  $project) {



            





                 fputcsv($handle, array($i++,$project->project_name??'',$project->end_date??'',$project->project_id??'',$project->first_name??'',$org_all_datas->org_name??'',$project->project_alias??'',$project->totalComplete??0,$project->totalOther??0));



                   



                 }

            }

        

       fclose($handle);



       $headers = array(

        'Content-Type' => 'text/csv'

       

        );





    return Response()->download($filename);





      }catch(Exception $e){



       return redirect()->back()->withErrors('FNF');

      }

      

    }



    function csv_data(){



    $org_list = DB::table('grc_organization');



    if(session('role') != 'superadmin'){

              $org_list->where('id',session('org_id')); 

          }

   $org_list = $org_list->where('status',1)->get();

  



     foreach ($org_list as $key => $org_lists) {



      $org_lists->project_list = DB::table('grc_project')



       ->join('alm_states','grc_project.state','=','alm_states.id')

         ->join('alm_cities','grc_project.city','=','alm_cities.id')

         ->join('main_currency','grc_project.currency_id','=','main_currency.id')

         ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')

         ->join('grc_sector','grc_project.sector','=','grc_sector.id')

         ->join('grc_user','grc_project.project_manager','=','grc_user.id')->where('grc_project.organization_id',$org_lists->id)->orderBy('grc_project.id','desc')->select('grc_project.*','grc_user.first_name')->get();



                    $complete = 0;

                     $other = 0;

                    $taskID = array();

               foreach ($org_lists->project_list as $key => $project) {



                 // $project->condiction = DB::table('grc_project_condition_doc')->where('project_id',$project->id)->get();

                                

                         $project->task_details = DB::table('grc_task')

                      ->join('grc_sector','grc_task.sector','=','grc_sector.id')

                      ->join('grc_user','grc_task.user_id','=','grc_user.id')

                      ->join('grc_project','grc_task.project_id','=','grc_project.id')

                       ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')

                      ->join('alm_states','grc_task.state_id','=','alm_states.id')

                      ->where('grc_task.project_id',$project->id)

                      ->orderBy('grc_task.id','desc')->select('grc_task.*')->get();

                   

        

                    foreach ($project->task_details as $key => $taskdetails) {



                           $taskID[] = $taskdetails->id;

  

                     }

                     

                     if(count($taskID) > 0){

                         

           //  $remark = DB::table('grc_task_remarks')->whereIn('task_id',$taskID)->orderBy('id','DESC')->first();



          $complete = DB::table('grc_task_remarks')->whereIn('task_id',$taskID)->where('task_status','Completed')->count();



          // $other = DB::table('grc_task_remarks')->whereIn('task_id',$taskID)->where('task_status','!=','Completed')->count();



                  

                     

                      $project->totalComplete = $complete;

                     $project->totalOther =  count($taskID) - $complete??0;

                   $project->probability =  $taskID;

                    $taskID = [];

                         

                     }

                     

        

                     



                  

               }

               

           

     }



     

     return $org_list;





    }





    function report_data_to_html($projectid,$setmonth,$contition)

    {

      

      $curentdatae= date('Y-m');



     $sixmonthpreviews = date('Y-m',strtotime('-6 months'));

      $onemonthpreviews = date('Y-m',strtotime('-1 months'));



      $projecReport = DB::table('grc_project')->join('grc_organization','grc_project.organization_id','=','grc_organization.id')->join('alm_states','grc_project.state','=','alm_states.id')->join('alm_cities','grc_project.city','=','alm_cities.id')->where('grc_project.id','=',$projectid)->where('grc_project.status',1);



     if($contition != 'all'){

      $projecReport->where('grc_project.project_stage',$contition);

     }



    



     $projectReportlist =  $projecReport->select('grc_project.*','grc_organization.org_name','grc_organization.address','alm_states.name as state_name','alm_cities.name as city_name')->get();



   foreach ($projectReportlist as $key => $projectReportlists) {



    $projectReportlists->Generic_condiction = DB::table('grc_project_condition_doc')->where('category_section','Generic')->where('project_id',$projectReportlists->id)->get();

    $projectReportlists->Specific_condiction = DB::table('grc_project_condition_doc')->where('category_section','Specific')->where('project_id',$projectReportlists->id)->get();



      $taskallGeneric = DB::table('grc_task');

     

      if($setmonth == 'monthlyreport'){



     $taskallGeneric->whereBetween(DB::raw("(DATE_FORMAT(grc_task.created_date,'%Y-%m'))"), [$onemonthpreviews, $curentdatae]);

        //  if($contition != 'All'){

        // $taskall->where('grc_task.type',$contition);

        //  }

         

         

     }else{



       $taskallGeneric->whereBetween(DB::raw("(DATE_FORMAT(grc_task.created_date,'%Y-%m'))"), [$sixmonthpreviews, $curentdatae]);

       

        // if($contition != 'All'){

        //     $taskall->where('grc_task.type',$contition);

        //  }



     }

     

     

     $projectReportlists->Generic_task  = $taskallGeneric->where('grc_task.project_id',$projectReportlists->id)->where('grc_task.status',1)->where('grc_task.category','Generic')->orderBy('grc_task.condition_no','ASC')->get();



         foreach ($projectReportlists->Generic_task as $key => $taskdetails) {



      $taskdetails->Generic_tast_document = DB::table('grc_project_task_document')->where('task_id',$taskdetails->id)->get();

      

     }

       

       

      $taskallSpecific = DB::table('grc_task');

     

      if($setmonth == 'monthlyreport'){



       $taskallSpecific->where(DB::raw("(DATE_FORMAT(grc_task.created_date,'%Y-%m'))"), ">=", $curentdatae);

       

        //  if($contition != 'All'){

        // $taskall->where('grc_task.type',$contition);

        //  }

         

         

     }else{



       $taskallSpecific->whereBetween(DB::raw("(DATE_FORMAT(grc_task.created_date,'%Y-%m'))"), [$sixmonthpreviews, $curentdatae]);

       

        // if($contition != 'All'){

        //     $taskall->where('grc_task.type',$contition);

        //  }



     }

     

     

     $projectReportlists->Specific_task  = $taskallSpecific->where('grc_task.project_id',$projectReportlists->id)->where('grc_task.status',1)->where('grc_task.category','Specific')->orderBy('grc_task.condition_no','ASC')->get();





   

     

      foreach ($projectReportlists->Specific_task as $key => $taskdetails) {



      $taskdetails->Specific_tast_document = DB::table('grc_project_task_document')->where('task_id',$taskdetails->id)->get();

      

     }

   



    

   

   

    }

    

      return $projectReportlist;



}









public function deleteproject($id){





  DB::table('grc_project')->where('id',$id)->delete();

  DB::table('grc_task')->where('project_id',$id)->delete();

  DB::table('grc_relation')->where('project_id',$id)->delete();



  return redirect()->back()->with('msg','Successfully Deleted');

}



public function getorganisationlist($role){

  

  

  if($role == 'admin') {

      

      $getornationlist = Db::table('grc_organization')->orWhereNull('org_admin')->select('id','org_name')->get();

      

  }elseif($role == 'project_Manager'){

      

       $getornationlist = Db::table('grc_organization')->select('id','org_name')->get();

      

  }else{

      

      $getornationlist = Db::table('grc_organization')->select('id','org_name')->get();

      

  }

  

  

  return response()->json(['status' => 200, 'data' => $getornationlist]);

    

}



public function getoproject($role,$org){

    

  if($role == 'admin') {

      

      $project = Db::table('grc_project')->where('organization_id',$org)->select('id','project_name')->get();

      

  }elseif($role == 'project_Manager'){

      

       $project = Db::table('grc_project')->orWhereNull('project_manager')->where('organization_id',$org)->select('id','project_name')->get();

      

  }else{

      

      $project = Db::table('grc_project')->select('id','project_name')->get();

      

  }

  

  

  return response()->json(['status' => 200, 'data' => $project]);

    

}





public function taskstatus($taskid){

    

  $task = DB::table('grc_task')->where('id',$taskid)->first();

    if($task->status == 1){



      DB::table('notification')

          ->insert([

                    'user_id' => session('userId'),

                    'org_id' => $task->id,

                    'msg' => 'DeActive Task '.$task->task_name,

                    'created_by' => session('userId'),

                   

                   ]); 

        

        $s = 0;



          DB::table('grc_user')->where('id',$task->user_id)->update(['status' =>$s]);

         $update = DB::table('grc_task')->where('id',$taskid)->update(['status' =>$s]);



          return response()->json(['status' => 200, 'msg' => 'Successfully Deactive Task']);

    

  

    }else{

           $s = 1;



           DB::table('notification')

          ->insert([

                    'user_id' => session('userId'),

                    'org_id' => $task->id,

                    'msg' => 'Active Task '.$task->task_name,

                    'created_by' => session('userId'),

                   

                   ]); 

     DB::table('grc_user')->where('id',$task->user_id)->update(['status' =>$s]);      

    $update = DB::table('grc_task')->where('id',$taskid)->update(['status' =>$s]);

    

       return response()->json(['status' => 200, 'msg' => 'Successfully Active Task']);



        

    }

  

}





public function getcondition($pid){

   

  return $getconfition  = DB::table('grc_project_additional_condition')->where('project_id',$pid)->get();

    

}





public function attach_file(Request $request){

    

  

    

    

     $rules = array(

      'attfile' => 'required|max:10000' // max 10000kb

    );



    // Now pass the input and rules into the validator

    $validator = Validator::make($request->all(), $rules);

    

    if($validator->fails())

    {

       return response()->json(['status' => 202, 'msg' => $validator->errors()->getMessages()]);

    }



      



         if($request->hasFile('attfile')) {

           $file = $request->file('attfile');



           $getFileExt   = $file->getClientOriginalExtension();

          $uploadedFile =   $file->getClientOriginalName();

         

           $file->move(public_path('attachement'), $uploadedFile);

           $attachmentfile = $uploadedFile;

           

           $arr = array(

               'task_id' => $request->task_id,

               'files' => $attachmentfile,

               'created_by' => session('userId'),

               'created_at' => date('Y-m-d h:i:s')

               

               

               );

               DB::table('task_files')->insert($arr);

           

           return response()->json(['status' => 200, 'msg' => 'Successfully Uploaded']);

        }



       

    



}



function update_hint_data(Request $request){

    

    $arr = array(

        'task_id' => $request->task_id,

        'hints' => $request->hint_text,

        'created_by' => session('userId'),

        'created_at' => date('Y-m-d h:i:s')

        

        

        );

        

        if(isset($request->hint_id)){

            

                DB::table('task_hints')->where('id',$request->hint_id)->update($arr);

        

         return response()->json(['status' => 200, 'msg' => 'Successfully Updated']);

            

        }else{

            

                DB::table('task_hints')->insert($arr);

        

         return response()->json(['status' => 200, 'msg' => 'Successfully Added']);

            

        }

    

}



public function delete_currency($id){



  DB::table('main_currency')->where('id',$id)->delete();

     return redirect()->back()->with('warning-currency','Successfully Deleted');

        

}



public function delete_status($id){



  DB::table('grc_status')->where('id',$id)->delete();

     return redirect()->back()->with('warning-status','Successfully Deleted');

        

}



public function delete_type($id){



  DB::table('grc_type')->where('id',$id)->delete();

     return redirect()->back()->with('msg','Successfully Deleted');

        

}



public function delete_stage($id){



  DB::table('grc_stages')->where('id',$id)->delete();

     return redirect()->back()->with('msg','Successfully Deleted');

        

}



public function delete_sector($id){



  DB::table('grc_sector')->where('id',$id)->delete();

     return redirect()->back()->with('msg','Successfully Deleted');

        

}



function view_noti($view_id){



  

	 	DB::table('notification')->update(['view' => 1]);

	 





	  $noticount= DB::table('notification');

             if(session('role') != 'superadmin'){

                $noticount->where('user_id',session('userId')); 

             }

            

          $pre_date = date('Y-m-d',(strtotime ( '-7 day' , strtotime ( date('Y-m-d')) ) ));



          $noticount  =  $noticount->where(DB::raw("(DATE_FORMAT(notification.created_at,'%Y-%m-%d'))"), ">=", $pre_date)->where('view',0)->orderBy('id','DESC')->count();



    return response()->json(['status' => 200, 'msg' => 'Successfully Updated','count_noti' => $noticount]);





}


function checkProjectDate($selectedDate,$projectId){

  $project = DB::table('grc_project')->where('id',$projectId)->first();
 
  if(strtotime($project->start_date) < strtotime($selectedDate) && strtotime($project->end_date) > strtotime($selectedDate)){
      
        

       return response()->json(['status' => 200, 'msg' => '']);
      
  }else{
      
        return response()->json(['status' => 201, 'msg' => 'Task end date cannot be greater then project end date']);
      
  }
  
}

function project_assign_inviable(Request $request,$id){
    
    
      if($request->isMethod('post')) 

         {

         

         $projectDetails = DB::table('grc_project')->where('id',$id)->first();


           DB::table('grc_project_condition_doc_assign')->where('project_id',$id)->where('doc_type',$request->stage)->delete();

            DB::table('grc_task')->where('project_id',$id)->where('type',$request->stage)->delete();

          $getDoc = DB::table('grc_project_condition_doc')->where('project_id',$id)->where('doc_type',$request->stage)->get();
          
          $i = 1;
          foreach ($getDoc as $key => $get_doc_condition) {





            $date1 = new DateTime(date('Y-m-d'));

            $date2 = new DateTime($request->endDate);



         $diff = $date2->diff($date1);



         $hours = $diff->h;

        $hours = $hours + ($diff->days*24);



          

          // $get_doc_condition = DB::table('grc_project_condition_doc')->where('id',$con_id)->first();

          

           if(isset($get_doc_condition)){

            

           

            //DB::table('grc_task')->where('project_id',$id)->where('type',$get_doc_condition->doc_type)->delete();

 

              $assign = [//'category_section' => $request->category,

                              'doc_id' => $get_doc_condition->id,

                              'condition_number' => $i,

                              'doc_type' => $get_doc_condition->doc_type,

                              'project_id' => $id,

                              'category_section' => $get_doc_condition->category_section,

                              'user_id' => $request->username,

                              'state_id' => $get_doc_condition->state_id??0,

                              'sector_name' => $get_doc_condition->sector_name??'',

                              'document_statement' => $get_doc_condition->document_statement,

                              'created_by' => session('userId'),

                              'modified_by' =>session('userId'),

                              'created_date' =>date('Y-m-d H:i:s'),

                              'modified_date' =>date('Y-m-d H:i:s'),

                              'status' => 1,

                              'last_date_task' => $request->endDate,

                              'condtion_status' => 2,

                             ];

                        

                                  DB::table('grc_project_condition_doc')->where('id',$get_doc_condition->id)->update(['condition_number' => $i]);

                        $assin = DB::table('grc_project_condition_doc_assign')->insert($assign);

           
        $tast_id = DB::table('grc_task')

                              ->insertGetId([
                                
                                'task_name' => $get_doc_condition->document_statement,

                              'user_id' => $request->username,

                              'task_id' => task_increment(),

                              'org_id' => $projectDetails->organization_id,

                              'project_id' => $id,

                              'state_id' => $get_doc_condition->state_id??0,

                              'category' => $get_doc_condition->category_section,

                              'sector' => $get_doc_condition->sector_name,

                              'condition_no' =>  $i,

                              'type' => $get_doc_condition->doc_type,

                              'estimated_hrs' => $hours??0,

                              'start_date' => date('Y-m-d H:i:s'),

                              'end_date' => $request->endDate,

                              'created_by' => session('userId'),

                              'modified_by' =>session('userId'),

                              'created_date' =>date('Y-m-d H:i:s'),

                              'modified_date' =>date('Y-m-d H:i:s'),

                              'task_status' => 'New',

                              'status' => 1,

                              'task_condition_status' => $get_doc_condition->id,

                             ]);



                  



                              $updaterr = DB::table('grc_relation')

                    ->insert(['project_id' => $id,

                              'org_id' => session('org_id'),

                              'user_id' => $request->username,

                              'task_id' => $tast_id,

                              'created_date' => date('Y-m-d H:i:s'),

                              'modified_date' => date('Y-m-d H:i:s'),

                              'status' => 1

                             ]); 



           }


            $i++;

          }

                      }





      return redirect()->back()->with('msg','Successfully Assign Users');
    
}


function testpage(){

    

    return view('superadmin.testpage');

}





}

