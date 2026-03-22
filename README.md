
# SVG Sprite Sprint

A UI for building performant, accessible SVG sprites. Dump icon folders in, pick the ones you want, get a production-ready `<symbol>` sprite with copy/pastable `<use>` snippets.

## Why

- Icon fonts are a bad way to icon
- SVG sprites give full control over style, color, and size
- Accessible by default (`<title>`, `aria-label`, `role="img"`)
- Icons can be difficult or messy to search — this makes it easy

## Requirements

- PHP 7+ (uses `DOMDocument` for SVG parsing)
- No build step, no npm, no dependencies — just PHP and vanilla JS

## Usage

1. Drop SVG folders into the `icons/` directory — nest them however you want
2. Serve with any PHP server
3. Click icons to select them
4. Copy the sprite, download the `.svg`, or grab individual `<use>` snippets

## Local Development

```bash
php -S localhost:8000
```

Then open http://localhost:8000

## Deploy to Dreamhost (or any shared host)

SFTP the project to your server. That's it — no build step.

```
Upload these:
  index.php
  list-svgs.php
  api/sprite.php
  css/styles.css
  js/main.js
  icons/          ← your SVG collections
```

The `icons/` directory can be managed directly on the server via SFTP — drop folders in, refresh the page.

## Project Structure

```
index.php          Main page — layout, sidebar, tabbed output panel
list-svgs.php      PHP recursive scanner — finds SVGs, renders icon grid
api/sprite.php     POST endpoint — generates <symbol> sprite from selections
css/styles.css     All styles — CSS Grid, custom properties, no frameworks
js/main.js         All JS — vanilla ES modules, no dependencies
icons/             Your SVG collections (gitignored)
todo.md            Roadmap and feature backlog
```

## See Also

- [todo.md](todo.md) for the full roadmap
