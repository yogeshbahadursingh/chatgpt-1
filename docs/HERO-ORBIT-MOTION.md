# Homepage orbit motion — local development handover

Date: 15 October 2026. Branch: `codex/hero-orbit-motion`.
Preview: <http://127.0.0.1:8877/>. **Not deployed to production.**

## Inspection and scope

The original visual used a separate CSS sphere, two ring spans and the existing WordPress Site Logo block. It was not a flattened screenshot. In normal-motion local Chromium, the existing animation clocks advanced: a frozen screenshot alone did not demonstrate a broken animation. The old v1.2/v1.3 CSS rules overlapped and animated the whole assembly, logo and pulsing dots; the previous pointer handler moved the logo along with the orb. Reduced-motion rules deliberately disabled those animations.

This change removes those old motion rules and replaces the existing scoped controller. It adds no animation plugin, framework, WebGL, video asset used by the website, or second JavaScript animation loop. The original logo asset and Site Logo block, cream card, colour palette, sphere dimensions, page copy, buttons and surrounding template are preserved. No WordPress content, options, plugins, payments or business settings were changed. Development version remains 2.4.1.

## Changed implementation files

All paths below are relative to `source/people-planet-thrive/`.

| File | Change |
|---|---|
| `templates/front-page.html` | Replaces the two decorative spans with separate surface/depth/SVG layers; retains the original Site Logo block; adds the Pause/Resume button below the existing caption. |
| `assets/css/hero-orb.css` | New component styles. Independent positioning, depth and rotation wrappers; original sphere gradient/shadows; slow illumination; reduced-motion/static composition; visible keyboard focus. |
| `assets/css/rescue.css` | Removes only the superseded v1.2/v1.3 orb motion blocks. All CSS outside those blocks is byte-for-byte preserved. |
| `assets/js/hero-orb.js` | Replaces the old pointer controller with one guarded controller for this component, native SVG path travel, pause and visibility handling, and settling-only pointer rAF. |
| `inc/class-enqueue.php` | Enqueues the new component stylesheet on the front page, after `ppt-rescue`, using a file modification version. Retains the existing single script enqueue. |

Supporting files: `tests/orbit-motion.cjs`, `tests/orbit-recording.cjs`, this report and `docs/qa-evidence/hero-orbit/`.

## Motion and accessibility behaviour

- Each dot's native SVG motion uses the **same path data as its visible ring**: 32-second and 38-second laps. The two assemblies rotate in complementary directions over 240 and 300 seconds.
- The independent light overlay moves through transform/opacity over 17 seconds. The sphere retains its original circular shape and green/teal gradient. No animated blur is used.
- Fine-hover pointers move decorations by at most 8px radially; the surface uses 55% of that displacement. The logo card, text and buttons remain stationary. A short rAF easing sequence settles and stops; pointer leave returns gently to centre.
- The keyboard-operable control freezes both ambient clocks and pointer motion. Manual pause survives offscreen/onscreen and visibility changes. Reduced motion produces a static composition and an explanatory disabled “Animation off” control.
- An IntersectionObserver and `visibilitychange` listener suspend motion. Native SVG motion and CSS animations share the same running/paused state. Decorative elements have no pointer hit area and are hidden from assistive technology; the logo and button remain exposed.
- Without JavaScript, both dots retain static transforms, rings and sphere remain complete, and the inactive button stays hidden. Touch pointers do not trigger depth, and scrolling remains native.

## Actual verification

`node tests/orbit-motion.cjs` completed **42 checks with zero failures** against the local WordPress site. Raw results are in `docs/qa-evidence/hero-orbit/test-results.json`.

| Check | Result |
|---|---|
| Running motion / no duplicate animations | PASS: three CSS animations and two SVG motion elements; clocks advance. Re-running the controller adds no extra motions or duplicate button action. |
| Path alignment | PASS: 15 timeline samples over 76 seconds, including both wrap points. Maximum measured error 0.154 SVG units, below 0.1 CSS pixel at the largest tested sphere. |
| Loop seam | PASS: positions immediately before/after each lap differed by less than 1 CSS pixel, consistent with continuous travel. |
| Logo/card and hero copy | PASS: identical bounding rectangles during ambient and pointer motion. Source Logo block unchanged. |
| Pointer and pause | PASS: bounded depth, stationary logo, gentle return, all clocks and depth frozen by Pause, no pointer rAF after settling. |
| Keyboard | PASS: reachable by Tab with visible focus; Enter pauses, Space resumes. |
| Offscreen | PASS: clocks freeze offscreen, resume onscreen when appropriate, and remain paused after a manual pause. |
| Reduced motion | PASS: initial load and live preference changes are static. Toggling the preference does not erase manual pause. |
| No JavaScript | PASS: loaded original logo, complete sphere/rings/dots, no CSS motion, no unusable visible control. |
| Responsive layouts | PASS: 360, 390, 600, 768, 900, 1024, 1280, 1440 and 1920px widths; no horizontal document overflow, logo and control within viewport, square sphere, control contained by hero. Mobile/tablet/desktop screenshots inspected. |
| Touch | PASS: emulated touch swipe over the orb scrolls the page without pointer displacement. |
| Nearby links | PASS: original logo home link and both About/Research hero calls to action remain clickable and reach their pages. |
| Accessibility scan | PASS: zero component violations in axe's WCAG 2 A/AA, 2.1 AA and 2.2 AA checks. This does not replace screen-reader testing. |
| Layout/performance diagnostics | PASS: no component layout shifts during motion, pointer movement and pause; no continuous JavaScript rendering loop after settling. Deliberate viewport resizing was excluded from animation-shift assessment. |
| Browser diagnostics | PASS: no console errors or unhandled exceptions in the component suite. |
| Syntax | PASS: PHP lint on the enqueue class; Node syntax check on the scoped controller. |
| Preservation | PASS: template outside this component and rescue CSS outside the old motion blocks unchanged; all five source files match the local installed copies; theme version still 2.4.1. |

**Verification limits:** The actual background-tab transition remains **unverified**. The automated headed Edge session kept `document.hidden=false` after another page was brought forward, so it did not exercise native hidden-tab behaviour. Controlled hidden/visible values dispatched through the real `visibilitychange` handler did verify clock suspension, resumption and preservation of manual pause. This distinction is recorded in `native-tab-recording-results.json`. Physical mobile devices, Safari/Firefox, assistive screen readers and low-end-device performance have not been tested. No production verification or deployment was performed.

The 20-second browser recording, `docs/qa-evidence/hero-orbit/orbit-demo.webm`, demonstrates ambient motion, pointer depth, Pause and Resume on the actual local page. It is a QA artifact, not a website dependency.

## Review, release and rollback

Review the local homepage and recording. In a normal browser, also perform the outstanding native background-tab check: let the orb run, switch tabs, return, then repeat after manually pausing. A manually paused composition must stay paused.

No release ZIP was rebuilt and no production upload occurred. If subsequently approved for release, follow the existing release/versioning process and ship the five implementation files together; purge relevant page/asset caches and recheck the homepage. If a saved WordPress front-page template overrides the theme file in that environment, reconcile that specific override only after review rather than assuming the file template is active.

The local pre-change copies are under `checkpoint/pre-orbit-motion/` (ignored by Git). The Git baseline is `484d09dc804a294cfb779cb794d66bb29a5b8bfc`. To roll back this component, restore the four previously existing files from that baseline/backup and remove only the newly added `assets/css/hero-orb.css`; restore their matching installed copies and clear the relevant caches. There are no database changes to roll back.
