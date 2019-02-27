
# SVG Sprite Sprint

Looking to craft tight little SVG sprites with handy code comments to `<use>` icons as a system for a website.

## Problems this will hopefully solve
- Icon fonts are a bad way to icon
- We want better control over style, colors
- Improve Accessibility
- Icons can be difficult or messy to search 

## Goals
- Be able to dump SVG directories and collections into one folder, as messy as you please
- List all SVGs in a single document, with names for findability
- Click the icon to start building a sprite
- Cookies to remember which collections you're after
- A quick way to add entire collections

## Requirements
- A way to render PHP templates locally (like a MAMP/WAMP/LAMP/XAMPP) or a server
- Access to the interet, or grad bootstrap assets if you want the layout / accordions etc.
- To reset unpredictable inline attr on the SVG files we are using the CSS `all: unset;` which isn't supported by all browsers https://caniuse.com/#search=all

## Usage
- Dump all of your icons into the `icons` dir
- Visit index.php - requires a PHP tool like MAMP
- If you are building a long-standing icon library you may want to go as far as forking this repo and removing the icons/* from the gitignore


## TODO
- sizing all the SVGs regardless of markup
- selectable states of icons
- JS gymnastics to add icons as sprites
  - Submit button to generate the sprite on demand vs. fuzzily on check
- Add the aria stuff for the sprites in the comment block version with `<use>`
- A button to just copy the SVG as an element
- Add folders as accordions
- Accordion itself having a select-all for that collection
- if h1 has no svgs, remove
- JS to make a scrollspy from h1s
