$("#to_subject").ready(function(){
var $regexname=/^([a-zA-Z0-9_ ]{3,100})$/;
  $("#to_subject").on('keypress keydown keyup',function(){
    if(!$(this).val().match($regexname)){
      $('.subject').show();
    }
    else{
      $('.subject').hide();
    }
  });
});
$(document).ready(function() {
$(function() {
    $('#dicard-message').attr('disabled', 'disabled');
}); 
$('input[type=text],input[type=email]').keyup(function() {        
    if ($('#email').val() !=''|| 
    $('#subject').val() != '' ||
    $('#message').val() != '') {
        $('#dicard-message').removeAttr('disabled');
    } else {
        $('#dicard-message').attr('disabled', 'disabled');
    }
});
});
$(document).ready(function() {
$(function() {
    $('#send-message').attr('disabled', 'disabled');
}); 
$('input[type=text],input[type=email]').keyup(function() {        
    if ($('#location-suggestions').val() !='' && 
    $('#to_subject').val() != '' &&
    $('#message').val() != '') {
        $('#send-message').removeAttr('disabled');
    } else {
        $('#send-message').attr('disabled', 'disabled');
    }
});
});
function uploadfile() {
  $("#attachment").click();
}
$(document).ready(function() {       
$('#attachment').bind('change', function() {
    var a=(this.files[0].size);
    $("#attachment-error").hide();
   // $("#max-size").html(a);
    if(a > 2000000) {
      $("#max-size").hide();
      $("#attachment-error").show();
       $('#send-message').attr('disabled', 'disabled');
    }
});
});
$("#reply-subject").ready(function(){
var $regexname=/^([a-zA-Z0-9_ ]{3,100})$/;
  $("#reply-subject").on('keypress keydown keyup',function(){
    if(!$(this).val().match($regexname)){
      $('.replysubject').show();
    }
    else{
      $('.replysubject').hide();
    }
  });
});
function deletemsg(mid,url) {
  jQuery.ajax({
      url: url,
      success: function(html) {
       window.location.reload();
      },
      async:true
    });
}
function forward(subject,message){
  $("#reply-message").hide();
  $("#submit-reply").hide();
  $("#reply-reset").hide();
  $("#forwardmsg").show();
  $("#forward-subject").val(subject);
  $("#forward-message").html(message);
}
$("#forward-subject").ready(function(){
var $regexname=/^([a-zA-Z0-9_ ]{3,100})$/;
  $("#forward-subject").on('keypress keydown keyup',function(){
    if(!$(this).val().match($regexname)){
      $('.forward-sub-error').show();
    }
    else{
      $('.forward-sub-error').hide();
    }
  });
});
function archive(url){
  jQuery.ajax({
      url: url,
      success: function(html) {
       window.location.reload();
      },
      async:true
    });
}
