
@if(empty(session('type')))
<div class="topbar">
            <!-- LOGO -->
            <div class="topbar-left">
               
                <a href="{{URL::to('/dashboard')}}" class="logo width100">
                    <span class="float-left width100 padding-5">
                        <img src="{{URL::to('assets/images/grc.png')}}" alt="" height="80">
                    </span>
                    <i><img src="{{URL::to('assets/images/grc.png')}}" alt="" height="80"></i>
                </a>
            </div>
            <?php
             $noticount= DB::table('notification');
             if(session('role') != 'superadmin'){
                $noticount->where('user_id',session('userId')); 
             }
            
          $pre_date = date('Y-m-d',(strtotime ( '-7 day' , strtotime ( date('Y-m-d')) ) ));

          $noticount  =  $noticount->where(DB::raw("(DATE_FORMAT(notification.created_at,'%Y-%m-%d'))"), ">=", $pre_date)->where('view',0)->orderBy('id','DESC')->count();
         
            $notifetch = DB::table('notification');
            if(session('role') != 'superadmin'){

             $notifetch->where('org_id',session('org_id'));
            }
             
          $noti_it = [];
          $notifetch =  $notifetch->where(DB::raw("(DATE_FORMAT(notification.created_at,'%Y-%m-%d'))"), ">=", $pre_date)->orderBy('id','DESC')->get();
          foreach ($notifetch as $key => $notifetchs) {
              $noti_it[] = $notifetchs->id;
          }
          $decoded = json_encode($noti_it);

            ?>
            <nav class="navbar-custom">
                <div class="width-float">
                    <ul class="navbar-right list-inline float-right mb-0">
      
                        <li class="dropdown notification-list list-inline-item">
                            <a onclick="view_noti('{{$decoded}}')" class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="mdi mdi-bell noti-icon"></i>
                                   <span   class="badge badge-pill badge-danger noti-icon-badge"><span  class="show_noti">{{$noticount??0}}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg">
                                <h6 class="dropdown-item-text">Notifications (<span class="show_noti">{{$noticount??0}}</span>)</h6>
                                <div class="slimscroll notification-item-list" style="height:auto;">
 					@foreach($notifetch as $notifetchs)
					<p>{{$notifetchs->msg??''}} Created By {{date('d-m-Y h:i:s',strtotime($notifetchs->created_at))}}</p>
 					@endforeach
				</div>
                            </div>
                        </li>
                        <li class="dropdown notification-list list-inline-item">
                            <a href="{{URL::to('/myProfile')}}" class="nav-link dropdown-toggle arrow-none waves-effect text-right" style="position: relative;
                            top: -16px;">
                                <p class="m-0">{{$setting->first_name}} {{$setting->last_name}}</p>
                                <p class="m-0">{{($setting->role == 'superadmin')?'Super Admin':ucwords($setting->role)}}</p>
                            </a>
                        </li>
                        <li class="dropdown notification-list list-inline-item">
	                            <div class="dropdown notification-list nav-pro-img">
                                <a class="dropdown-toggle nav-link arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    @if(!empty($setting->photo))
                                    <img src="{{URL::to('/uploads_profileimg/'.$setting->photo)}}" alt="user" class="rounded-circle">
                                    @else
                                       <img src="{{URL::to('assets/download.png')}}" alt="user" class="rounded-circle">
                                    @endif
                                </a>
                                <div class="dropdown-menu dropdown-menu-right profile-dropdown">
                                    <a class="dropdown-item" href="{{URL::to('/myProfile')}}">
                                        <i class="mdi mdi-account-circle m-r-5"></i>Profile
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="{{URL::to('/logout')}}">
                                        <i class="mdi mdi-power text-danger"></i>
                                        Logout
                                    </a>
                                </div>
                            </div>
                        </li>
                    </ul>

                  <a href="{{URL::to('/dashboard')}}" class="green_erp_cls_logo"><img src="{{URL::to('assets/images/green_erp_logo.png')}}" alt="Green ERP" title="Green ERP"></a>
                   <ul class="list-inline menu-left mb-0">
                    <li class="float-left">
                        <button class="button-menu-mobile open-left waves-effect">
                            <i class="mdi mdi-menu"></i>
                        </button>
                    </li>
                </ul>
                </div>
            </nav>
        </div>
        @endif
        <!-- Top Bar End -->