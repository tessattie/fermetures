<nav class="navbar navbar-default" id = "columnid">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->

    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/caisses/public/home"><p><img src="/caisses/public/images/logo.png" class="logo"></p></a>
    </div>

    <form class="form-inline my-2 my-lg-0" style="width:39%;float:left" action = "/caisses/public/home/setData" method = "POST">
      <input type="submit" name="submit" value = "SUBMIT" class="btn btn-success" style="padding:4px 15px 3px;;float:right;margin-top:20px;margin-left:3px">
      <select class="form-control mr-sm-2" name="cashier" style="margin-top:20px;float:right">
        <option value="">-- Choose option --</option>
        <?php foreach($data['statuses'] as $st) : ?>
          <?php if($st['status'] != 0): ?>
          <option value="<?= $st['cashier_id'] ?>" <?= (!empty($_COOKIE['cashier']) && $_COOKIE['cashier'] == $st['cashier_id'] ? "selected" : "") ?> ><?= $st['cashier_id'] . " - " .  $st['cashier_name'] ?></option>
          <?php endif; ?>
        <?php endforeach; ?>
      </select>
      <input class="form-control mr-sm-2" name="date"  type="date" placeholder="Date" id='dateInput' style="margin-top:20px;float:right;margin-right:5px" value = "<?= $_COOKIE["date"] ?>">
    </form>
      <?php  
        $list = array(0 => "info", 1 => "success", 2 => "warning");
        $glyph = array(0 => "glyphicon glyphicon-minus", 1 => "glyphicon glyphicon-ok", 2 => "glyphicon glyphicon-plus");
       ?>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
      <?php if($_SESSION['caisses']['role'] == "20") : ?>
        <li class="dropdown">
          <a href="#" class="navrightmenu" data-toggle="modal" data-target="#totalsModal">Totals</a>
        </li>
      <li class="dropdown">
          <a href="#" class="navrightmenu" data-toggle="modal" data-target="#exampleModal">Report</a>
        </li>
        <?php endif; ?>
      <li>

          <a href="#" class="dropdown-toggle navrightmenu" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
          Caisses <span class="caret"></span></a>
          <ul class="dropdown-menu" style="height:300px;overflow-y:scroll;width: 235px;">
            <?php foreach($data['statuses'] as $st) : ?>
              <?php if($st['status'] != 0): ?>
            <li style="padding:5px;"><label style="margin-right:7px;padding:.2em .3em .3em 0.6em" class="label label-<?= $list[$st['status']] ?>"><span class = "<?= $glyph[$st['status']] ?>"></span> </label> <?= $st['cashier_id'] . " - " .  $st['cashier_name'] ?></li>
            <?php endif; ?>
            <?php endforeach; ?>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle navrightmenu" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= ucfirst($_SESSION["caisses"]['firstname']); ?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="/caisses/public/home">Home</a></li>
            <li><a href="/caisses/public/account">Settings</a></li>
            <li><a href="/caisses/public/home/logout">Log out</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->

  </div><!-- /.container-fluid -->
</nav>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  <form action="/caisses/public/home/report" method="POST">
    <div class="modal-content" style="border:1px solid white;">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Report</h3>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label for="exampleInputEmail1">Date</label>
            <input required type="date" class="form-control" value="<?= date("Y-m-d") ?>" style="font-size:13px;height:32px" name="timestamp">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Period</label>
            <select class="form-control" style="font-size:13px;height:32px" name="report_type" required>
              <option value = "">-- Choose --</option>
              <option value = "2">Midi</option>
              <option value = "1">Soir</option>
            </select>
          </div>
          <div class="form-group"> 
            <label for="exampleInputPassword1">Action</label> 
            <select class="form-control" style="font-size:13px;height:32px"  name="action" required>
              <option value = "">-- Choose --</option>
              <option value = "1">Show</option>
              <option value = "2">Export</option>
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-bottom:0px">
        Close</button>
        <input type="submit" name="submit" class="btn btn-primary" value = "Submit">
      </div>
    </div>
    </form>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="totalsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  <form action="/caisses/public/home/totals" method="POST">
    <div class="modal-content" style="border:1px solid white;">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Totals</h3>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label for="exampleInputEmail1">Date</label>
            <input required type="date" class="form-control" value="<?= date("Y-m-d") ?>" style="font-size:13px;height:32px" name="timestamp">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Period</label>
            <select class="form-control" style="font-size:13px;height:32px" name="report_type" required>
              <option value = "">-- Choose --</option>
              <option value = "2">Midi</option>
              <option value = "1">Soir</option>
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-bottom:0px">
        Close</button>
        <input type="submit" name="submit" class="btn btn-primary" value = "Submit">
      </div>
    </div>
    </form>
  </div>
</div>

<div class="container-fluid">
  <div class="row salesrow">
    <div class = "col-md-7 fildiv">
      <?php 
      if(!empty($data['title']))
      {
        echo '<p class="filArianne"><span class="csm"><a href="/caisses/public/home">CAISSES</a></span><span class="glyphicon glyphicon-chevron-right"></span><span class="tablecaption">'.$data['title'].'</span>';
      }
      ?>
    </div>
    <div class = "col-md-5 salescol">
    </div>
  </div>

<a href='#columnid'><button type="button" class="btn btn-default" id = "backtop">TOP</button></a>