# PPT Core — WordPress Plugin

**Plugin Name:** PPT Core
**Plugin URI:** https://ppthrive.com
**Version:** 1.0.0
**Requires WordPress:** 6.4+
**Requires PHP:** 8.0+

## Description

Core functionality for People & Planet Thrive — custom post types, taxonomies, meta fields, and organisation-specific data models for scholarly publishing, research, training, and events.

## Features

### Custom Post Types

| Post Type | Slug | Description |
|-----------|------|-------------|
| Journal | `ppt_journal` | Journal publications with ISSN, editorial data |
| Journal Issue | `ppt_journal_issue` | Individual volumes/issues |
| Article | `ppt_article` | Scholarly articles with DOI, abstract, ORCID |
| Researcher | `ppt_researcher` | Research profiles with affiliations |
| Research Project | `ppt_research_project` | Active and completed projects |
| Research Area | `ppt_research_area` | Research domains and fields |
| Publication | `ppt_publication` | Books, reports, monographs |
| Training | `ppt_training` | Courses and workshops |
| Event | `ppt_event` | Events, webinars, conferences |
| Team Member | `ppt_team_member` | Organisation staff |
| Partner | `ppt_partner` | Partner organisations |

### Taxonomies

- Journal Categories
- Article Types (research, review, editorial, etc.)
- Research Domains
- Publication Types
- Training Types
- Event Types

### Meta Fields

Scholarly article metadata:
- DOI, Abstract, Keywords
- Author ORCID, Affiliation
- Page numbers, PDF URL, Full text URL
- Dates (received, accepted, published)

Journal metadata:
- ISSN, eISSN
- Publication frequency
- Editor-in-Chief

Researcher metadata:
- ORCID, Affiliation, Position
- Google Scholar, ResearchGate URLs

Event metadata:
- Start/end dates
- Location, Online flag
- Registration URL

### REST API

All custom post types are available via the WordPress REST API with extended meta fields.

### Admin Interface

- Dedicated dashboard page
- Custom meta boxes for each content type
- Admin columns for key data
- Bulk edit support

## Installation

1. Download the plugin ZIP file.
2. In WordPress admin, go to **Plugins → Add New → Upload Plugin**.
3. Select the ZIP file and click **Install Now**.
4. Activate the plugin.

## Architecture

This plugin follows WordPress best practices:

- **Singleton pattern** for the main class
- **Loader class** for hook management
- **Autoloader** for class files
- **Proper escaping and sanitisation** throughout
- **Nonce verification** on all forms
- **Capability checks** on all admin actions
- **Internationalisation** support (text domain: `ppt-core`)

## Content Portability

All content models are stored in this plugin, NOT in the theme. This means:
- Content survives theme changes
- Data is accessible via REST API even without the theme
- The plugin can be used with any compatible theme

## WooCommerce Integration

The plugin prepares for WooCommerce integration:
- Publication post type can be linked to WooCommerce products
- Meta fields support pricing and format data
- REST API exposes data for headless commerce

## Uninstall

When uninstalled, the plugin:
- Removes its own options and transients
- Does NOT delete custom post type content (preserves user data)
- Does NOT modify any WordPress core data

## License

GNU General Public License v2 or later.

## Credits

Developed by People & Planet Thrive Initiative Pvt. Ltd.
