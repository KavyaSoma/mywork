function deletenews(pid,url){
jQuery.ajax({
      url: url,
      success: function(html) {
       window.location.reload();
      },
      async:true
    });
}

function editnews(pid,message,sub,pdate,edate,status,type,link){
 $("#subject").val(sub);
 $("#publisheddate").val(pdate);
 $("#expireddate").val(edate);
 $("#description").html(message);
 $("#wesitelink").val(link);
 $("#news_id").val(pid);
 $("#mydropdownlist").val("thevalue").change();
}