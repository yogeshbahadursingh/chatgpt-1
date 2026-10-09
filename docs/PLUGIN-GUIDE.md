# Plugins for People & Planet Thrive

Reviewed 9 October 2026 against the project's source and official plugin documentation. These are installation recommendations, not a claim that optional plugins have been tested together on the live host. Check the existing Installed Plugins list before adding anything.

## Required for this build

| Plugin | Purpose | Action |
|---|---|---|
| **PPT Core** — supplied `release/ppt-core.zip` | Journals, articles, research, publications, people, events, shared topics, site setup and the existing enquiry form | Install/activate the supplied release. This is a custom plugin, not a WordPress.org download. |
| [**WooCommerce**](https://wordpress.org/plugins/woocommerce/) | Physical books, e-books, orders, customer accounts and controlled digital downloads | Required for the planned store. Activate it, then run **Tools → PPT Site Setup → Create / Repair Site** again and configure genuine store details. |

`people-planet-thrive.zip` is the **theme**: install it under Appearance → Themes, not Plugins. The logo and premium navigation do not require an additional plugin.

## Add only where the service is missing

| Plugin/service | When to use it | Setup required |
|---|---|---|
| [**FluentSMTP**](https://wordpress.org/plugins/fluent-smtp/) | WordPress does not already have a working authenticated mail connection | Connect the operator's mail provider. Test receipt of enquiries, order messages and password resets. The plugin is free; the chosen mail service may charge. Use one SMTP integration. |
| [**UpdraftPlus**](https://wordpress.org/plugins/updraftplus/) | The host does not provide suitable, tested off-site backups and restore access | Schedule files/database backups to separate storage and verify a restore on staging. Choose a backup frequency that suits genuine order activity. |
| [**Wordfence Security**](https://wordpress.org/plugins/wordfence/) | Equivalent managed firewall, malware monitoring and administrator login protection are not already supplied | Configure administrator two-factor authentication, firewall and scan settings. Check the host's compatibility guidance. |
| **One payment-provider extension** | You want to accept online payments | Choose the official/supported WooCommerce extension for a provider that has approved the Nepal business, settlement bank and required currencies. No gateway is preselected and merchant eligibility has not been verified. Test its sandbox before live trading. |

## Keep one existing provider for each job

- **Cache:** SpeedyCache appears in the supplied WordPress screenshot. Review that installation first; do not add a second page-cache plugin. Retain WordPress block CSS and required WooCommerce assets. Confirm Cart, Checkout, My Account and customer-specific sessions bypass full-page caching, following [WooCommerce's caching guidance](https://developer.woocommerce.com/docs/best-practices/performance/configuring-caching-plugins).
- **SEO:** The public audit found an existing sitemap/schema provider but could not identify its administrator settings. Configure that provider's real organisation name and logo first. If there is no suitable SEO plugin, [Yoast SEO](https://wordpress.org/plugins/wordpress-seo/) is one option for metadata and XML sitemaps. Activate only one SEO suite and verify that it does not duplicate the theme's organisation/breadcrumb metadata.

The current build already supplies content types, metadata fields, search, navigation and an enquiry form. Elementor, a mega-menu plugin, a logo plugin, ACF, a CPT builder, a separate e-book/download shop and another contact-form plugin are not dependencies of this implementation.

## Installation order and launch checks

1. Back up the existing site and prepare staging. Install/update PPT Core and the supplied theme there.
2. Activate WooCommerce and rerun PPT Site Setup. Check Shop plus the [Cart, Checkout and My Account assignments](https://woocommerce.com/document/configuring-woocommerce-settings/advanced/).
3. Configure mail delivery, then the recipient and enquiry toggle in **Settings → PPT Platform**. Installing an SMTP plugin alone does not enable the PPT enquiry form.
4. Configure the single SEO/cache providers and any missing backup/security service. Add the approved payment extension when the merchant account is ready.
5. Test navigation, enquiries, physical/digital sandbox purchases and protected downloads. Obtain production approval before deploying or enabling live sales.

The public audit returned 404 for all four store routes and found the contact service disabled. Plugin installation must be followed by these configuration checks. Demonstration products remain previews in production; publish approved genuine products before trading.
