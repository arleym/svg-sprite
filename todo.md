# SVG Sprite Sprint — TODO

## Stack & Hosting

- Hosted on Dreamhost shared server (PHP available, no Node.js runtime)
- Keep PHP backend for SVG discovery/processing
- Modernize frontend with vanilla JS (ES modules), drop jQuery dependency
- Replace Bootstrap 4 with modern CSS (grid, custom properties, container queries)
- No build step required — just upload and go
- Use SVGO as a local CLI tool for pre-processing icons before upload (not runtime)

---

## Phase 1: Core Sprite Output (the whole point)

- [ ] Generate proper `<symbol>` sprite from selected SVGs
  - Wrap selections in `<svg xmlns="http://www.w3.org/2000/svg" style="display:none"><defs>...</defs></svg>`
  - Convert each SVG to `<symbol id="icon-name" viewBox="...">` with paths inside
  - Auto-derive `id` from filename (sanitize: lowercase, hyphens, no spaces)
- [ ] Show copyable `<use>` reference per icon: `<svg><use href="#icon-name"></use></svg>`
- [ ] Add accessible markup to generated output
  - `<title>` element inside each `<symbol>`
  - `aria-hidden="true"` on the sprite container
  - Usage snippets show `role="img" aria-label="Icon Name"` pattern
- [ ] Code comments in sprite output for easy identification of each icon

## Phase 2: Output Panel Overhaul

- [ ] Replace raw `#svg-shortlist` blob with a tabbed output panel:
  - **Preview tab**: rendered icons via `<use>` references
  - **Sprite tab**: full `<svg><defs>...</defs></svg>` block, syntax-highlighted, one-click copy
  - **Usage tab**: list of `<use href="#icon-name">` snippets for each selected icon
- [ ] Download sprite as `.svg` file button
- [ ] Clear selection button: empty output, deselect all icons
- [ ] Auto-deselect all after "Copy All" (or offer the option)

## Phase 3: Selection UX

- [ ] Select-all / deselect-all per collection (accordion section)
- [ ] Global search/filter input — typing "arrow" filters across all collections
- [ ] Selection count badge in toolbar: "12 icons selected"
- [ ] Keyboard navigation: arrow keys between icons, space to toggle
- [ ] Drag/rubber-band selection across the icon grid (stretch goal)

## Phase 4: SVG Cleanup

- [ ] Use SVGO locally (CLI) to pre-clean icons before uploading to server
- [ ] PHP-side cleanup as fallback:
  - Strip `width`/`height` attributes, preserve `viewBox`
  - Remove hardcoded `fill` attributes so icons inherit `currentColor`
  - Strip editor metadata (Sketch, Illustrator, Inkscape comments)
  - Normalize `viewBox` format
- [ ] This replaces the CSS scaling hacks for oversized icons (1024px etc.)

## Phase 5: Modernize Frontend (no jQuery, no Bootstrap)

- [ ] Replace jQuery with vanilla JS (ES modules)
  - `document.querySelector` / `querySelectorAll` for DOM
  - `fetch` for any async needs
  - Event delegation for dynamic elements
  - Native `IntersectionObserver` for scroll tracking (replaces scrollspy)
- [ ] Replace Bootstrap grid/accordion with:
  - CSS Grid for icon layout
  - `<details>/<summary>` for accordion sections (native, accessible, zero JS)
  - CSS custom properties for theming
- [ ] Keep Clipboard.js (it's small and handles edge cases well) or replace with `navigator.clipboard.writeText()`

## Phase 6: State Persistence

- [ ] LocalStorage for selections (survives page refresh)
- [ ] URL hash encoding for shareable links: `#icons=arrow-left,check,close`
- [ ] Export/import selection manifest as JSON for team sharing

## Phase 7: Preview & Polish

- [ ] Dark/light mode toggle for previewing icons on different backgrounds
- [ ] Icon size slider to preview at 16px, 24px, 32px, 48px
- [ ] Color picker to preview icons with different fill colors
- [ ] Clipboard copy confirmation tooltips (replaces alert/no-feedback)
- [ ] Fix nav overflow for long folder names (overflow-x scroll, right-align text)
- [ ] Sticky toolbar that stays fixed only when it fits in viewport

## Phase 8: Nice-to-Haves

- [ ] Drag-and-drop zone to upload new SVGs from browser (PHP handles file write)
- [ ] Diff view: compare current sprite with a previously exported one
- [ ] Icon count per collection shown in nav
- [ ] Lazy-load icon sections for large collections (IntersectionObserver)
- [ ] Remember last-used collections via LocalStorage

---

## Done (from original development)

- [x] Recursive SVG discovery from nested directories
- [x] Accordion-based organization by folder
- [x] Dynamic navigation sidebar with scrollspy
- [x] Individual SVG selection with visual feedback
- [x] Copy single SVG code to clipboard
- [x] Copy multiple selected SVGs to clipboard
- [x] Download individual SVG files
- [x] Show/Hide all collections
- [x] CSS normalization for inconsistent SVG sizes
- [x] Icon counter per collection
