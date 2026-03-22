/**
 * SVG Sprite Sprint — main.js
 * Vanilla JS, no dependencies
 */

// --- State ---
let spriteData = null;
let debounceTimer = null;

// --- Init ---
document.addEventListener('DOMContentLoaded', () => {
    setupCollectionNav();
    setupAccordionControls();
    setupIconSelection();
    setupTabs();
    setupOutputActions();
    setupSearch();
});

// --- Collection Nav ---
function setupCollectionNav() {
    const nav = document.querySelector('.collection-nav');
    const collections = document.querySelectorAll('.collection');

    collections.forEach((details) => {
        const heading = details.querySelector('.collection-header h3');
        if (!heading) return;

        const link = document.createElement('a');
        link.href = '#' + details.id;
        link.textContent = heading.textContent;
        link.addEventListener('click', (e) => {
            e.preventDefault();
            details.open = true;
            details.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
        nav.appendChild(link);
    });

    // Highlight active collection on scroll
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                const id = entry.target.id;
                const navLink = nav.querySelector(`a[href="#${id}"]`);
                if (navLink) {
                    navLink.classList.toggle('active', entry.isIntersecting);
                }
            });
        }, { rootMargin: '-10% 0px -80% 0px' });

        collections.forEach((c) => observer.observe(c));
    }
}

// --- Accordion Expand/Collapse ---
function setupAccordionControls() {
    const expandBtn = document.getElementById('btn-expand-all');
    const collapseBtn = document.getElementById('btn-collapse-all');
    const collections = () => document.querySelectorAll('.collection');

    expandBtn?.addEventListener('click', () => {
        collections().forEach((d) => d.open = true);
    });

    collapseBtn?.addEventListener('click', () => {
        collections().forEach((d) => d.open = false);
    });
}

// --- Icon Selection ---
function setupIconSelection() {
    // Event delegation on the collections container
    const container = document.getElementById('icon-collections');
    if (!container) return;

    container.addEventListener('click', (e) => {
        const card = e.target.closest('.icon-card');
        if (!card) return;

        // Don't toggle selection if clicking action buttons or snippet bar
        if (e.target.closest('.icon-actions') || e.target.closest('.icon-use-snippet')) return;

        card.classList.toggle('selected');
        debouncedUpdateSprite();
    });

    // Single icon copy (raw SVG)
    container.addEventListener('click', (e) => {
        const copyBtn = e.target.closest('.btn-copy-single');
        if (!copyBtn) return;

        e.stopPropagation();
        const card = copyBtn.closest('.icon-card');
        const svgRaw = card?.querySelector('.svg-raw');
        if (svgRaw) {
            copyToClipboard(svgRaw.innerHTML.trim());
            showToast('Raw SVG copied!');
        }
    });

    // Copy <use> snippet
    container.addEventListener('click', (e) => {
        const copyBtn = e.target.closest('.btn-copy-use');
        if (!copyBtn) return;

        e.stopPropagation();
        const snippet = copyBtn.dataset.snippet;
        if (snippet) {
            copyToClipboard(snippet);
            showToast('Use snippet copied!');
        }
    });
}

// --- Tabs ---
function setupTabs() {
    const tabs = document.querySelectorAll('.tab');

    tabs.forEach((tab) => {
        tab.addEventListener('click', () => {
            // Deactivate all
            tabs.forEach((t) => {
                t.classList.remove('active');
                t.setAttribute('aria-selected', 'false');
            });

            document.querySelectorAll('.tab-panel').forEach((p) => {
                p.classList.remove('active');
                p.hidden = true;
            });

            // Activate clicked
            tab.classList.add('active');
            tab.setAttribute('aria-selected', 'true');

            const panel = document.getElementById(tab.getAttribute('aria-controls'));
            if (panel) {
                panel.classList.add('active');
                panel.hidden = false;
            }
        });
    });
}

// --- Output Action Buttons ---
function setupOutputActions() {
    document.querySelector('.btn-copy-sprite')?.addEventListener('click', () => {
        if (spriteData?.sprite) {
            copyToClipboard(spriteData.sprite);
            showToast('Sprite copied!');
        }
    });

    document.querySelector('.btn-download-sprite')?.addEventListener('click', () => {
        if (spriteData?.sprite) {
            downloadFile(spriteData.sprite, 'sprite.svg', 'image/svg+xml');
        }
    });

    document.querySelector('.btn-clear')?.addEventListener('click', () => {
        document.querySelectorAll('.icon-card.selected').forEach((card) => {
            card.classList.remove('selected');
        });
        spriteData = null;
        updateOutputPanel(null);
    });
}

// --- Search / Filter ---
function setupSearch() {
    const input = document.getElementById('icon-search');
    if (!input) return;

    input.addEventListener('input', () => {
        const query = input.value.toLowerCase().trim();
        const cards = document.querySelectorAll('.icon-card');
        const collections = document.querySelectorAll('.collection');

        cards.forEach((card) => {
            const name = card.dataset.iconName || '';
            const match = !query || name.includes(query);
            card.classList.toggle('hidden', !match);
        });

        // Hide collections with no visible cards
        collections.forEach((col) => {
            const visibleCards = col.querySelectorAll('.icon-card:not(.hidden)');
            col.classList.toggle('hidden', visibleCards.length === 0);
            if (query && visibleCards.length > 0) {
                col.open = true;
            }
        });
    });
}

// --- Sprite Generation ---
function debouncedUpdateSprite() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(updateSprite, 250);
}

async function updateSprite() {
    const selected = document.querySelectorAll('.icon-card.selected');
    const count = selected.length;

    // Update count
    document.querySelector('.selection-count').textContent =
        `${count} icon${count !== 1 ? 's' : ''} selected`;

    if (count === 0) {
        spriteData = null;
        updateOutputPanel(null);
        return;
    }

    const files = Array.from(selected).map((card) => card.dataset.filepath);

    try {
        const resp = await fetch('api/sprite.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ files })
        });

        if (!resp.ok) throw new Error(`HTTP ${resp.status}`);

        spriteData = await resp.json();
        updateOutputPanel(spriteData);
    } catch (err) {
        console.error('Sprite generation failed:', err);
        showToast('Error generating sprite');
    }
}

// --- Update Output Panel ---
function updateOutputPanel(data) {
    const previewGrid = document.querySelector('.preview-grid');
    const spriteCode = document.querySelector('.sprite-code');
    const usageList = document.querySelector('.usage-list');

    const copyBtn = document.querySelector('.btn-copy-sprite');
    const downloadBtn = document.querySelector('.btn-download-sprite');
    const clearBtn = document.querySelector('.btn-clear');

    if (!data || !data.sprite) {
        previewGrid.innerHTML = '<p class="placeholder-text">Select icons to build a sprite</p>';
        spriteCode.textContent = '';
        usageList.innerHTML = '';
        copyBtn.disabled = true;
        downloadBtn.disabled = true;
        clearBtn.disabled = true;
        return;
    }

    copyBtn.disabled = false;
    downloadBtn.disabled = false;
    clearBtn.disabled = false;

    // --- Preview tab ---
    // Inject sprite into a hidden container so <use> references work
    let hiddenSprite = document.getElementById('hidden-sprite-container');
    if (!hiddenSprite) {
        hiddenSprite = document.createElement('div');
        hiddenSprite.id = 'hidden-sprite-container';
        hiddenSprite.style.cssText = 'position:absolute;width:0;height:0;overflow:hidden';
        document.body.appendChild(hiddenSprite);
    }
    hiddenSprite.innerHTML = data.sprite;

    previewGrid.innerHTML = data.usage.map((item) => `
        <div class="preview-icon" title="${item.label}">
            <svg role="img" aria-label="${item.label}"><use href="#${item.id}"></use></svg>
        </div>
    `).join('');

    // --- Sprite tab ---
    spriteCode.textContent = data.sprite;

    // --- Usage tab ---
    usageList.innerHTML = data.usage.map((item) => `
        <li>
            <code class="usage-snippet">${escapeHtml(item.snippet)}</code>
            <button class="btn-icon btn-copy-snippet" title="Copy" data-snippet="${escapeAttr(item.snippet)}">
                <svg class="ui-icon" viewBox="0 0 16 16" aria-hidden="true"><use href="#ui-paste"></use></svg>
            </button>
        </li>
    `).join('');

    // Copy snippet buttons
    usageList.querySelectorAll('.btn-copy-snippet').forEach((btn) => {
        btn.addEventListener('click', () => {
            copyToClipboard(btn.dataset.snippet);
            showToast('Snippet copied!');
        });
    });
}

// --- Clipboard ---
async function copyToClipboard(text) {
    try {
        await navigator.clipboard.writeText(text);
    } catch {
        // Fallback for HTTP / older browsers
        const ta = document.createElement('textarea');
        ta.value = text;
        ta.style.cssText = 'position:fixed;left:-9999px;top:-9999px';
        document.body.appendChild(ta);
        ta.select();
        document.execCommand('copy');
        document.body.removeChild(ta);
    }
}

// --- Download ---
function downloadFile(content, filename, mimeType) {
    const blob = new Blob([content], { type: mimeType });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    a.click();
    URL.revokeObjectURL(url);
}

// --- Toast ---
function showToast(message) {
    const toast = document.getElementById('copy-toast');
    if (!toast) return;

    toast.textContent = message;
    toast.classList.add('show');

    setTimeout(() => toast.classList.remove('show'), 1500);
}

// --- Helpers ---
function escapeHtml(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
}

function escapeAttr(str) {
    return str.replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/'/g, '&#39;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
}
