lobby.load(function(){  
  $("#workspace #add").on("click", function(){
    lastRow = $(this).parent().find(".row:last");
    id = parseInt(lastRow.data("id")) + 1;
    
    newRow = '<div class="valign-wrapper row" data-id="'+ id +'" ' + (
      lobby.app.config["type"] === "class" ? 'data-class="'+ lastRow.data("class") +'" data-div="'+ lastRow.data("div"
    ) +'"' : '') + '>';
      newRow += '<input type="text" class="valign col b8" name="candidates['+ id +'][name]" placeholder="Candidate name" /><select name="candidates['+ id +'][gender]" class="col m2"><option value="m">Male</option><option value="f">Female</option></select><a id="remove" class="valign col s2"></a>';
      if(lobby.app.config["type"] === "class"){
        newRow += '<input type="hidden" name="candidates['+ id +'][class]" value="'+ lastRow.data("class") +'" />';
        newRow += '<input type="hidden" name="candidates['+ id +'][division]" value="'+ lastRow.data("div") +'" />';
      }
    newRow += '</div>';
    
    lastRow.after(newRow);
    $(this).parent().find(".row:last").find("input").focus();
  });
  
  $("#workspace #remove").live("click", function(){
    if($(this).parents(".addCandidateRows").find(".row").length !== 1)
      $(this).parents(".valign-wrapper").remove();
  });
});
