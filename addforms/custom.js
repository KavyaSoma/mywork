function shortName(url) {
          var email = $('#email').val();
          jQuery.ajax({
    url: url+'/'+email,
    success:function(value){
      if(value == "success"){
        var temp = new Array();
          temp = email.split("@");
          console.log(temp[0]);
          $('#display').val(temp[0]);
        $("#message").html("");
          $("#instructor-contact").removeAttr('disabled');
      }
      else{
        $("#instructor-contact").attr('disabled', 'disabled');
      $("#message").html("<span style='color:red'>ShortName Already exists.Please Add numeric characters or change shortname</span>");
    } 
  },
    async:true
  });
}function eventname(){
  var $regexname=/^([a-zA-Z_ ]{5,25})$/;
  $("#event-name").on('keypress keydown keyup',function(){
    if(!$(this).val().match($regexname)){
      $('.name-error').show();
    }
    else{
       $('.name-error').hide();
        var eventname=$('#event-name').val();
        eventname =eventname.replace(/ +/g, ""); 
        document.getElementById('short-name').value = eventname.toLowerCase();
          
    }
  });
}

function eventshortname(url){
  var shortname = $("#short-name").val();
 jQuery.ajax({
    url: url+'/'+shortname,
    success:function(value){
      if(value == "success"){
        $("#message").html("");
          $("#saveevent").removeAttr('disabled');
      }
      else{
        $("#saveevent").attr('disabled', 'disabled');
      $("#message").html("<span style='color:red'>ShortName Already exists.Please Add numeric characters or change shortname</span>");
    } 
  },
    async:true
  });
}

function venueshortname(url){
   var shortname = $("#venue-short-name").val();
 jQuery.ajax({
    url: url+'/'+shortname,
    success:function(value){
      if(value == "success"){
        $("#message").html("");
          $("#savevenue").removeAttr('disabled');
      }
      else{
        $("#savevenue").attr('disabled', 'disabled');
      $("#message").html("<span style='color:red'>ShortName Already exists.Please Add numeric characters or change shortname</span>");
    } 
  },
    async:true
  });
}

function clubshortname(url){
    var shortname = $("#shortname").val();
  jQuery.ajax({
    url: url+'/'+shortname,
    success:function(value){
      if(value == "success"){
        $("#message").html("");
          $("#save-club").removeAttr('disabled');
      }
      else{
        $("#save-club").attr('disabled', 'disabled');
      $("#message").html("<span style='color:red'>ShortName Already exists.Please Add numeric characters or change shortname</span>");
    } 
  },
    async:true
  });
}