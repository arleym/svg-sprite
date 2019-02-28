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
  <svg style="display:none">
    <defs>
      <?php /* Yup, went there! This is a sprite of SVGs in this app UI

        <svg class="icon-paste" viewBox="0 0 16 16" aria-hidden="true">
          <use xlink:href="#icon-paste"></use>
        </svg>
      */?>
      <symbol>
        <g id="icon-paste">
          <path d="M14.5 2h-4.5c0-1.105-0.895-2-2-2s-2 0.895-2 2h-4.5c-0.276 0-0.5 0.224-0.5 0.5v13c0 0.276 0.224 0.5 0.5 0.5h13c0.276 0 0.5-0.224 0.5-0.5v-13c0-0.276-0.224-0.5-0.5-0.5zM8 1c0.552 0 1 0.448 1 1s-0.448 1-1 1c-0.552 0-1-0.448-1-1s0.448-1 1-1zM14 15h-12v-12h2v1.5c0 0.276 0.224 0.5 0.5 0.5h7c0.276 0 0.5-0.224 0.5-0.5v-1.5h2v12z"></path>
          <path d="M7 13.414l-3.207-3.707 0.914-0.914 2.293 1.793 4.293-3.793 0.914 0.914z"></path>
        </g>
      </symbol>
    </defs>
  </svg>

  <div class="container-fluid">
    <div class="row">
      <div class="col-md-2 bg-light">
        <div class="svg-toolbar p-4">
          <h4>Sprite</h4>
          <div id="" class="mb-4 small">
            <button id="svg-sprite-copyer" class="btn btn-primary btn-sm d-block mb-1" data-clipboard-action="copy" data-clipboard-target="#svg-shortlist">Cut All SVGs</button>
            <div id="svg-shortlist" class="bg-white border border-primary"></div>
          </div>

          <h4>Collections</h4>
          <ol id="svg-nav" class="navbar d-block m-0 p-0" role="navigation" aria-label="Main navigation">
          </ol>
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

  <!-- 3 Bootstrap JS dependencies -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

  <!-- https://clipboardjs.com/ -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>

  <!-- App JS -->
  <script src="js/main.js"></script>
</body>
</html>
