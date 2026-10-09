# Logo update — 2.3.3, 9 October 2026

**Follow-up:** theme 2.3.4 makes the navbar logo smaller and shows the site name beside it. See [COMPACT-NAVBAR.md](COMPACT-NAVBAR.md) for current sizing and focused verification. This document retains the original 2.3.3 evidence.

The owner's supplied People & Planet Thrive logo is now included in the installable theme and uses WordPress's native Site Logo in the header, existing homepage hero position and footer. Production has not been changed. This is the logo follow-up to the 2.3.2 route, architecture and commerce repair baseline, not a claim of a new full-site acceptance run.

## Artwork and placement

- The packaged PNG is byte-for-byte identical to `People & Planet Thrive Logo (1).png`: 1536 × 1024, SHA-256 `8045f234b21f024c04a6781dd34d2b2a30c453757dec1050f625064ab06b89a5`.
- The file already contains transparency. Its full composition, colours and transparency are preserved. An ivory CSS background keeps the dark lettering readable in all three placements; a thin gold border fits the existing design.
- Header display: 156px desktop and 132px mobile; hero: 280px with its existing mobile limit; footer: up to 240px. The complete 3:2 artwork is retained. Native alt text identifies People & Planet Thrive and logo links return Home.
- Duplicate text branding is hidden only when WordPress has a configured logo. Native text branding remains the fallback. The existing animated orb, content layout and menu behavior are retained. Site Icon is not changed.

## Installation and editing

Install the two release ZIPs on staging and run **Tools → PPT Site Setup → Create / Repair Site**. If no valid native Site Logo exists, setup imports the supplied PNG into Media Library and selects it. The content hash prevents duplicate imports. A logo already chosen in WordPress is preserved; select the new artwork manually through the Site Logo block if replacing an existing brand image.

Setup generates WordPress's normal responsive sizes when a supported image editor is available. Local QA enabled PHP GD for the native regeneration command, then verified the original and responsive rendering. The original PNG is retained. Production must have a working WordPress image editor for derivative sizes.

Previously saved custom template parts remain authoritative. For the local preview, the saved header's existing Site Logo width was changed from 72px to 156px; its navigation and other blocks were preserved. On an existing site, review that setting in Appearance → Editor and add a native Site Logo to a saved custom footer if necessary. Do not discard approved custom templates wholesale. No extra logo or menu plugin is needed.

Logo upload failures produce an escaped administrator warning and allow page, WooCommerce and permalink repair to complete. A failed attachment insertion cleans up only its newly uploaded file.

## Evidence and remaining gate

The verification table and package manifest below record this release's focused checks. The previous full route/commerce matrix remains in [QA-REPORT.md](QA-REPORT.md). No optional third-party plugin, real payment, production mail delivery or hosting configuration has been certified by this logo update. The public store-route and enquiry issues in LIVE-AUDIT.md still need the approved staging-to-production process.

See [PLUGIN-GUIDE.md](PLUGIN-GUIDE.md) for the requested required/conditional plugin list and [INSTALLATION.md](INSTALLATION.md) for deployment and rollback steps. Production deployment still requires explicit human approval.

## Verification results

| Check | Result |
|---|---|
| Logo setup, permissions, preservation, error recovery | 19/19 passed |
| Logo layout, two-page axe checks, schema URL and served-file integrity | 11/11 passed |
| Premium navigation regression | 16/16 passed |
| PHP syntax | 102 files passed |
| Installed source integrity | 152/152 matched |

Evidence: [manifest](qa-evidence/logo-2.3.3/manifest.json), [setup](qa-evidence/logo-2.3.3/logo-setup-results.json), [browser](qa-evidence/logo-2.3.3/logo-browser-results.json), [navigation](qa-evidence/logo-2.3.3/navigation-premium-results.json). Automated accessibility found zero violations on Home and Insights; image/gradient contrast still requires human judgment. Desktop/mobile screenshots were visually inspected.

Previews: [desktop header and hero](logo-home-1366.png), [mobile header](logo-home-375.png), [desktop footer](logo-footer-1366.png), [mobile footer](logo-footer-375.png).

## Package manifest

- **people-planet-thrive.zip**: 130 files; 1955779 bytes; SHA-256 `b3ff2823a24f015709a72800a7c7b0cb8844c06c74234427bc55b7c6f2c63d87`.
- **ppt-core.zip**: 22 files; 46779 bytes; SHA-256 `01b6a8a3522a4b485aa4cb6a559ca1f3f031fc126567dd568a53e034cf7b605a`.
