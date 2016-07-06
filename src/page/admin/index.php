<div class="contents">
  <h1>Admin Panel</h1>
  <?php
  echo Lobby::l("/admin/app/school-election/config", "Configure Election", "class='btn red'");
  ?>
  <h2>Election</h2>
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
  <div style="margin-top:10px;">
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
    echo \Lobby::l("/admin/app/school-election/didnt-vote", "Who Didn't Vote ?", "class='btn orange'");
    ?>
  </div>
  <h2>Other Tools</h2>
  <?php
  if( isset($_GET['action']) ){
    $this->EC->liveChange($_GET['action']);
    echo sss("Requested For {$_GET['action']}", "The request to reload election page has been sent.");
  }
  if( isset($_POST['clearData']) ){
    $this->EC->clear();
    echo "<h2>Successfully Cleared Data</h1>";
  }
  ?>
  <div style="margin-top:10px;">
    <form action="<?php echo \Lobby::u();?>" method="POST" onsubmit="return confirm('Are you sure ?') !== true ? false : true;"><button title="Empty all the data of election stored in database ?" name="clearData" class="btn red">CLEAR ALL DATA !</button></form>
  </div>
  <div style="margin-top:10px;">
    <a href="?action=reload" class="btn">Reload Election Pages</a>
  </div>
  <div style="margin-top:10px;">
    <a href="?action=reset" class="btn">Reset Live Actions</a>
  </div>
</div>
