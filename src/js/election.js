lobby.app = $.extend(lobby.app, {

  voterID: null,
  
  /**
   * Prevent boxes being checked does not overflow the limit
   */
  checkboxesCheck: function(parent){
    parent.find("input[type=checkbox]").live('change', function(evt) {
      if(parent.find(':checked').length > lobby.app.config["able-to-choose"]){
        parent.find(':checked').not(this).last().prop("checked", false);
      }
    });
  },
  
  dialog: function(msg){
    $("<div><h3>"+ msg +"</h3></div>").dialog({
      closeOnEscape: true,
      minWidth: 500
    });
  }
  
});

lobby.load(function(){
  /**
  This was for bethany exclusively by Subin 2014
  lobby.app.ajax("/username.php", function(u){
     if(u != "error"){
       lobby.app.voterID = u;
       $("#workspace #voterForm").fadeOut(500, function(){
        $("#workspace #voteForm").fadeIn(500);
      });
      $("#workspace #voteForm #username").text(u);
     }else{
       lobby.app.dialog("Some error occured, please contact administrator");
     }
   });
  */
  
  var candidateLimit = lobby.app.config["able-to-choose"];
  
  if(lobby.app.config["type"] === "multiple"){
    lobby.app.checkboxesCheck($("#workspace #candidates #boys"));
    lobby.app.checkboxesCheck($("#workspace #candidates #girls"));
  }else{
    lobby.app.checkboxesCheck($("#workspace #candidates"));
  }
  
  $("#workspace #voteForm").on('submit', function(e){
    e.preventDefault();
    
    if(lobby.app.config["type"] === "multiple" && $("#girls :checked").length < candidateLimit){
      lobby.app.dialog("Please Select "+ candidateLimit +" Girl(s)");
    }else if(lobby.app.config["type"] === "multiple" && $("#boys :checked").length < candidateLimit){
      lobby.app.dialog("Please Select "+ candidateLimit +" Boy(s)");
    }else if($("#voteForm :checked").length < candidateLimit){
      lobby.app.dialog("Please Select "+ candidateLimit +" candidate(s)");
    }else{
      requestData = {
        "vote" : "true",
        "voterID" : lobby.app.voterID,
        "candidates" : []
      };
      $(this).find(":checked").each(function(){
        requestData["candidates"].push($(this).val());
      });

      lobby.app.ajax("vote", requestData, function(r){
        if(r === "error"){
          lobby.app.dialog("Some Error occured. Please contact the supervisor.");
        }else if(r === "voted"){
          lobby.app.dialog("You have already voted.<br/>Please don't try to trick me :-)");
        }else{
          $("#workspace #votedBeep")[0].play();
          $("#workspace #voteForm").fadeOut(500, function(){
            $("#workspace .thankyou").fadeIn(500, function(){
              setTimeout(function(){
                lobby.app.redirect("/");
              }, 5000);
            });
          });
        }
      });
    }
  });
  
  $("#workspace #voterForm").on("submit", function(e){
    e.preventDefault();
    
    /**
     * 'class' is a reserved keyword in JS, so using 'clas'
     */
    var clas = $(this).find("[name=class]").val();
    var div  = $(this).find("[name=division]").val();
    var roll = $(this).find("[name=roll]").val();
    var pass = lobby.app.config["password"] === "1" ? $(this).find("[name=password]").val() : 0;
    
    if(/^[a-z]+$/i.test(roll)){
      lobby.app.dialog("Alphabetic characters are not valid for a Roll Number");
    }else if(roll.length == 0){
      lobby.app.dialog("Please type in a roll number");
    }else if(lobby.app.config["password"] === "1" && pass.length != 3){
      lobby.app.dialog("Password Should Be a 3 Digit Number");
    }else{
      lobby.app.voterID = clas + div + roll;
      lobby.app.ajax("login", {"id" : lobby.app.voterID, "roll" : roll, "password" : pass}, function(r){
        /**
         * Show the vote form
         */
        if(r === "true"){
          $("#workspace #voteForm #username").text(lobby.app.voterID);
          $("#workspace #voterForm").fadeOut(500, function(){
            $("#workspace #voteForm").fadeIn(500);
          });
          if(lobby.app.config["type"] === "class"){
            lobby.app.ajax("candidates.php", {"class": clas, "division": div}, function(response){
              $("#workspace #voteForm #candidates").html(response);
            });
          }
        }else if(r == "voted"){
          lobby.app.dialog("You have already voted.<br/>Please don't try to trick me :-)");
        }else{
          lobby.app.dialog("Password Wrong !");
        }
      });
    }
  });
  
  setInterval(function(){
    lobby.app.ajax("changes.php", {}, function(script){
      eval(script);
    });
  }, 8000);
  
  setInterval(function(){
    if($("#workspace #voteForm").is(":visible")){
      $("#workspace #voteForm #username").animate({"opacity" : 0}, 500, function(){
        $("#workspace #voteForm #username").animate({"opacity" : 1}, 500);
      });
    }
  }, 1000);
  
  /**
   * Focus on Roll number field
   */
  $("#workspace #voterForm input[name=roll]").focus();
});
