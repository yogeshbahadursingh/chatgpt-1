# Compact navbar — theme 2.3.4

At the owner's request, the navbar now pairs a small complete logo with the native editable site name. Logo width is 64px on desktop and 48px on mobile, replacing the previous 156px/132px treatment. The duplicate tagline is hidden in this compact header; the native site name stays visible. The logo's link retains a minimum 44px target height.

The hero and footer artwork, original PNG, content, routes, navigation links and PPT Core 2.3.3 are unchanged. The theme version and stylesheet cache version are 2.3.4. Existing saved template parts are preserved; local QA updated only the saved header Site Logo width to 64px.

Install the updated theme ZIP on staging. A saved header still uses the compact CSS, but set its native Site Logo width to 64px in Appearance → Editor for matching responsive image hints. Production has not been deployed and still requires approval.

Verification and package details are recorded in `qa-evidence/navbar-2.3.4`. Screenshots: [desktop](navbar-compact-desktop.png) and [mobile](navbar-compact-mobile.png). The full architecture/commerce baseline remains in QA-REPORT.md; this is a targeted layout adjustment.

## Verified results

- Logo, visible name and layout across seven widths, two-page accessibility, schema and image integrity: 11/11 passed.
- Premium navigation, keyboard/mobile menu, sticky behavior, no-JavaScript fallback and reduced motion: 16/16 passed.
- PHP syntax: 102 files passed; installed source: 152/152 matched.
- Desktop (1366px) and mobile (375px) screenshots visually inspected.

- people-planet-thrive.zip: 1955862 bytes; SHA-256 `3d0c22be25070943b40739c7b0084a26d6dbad4189df1297855b6c5a89f4eccd`.
- ppt-core.zip: 46779 bytes; SHA-256 `01b6a8a3522a4b485aa4cb6a559ca1f3f031fc126567dd568a53e034cf7b605a`.
