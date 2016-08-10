<div class="contents">
  <h1>Election Panel</h1>
  <?php
  if(isset($_POST['clearData'])){
    $this->EC->clear();
    Response::redirect($this->adminURL . "?cleared");
  }
  
  if(isset($_GET["cleared"]))
    echo sss("Successfully Cleared Data", "All Election data has been cleared.");
    
  echo Lobby::l("/admin/app/school-election/config", "General Settings", "class='btn btn-large red'");
  ?>
  <a href="http://subinsb.com/school-election" target="_blank" class="btn green btn-large">Help, How-To Guide, & Support</a>
  <div class="row">
    <div class="col m6" style="border-right: 5px dashed #000;">
      <h2>General</h2>
      <div class="col m6">
        <div>
          <?php
          echo \Lobby::l("/admin/app/school-election/candidates", "Manage Candidates", "class='btn'");
          ?>
        </div>
        <div style="margin-top:10px;">
          <?php
          echo \Lobby::l("/admin/app/school-election/create-users", "Manage Voters", "class='btn purple'");
          ?>
        </div>
      </div>
      <div class="col m6">
        <div>
          <?php
          echo \Lobby::l("/admin/app/school-election/stats", "Results", "class='btn green'");
          ?>
        </div>
        <div style="margin-top:10px;">
          <?php
          echo \Lobby::l("/admin/app/school-election/voted", "Voted List", "class='btn red'");
          ?>
        </div>
      </div>
    </div>
    <div class="col m6">
      <h2>Other Tools</h2>
      <div style="margin-top:10px;">
        <form action="<?php echo \Lobby::u();?>" method="POST" onsubmit="return confirm('Are you sure ?') !== true ? false : true;"><button title="This will empty all the data of election stored in database" name="clearData" class="btn red">CLEAR ALL DATA !</button></form>
      </div>
    </div>
  </div>
  <?php
  echo sme("About sElec", "<b>sElec</b> stands for <b>S</b>chool <b>Elec</b>tion. Just a random name.<cl/>If you need any help, contact me at <a href='https://www.facebook.com/SubinSiby'>Facebook</a>, <a href='https://plus.google.com/+SubinSiby'>Google+</a> or tweet to <a href='https://twitter.com/SubinSiby'>@SubinSiby</a><cl/>Copyleft (<a href='http://www.apache.org/licenses/LICENSE-2.0'>Apache License v2</a>). <a href='https://github.com/subins2000/lobby-school-election'>Fork</a>, Distribute and Enjoy!");
  ?>
</div>
