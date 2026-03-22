# SVG Sprite Sprint — TODO

## Stack & Hosting

- Hosted on Dreamhost shared server (PHP available, no Node.js runtime)
- Keep PHP backend for SVG discovery/processing
- Modernize frontend with vanilla JS (ES modules), drop jQuery dependency
- Replace Bootstrap 4 with modern CSS (grid, custom properties, container queries)
- No build step required — just upload and go
- Use SVGO as a local CLI tool for pre-processing icons before upload (not runtime)

---

## Phase 1: Core Sprite Output — DONE

- [x] Generate proper `<symbol>` sprite from selected SVGs
- [x] Show copyable `<use>` reference per icon (on-card snippet bar + Usage tab)
- [x] Add accessible markup (`<title>`, `aria-hidden`, `role="img"`, `aria-label`)
- [x] Code comments in sprite output with copy/pastable `<use>` snippets

## Phase 2: Output Panel Overhaul — DONE

- [x] Tabbed output panel: Preview / Sprite / Usage
- [x] Download sprite as `.svg` file
- [x] Clear selection button
- [x] Copy sprite button

## Phase 3: Selection UX — DONE

- [x] Select-all / deselect-all per collection (appears on hover)
- [x] Global search/filter input
- [x] Selection count badge: "12 icons selected"
- [x] Keyboard navigation: arrow keys to move, space to toggle selection
- [ ] Drag/rubber-band selection across the icon grid (stretch goal)

## Phase 4: SVG Cleanup — DONE

- [ ] Use SVGO locally (CLI) to pre-clean icons before uploading to server
- [x] PHP-side cleanup in api/sprite.php:
  - Strip `width`/`height` attributes, preserve `viewBox`
  - Remove hardcoded `fill` attributes (keep `fill="none"` and `fill="currentColor"`)
  - Strip editor metadata (Sketch, Illustrator, Inkscape namespaces + attributes)
  - Strip `data-name` attributes, empty `<g>` wrappers
  - Collapse whitespace

## Phase 5: Modernize Frontend — DONE

- [x] Replace jQuery with vanilla JS (ES modules, event delegation, fetch)
- [x] Replace Bootstrap with CSS Grid, `<details>/<summary>`, custom properties
- [x] Replace Clipboard.js with `navigator.clipboard.writeText()` + fallback

## Phase 6: State Persistence — DONE

- [x] LocalStorage for selections (survives page refresh)
- [ ] URL hash encoding for shareable links: `#icons=arrow-left,check,close`
- [ ] Export/import selection manifest as JSON for team sharing

## Phase 7: Preview & Polish — DONE

- [x] Dark/light mode toggle for previewing icons on different backgrounds
- [x] Icon size slider (16px–64px)
- [x] Color picker to preview icons with different fill colors
- [x] Toast notifications for copy confirmations
- [x] Sticky sidebar with scroll
- [ ] Fix nav overflow for long folder names (overflow-x scroll, right-align text)

## Phase 8: Nice-to-Haves

- [ ] Drag-and-drop zone to upload new SVGs from browser (PHP handles file write)
- [ ] Diff view: compare current sprite with a previously exported one
- [ ] Icon count per collection shown in nav
- [ ] Lazy-load icon sections for large collections (IntersectionObserver)
- [ ] Remember last-used collections via LocalStorage
- [ ] URL hash encoding for shareable selections

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
