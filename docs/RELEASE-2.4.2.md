# Upload packages — 15 October 2026

Built for review and staging upload. **No production deployment was performed.**

| Package | Version | Purpose |
|---|---|---|
| `release/people-planet-thrive.zip` | 2.4.2 | Complete NexSec Labs Theme, retaining the `people-planet-thrive` directory and client branding. Includes developer attribution, accessible orbital motion and all current theme source/assets. |
| `release/ppt-core.zip` | 2.4.1 | Complete companion plugin. Its source is unchanged by this packaging task. |

These are separate WordPress-installable packages. They are **not a database/media migration or a full-site backup**. Existing pages, orders, settings, uploads and saved Site Editor templates remain in WordPress. The About/Terms review content is outside these packages; uploading a ZIP does not publish or approve it. The Terms acceptance module remains opt-in and requires its existing explicit approval/configuration gate.

## Upload

1. Back up the target site's database, uploads, current theme and plugin. Test on staging first; production still requires approval.
2. For the latest visual update, use **Appearance → Themes → Add New Theme → Upload Theme** and select `people-planet-thrive.zip`. If WordPress shows a replacement confirmation for the existing theme, verify the same `people-planet-thrive` directory and version 2.4.2, then replace it. The displayed theme name becomes **NexSec Labs Theme**.
3. If PPT Core needs installation/update, use **Plugins → Add New Plugin → Upload Plugin** and select `ppt-core.zip`. An already-current PPT Core 2.4.1 with identical source does not need reinstalling for the orbit update. Preserve its activation state.
4. Clear relevant page/asset caches and review the homepage, mobile layout, logo and Pause/Resume control. A saved front-page template can override the packaged template: compare and selectively merge that particular override rather than resetting the whole Site Editor.
5. Do not run importers or reset site content merely to apply this theme update. Installing these packages does not require changing currencies, payment settings, public Terms or business information.

## Actual package verification

- Built with the existing `tests/build-release.ps1` process. All **106 PHP files** passed syntax lint.
- Checked every decompressed archive file against source using SHA-256: **134 theme files + 26 plugin files**, all identical. Verified package root directories, unique file entries, expected theme metadata and the required orbit files. No runtime, checkpoints, database dumps, local configuration, tests or review-content directory is included.
- Installed **these exact ZIPs** through WP-CLI on `http://127.0.0.1:8877/`. WordPress reports active NexSec Labs Theme **2.4.2** and active PPT Core **2.4.1**. All **160 installed files** match source.
- Nine post-install smoke checks passed: HTTP 200 homepage; orbital assets running; logo loaded; Pause/Resume; no horizontal overflow at 360, 768 and 1440px; static reduced motion; no console errors/unhandled exceptions.
- The earlier component suite passed 42 checks. Its remaining limits still apply: actual native background-tab switching, physical devices, Safari/Firefox and screen-reader testing are not verified. See `HERO-ORBIT-MOTION.md`. The release smoke test does not claim a new whole-site or commerce audit.
- Theme release metadata changed only in `style.css`, `functions.php` and `README.md`: 2.4.1 → 2.4.2. Theme identifiers, logo and functionality were not altered during packaging. PPT Core version remains 2.4.1.

Evidence: `docs/qa-evidence/release-2.4.2/` contains the build, archive comparison, installed comparison and browser smoke results.

## Checksums (SHA-256)

```text
cf9e0aba092e38edaed1d57feb0ae9438a7b9f0912b179151474b4e9b31f9db2  people-planet-thrive.zip
16ab9e12cdd8d4e702c902866e01f830e06d0e7f47c5ee544ec02b9b90e3369a  ppt-core.zip
```

## Rollback

Previous development ZIPs and pre-release theme metadata are preserved in `checkpoint/pre-release-2.4.2-20261015-122636/`. That checkpoint is private development material, not a production backup. For an actual site rollback, reinstall that site's own pre-update theme/plugin packages and clear caches. This packaging task did not change page content, commerce settings or the database schema. Preserve new real orders and editorial work; do not restore an old whole database over them for a file-only rollback.
