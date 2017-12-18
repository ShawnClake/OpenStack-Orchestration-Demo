<html>
<head>
<title> NFV Magic Buttons Demo </title>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

</head>
<body style="background-color:#E8E8E8">

<div class='container'>
  <div class='row'>
    <div class='col-sm-12'>
      <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="#">
          <img src="https://www.forcepoint.com/sites/default/files/styles/medium/public/deployment-icon-cloud.png" width="30" height="30" class="d-inline-block align-top" alt="">
          NFV Magic Buttons
        </a>
      </nav>
    </div>
  </div>

  <div class = 'row'>

    <div class='col'>
      <?php
date_default_timezone_set("America/Regina");
        $status = $_GET['status'];
        if(isset($status))
        {
          if($status == 1)
            echo '<div style="margin-top:30px;" class="alert alert-success alert-dismissible fade show" role="alert">[' . date("Y-m-d h:i:sa") . '] <strong>Stack</strong> (' . $_GET['stack-name'] . ')  Created Successfully! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
          else if($status == 2 || $status == 3)
            echo '<div style="margin-top:30px;" class="alert alert-warning alert-dismissible fade show" role="alert">[' . date("Y-m-d h:i:sa") . '] Invalid <strong>Stack</strong> Type! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
	  else if($status == 4)
            echo '<div style="margin-top:30px;" class="alert alert-danger alert-dismissible fade show" role="alert">[' . date("Y-m-d h:i:sa") . '] <strong>Stack</strong> Creation Failed! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';


        }

      ?>
    </div>

  </div>


  <div class='row justify-content-center' style="margin-top:15px;">
    <div class='col-sm'>

      <div class="card" style="width: 20rem;">
        <img class="card-img-top" style="height:300px;" src="https://avatars0.githubusercontent.com/u/5647000?s=200&v=4" alt="Card image cap">
        <div class="card-body">
          <h4 class="card-title">Service 1 - 4i_2n_1v</h4>
          <p class="card-text">Two networks each containing two instances are connected to a VyOS VNF. The VNF also connects to the provider network to provide external connectivity.</p>
          <a href="demo.php?type=1" class="btn btn-primary">Create Stack</a>
        </div>
      </div>
    
    </div>

    <div class='col-sm'>

      <div class="card" style="width: 20rem;">
        <img class="card-img-top" style="height:300px;" src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e6/OpenStack%C2%AE_Logo_2016.svg/1200px-OpenStack%C2%AE_Logo_2016.svg.png" alt="Card image cap">
        <div class="card-body">
          <h4 class="card-title">Service 2 - 4i_2n_2v</h4>
          <p class="card-text">Two networks each containing two instances are each connected to a VyOS VNF. Both VyOS VNFs are then connected to an OpenStack router.</p><br>
          <a href="demo.php?type=2" class="btn btn-primary">Create Stack</a>
        </div>
      </div>

    </div>

    <div class='col-sm'>

      <div class="card" style="width: 20rem;">
        <img class="card-img-top" style="height:300px;" src="https://webobjects2.cdw.com/is/image/CDW/3759609?$product-main$" alt="Card image cap">
        <div class="card-body">
          <h4 class="card-title">Service 3 - 2i_1n_1v</h4>
          <p class="card-text">Two instances are connected to a network which resides behind a VyOS VNF. By default, outbound traffic is natted.</p><br>
          <a href="demo.php?type=3" class="btn btn-primary">Create Stack</a>
        </div>
      </div>

    </div>



  </div>
</div>

</body>
</html>
