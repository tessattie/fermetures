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

    <form class="form-inline my-2 my-lg-0" style="width:39%;float:left">
      <button class="btn btn-success" style="padding:5px;float:right;margin-top:20px;margin-left:3px"><A HREF="javascript:history.go(0)" style="color:white;"><span class="glyphicon glyphicon-refresh"></span></A></button>
    <?php if(!empty($_SESSION['caisses']['keyword'])) : ?>

      <input class="form-control mr-sm-2" type="text" placeholder="Cashier" id='keywordInput' style="margin-top:20px;float:right" value = "<?= $_SESSION['csm']['keyword'] ?>">
    <?php else : ?>
      <input class="form-control mr-sm-2"  type="text" placeholder="Cashier" id='keywordInput' style="margin-top:20px;float:right">
    <?php endif; ?>
      <input class="form-control mr-sm-2"  type="date" placeholder="Date" id='dateInput' style="margin-top:20px;float:right;margin-right:5px">
    </form>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
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