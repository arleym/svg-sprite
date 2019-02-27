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
    echo "<div class='position-relative'><a class='d-block card' data-toggle='collapse' href='#collaps" . $i . "' role='button' aria-expanded='false' aria-controls='collaps" . $i . "'>";
    echo "<h1 class='js-svg-collection'>" . $directory . "</h1></a><section class='w-icons collapse' id='collaps" . $i . "'>";

    foreach($extensions as $extension) {

      // a SVG counter variable
      $svg = 0;
      foreach(glob("{$directory}/*.{$extension}") as $file) {
        $files[$extension][] = $file;

        // wrap the icon and output with label
        echo "<label class='svg-icon'>";
          include $file;
          echo "<div class='p-2'><input class='js-spritecheck' type='checkbox'>";
          echo "<div class='icon-label'>";
          // echo dirname($file, 1); // we could list the path
          echo basename($file, '.svg').PHP_EOL;
        echo "</div></div></label>\n\n";

        $svg++;
      }
    }
    echo "</section><span class='svg-count'>" . $svg . " SVGs</div>";
    $i++;
  }
}

// echo the SVGs
$files = findFiles("icons", ["svg"]);
