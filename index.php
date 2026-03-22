<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SVG Sprite Sprint</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <!-- UI icon sprite -->
    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" style="position:absolute;width:0;height:0;overflow:hidden">
        <defs>
            <symbol id="ui-paste" viewBox="0 0 16 16">
                <path d="M14.5 2h-4.5c0-1.105-0.895-2-2-2s-2 0.895-2 2h-4.5c-0.276 0-0.5 0.224-0.5 0.5v13c0 0.276 0.224 0.5 0.5 0.5h13c0.276 0 0.5-0.224 0.5-0.5v-13c0-0.276-0.224-0.5-0.5-0.5zM8 1c0.552 0 1 0.448 1 1s-0.448 1-1 1c-0.552 0-1-0.448-1-1s0.448-1 1-1zM14 15h-12v-12h2v1.5c0 0.276 0.224 0.5 0.5 0.5h7c0.276 0 0.5-0.224 0.5-0.5v-1.5h2v12z"/>
                <path d="M7 13.414l-3.207-3.707 0.914-0.914 2.293 1.793 4.293-3.793 0.914 0.914z"/>
            </symbol>
            <symbol id="ui-download" viewBox="0 0 512 512">
                <path d="M216 0h80c13.3 0 24 10.7 24 24v168h87.7c17.8 0 26.7 21.5 14.1 34.1L269.7 378.3c-7.5 7.5-19.8 7.5-27.3 0L90.1 226.1c-12.6-12.6-3.7-34.1 14.1-34.1H192V24c0-13.3 10.7-24 24-24zm296 376v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h146.7l49 49c20.1 20.1 52.5 20.1 72.6 0l49-49H488c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z"/>
            </symbol>
            <symbol id="ui-check" viewBox="0 0 24 24">
                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
            </symbol>
        </defs>
    </svg>

    <div class="app-layout">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-section sidebar-output">
                <h2 class="sidebar-heading">Sprite Output</h2>

                <div class="output-panel">
                    <nav class="tab-bar" role="tablist">
                        <button role="tab" aria-selected="true" aria-controls="panel-preview" id="tab-preview" class="tab active">Preview</button>
                        <button role="tab" aria-selected="false" aria-controls="panel-sprite" id="tab-sprite" class="tab">Sprite</button>
                        <button role="tab" aria-selected="false" aria-controls="panel-usage" id="tab-usage" class="tab">Usage</button>
                    </nav>

                    <div id="panel-preview" role="tabpanel" aria-labelledby="tab-preview" class="tab-panel active">
                        <div class="preview-grid">
                            <p class="placeholder-text">Select icons to build a sprite</p>
                        </div>
                    </div>

                    <div id="panel-sprite" role="tabpanel" aria-labelledby="tab-sprite" class="tab-panel" hidden>
                        <pre class="sprite-code-wrap"><code class="sprite-code"></code></pre>
                    </div>

                    <div id="panel-usage" role="tabpanel" aria-labelledby="tab-usage" class="tab-panel" hidden>
                        <ul class="usage-list"></ul>
                    </div>
                </div>

                <div class="output-actions">
                    <span class="selection-count">0 icons selected</span>
                    <div class="output-buttons">
                        <button class="btn btn-primary btn-copy-sprite" disabled>Copy Sprite</button>
                        <button class="btn btn-secondary btn-download-sprite" disabled>Download .svg</button>
                        <button class="btn btn-ghost btn-clear" disabled>Clear</button>
                    </div>
                </div>
            </div>

            <div class="sidebar-section sidebar-nav">
                <h2 class="sidebar-heading">Collections</h2>
                <nav class="collection-nav" aria-label="Icon collections"></nav>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="main-content">
            <header class="page-header">
                <h1>SVG Sprite Sprint</h1>
                <div class="header-actions">
                    <input type="search" class="search-input" id="icon-search" placeholder="Filter icons..." aria-label="Filter icons">
                    <button class="btn btn-ghost" id="btn-expand-all">Expand all</button>
                    <button class="btn btn-ghost" id="btn-collapse-all">Collapse all</button>
                </div>
            </header>

            <div class="preview-toolbar">
                <div class="toolbar-group">
                    <label class="toolbar-label" for="icon-size-slider">Size</label>
                    <input type="range" id="icon-size-slider" min="16" max="64" value="48" step="4">
                    <span class="toolbar-value" id="icon-size-value">48px</span>
                </div>
                <div class="toolbar-group">
                    <label class="toolbar-label" for="icon-color-picker">Color</label>
                    <input type="color" id="icon-color-picker" value="#222222">
                    <button class="btn btn-ghost btn-reset-color" id="btn-reset-color" title="Reset to default">Reset</button>
                </div>
                <div class="toolbar-group">
                    <button class="btn btn-ghost" id="btn-toggle-theme" title="Toggle dark/light preview">Dark mode</button>
                </div>
            </div>
            <div id="icon-collections">
                <?php include('list-svgs.php'); ?>
            </div>
        </main>
    </div>

    <div class="toast" id="copy-toast" aria-live="polite"></div>

    <script type="module" src="js/main.js"></script>
</body>
</html>
