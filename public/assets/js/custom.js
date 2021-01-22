$(".toggle-password").click(function() {

    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });
 $(document).ready(function(){
   debugger
     $(".modalpopup").fadeIn('fast').delay(4000).fadeOut('fast');
            $("#closepopup").click(function(){
                debugger
                $(".modalpopup").css("display","none");
            });
   $(".addDep").class(function(){
    $("#depart").show();
   });

 });
function task_preview(){
  debugger
  var pro_name=document.getElementById("projectId").value;
  var task_name=document.getElementById("taskname").value;
   var task_state=document.getElementById("projectstate").value;
  var task_cto=document.getElementById("category").value;
   var task_sector=document.getElementById("sector").value;
  var task_condition=document.getElementById("conditionno").value;
   var task_user=document.getElementById("user_name").value;
  var task_type=document.getElementById("tasktype").value;
    var task_status=document.getElementById("taskstatus").value;
  var task_startdate=document.getElementById("startdate").value;
   var task_endate=document.getElementById("endDate").value;
  var taskhr=document.getElementById("estimatedhours").value;
  var task_desc=document.getElementById("taskDescription").value;
 }
 