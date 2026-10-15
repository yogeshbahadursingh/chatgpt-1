# NexSec Labs theme attribution — 15 October 2026

Completed in local development at `http://127.0.0.1:8877`, on branch `codex/nexsec-theme-attribution`. Production was not changed and no release package was prepared.

## Theme inspected

The active theme is the existing custom standalone WordPress block theme in `people-planet-thrive`. WordPress reports both `stylesheet` and `template` as `people-planet-thrive`, `is_child_theme()` is false, and the root stylesheet has no parent `Template` field. Its existing PPT templates, patterns and integration code identify this as the project's custom theme, rather than an unmodified stock theme. No new theme was created or activated.

## Files changed

- `source/people-planet-thrive/style.css`: edited only the four requested lines in its existing comment header:
  - Theme Name: NexSec Labs Theme
  - Author: NexSec Labs
  - Author URI: https://nexseclabs.co.uk/
  - Description: Custom WordPress theme designed and developed by NexSec Labs for People & Planet Thrive.
- `source/people-planet-thrive/README.md`: identifies NexSec Labs as developer and People & Planet Thrive as client; explains the unchanged internal identity and ownership boundaries. Corrects its stale displayed version from 2.4.0 to the already-current 2.4.1.
- This handover and `docs/qa-evidence/nexsec-attribution/`: verification records and the actual WordPress Theme Details screenshot.

Only the two theme files above were copied into the existing local installation. Version remains **2.4.1** in the stylesheet and theme constant. Theme URI, directory/package identifiers, text domain, translation configuration, compatibility fields, licence, licence URL, client tagline, copyright/ownership wording and update configuration remain unchanged. All other installed theme files have identical SHA-256 hashes. No plugin, business content, footer backlink or setting was changed by the implementation.

## Actual checks

| Check | Result |
|---|---|
| Appearance → Themes active card | PASS: “NexSec Labs Theme” |
| Theme Details | PASS: “NexSec Labs”, linking to `https://nexseclabs.co.uk/`, with requested description and version 2.4.1; screenshot inspected |
| Active identity / parent | PASS: same stylesheet/template identifiers; standalone, no parent |
| Root stylesheet preservation | PASS: comparison found only the four requested header changes; remainder preserved |
| Installed theme file comparison | PASS: only `style.css` and `README.md` changed |
| Saved navigation, template parts, templates and global styles | PASS: hashes unchanged |
| About, Terms, Terms review draft, Work With Us, Checkout and Privacy page records | PASS: hashes unchanged |
| Theme mods, site identity, inspected WooCommerce settings, currency, page assignments and enquiry settings | PASS: hashes unchanged |
| About, Work With Us and Publications at 390px / 1440px | PASS: all six responses HTTP 200, one H1, no horizontal overflow; all six viewport screenshots byte-identical before/after |
| Public copy | PASS: About and Work With Us text hashes match. Initial immediate-load Publications text hashes differed; a targeted original/new/restored-header comparison after network/font readiness produced identical normalised full text in all three observations. No public NexSec attribution appeared on these pages. |
| Mobile menu | PASS: Enter opens, Escape closes and restores focus |
| Desktop menu | PASS: Publications link navigates to the correct route |
| Temporary local admin session | Removed after verification |

Browser verification used Chromium. The Themes dialog's outer wrappers have zero height despite their fixed-position visible contents; verification targeted the visible `.theme-wrap` after inspecting the DOM and screenshot. No admin UI change was necessary.

## Limits and rollback

Production Appearance → Themes and other browsers are **unverified** for this change. No production login, redesign, deployment, theme activation, purchase, payment, customer message or release build was performed. Existing release ZIPs remain the previous packages; this attribution change is source/development-only until the established versioning and packaging process prepares a subsequent approved release.

To undo the local attribution, restore only the two backed-up files in `runtime/nexsec/style.before.css` and `runtime/nexsec/README.before.md` to their corresponding source and installed-theme paths. No database restoration or theme switch is needed. Alternatively revert the attribution commit. Preserve any later edits before restoring a backup.
