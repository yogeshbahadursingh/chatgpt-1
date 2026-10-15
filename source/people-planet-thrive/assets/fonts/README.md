# Typography assets

The supplied theme has no font binaries. Version 2.4.0 removes broken fontFace URLs and retains the existing serif, sans-serif and monospace fallback stacks. This preserves the typography actually rendered by the previous package without font 404 requests or third-party font calls.

If approved self-hosted fonts are added later, include their licences, register only bundled files in theme.json, use font-display: swap, and retest layout, loading and language coverage. Do not register placeholder URLs.
