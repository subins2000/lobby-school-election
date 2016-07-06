lobby.load(function(){
  $("#workspace select[name=type]").live("change", function(){
    if($(this).val() === "multiple"){
      $("#workspace .type-multiple-option").fadeIn(500);
    }else{
      $("#workspace .type-multiple-option").fadeOut(500);
    }
  });
  
  $("#workspace #classes #add").on("click", function(){
    $("#workspace #classes").append('<div class="valign-wrapper col s6"><input type="number" name="classes[]" class="valign" /><a id="remove" class="valign"></a></div>');
    $("#workspace #classes input:last").focus();
  });
  
  $("#workspace #divisions #add").on("click", function(){
    $("#workspace #classes").append('<div class="valign-wrapper col s6"><input type="text" name="divs[]" class="valign" /><a id="remove" class="valign"></a></div>');
    $("#workspace #classes input:last").focus();
  });
  
  $("#workspace #remove").live("click", function(){
    $(this).parents(".valign-wrapper").remove();
  });
});
