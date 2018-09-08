function members(gname,gid){
  $("#groupname").html(gname);
  $("#group-name").val(gname);
  $("#group_id").val(gid);
}
function group(url){
  window.location.assign(url);
}