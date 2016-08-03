<div class="contents">
  <h1>Election Panel</h1>
  <?php
  if(isset($_GET['action'])){
    $this->EC->liveChange($_GET['action']);
    echo sss("Requested For {$_GET['action']}", "The request to reload election page has been sent.");
  }
  if(isset($_POST['clearData'])){
    $this->EC->clear();
    echo sss("Successfully Cleared Data", "Election data has been cleared.");
  }
  echo Lobby::l("/admin/app/school-election/config", "General Settings", "class='btn btn-large red'");
  ?>
  <a href="https://github.com/subins2000/lobby-school-election#school-election" target="_blank" class="btn green btn-large">Help & HowTo Guide</a>
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
        <div style="margin-top:10px;">
          <?php
          echo \Lobby::l("/admin/app/school-election/didnt-vote", "Who Didn't Vote ?", "class='btn orange' title='See who did not vote in a class'");
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
</div>
