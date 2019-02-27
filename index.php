<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>SVG Sprite Sprint</title>
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="css/styles.css">
</head>
<body class="position-relative" data-spy="scroll" data-target="#svg-nav" data-offset="0">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-2 bg-light">
        <div class="p-4" style="position: fixed;">
          <h4>SVG Collections</h4>
          <nav id="svg-nav" class="navbar navbar-light d-block m-0 p-0" role="navigation" aria-label="Main navigation">
          </nav>
        </div>
      </div><!-- col -->
      <div class="col-md-10">
        <div class="p-4 position-relative">
          <div class="row mb-4">
            <div class="col"><h1>SVG Sprite Sprint</h1></div>
            <div class="col">
              <div class="small text-right">
                <button id="all-show">Show all</button>
                <button id="all-hide">Hide all</button>
              </div>
            </div>
          </div>
          <?php include('list-svgs.php'); ?>
        </div>
      </div><!-- col -->

    </div><!-- row -->
  </div><!-- container -->

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="js/main.js"></script>
</body>
</html>
