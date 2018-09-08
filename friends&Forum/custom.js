function addfriend(url){
  jQuery.ajax({
    url: url,
    success: function(html) {
      window.location.reload();
    },
    async:true
  })
}
function friends(url){
 jQuery.ajax({
    url: url,
    success: function(html) {
      window.location.reload();
    },
    async:true
  })
}
