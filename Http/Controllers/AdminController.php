<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use Session;
use Redirect;
use Response;

//use Input;

class AdminController extends Controller
{
public function admin_login(Request $request){
  //echo "string"; die('dfg');
        if($request->isMethod('post')) 
       { 
       $username = $request->input('username');
      $password = $request-> input ('password');
       $psw = md5($password);
       //die('xc');
 //echo $count; die('fjkj');
       
       if(!empty($username) && !empty($password))
        {
          $count = DB::table('grc_user')->where('email',$username)->where('role','admin')->where('password','=',$psw)->where('status', 1)->count();

            if ($count == 1)
            {   

                $user = DB::table('grc_user')->where('email',$username)->where('status', 1)->first();  
                Session::put('userId', $user->id);
                Session::put('email', $user->email);
                Session::put('username',$user->user_name);
                Session::put('password',$user->password);
                Session::put('role',$user->role);
                Session::put('org_id',$user->org_id);
              

                $request->session()->flash('login', 'Login Successfully.');
                return redirect('/dashboard');
            } else{
                $request->session()->flash('warning', 'Username/Email or Password not match!');
               return redirect('/Adminlogin');
                 }  
         }else{
                $request->session()->flash('warning', 'Username/Email or Password not match!');
                return redirect('/Adminlogin');
               } 

        }else{  
              
                return view('admin.admin_login');

            }

      //return view('admin.admin_login');
    }


public function pm_login(Request $request){
  //echo "string"; die('dfg');
        if($request->isMethod('post')) 
       { 
       $username = $request->input('username');
       $password = $request-> input ('password');
       $psw = md5($password);

       
       if(!empty($username) && !empty($password))
        {
          $count = DB::table('grc_user')->where('email',$username)->where('role','project_Manager')->where('password','=',$psw)->where('status', 1)->count();
            if ($count == 1)
            {   
                $user = DB::table('grc_user')->where('email',$username)->where('status', 1)->first();  
                Session::put('userId', $user->id);
                Session::put('email', $user->email);
                Session::put('username',$user->user_name);
                Session::put('password',$user->password);
                Session::put('role',$user->role);
                Session::put('org_id',$user->org_id);
              

                $request->session()->flash('login', 'Login Successfully.');
                return redirect('/dashboard');
            } else{
                $request->session()->flash('warning', 'Username/Email or Password not match!');
               return redirect('/projectmanager_login');
                 }  
         }else{
                $request->session()->flash('warning', 'Username/Email or Password not match!');
                return redirect('/projectmanager_login');
               } 

        }else{  
              
                return view('admin.project_managerlogin');

            }

      //return view('admin.admin_login');
    }

  public function pm_logout(Request $request) {
      $request->session()->flush();
      return redirect('/projectmanager_login');
    }

    public function employee_login(Request $request){
  //echo "string"; die('dfg');
        if($request->isMethod('post')) 
       { 
       $username = $request->input('username');
       $password = $request-> input ('password');
       $psw = md5($password);

       
       if(!empty($username) && !empty($password))
        {
          $count = DB::table('grc_user')->where('email',$username)->where('role','Employee')->where('password','=',$psw)->where('status', 1)->count();
            if ($count == 1)
            {   
                $user = DB::table('grc_user')->where('email',$username)->where('status', 1)->first();  
                Session::put('userId', $user->id);
                Session::put('email', $user->email);
                Session::put('username',$user->user_name);
                Session::put('password',$user->password);
                Session::put('role',$user->role);
                Session::put('org_id',$user->org_id);
              

                $request->session()->flash('login', 'Login Successfully.');
                return redirect('/dashboard');
            } else{
                $request->session()->flash('warning', 'Username/Email or Password not match!');
               return redirect('/employee-login');
                 }  
         }else{
                $request->session()->flash('warning', 'Username/Email or Password not match!');
                return redirect('/employee-login');
               } 

        }else{  
              
                return view('admin.employee_login');

            }

      //return view('admin.admin_login');
    }

    public function employeelogout(Request $request) {
      $request->session()->flush();
      return redirect('/employee-login');
    }
public function admin_orgview_editorgname(Request $request,$id){
  //echo $id; die('ds');
  if($request->isMethod('post')) 
       { 
           $orgedit = DB::table('grc_organization')->where('id',$id)->count();
           if($orgedit==1){

           $update = DB::table('grc_organization')->where('id',$id)
                    ->update([
                              'org_name' => $request->org
                             ]);
        //             $organizationview = DB::table('grc_organization')->select('*','alm_countries.name as countryname','alm_states.name as statename','alm_cities.name as cityname')
        //                   ->join('alm_countries','grc_organization.country','=','alm_countries.id')
        //                   ->join('alm_states','grc_organization.state','=','alm_states.id')
        //                   ->join('alm_cities','grc_organization.city','=','alm_cities.id')
        //                   ->where('grc_organization.id',$id)
        //                   ->first();
        //                   $this->sendorgEmail($id,'Ornazation Name',$organizationview->org_name);
        // return redirect('/Organization-view/'.$id)->with('organizationview');
        //   }else{

        //     $organizationview = DB::table('grc_organization')->select('*','alm_countries.name as countryname','alm_states.name as statename','alm_cities.name as cityname')
        //                   ->join('alm_countries','grc_organization.country','=','alm_countries.id')
        //                   ->join('alm_states','grc_organization.state','=','alm_states.id')
        //                   ->join('alm_cities','grc_organization.city','=','alm_cities.id')
        //                   ->where('grc_organization.id',$id)
        //                   ->first();
        //return redirect('/Organization-view/'.$id)->with('organizationview');
        return redirect()->back();
           }
       }else{
        echo "string"; die('sdf');
 $organizationview = DB::table('grc_organization')->select('*','alm_countries.name as countryname','alm_states.name as statename','alm_cities.name as cityname')
                          ->join('alm_countries','grc_organization.country','=','alm_countries.id')
                          ->join('alm_states','grc_organization.state','=','alm_states.id')
                          ->join('alm_cities','grc_organization.city','=','alm_cities.id')
                          ->where('grc_organization.id',$id)
                          ->first();
       return view('superadmin.organization_view',compact('organizationview','id'));
     } 
    }

    public function admin_orgview_editorgUsername(Request $request,$id){
  //echo $id; die('ds');
  if($request->isMethod('post')) 
       { 
           $orgedit = DB::table('grc_organization')->where('id',$id)->count();
           if($orgedit==1){

           $update = DB::table('grc_organization')->where('id',$id)
                    ->update([
                              'user_name' => $request->username
                             ]);
                    $organizationview = DB::table('grc_organization')->select('*','alm_countries.name as countryname','alm_states.name as statename','alm_cities.name as cityname')
                          ->join('alm_countries','grc_organization.country','=','alm_countries.id')
                          ->join('alm_states','grc_organization.state','=','alm_states.id')
                          ->join('alm_cities','grc_organization.city','=','alm_cities.id')
                          ->where('grc_organization.id',$id)
                          ->first();
                          $this->sendorgEmail($id,'Ornazation Name',$organizationview->org_name);
        return redirect('/Organization-view/'.$id)->with('organizationview');
           }else{

            $organizationview = DB::table('grc_organization')->select('*','alm_countries.name as countryname','alm_states.name as statename','alm_cities.name as cityname')
                          ->join('alm_countries','grc_organization.country','=','alm_countries.id')
                          ->join('alm_states','grc_organization.state','=','alm_states.id')
                          ->join('alm_cities','grc_organization.city','=','alm_cities.id')
                          ->where('grc_organization.id',$id)
                          ->first();
        return redirect('/Organization-view/'.$id)->with('organizationview');
           }
       }else{
        echo "string"; die('sdf');
 $organizationview = DB::table('grc_organization')->select('*','alm_countries.name as countryname','alm_states.name as statename','alm_cities.name as cityname')
                          ->join('alm_countries','grc_organization.country','=','alm_countries.id')
                          ->join('alm_states','grc_organization.state','=','alm_states.id')
                          ->join('alm_cities','grc_organization.city','=','alm_cities.id')
                          ->where('grc_organization.id',$id)
                          ->first();
       return view('superadmin.organization_view',compact('organizationview','id'));
     } 
    }
    

     public function admin_orgview_editorgmobile(Request $request,$id){
  //echo $id; die('ds');
  if($request->isMethod('post')) 
       { 
           $orgedit = DB::table('grc_organization')->where('id',$id)->count();
           if($orgedit==1){

           $update = DB::table('grc_organization')->where('id',$id)
                    ->update([
                              'mobile_no' => $request->mobile
                             ]);
        //             $organizationview = DB::table('grc_organization')->select('*','alm_countries.name as countryname','alm_states.name as statename','alm_cities.name as cityname')
        //                   ->join('alm_countries','grc_organization.country','=','alm_countries.id')
        //                   ->join('alm_states','grc_organization.state','=','alm_states.id')
        //                   ->join('alm_cities','grc_organization.city','=','alm_cities.id')
        //                   ->where('grc_organization.id',$id)
        //                   ->first();
        //                     $this->sendorgEmail($id,'Ornazation Mobile No',$organizationview->mobile_no);
        // return redirect('/Organization-view/'.$id)->with('organizationview');
        //   }else{

        //     $organizationview = DB::table('grc_organization')->select('*','alm_countries.name as countryname','alm_states.name as statename','alm_cities.name as cityname')
        //                   ->join('alm_countries','grc_organization.country','=','alm_countries.id')
        //                   ->join('alm_states','grc_organization.state','=','alm_states.id')
        //                   ->join('alm_cities','grc_organization.city','=','alm_cities.id')
        //                   ->where('grc_organization.id',$id)
        //                   ->first();
       // return redirect('/Organization-view/'.$id)->with('organizationview');
          return redirect()->back();
           }
       }else{
        echo "string"; die('sdf');
 $organizationview = DB::table('grc_organization')->select('*','alm_countries.name as countryname','alm_states.name as statename','alm_cities.name as cityname')
                          ->join('alm_countries','grc_organization.country','=','alm_countries.id')
                          ->join('alm_states','grc_organization.state','=','alm_states.id')
                          ->join('alm_cities','grc_organization.city','=','alm_cities.id')
                          ->where('grc_organization.id',$id)
                          ->first();
       return view('superadmin.organization_view',compact('organizationview','id'));
     } 
    }

      public function admin_orgview_editorgalternate(Request $request,$id){
  //echo $id; die('ds');
  if($request->isMethod('post')) 
       { 
           $orgedit = DB::table('grc_organization')->where('id',$id)->count();
           if($orgedit==1){

           $update = DB::table('grc_organization')->where('id',$id)
                    ->update([
                              'alternate_no' => $request->alternate
                             ]);
        //             $organizationview = DB::table('grc_organization')->select('*','alm_countries.name as countryname','alm_states.name as statename','alm_cities.name as cityname')
        //                   ->join('alm_countries','grc_organization.country','=','alm_countries.id')
        //                   ->join('alm_states','grc_organization.state','=','alm_states.id')
        //                   ->join('alm_cities','grc_organization.city','=','alm_cities.id')
        //                   ->where('grc_organization.id',$id)
        //                   ->first();
        //                   $this->sendorgEmail($id,'Ornazation Alternate Mobile No',$organizationview->alternate_no);
        // return redirect('/Organization-view/'.$id)->with('organizationview');
        //   }else{

        //     $organizationview = DB::table('grc_organization')->select('*','alm_countries.name as countryname','alm_states.name as statename','alm_cities.name as cityname')
        //                   ->join('alm_countries','grc_organization.country','=','alm_countries.id')
        //                   ->join('alm_states','grc_organization.state','=','alm_states.id')
        //                   ->join('alm_cities','grc_organization.city','=','alm_cities.id')
        //                   ->where('grc_organization.id',$id)
        //                   ->first();
       
        return redirect()->back();
           }
       }else{
        echo "string"; die('sdf');
 $organizationview = DB::table('grc_organization')->select('*','alm_countries.name as countryname','alm_states.name as statename','alm_cities.name as cityname')
                          ->join('alm_countries','grc_organization.country','=','alm_countries.id')
                          ->join('alm_states','grc_organization.state','=','alm_states.id')
                          ->join('alm_cities','grc_organization.city','=','alm_cities.id')
                          ->where('grc_organization.id',$id)
                          ->first();
       return view('superadmin.organization_view',compact('organizationview','id'));
     } 
    }
      public function admin_orgview_editorgpincode(Request $request,$id){
          
         
  //echo $id; die('ds');
  if($request->isMethod('post')) 
       { 
           $orgedit = DB::table('grc_organization')->where('id',$id)->count();
           if($orgedit==1){

           $update = DB::table('grc_organization')->where('id',$id)
                    ->update([
                              'pincode' => $request->pincode
                             ]);
                            
        //             $organizationview = DB::table('grc_organization')->select('*','alm_countries.name as countryname','alm_states.name as statename','alm_cities.name as cityname')
        //                   ->join('alm_countries','grc_organization.country','=','alm_countries.id')
        //                   ->join('alm_states','grc_organization.state','=','alm_states.id')
        //                   ->join('alm_cities','grc_organization.city','=','alm_cities.id')
        //                   ->where('grc_organization.id',$id)
        //                   ->first();
        //                   $this->sendorgEmail($id,'Ornazation Pin Code',$organizationview->pincode);
        // return redirect('/Organization-view/'.$id)->with('organizationview');
        //   }else{

        //     $organizationview = DB::table('grc_organization')->select('*','alm_countries.name as countryname','alm_states.name as statename','alm_cities.name as cityname')
        //                   ->join('alm_countries','grc_organization.country','=','alm_countries.id')
        //                   ->join('alm_states','grc_organization.state','=','alm_states.id')
        //                   ->join('alm_cities','grc_organization.city','=','alm_cities.id')
        //                   ->where('grc_organization.id',$id)
        //                   ->first();
       // return redirect('/Organization-view/'.$id)->with('organizationview');
          return redirect()->back();
           }
       }else{
        echo "string"; die('sdf');
 $organizationview = DB::table('grc_organization')->select('*','alm_countries.name as countryname','alm_states.name as statename','alm_cities.name as cityname')
                          ->join('alm_countries','grc_organization.country','=','alm_countries.id')
                          ->join('alm_states','grc_organization.state','=','alm_states.id')
                          ->join('alm_cities','grc_organization.city','=','alm_cities.id')
                          ->where('grc_organization.id',$id)
                          ->first();
       return view('superadmin.organization_view',compact('organizationview','id'));
     } 
    }

     public function admin_orgview_editorgaddress(Request $request,$id){
  //echo $id; die('ds');
  if($request->isMethod('post')) 
       { 
           $orgedit = DB::table('grc_organization')->where('id',$id)->count();
           if($orgedit==1){

           $update = DB::table('grc_organization')->where('id',$id)
                    ->update([
                              'address' => $request->address
                             ]);
        //             $organizationview = DB::table('grc_organization')->select('*','alm_countries.name as countryname','alm_states.name as statename','alm_cities.name as cityname','grc_organization.status as ogstatus')
        //                   ->join('alm_countries','grc_organization.country','=','alm_countries.id')
        //                   ->join('alm_states','grc_organization.state','=','alm_states.id')
        //                   ->join('alm_cities','grc_organization.city','=','alm_cities.id')
        //                   ->where('grc_organization.id',$id)
        //                   ->first();
        //                   $this->sendorgEmail($id,'Ornazation Address',$organizationview->address);
        // return redirect('/Organization-view/'.$id)->with('organizationview');
        //   }else{

        //     $organizationview = DB::table('grc_organization')->select('*','alm_countries.name as countryname','alm_states.name as statename','alm_cities.name as cityname','grc_organization.status as ogstatus')
        //                   ->join('alm_countries','grc_organization.country','=','alm_countries.id')
        //                   ->join('alm_states','grc_organization.state','=','alm_states.id')
        //                   ->join('alm_cities','grc_organization.city','=','alm_cities.id')
        //                   ->where('grc_organization.id',$id)
        //                   ->first();
      //  return redirect('/Organization-view/'.$id)->with('organizationview');
        return redirect()->back();
           }
       }else{
        echo "string"; die('sdf');
 $organizationview = DB::table('grc_organization')->select('*','alm_countries.name as countryname','alm_states.name as statename','alm_cities.name as cityname','grc_organization.status as ogstatus')
                          ->join('alm_countries','grc_organization.country','=','alm_countries.id')
                          ->join('alm_states','grc_organization.state','=','alm_states.id')
                          ->join('alm_cities','grc_organization.city','=','alm_cities.id')
                          ->where('grc_organization.id',$id)
                          ->first();
       return view('superadmin.organization_view',compact('organizationview','id'));
     } 
    }
public function admin_proviewedit_projectname(Request $request,$id){
 if($request->isMethod('post')) 
       { 
           $orgedit = DB::table('grc_project')->where('id',$id)->count();
           if($orgedit==1){

           $update = DB::table('grc_project')->where('id',$id)
                    ->update([
                              'project_name' => $request->projectname
                             ]);


                    $projectview = DB::table('grc_project')->select('*','alm_states.name as statename','alm_cities.name as cityname','grc_project.description as prodescription','grc_project.id as proid','grc_project.pincode as propincode')
                          ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')
                          ->join('main_currency','grc_project.currency_id','=','main_currency.id')
                          ->join('alm_states','grc_project.state','=','alm_states.id')
                          ->join('alm_cities','grc_project.city','=','alm_cities.id')
                          ->where('grc_project.id',$id)
                          ->first();
        
        $projectdoc = DB::table('project_document')->where('project_id',$id)->get();   
                          

      return redirect('/Project-view/'.$id)->with('msg','Successfully Updated');
                  }else{
                    $projectview = DB::table('grc_project')->select('*','alm_states.name as statename','alm_cities.name as cityname','grc_project.description as prodescription','grc_project.id as proid','grc_project.pincode as propincode')
                          ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')
                          ->join('main_currency','grc_project.currency_id','=','main_currency.id')
                          ->join('alm_states','grc_project.state','=','alm_states.id')
                          ->join('alm_cities','grc_project.city','=','alm_cities.id')
                          ->where('grc_project.id',$id)
                          ->first();
        
        $projectdoc = DB::table('project_document')->where('project_id',$id)->get();   
                          
  return redirect('/Project-view/'.$id)->with('projectview','projectdoc','id');      }
                }else{
      $projectview = DB::table('grc_project')->select('*','alm_states.name as statename','alm_cities.name as cityname','grc_project.description as prodescription','grc_project.id as proid','grc_project.pincode as propincode')
                          ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')
                          ->join('main_currency','grc_project.currency_id','=','main_currency.id')
                          ->join('alm_states','grc_project.state','=','alm_states.id')
                          ->join('alm_cities','grc_project.city','=','alm_cities.id')
                          ->where('grc_project.id',$id)
                          ->first();
        
        $projectdoc = DB::table('project_document')->where('project_id',$id)->get();   
                          

        return redirect('/Project-view/'.$id)->with('projectview','projectdoc','id');
    }
    }

    public function admin_proviewedit_pincode(Request $request,$id){
 if($request->isMethod('post')) 
       { 

           $orgedit = DB::table('grc_project')->where('id',$id)->count();
           if($orgedit==1){

           $update = DB::table('grc_project')->where('id',$id)
                    ->update([
                              'pincode' => $request->pincode
                             ]);


                    $projectview = DB::table('grc_project')->select('*','alm_states.name as statename','alm_cities.name as cityname','grc_project.description as prodescription','grc_project.id as proid','grc_project.pincode as propincode')
                          ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')
                          ->join('main_currency','grc_project.currency_id','=','main_currency.id')
                          ->join('alm_states','grc_project.state','=','alm_states.id')
                          ->join('alm_cities','grc_project.city','=','alm_cities.id')
                          ->where('grc_project.id',$id)
                          ->first();
        
        $projectdoc = DB::table('project_document')->where('project_id',$id)->get();   
                          

      return redirect('/Project-view/'.$id)->with('projectview','projectdoc','id');
                  }else{
                    $projectview = DB::table('grc_project')->select('*','alm_states.name as statename','alm_cities.name as cityname','grc_project.description as prodescription','grc_project.id as proid','grc_project.pincode as propincode')
                          ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')
                          ->join('main_currency','grc_project.currency_id','=','main_currency.id')
                          ->join('alm_states','grc_project.state','=','alm_states.id')
                          ->join('alm_cities','grc_project.city','=','alm_cities.id')
                          ->where('grc_project.id',$id)
                          ->first();
        
        $projectdoc = DB::table('project_document')->where('project_id',$id)->get();   
                          
  return redirect('/Project-view/'.$id)->with('projectview','projectdoc','id');      }
                }else{
      $projectview = DB::table('grc_project')->select('*','alm_states.name as statename','alm_cities.name as cityname','grc_project.description as prodescription','grc_project.id as proid','grc_project.pincode as propincode')
                          ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')
                          ->join('main_currency','grc_project.currency_id','=','main_currency.id')
                          ->join('alm_states','grc_project.state','=','alm_states.id')
                          ->join('alm_cities','grc_project.city','=','alm_cities.id')
                          ->where('grc_project.id',$id)
                          ->first();
        
        $projectdoc = DB::table('project_document')->where('project_id',$id)->get();   
                          

        return redirect('/Project-view/'.$id)->with('projectview','projectdoc','id');
    }
    }


     public function admin_proviewedit_landmark(Request $request,$id){
 if($request->isMethod('post')) 
       { 

           $orgedit = DB::table('grc_project')->where('id',$id)->count();
           if($orgedit==1){

           $update = DB::table('grc_project')->where('id',$id)
                    ->update([
                              'landmark' => $request->landmark
                             ]);


                    $projectview = DB::table('grc_project')->select('*','alm_states.name as statename','alm_cities.name as cityname','grc_project.description as prodescription','grc_project.id as proid','grc_project.pincode as propincode')
                          ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')
                          ->join('main_currency','grc_project.currency_id','=','main_currency.id')
                          ->join('alm_states','grc_project.state','=','alm_states.id')
                          ->join('alm_cities','grc_project.city','=','alm_cities.id')
                          ->where('grc_project.id',$id)
                          ->first();
        
        $projectdoc = DB::table('project_document')->where('project_id',$id)->get();   
                          

      return redirect('/Project-view/'.$id)->with('projectview','projectdoc','id');
                  }else{
                    $projectview = DB::table('grc_project')->select('*','alm_states.name as statename','alm_cities.name as cityname','grc_project.description as prodescription','grc_project.id as proid','grc_project.pincode as propincode')
                          ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')
                          ->join('main_currency','grc_project.currency_id','=','main_currency.id')
                          ->join('alm_states','grc_project.state','=','alm_states.id')
                          ->join('alm_cities','grc_project.city','=','alm_cities.id')
                          ->where('grc_project.id',$id)
                          ->first();
        
        $projectdoc = DB::table('project_document')->where('project_id',$id)->get();   
                          
  return redirect('/Project-view/'.$id)->with('projectview','projectdoc','id');      }
                }else{
      $projectview = DB::table('grc_project')->select('*','alm_states.name as statename','alm_cities.name as cityname','grc_project.description as prodescription','grc_project.id as proid','grc_project.pincode as propincode')
                          ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')
                          ->join('main_currency','grc_project.currency_id','=','main_currency.id')
                          ->join('alm_states','grc_project.state','=','alm_states.id')
                          ->join('alm_cities','grc_project.city','=','alm_cities.id')
                          ->where('grc_project.id',$id)
                          ->first();
        
        $projectdoc = DB::table('project_document')->where('project_id',$id)->get();   
                          

        return redirect('/Project-view/'.$id)->with('projectview','projectdoc','id');
    }
    }

    public function userview_editfirstname(Request $request,$id){
if($request->isMethod('post')) 
       { 

           $orgedit = DB::table('grc_user')->where('id',$id)->count();
           if($orgedit==1){

           $update = DB::table('grc_user')->where('id',$id)
                    ->update([
                              'first_name' => $request->fname
                             ]);

                      $userData = DB::table('grc_user')->select('*','grc_user.pincode as upincode','grc_user.landmark as ulandmark')
                ->join('grc_project','grc_user.pro_id','=','grc_project.id')->where('grc_user.id',$id)->first();
      return redirect('/Users-view/'.$id)->with('userData','id');
                  }else{
                    $userData = DB::table('grc_user')->select('*','grc_user.pincode as upincode','grc_user.landmark as ulandmark')
                ->join('grc_project','grc_user.pro_id','=','grc_project.id')->where('grc_user.id',$id)->first();
       return redirect('/Users-view/'.$id)->with('userData','id');
                  }
     }else{
      $userData = DB::table('grc_user')->select('*','grc_user.pincode as upincode','grc_user.landmark as ulandmark')
                ->join('grc_project','grc_user.pro_id','=','grc_project.id')->where('grc_user.id',$id)->first();
      return redirect('/Users-view/'.$id)->with('userData','id');
    }
    }

     public function userview_editlname(Request $request,$id){
if($request->isMethod('post')) 
       { 

           $orgedit = DB::table('grc_user')->where('id',$id)->count();
           if($orgedit==1){

           $update = DB::table('grc_user')->where('id',$id)
                    ->update([
                              'last_name' => $request->lname
                             ]);

                      $userData = DB::table('grc_user')->select('*','grc_user.pincode as upincode','grc_user.landmark as ulandmark')
                ->join('grc_project','grc_user.pro_id','=','grc_project.id')->where('grc_user.id',$id)->first();
      return redirect('/Users-view/'.$id)->with('userData','id');
                  }else{
                    $userData = DB::table('grc_user')->select('*','grc_user.pincode as upincode','grc_user.landmark as ulandmark')
                ->join('grc_project','grc_user.pro_id','=','grc_project.id')->where('grc_user.id',$id)->first();
       return redirect('/Users-view/'.$id)->with('userData','id');
                  }
     }else{
      $userData = DB::table('grc_user')->select('*','grc_user.pincode as upincode','grc_user.landmark as ulandmark')
                ->join('grc_project','grc_user.pro_id','=','grc_project.id')->where('grc_user.id',$id)->first();
      return redirect('/Users-view/'.$id)->with('userData','id');
    }
    }
     public function userview_editmobile(Request $request,$id){
if($request->isMethod('post')) 
       { 

           $orgedit = DB::table('grc_user')->where('id',$id)->count();
           if($orgedit==1){

           $update = DB::table('grc_user')->where('id',$id)
                    ->update([
                              'mobile_no' => $request->mobile
                             ]);

                      $userData = DB::table('grc_user')->select('*','grc_user.pincode as upincode','grc_user.landmark as ulandmark')
                ->join('grc_project','grc_user.pro_id','=','grc_project.id')->where('grc_user.id',$id)->first();
      return redirect('/Users-view/'.$id)->with('userData','id');
                  }else{
                    $userData = DB::table('grc_user')->select('*','grc_user.pincode as upincode','grc_user.landmark as ulandmark')
                ->join('grc_project','grc_user.pro_id','=','grc_project.id')->where('grc_user.id',$id)->first();
       return redirect('/Users-view/'.$id)->with('userData','id');
                  }
     }else{
      $userData = DB::table('grc_user')->select('*','grc_user.pincode as upincode','grc_user.landmark as ulandmark')
                ->join('grc_project','grc_user.pro_id','=','grc_project.id')->where('grc_user.id',$id)->first();
      return redirect('/Users-view/'.$id)->with('userData','id');
    }
    }
     public function userview_editpincode(Request $request,$id){
if($request->isMethod('post')) 
       { 

           $orgedit = DB::table('grc_user')->where('id',$id)->count();
           if($orgedit==1){

           $update = DB::table('grc_user')->where('id',$id)
                    ->update([
                              'pincode' => $request->pincode
                             ]);

                      $userData = DB::table('grc_user')->select('*','grc_user.pincode as upincode','grc_user.landmark as ulandmark')
                ->join('grc_project','grc_user.pro_id','=','grc_project.id')->where('grc_user.id',$id)->first();
      return redirect('/Users-view/'.$id)->with('userData','id');
                  }else{
                    $userData = DB::table('grc_user')->select('*','grc_user.pincode as upincode','grc_user.landmark as ulandmark')
                ->join('grc_project','grc_user.pro_id','=','grc_project.id')->where('grc_user.id',$id)->first();
       return redirect('/Users-view/'.$id)->with('userData','id');
                  }
     }else{
      $userData = DB::table('grc_user')->select('*','grc_user.pincode as upincode','grc_user.landmark as ulandmark')
                ->join('grc_project','grc_user.pro_id','=','grc_project.id')->where('grc_user.id',$id)->first();
      return redirect('/Users-view/'.$id)->with('userData','id');
    }
    }

    public function userview_editlandmark(Request $request,$id){
if($request->isMethod('post')) 
       { 

           $orgedit = DB::table('grc_user')->where('id',$id)->count();
           if($orgedit==1){

           $update = DB::table('grc_user')->where('id',$id)
                    ->update([
                              'landmark' => $request->landmark
                             ]);

                      $userData = DB::table('grc_user')->select('*','grc_user.pincode as upincode','grc_user.landmark as ulandmark')
                ->join('grc_project','grc_user.pro_id','=','grc_project.id')->where('grc_user.id',$id)->first();
      return redirect('/Users-view/'.$id)->with('userData','id');
                  }else{
                    $userData = DB::table('grc_user')->select('*','grc_user.pincode as upincode','grc_user.landmark as ulandmark')
                ->join('grc_project','grc_user.pro_id','=','grc_project.id')->where('grc_user.id',$id)->first();
       return redirect('/Users-view/'.$id)->with('userData','id');
                  }
     }else{
      $userData = DB::table('grc_user')->select('*','grc_user.pincode as upincode','grc_user.landmark as ulandmark')
                ->join('grc_project','grc_user.pro_id','=','grc_project.id')->where('grc_user.id',$id)->first();
      return redirect('/Users-view/'.$id)->with('userData','id');
    }
    }
    public function admin_logout(Request $request) {
      $request->session()->flush();
      return redirect('/Adminlogin');
    }
    
    private function sendorgEmail($org_id,$name,$changeName){
        
                  
		  $orgstatus = DB::table('grc_organization')->where('id',$org_id)->first();
		  $msg = '<table style="width:100%; background:#F1FDF6;  " cellspacing="0" cellpadding="0" border="0" align="center">
          <tbody><tr>
           <td>
            <table style=" margin-top:30px;" width="845" cellspacing="0" cellpadding="0" border="0" align="center">
             <tbody>
              <tr>
              <td>
              
              </td>
             </tr>
             <tr>
              <td style=" background:#fff; vertical-align: bottom; margin0; padding:0;">
               <div style="padding: 22px;  position:relative; float: left; width: 100%; box-sizing: border-box;">

                <div style="float:left; width:100%;">
                 <div style="width:688px; margin:52px auto;   ">
                 <div style="float: left; background: #3CC6ED none repeat scroll 0% 0%; padding: 55px 45px 35px; margin-bottom: 50px;">
                  <h3 style="color: rgb(0, 0, 0); font-family: Tahoma,sans-serif; font-size: 20px; line-height: 25px; margin-top: 0;">Welcome to Wrello,</h3>
                 
                  
                   <p style="color: #fff; font-family: helvetica,sans-serif; font-size: 17px; line-height: 22px; margin: 0  0 25px; text-align: left;">We gives you access to all our features and tools available in our plan. So get started today ! .</p>
                 
                   <h3 style="color: #fff;  font-size: 18px; text-align: left; margin: 0 0 40px;"> Organization is: .'.$name.'. '.$changeName.'</h3>
                 
                    
                 
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
           
            $sub = "organization Update";
            $from = "dsaini@kloudrac.com";
            $fromname = "Not_To_Reply";
            
            $response = sendMailNotification($sub,$msg,$orgstatus->org_email,$from,$fromname);
            $response = sendMailNotification($sub,$msg,session('email'),$from,$fromname);
            if(isset($orgstatus->org_admin)){
            $response = sendMailNotification($sub,$orgstatus->org_admin,$from,$fromname);
            }
            
        
        
        
    }
    
}