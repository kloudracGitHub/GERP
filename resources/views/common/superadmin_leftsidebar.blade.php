
@if(empty(session('type')))
 <!-- ========== Left Sidebar Start ========== -->
        <div class="left side-menu">
            <div class="slimscroll-menu" id="remove-scroll">
                <!--- Sidemenu -->
               
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                     
                    <ul class="metismenu" id="side-menu">
                       <?php //echo session('role'); die('dfghj');?>
                       
                       @if(session('role')=='superadmin')
                        <li>
                            <a href="{{URL::to('/dashboard')}}" class="waves-effect">
                                <i class="mdi mdi-home-outline"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                         <li>
                            <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-settings"></i>
                                <span>System Wide Setting <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span></span>
                            </a>
                             <ul class="submenu">
                              <li><a href="{{URL::to('/country')}}" class="waves-effect">Country Management</a></li>

                              <li><a href="{{URL::to('/currency-management')}}" class="waves-effect">Currency Management</a></li>

                              <li><a href="{{URL::to('/status-management')}}" class="waves-effect">Status Management</a></li>

                              <li><a href="{{URL::to('/type-management')}}" class="waves-effect">Type Management</a></li>

                               <li><a href="{{URL::to('/stage-management')}}" class="waves-effect">Stage Management</a></li>

                               <li><a href="{{URL::to('/sector-management')}}" class="waves-effect">Sector Management</a></li>
                             
                           </ul>
                        </li>
                       
                        <li>
                            <a href="{{URL::to('/Organization-list')}}" class="waves-effect"><i class="fas fa-building"></i>
                                <span>Organization</span>
                            </a>
                        </li>
                       
                        <li>
                            <a href="{{URL::to('/Project-list')}}" class="waves-effect"><i class="mdi mdi-settings"></i>
                                <span>Projects</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{URL::to('/Task-list')}}" class="waves-effect"><i class="mdi mdi-account-edit"></i>
                                <span> Tasks</span></span>
                            </a>
                        </li>
                        <li>
                            <a href="{{URL::to('/Document')}}" class="waves-effect"><i class="mdi mdi-file-document"></i>
                                <span>Documents</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{URL::to('report/')}}" class="waves-effect"> <i class="mdi mdi-account-star"></i>
                                <span>Reports</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{URL::to('/circular')}}" class="waves-effect"><i class="mdi mdi-library-books"></i>
                                <span>Circulars</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{URL::to('/Users-list')}}" class="waves-effect"><i class="mdi mdi-account-key"></i>
                                <span>Users</span>
                            </a>
                        </li> 
                        <li>
                            <a href="{{URL::to('/myProfile')}}" class="waves-effect"><i class="ti-face-smile"></i> <span>My Profile
                            </span></a>
                        </li>
                         <li>
                            <a href="{{URL::to('/change-password')}}" class="waves-effect"><i class="ti-face-smile"></i> <span>Change Password
                            </span></a>
                        </li>
                        <li>
                            <a href="{{URL::to('/logout')}}" class="waves-effect"><i class="ti-location-pin"></i><span> Logout</span></a>
                        </li>
                       @endif
                         @if(session('role')=='admin')
                        <li>
                            <a href="{{URL::to('/dashboard')}}" class="waves-effect">
                                <i class="mdi mdi-home-outline"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                         <li>
                            <a href="{{URL::to('/Organization-view/'.session('org_id'))}}" class="waves-effect"><i class="fas fa-building"></i>
                                <span>Organization</span>
                            </a>
                        </li>
                       
                        <li>
                            <a href="{{URL::to('/Project-list')}}" class="waves-effect"><i class="mdi mdi-settings"></i>
                                <span>Projects</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{URL::to('/Task-list')}}" class="waves-effect"><i class="mdi mdi-account-edit"></i>
                                <span> Tasks</span></span>
                            </a>
                        </li>
                        <li>
                            <a href="{{URL::to('/Document')}}" class="waves-effect"><i class="mdi mdi-file-document"></i>
                                <span>Documents</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{URL::to('/circular')}}" class="waves-effect"><i class="mdi mdi-orbit"></i>
                                <span>Circulars</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{URL::to('/Users-list')}}" class="waves-effect"><i class="mdi mdi-account-multiple"></i>
                                <span>Users</span>
                            </a>
                        </li> 
                        <li>
                            <a href="{{URL::to('/myProfile')}}" class="waves-effect"><i class="ti-face-smile"></i> <span>My Profile
                            </span></a>
                        </li>
                        <li>
                            <a href="{{URL::to('/change-password')}}" class="waves-effect"><i class="ti-face-smile"></i> <span>Change Password
                            </span></a>
                        </li>
                        <li>
                            <a href="{{URL::to('/logout')}}" class="waves-effect"><i class="ti-location-pin"></i><span> Logout</span></a>
                        </li>
                        @endif
                         @if(session('role')=='project_Manager')
                        <li>
                            <a href="{{URL::to('/dashboard')}}" class="waves-effect">
                                <i class="mdi mdi-home-outline"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                         <li>
                            <a href="{{URL::to('/Organization-view/'.session('org_id'))}}" class="waves-effect"><i class="fas fa-building"></i>
                                <span>Organization</span>
                            </a>
                        </li>
                       
                        <li>
                            <a href="{{URL::to('/Project-list')}}" class="waves-effect"><i class="mdi mdi-settings"></i>
                                <span>Projects</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{URL::to('/Task-list')}}" class="waves-effect"><i class="mdi mdi-account-edit"></i>
                                <span> Tasks</span></span>
                            </a>
                        </li>
                        <li>
                            <a href="{{URL::to('/Document')}}" class="waves-effect"><i class="mdi mdi-account-network"></i>
                                <span>Documents</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{URL::to('/Users-list')}}" class="waves-effect"><i class="mdi mdi-account-multiple"></i>
                                <span>Users</span>
                            </a>
                        </li> 
                        <li>
                            <a href="{{URL::to('/myProfile')}}" class="waves-effect"><i class="ti-face-smile"></i> <span>My Profile
                            </span></a>
                        </li>
                       <li>
                            <a href="{{URL::to('/change-password')}}" class="waves-effect"><i class="ti-face-smile"></i> <span>Change Password
                            </span></a>
                        </li>
                        <li>
                            <a href="{{URL::to('/logout')}}" class="waves-effect"><i class="ti-location-pin"></i><span> Logout</span></a>
                        </li>
                        @endif
                        @if(session('role')=='employee')
                        <li>
                            <a href="{{URL::to('/dashboard')}}" class="waves-effect">
                                <i class="mdi mdi-home-outline"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                         <li>
                            <a href="{{URL::to('/Organization-view/'.session('org_id'))}}" class="waves-effect"><i class="fas fa-building"></i>
                                <span>Organization</span>
                            </a>
                        </li>
                       
                        <li>
                            <a href="{{URL::to('/Project-list')}}" class="waves-effect"><i class="mdi mdi-settings"></i>
                                <span>Projects</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{URL::to('/Task-list')}}" class="waves-effect"><i class="mdi mdi-account-edit"></i>
                                <span> Tasks</span></span>
                            </a>
                        </li>
                        
                        <!-- <li>
                            <a href="{{URL::to('/Users-list')}}" class="waves-effect"><i class="mdi mdi-account-key"></i>
                                <span>Users</span>
                            </a>
                        </li>  -->
                        <li>
                            <a href="{{URL::to('/myProfile')}}" class="waves-effect"><i class="ti-face-smile"></i> <span>My Profile
                            </span></a>
                        </li>
                        <li>
                            <a href="{{URL::to('/change-password')}}" class="waves-effect"><i class="ti-face-smile"></i> <span>Change Password
                            </span></a>
                        </li>
                        <li>
                            <a href="{{URL::to('/logout')}}" class="waves-effect"><i class="ti-location-pin"></i><span> Logout</span></a>
                        </li>
                        @endif
                    </ul>
                </div>
                
                <!-- Sidebar -->
                <div class="clearfix"></div>
            </div>
            <!-- Sidebar -left -->
        </div>

        @endif