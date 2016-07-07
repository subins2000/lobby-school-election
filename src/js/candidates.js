lobby.load(function(){  
  $("#workspace #add").on("click", function(){
    id = parseInt($("#workspace .row:last").data("id")) + 1;
    $("#workspace .row:last").after('<div class="valign-wrapper row" data-id="'+ id +'"><input class="valign col b8" name="candidates['+ id +'][name]" placeholder="Candidate name" /><select name="candidates['+ id +'][gender]" class="col m2"><option value="m">Male</option><option value="f">Female</option></select><a id="remove" class="valign col s2"></a></div>');
    $("#workspace input:last").focus();
  });
  
  $("#workspace #remove").live("click", function(){
    $(this).parents(".valign-wrapper").remove();
  });
});
