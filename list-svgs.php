<?php

// echo the SVGs listed in functions.php
$files = findFiles("icons", ["svg"]);
foreach ($files as $file) {
  echo "<label class='svg-icon'>";
    include $file;
    echo "<div class='p-2'><input class='js-spritecheck' type='checkbox'>";
    echo "<div class='icon-label'>";
    echo basename($file, '.svg').PHP_EOL;
  echo "</div></div></label>\n\n";
}
