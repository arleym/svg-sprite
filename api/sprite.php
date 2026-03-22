<?php
/**
 * Sprite Generator API
 *
 * POST JSON: { "files": ["icons/feather/arrow-left.svg", ...] }
 * Returns JSON: { "sprite": "<svg>...</svg>", "usage": [...] }
 */

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'POST required']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['files']) || !is_array($input['files'])) {
    http_response_code(400);
    echo json_encode(['error' => 'JSON body with "files" array required']);
    exit;
}

$baseDir = realpath(__DIR__ . '/..');
$symbols = [];
$usage = [];
$seenIds = [];

foreach ($input['files'] as $relativePath) {
    // Security: only allow files under icons/ ending in .svg
    if (!preg_match('/^icons\//', $relativePath) || !preg_match('/\.svg$/i', $relativePath)) {
        continue;
    }

    $fullPath = realpath($baseDir . '/' . $relativePath);

    // Security: ensure resolved path is within our project
    if (!$fullPath || strpos($fullPath, $baseDir . '/icons/') !== 0) {
        continue;
    }

    if (!file_exists($fullPath)) {
        continue;
    }

    $svgContent = file_get_contents($fullPath);
    if (!$svgContent) {
        continue;
    }

    // Derive ID from path: icons/feather/arrow-left.svg -> icon-feather-arrow-left
    $idBase = preg_replace('/^icons\//', '', $relativePath);
    $idBase = preg_replace('/\.svg$/i', '', $idBase);
    $id = 'icon-' . preg_replace('/[^a-z0-9]+/', '-', strtolower($idBase));
    $id = trim($id, '-');

    // Handle duplicate IDs
    if (isset($seenIds[$id])) {
        $seenIds[$id]++;
        $id .= '-' . $seenIds[$id];
    } else {
        $seenIds[$id] = 1;
    }

    // Derive human-readable title
    $basename = basename($relativePath, '.svg');
    $title = ucwords(str_replace(['-', '_'], ' ', $basename));

    // Parse SVG to extract viewBox and inner content
    $viewBox = '0 0 24 24'; // fallback
    $innerContent = '';

    libxml_use_internal_errors(true);
    $doc = new DOMDocument();
    $loaded = $doc->loadXML($svgContent);

    if ($loaded) {
        $svgElements = $doc->getElementsByTagName('svg');
        if ($svgElements->length > 0) {
            $svgEl = $svgElements->item(0);

            // Extract viewBox
            if ($svgEl->hasAttribute('viewBox')) {
                $viewBox = $svgEl->getAttribute('viewBox');
            } elseif ($svgEl->hasAttribute('width') && $svgEl->hasAttribute('height')) {
                $w = $svgEl->getAttribute('width');
                $h = $svgEl->getAttribute('height');
                // Strip units like "px"
                $w = preg_replace('/[^0-9.]/', '', $w);
                $h = preg_replace('/[^0-9.]/', '', $h);
                $viewBox = "0 0 $w $h";
            }

            // Extract inner content (children of <svg>)
            $inner = '';
            foreach ($svgEl->childNodes as $child) {
                $inner .= $doc->saveXML($child);
            }
            // Clean up: remove XML declarations, comments with editor metadata
            $inner = preg_replace('/<!--.*?-->/s', '', $inner);
            $inner = trim($inner);
            if ($inner) {
                $innerContent = $inner;
            }
        }
    }

    libxml_clear_errors();

    // Fallback: regex extraction if DOM parsing failed
    if (!$innerContent) {
        // Try to get viewBox via regex
        if (preg_match('/viewBox=["\']([^"\']+)["\']/', $svgContent, $m)) {
            $viewBox = $m[1];
        }
        // Get content between <svg...> and </svg>
        if (preg_match('/<svg[^>]*>(.*)<\/svg>/s', $svgContent, $m)) {
            $innerContent = trim($m[1]);
        }
    }

    if (!$innerContent) {
        continue;
    }

    // Remove hardcoded fill attributes (so icons inherit currentColor)
    // But keep fill="none" and fill="currentColor" as they're intentional
    $cleanedContent = preg_replace('/\s+fill="(?!none|currentColor)[^"]*"/', '', $innerContent);

    // Build the symbol with usage comment
    $useSnippet = "<svg><use href=\"#$id\"></use></svg>";
    $symbol = "  <!-- $id\n";
    $symbol .= "       Usage: $useSnippet -->\n";
    $symbol .= "  <symbol id=\"$id\" viewBox=\"$viewBox\">\n";
    $symbol .= "    <title>$title</title>\n";
    $symbol .= "    $cleanedContent\n";
    $symbol .= "  </symbol>";

    $symbols[] = $symbol;

    $usage[] = [
        'id' => $id,
        'label' => $title,
        'snippet' => "<svg role=\"img\" aria-label=\"$title\"><use href=\"#$id\"></use></svg>"
    ];
}

if (empty($symbols)) {
    echo json_encode(['sprite' => '', 'usage' => []]);
    exit;
}

// Build the full sprite
$sprite = "<svg xmlns=\"http://www.w3.org/2000/svg\" aria-hidden=\"true\" style=\"position:absolute;width:0;height:0;overflow:hidden\">\n";
$sprite .= "<defs>\n";
$sprite .= implode("\n\n", $symbols) . "\n";
$sprite .= "</defs>\n";
$sprite .= "</svg>";

echo json_encode([
    'sprite' => $sprite,
    'usage' => $usage
]);
