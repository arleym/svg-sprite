<?php
/**
 * Recursively find all SVG files in the icons/ directory
 * and render them as <details>/<summary> accordion sections.
 */

function findFiles($directory, $extensions = []) {
    function glob_recursive($directory, &$directories = []) {
        foreach (glob($directory, GLOB_ONLYDIR | GLOB_NOSORT) as $folder) {
            $directories[] = $folder;
            glob_recursive("{$folder}/*", $directories);
        }
    }

    glob_recursive($directory, $directories);
    $i = 0;

    foreach ($directories as $dir) {
        // Collect SVG files in this directory
        $svgFiles = [];
        foreach ($extensions as $ext) {
            foreach (glob("{$dir}/*.{$ext}") as $file) {
                $svgFiles[] = $file;
            }
        }

        $count = count($svgFiles);
        if ($count === 0) continue;

        // Strip "icons/" prefix for display
        $displayName = preg_replace('/^icons\//', '', $dir);
        $isFirst = ($i === 0);
        ?>
        <details class="collection" id="collection-<?php echo $i; ?>"<?php if ($isFirst) echo ' open'; ?>>
            <summary class="collection-header">
                <h3><?php echo htmlspecialchars($displayName); ?></h3>
                <span class="collection-count"><?php echo $count; ?> SVGs</span>
            </summary>
            <div class="icon-grid">
                <?php foreach ($svgFiles as $file):
                    $basename = basename($file, '.svg');
                    $iconName = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $basename));
                    // Build the symbol ID the same way api/sprite.php does
                    $idBase = preg_replace('/^icons\//', '', $file);
                    $idBase = preg_replace('/\.svg$/i', '', $idBase);
                    $symbolId = 'icon-' . trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($idBase)), '-');
                    $useSnippet = '<svg><use href="#' . $symbolId . '"></use></svg>';
                ?>
                <div class="icon-card" data-filepath="<?php echo htmlspecialchars($file); ?>" data-icon-name="<?php echo htmlspecialchars($iconName); ?>" data-symbol-id="<?php echo htmlspecialchars($symbolId); ?>">
                    <div class="icon-preview">
                        <div class="svg-raw"><?php include $file; ?></div>
                    </div>
                    <div class="icon-info">
                        <span class="icon-label"><?php echo htmlspecialchars($basename); ?></span>
                    </div>
                    <div class="icon-use-snippet">
                        <code class="use-code"><?php echo htmlspecialchars($useSnippet); ?></code>
                        <button type="button" class="btn-icon btn-copy-use" title="Copy use snippet" data-snippet="<?php echo htmlspecialchars($useSnippet); ?>">
                            <svg class="ui-icon" viewBox="0 0 16 16" aria-hidden="true"><use href="#ui-paste"></use></svg>
                        </button>
                    </div>
                    <div class="icon-actions">
                        <a href="<?php echo htmlspecialchars($file); ?>" download class="btn-icon" title="Download SVG">
                            <svg class="ui-icon" viewBox="0 0 512 512" aria-hidden="true"><use href="#ui-download"></use></svg>
                        </a>
                        <button type="button" class="btn-icon btn-copy-single" title="Copy raw SVG">
                            <svg class="ui-icon" viewBox="0 0 16 16" aria-hidden="true"><use href="#ui-paste"></use></svg>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </details>
        <?php
        $i++;
    }
}

findFiles("icons", ["svg"]);
