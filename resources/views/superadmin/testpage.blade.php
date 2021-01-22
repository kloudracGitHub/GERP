


 <link rel="stylesheet" href="{{URL::to('assets/css/chartist.min.cs')}}">
    <link href="{{URL::to('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{URL::to('assets/css/metismenu.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{URL::to('assets/css/icons.css')}}" rel="stylesheet" type="text/css">
    <link href="{{URL::to('assets/css/style.css')}}" id="cpswitch" rel="stylesheet" type="text/css">
    <link href="{{URL::to('assets/css/jquery.colorpanel.css')}}" rel="stylesheet" type="text/css">

    <link href="{{URL::to('assets/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{URL::to('assets/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">
    
    <!-- Responsive datatable examples -->
    <link href="{{URL::to('assets/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{URL::to('assets/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::to('assets/css/select2.min.css')}}" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">


  <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>S. No.</th>
                                                    <th>Task id</th>
                                                    <th>User</th>
                                                    <th>Category</th>
                                                    <th>Type</th>
                                                    <th>Hours</th>
                                                    <th>Status</th>
                                                    <th>Task Status</th>
                                                    <th>Action</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>001</td>
                                                    <td><a href="task_details.html">004</a></td>
                                                    <td>Suresh</td>
                                                    <td>General</td>
                                                    <td>EC</td>
                                                    <td>60</td>
                                                    <td class="active-text">New</td>
                                                    <td><span class="task_status task_complete"></span></td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" checked>
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <a href="saved_task.html" class="project_det_page"><img src="assets/images/eye_icon.png" alt="" title=""></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>002</td>
                                                    <td><a href="task_details.html">056</a></td>
                                                    <td>Atul</td>
                                                    <td>Specific</td>
                                                    <td>EC</td>
                                                    <td>40</td>
                                                    <td>Running</td>
                                                    <td><span class="task_status task_incomplete"></span></td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <a href="saved_task.html" class="project_det_page"><img src="assets/images/eye_icon.png" alt="" title=""></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>003</td>
                                                    <td><a href="task_details.html">055</a></td>
                                                    <td>Kamlesh</td>
                                                    <td>General</td>
                                                    <td>EC</td>
                                                    <td>70</td>
                                                    <td>Running</td>
                                                    <td><span class="task_status task_pending"></span></td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" checked>
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <a href="saved_task.html" class="project_det_page"><img src="assets/images/eye_icon.png" alt="" title=""></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>004</td>
                                                    <td><a href="task_details.html">008</a></td>
                                                    <td>Shyam</td>
                                                    <td>General</td>
                                                    <td>EC</td>
                                                    <td>120</td>
                                                    <td>Running</td>
                                                    <td><span class="task_status task_pending"></span></td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" checked>
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <a href="saved_task.html" class="project_det_page"><img src="assets/images/eye_icon.png" alt="" title=""></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>005</td>
                                                    <td><a href="task_details.html">010</a></td>
                                                    <td>Kamlesh</td>
                                                    <td>Specific</td>
                                                    <td>CTE</td>
                                                    <td>80</td>
                                                    <td>New</td>
                                                    <td><span class="task_status task_incomplete"></span></td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <a href="saved_task.html" class="project_det_page"><img src="assets/images/eye_icon.png" alt="" title=""></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>006</td>
                                                    <td><a href="task_details.html">020</a></td>
                                                    <td>Ramesh</td>
                                                    <td>General</td>
                                                    <td>EC</td>
                                                    <td>60</td>
                                                    <td>Running</td>
                                                    <td><span class="task_status task_pending"></span></td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <a href="saved_task.html" class="project_det_page"><img src="assets/images/eye_icon.png" alt="" title=""></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>007</td>
                                                    <td><a href="task_details.html">051</a></td>
                                                    <td>Vivek</td>
                                                    <td>Specific</td>
                                                    <td>EC</td>
                                                    <td>20</td>
                                                    <td>On Hold</td>
                                                    <td><span class="task_status task_complete"></span></td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <a href="saved_task.html" class="project_det_page"><img src="assets/images/eye_icon.png" alt="" title=""></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>008</td>
                                                    <td><a href="task_details.html">046</a></td>
                                                    <td>Vijay</td>
                                                    <td>Specific</td>
                                                    <td>EC</td>
                                                    <td>50</td>
                                                    <td>Running</td>
                                                    <td><span class="task_status task_incomplete"></span></td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" checked>
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <a href="saved_task.html" class="project_det_page"><img src="assets/images/eye_icon.png" alt="" title=""></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>009</td>
                                                    <td><a href="task_details.html">012</a></td>
                                                    <td>Rajeev</td>
                                                    <td>General</td>
                                                    <td>EC</td>
                                                    <td>40</td>
                                                    <td>New</td>
                                                    <td><span class="task_status task_complete"></span></td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" checked>
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <a href="saved_task.html" class="project_det_page"><img src="assets/images/eye_icon.png" alt="" title=""></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>010</td>
                                                    <td><a href="task_details.html">091</a></td>
                                                    <td>Kamlesh</td>
                                                    <td>General</td>
                                                    <td>EC</td>
                                                    <td>90</td>
                                                    <td>On Hold</td>
                                                    <td><span class="task_status task_complete"></span></td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" checked>
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <a href="saved_task.html" class="project_det_page"><img src="assets/images/eye_icon.png" alt="" title=""></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>011</td>
                                                    <td><a href="task_details.html">016</a></td>
                                                    <td>Vimlesh</td>
                                                    <td>Specific</td>
                                                    <td>EC</td>
                                                    <td>60</td>
                                                    <td>Running</td>
                                                    <td><span class="task_status task_pending"></span></td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" checked>
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <a href="saved_task.html" class="project_det_page"><img src="assets/images/eye_icon.png" alt="" title=""></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>012</td>
                                                    <td><a href="task_details.html">082</a></td>
                                                    <td>Rajeev</td>
                                                    <td>General</td>
                                                    <td>EC</td>
                                                    <td>70</td>
                                                    <td>New</td>
                                                    <td><span class="task_status task_complete"></span></td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <a href="saved_task.html" class="project_det_page"><img src="assets/images/eye_icon.png" alt="" title=""></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>013</td>
                                                    <td><a href="task_details.html">088</a></td>
                                                    <td>Avneesh</td>
                                                    <td>Specific</td>
                                                    <td>EC</td>
                                                    <td>80</td>
                                                    <td>Running</td>
                                                    <td><span class="task_status task_complete"></span></td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" checked>
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <a href="saved_task.html" class="project_det_page"><img src="assets/images/eye_icon.png" alt="" title=""></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>014</td>
                                                    <td><a href="task_details.html">003</a></td>
                                                    <td>Suresh</td>
                                                    <td>General</td>
                                                    <td>EC</td>
                                                    <td>80</td>
                                                    <td>On Hold</td>
                                                    <td><span class="task_status task_pending"></span></td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" checked>
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <a href="saved_task.html" class="project_det_page"><img src="assets/images/eye_icon.png" alt="" title=""></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>015</td>
                                                    <td><a href="task_details.html">061</a></td>
                                                    <td>Rajeev</td>
                                                    <td>Specific</td>
                                                    <td>EC</td>
                                                    <td>90</td>
                                                    <td>Completed</td>
                                                    <td><span class="task_status task_complete"></span></td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <a href="saved_task.html" class="project_det_page"><img src="assets/images/eye_icon.png" alt="" title=""></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>016</td>
                                                    <td><a href="task_details.html">075</a></td>
                                                    <td>Atulh</td>
                                                    <td>Specific</td>
                                                    <td>EC</td>
                                                    <td>60</td>
                                                    <td>Completed</td>
                                                    <td><span class="task_status task_pending"></span></td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <a href="saved_task.html" class="project_det_page"><img src="assets/images/eye_icon.png" alt="" title=""></a>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                      
                                        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
                                          <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
                                              <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
                                               <script src="{{URL::to('assets/js/jquery.min.js')}}"></script>
    <script src="{{URL::to('assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{URL::to('assets/js/metisMenu.min.js')}}"></script>
    <script src="{{URL::to('assets/js/jquery.slimscroll.js')}}"></script>
    <script src="{{URL::to('assets/js/waves.min.js')}}"></script>
    <!--Chartist Chart-->
    <script src="{{URL::to('assets/js/chartist.min.js')}}"></script>
    <script src="{{URL::to('assets/js/chartist-plugin-tooltip.min.js')}}"></script>

    <script src="{{URL::to('assets/js/chart.min.js')}}"></script>
    <script src="{{URL::to('assets/js/chartjs.init.js')}}"></script>
    <!-- peity JS -->
    <script src="{{URL::to('assets/js/jquery.peity.min.js')}}"></script>
    <script src="{{URL::to('assets/js/dashboard.js')}}"></script>
    <!-- App js -->
    <script src="{{URL::to('assets/js/app.js')}}"></script>
    <script src="{{URL::to('assets/js/excanvas.js')}}"></script>
    <script src="{{URL::to('assets/js/jquery.knob.js')}}"></script>
    <script src="{{URL::to('assets/js/jquery.colorpanel.js')}}"></script>

    <!-- Required datatable js -->
    <script src="{{URL::to('assets/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::to('assets/js/dataTables.bootstrap4.min.js')}}"></script>
    <!-- Buttons examples -->
    <script src="{{URL::to('assets/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::to('assets/js/buttons.bootstrap4.min.js')}}"></script>
    <!-- Responsive examples -->
    <script src="{{URL::to('assets/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::to('assets/js/responsive.bootstrap4.min.js')}}"></script>
    <!-- Datatable init js -->
    <script src="{{URL::to('assets/js/datatables.init.js')}}"></script>
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> -->
     <script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
    <!--  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script>  -->
    <script src="http://malsup.github.com/jquery.form.js"></script> 
       <script src="{{URL::to('assets/js/bootstrap-datepicker.js')}}"></script>
                                        <script>
                                            $(document).ready(function() {
    $('#datatable').DataTable();
} );
                                        </script>

                                      
                                        