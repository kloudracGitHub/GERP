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
    use Illuminate\Support\Facades\Mail;
    use App\Mail\SendMailable;
    use DB;
    use JWTFactory;
    use Response;
    use URL;
    use DateTime;
    use PDF;
    use File;
    use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{


 public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }

  //  Start Dashboad view Api//
    public function dashboard_view(){

    	$user = JWTAuth::parseToken()->authenticate();
      

    	$usercount = $usercount = DB::table('grc_user')->where('id','!=',$user->id);


      // if($user->role != 'superadmin'){
      //      $usercount->where('created_by',$user->id);    
      // }

     if($user->role == 'project_Manager'){

             $usercount->where('created_by',$user->id); 

           }else{
         if($user->role != 'superadmin'){
           $usercount->where('created_by',$user->id);    
          }
        }

      $usercount = $usercount->whereIN('role',['Employee','project_Manager','admin'])->count();
     
      $orgnagationcount = DB::table('grc_organization');
      
        if($user->role != 'superadmin'){
           $orgnagationcount->where('id',$user->org_id);    
      }
      
      $orgnagationcount = $orgnagationcount->count();
      
      
      $projectcount = DB::table('grc_project')->join('alm_states','grc_project.state','=','alm_states.id')
         ->join('alm_cities','grc_project.city','=','alm_cities.id')
         ->join('main_currency','grc_project.currency_id','=','main_currency.id')
         ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')
         ->join('grc_sector','grc_project.sector','=','grc_sector.id')
         ->join('grc_user','grc_project.project_manager','=','grc_user.id');


    
      
      //    if($user->role != 'superadmin'){
      //      $projectcount->where('organization_id',$user->org_id);    
      // }

       if($user->role == 'project_Manager'){

             $projectcount->where('grc_project.project_manager',$user->id); 

           }elseif($user->role == 'employee'){

                      $project = [];
       $task_list = DB::table('grc_task')->where('user_id',$user->id)->get();
       foreach ($task_list as $key => $task_lists) {
          $project[] = $task_lists->project_id;
       }

             $projectcount->whereIn('grc_project.id',$project);

           }else{
         if($user->role != 'superadmin'){
           $projectcount->where('grc_project.organization_id',$user->org_id);    
          }
        }
      
      
      $projectcount = $projectcount->count();
      
      
      
      $usertask = DB::table('grc_task');
      
         if($user->role != 'superadmin'){
           $usertask->where('org_id',$user->org_id);    
      }
      
      $usertask = $usertask->get();
       $grc_circular = DB::table('grc_circular')->where('status',1);
       
         if($user->role != 'superadmin'){
           $grc_circular->where('org_id',$user->org_id);    
      }
       
      $grc_circular= $grc_circular->orderBy('id','DESC')->get();


  $orgname = array();
  $orgstatus = array();
  $orgbgcolor = array();
  $orgnagation = DB::table('grc_organization');

 if($user->role != 'superadmin'){
           $orgnagation->where('id',$user->org_id);    
      }
$orgnagation = $orgnagation->where('status',1)->get();
  
  
  foreach($orgnagation as $k=>$orgnagations){
                
$projects = DB::table('grc_project')->where('organization_id',$orgnagations->id)->where('status',1)->count();
    $orgname[] = $orgnagations->org_name;
    $orgstatus[] = $projects;
    if($k % 2 ==0){
     $color =  'rgb(87, 148, 238)';
    }else{

      $color = 'rgb(82, 224, 122)';

    }
    $orgbgcolor[] =  $color;
  }
  
  //$enorname = json_encode($orname);
 //$enstatus = json_encode($orstatus);   
 //$encolor = json_encode($bgcolor);

 
  
 $projectName = array();
 $projectColor= array();
  $projectstaus= array();
$project = DB::table('grc_project');
if(session('role') != 'superadmin'){
$project->where('organization_id',$user->org_id);    
}

 $project = $project->where('status',1)->get();
 foreach($project as $k=>$projectsdate){
  $condition = DB::table('grc_project_condition_doc')->where('project_id',$projectsdate->id)->where('status',1)->count();
    $projectName[] = $projectsdate->project_name;
     if($k % 2 ==0){
     $color =  'rgb(87, 148, 238)';
    }else{

      $color = 'rgb(82, 224, 122)';

    }
    $projectColor[] = $color;
    $projectstaus[] = $condition;

    }

 //$enProjectname = json_encode($projectName);
 //$enProjectstatus = json_encode($projectstaus);   
 //$enPojectcolor = json_encode($projectColor);

  

        return response()->json(compact('usercount','orgnagationcount','projectcount','usertask','grc_circular','projectName','projectColor','projectstaus','orgname','orgstatus','orgbgcolor'));


    }

    public function organizationlist_view(Request $request){
        
        
    	$user = JWTAuth::parseToken()->authenticate();
      
      

    	 $orglist = DB::table('grc_organization')
            
            ->leftjoin('alm_countries','grc_organization.country','=','alm_countries.id')
            ->leftjoin('alm_states','grc_organization.state','=','alm_states.id')
            ->leftjoin('alm_cities','grc_organization.city','=','alm_cities.id')
             ->leftjoin('grc_user','grc_organization.org_admin','=','grc_user.id')
            ->orderBy('id','desc')->select('grc_organization.*','alm_countries.name as country_name','alm_states.name as state_name','alm_cities.name as city_name','grc_user.first_name','grc_user.last_name');
            if($user->role != 'superadmin'){
                $orglist->where('grc_organization.id',$user->org_id);    
                 }


         if(isset($request->dateStart) && isset($request->dateEnd)){
             $orglist->whereBetween(DB::raw("(DATE_FORMAT(grc_organization.created_date,'%Y-%m-%d'))"), [date('Y-m-d',strtotime($request->dateStart)), date('Y-m-d',strtotime($request->dateEnd))]);
          }

            $orglist = $orglist->get();
  
           foreach ($orglist as $key => $orglists) {

           $orglists->org_unique_id = 'ORG-'.$orglists->org_unique_id;
           $orglists->project_count = DB::table('grc_project')->where('organization_id',$orglists->id)->count();

            if(isset($orglists->logo) && !empty($orglists->logo)){

               $orglists->org_logo = URL::to('/org_uploads/').'/'.$orglists->logo;

            }else{
               $orglists->org_logo = null;

            }
          
            $orglists->status_name = ($orglists->status==1)?'Active':'Inactive';
            $orglists->admin_name = $orglists->first_name.' '.$orglists->last_name;
            
           }

          
              return response()->json(compact('orglist'),200);


    }

    function organizationlist_pagination(Request $request){




          $user = JWTAuth::parseToken()->authenticate();
      
      

       $orglist = DB::table('grc_organization')
            
            ->leftjoin('alm_countries','grc_organization.country','=','alm_countries.id')
            ->leftjoin('alm_states','grc_organization.state','=','alm_states.id')
            ->leftjoin('alm_cities','grc_organization.city','=','alm_cities.id')
             ->leftjoin('grc_user','grc_organization.org_admin','=','grc_user.id')
            ->orderBy('id','desc')->select('grc_organization.*','alm_countries.name as country_name','alm_states.name as state_name','alm_cities.name as city_name','grc_user.first_name','grc_user.last_name');
            if($user->role != 'superadmin'){
                $orglist->where('grc_organization.id',$user->org_id);    
                 }

             if(isset($request->search)){
              //  $orglist->where('grc_organization.org_name',$request->search);    
                  $orglist->where('grc_organization.org_name', 'like', '%' . $request->search . '%');
                 }

                  if(isset($request->dateStart) && isset($request->dateEnd)){
                   
                       
                        $sdate = str_replace('/', '-', $request->dateStart);
                        $statdate =  date('Y-m-d', strtotime($sdate));
                        
                         $edate = str_replace('/', '-', $request->dateEnd);
                        $enddate =  date('Y-m-d', strtotime($edate));
                         
             $orglist->whereBetween(DB::raw("(DATE_FORMAT(grc_organization.created_date,'%Y-%m-%d'))"), [$statdate,$enddate]);
          }

            $orglist = $orglist->paginate(10);
  
           foreach ($orglist as $key => $orglists) {

           $orglists->org_unique_id = 'ORG-'.$orglists->org_unique_id;
           $orglists->project_count = DB::table('grc_project')->where('organization_id',$orglists->id)->count();

            if(isset($orglists->logo) && !empty($orglists->logo)){

               $orglists->org_logo = URL::to('/org_uploads/').'/'.$orglists->logo;

            }else{
               $orglists->org_logo = null;

            }
          
            $orglists->status_name = ($orglists->status==1)?'Active':'Inactive';
            $orglists->admin_name = $orglists->first_name.' '.$orglists->last_name;
            
           }
           $org_list = [];
           foreach ($orglist as $key => $orglists) {
             $org_list[] = $orglists;
           }

              return response()->json(['orglist' =>$org_list ],200);


    }

    function organization_view_app($id){

      if(!isset($id)){

          return response()->json(['status' => 400,'msg' => 'ORG Not found'],400);

      }

         $organizationview = DB::table('grc_organization')->select('*','alm_countries.name as countryname','alm_states.name as statename','alm_cities.name as cityname','grc_organization.id as orgid','grc_organization.status as ogstatus','grc_user.first_name' ,'grc_user.middle_name','grc_user.last_name','grc_organization.pincode as orgpincode','grc_organization.address as org_address','grc_organization.mobile_no as org_mobile','grc_organization.alternate_no as altno')
                          ->leftjoin('alm_countries','grc_organization.country','=','alm_countries.id')
                          ->leftjoin('alm_states','grc_organization.state','=','alm_states.id')
                          ->leftjoin('alm_cities','grc_organization.city','=','alm_cities.id')
                          ->leftjoin('grc_user','grc_organization.org_admin','=','grc_user.id')
                          ->where('grc_organization.id',$id)
                          ->first();

                  $organizationview->logo = URL::to('/org_uploads/').'/'.$organizationview->logo;

            return response()->json(compact('organizationview'),200);

    }

    function organization_edit_app(Request $request,$id){

          $user = JWTAuth::parseToken()->authenticate();
      

       if(!isset($id)){

          return response()->json(['status' => 400,'msg' => 'ORG Not found'],400);

      }

       $validator = Validator::make($request->all(), [
            'orgname' => 'required',
            
         
              'org_email' => 'required|email',
              'mobile_no' =>'required',
           
           // 'orgalterno' => 'required|max:10',
           'orglogo' => 'mimes:jpeg,jpg,png,gif,PNG,GIF,JPG,JPEG|max:10000',
            'orgcountry' => 'required',
            'orgstate' => 'required',
            
            'orgcity' => 'required',
            'orgpincode' => 'required|max:6',
            'pre_mob' => 'required',
            'orgaddress' => 'required',
        ]);
        

          if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
            }

            Log::info(json_encode($request->all()));

       if ($request->file('orglogo')) {
                    $destinationPath = public_path('org_uploads');
                    $extension = $request->file('orglogo')->getClientOriginalExtension();
                    $fileName = uniqid().'.'.$extension;
                    $request->file('orglogo')->move($destinationPath, $fileName);
                }else{
                  $fileName = ''; 
                }
             if(isset($id) && !empty($id)){

                 $update = DB::table('grc_organization')->where('id',$id)
                    ->update([
                              'org_name' => $request->orgname,
                              'org_email' => $request->org_email,
                              'pre_mob' => $request->pre_mob,
                              
                              'mobile_no' => $request->mobile_no,
                              'alternate_no' => $request->orgalterno,
                               'logo' => $fileName,
                              
                              'country' => $request->orgcountry,
                              'state' => $request->orgstate,
                              'city' => $request->orgcity,
                              'pincode' => $request->orgpincode,
                             
                              'address' => $request->orgaddress,
                              'created_date' => date('Y-m-d H:i:s'),
                              'modified_date' => date('Y-m-d H:i:s'),
                              'status' => 1
                             ]); 

                     DB::table('notification')
                    ->insert([
                              'user_id' => $user->id,
                              'org_id' => $request->org_id,
                              'msg' => 'Updated ORG '.$request->orgname,
                              'created_by' => $user->id,
                             
                             ]); 
                     
                    
                      return response()->json(['msg' => 'Organization Updated Successfully'], 200);


    }

  }

  function org_delete_app($id){

       $user = JWTAuth::parseToken()->authenticate();
      

      if(!isset($id)){

          return response()->json(['status' => 400,'msg' => 'Organization Not found'],400);

      }

       $get_org =  DB::table('grc_organization')->where('id',$id)->first();
        DB::table('notification')
                    ->insert([
                              'user_id' => $user->id,
                              'org_id' => $get_org->id,
                              'msg' => 'Delete ORG '.$get_org->org_name,
                              'created_by' => $user->id,
                             
                             ]); 

      DB::table('grc_organization')->where('id',$id)->delete();
      DB::table('grc_project')->where('organization_id',$id)->delete();
      DB::table('grc_task')->where('org_id',$id)->delete();

       return response()->json(['status' => 200,'msg' => 'Organization Deleted Successfully'],200);


  }

    public function organization_add(Request $request){

    	 $user = JWTAuth::parseToken()->authenticate();
      

    	 $validator = Validator::make($request->all(), [
            'orgname' => 'required|max:255',
           // 'orgemail' => 'required',
             'orgemail' => 'unique:grc_organization,org_email|required',
            // 'orgemail' => 'required|email',
             'adminname' =>'required',
            'orgmobile' => 'unique:grc_organization,mobile_no|max:10|required',
           // 'orgalterno' => 'required|max:10',
           //'orglogo' => 'mimes:jpeg,jpg,png,gif,PNG,GIF,JPG,JPEG|required|max:1000',
            'orgcountry' => 'required',
            'orgstate' => 'required',
            'orgstatus' => 'required',
            'orgcity' => 'required',
            'orgpincode' => 'required|max:6',
            'pre_mob' => 'required',
            'orgaddress' => 'required|max:200',
        ]);

            if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
            }

             $count = DB::table('grc_organization')->select('*')->where('org_unique_id',$request->orgname)->count();
            if($count == 0){
              $uniqueID = mt_rand(1000, 9999);
              $autogenerateId = 'GRC-'.$uniqueID;

                if ($request->file('orglogo')) {
                    $destinationPath = public_path('org_uploads');
                    $extension = $request->file('orglogo')->getClientOriginalExtension();
                    $fileName = uniqid().'.'.$extension;
                    $request->file('orglogo')->move($destinationPath, $fileName);
                }else{
                  $fileName = ''; 
                }


            $update = DB::table('grc_organization')
                    ->insert(['org_unique_id' => org_increment(),
                              'org_name' => $request->orgname,
                              'org_email' => $request->orgemail,
                              'pre_mob' => $request->pre_mob,
                              
                              'mobile_no' => $request->orgmobile,
                              'alternate_no' => $request->orgalterno,
                              'logo' => $fileName,
                              'org_admin' => $request->adminname,
                              'country' => $request->orgcountry,
                              'state' => $request->orgstate,
                              'city' => $request->orgcity,
                              'pincode' => $request->orgpincode,
                              'org_status' => $request->orgstatus,
                              'address' => $request->orgaddress,
                              'created_date' => date('Y-m-d H:i:s'),
                              'modified_date' => date('Y-m-d H:i:s'),
                              'status' => $request->orgstatus,
                             ]); 

              $ogid = DB::getPdo()->lastInsertId();

               DB::table('notification')
                    ->insert([
                              'user_id' => $user->id,
                              'org_id' => $ogid,
                              'msg' => 'Created ORG '.$request->orgname,
                              'created_by' => $user->id,
                             
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
               return response()->json(['msg' => 'Organization Created Successfully'], 200);


                }else{

                	return response()->json(['msg' => 'Organization  Name Already Registered'], 400);

                }

    }


 public function org_status($id){

 	 $user = JWTAuth::parseToken()->authenticate();

 	

 	$orgcount = DB::table('grc_organization')->where('id',$id)->count();
      $orgstatus = DB::table('grc_organization')->where('id',$id)->first();
        if(!isset($orgstatus)) {

        	 return response()->json(['msg' => 'Invalid Organization Id'], 400);

        }    

      if($orgcount==1){
       
        $status = $orgstatus->status;



        if($status == 1){

          DB::table('notification')
          ->insert([
                    'user_id' => $user->id,
                    'org_id' => $orgstatus->id,
                    'msg' => 'Deactive ORG '.$orgstatus->org_name,
                    'created_by' => $user->id,
                   
                   ]);  
                   
                   DB::table('grc_user')->where('org_id', $orgstatus->id)
                   ->update([
                             'status' => 0
                            ]);

                  $update = DB::table('grc_organization')->where('id',$id)
                    ->update([
                              'status' => 0
                             ]);

           return response()->json(['msg' => 'Organization Deactivated Successfully'], 200);


                             }else{

            DB::table('notification')
          ->insert([
                    'user_id' => $user->id,
                    'org_id' => $orgstatus->id,
                    'msg' => 'Active ORG '.$orgstatus->org_name,
                    'created_by' => $user->id,
                   
                   ]);  

                   DB::table('grc_user')->where('org_id', $orgstatus->id)
                   ->update([
                             'status' => 1
                            ]);
            $update = DB::table('grc_organization')->where('id',$id)
                    ->update([
                              'status' => 1
                             ]);

         return response()->json(['msg' => 'Organization  Activated Successfully'], 200);                              

                             }
                         }
                        }

       public function project_list(Request $request){

       	 $user = JWTAuth::parseToken()->authenticate();

       	 if( $user->role == 'project_Manager'){
        $projectlist = DB::table('grc_project')
        ->join('alm_states','grc_project.state','=','alm_states.id')
        ->join('alm_cities','grc_project.city','=','alm_cities.id')
        ->join('main_currency','grc_project.currency_id','=','main_currency.id')
        ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')
        ->join('grc_sector','grc_project.sector','=','grc_sector.id')
        ->join('grc_user','grc_project.project_manager','=','grc_user.id')


        ->where('grc_project.project_manager',$user->id);

         if(isset($request->projectid)){

        //  $projectlist->where('project_id',$request->projectid);
             $projectlist->where('grc_project.project_id', 'like', '%' . $request->projectid . '%');

         }
          if(isset($request->projectname)){

             $projectlist->where('grc_project.project_name', 'like', '%' . $request->projectname . '%');

          
         }
          if(isset($request->projecttype)){

              $projectlist->where('grc_project.project_type',$request->projecttype);
          
         }
          if(isset($request->projectstatus)){

             $projectlist->where('grc_project.project_status',$request->projectstatus);
          
         }


          if(isset($request->org_id)){

             $projectlist->where('grc_project.organization_id',$request->org_id);
          
         }

                
      }elseif($user->role == 'admin'){
          
          
          
        $projectlist = DB::table('grc_project')->leftjoin('alm_states','grc_project.state','=','alm_states.id')->leftjoin('alm_cities','grc_project.city','=','alm_cities.id')->leftjoin('main_currency','grc_project.currency_id','=','main_currency.id')->join('grc_organization','grc_project.organization_id','=','grc_organization.id')->leftjoin('grc_sector','grc_project.sector','=','grc_sector.id')->join('grc_user','grc_project.project_manager','=','grc_user.id')->where('grc_project.organization_id',$user->org_id);
                        if(isset($request->projectid)){

        //  $projectlist->where('project_id',$request->projectid);
             $projectlist->where('grc_project.project_id', 'like', '%' . $request->projectid . '%');

         }
          if(isset($request->projectname)){

             $projectlist->where('grc_project.project_name', 'like', '%' . $request->projectname . '%');

          
         }
          if(isset($request->projecttype)){

              $projectlist->where('grc_project.project_type',$request->projecttype);
          
         }
          if(isset($request->projectstatus)){

             $projectlist->where('grc_project.project_status',$request->projectstatus);
          
         }




                 
      }elseif($user->role == 'employee'){


            $project = [];
       $task_list = DB::table('grc_task')->where('user_id',$user->id)->get();
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
       

      
        // $projectlist = DB::table('grc_project')
        // ->join('alm_states','grc_project.state','=','alm_states.id')
        // ->join('alm_cities','grc_project.city','=','alm_cities.id')
        // ->join('main_currency','grc_project.currency_id','=','main_currency.id')
        // ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')
        // ->join('grc_sector','grc_project.sector','=','grc_sector.id')
        // ->join('grc_user','grc_project.project_manager','=','grc_user.id')
        //  ->leftjoin('grc_task','grc_project.id','=','grc_task.project_id')
        // ->where('grc_task.user_id',$user->id);


                        if(isset($request->projectid)){

        //  $projectlist->where('project_id',$request->projectid);
             $projectlist->where('grc_project.project_id', 'like', '%' . $request->projectid . '%');

         }
          if(isset($request->projectname)){

             $projectlist->where('grc_project.project_name', 'like', '%' . $request->projectname . '%');

          
         }
          if(isset($request->projecttype)){

              $projectlist->where('grc_project.project_type',$request->projecttype);
          
         }
          if(isset($request->projectstatus)){

             $projectlist->where('grc_project.project_status',$request->projectstatus);
          
         }

                 
      }else{
         $projectlist = DB::table('grc_project')
         ->join('alm_states','grc_project.state','=','alm_states.id')
         ->join('alm_cities','grc_project.city','=','alm_cities.id')
         ->join('main_currency','grc_project.currency_id','=','main_currency.id')
         ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')
         ->join('grc_sector','grc_project.sector','=','grc_sector.id')
         ->join('grc_user','grc_project.project_manager','=','grc_user.id');
                         if(isset($request->projectid)){

        //  $projectlist->where('project_id',$request->projectid);
             $projectlist->where('grc_project.project_id', 'like', '%' . $request->projectid . '%');

         }
          if(isset($request->projectname)){

             $projectlist->where('grc_project.project_name', 'like', '%' . $request->projectname . '%');

          
         }


              if(isset($request->org_id)){

             $projectlist->where('grc_project.organization_id', $request->org_id);

          
         }


          if(isset($request->projecttype)){

              $projectlist->where('grc_project.project_type',$request->projecttype);
          
         }
          if(isset($request->projectstatus)){

             $projectlist->where('grc_project.project_status',$request->projectstatus);
          
         }
                 
      }

       if(isset($request->org_id)){

             $projectlist->where('grc_project.organization_id',$request->org_id);
          
         }


        if(isset($request->dateStart) && isset($request->dateEnd)){
             $projectlist->whereBetween(DB::raw("(DATE_FORMAT(grc_project.created_date,'%Y-%m-%d'))"), [date('Y-m-d',strtotime($request->dateStart)), date('Y-m-d',strtotime($request->dateEnd))]);; 
          }

        $project =  $projectlist->orderBy('grc_project.id','desc')->select('grc_project.*','alm_states.name as state_name','alm_cities.name as city_name','main_currency.currencyname','grc_organization.org_name as organization','grc_sector.sector_name','grc_user.first_name','grc_user.last_name')->get();
   foreach($project as $projects){
       $projects->project_manager_name =  $projects->first_name .' '. $projects->last_name;
   }
         return response()->json(compact('project'));


                        }

function project_list_pagination(Request $request) {


           $user = JWTAuth::parseToken()->authenticate();

         if( $user->role == 'project_Manager'){
        $projectlist = DB::table('grc_project')
        ->join('alm_states','grc_project.state','=','alm_states.id')
        ->join('alm_cities','grc_project.city','=','alm_cities.id')
        ->join('main_currency','grc_project.currency_id','=','main_currency.id')
        ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')
        ->join('grc_sector','grc_project.sector','=','grc_sector.id')
        ->join('grc_user','grc_project.project_manager','=','grc_user.id')


        ->where('grc_project.project_manager',$user->id);

         if(isset($request->projectid)){

        //  $projectlist->where('project_id',$request->projectid);
             $projectlist->where('grc_project.project_id', 'like', '%' . $request->projectid . '%');

         }
          if(isset($request->projectname)){

             $projectlist->where('grc_project.project_name', 'like', '%' . $request->projectname . '%');

          
         }
          if(isset($request->projecttype)){

              $projectlist->where('grc_project.project_type',$request->projecttype);
          
         }
          if(isset($request->projectstatus)){

             $projectlist->where('grc_project.project_status',$request->projectstatus);
          
         }


          if(isset($request->org_id)){

             $projectlist->where('grc_project.organization_id',$request->org_id);
          
         }

                
      }elseif($user->role == 'admin'){
          
          
          
        $projectlist = DB::table('grc_project')->leftjoin('alm_states','grc_project.state','=','alm_states.id')->leftjoin('alm_cities','grc_project.city','=','alm_cities.id')->leftjoin('main_currency','grc_project.currency_id','=','main_currency.id')->join('grc_organization','grc_project.organization_id','=','grc_organization.id')->leftjoin('grc_sector','grc_project.sector','=','grc_sector.id')->join('grc_user','grc_project.project_manager','=','grc_user.id')->where('grc_project.organization_id',$user->org_id);
                        if(isset($request->projectid)){

        //  $projectlist->where('project_id',$request->projectid);
             $projectlist->where('grc_project.project_id', 'like', '%' . $request->projectid . '%');

         }
          if(isset($request->projectname)){

             $projectlist->where('grc_project.project_name', 'like', '%' . $request->projectname . '%');

          
         }
          if(isset($request->projecttype)){

              $projectlist->where('grc_project.project_type',$request->projecttype);
          
         }
          if(isset($request->projectstatus)){

             $projectlist->where('grc_project.project_status',$request->projectstatus);
          
         }




                 
      }elseif($user->role == 'employee'){


            $project = [];
       $task_list = DB::table('grc_task')->where('user_id',$user->id)->get();
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
       

      
        // $projectlist = DB::table('grc_project')
        // ->join('alm_states','grc_project.state','=','alm_states.id')
        // ->join('alm_cities','grc_project.city','=','alm_cities.id')
        // ->join('main_currency','grc_project.currency_id','=','main_currency.id')
        // ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')
        // ->join('grc_sector','grc_project.sector','=','grc_sector.id')
        // ->join('grc_user','grc_project.project_manager','=','grc_user.id')
        //  ->leftjoin('grc_task','grc_project.id','=','grc_task.project_id')
        // ->where('grc_task.user_id',$user->id);


                        if(isset($request->projectid)){

        //  $projectlist->where('project_id',$request->projectid);
             $projectlist->where('grc_project.project_id', 'like', '%' . $request->projectid . '%');

         }
          if(isset($request->projectname)){

             $projectlist->where('grc_project.project_name', 'like', '%' . $request->projectname . '%');

          
         }
          if(isset($request->projecttype)){

              $projectlist->where('grc_project.project_type',$request->projecttype);
          
         }
          if(isset($request->projectstatus)){

             $projectlist->where('grc_project.project_status',$request->projectstatus);
          
         }

                 
      }else{
         $projectlist = DB::table('grc_project')
         ->join('alm_states','grc_project.state','=','alm_states.id')
         ->join('alm_cities','grc_project.city','=','alm_cities.id')
         ->join('main_currency','grc_project.currency_id','=','main_currency.id')
         ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')
         ->join('grc_sector','grc_project.sector','=','grc_sector.id')
         ->join('grc_user','grc_project.project_manager','=','grc_user.id');
                         if(isset($request->projectid)){

        //  $projectlist->where('project_id',$request->projectid);
             $projectlist->where('grc_project.project_id', 'like', '%' . $request->projectid . '%');

         }
          if(isset($request->projectname)){

             $projectlist->where('grc_project.project_name', 'like', '%' . $request->projectname . '%');

          
         }


              if(isset($request->org_id)){

             $projectlist->where('grc_project.organization_id', $request->org_id);

          
         }


          if(isset($request->projecttype)){

              $projectlist->where('grc_project.project_type',$request->projecttype);
          
         }
          if(isset($request->projectstatus)){

             $projectlist->where('grc_project.project_status',$request->projectstatus);
          
         }
                 
      }

       if(isset($request->org_id)){

             $projectlist->where('grc_project.organization_id',$request->org_id);
          
         }


        if(isset($request->dateStart) && isset($request->dateEnd)){
            
                     $sdate = str_replace('/', '-', $request->dateStart);
                        $statdate =  date('Y-m-d', strtotime($sdate));
                        
                         $edate = str_replace('/', '-', $request->dateEnd);
                        $enddate =  date('Y-m-d', strtotime($edate));
                        
             $projectlist->whereBetween(DB::raw("(DATE_FORMAT(grc_project.created_date,'%Y-%m-%d'))"), [$statdate,$enddate]);; 
          }

        $project =  $projectlist->orderBy('grc_project.id','desc')->select('grc_project.*','alm_states.name as state_name','alm_cities.name as city_name','main_currency.currencyname','grc_organization.org_name as organization','grc_sector.sector_name','grc_user.first_name','grc_user.last_name')->paginate(10);
   foreach($project as $projects){
       $projects->project_manager_name =  $projects->first_name .' '. $projects->last_name;
   }


 $project_list = [];

 foreach ($project as $key => $projects) {
    $project_list[] = $projects;
 }

         return response()->json(['project' => $project_list],200);

}
   




    public function org_view($org_id=''){

    	 if(isset($org_id) && !empty($org_id)){

        $organizationview = DB::table('grc_organization')->select('*','alm_countries.name as countryname','alm_states.name as statename','alm_cities.name as cityname','grc_organization.id as orgid','grc_organization.status as ogstatus','grc_user.first_name' ,'grc_user.middle_name','grc_user.last_name','grc_organization.pincode as orgpincode','grc_organization.address as org_address','grc_organization.mobile_no as org_mobile','grc_organization.alternate_no as altno')
                          ->leftjoin('alm_countries','grc_organization.country','=','alm_countries.id')
                          ->leftjoin('alm_states','grc_organization.state','=','alm_states.id')
                          ->leftjoin('alm_cities','grc_organization.city','=','alm_cities.id')
                          ->leftjoin('grc_user','grc_organization.org_admin','=','grc_user.id')
                          ->where('grc_organization.id',$org_id);
               

               if($organizationview->count() > 0) {

              $organizationview = $organizationview->first();

               	 return response()->json(compact('organizationview'),200);

               }else{

               	 return response()->json(['msg' => 'Organization Not Found'], 400);

               }         


        

        }else{
            
            return response()->json(['msg' => 'Organization Not Found'], 400);

            
        }

    }


    public function project_edit(Request $request,$id){


       if(!isset($id)){

         return response()->json(['msg' => 'Project Id Not find'], 400);

       }


   $user = JWTAuth::parseToken()->authenticate();


            
    $validator = Validator::make($request->all(), [
            'projectname' => 'required|max:255',
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
           
        ]);

         if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
        }
           
              $project = DB::table('grc_project')->where('id',$id)->first();

            
              if(!isset($project)){

                  return response()->json(['msg' => 'Project Not find'], 400);

              }

              if($user->role == 'admin'){
                $org = $user->org_id;
               }else{
                $org = $request->organizationname;
               }

                DB::table('notification')
                ->insert([
                          'user_id' => $user->id,
                          'org_id' => $org,
                          'msg' => 'Update Project '.$request->projectname,
                          'created_by' => $user->id,
                         
                         ]);  

                  $update = DB::table('grc_project')->where('id',$id)
                    ->update([ 'organization_id' => $org,
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
                              'start_date' => date('Y-m-d',strtotime($request->projectstart)),
                              
                              'end_date' => date('Y-m-d',strtotime($request->projectend)),
                              'created_by' => $user->id,
                              'pincode' => $request->pincode,
                              'modified_by' =>$user->id,
                              'created_date' => date('Y-m-d H:i:s'),
                              'last_modified_date' => date('Y-m-d H:i:s'),
                              'project_status' => $request->prstatus,
                              'status' => 1
                             ]);

       return response()->json(['status' => 200 ,'msg' => 'Project Updated Successfully'], 200);


    }
  

    public function project_add(Request $request){

 	 $user = JWTAuth::parseToken()->authenticate();


            
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
           
        ]);

         if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
           }

             $count = DB::table('grc_project')->select('*')->where('project_name',$request->projectname)->where('organization_id',$request->organizationname)->count();
            if($count == 0){
              $count1 = DB::table('grc_project')->orderBy('id','DESC')->first();
              
              
              if(isset($request->organizationname)){
                  $id = $request->organizationname;
                  
                   $org = DB::table('grc_organization')->where('id',$id)->select('org_name')->first();
                  
              }else{
                  
                  $org = DB::table('grc_organization')->where('id',$user->org_id)->select('org_name')->first();
                  
              }

              if(!isset($org)){

              	 return response()->json(['msg' => 'Organization Name Not Found'], 200);
                
              }

               $exportId = "01"; 
               $uniqueID = mt_rand(1000, 9999);
              $autogenerateId = $org->org_name.$request->projectname.'/'.$request->projectstage.'/'.date("F").'/'.date("Y").'/'.$exportId;
                //$uniqueID = mt_rand(1000, 9999);
            //    $autogenerateId = $request->organizationname.$request->projectname.'/'.$request->projectstage.'/'.$year./.$exportId;
              if($user->role == 'admin'){
                $org = $user->org_id;
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
                          'user_id' => $user->id,
                          'org_id' => $org,
                          'msg' => 'Created Project '.$request->projectname,
                          'created_by' => $user->id,
                         
                         ]);  

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
                              'start_date' => date('Y-m-d',strtotime($request->projectstart)),
                              'project_id' => $autogenerateId,
                              'end_date' => date('Y-m-d',strtotime($request->projectend)),
                              'created_by' => $user->id,
                              'pincode' => $request->pincode,
                              'modified_by' =>$user->id,
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


                     return response()->json(['msg' => 'Project Created Successfully'], 200);
            
          }else{

          	 return response()->json(['msg' => 'Project Already Registered'], 200);

          }


    }

    function delete_project_app($id){

      $user = JWTAuth::parseToken()->authenticate();


      if(!isset($id)){

        return response()->json(['msg' => 'Project Not find'], 400);

      }


     $get_project =  DB::table('grc_project')->where('id',$id)->first();
        DB::table('notification')
                    ->insert([
                              'user_id' => $user->id,
                              'org_id' => $get_project->organization_id,
                              'msg' => 'Delete Project '.$get_project->project_name,
                              'created_by' => $user->id,
                             
                             ]); 

        
      
      DB::table('grc_project')->where('id',$id)->delete();
      DB::table('grc_task')->where('project_id',$id)->delete();

        return response()->json(['msg' => 'Project Deleted Successfully'], 200);


    }


    function project_org_list_app(){

       $user = JWTAuth::parseToken()->authenticate();


      $project_org_list = DB::table('grc_organization')->where('status',1);

      if($user->role != 'superadmin'){
        $project_org_list->where('id',$user->org_id);
      }
       $project_org_list =  $project_org_list->select('id','org_name')->get();

    return response()->json(['status' => 200,'org_list' => $project_org_list ], 200);



    }

    public function project_mng_list_app(Request $request){

        $user = JWTAuth::parseToken()->authenticate();
 

       $manager_list = DB::table('grc_user')->where('status',1)->where('role','project_Manager');
         if($user->role != 'superadmin'){

        $manager_list->where('org_id',$user->org_id);
      }

       if($user->role == 'superadmin'){
        if(isset($request->org_id)){         
         $manager_list->where('org_id',$request->org_id);
        }
       }


      $manager_list = $manager_list->select('id','first_name','last_name')->get();
      foreach ($manager_list as $key => $value) {
       $value->user_name = ucwords($value->first_name).' '. ucwords($value->last_name);
      }

    return response()->json(['status' => 200,'mng_list' => $manager_list ], 200);


    }

    function project_type_app(){

      $project_type = DB::table('grc_type')->get();
       return response()->json(['status' => 200,'project_type' => $project_type ], 200);
    }

    function project_stage_app(){
       $project_stage = DB::table('grc_stages')->get();
       return response()->json(['status' => 200,'project_stage' => $project_stage ], 200);
    

    }

    function project_currency_app(){

       $main_currency = DB::table('main_currency')->get();
       return response()->json(['status' => 200,'main_currency' => $main_currency ], 200);
    

    }

    function project_detail($id){

  $user = JWTAuth::parseToken()->authenticate();

    $projectDet = DB::table('grc_project')->where('id',$id)
                    ->first();
    if(!isset($projectDet)){
     return response()->json(['status' => 400,'msg' => 'Project Not found' ], 400);
     
    }                
                 $stateid = $projectDet->state;
                  $sectorid = $projectDet->sector;
         $sector = DB::table('grc_sector')->where('sector_name',$sectorid)->first();       
      
    
      

     $con1 = DB::table('grc_project_condition_doc')->select('*','grc_project_condition_doc.id as conid','grc_user.id as userId')
          ->leftJoin('grc_user','grc_project_condition_doc.user_id','=','grc_user.id')
      ->where('grc_project_condition_doc.state_id',$stateid)->where('grc_project_condition_doc.sector_name',$sectorid)->where('grc_project_condition_doc.project_id',$id)->where('grc_project_condition_doc.doc_type','EC');
              
               if($user->role != 'superadmin'){
                 
                  $con1->where('grc_user.org_id',$user->org_id);  
                   
               }
                $con1 = $con1->get();
              $con_arr = array();
              foreach ($con1 as $key => $con11) {
                $assign_con = DB::table('grc_project_condition_doc_assign')->join('grc_user','grc_project_condition_doc_assign.user_id','=','grc_user.id')->where('grc_project_condition_doc_assign.doc_id',$con11->conid)->select('grc_project_condition_doc_assign.*','grc_user.first_name','grc_user.last_name')->first();

                  if(isset($assign_con)){

                     $con11->assign_condition_number = $assign_con->condition_number??'';
                  $con11->assign_user_id = $assign_con->user_id??'';
                  $con11->assign_user_name = $assign_con->first_name??''.' '.$assign_con->last_name??'';
                  $con11->assign_last_date_task = $assign_con->last_date_task??'';



                  }
                 
               $con_arr[] = $con11->document_statement;
              }

   //  $project_condition_ec = DB::table('grc_document')->whereNotIn('document',$con_arr)->where('state',$stateid)->where('sector',$sector->id)->where('type','EC')->get();
      
          
       // $project_condition_cto = DB::table('grc_document')->where('state',$stateid)->where('sector',$sector->id)->where('type','CTO')->get();
              
      $con2 = DB::table('grc_project_condition_doc')->select('*','grc_project_condition_doc.id as conid','grc_user.id as userId')->leftJoin('grc_user','grc_project_condition_doc.user_id','=','grc_user.id')
      ->where('grc_project_condition_doc.state_id',$stateid)->where('grc_project_condition_doc.sector_name',$sectorid)->where('grc_project_condition_doc.project_id',$id)->where('grc_project_condition_doc.doc_type','CTO');
                    
                     if($user->role != 'superadmin'){
                 
                  $con2->where('grc_user.org_id',$user->org_id);  
                   
               }
                    
                    $con2= $con2->get();
               foreach ($con2 as $key => $con22) {
                
             
                     $assign_con = DB::table('grc_project_condition_doc_assign')->join('grc_user','grc_project_condition_doc_assign.user_id','=','grc_user.id')->where('grc_project_condition_doc_assign.doc_id',$con22->conid)->select('grc_project_condition_doc_assign.*','grc_user.first_name','grc_user.last_name')->first();

                  if(isset($assign_con)){

                     $con22->assign_condition_number = $assign_con->condition_number;
                  $con22->assign_user_id = $assign_con->user_id;
                  $con22->assign_user_name = $assign_con->first_name.' '.$assign_con->last_name;
                  $con22->assign_last_date_task = $assign_con->last_date_task;

                  }
                 
                }


     // $project_condition_cte = DB::table('grc_document')->where('state',$stateid)->where('sector',$sector->id)->where('type','CTE')->get();
                    
      $con3 = DB::table('grc_project_condition_doc')->select('*','grc_project_condition_doc.id as conid','grc_user.id as userId')->leftJoin('grc_user','grc_project_condition_doc.user_id','=','grc_user.id')
      ->where('grc_project_condition_doc.state_id',$stateid)->where('grc_project_condition_doc.sector_name',$sectorid)->where('grc_project_condition_doc.project_id',$id)->where('grc_project_condition_doc.doc_type','CTE');
                    
                      if($user->role != 'superadmin'){
                 
                  $con3->where('grc_user.org_id',$user->org_id);  
                   
               }
                    
                    $con3= $con3->get();

                     foreach ($con3 as $key => $con33) {
                
             
                     $assign_con = DB::table('grc_project_condition_doc_assign')->join('grc_user','grc_project_condition_doc_assign.user_id','=','grc_user.id')->where('grc_project_condition_doc_assign.doc_id',$con33->conid)->select('grc_project_condition_doc_assign.*','grc_user.first_name','grc_user.last_name')->first();

                    if(isset( $assign_con)){

                 $con33->assign_condition_number = $assign_con->condition_number;
                  $con33->assign_user_id = $assign_con->user_id;
      $con33->assign_user_name = $assign_con->first_name.' '.$assign_con->last_name;
      $con33->assign_last_date_task = $assign_con->last_date_task;

                    }
                  
                }


                 //   $project_condition_gb = DB::table('grc_document')->where('state',$stateid)->where('sector',$sector->id)->where('type','GB')->get();
                    
      $con4 = DB::table('grc_project_condition_doc')->select('*','grc_project_condition_doc.id as conid','grc_user.id as userId')->leftJoin('grc_user','grc_project_condition_doc.user_id','=','grc_user.id')
      ->where('grc_project_condition_doc.state_id',$stateid)->where('grc_project_condition_doc.sector_name',$sectorid)->where('grc_project_condition_doc.project_id',$id)->where('grc_project_condition_doc.doc_type','GB');
                    
                     if($user->role != 'superadmin'){
                 
                  $con4->where('grc_user.org_id',$user->org_id);  
                   
               }
                    
                    $con4 = $con4->get();

                      foreach ($con4 as $key => $con44) {
                
             
                     $assign_con = DB::table('grc_project_condition_doc_assign')->join('grc_user','grc_project_condition_doc_assign.user_id','=','grc_user.id')->where('grc_project_condition_doc_assign.doc_id',$con44->conid)->select('grc_project_condition_doc_assign.*','grc_user.first_name','grc_user.last_name')->first();

                     if(isset($assign_con)){

                $con44->assign_condition_number = $assign_con->condition_number;
                  $con44->assign_user_id = $assign_con->user_id;
                  $con44->assign_user_name = $assign_con->first_name.' '.$assign_con->last_name;
                  $con44->assign_last_date_task = $assign_con->last_date_task;

                     }

                
                }
                    
        $userlist = DB::table('grc_user');
        
                     if($user->role != 'superadmin'){
                 
                  $userlist->where('grc_user.org_id',$user->org_id);  
                   
               }
                    $userlist = $userlist->get();                         

       $projectshow = DB::table('grc_project')->join('alm_states','grc_project.state','=','alm_states.id')->join('alm_cities','grc_project.city','=','alm_cities.id')->join('main_currency','grc_project.currency_id','=','main_currency.id')->join('grc_organization','grc_project.organization_id','=','grc_organization.id')->join('grc_sector','grc_project.sector','=','grc_sector.id')->join('grc_user','grc_project.project_manager','=','grc_user.id')->where('grc_project.id',$id)->select('grc_project.*','alm_states.name as state_name','alm_cities.name as city_name','main_currency.currencyname','grc_organization.org_name','grc_sector.sector_name','grc_user.first_name','grc_user.last_name')->first();
        //echo "<pre>";  print_r($con1); die('dsfs');
        return response()->json(compact('userlist','id','con1','con2','con3','con4','stateid','sectorid','projectshow')
, 200);    

    }

    function project_view_app($id){

        $projectview = DB::table('grc_project')->select('*','alm_states.name as statename','alm_cities.name as cityname','grc_project.description as prodescription','grc_project.id as proid','grc_project.pincode as propincode','grc_user.first_name','grc_user.middle_name','grc_user.last_name')
                          ->leftjoin('grc_organization','grc_project.organization_id','=','grc_organization.id')
                          ->leftjoin('main_currency','grc_project.currency_id','=','main_currency.id')
                          ->leftjoin('alm_states','grc_project.state','=','alm_states.id')
                          ->leftjoin('alm_cities','grc_project.city','=','alm_cities.id')
                          ->leftjoin('grc_user','grc_project.project_manager','=','grc_user.id')
                          ->where('grc_project.id',$id)
                          ->first();
           $Form1 = DB::table('project_document')->where('project_id',$id)->where('category','Form1')->get();

           $Form2 = DB::table('project_document')->where('project_id',$id)->where('category','Form2')->get();
           $EIA = DB::table('project_document')->where('project_id',$id)->where('category','EIA')->get();

           $form_cat = ['Form1' => 'Form1','Form2' => 'Form2','EIA' => 'EIA Report'];

  return response()->json(compact('projectview','Form2','Form1','EIA','form_cat'), 200);    

        

    }

    function project_document_app(Request $request,$id){

       $user = JWTAuth::parseToken()->authenticate();
        if($request->isMethod('post')) 
         { 

           $validator = Validator::make($request->all(), [
            'task_upload' =>  'required|max:2000',
            'selectcatefory' => 'required',
            
        ]);

          if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
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
                              'created_by' => $user->id,
                              'modified_by' => $user->id,
                              'status' => 1
                             ]);

      return response()->json(['status' => 200,'msg'=> 'Attachment Uploaded Successfully'], 200);
    
       
    }
  }


  function add_condition_app(Request $request,$id){

     $user = JWTAuth::parseToken()->authenticate();
    if($request->isMethod('post')) 
         {


        

         $validator = Validator::make($request->all(), [
            'type' =>  'required',
            'category' => 'required',
             'condition_no' => 'required',
              'userid' => 'required',
               'stateid' => 'required',
                'sectorid' => 'required',
                 'compliance' => 'required',
                  'timeFrame' => 'required',

            
        ]);

          if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
           }

              Log::info(json_encode($request->all()));


             $documentData = ['category_section' => $request->category,
                              'project_id' => $id,
                              'condition_number' => $request->condition_no,
                              'doc_type' => $request->type,
                              'user_id' => $request->userid,
                              'state_id' => $request->stateid,
                              'sector_name' => $request->sectorid,
                              'document_statement' => $request->compliance,
                              'created_by' => $user->id,
                              'modified_by' =>$user->id,
                              'created_date' =>date('Y-m-d H:i:s'),
                              'modified_date' =>date('Y-m-d H:i:s'),
                              'status' => 1
                             ];
                       $con_id = DB::table('grc_project_condition_doc')
                    ->insertGetId($documentData);


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
                              'created_by' => $user->id,
                              'modified_by' =>$user->id,
                              'created_date' =>date('Y-m-d H:i:s'),
                              'modified_date' =>date('Y-m-d H:i:s'),
                              'status' => 1,
                              'last_date_task' => $request->timeFrame,
                              'condtion_status' => 2,
                             ];
                        

                        $assin = DB::table('grc_project_condition_doc_assign')->insert($assign);
                       
                    
                             
                            
         
        $tast_id = DB::table('grc_task')
                              ->insert(['task_name' => $request->compliance,
                              'user_id' => $request->userid,
                              'task_id' => task_increment(),
                              'org_id' => $user->org_id,
                              'project_id' => $id,
                              'state_id' =>  $request->stateid,
                              'category' => $request->category,
                              'sector' =>  $request->sectorid,
                              'condition_no' => $request->condition_no,
                              
                              'type' => $request->type,
                              'estimated_hrs' => $hours??0,
                              'start_date' => date('Y-m-d H:i:s'),
                              'end_date' => $request->timeFrame,
                              'created_by' => $user->id,
                              'modified_by' =>$user->id,
                              'created_date' =>date('Y-m-d H:i:s'),
                              'modified_date' =>date('Y-m-d H:i:s'),
                              'task_status' => 'New',
                              'status' => 1,
                              'task_condition_status' => $con_id,
                             ]);

                  


        return response()->json(['status' => 200,'msg'=> 'Successfully Add Condition and Assign'], 200);


                }
     }

     function edit_condition_app(Request $request,$id){




  $user = JWTAuth::parseToken()->authenticate();

       
      if($request->isMethod('post')) 
         {



           $validator = Validator::make($request->all(), [
            'condition_id' =>  'required',
            
             
              'userid' => 'required',
              
                 'compliance' => 'required',

            
        ]);



          if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
           }

               Log::info(json_encode($request->all()));

        
            $count = DB::table('grc_project_condition_doc')->where('id',$request->condition_id)->count();

           
           
            if($count == 1){
              
              
            // echo $ID; die('sdsz');
 $documentData = DB::table('grc_project_condition_doc')->where('id',$request->condition_id)
                    ->update([//'category_section' => $request->category,
                              //'condition_number' => $request->condition_no,
                              //'doc_type' => $request->type,
                              'user_id' => $request->userid,
                              //'state_id' => $request->stateid,
                              //'sector_name' => $request->sectorid,
                              'document_statement' => $request->compliance,
                              'created_by' => $user->id,
                              'modified_by' =>$user->id,
                              //'created_date' =>date('Y-m-d H:i:s'),
                              'modified_date' =>date('Y-m-d H:i:s'),
                              'status' => 1
                             ]);
                             
                             
            $documentData = DB::table('grc_project_condition_doc_assign')->where('doc_id',$request->condition_id)
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
         
        $update = DB::table('grc_task')->where('task_condition_status',$request->condition_id)->where('project_id',$id)
                              ->update(['task_name' => $request->compliance,
                              'user_id' => $request->userid,
                             //'estimated_hrs' => $value->time_limit,
                              //'start_date' => $value->time_limit,
                              //'end_date' => $value->time_limit,
                              'created_by' =>  $user->id,
                              'modified_by' => $user->id,
                              //'created_date' =>date('Y-m-d H:i:s'),
                              'modified_date' =>date('Y-m-d H:i:s'),
                              //'task_status' => 'New',
                              'status' => 1
                             ]);



                            }

       return response()->json(['status' => 200,'msg'=> 'Successfully Updated Condition'], 200);


                    }        

     }

         public function project_condition_delete_app(Request $request,$id){

      if($request->isMethod('post')) 
         {


       $validator = Validator::make($request->all(), [
            'condition_id' =>  'required',
            
        ]);



          if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
           }

      

      
               $documentData = DB::table('grc_project_condition_doc')->where('id',$request->condition_id)->delete();
       $update = DB::table('grc_task')->where('add_condition_id',$request->condition_id)->delete();
           
        

   

  
             
       return response()->json(['status' => 200,'msg'=> 'Successfully Deleted Condition'], 200);       
     }
    }

    public function project_status($id){

    		 $user = JWTAuth::parseToken()->authenticate();




        $projectcount = DB::table('grc_project')->where('id',$id)->count();

      if(!isset($projectcount)){
     return response()->json(['status' => 400,'msg' => 'Project Not found' ], 400);
     
    } 

      $projectstatus = DB::table('grc_project')->where('id',$id)->first();
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
                    'user_id' =>  $user->id,
                    'org_id' => $projectstatus->id,
                    'msg' => 'Active Project '.$projectstatus->project_name,
                    'created_by' =>  $user->id,
                   
                   ]); 

                   $update = DB::table('grc_user')->whereIn('id',$projecttask_user)
                   ->update([
                             'status' => 0
                            ]);

                  $update = DB::table('grc_project')->where('id',$id)
                    ->update([
                              'status' => 0
                             ]);
                             
           // foreach($project_task_status as $project_task_statuss){
                
                $update = DB::table('grc_task')->where('project_id',$id)
                    ->update([
                              'status' => 0
                             ]);
                
          //  }                 
                             

     return response()->json(['msg' => 'Project Deactivated Successfully'], 200);
       
        }else{


        	  DB::table('notification')
          ->insert([
                    'user_id' =>  $user->id,
                    'org_id' => $projectstatus->id,
                    'msg' => 'Active Project '.$projectstatus->project_name,
                    'created_by' =>  $user->id,
                   
                   ]); 

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
                

     
         
     return response()->json(['msg' => 'Project Activated Successfully'], 200);
        }

    }

}

public function superadmin_project_view($id){

	$projectview = DB::table('grc_project')->select('*','alm_states.name as statename','alm_cities.name as cityname','grc_project.description as prodescription','grc_project.id as proid','grc_project.pincode as propincode','grc_user.first_name','grc_user.middle_name','grc_user.last_name')
                          ->leftjoin('grc_organization','grc_project.organization_id','=','grc_organization.id')
                          ->leftjoin('main_currency','grc_project.currency_id','=','main_currency.id')
                          ->leftjoin('alm_states','grc_project.state','=','alm_states.id')
                          ->leftjoin('alm_cities','grc_project.city','=','alm_cities.id')
                          ->leftjoin('grc_user','grc_project.project_manager','=','grc_user.id')
                          ->where('grc_project.id',$id);
                          

                          if($projectview->count() > 0){
                          	$projectview = $projectview->first();

                          return response()->json(compact('projectview'),200);

                          }else{

                          	return response()->json(['msg' => 'Project Not Found'], 200);

                          }

 
                 }


public function project_document(Request $request){

	 $user = JWTAuth::parseToken()->authenticate();


	 $validator = Validator::make($request->all(), [
            'task_upload' =>  'required|max:20000|mimes:doc,docx,pdf,jpg,gif,png',
            'selectcatefory' => 'required',
            'project_id' => 'required',
            
        ]);

        if ($validator->fails()) {
          
     return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
         
        }

        $project_id = $request->project_id;

        if(isset($project_id)){



          $Countdoc =  DB::table('project_document')->where('category',$request->selectcatefory)->where('project_id',$project_id)->count();
          if($Countdoc == 1){
           
            return response()->json(['msg' => 'This category document already exist'], 400);

          }else{
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
                              'project_id' => $project_id,
                              'created_by' => $user->id,
                              'modified_by' => $user->id,
                              'status' => 1
                             ]);
                }

      	       return response()->json(['msg' => 'Project Document Uploaded'], 200);

      	 }else{

      	 		return response()->json(['msg' => 'Project Not Found'], 400);
        	
        }
    }


public function add_project_condition_app(Request $request,$id){

   $user = JWTAuth::parseToken()->authenticate();

 if($request->isMethod('post')) 
         {
            $count = DB::table('grc_project_condition_doc')->where('document_statement',$request->compliance)->where('project_id',$id)->where('doc_type',$request->type)->count();

            if($count == 0){
             $documentData = DB::table('grc_project_condition_doc')
                    ->insert(['category_section' => $request->category,
                              'project_id' => $id,
                              'condition_number' => $request->condition_no,
                              'doc_type' => $request->type,
                              'user_id' => $request->userid,
                              'state_id' => $request->stateid,
                              'sector_name' => $request->sectorid,
                              'document_statement' => $request->compliance,
                              'created_by' =>  $user->id,
                              'modified_by' => $user->id,
                              'created_date' =>date('Y-m-d H:i:s'),
                              'modified_date' =>date('Y-m-d H:i:s'),
                              'status' => 1
                             ]);

    return response()->json(['status' => 200 ,'msg' => 'Successfully Added Project Condition'], 200);
      


      }else{

        return response()->json(['msg' => 'Project Condition Already Exit'], 200);
          

      }
    }                

}

function edit_project_condition_app(Request $request,$id){

     $user = JWTAuth::parseToken()->authenticate();


   if($request->isMethod('post')) 
         {

           $validator = Validator::make($request->all(), [
            
            'condition_id' => 'required',
            'userid' => 'required',
             'compliance'=> 'required',
           
        
           
        ]);

         if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
           }

        
            $count = DB::table('grc_project_condition_doc')->where('id',$request->condition_id)->count();
           
            if($count == 1){
              
              
            // echo $ID; die('sdsz');
             $documentData = DB::table('grc_project_condition_doc')->where('id',$request->condition_id)
                    ->update([//'category_section' => $request->category,
                              //'condition_number' => $request->condition_no,
                              //'doc_type' => $request->type,
                              'user_id' => $request->userid,
                              //'state_id' => $request->stateid,
                              //'sector_name' => $request->sectorid,
                              'document_statement' => $request->compliance,
                              'created_by' =>  $user->id,
                              'modified_by' => $user->id,
                              //'created_date' =>date('Y-m-d H:i:s'),
                              'modified_date' =>date('Y-m-d H:i:s'),
                              'status' => 1
                             ]);
         
        $update = DB::table('grc_task')->where('add_condition_id',$request->condition_id)->where('project_id',$id)
                              ->update(['task_name' => $request->compliance,
                              'user_id' => $request->userid,
                             //'estimated_hrs' => $value->time_limit,
                              //'start_date' => $value->time_limit,
                              //'end_date' => $value->time_limit,
                              'created_by' =>  $user->id,
                              'modified_by' =>$user->id,
                              //'created_date' =>date('Y-m-d H:i:s'),
                              'modified_date' =>date('Y-m-d H:i:s'),
                              //'task_status' => 'New',
                              'status' => 1
                             ]);

                    $updaterealid = DB::table('grc_task')->where('add_condition_id',$request->condition_id)->where('project_id',$id)->first();
                   
                       if(isset($updaterealid->id)){
                        $taskid = $updaterealid->id;

                              $updaterr = DB::table('grc_relation')
                    ->insert(['project_id' => $id,
                              'org_id' => $user->org_id,
                              'user_id' => $request->userid,
                              'task_id' => $taskid,
                              'created_date' => date('Y-m-d H:i:s'),
                              'modified_date' => date('Y-m-d H:i:s'),
                              'status' => 1
                             ]); 

                         }


    return response()->json(['status' => 200 ,'msg' => 'Successfully Updated Project Condition'], 200);
      
            

       }
   } 

}


function project_additional_condition_app(Request $request,$id){

   if($request->isMethod('post')) 
         {
           $validator = Validator::make($request->all(), [
            'addCondition' => 'required|max:100',
            
        ]);

       
         if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
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
                  }
 return response()->json(['status' => 200 ,'msg' => 'Successfully Addition Project Condition'], 200);
      
             }     
                  
}

function get_project_app(Request $require,$id){

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


 return response()->json(compact('CData','currency','orgname','projectEdit'), 200);

}



public function project_assignuser_app(Request $request,$id) {
     
       $user = JWTAuth::parseToken()->authenticate();

   if($request->isMethod('post')) 
         {
          
          
           $validator = Validator::make($request->all(), [
            
            'conditionrealid' => 'required',
            'timeFrame' => 'required',
             'username'=> 'required',
             'document' => 'required',
             'order' => 'required',
           
        ]);

         if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
           }

             Log::info(json_encode($request->all()));

         $con_id =   $request->conditionrealid; 
                   
        

          $date1 = new DateTime(date('Y-m-d'));
          $date2 = new DateTime($request->timeFrame);

         $diff = $date2->diff($date1);

         $hours = $diff->h;
        $hours = $hours + ($diff->days*24);

          
           $get_doc_condition = DB::table('grc_project_condition_doc')->where('id',$con_id)->first();
           if(isset($get_doc_condition)){
            
            DB::table('grc_project_condition_doc_assign')->where('doc_id',$con_id)->delete();
            DB::table('grc_task')->where('task_condition_status',$con_id)->delete();
            //DB::table('grc_task')->where('project_id',$id)->where('type',$get_doc_condition->doc_type)->delete();


            $documentData = DB::table('grc_project_condition_doc_assign')
                    ->insert([//'category_section' => $request->category,
                              'doc_id' => $con_id,
                              'condition_number' => $get_doc_condition->condition_number,
                              'doc_type' => $get_doc_condition->doc_type,
                              'project_id' => $id,
                              'category_section' => $get_doc_condition->category_section,
                              'user_id' => $request->username,
                              'state_id' => $get_doc_condition->state_id,
                              'sector_name' => $get_doc_condition->sector_name??'',
                              'document_statement' => $request->document,
                              'created_by' =>  $user->id,
                              'modified_by' =>$user->id,
                              'created_date' =>date('Y-m-d H:i:s'),
                              'modified_date' =>date('Y-m-d H:i:s'),
                              'status' => 1,
                              'last_date_task' => $request->timeFrame,
                              'condtion_status' => 2,
                             ]);
         
        $tast_id = DB::table('grc_task')
                              ->insertGetId(['task_name' => $request->document,
                              'user_id' => $request->username,
                              'task_id' => task_increment(),
                              'org_id' => $user->org_id,
                              'project_id' => $id,
                              'state_id' => $get_doc_condition->state_id,
                              'category' => $get_doc_condition->category_section,
                              'sector' => $get_doc_condition->sector_name,
                              'condition_no' => $get_doc_condition->condition_number,
                              'user_id' => $request->username,
                              'type' => $get_doc_condition->doc_type,
                              'estimated_hrs' => $hours??0,
                              'start_date' => date('Y-m-d H:i:s'),
                              'end_date' => $request->timeFrame,
                              'created_by' => $user->id,
                              'modified_by' =>$user->id,
                              'created_date' =>date('Y-m-d H:i:s'),
                              'modified_date' =>date('Y-m-d H:i:s'),
                              'task_status' => 'New',
                              'status' => 1,
                              'task_condition_status' => $con_id,
                             ]);

                  

                              $updaterr = DB::table('grc_relation')
                    ->insert(['project_id' => $id,
                              'org_id' => $user->org_id,
                              'user_id' => $request->username,
                              'task_id' => $tast_id,
                              'created_date' => date('Y-m-d H:i:s'),
                              'modified_date' => date('Y-m-d H:i:s'),
                              'status' => 1
                             ]); 

           

         
                      }
                      
                      }

return response()->json(['status' => 200 ,'msg' => 'Successfully Assing User Condition'], 200);
      
}


 public function additional_projectstage_app(Request $request,$id){

   $user = JWTAuth::parseToken()->authenticate();

      if($request->isMethod('post')) 
         {
           $validator = Validator::make($request->all(), [
            'addCondition' => 'required|max:100',
            
        ]);

        if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
           }
            $count = DB::table('grc_project_additional_condition')->where('stage_name',$request->addCondition)->count();
            // echo $count; die('sdsz');
            if($count == 0){
              
            $documentData = DB::table('grc_project_additional_condition')
                    ->insert(['stage_name' => $request->addCondition,
                              'project_id' => $id,
                              'created_by' => $user->id,
                              'modified_by' =>$user->id,
                              'created_date' =>date('Y-m-d H:i:s'),
                              'modified_date' =>date('Y-m-d H:i:s'),
                              'status' => 1
                             ]);
                  
    

      return response()->json(['status' => 200 ,'msg' => 'Successfully Added'], 200);
     
     
    }else{
     

         return response()->json(['status' => 200 ,'msg' => 'Successfully Not Added'], 200);
    }
  }

      
  }

  function update_stage_app(Request $request,$id){

     $validator = Validator::make($request->all(), [
            'stage' => 'required|max:100',
            
        ]);

        if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
           }

           $update = DB::table('grc_project')->where('id',$id)->update(['project_stage' =>$request->stage]);

           return response()->json(['status' => 200 ,'msg' => 'Successfully Chnage stage'], 200);

  }
    



 function task_delele_app($id){


    $del =   DB::table('grc_task')->where('id',$id)->delete();

    if($del){
      return response()->json(['status' => 200 ,'msg' => 'Task Deleted Successfully'], 200);
    

    }else{

      return response()->json(['status' => 200 ,'msg' => 'Task Not Found'], 200);
    

    }
      

  

    }

    function user_delele_app($id){

      $org = DB::table('grc_organization')->where('org_admin',$id)->count();
       $project = DB::table('grc_project')->where('project_manager',$id)->count();
        $task = DB::table('grc_task')->where('user_id',$id)->count();

        if($org > 0){
          return response()->json(['status' => 400 ,'msg' => 'Organization assgin this user can not be delete'], 400);
        }
         if($project > 0){
          return response()->json(['status' => 400 ,'msg' => 'Project assgin this user can not be delete'], 400);
        }
         if($task > 0){
          return response()->json(['status' => 400 ,'msg' => 'Task assgin this user can not be delete'], 400);
        }

  DB::table('grc_user')->where('id',$id)->delete();
  return response()->json(['status' => 200 ,'msg' => 'Successfully Task Delete'], 200);
  

    }

    public function delete_status_app($id){

  DB::table('grc_status')->where('id',$id)->delete();
      return response()->json(['status' => 200 ,'msg' => 'Successfully Status Delete'], 200);   
}

public function delete_type_app($id){

  DB::table('grc_type')->where('id',$id)->delete();
   return response()->json(['status' => 200 ,'msg' => 'Successfully Type Delete'], 200);   
}    


public function delete_stage_app($id){

  DB::table('grc_stages')->where('id',$id)->delete();
     return response()->json(['status' => 200 ,'msg' => 'Successfully Stage Delete'], 200);   

        
}

public function delete_sector_app($id){

  DB::table('grc_sector')->where('id',$id)->delete();
     return response()->json(['status' => 200 ,'msg' => 'Successfully Sector Delete'], 200);   

        
}



function userlist_app(){

  $user = JWTAuth::parseToken()->authenticate();

  if ($user->role == 'project_Manager') {
        $user_list = DB::table('grc_user')->where('grc_user.role','Employee')->join('alm_countries','grc_user.country','=','alm_countries.id')->join('alm_states','grc_user.state','=','alm_states.id')->join('alm_cities','grc_user.city','=','alm_cities.id')->where('grc_user.created_by',$user->id)->orderBy('grc_user.id', 'desc')->select('grc_user.*','grc_user.desgination as designation','alm_countries.name as country_name','alm_states.name as state_name','alm_cities.name as city_name')->where('grc_user.id','!=',$user->id)->get();

        foreach ($user_list as $key => $user_lists) {
         $user_lists->user_photo = URL::to('uploads_profileimg').'/'.$user_lists->photo;
          $user_lists->dob = date('d/m/Y',strtotime($user_lists->dob));
        }
      }else{
       $user_list = DB::table('grc_user');
       
       if($user->role !='superadmin'){
           $user_list ->where('grc_user.created_by',$user->id);
       }
       $user_list =  $user_list->join('alm_countries','grc_user.country','=','alm_countries.id')->join('alm_states','grc_user.state','=','alm_states.id')->join('alm_cities','grc_user.city','=','alm_cities.id')->whereIN('role',['Employee','project_Manager','admin'])->orderBy('grc_user.id', 'desc')->select('grc_user.*','grc_user.desgination as designation','alm_countries.name as country_name','alm_states.name as state_name','alm_cities.name as city_name')->where('grc_user.id','!=',$user->id)->get();
       foreach ($user_list as $key => $user_lists) {
         $user_lists->user_photo = URL::to('uploads_profileimg').'/'.$user_lists->photo;
          $user_lists->dob = date('d/m/Y',strtotime($user_lists->dob));
        }
      }

       return response()->json(compact('user_list'), 200);   


}


function userlist_pagination_app(Request $request){


  $user = JWTAuth::parseToken()->authenticate();

  if ($user->role == 'project_Manager') {
        $user_list = DB::table('grc_user')->where('grc_user.role','Employee')->join('alm_countries','grc_user.country','=','alm_countries.id')->join('alm_states','grc_user.state','=','alm_states.id')->join('alm_cities','grc_user.city','=','alm_cities.id')->leftjoin('grc_organization','grc_user.org_id','=','grc_organization.id');

if(isset($request->search)){
   $user_list->Where('grc_user.first_name', 'like', '%' . $request->search . '%')->orWhere('grc_user.last_name', 'like', '%' . $request->search . '%');
}

       $user_list = $user_list->where('grc_user.created_by',$user->id)->orderBy('grc_user.id', 'desc')->select('grc_user.*','grc_user.desgination as designation','alm_countries.name as country_name','alm_states.name as state_name','alm_cities.name as city_name','grc_organization.org_name')->where('grc_user.id','!=',$user->id)->paginate(10);

        foreach ($user_list as $key => $user_lists) {
         $user_lists->user_photo = URL::to('uploads_profileimg').'/'.$user_lists->photo;
          $user_lists->dob = date('d/m/Y',strtotime($user_lists->dob));
        }
      }else{
       $user_list = DB::table('grc_user');
       
       if($user->role !='superadmin'){
           $user_list ->where('grc_user.created_by',$user->id);
       }

        if(isset($request->search)){
   $user_list->Where('grc_user.first_name', 'like', '%' . $request->search . '%')->orWhere('grc_user.last_name', 'like', '%' . $request->search . '%');
}

       $user_list =  $user_list->join('alm_countries','grc_user.country','=','alm_countries.id')->join('alm_states','grc_user.state','=','alm_states.id')->join('alm_cities','grc_user.city','=','alm_cities.id')->leftjoin('grc_organization','grc_user.org_id','=','grc_organization.id')->whereIN('role',['Employee','project_Manager','admin'])->orderBy('grc_user.id', 'desc')->select('grc_user.*','grc_user.desgination as designation','alm_countries.name as country_name','alm_states.name as state_name','alm_cities.name as city_name','grc_organization.org_name')->where('grc_user.id','!=',$user->id)->paginate(10);
       foreach ($user_list as $key => $user_lists) {
         $user_lists->user_photo = URL::to('uploads_profileimg').'/'.$user_lists->photo;
          $user_lists->dob = date('d/m/Y',strtotime($user_lists->dob));
        }
      }
       $user_data = [];
      foreach ($user_list as $key => $user_lists) {
       $user_data[] = $user_lists;
      }

     // dd($user_data);

       return response()->json(compact('user_data'), 200);   
}

 public function user_add_app(Request $request){

    $user = JWTAuth::parseToken()->authenticate();
    
   

      //echo $request->org_name; die('fsdfs');
       if($request->isMethod('post')) 
       { 
       // dd($request->all());
       $validator = Validator::make($request->all(), [
            
            'fname' => 'required|max:150',
            
            'lname' => 'required',
           
            'role' => 'required',
            
            'emailaddress' => 'unique:grc_user,email|required|email|max:255',
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
            'profileimage' => 'image|mimes:jpeg,png,jpg,gif|max:2000',
            
        ]);

       if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
           }
      $count = DB::table('grc_user')->select('*')->where('email',$request->emailaddress)->count();
     // dd($count);
            if($count == 0){
              $uniqueID = mt_rand(1000, 9999);
              $autogenerateId = 'EMP-'.$uniqueID;
              
              if($user->role == 'admin'){
                  $pass = 'Admin@'.$uniqueID;
                  $org_id = $user->org_id;
                }else if($user->role == 'project_Manager'){
                  $pass = 'ProjectManager_'.$uniqueID;
                   $org_id = $user->org_id;
                }else{
                  $pass = 'Employee_'.$uniqueID;
                   //$org_id = null;
                   if( $request->role != 'admin'){

                          $validator = Validator::make($request->all(), [
            
                            'org_id' => 'required',
    
                           ]);

       if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
           }

                       $org_id = $request->org_id??null;

                      }else{

                        $org_id = null;

                      }
                }

                //   if(($user->role == 'admin') || ($user->role == 'project_Manager')){
                //     $org = $user->org_id;
                //     }else{
                //       $org = $request->org_name;
                //     }

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

              
            $update = DB::table('grc_user')
                    ->insertGetId(['employee_id' => user_increment(),
                               'org_id' =>  $org_id??'',
                               // 'pro_id' => $request->pro_name??'',
                              'first_name' => $request->fname,
                              'middle_name' => $request->mname??'',
                              'last_name' => $request->lname,
                             
                              'password' => md5($pass),
                              'role' => $request->role,
                              'desgination' => $request->designation,
                              'email' => $request->emailaddress,
                              'alt_email' => $request->alt_emailaddress,
                              'mobile_no' => $request->mobile,
                              'alternate_no' => $request->alternate,
                              'pancard_no' => $request->pancard,
                              'adhaar_card' => $request->adhaar,
                              'dob' => date('Y-m-d',strtotime($request->dob)),
                              'gender' => $request->gender,
                              'photo' => $fileName??'',
                              'country' => $request->country,
                              'state' => $request->state,
                              'city' => $request->city,
                              'pincode' => $request->pincode,
                              'landmark' =>$request->landmark,
                              'address' => $request->address,
                              'created_by' => $user->id,
                              'update_by' => $user->id,
                              
                              'pre_mob' => $request->pre_mob??'',
                              'pre_alt_mob' => $request->pre_alt_mob??'',
                              
                              'created_at' => date('Y-m-d H:i:s'),
                              'updated_at' => date('Y-m-d H:i:s'),
                              'status' => 1
                             ]); 
                             
                            //  if($request->role == 'admin'){
                            //      DB::table('grc_organization')->where('id',$org)->update(['org_admin' =>$update ]);
                            //  }else if($request->role == 'project_Manager'){
                            //         DB::table('grc_project')->where('id',$request->pro_name)->update(['project_manager' =>$update ]);
                            //  }
                            // dd($update);
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
           // $response = $this->verifysendMail($sub,$msg,$to,$from,$fromname);
           // $response = $this->verifysendMail($sub,$msg,$user->email,$from,$fromname);


         $sendEmailId = array($to,$user->email);
            
        MultiSendEmail(array_unique($sendEmailId),$sub,$from,$fromname,$msg);
           
                 
             // $request->session()->flash('org-success', 'Organization add Successfully.');
    
            // return view('superadmin.user_add');
             return response()->json(['msg' => 'User Created Successfully'], 200);
   
            }else{
            return response()->json(['msg' => 'User Already Exist'], 400);
   
            }
          
        }else{
         return response()->json(['msg' => 'Method Not Allow'], 400);
   
      }
    }

    public function user_status_app(Request $request,$id){

       $user = JWTAuth::parseToken()->authenticate();

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
                 
                   <h3 style="color: #fff;  font-size: 18px; text-align: left; margin: 0 0 40px;"> Uses is Deactived: '.$projectstatus->first_name.' '.$projectstatus->last_name.'</h3>
                 
                    
                 
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
            
            
          //   if(isset($userdata->email)){
          //   $response = $this->verifysendMail($sub,$msg,$userdata->email,$from,$fromname);  
          //   }
            
         
          //    if(isset($projectstatus->email)){
          //   $response = $this->verifysendMail($sub,$msg,$projectstatus->email,$from,$fromname);
          // }
          // if(isset($user->email)){
          //   $response = $this->verifysendMail($sub,$msg,$user->email,$from,$fromname);
          // }

            $sendEmailId = array($userdata->email??'',$projectstatus->email??'',$user->email??'');
            
        MultiSendEmail(array_unique($sendEmailId),$sub,$from,$fromname,$msg);

          return response()->json(['status' => 200,'msg' => 'User Activated Successfully'], 200);
    // return view('superadmin.user_list',compact('user_list'));
        }else{
         
             $update = DB::table('grc_user')->where('id',$id)
                    ->update([
                              'status' => 1
                             ]);
                             

                             
                             
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
                 
                   <h3 style="color: #fff;  font-size: 18px; text-align: left; margin: 0 0 40px;"> Uses is Actived: '.$projectstatus->first_name.' '.$projectstatus->last_name.'</h3>
                 
                    
                 
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
            
            
          //   if(isset($userdata->email)){
          //   $response = $this->verifysendMail($sub,$msg,$userdata->email??'',$from,$fromname);
          //   }
          //    if(isset($projectstatus->email)){
          //   $response = $this->verifysendMail($sub,$msg,$projectstatus->email,$from,$fromname);
          // }
          // if(isset($user->email)){
          //   $response = $this->verifysendMail($sub,$msg,$user->email,$from,$fromname);
          // }


              $sendEmailId = array($userdata->email??'',$projectstatus->email??'',$user->email??'');
            
        MultiSendEmail(array_unique($sendEmailId),$sub,$from,$fromname,$msg);


      return response()->json(['status' => 200,'msg' => 'User Deactived Successfully'], 200);
        }
      }else{
        return response()->json(['status' => 200,'msg' => "This project doesn't exist in database"], 200);
        
      }
      
    }

function user_view_app($id){

   $userData = DB::table('grc_user')->select('grc_user.*','grc_user.pincode as upincode','grc_user.landmark as ulandmark','grc_project.project_name','alm_countries.name as county','alm_states.name as state','alm_cities.name as city')
                ->leftjoin('grc_project','grc_user.id','=','grc_project.project_manager')->leftjoin('alm_countries','grc_user.country','=','alm_countries.id')->leftjoin('alm_states','grc_user.state','=','alm_states.id')->leftjoin('alm_cities','grc_user.city','=','alm_cities.id')->where('grc_user.id',$id)->first();

                $userData->designation = $userData->desgination;

 $userData->user_photo = URL::to('uploads_profileimg').'/'.$userData->photo;
                 return response()->json(['status' => 200,'details' => $userData], 200);

}

function country_add_app(Request $request){

   if($request->isMethod('post')) 
       {      
           
           //dd($request->all());
           
        $validator = Validator::make($request->all(), [
            'countryname' => 'required',
            
            
        ]);

         if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
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
          
 
          return response()->json(['status' => 200,'msg' =>'Successfully Add Country' ], 200);
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
      return response()->json(compact('Data','CData','existcountryid'), 200);

     
   }

}

function country_delete_app($id){

        $deletecountry = DB::table('grc_superadmin_country_list')->where('id',$id)->delete();
return response()->json(['status' => 200,'msg' =>'Successfully deleted country' ], 200);

}

function status_management_app(Request $request,$id=null){




        


  $status_list = DB::table('grc_status')->get();
   $status_edit = [];
  if(!empty($id)){

      $validator = Validator::make($request->all(), [
          
            'status' => 'required',
            
            
        ]);

         if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
           }

    $status_edit = DB::table('grc_status')->where('id',$id)->first(); 
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
   return response()->json(['status' => 200,'msg' =>'Successfully Updated' ], 200);

      
  }


     if($request->isMethod('post')) 
       {  

         $validator = Validator::make($request->all(), [
            
            'status' => 'required',
            
            
        ]);

         if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
           }

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

         return response()->json(['status' => 200,'msg' =>'Successfully Added' ], 200);

    }else{
         return response()->json(['status' => 200,'msg' =>'Status Aleady Exist' ], 200);
    }
    }

}

public function stage_management_app(Request $request,$id=null){

   $user = JWTAuth::parseToken()->authenticate();

      $stage_list = DB::table('grc_stages')->get();
      $stage_edit = [];
      if(!empty($id)){
        $stage_edit = DB::table('grc_stages')->where('id',$id)->first();
      }

     

      

      if($request->isMethod('post')) 
       { 


          $validator = Validator::make($request->all(), [
            'stage' => 'required',
           
            
            
        ]);
         if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
           }


         if(!empty($request->stage_id)){
       $update = DB::table('grc_stages')->where('id',$request->stage_id)
                    ->update(['stage_name' => $request->stage,
                              'createdby' => $user->id,
                              'modifiedby' => $user->id,
                              'createdate' => date('Y-m-d H:i:s'),
                              'modifieddate' => date('Y-m-d H:i:s'),
                              'status' => 1
                             ]);
       return response()->json(['status' => 200,'msg' =>'Successfully Updated' ], 200);
       
      }
          $countcurrency = DB::table('grc_stages')->where('stage_name',$request->stage)->count();
          if($countcurrency == 0){
          $update = DB::table('grc_stages')
                    ->insert(['stage_name' => $request->stage,
                              'createdby' => $user->id,
                              'modifiedby' => $user->id,
                              'createdate' => date('Y-m-d H:i:s'),
                              'modifieddate' => date('Y-m-d H:i:s'),
                              'status' => 1
                             ]);
        return response()->json(['status' => 200,'msg' =>'Data add successfully' ], 200);
    
       }else{
         return response()->json(['status' => 200,'msg' =>'Stage already exist' ], 200);
        
       }
    }
    }

   public function type_management_app(Request $request,$id=null){

       $type = DB::table('grc_type')->get();
        $type_edit = [];
       if(!empty($id)){

         $type_edit = DB::table('grc_type')->where('id',$id)->first();

       }

 
       

      if($request->isMethod('post')) 
       { 






          $validator = Validator::make($request->all(), [
            'type_name' => 'required',
            
            
        ]);

       if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
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
       return response()->json(['status' => 200,'msg' =>'Successfully updated' ], 200);
      
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
       return response()->json(['status' => 200,'msg' =>'Data add successfully' ], 200);
      
     
       }else{
          return response()->json(['status' => 200,'msg' =>'Data already exist' ], 200);
      
        
       }
    }
    }



     public function currency_management_app(Request $request,$id=null){

      $currency_list = DB::table('main_currency')->get();
       $currency_edit = [];
      if(!empty($id)){
        $currency_edit = DB::table('main_currency')->where('id',$id)->first(); 
      }

      if($request->isMethod('post')) 
       { 

        $validator = Validator::make($request->all(), [
            'currency' => 'required',
            'currency_code' => 'required',
            
            
        ]);

        if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
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
            return response()->json(['status' => 200,'msg' =>'Successfully Updated' ], 200);
      
        
           
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
       return response()->json(['status' => 200,'msg' =>'Data add successfully' ], 200);
   
       }else{

         return response()->json(['status' => 200,'msg' =>'Currency already exist' ], 200);
   
       
       }
    }
    }

   
   public function sector_management_app(Request $request,$id=null){

$sector_list = DB::table('grc_sector')->get();
$sector_edit = [];


if(!empty($id)){

  $sector_edit  = DB::table('grc_sector')->where('id',$id)->first();


}

 if($request->isMethod('post')) 
       {


         $validator = Validator::make($request->all(), [
            'sector' => 'required',
            
            
        ]);

        if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
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
                      return response()->json(['status' => 200,'msg' =>'Successfully Updated' ], 200);
   

                    
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
          return response()->json(['status' => 200,'msg' =>'Data add successfully' ], 200);
   
      
       }else{
           return response()->json(['status' => 200,'msg' =>'Data already exist' ], 200);
   
      
       }
    }
    }

    function project_sector_app(){

   $sector_name  =   DB::table('grc_sector')->where('status',1)->select('id','sector_name')->get();

     return response()->json(['status' => 200,'sector_name' =>$sector_name], 200);

    }

 public function task_list_app(Request $request){

  $user = JWTAuth::parseToken()->authenticate();

   
          
               if($user->role =='project_Manager'){
       // $pro_list = DB::table('grc_project')->get();
          
        $task_list = DB::table('grc_task')->select('*','grc_task.id as id','grc_user.first_name','grc_user.middle_name','grc_user.last_name','grc_organization.org_name','grc_project.project_name','alm_states.name as state_name','grc_sector.sector_name')
                   ->join('grc_sector','grc_task.sector','=','grc_sector.id')
                   ->join('grc_project','grc_task.project_id','=','grc_project.id')
                   ->join('grc_user','grc_task.user_id','=','grc_user.id')
                   ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')
                   ->join('alm_states','grc_task.state_id','=','alm_states.id')
                   ->where('grc_project.project_manager',$user->id)->orderBy('grc_task.id','desc')
                   ->get();

       

      }elseif($user->role=='admin'){
        //dd(session('org_id'));
        $task_list = DB::table('grc_task')
        ->join('grc_sector','grc_task.sector','=','grc_sector.id')
        ->join('grc_user','grc_task.user_id','=','grc_user.id')
        ->join('grc_project','grc_task.project_id','=','grc_project.id')
        ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')
        ->join('alm_states','grc_task.state_id','=','alm_states.id')
        ->where('grc_task.org_id',$user->org_id)->orderBy('grc_task.id','desc')
        ->select('grc_task.*','grc_user.first_name','grc_user.middle_name','grc_user.last_name','grc_organization.org_name','grc_project.project_name','alm_states.name as state_name','grc_sector.sector_name')->get();

      }elseif($user->role=='employee'){

        $task_list = DB::table('grc_task')
        ->join('grc_sector','grc_task.sector','=','grc_sector.id')
        ->join('grc_user','grc_task.user_id','=','grc_user.id')
        ->join('grc_project','grc_task.project_id','=','grc_project.id')
        ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')
        ->join('alm_states','grc_task.state_id','=','alm_states.id')
        ->where('grc_task.user_id',$user->id)->where('grc_organization.id',$user->org_id)->orderBy('grc_task.id','desc')
        ->select('grc_task.*','grc_user.first_name','grc_user.middle_name','grc_user.last_name','grc_organization.org_name','grc_project.project_name','alm_states.name as state_name','grc_sector.sector_name')->get();

       


           // $task_list = DB::table('grc_task')
           // ->join('grc_user','grc_task.user_id','=','grc_user.id')
           // ->join('grc_project','grc_task.project_id','=','grc_project.id')
           // ->leftjoin('grc_organization','grc_task.org_id','=','grc_organization.id')
           // ->where('grc_task.user_id',session('userId'))->orderBy('grc_task.created_date','desc')
           // ->select('grc_task.*','grc_user.first_name','grc_user.middle_name','grc_user.last_name','grc_organization.org_name','grc_project.project_name')->get();

      }else{
        $task_list = DB::table('grc_task')
        ->join('grc_sector','grc_task.sector','=','grc_sector.id')
        ->join('grc_user','grc_task.user_id','=','grc_user.id')
        ->join('grc_project','grc_task.project_id','=','grc_project.id')
        ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')
        ->join('alm_states','grc_task.state_id','=','alm_states.id')
        ->orderBy('grc_task.id','desc')->select('grc_task.*','grc_user.first_name','grc_user.middle_name','grc_user.last_name','grc_organization.org_name','grc_project.project_name','alm_states.name as state_name','grc_sector.sector_name')->get();
      }
      
      foreach($task_list as $task_lists){
                   $task_lists->start_date = date('d/m/Y',strtotime($task_lists->start_date));
                       $task_lists->end_date = date('d/m/Y',strtotime($task_lists->end_date));
                       $task_lists->user_name = $task_lists->first_name.' '.$task_lists->last_name;
                   }

      if($request->isMethod('post'))
       {
  
     $task_list = [];
 
   $task_list = DB::table('grc_task')->select('grc_task.*','grc_task.id as id','grc_user.first_name','grc_user.middle_name','grc_user.last_name','grc_organization.org_name','grc_project.project_name','grc_sector.sector_name')
                   ->leftjoin('grc_project','grc_task.project_id','=','grc_project.id')
                    ->join('grc_sector','grc_task.sector','=','grc_sector.id')
                   ->leftjoin('grc_user','grc_task.user_id','=','grc_user.id')
                   ->leftjoin('grc_organization','grc_task.org_id','=','grc_organization.id');

                    if($user->role =='project_Manager'){
                   $task_list->where('grc_project.project_manager',$user->id);
                 }else if($user->role=='admin'){
                  $task_list->where('grc_task.org_id',$user->org_id);
                }else if($user->role=='employee'){
                  $task_list->where('grc_task.org_id',$user->org_id);
                }

                   if(!empty($request->tast_id)){
                    
                    $task_list->where('grc_task.task_id', 'like', '%' . $request->tast_id . '%');

                   }
                   
                        if(!empty($request->task_name)){
                    
                 $task_list->where('grc_task.task_name', 'like', '%' . $request->task_name . '%');
                   
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
                   foreach($task_list as $task_lists){
                  $task_lists->start_date = date('d/m/Y',strtotime($task_lists->start_date));
                       $task_lists->end_date = date('d/m/Y',strtotime($task_lists->end_date));
                       $task_lists->user_name = $task_lists->first_name.' '.$task_lists->last_name;
                   }
                  
               
                  return response()->json(compact('task_list'), 200);
                  
       } 

      
     
         return response()->json(compact('task_list'), 200);
       
 
     
    }

    function task_list_pagination(Request $request){



        $user = JWTAuth::parseToken()->authenticate();

   
          
               if($user->role =='project_Manager'){
       // $pro_list = DB::table('grc_project')->get();
          
        $task_list = DB::table('grc_task')->select('*','grc_task.id as id','grc_user.first_name','grc_user.middle_name','grc_user.last_name','grc_organization.org_name','grc_project.project_name','alm_states.name as state_name','grc_sector.sector_name')
                   ->join('grc_sector','grc_task.sector','=','grc_sector.id')
                   ->join('grc_project','grc_task.project_id','=','grc_project.id')
                   ->join('grc_user','grc_task.user_id','=','grc_user.id')
                   ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')
                   ->join('alm_states','grc_task.state_id','=','alm_states.id');

                   if(isset($request->search)){
                     $task_list->where('grc_task.task_name', 'like', '%' . $request->search . '%');
                   }
             $task_list  =    $task_list->where('grc_project.project_manager',$user->id)->orderBy('grc_task.id','desc')
                   ->paginate(10);

       

      }elseif($user->role=='admin'){
        //dd(session('org_id'));
        $task_list = DB::table('grc_task')
        ->join('grc_sector','grc_task.sector','=','grc_sector.id')
        ->join('grc_user','grc_task.user_id','=','grc_user.id')
        ->join('grc_project','grc_task.project_id','=','grc_project.id')
        ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')
        ->join('alm_states','grc_task.state_id','=','alm_states.id');

       if(isset($request->search)){
                     $task_list->where('grc_task.task_name', 'like', '%' . $request->search . '%');
                   }

    $task_list   =  $task_list ->where('grc_task.org_id',$user->org_id)->orderBy('grc_task.id','desc')
        ->select('grc_task.*','grc_user.first_name','grc_user.middle_name','grc_user.last_name','grc_organization.org_name','grc_project.project_name','alm_states.name as state_name','grc_sector.sector_name')->paginate(10);

      }elseif($user->role=='employee'){

        $task_list = DB::table('grc_task')
        ->join('grc_sector','grc_task.sector','=','grc_sector.id')
        ->join('grc_user','grc_task.user_id','=','grc_user.id')
        ->join('grc_project','grc_task.project_id','=','grc_project.id')
        ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')
        ->join('alm_states','grc_task.state_id','=','alm_states.id');
          if(isset($request->search)){
                     $task_list->where('grc_task.task_name', 'like', '%' . $request->search . '%');
                   }

        $task_list   =  $task_list->where('grc_task.user_id',$user->id)->where('grc_organization.id',$user->org_id)->orderBy('grc_task.id','desc')
        ->select('grc_task.*','grc_user.first_name','grc_user.middle_name','grc_user.last_name','grc_organization.org_name','grc_project.project_name','alm_states.name as state_name','grc_sector.sector_name')->paginate(10);

       

      }else{
        $task_list = DB::table('grc_task')
        ->join('grc_sector','grc_task.sector','=','grc_sector.id')
        ->leftjoin('grc_user','grc_task.user_id','=','grc_user.id')
        ->join('grc_project','grc_task.project_id','=','grc_project.id')
        ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')
        ->join('alm_states','grc_task.state_id','=','alm_states.id');
              if(isset($request->search)){
                     $task_list->where('grc_task.task_name', 'like', '%' . $request->search . '%');
                   }
         $task_list   =  $task_list->orderBy('grc_task.id','desc')->select('grc_task.*','grc_user.first_name','grc_user.middle_name','grc_user.last_name','grc_organization.org_name','grc_project.project_name','alm_states.name as state_name','grc_sector.sector_name')->paginate(10);
      }
      
      foreach($task_list as $task_lists){
                   $task_lists->start_date = date('d/m/Y',strtotime($task_lists->start_date));
                       $task_lists->end_date = date('d/m/Y',strtotime($task_lists->end_date));
                       $task_lists->user_name = $task_lists->first_name.' '.$task_lists->last_name;
                   }
                   $task_data = [];
                   foreach ($task_list as $key => $task_lists) {
                     $task_data[] = $task_lists;
                   }


     return response()->json(compact('task_data'), 200);
    }

    function task_export_app(){


      $user = JWTAuth::parseToken()->authenticate();

   
          
               if($user->role =='project_Manager'){
       // $pro_list = DB::table('grc_project')->get();
          
        $task_list = DB::table('grc_task')->select('*','grc_task.id as id','grc_user.first_name','grc_user.middle_name','grc_user.last_name','grc_organization.org_name','grc_project.project_name','alm_states.name as state_name','grc_sector.sector_name')
                   ->join('grc_sector','grc_task.sector','=','grc_sector.id')
                   ->join('grc_project','grc_task.project_id','=','grc_project.id')
                   ->join('grc_user','grc_task.user_id','=','grc_user.id')
                   ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')
                   ->join('alm_states','grc_task.state_id','=','alm_states.id')
                   ->where('grc_project.project_manager',$user->id)->orderBy('grc_task.id','desc')
                   ->get();

       

      }elseif($user->role=='admin'){
        //dd(session('org_id'));
        $task_list = DB::table('grc_task')
        ->join('grc_sector','grc_task.sector','=','grc_sector.id')
        ->join('grc_user','grc_task.user_id','=','grc_user.id')
        ->join('grc_project','grc_task.project_id','=','grc_project.id')
        ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')
        ->join('alm_states','grc_task.state_id','=','alm_states.id')
        ->where('grc_task.org_id',$user->org_id)->orderBy('grc_task.id','desc')
        ->select('grc_task.*','grc_user.first_name','grc_user.middle_name','grc_user.last_name','grc_organization.org_name','grc_project.project_name','alm_states.name as state_name','grc_sector.sector_name')->get();

      }elseif($user->role=='employee'){

        $task_list = DB::table('grc_task')
        ->join('grc_sector','grc_task.sector','=','grc_sector.id')
        ->join('grc_user','grc_task.user_id','=','grc_user.id')
        ->join('grc_project','grc_task.project_id','=','grc_project.id')
        ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')
        ->join('alm_states','grc_task.state_id','=','alm_states.id')
        ->where('grc_task.user_id',$user->id)->where('grc_organization.id',$user->org_id)->orderBy('grc_task.id','desc')
        ->select('grc_task.*','grc_user.first_name','grc_user.middle_name','grc_user.last_name','grc_organization.org_name','grc_project.project_name','alm_states.name as state_name','grc_sector.sector_name')->get();

       


           // $task_list = DB::table('grc_task')
           // ->join('grc_user','grc_task.user_id','=','grc_user.id')
           // ->join('grc_project','grc_task.project_id','=','grc_project.id')
           // ->leftjoin('grc_organization','grc_task.org_id','=','grc_organization.id')
           // ->where('grc_task.user_id',session('userId'))->orderBy('grc_task.created_date','desc')
           // ->select('grc_task.*','grc_user.first_name','grc_user.middle_name','grc_user.last_name','grc_organization.org_name','grc_project.project_name')->get();

      }else{
        $task_list = DB::table('grc_task')
        ->join('grc_sector','grc_task.sector','=','grc_sector.id')
        ->leftjoin('grc_user','grc_task.user_id','=','grc_user.id')
        ->join('grc_project','grc_task.project_id','=','grc_project.id')
        ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')
        ->join('alm_states','grc_task.state_id','=','alm_states.id')
        ->orderBy('grc_task.id','desc')->select('grc_task.*','grc_user.first_name','grc_user.middle_name','grc_user.last_name','grc_organization.org_name','grc_project.project_name','alm_states.name as state_name','grc_sector.sector_name')->get();
      }
      
      foreach($task_list as $task_lists){
                   $task_lists->start_date = date('d/m/Y',strtotime($task_lists->start_date));
                       $task_lists->end_date = date('d/m/Y',strtotime($task_lists->end_date));
                       $task_lists->user_name = $task_lists->first_name.' '.$task_lists->last_name;
                   }

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


       
       $file_name = str_replace(public_path(), URL::to('/'), $filename);


 return response()->json(['status' => 200,'link' => $file_name ], 200);



    }

    function export_csv_app(){

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


       $file_name = str_replace(public_path(), URL::to('/'), $filename);


 return response()->json(['status' => 200,'link' => $file_name ], 200);




      }catch(Exception $e){

        return response()->json(['status' => 400,'msg' => $e->getMessage() ], 400);
      }

    }


 function csv_data(){

   $user = JWTAuth::parseToken()->authenticate();

    $org_list = DB::table('grc_organization');

    if($user->role != 'superadmin'){
              $org_list->where('id',$user->org_id); 
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
                  //  $project->probability =  $remark->Probability??null;
                       
                         
                     }
                     
        
                     

                  
               }
           
     }


     return $org_list;


    }




    function task_user_list_app(){

         $user = JWTAuth::parseToken()->authenticate();

         $user_emp = DB::table('grc_user')->where('role','employee')->where('status',1);
         if($user->role !='superadmin'){
           $user_emp->where('created_by',$user->id);
         }

         $user_emp = $user_emp->select('id','first_name','last_name')->get();
         foreach($user_emp as $user_emps){
             $user_emps->user_name = $user_emps->first_name .' '. $user_emps->last_name;
         }

          return response()->json(compact('user_emp'), 200);

    }


    function task_edit_app(Request $request,$id){

 $user = JWTAuth::parseToken()->authenticate();



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
            
            
        ]);

         if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
           }





$uniqueID = mt_rand(1000, 9999);
              $autogenerateId = 'TSK-'.$uniqueID;
              
             $getorg = DB::table('grc_project')->where('id',$request->projectId)->first();
             
             $org_id = $getorg->organization_id??'';

              DB::table('notification')
              ->insert([
                        'user_id' => $user->id,
                        'org_id' => $org_id,
                        'msg' => 'Edit Task '.$request->taskname,
                        'created_by' => $user->id,
                       
                       ]);  

            $taskadd = DB::table('grc_task')->where('id',$id)
                    ->update(['project_id' => $request->projectId,
                              
                              'task_name' => $request->taskname,
                              'condition_no' => $request->conditionno,
                              'category' => $request->category,
                              'type' => $request->tasktype,
                              'sector' => $request->sector,
                              'user_id' =>$request->user_name,
                              'state_id' => $request->projectstate,
                              'description' => $request->taskDescription,
                              'estimated_hrs' => $request->estimatedhours,
                              'start_date' => date('Y-m-d',strtotime($request->startdate)),
                              'end_date' => date('Y-m-d',strtotime($request->endDate)),
                              'task_status' => $request->taskstatus,
                              'created_by' => $user->id,
                              'modified_by' => $user->id,
                              'created_date' => date('Y-m-d H:i:s'),
                              'modified_date' => date('Y-m-d H:i:s'),
                              'status' => 1
                             ]);


 return response()->json(['status' => 200,'msg' => 'Task Updated Successfully'], 200);



    }


    }


     public function task_add_app(Request $request){

        $user = JWTAuth::parseToken()->authenticate();

   
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
            
            
        ]);

         if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
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
                        'user_id' => $user->id,
                        'org_id' => $org_id,
                        'msg' => 'Created Task '.$request->taskname,
                        'created_by' => $user->id,
                       
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
                              'start_date' => date('Y-m-d',strtotime($request->startdate)),
                              'end_date' => date('Y-m-d',strtotime($request->endDate)),
                              'task_status' => $request->taskstatus,
                              'created_by' => $user->id,
                              'modified_by' => $user->id,
                              'created_date' => date('Y-m-d H:i:s'),
                              'modified_date' => date('Y-m-d H:i:s'),
                              'status' => 1
                             ]);

                    // $taskid = DB::getPdo()->lastInsertId();
                     $update = DB::table('grc_relation')
                    ->insert(['project_id' => $request->projectId,
                              'org_id' => $user->org_id,
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
      
      
      
      $getuserEmp = DB::table('grc_user')->where('org_id',$org_id)->where('id',$request->user_name)->where('role','employee')->first();
      
         if(isset($getuserEmp->email)){
             
              $EMPemail = $getuserEmp->email;
             
             
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
          //  $to = $useremail;
            $sub = "Task Assign";
            $from = "dsaini@kloudrac.com";
            $fromname = "Not_To_Reply";
           // $response = $this->sendMail($sub,$msg,$EMPemail,$from,$fromname);
           // $response = $this->sendMail($sub,$msg,session('email'),$from,$fromname);
            
         $sendEmailId = array(session('email'),$EMPemail);
            
        MultiSendEmail(array_unique($sendEmailId),$sub,$from,$fromname,$msg);
             
         }
        
         return response()->json(['status' => 200,'msg' => 'Task Created Successfully'], 200);

     
       }else{
      return response()->json(['status' => 200,'msg' => 'Task Already Exist'], 200);

     
    }
    }
  }

  function task_details_app($id){
     $taskdoc = array();
      $task_remarklist = DB::table('grc_task_remarks')->select('*','grc_task_remarks.created_date as cdate')
                 ->Join('grc_project_task_document','grc_task_remarks.id','=','grc_project_task_document.task_remark_id')
                ->where('grc_task_remarks.task_id',$id)->orderby('grc_task_remarks.created_date','DESC')->get();
if(!isset( $task_remarklist )){
 return response()->json(['status' => 400,'msg' => 'Task not found'], 400);
}


      foreach ($task_remarklist as $value) {
         $tdoc['document'] = !empty($value->document)?URL::to('/uploads_remarkdoc/'.$value->document):'';
         $tdoc['task_remark'] = isset($value->task_remark)?$value->task_remark:'';
          $tdoc['hints'] = isset($value->hints)?$value->hints:'';
         $tdoc['task_status'] = isset($value->task_status)?$value->task_status:'';
         $tdoc['figure_at_site'] = isset($value->figure_at_site)? str_replace('\n', '<br/>', $value->figure_at_site):'';
         $tdoc['actual_at_site'] = isset($value->actual_at_site)?str_replace('\n', '<br/>', $value->actual_at_site):'';
         $tdoc['Probability'] = isset($value->Probability)?$value->Probability:'';
         $tdoc['cdate'] = isset($value->cdate)?$value->cdate:'';
         $taskdoc[] = $tdoc;
      }
        

    
        $task_list = DB::table('grc_task')->join('grc_user','grc_task.user_id','=','grc_user.id')->where('grc_task.id',$id)->select('grc_task.*','grc_user.first_name','grc_user.last_name')->first();
        $projectshow = DB::table('grc_project')->leftjoin('grc_task','grc_project.id','=','grc_task.project_id')->where('grc_task.id',$id)->select('grc_project.project_name')->first();
        
        if(!isset( $task_list )){
 return response()->json(['status' => 400,'msg' => 'Task not found'], 400);
}

     
        
        $task_list->task_name = isset($task_list->task_name)?$task_list->task_name:'';
          $task_list->condition_no = isset($task_list->condition_no)?$task_list->condition_no:'';
        $task_list->estimated_hrs = isset($task_list->estimated_hrs)?$task_list->estimated_hrs:'';
        $task_list->end_date = isset($task_list->end_date)?$task_list->end_date:'';
        $task_list->task_status = isset($task_list->task_status)?$task_list->task_status:'';
        $task_list->Probability = isset($task_list->Probability)?$task_list->Probability:'';
        $task_list->user_id = isset($task_list->user_id)?$task_list->user_id:'';
        $task_list->user_name = isset($task_list->first_name)?$task_list->first_name.' '.$task_list->last_name:'';
       $task_list->figure  =  isset($task_list->figure)? str_replace("\n", '<br/>', $task_list->figure):'';
   
     $task_list->actual  =   isset($task_list->actual)?str_replace("\n", '<br/>', $task_list->actual):'';

        $taskData = $task_list;

        $hints = DB::table('task_hints')->where('task_id',$id)->get();
         $hints_attach = DB::table('task_files')->where('task_id',$id)->get();
         foreach ($hints_attach as $key => $hints_attachs) {
            $hints_attachs->attch_file = URl::to('attachement/'.$hints_attachs->files);
         }

         return response()->json(compact('taskData','id','taskdoc','projectshow','hints','hints_attach'), 200);
       // echo "<pre>"; print_r($taskData); die('sdfd');
      
  }


   public function task_remark_update_app(Request $request,$id){

       $user = JWTAuth::parseToken()->authenticate();

       if($request->isMethod('post'))
       { 

      //  dd($request->all());

        $validator = Validator::make($request->all(), [
            'taskRemarks' => 'required',
            'taskstatus' => 'required',
            'pro' => 'required',
           // 'figuresite' => 'required',
          //  'actualsite' => 'required',
            
            // 'task_upload' => 'required |max:10000',
            // 'task_upload.*' => 'mimes:jpg,jpeg,png,gif,bmp',

            
        ]);

 if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
           }

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
                              'hints' => $request->hints??'',
                              'user_id' => $user->id,
                              'figure_at_site' => $request->figuresite??'',
                              'actual_at_site' => $request->actualsite??'',
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
                              'user_id' => $user->id,
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
            
            $getuser = DB::table('grc_user')->where('org_id',$task_list->org_id)->where('id',$task_list->user_id)->get();
            
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
           // $response = $this->sendMail($sub,$msg,$user->email,$from,$fromname);
            
                  $sendEmailId = array($getuser->email,$user->email);
            
               $response =   MultiSendEmail(array_unique($sendEmailId),$sub,$from,$fromname,$msg);
            if($response){
              echo "Mail Send";
            }else{
              echo "Mail not send";
            }
            
        }
        
          return response()->json(['status' =>200,'msg'=>'Task Remark Added Successfully'],200);
         
                   }else{
                      return response()->json(['status' =>200,'msg'=>'Data already exist'],200);
         
                   
                   }
     }
    }



function organization_delete($id){


   $org = DB::table('grc_organization')->where('id',$id)->first(); 

   DB::table('grc_user')->where('org_id',$org->id)->delete();
   DB::table('grc_project')->where('organization_id',$org->id)->delete();
   DB::table('grc_task')->where('org_id',$org->id)->delete();

  DB::table('grc_organization')->where('id',$id)->delete();

   return response()->json(['status' =>200,'msg'=>'Delete successfully'],200);
         


}

function user_delete_app($id){

 $user  = DB::table('grc_user')->where('id',$id)->first();

 DB::table('grc_project')->where('project_manager',$user->id)->delete();
   DB::table('grc_task')->where('user_id',$user->id)->delete();

      return response()->json(['status' =>200,'msg'=>'Delete successfully'],200);
         

}


      public function myprofile_app(){

     $user = JWTAuth::parseToken()->authenticate();

      $userprofile = DB::table('grc_user')->select('*','alm_countries.name as country_name','alm_states.name as state_name','alm_cities.name as city_name')
                                   ->leftjoin('alm_countries','grc_user.country','=','alm_countries.id')
                                   ->leftjoin('alm_states','grc_user.state','=','alm_states.id')
                                   ->leftjoin('alm_cities','grc_user.city','=','alm_cities.id')
                                   ->where('grc_user.id',$user->id)->where('grc_user.status', 1)->first(); 
        $userprofile->user_photo = URL::to('/uploads_profileimg').'/'.$userprofile->photo;
        $userprofile->designation = $userprofile->desgination;
 
     return response()->json(['status' =>200,'profile' => $userprofile ],200);
     
    }

    function myprofile_edit_app(Request $request,$id){


$user = JWTAuth::parseToken()->authenticate();

  


          if($request->isMethod('post'))
       {

         $validator = Validator::make($request->all(), [
            
            'fname' => 'required|max:150',
            
            'lname' => 'required',
           
            'role' => 'required',
            
            'emailaddress' => 'required|email|max:255',
            'mobile' => 'required',
             'address' => 'required',
            'pancard' => 'required',
            'adhaar' => 'required|max:12',
            'dob' => 'required',
            'gender' => 'required',
            
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pincode' => 'required|max:6',
            
            'address' => 'required',
            // 'profileimage' => 'required|image|mimes:jpeg,png,jpg,gif|max:200',
            
        ]);

       if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
           }
          
           Log::info(json_encode($request->all()));
     
         $userupdate = DB::table('grc_user')->where('id',$id)->count();
        if($userupdate == 1){
            
             if ($request->file('profilepic')) {
                    $destinationPath = public_path('uploads_profileimg');
                    $extension = $request->file('profilepic')->getClientOriginalExtension();
                    $fileName = uniqid().'.'.$extension;
                    $request->file('profilepic')->move($destinationPath, $fileName);
                      $taskadd = DB::table('grc_user')->where('id',$id)
                    ->update([
                               //'org_id' => $org,
                              
                              'first_name' => $request->fname,
                              'middle_name' => $request->mname??'',
                              'last_name' => $request->lname,
                             
                             
                              'role' => $request->role,
                              'desgination' => $request->designation,
                              'email' => $request->emailaddress,
                              'alt_email' => $request->alt_emailaddress,
                              'mobile_no' => $request->mobile,
                              'alternate_no' => $request->alternate,
                              'pancard_no' => $request->pancard,
                              'adhaar_card' => $request->adhaar,
                              'dob' => date('Y-m-d',strtotime($request->dob)),
                              'gender' => $request->gender,
                              'photo' => $fileName??'',
                              'country' => $request->country,
                              'state' => $request->state,
                              'city' => $request->city,
                              'pincode' => $request->pincode,
                              'landmark' =>$request->landmark,
                              'address' => $request->address,
                              'created_by' => $user->id,
                              'update_by' => $user->id,
                              
                              'pre_mob' => $request->pre_mob??'',
                              'pre_alt_mob' => $request->pre_alt_mob??'',
                              
                              'updated_at' => date('Y-m-d H:i:s'),
                              
                             ]); 



                      


                }else{
                     $taskadd = DB::table('grc_user')->where('id',$id)
                    ->update([
                               //'org_id' => $org,
                              
                              'first_name' => $request->fname,
                              'middle_name' => $request->mname??'',
                              'last_name' => $request->lname,
                             
                             
                              'role' => $request->role,
                              'desgination' => $request->designation,
                              'email' => $request->emailaddress,
                              'alt_email' => $request->alt_emailaddress,
                              'mobile_no' => $request->mobile,
                              'alternate_no' => $request->alternate,
                              'pancard_no' => $request->pancard,
                              'adhaar_card' => $request->adhaar,
                              'dob' => date('Y-m-d',strtotime($request->dob)),
                              'gender' => $request->gender,
                            
                              'country' => $request->country,
                              'state' => $request->state,
                              'city' => $request->city,
                              'pincode' => $request->pincode,
                              'landmark' =>$request->landmark,
                              'address' => $request->address,
                              'created_by' => $user->id,
                              'update_by' => $user->id,
                              
                               'pre_mob' => $request->pre_mob??'',
                              'pre_alt_mob' => $request->pre_alt_mob??'',
                              
                              
                              'updated_at' => date('Y-m-d H:i:s'),
                              
                             ]); 
                }
            
                DB::table('notification')
                ->insert([
                          'user_id' => $user->id,
                          'org_id' => $user->org_id,
                          'msg' => 'Edit  User '.$request->fname,
                          'created_by' => $user->id,
                         
                         ]); 
        
                   
           
         return response()->json(['status' => 200,'msg' => 'Profile Updated Successfully'], 200);
    
        }else{
            return response()->json(['status' => 200,'msg' => 'Profile Not Exist'], 200);
        }

      }

      }

    


    public function organizationlist_search(Request $request) {

     $orglist = DB::table('grc_organization')
            ->select('*','grc_organization.id as organizationid')
            ->join('alm_countries','grc_organization.country','=','alm_countries.id')
             ->join('grc_user','grc_user.id','=','grc_organization.org_admin')->join('alm_states','grc_organization.state','=','alm_states.id')->join('alm_cities','grc_organization.city','=','alm_cities.id');

            if(isset($request->org_id)){
             $orglist->where('grc_organization.org_unique_id', 'like', '%' . $request->org_id . '%'); 
            }

              if(isset($request->org_name)){
             $orglist->where('grc_organization.org_name', 'like', '%' . $request->org_name . '%'); 
            }

               if(isset($request->org_email)){
             $orglist->where('grc_organization.org_email', 'like', '%' . $request->org_email . '%'); 
            }


               if(isset($request->org_status)){
             $orglist->where('grc_organization.org_status', 'like', '%' . $request->org_status . '%'); 
            }

              if(isset($request->last_date)){
             $orglist->where('grc_organization.created_date', 'like', '%' . $request->last_date . '%'); 
            }


              if(isset($request->org_country)){
             $orglist->where('alm_countries.name', 'like', '%' . $request->org_country . '%'); 
            }

          $orglist  = $orglist->orderBy('created_date','desc')->select('grc_organization.*','grc_user.first_name','grc_user.last_name','alm_countries.name as country_name','alm_states.name as state_name','alm_cities.name as city_name')->get();

          foreach ($orglist as $key => $orglists) {
           $orglists->org_pic = URL::to('/org_uploads').'/'.$orglists->logo;
             $orglists->status_name = ($orglists->status==1)?'Active':'Inactive';
              $orglists->admin_name = $orglists->first_name.' '.$orglists->last_name;
          }

       return response()->json(['status' =>200,'org_list' => $orglist ],200);
      
     
    }

    function notification_app(){

       $user = JWTAuth::parseToken()->authenticate();

       $pre_date = date('Y-m-d', strtotime('-7 days'));

       $notification = DB::table('notification');
       if($user->role != 'superadmin'){
        $notification->where('org_id',$user->org_id);
       }

       $notification->where(DB::raw("(DATE_FORMAT(notification.created_at,'%Y-%m-%d'))"), ">=", $pre_date);

      

         $notification = $notification->where(DB::raw("(DATE_FORMAT(notification.created_at,'%Y-%m-%d'))"), ">=", $pre_date)->orderby('id','DESC')->get();

          $count =  $notification->where('view',0)->count();

          return response()->json(['status' =>200,'noti_count' => $count,'noti_list' =>  $notification ],200);


    }

    function view_notification_app(){


       $user = JWTAuth::parseToken()->authenticate();

      

       $notification = DB::table('notification');
       if($user->role != 'superadmin'){
        $notification->where('org_id',$user->org_id);
       }

        $notification->where('view',0);
         $notification = $notification->get();


          
         foreach ($notification as $key => $notifications) {
         DB::table('notification')->where('id',$notifications->id)->update(['view' => 1]);
         }

          $pre_date = date('Y-m-d', strtotime('-7 days'));

       $notification = DB::table('notification');
       if($user->role != 'superadmin'){
        $notification->where('org_id',$user->org_id);
       }

       $notification->where(DB::raw("(DATE_FORMAT(notification.created_at,'%Y-%m-%d'))"), "<=", $pre_date);
       $notification->where('view',0);
       $count =  $notification->count();


     return response()->json(['status' =>200,'noti_count' => $count],200);



    }
    

    public function contact_us(Request $request){


    if($request->isMethod('post')) 
         {
         
         $validator = Validator::make($request->all(), [
            'user_name' => 'required',
             'mobile' => 'required',
              'email' => 'required|email',
               'message' => 'required',
            
           
        ]);

        if ($validator->fails()) {
       return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
         
      }   

         $msg = '<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
  border: 1px solid black;
}
</style>
</head>
<body>

<h1>Contact us</h1>

<table>
  <tr>
    <th>USer Name</th>
    <th>'.$request->user_name.'</th>
  </tr>
  <tr>
    <td>Email</td>
    <td>'.$request->email.'</td>
  </tr>
  <tr>
    <td>Mobile No</td>
    <td>'.$request->mobile.'</td>
  </tr>
  <tr>
    <td>Message</td>
    <td>'.$request->message.'</td>
  </tr>
</table>

</body>
</html>
';

            $to = ['Taxi4divine@gmail.com','upretinisa0@gmail.com'];
            $sub = "Contact us";
            $from = "usrivastava@kloudrac.com";
            $fromname = "NOT_To_Reply";
            $response = $this->verifysendMail($sub,$msg,$to,$from,$fromname);
             return response()->json(['msg' => 'Successfully Send  Your Email'], 200);
           
}else{


   return response()->json(['msg' => 'Method Not Allow'], 200);
           

}
           

    }


public function forgot_password(Request $request){


	 $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            
           
        ]);

        if ($validator->fails()) {
    return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
         
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
            $from = "usrivastava@kloudrac.com";
            $fromname = "NOT_To_Reply";
            $response = $this->verifysendMail($sub,$msg,$to,$from,$fromname);
            


            return response()->json(['msg' => 'Email Has Sent Successfully'], 200);
        //else{
            //Session::put('find_mail', 2);
           // return view('forget.email'); 
           }else{
            //Session::put('find_mail', 2);
           return response()->json(['msg' => 'Email Id is Not Registered '], 200);
           }
       
}


public function change_password(Request $request){


            
	         if(!isset($request->user_id) && empty($request->user_id)){
             return response()->json(['msg' => 'User id Not Found'], 400);
           }

            $user_id = $request->user_id;
     

        	  $user = DB::table('grc_user')->where('id', $user_id)->first();
      if(!isset($user)){
         
           return response()->json(['msg' => 'User Invalid'], 400);
      }

            $user = DB::table('grc_user')->where('id', $user_id)->first();
            $useremail = $user->email;
            $count = DB::table('grc_user')->where('id', $user_id)->count();


      //$email = $request->email;
        $password = $request->newpassword;
        $password_confirmation = $request->repeatpassword;

        if($password  != $password_confirmation){

        	 return response()->json(['msg' => 'Password Not Match'], 400);
        }

            //print_r($user); echo $user->token; die('tttt');
           
            if($count > 0){
               // $user_token = $user->remember_token;
              
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
                               <img src="http://wrello.com/public/uploads/wrello_2.png">
                              </td>
                            </tr>
                         
                         <tr>
                          <td style=" background:#fff; vertical-align: bottom; margin0; padding:0;">
                           <div style="padding: 22px;  position:relative; float: left; width: 100%; box-sizing: border-box;">

                            <div style="float:left; width:100%;">
                             <div style="width:688px; margin:52px auto;">
                             <div style="float: left; background: #3CC6ED none repeat scroll 0% 0%; padding: 55px 45px 35px; margin-bottom: 50px;">
                              <h3 style="color: rgb(0, 0, 0); font-family: Tahoma,sans-serif; font-size: 20px; line-height: 25px; margin-top: 0;">Welcome to Wrello,</h3>
                              
                               <p style="color: #fff; font-family: helvetica,sans-serif; font-size: 17px; line-height: 22px; margin: 0  0 25px; text-align: left;">This notice confirms that your password was changed on Wrello.<br> If you did not change your password, please contact the Site Administrator.</p>
                               
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


                   return response()->json(['msg' => 'Successfully Change Password'], 200);
                }
                else{
                    return response()->json(['msg' => 'User NOt Found'], 400);
                }
  
}

function country(){

   $get_country = DB::table('alm_countries')->get();
   return response()->json(['country_list' => $get_country], 200);
}
function country_app(){

 //  $get_country = DB::table('alm_countries')->get();

$get_country = DB::table('grc_superadmin_country_list')->join('alm_countries','grc_superadmin_country_list.country_id','=','alm_countries.id')->get();

foreach ($get_country as $key => $get_countrys) {
  $get_countrys->country_name = $get_countrys->name;
}

   return response()->json(['country_list' => $get_country], 200);
}

function state_app(Request $request){

   $validator = Validator::make($request->all(), [
            'country_id' => 'required',
             
        ]);

        if ($validator->fails()) {
    return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
         
      }
           

  $get_state = DB::table('alm_states')->where('country_id',$request->country_id)->get();
   return response()->json(['state_list' => $get_state], 200);

}

function city_app(Request $request){

   $validator = Validator::make($request->all(), [
            'state_id' => 'required',
             
        ]);

        if ($validator->fails()) {
    return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
         
      }
           

  $get_city = DB::table('alm_cities')->where('state_id',$request->state_id)->get();
   return response()->json(['city_list' => $get_city], 200);

}

function project_status_app(){

  $project_status = DB::table('grc_status')->where('status',1)->select('id','status_name')->get();

   return response()->json(['status' => 200,'project_status'=> $project_status], 200);

  
}

function org_admin_app(){

   $user = JWTAuth::parseToken()->authenticate();

   $adminname = DB::table('grc_user')->where('role','admin')->where('status', 1)->get();
   $amdin = [];
   foreach ($adminname as $key => $adminnames) {
    if($adminnames->org_id == ''){

     $amdin[] = $adminnames;
    }
   }
    
   return response()->json(['admin_list' => $amdin], 200);
}

function task_status_app($id){

  $user = JWTAuth::parseToken()->authenticate();

    $task = DB::table('grc_task')->where('id',$id)->first();

    if(!isset( $task )){
      return response()->json(['status' => 200,'msg'=> 'Task Not found'], 400);
    }
    if($task->status == 1){

      DB::table('notification')
          ->insert([
                    'user_id' => $user->id,
                    'org_id' => $task->id,
                    'msg' => 'DeActive Task '.$task->task_name,
                    'created_by' => $user->id,
                   
                   ]); 
        
        $s = 0;

          DB::table('grc_user')->where('id',$task->user_id)->update(['status' =>$s]);
         $update = DB::table('grc_task')->where('id',$id)->update(['status' =>$s]);
    
    return response()->json(['status' => 200,'msg'=> 'Task Deactivated Successfully'], 200);
    }else{
           $s = 1;

           DB::table('notification')
          ->insert([
                    'user_id' => $user->id,
                    'org_id' => $task->id,
                    'msg' => 'Active Task '.$task->task_name,
                    'created_by' => $user->id,
                   
                   ]); 
     DB::table('grc_user')->where('id',$task->user_id)->update(['status' =>$s]);      
    $update = DB::table('grc_task')->where('id',$id)->update(['status' =>$s]);
    
     return response()->json(['status' => 200,'msg'=> 'Task Activated Successfully'], 200);
        
    }
}

function attach_file_app(Request $request){


   $validator = Validator::make($request->all(), [
           'attfile' => 'mimes:jpeg,jpg,png,gif|required|max:10000' // max 10000kb
            
           
        ]);

        if ($validator->fails()) {
    return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
         
      }


      if($request->hasFile('attfile')) {
           $file = $request->file('attfile');

           $getFileExt   = $file->getClientOriginalExtension();
          $uploadedFile =   time().'.'.$getFileExt;
          $name = time().$uploadedFile;
           $file->move(public_path().'attachement/', $name);
           $attachmentfile = URL::to('/').'attachement/'. $name;
           return response()->json(['status' => 200, 'Attfile' => $attachmentfile]);
        }
}

function document_app(Request $request){

        if($request->isMethod('post'))
       {


        $validator = Validator::make($request->all(), [
           'stateid' => 'required',
           'sectorid' => 'required',
            
           
        ]);

        if ($validator->fails()) {
    return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
         
      }


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

    
        return response()->json(['status' => 200, 'data' => $data],200);

       }else{

        $docData1 = DB::table('grc_document')->where('type','EC')->get();
      $docData2 = DB::table('grc_document')->where('type','CTO')->get();
      $docData3 = DB::table('grc_document')->where('type','CTE')->get();
      $docData4 = DB::table('grc_document')->where('type','GB')->get(); 
     
      return response()->json(compact('docData1','docData2','docData3','docData4'),200);

       }

}



  function org_projectlist(Request $request){
          
           $projectlist = DB::table('grc_project')
         ->join('alm_states','grc_project.state','=','alm_states.id')
         ->join('alm_cities','grc_project.city','=','alm_cities.id')
         ->join('main_currency','grc_project.currency_id','=','main_currency.id')
         ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')
         ->join('grc_sector','grc_project.sector','=','grc_sector.id')
         ->join('grc_user','grc_project.project_manager','=','grc_user.id');
         
            if(isset($request->org_id)){

             $projectlist->where('grc_project.organization_id', $request->org_id);

          
         }
         
           $project =  $projectlist->orderBy('grc_project.created_date','desc')->select('grc_project.*','alm_states.name as state_name','alm_cities.name as city_name','main_currency.currencyname','grc_organization.org_name as organization','grc_sector.sector_name','grc_user.first_name','grc_user.last_name')->get();

         
          return response()->json(compact('project'),200);
          
      }



function report_app(Request $request){



    $user = JWTAuth::parseToken()->authenticate();

      $validator = Validator::make($request->all(), [
           'projectdropdown' => 'required',
            'typeofreport' => 'required',
           'condition' => 'required',
           'orgdropdown' => 'required',
            
           
        ]);



        if ($validator->fails()) {
    return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
         
      }

    $role = $user->role;
    $userId = $user->id;
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
   
  

     $projecReport = DB::table('grc_project')->where('id','=',$request->projectdropdown)->where('status',1);

    
  
   

     $projectReportlist =  $projecReport->get();
 
$arr = array();
     
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
      

     }
     
    $projectReportlists->task   =  $projectReportlistsall->where('project_id',$projectReportlists->id)->where('status',1)->get();


    foreach ($projectReportlists->task as $key => $taskdata) {

              $remark = DB::table('grc_task_remarks')->where('task_id',$taskdata->id)->orderBy('grc_task_remarks.id', 'desc')->first();



           $document = DB::table('grc_project_task_document')->where('task_id',$taskdata->id)->orderBy('grc_project_task_document.id', 'desc')->first();


    $val['task_id'] = $taskdata->task_id;
    $val['task_name'] = $taskdata->task_name;
    $val['doc_type'] = $taskdata->type;
    $val['status'] = $remark->task_status??'NEW';
    $val['task_remark'] = $remark->task_remark??'No Remarks';
    $val['probability'] =$remark->Probability??'0%';
    if(isset($document->document) && !empty($document->document)){
      $doc = explode('|',$document->document);
      $val['attachement'] = URL::to('uploads_remarkdoc/').'/'.$doc[0];
    }else{

      $val['attachement'] = null;

    }

    $arr[] = $val;
      
    }

}





   
  //   $task_con = DB::table('grc_project')
  //   ->select('grc_project_condition_doc.*','grc_project.project_name','grc_task.task_name','grc_task_remarks.task_remark','grc_task_remarks.task_status as remark_status','grc_task_remarks.Probability','grc_project_task_document.document as attachement','grc_task_remarks.task_id','grc_task.task_id as task_unique_id')
    
  //    ->join('grc_project_condition_doc','grc_project.id','=','grc_project_condition_doc.project_id')
  //    ->join('grc_task', function($join) {
  //                   $join->on('grc_project.id', '=', 'grc_task.project_id')->groupBy('grc_task.task_name');
  //               })


  //   ->join('grc_task_remarks', function($join) {
  //                   $join->on('grc_task.id', '=', 'grc_task_remarks.task_id')->orderby('grc_task_remarks.id','DESC')->groupBy('grc_task_remarks.task_id');
  //               })

  //   ->join('grc_project_task_document', function($join) {
  //                   $join->on('grc_task_remarks.id', '=', 'grc_project_task_document.task_remark_id')->orderby('grc_project_task_document.id','DESC')->groupBy('grc_project_task_document.task_id');
  //               })

   
  //   ->where('grc_project.id',$request->projectdropdown);

  //   if($request->typeofreport == 'monthlyreport'){
           
           

  //   $task_con->where(DB::raw("(DATE_FORMAT(grc_task.created_date,'%Y-%m'))"), ">=", $curentdatae);
       
       
         
  //    }else{

  //     $task_con ->whereBetween(DB::raw("(DATE_FORMAT(grc_task.created_date,'%Y-%m'))"), [$sixmonthpreviews, $curentdatae]);
   

  //    }

  //     if($request->condition != 'all'){
  //     $task_con->where('grc_task.type',$request->condition);
  //     }
     
  //    //$task_con->groupBy('grc_task.task_name');
     
  // $task_con  = $task_con->get();

  // foreach ($task_con as $key => $task_cons) {
  //  if(isset($task_cons->attachement)){
  //     $task_cons->attachement = URL::to('uploads_remarkdoc/').'/'.$task_cons->attachement;

  //  }else{

  //     $task_cons->attachement = null;

  //  }
 
  // }
    
    
     return response()->json(['project' =>  $projectlist,'project_report' => $arr],200);

}

function report_org_project_list(Request $request){

   $validator = Validator::make($request->all(), [
           'org_id' => 'required',
             
        ]);

    if ($validator->fails()) {
    return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
         
      }

      $project_list = DB::table('grc_project')->where('organization_id',$request->org_id)->select('id','project_name')->get();

       return response()->json(['project_list' =>  $project_list],200);

}

function pdf_app(Request $request){

  $validator = Validator::make($request->all(), [
           'projectdropdown' => 'required',
           'typeofreport' => 'required',
           'condition' => 'required',         
        ]);

    if ($validator->fails()) {
    return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
         
      }

      try{

         $data = $this->report_data_to_html($request->projectdropdown,$request->typeofreport,$request->condition);

         $customPaper = array(0,0,720,700);
        
        // Send data to the view using loadView function of PDF facade
    $pdf = PDF::loadView('superadmin.report_templete',['report' => $data,'type_report' => $request->typeofreport])->setPaper($customPaper, 'landscape');
    // If you want to store the generated pdf to the server then you can use the store function
    $pdf->save(public_path($data[0]->project_name).'.pdf');
   // $pdf->save(public_path($pdfpath));
    // Finally, you can download the file using download function
   // return $pdf->download($data[0]->project_name.'.pdf');

       
      $full_pdf =  URL::to($data[0]->project_name.'.pdf');

     return response()->json(['status' => 200,'link'=> $full_pdf ], 200);
     }catch(Exception $e){

         return response()->json(['status' => 400,'error'=> 'Something Went to Worng'], 400);
      }

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
     
     
     $projectReportlists->Generic_task  = $taskallGeneric->where('grc_task.project_id',$projectReportlists->id)->where('grc_task.status',1)->where('grc_task.category','Generic')->get();

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
     
     
     $projectReportlists->Specific_task  = $taskallSpecific->where('grc_task.project_id',$projectReportlists->id)->where('grc_task.status',1)->where('grc_task.category','Specific')->get();


   
     
      foreach ($projectReportlists->Specific_task as $key => $taskdetails) {

      $taskdetails->Specific_tast_document = DB::table('grc_project_task_document')->where('task_id',$taskdetails->id)->get();
      
     }
   

    
   
   
    }
    
      return $projectReportlist;

  }



function report_data_to_html_list(Request $request)
    {
      

        $validator = Validator::make($request->all(), [
           'projectdropdown' => 'required',
           'typeofreport' => 'required',
           'condition' => 'required',         
        ]);

    if ($validator->fails()) {
    return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
         
      }
        

        $projectid = $request->projectdropdown;

        $setmonth = $request->typeofreport;

        $contition = $request->condition;


      $curentdatae= date('Y-m');

     $sixmonthpreviews = date('Y-m',strtotime('-6 months'));

      $projecReport = DB::table('grc_project')->where('id','=',$projectid)->where('status',1);

     if($contition != 'all'){
      $projecReport->where('project_stage',$contition);
     }

    

     $projectReportlist =  $projecReport->get();

   foreach ($projectReportlist as $key => $projectReportlists) {

    $projectReportlists->condiction = DB::table('grc_project_condition_doc')->where('project_id',$projectReportlists->id)->get();

      $taskall = DB::table('grc_task');
     
      if($setmonth == 'monthlyreport'){

       $taskall->where(DB::raw("(DATE_FORMAT(grc_task.created_date,'%Y-%m'))"), ">=", $curentdatae);
       
        //  if($contition != 'All'){
        // $taskall->where('grc_task.type',$contition);
        //  }
         
         
     }else{

       $taskall->whereBetween(DB::raw("(DATE_FORMAT(grc_task.created_date,'%Y-%m'))"), [$sixmonthpreviews, $curentdatae]);
       
        // if($contition != 'All'){
        //     $taskall->where('grc_task.type',$contition);
        //  }

     }
     
     
     $projectReportlists->task  = $taskall->where('project_id',$projectReportlists->id)->where('status',1)->get();

     foreach ($projectReportlists->task as $key => $taskdetails) {

      $taskdetails->tast_document = DB::table('grc_project_task_document')->where('task_id',$taskdetails->id)->get();
      
     }
   
     $output = '<table width="100%" style="border-collapse: collapse; border: 0px;"
                                        >
                                        <thead>
                                            <tr>
                                               <th style="border: 1px solid; padding:12px;" width="10%">S. No.</th>
                                                <th style="border: 1px solid; padding:12px;" width="10%">Task ID</th>
                                                <th style="border: 1px solid; padding:12px;" width="10%">Condition</th>
                                                <th style="border: 1px solid; padding:12px;" width="20%">Compliance</th>
                                                <th style="border: 1px solid; padding:12px;" width="10%">Status of Compliance</th>
                                                <th style="border: 1px solid; padding:12px;" width="10%">probability</th>
                                                <th style="border: 1px solid; padding:12px;" width="30%">Attachments</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
     $html = '';
      $i = 1;

     foreach ($projectReportlist as  $project) {
  
       foreach ($project->task as  $taskall) {


      
                                          $remark = DB::table('grc_task_remarks')->where('task_id',$taskall->id)->orderBy('grc_task_remarks.id', 'desc')->first();

                                           

                                            if(isset($remark->task_remark) && !empty($remark->task_remark)){
                                                  $task_remark  = $remark->task_remark;
                                            }else{

                                              $task_remark = '&nbsp;';

                                            }
                                            if(isset($remark->task_status) && !empty($remark->task_status)){
                                                  $task_status  = $remark->task_status;
                                            }else{

                                              $task_status = '&nbsp;';

                                            }

                                            if(isset($remark->Probability) && !empty($remark->Probability)){
                                                  $Probability  = $remark->Probability;
                                            }else{

                                              $Probability = '&nbsp;';

                                            }
                                            
                                              $keyword = 1; 
                                             if(isset($taskall->tast_document) && !empty($taskall->tast_document)){
                                               
                                              foreach ($taskall->tast_document as $ke => $document) {
                                               if(isset($document->document) && !empty($document->document)){
                                                  $document  = $document->document;
                                                           
                                                 foreach(explode('|',$document) as $doc){        

                                                  $info = pathinfo(public_path('/uploads_remarkdoc/').$doc);
                                                    $ext = $info['extension'];
                                                   
                                                   if($ext == 'gif' || $ext == 'png' || $ext == 'bmp'|| $ext == 'jpeg'|| $ext == 'jpg' || $ext == 'PNG' || $ext == 'GIF' || $ext == 'JPG'){

                                                     

                                                     $html .=' <h5>Annexure '.$i.'.'.$keyword++.'</h5><p ><img width="100%" src="'.public_path('/uploads_remarkdoc/'.$doc) .'"></p>';

                                                   }else{

                                                     $html .='&nbsp;';

                                                   }
                                               }
                                                 

                                            }else{

                                              $document = '&nbsp;';

                                            }
                                          
                                              }
                                               
                                             }
                                            
                                           

         $output .= ' <tr>
                                         <td style="border: 1px solid; padding:12px;" width="10%">'.$i.'</td>
                                        <td style="border: 1px solid; padding:12px;" width="10%">'.$taskall->task_id.'</td>
                                                <td style="border: 1px solid; padding:12px;" width="20%">'.$taskall->task_name.'</td>
                                                <td style="border: 1px solid; padding:12px;" width="10%"> '.$task_remark.'</td>
                                                <td style="border: 1px solid; padding:12px;" width="10%">'. $task_status.'</td>
                                                <td style="border: 1px solid; padding:12px;" width="10%">'.$Probability.'</td>';
                                                  $output .= '<td style="border: 1px solid; padding:12px;" width="30%"> <ul>';
                                                      
                                                   if(isset($taskall->tast_document) && !empty($taskall->tast_document)){
                                                    $keyword = 1;
                                              foreach ($taskall->tast_document as $key => $document) {
                                               if(isset($document->document) && !empty($document->document)){
                                                $document  = $document->document;
                                                     
                                                 foreach(explode('|',$document) as $doc){    
                                                 $output .= '<li> Annexure '.$i.'.'.$keyword++.'</li>';
                                                 } 

                                                }

                                              

                                               
                                              }

                                            }
                                               
                                             
                                              $output .= '</ul></td></tr>';

                                              $i++;
                                             
                                             
       }
     }

    
     $output .= ' </tbody></table>';
      $output .=  $html;
     //dd($output);
    // return $output;

      return response()->json(['status' => 200,'data'=> $output], 200);
    }

}



function import_csv_data_app(Request $request){

    
     $validator = Validator::make($request->all(), [
           'task_upload' => 'required',
           'selectcategory' => 'required',
           'selectstate' => 'required',
           'selectsector' => 'required',
         
        ]);

    if ($validator->fails()) {
    return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
         
      }


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

   //  dd($importData_arr);

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

          return response()->json(['status' => 400,'msg'=> 'please remove this special charactor'], 400);
       // dd($ex);
       // report($ex);
       // return false;
          }
            
            //dd($insertData);

           return response()->json(['status' => 200,'msg'=> 'Conditions Uploaded Successfully'], 200);
         
        }else{
        
     return response()->json(['status' => 400,'msg'=> 'File too large. file must be less than 2MB.'], 400);
        }

      }else{
   
         return response()->json(['status' => 400,'msg'=> 'Invalid file extension'], 400);
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

function getorganisation_app($role){
  if(!isset($role)){

    return response()->json(['status' => 400, 'msg' => 'Role not found']);

  }

 if($role == 'admin') {
      
      $getornationlist = Db::table('grc_organization')->orWhereNull('org_admin')->select('id','org_name')->get();
      
  }elseif($role == 'project_Manager'){
      
       $getornationlist = Db::table('grc_organization')->select('id','org_name')->get();
      
  }else{
      
      $getornationlist = Db::table('grc_organization')->select('id','org_name')->get();
      
  }
  
  
  return response()->json(['status' => 200, 'data' => $getornationlist]);


}

function getoproject_app(){


    $user = JWTAuth::parseToken()->authenticate();

  $project = [];

  $project = Db::table('grc_project');
  if($user->role != 'superadmin'){
     $project ->where('organization_id',$user->org_id);
  }
  
   $project  = $project->select('id','project_name')->get();


     return response()->json(['status' => 200, 'data' => $project]);

}


function getcondition_app($project_id){
    if(!isset($project_id)){

    return response()->json(['status' => 400, 'msg' => 'Project id not found']);

  }

  $getconfition = DB::table('grc_project_additional_condition')->where('grc_project_additional_condition.project_id',$project_id)->get();
   $predifine = DB::table('grc_project_condition_doc')->join('grc_user','grc_user.id','=','grc_project_condition_doc.user_id')->where('project_id',$project_id)->select('grc_project_condition_doc.*','grc_user.first_name','grc_user.last_name')->get();

   foreach ($predifine as $key => $predifines) {
    
       $assign_con = DB::table('grc_project_condition_doc_assign')->join('grc_user','grc_project_condition_doc_assign.user_id','=','grc_user.id')->where('grc_project_condition_doc_assign.doc_id',$predifines->id)->select('grc_project_condition_doc_assign.*','grc_user.first_name','grc_user.last_name')->first();

                  if(isset($assign_con)){

        $predifines->assign_condition_number = $assign_con->condition_number??'';
       $predifines->assign_user_id = $assign_con->user_id??'';
       $predifines->assign_user_name = $assign_con->first_name??''.' '.$assign_con->last_name??'';
        $predifines->assign_last_date_task = $assign_con->last_date_task??'';



                  }
                 

   }
    return response()->json(['status' => 200, 'customedata' => $getconfition,'predifine' => $predifine ]);
    
}

function custome_getoproject_app($project_id){

  $getconfition = DB::table('grc_project_additional_condition')->where('project_id',$project_id)->get();

  foreach ($getconfition as $key => $getconfitions) {

     $getconfitions->condition = DB::table('grc_project_condition_doc')->join('grc_user','grc_user.id','=','grc_project_condition_doc.user_id')->where('grc_project_condition_doc.project_id',$project_id)->where('grc_project_condition_doc.doc_type',$getconfitions->stage_name)->select('grc_project_condition_doc.*','grc_user.first_name','grc_user.last_name')->get();

     foreach ($getconfitions->condition as $key => $con) {
      
       $assign_con = DB::table('grc_project_condition_doc_assign')->join('grc_user','grc_project_condition_doc_assign.user_id','=','grc_user.id')->where('grc_project_condition_doc_assign.doc_id',$con->id)->select('grc_project_condition_doc_assign.*','grc_user.first_name','grc_user.last_name')->first();

                  if(isset($assign_con)){

        $con->assign_condition_number = $assign_con->condition_number??'';
       $con->assign_user_id = $assign_con->user_id??'';
       $con->assign_user_name = $assign_con->first_name??''.' '.$assign_con->last_name??'';
        $con->assign_last_date_task = $assign_con->last_date_task??'';



                  }

     }
   
  }

     return response()->json(['status' => 200, 'customedata' => $getconfition ]);

}


function user_edit_app(Request $request){


$user = JWTAuth::parseToken()->authenticate();

  


          if($request->isMethod('post'))
       {

          $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'fname' => 'required',
            'lname' => 'required',
            'phonenumber' => 'required',
            'dob' => 'required',
            'landmark' => 'required',
            'gender' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            //'photo' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
            'pincode' => 'required',



            
        ]);

           if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
           }

           $id =   $request->user_id;
     
         $userupdate = DB::table('grc_user')->where('id',$id)->count();
        if($userupdate == 1){
            
             if ($request->file('profilepic')) {
                    $destinationPath = public_path('uploads_profileimg');
                    $extension = $request->file('profilepic')->getClientOriginalExtension();
                    $fileName = uniqid().'.'.$extension;
                    $request->file('profilepic')->move($destinationPath, $fileName);
                      $taskadd = DB::table('grc_user')->where('id',$id)
                    ->update([
                              'first_name' => $request->fname,
                              'last_name' => $request->lname,
                              'mobile_no' =>$request->phonenumber,
                              'dob' => date('Y-m-d',strtotime($request->dob)),
                              'landmark' => $request->landmark,
                              'gender' => $request->gender,
                              'country' => $request->country,
                              'state' => $request->state,
                              'city' => $request->city,
                              'photo' =>$fileName,
                              'pincode'=> $request->pincode,
                              //'created_at' => date('Y-m-d H:i:s'),
                              'updated_at' => date('Y-m-d H:i:s')
                             ]); 
                }
            
                DB::table('notification')
                ->insert([
                          'user_id' => $user->id,
                          'org_id' => $user->org_id,
                          'msg' => 'Edit  User '.$request->fname,
                          'created_by' => $user->id,
                         
                         ]); 
        
                   
           
         return response()->json(['status' => 200,'msg' => 'User successfully updated'], 200);
    
        }else{
            return response()->json(['status' => 200,'msg' => 'User Not Exist'], 200);
        }

      }


}

function user_role_list_app(){

  $user = JWTAuth::parseToken()->authenticate();
  $data = [];
  if($user->role = 'superadmin'){

    $data = ['admin' => 'Admin','project_Manager' => 'Project Manager','employee' => 'User'];

  
  }else{

     $data = ['project_Manager' => 'Project Manager','employee' => 'User'];


  }

  return response()->json(['status' => 200,'data' => $data ], 200);
  
  
}


 public function circulars_app(Request $request){

 
  $user = JWTAuth::parseToken()->authenticate();

      if($request->isMethod('post'))
       {
         $validator = Validator::make($request->all(), [
            'addCircular' => 'required',
            'circularimage' => 'max:10000'
            
        ]);
         if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
           }

        if($request->hasFile('circularimage')) {
          $file = $request->file('circularimage');
         
          
          $getFileExt   = $file->getClientOriginalExtension();
          $uploadedFile =   time().'.'.$getFileExt;
          $name = time().$uploadedFile;
          $path = public_path('/attachement');
          
         $file->move($path, $name);
         $fileName = $name;
       // dd($fileName);
          }else{

            $fileName = '';

          }


           DB::table('notification')
              ->insert([
                        'user_id' => $user->id,
                        'org_id' => $user->org_id,
                        'msg' => 'Created Circular '.$request->addCircular,
                        'created_by' => $user->id,
                       
                       ]);  


        
                     $update = DB::table('grc_circular')
                    ->insert(['circular_name' => $request->addCircular,
                    'attachment' => $fileName,
                              'created_by' => $user->id,
                              'org_id' => $user->org_id,
                              'created_date' => date('Y-m-d H:i:s'),
                              'modified_date' => date('Y-m-d H:i:s'),
                              'status' => 1
                             ]); 
             
                 return response()->json(['status' => 200,'msg' => 'Circular Created  Successfully' ], 200);
  
  
              //$updateData = DB::table('grc_circular')->get();      
                   // return view('superadmin.circular',compact('updateData'));
       }else{
          $updateData = DB::table('grc_circular');
       

       if(session('role') != 'superadmin'){
              $updateData->where('org_id',$user->org_id); 
          }



         $updateData = $updateData->orderBy('id','DESC')->get();  
        
         return response()->json(['status' => 200,'data' => $updateData ], 200);
       }
      
    }

    function circulars_date_rage_app(Request $request){

       $updateData = DB::table('grc_circular');

           if(isset($request->dateStart) && isset($request->dateEnd)){
               
                        $sdate = str_replace('/', '-', $request->dateStart);
                        $statdate =  date('Y-m-d', strtotime($sdate));
                        
                         $edate = str_replace('/', '-', $request->dateEnd);
                        $enddate =  date('Y-m-d', strtotime($edate));
               
             $updateData->whereBetween(DB::raw("(DATE_FORMAT(grc_circular.created_date,'%Y-%m-%d'))"), [$statdate,$enddate]);; 
          }


         $updateData = $updateData->orderBy('id','DESC')->get();  
        
         return response()->json(['status' => 200,'data' => $updateData ], 200);

    }

     public function circulars_delete_app(Request $request,$id){
     
        $updateDataas = DB::table('grc_circular')->where('id',$id)->delete();
                    
       return response()->json(['status' => 200,'msg' => ' Circular Deleted Successfully' ], 200);
     
      
    }


     public function changepass_app(Request $request){

      $user = JWTAuth::parseToken()->authenticate();
         $userId = $user->id;

          $messages = [
          'min'      => 'New Password must have minimum :min characters',
        ];
      
       
         $db_pass =  $user->password; 
         if($request->isMethod('post')) {

          $validator = Validator::make($request->all(), [
            'opwd' => 'required|min:6',
            'npwd' => 'required|min:6',
            'cpwd' => 'required|min:6',
           
            
        ],$messages);
         if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
           }


           $opwd = $request->opwd;
            $npwd = $request->npwd;
            $cpwd = $request->cpwd;
            
           if ((md5($opwd) == $db_pass)) {

             
                 if($npwd==$cpwd)
                {
                    $update = DB::table('grc_user')
                    ->where('id',$userId)
                    ->update(['password' => md5($npwd),
                    ]); 
                     

               return response()->json(['status' => 200,'msg' => 'Password changed Successfully' ], 200);
                      
                }else{
                   

       return response()->json(['status' => 400,'msg' => 'New password and Confirm password does not match' ], 400);

                    }
        }else{
                    

    return response()->json(['status' => 400,'msg' => 'Current Password does not match' ], 400);
            }
        }
    
     
    }


    function create_custome_condition_app(Request $request,$id){


      $user = JWTAuth::parseToken()->authenticate();

            $validator = Validator::make($request->all(), [
            'addCondition' => '|required',
          
            
        ]);
         if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
           }

               Log::info(json_encode($request->all()));

      if(DB::table('grc_project_additional_condition')->where('project_id',$id)->where('stage_name',$request->addCondition)->count() == 0){


  $documentData = DB::table('grc_project_additional_condition')
                    ->insert(['stage_name' => $request->addCondition,
                              'project_id' => $id,
                              'created_by' => $user->id,
                              'modified_by' =>$user->id,
                              'created_date' =>date('Y-m-d H:i:s'),
                              'modified_date' =>date('Y-m-d H:i:s'),
                              'status' => 1
                             ]);

      }else{

            return response()->json(['status' => 400,'msg' => 'Condition Already Exist' ], 400);

      }


    return response()->json(['status' => 200,'msg' => 'Successfully Added' ], 200);
                  

    }

    function project_form_list(){

      $array = DB::table('project_form_list')->get();

        return response()->json(['status' => 200,'form_list' => $array ], 200);
  
   
   
    }

    function project_form_file_list($id){

       $array = DB::table('project_form_list')->get();




        foreach ($array as $key => $value) {
          $att_doc = [];
         $projectdoc = DB::table('project_document')->where('project_id',$id)->where('category',$value->id)->get();
         if(isset($projectdoc)){

             foreach ($projectdoc as $key => $projectdocs) {
           $projectdocs->doc_file = URL::to('/uploads/').'/'.$projectdocs->document;
            }
       
         }
      
         $value->doc_details = $projectdoc;
        }
       
        return response()->json(['status' => 200,'form_list' => $array ], 200);

    }

    function project_form_file_delete($id){

       $projectdoc = DB::table('project_document')->where('id',$id)->delete();

       return response()->json(['status' => 200,'msg' => 'Successfully Project file Delete' ], 200);

    }

    function org_export(){

        $orglist = DB::table('grc_organization')
            // ->select('*','grc_organization.id as organizationid')
            // ->leftjoin('alm_countries','grc_organization.country','=','alm_countries.id');

            ->leftjoin('alm_countries','grc_organization.country','=','alm_countries.id')
            ->leftjoin('alm_states','grc_organization.state','=','alm_states.id')
            ->leftjoin('alm_cities','grc_organization.city','=','alm_cities.id')
             ->leftjoin('grc_user','grc_organization.org_admin','=','grc_user.id')
            ->orderBy('grc_organization.id','desc')
              ->select('*','grc_organization.id as organizationid');


              $orglist  = $orglist->orderBy('grc_organization.id','desc')->get();
     
          


     
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

       $file_name = str_replace(public_path(), URL::to('/'), $filename);


 return response()->json(['status' => 200,'link' => $file_name ], 200);

      
    




    }

    function project_export(){

   $user = JWTAuth::parseToken()->authenticate();

         if( $user->role == 'project_Manager'){
        $projectlist = DB::table('grc_project')
        ->join('alm_states','grc_project.state','=','alm_states.id')
        ->join('alm_cities','grc_project.city','=','alm_cities.id')
        ->join('main_currency','grc_project.currency_id','=','main_currency.id')
        ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')
        ->join('grc_sector','grc_project.sector','=','grc_sector.id')
        ->join('grc_user','grc_project.project_manager','=','grc_user.id')


        ->where('grc_project.project_manager',$user->id);

         if(isset($request->projectid)){

        //  $projectlist->where('project_id',$request->projectid);
             $projectlist->where('grc_project.project_id', 'like', '%' . $request->projectid . '%');

         }
          if(isset($request->projectname)){

             $projectlist->where('grc_project.project_name', 'like', '%' . $request->projectname . '%');

          
         }
          if(isset($request->projecttype)){

              $projectlist->where('grc_project.project_type',$request->projecttype);
          
         }
          if(isset($request->projectstatus)){

             $projectlist->where('grc_project.project_status',$request->projectstatus);
          
         }


          if(isset($request->org_id)){

             $projectlist->where('grc_project.organization_id',$request->org_id);
          
         }

                
      }elseif($user->role == 'admin'){
          
          
          
        $projectlist = DB::table('grc_project')->leftjoin('alm_states','grc_project.state','=','alm_states.id')->leftjoin('alm_cities','grc_project.city','=','alm_cities.id')->leftjoin('main_currency','grc_project.currency_id','=','main_currency.id')->join('grc_organization','grc_project.organization_id','=','grc_organization.id')->leftjoin('grc_sector','grc_project.sector','=','grc_sector.id')->join('grc_user','grc_project.project_manager','=','grc_user.id')->where('grc_project.organization_id',$user->org_id);
                        if(isset($request->projectid)){

        //  $projectlist->where('project_id',$request->projectid);
             $projectlist->where('grc_project.project_id', 'like', '%' . $request->projectid . '%');

         }
          if(isset($request->projectname)){

             $projectlist->where('grc_project.project_name', 'like', '%' . $request->projectname . '%');

          
         }
          if(isset($request->projecttype)){

              $projectlist->where('grc_project.project_type',$request->projecttype);
          
         }
          if(isset($request->projectstatus)){

             $projectlist->where('grc_project.project_status',$request->projectstatus);
          
         }




                 
      }elseif($user->role == 'employee'){


            $project = [];
       $task_list = DB::table('grc_task')->where('user_id',$user->id)->get();
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
       

      
        // $projectlist = DB::table('grc_project')
        // ->join('alm_states','grc_project.state','=','alm_states.id')
        // ->join('alm_cities','grc_project.city','=','alm_cities.id')
        // ->join('main_currency','grc_project.currency_id','=','main_currency.id')
        // ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')
        // ->join('grc_sector','grc_project.sector','=','grc_sector.id')
        // ->join('grc_user','grc_project.project_manager','=','grc_user.id')
        //  ->leftjoin('grc_task','grc_project.id','=','grc_task.project_id')
        // ->where('grc_task.user_id',$user->id);


                        if(isset($request->projectid)){

        //  $projectlist->where('project_id',$request->projectid);
             $projectlist->where('grc_project.project_id', 'like', '%' . $request->projectid . '%');

         }
          if(isset($request->projectname)){

             $projectlist->where('grc_project.project_name', 'like', '%' . $request->projectname . '%');

          
         }
          if(isset($request->projecttype)){

              $projectlist->where('grc_project.project_type',$request->projecttype);
          
         }
          if(isset($request->projectstatus)){

             $projectlist->where('grc_project.project_status',$request->projectstatus);
          
         }

                 
      }else{
         $projectlist = DB::table('grc_project')
         ->join('alm_states','grc_project.state','=','alm_states.id')
         ->join('alm_cities','grc_project.city','=','alm_cities.id')
         ->join('main_currency','grc_project.currency_id','=','main_currency.id')
         ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')
         ->join('grc_sector','grc_project.sector','=','grc_sector.id')
         ->join('grc_user','grc_project.project_manager','=','grc_user.id');
                         if(isset($request->projectid)){

        //  $projectlist->where('project_id',$request->projectid);
             $projectlist->where('grc_project.project_id', 'like', '%' . $request->projectid . '%');

         }
          if(isset($request->projectname)){

             $projectlist->where('grc_project.project_name', 'like', '%' . $request->projectname . '%');

          
         }


              if(isset($request->org_id)){

             $projectlist->where('grc_project.organization_id', $request->org_id);

          
         }


          if(isset($request->projecttype)){

              $projectlist->where('grc_project.project_type',$request->projecttype);
          
         }
          if(isset($request->projectstatus)){

             $projectlist->where('grc_project.project_status',$request->projectstatus);
          
         }
                 
      }

       if(isset($request->org_id)){

             $projectlist->where('grc_project.organization_id',$request->org_id);
          
         }


        if(isset($request->dateStart) && isset($request->dateEnd)){
             $projectlist->whereBetween(DB::raw("(DATE_FORMAT(grc_project.created_date,'%Y-%m-%d'))"), [$request->dateStart, $request->dateEnd]);; 
          }

        $project =  $projectlist->orderBy('grc_project.created_date','desc')->select('grc_project.*','alm_states.name as state_name','alm_cities.name as city_name','main_currency.currencyname','grc_organization.org_name as organization','grc_sector.sector_name','grc_user.first_name','grc_user.last_name')->get();
   foreach($project as $projects){
       $projects->project_manager_name =  $projects->first_name .' '. $projects->last_name;
   }

    
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

        $file_name = str_replace(public_path(), URL::to('/'), $filename);


 return response()->json(['status' => 200,'link' => $file_name ], 200);



    }

    function user_export(){


  $user = JWTAuth::parseToken()->authenticate();

  if ($user->role == 'project_Manager') {
        $user_list = DB::table('grc_user')->where('grc_user.role','Employee')->join('alm_countries','grc_user.country','=','alm_countries.id')->join('alm_states','grc_user.state','=','alm_states.id')->join('alm_cities','grc_user.city','=','alm_cities.id')->where('grc_user.created_by',$user->id)->orderBy('grc_user.id', 'desc')->select('grc_user.*','grc_user.desgination as designation','alm_countries.name as country_name','alm_states.name as state_name','alm_cities.name as city_name')->where('grc_user.id','!=',$user->id)->get();

        foreach ($user_list as $key => $user_lists) {
         $user_lists->user_photo = URL::to('uploads_profileimg').'/'.$user_lists->photo;
          $user_lists->dob = date('d/m/Y',strtotime($user_lists->dob));
        }
      }else{
       $user_list = DB::table('grc_user');
       
       if($user->role !='superadmin'){
           $user_list ->where('grc_user.created_by',$user->id);
       }
       $user_list =  $user_list->join('alm_countries','grc_user.country','=','alm_countries.id')->join('alm_states','grc_user.state','=','alm_states.id')->join('alm_cities','grc_user.city','=','alm_cities.id')->whereIN('role',['Employee','project_Manager','admin'])->orderBy('updated_at', 'desc')->select('grc_user.*','grc_user.desgination as designation','alm_countries.name as country_name','alm_states.name as state_name','alm_cities.name as city_name')->where('grc_user.id','!=',$user->id)->get();
       foreach ($user_list as $key => $user_lists) {
         $user_lists->user_photo = URL::to('uploads_profileimg').'/'.$user_lists->photo;
          $user_lists->dob = date('d/m/Y',strtotime($user_lists->dob));
        }
      }



    $columns = array('S.No', 'EMP Code', 'First Name', 'last Name', 'Email','Phone','Role');

    
    $filename = public_path("uploads/csv/user_'".time()."'_report.csv");
    $handle = fopen($filename, 'w+');
    fputcsv($handle, $columns);

         $i = 1;
        foreach($user_list as $user_datas) {

           fputcsv($handle, array($i++, 'EMP-'.$user_datas->employee_id,ucwords($user_datas->first_name),ucwords($user_datas->last_name),$user_datas->email,$user_datas->mobile_no,$user_datas->role));
        }
        
       fclose($handle);

       $headers = array(
        'Content-Type' => 'text/csv'
       
        );

       $file_name = str_replace(public_path(), URL::to('/'), $filename);


 return response()->json(['status' => 200,'link' => $file_name ], 200);



    }


    function document_export(Request $request){


        $user = JWTAuth::parseToken()->authenticate();

            $validator = Validator::make($request->all(), [
            'state_id' => 'required',
            'sector_id' => 'required'
          
            
        ]);
         if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
           }

           $stateid = $request->state_id;
           $sectorid = $request->sector_id;

          $document  = DB::table('grc_document')->join('grc_sector','grc_document.sector','=','grc_sector.id')->where('grc_document.state',$stateid)->where('grc_document.sector',$sectorid)->select('grc_document.*','grc_sector.sector_name')->get();



              $columns = array('S.No','Condition', 'Document');

    
    $filename = public_path("uploads/csv/document_'".time()."'_report.csv");
    $handle = fopen($filename, 'w+');
    fputcsv($handle, $columns);

         $i = 1;
        foreach($document as $documents) {

           fputcsv($handle, array($i++, $documents->type,$documents->document));
        }
        
       fclose($handle);

       $headers = array(
        'Content-Type' => 'text/csv'
       
        );

       $file_name = str_replace(public_path(), URL::to('/'), $filename);


 return response()->json(['status' => 200,'link' => $file_name ], 200);


    }

  function update_figure_app(Request $request){


            $validator = Validator::make($request->all(), [
            'figure' => 'required',
            'task_id' => 'required'
          
            
        ]);
         if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
           }


    Log::info(json_encode($request->all()));

  
          $characters = str_replace("\n", '<br/>', $request->figure);
        

           DB::table('grc_task')->where('id',$request->task_id)->update(['figure' => $characters]);
           return response()->json(['status' => 200,'msg' => 'Updated successfully' ], 200);
  
}

  function update_actual_app(Request $request){


            $validator = Validator::make($request->all(), [
            'actual' => 'required',
            'task_id' => 'required'
          
            
        ]);
         if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
           }

               Log::info(json_encode($request->all()));
  
          $characters = str_replace("\n", '<br/>', $request->actual);
          $characters =  $characters;
          

           DB::table('grc_task')->where('id',$request->task_id)->update(['actual' => $characters]);
           return response()->json(['status' => 200,'msg' => 'Updated successfully' ], 200);
  
}

function add_hints(Request $request){

   $user = JWTAuth::parseToken()->authenticate();

     $validator = Validator::make($request->all(), [
            'hint' => 'required',
            'task_id' => 'required'
          
            
        ]);
         if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
           }

       
          $characters = str_replace("\n", '<br/>', $request->hint);

           DB::table('task_hints')->insert([
            'task_id' => $request->task_id,
            'hints' => $characters,
            'created_by' => $user->id,
            'created_at' => date('Y-m-d h:i:s')
          ]);
           return response()->json(['status' => 200,'msg' => 'Added successfully' ], 200);

}

function edit_hints(Request $request){

    $user = JWTAuth::parseToken()->authenticate();

    $validator = Validator::make($request->all(), [
            'hint' => 'required',
            'hint_id' => 'required'
          
            
        ]);
         if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
           }


            $characters = str_replace("\n", '<br/>', $request->hint);

           DB::table('task_hints')->where('id',$request->hint_id)->update([
            'hints' => $characters,
            'created_by' => $user->id,
            'created_at' => date('Y-m-d h:i:s')
          ]);
           return response()->json(['status' => 200,'msg' => 'Update successfully' ], 200);

}

function delete_hints($id){


     DB::table('task_hints')->where('id',$id)->delete();
  return response()->json(['status' => 200,'msg' => 'Delete successfully' ], 200);

}

function add_fileattach_hints(Request $request){

     $validator = Validator::make($request->all(), [
            'attfile' => 'required|max:5000',
            'task_id' => 'required'
          
            
        ]);
         if($validator->fails()){
          return response()->json(['status' => 400,'error'=> $validator->errors()->first()], 400);
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

function delete_fileattach($id){
  $get_file = DB::table('task_files')->where('id',$id)->first();
   $image_path = public_path('attachement/'.$get_file->files);
  if(File::exists($image_path)) {
        File::delete($image_path);
    }
    DB::table('task_files')->where('id',$id)->delete();
    return response()->json(['status' => 200, 'msg' => 'Deleted successfully']);
}


 private function verifysendMail($sub,$msg,$to,$from,$fromname)
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




}
