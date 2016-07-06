/* A global variable */
window.voterID = "";

/* The HOST URL */
window.hostURL   = window.location.protocol + "//" + window.location.host + window.location.pathname;

$(document).ready(function(){
  /**
  This was for bethany exclusively by Subin 2014
  lobby.app.ajax("/username.php", function(u){
     if(u != "error"){
       window.voterID = u;
       $(".contents #voterForm").fadeOut(500, function(){
        $(".contents #voteForm").fadeIn(500);
      });
      $(".contents #voteForm #username").text(u);
     }else{
       alert("Some error occured, please contact administrator");
     }
   });
  */
   
  var candidateLimit = lobby.app.config["able-to-choose"] ;
  
  $('.boys input[type=checkbox]').on('change', function(evt) {
    if($(".boys").find(':checked').length > candidateLimit) {
      this.checked = false;
    }
  });
  $('.girls input[type=checkbox]').on('change', function(evt) {
    if($(".girls").find(':checked').length > candidateLimit) {
      this.checked = false;
    }
  });
  
  $(".contents #voteForm").on('submit', function(e){
    e.preventDefault();
    if($(".girls :checked").length < candidateLimit){
      alert("Please Select "+ candidateLimit +" Girl(s)");
    }else if($(".boys :checked").length < candidateLimit){
      alert("Please Select "+ candidateLimit +" Boy(s)");
    }else{
      requestData = {
        "vote" : "true",
        "voterID" : window.voterID,
        "candidates" : []
      };
      $(this).find(":checked").each(function(){
        requestData["candidates"].push($(this).val());
      });

      lobby.app.ajax("vote.php", requestData, function(r){
        if(r == "error"){
          alert("Some Error occured. Please contact the supervisor.");
        }else if(r == "voted"){
          alert("You have already voted. Please Don't try to trick me :-)");
        }else{
          $(".contents #voteForm").fadeOut(500, function(){
            $(".contents .thankyou").fadeIn(500);
          });
        }
      }).error(function(){
        alert("Some error occured. Contact the administrator");
      });
    }
  });
  
  $(".contents #voterForm").on("submit", function(e){
    e.preventDefault();
    var cl   = $(this).find("[name=class]").val();
    var dv   = $(this).find("[name=division]").val();
    var roll  = $(this).find("[name=roll]").val();
    var password = $(this).find("[name=password]").val();
    
    if(/^[a-z]+$/i.test(roll)){
      alert("Alphabetic characters are not valid for a Roll Number");
    }else if(roll.length == 0){
      alert("Please type in a roll number");
    }else if(password.length != 3){
      alert("Password Should Be a 3 Digit Number");
    }else{
      window.voterID  = cl + dv + roll;
      lobby.app.ajax("check.php", {"id" : voterID, "roll" : roll, "password" : password}, function(r){
        /**
         * Show the vote form
         */
        if(r == "true"){
          $(".contents #voteForm #username").text(voterID);
          $(".contents #voterForm").fadeOut(500, function(){
            $(".contents #voteForm").fadeIn(500);
          });
        }else if(r == "voted"){
          alert("You have already voted. Please Don't try to trick me :-)");
        }else{
          alert("Password Wrong !");
        }
      });
    }
  });
  
  setInterval(function(){
    lobby.app.ajax("changes.php", {}, function(script){
      eval(script);
    });
  }, 5000);
  
  setInterval(function(){
    if($(".contents #voteForm").is(":visible")){
      $(".contents #voteForm #username").animate({"opacity" : 0}, 500, function(){
        $(".contents #voteForm #username").animate({"opacity" : 1}, 500);
      });
    }
  }, 1000);
});
