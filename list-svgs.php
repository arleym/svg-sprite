<?php
// Recursively get all svg files out of the icons directory
// via Josh & http://php.net/manual/en/function.glob.php#111217

// find all the files in folders
function findFiles($directory, $extensions = array()) {
  function glob_recursive($directory, &$directories = array()) {
    foreach(glob($directory, GLOB_ONLYDIR | GLOB_NOSORT) as $folder) {
      $directories[] = $folder;
      glob_recursive("{$folder}/*", $directories);
    }
  }
  glob_recursive($directory, $directories);
  $files = array ();

  // need a unique loop number in the directory foreach to make accordions a11y
  $i = 0;
  foreach($directories as $directory) {

    // Folder title plus a flexbox wrapper for each icon
    ?>
    <div id="svg-collection-<?php echo $i; ?>" class="js-collection position-relative">
      <a class="svg-collection-title p-2 d-block card" data-toggle="collapse" href="#collapse<?php echo $i; ?>" role="button" aria-expanded="false" aria-controls="collapse<?php echo$i; ?>">
        <h3 class="js-svg-collection h4"><?php echo $directory; ?></h3>
      </a>
      <section class="w-icons collapse" id="collapse<?php echo $i; ?>">

    <?php foreach($extensions as $extension) {

      // a SVG counter variable
      $svg = 0;
      foreach(glob("{$directory}/*.{$extension}") as $file) {
        $files[$extension][] = $file;

        // wrap the icon and output with label
        ?>
        <div class="card bg-light m-2 pb-5">
          <!-- <div class="w-icon-ui"> -->
            <a href="<?php echo $file; ?>" download class="btn-sm btn btn-light icon-ui-tiny">
              <svg class="icon-download" viewBox="0 0 512 512" aria-hidden="true">
                <use xlink:href="#icon-download"></use>
              </svg>
              Dnld
            </a>
            <button class="btn-sm btn btn-light icon-ui-tiny svg-copyer">
              <svg class="icon-paste" viewBox="0 0 16 16" aria-hidden="true">
                <use xlink:href="#icon-paste"></use>
              </svg>
              Copy
            </button>
          <!-- </div> -->
          <div class="svg-icon">
            <div class="svg-copy">
              <?php include $file; ?>
            </div>
          </div>
          <div class='p-2'>
            <div class='icon-label'>
              <input class='js-spritecheck' type='checkbox'>
              <?php echo basename($file, '.svg').PHP_EOL; ?>
            </div>
          </div>
        </div>
      <?php
        $svg++;
      }
    }
    echo "</section><span class='svg-counter'><span class='js-count'>" . $svg . "</span> SVGs</span></div>";
    $i++;
  }
}

// echo the SVGs
$files = findFiles("icons", ["svg"]);
