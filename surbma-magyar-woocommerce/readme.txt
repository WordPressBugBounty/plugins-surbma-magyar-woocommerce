=== HuCommerce | Hungarian WooCommerce Extensions ===
Contributors: Surbma, xnagyg
Tags: woocommerce, hungarian, hungary, checkout, webshop
Requires at least: 5.3
Tested up to: 6.6
Stable tag: 2026.2.0
Requires PHP: 7.0
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Useful fixes and enhancements for Hungarian WooCommerce webshops.

== Description ==

> Useful fixes and enhancements for Hungarian WooCommerce webshops.

WooCommerce is the world's most popular eCommerce platform — and increasingly the top choice in Hungary too. However, WooCommerce's default behavior doesn't always meet Hungarian legal, cultural, or formatting requirements. This plugin bridges that gap by providing ready-made, configurable solutions for Hungarian store owners — no coding required.

Features are continuously expanded based on community feedback.

#### HuCommerce Facebook Support Group

Join the official HuCommerce Facebook support group to ask questions, share ideas, and connect with the community: [HuCommerce Facebook Group](https://www.facebook.com/groups/HuCommerce.hu/)

### HuCommerce Start (Free)

The choice of more than 9,000 Hungarian webshop owners. A must-have collection of essential fixes and enhancements for every Hungarian WooCommerce store.

[Learn more about HuCommerce Start →](https://www.hucommerce.hu/bovitmenyek/hucommerce/)

**HuCommerce Start features:**

- Hungarian name order (last name first) on the checkout — compatible with WooCommerce 4.4+
- Tax number field on checkout (shown only when a company name is entered; required and saved to the order and user profile)
- Hide the State/County field (irrelevant in Hungary, but can be re-enabled if needed)
- Checkout field format validation (tax number, ZIP code, phone number — with per-field toggle)
- Automatic city fill based on ZIP code
- Translation fixes for WooCommerce and popular themes (Divi, Storefront)
- Basic community support

### HuCommerce Pro (Premium)

The extended edition of HuCommerce with additional features and priority support. Your purchase supports ongoing development.

[Learn more about HuCommerce Pro →](https://www.hucommerce.hu/bovitmenyek/hucommerce/)

> [Subscribe to the HuCommerce newsletter](https://www.hucommerce.hu/hc/hirlevel-feliratkozas/) and receive a 5,000 HUF coupon for HuCommerce Pro.

**HuCommerce Pro features:**

Everything in HuCommerce Start, plus:

- **Legal compliance** — Add active consent checkboxes for Terms & Conditions and Privacy Policy; store acceptance records (including IP, date, and order data); add legal text above/below the Place Order button; Privacy Policy acceptance on the registration form
- **Product Price History** *(Beta)* — Comply with EU consumer protection regulations (Omnibus Directive) by recording and displaying the lowest price in the 30 days before a discount; chart and table view per product; customizable front-end text
- **Checkout page layout** — Conditional display of company billing fields (toggle with a checkbox); side-by-side fields on desktop (company name + tax number, ZIP + city, phone + email); reorder fields; hide Country and Order Notes fields
- **Coupon field modifications** — Reposition, hide, or always show the coupon field on the checkout page
- **Quantity +/- buttons** — Add plus/minus buttons to quantity fields on product and cart pages (supports Storefront, Divi, Avada and more)
- **Auto cart update** — Cart totals update automatically when quantity changes, no need to click "Update Cart"
- **Single product per order** — Limit each order to one product (useful for services or bookings)
- **Redirect cart to checkout** — Automatically redirect the Cart page to the Checkout page to streamline the purchase flow
- **Continue Shopping button** — Display a "Continue Shopping" button on Cart and/or Checkout pages with configurable position and custom text
- **Login & registration redirect** — Redirect users to a custom URL after login or registration (separate URLs for each; ignored on the Checkout page)
- **Free shipping progress notification** — Show remaining amount for free shipping on product listing pages, Cart, and Checkout; customizable and translatable text
- **Hide shipping methods** — Hide irrelevant shipping methods when free shipping is available (with option to keep click-and-collect and "point" methods)
- **Custom "Add to Cart" button text** — Define different button labels per product type (simple, subscription, membership, etc.)
- **Product extra settings** — Additional per-product options: add-to-cart button on listing pages, custom subtitle (SEO-friendly), disable related products, configure products-per-page and columns, upsell/related product counts
- **Global data (shortcodes)** — Store reusable data (company name, address, phone, email, etc.) and display them anywhere with shortcodes; phone and email are rendered as clickable, bot-protected links
- **SMTP configuration** — Connect your store's outgoing email to an external SMTP provider (e.g., Mailgun, SendGrid)
- **Premium plugin & theme translations** — Hungarian translations for popular WooCommerce add-ons and themes that lack quality official translations
- **WPML & Polylang compatibility** — All text fields work with WPML and Polylang for multilingual stores
- **Priority support** — Email and live chat support for Pro customers
- More features coming soon…

**HuCommerce Knowledge Base**

Full documentation for all modules and Pro activation is available in the [HuCommerce Knowledge Base](https://www.hucommerce.hu/tudasbazis/).

#### Hungarian Name Order (WooCommerce 4.4+)

Reverses the first name / last name field order on the checkout when the store is set to Hungarian. The display is responsive, compatible with WPML, and works correctly in order confirmation emails, the customer account area, and admin order views.

#### Tax Number Field on Checkout

A Tax Number field appears below the Company Name field on the Billing section of the checkout. It is only shown when a company name is entered, making it a required field in that case. The tax number is saved to the order and to the user profile. It appears on order confirmation emails, in the admin order editor, and in customer-facing notifications.

Masking, validation (formats: `00000000-0-00`, `00000000000`, `HU00000000`), and a placeholder can all be enabled independently.

#### Hide State/County Field

The State/County field is not commonly used in Hungary, so this module hides it by default. It can be re-enabled in the plugin settings if needed.

#### Checkout Field Validation

Optionally validate and mask the following fields:

- Billing Tax Number: `00000000-0-00` (13 chars), `00000000000` (11 digits), or `HU00000000` (HU prefix + 8 digits)
- Billing and Shipping ZIP Code: `0000` (4 digits)
- Billing Phone: `+36000000000` (11–12 characters)

Each field can be toggled independently.

#### Automatic City Fill from ZIP Code

After a ZIP code is entered on the checkout, the city field is filled in automatically. Manual city edits are respected and will not be overwritten. Some ZIP codes covering multiple settlements may not be supported — these are corrected over time.

#### Translation Fixes

Temporary fixes for missing or incorrect Hungarian translations in WooCommerce and popular themes (Divi, Storefront), applied while official translations are pending. The developer is an official contributor to the Hungarian WooCommerce translation team.

#### Basic Support

Support is available in the [Facebook group](https://www.facebook.com/groups/HuCommerce.hu/) and on the [WordPress.org support forum](https://wordpress.org/support/plugin/surbma-magyar-woocommerce/).

---

### Want to learn more about us and our services?

Visit our website: [HuCommerce.hu →](https://www.hucommerce.hu/)

== Installation ==

### Automatic Installation (Recommended)

1. In your WordPress admin go to **Plugins → Add New**.
2. Search for *HuCommerce | Hungarian WooCommerce Extensions*.
3. Click **Install Now**, then **Activate**.
4. Go to **WooCommerce → HuCommerce** to configure which modules you want to use.
5. That's it! :)

### Manual Installation via WordPress Admin

1. Download the plugin: [HuCommerce | Hungarian WooCommerce Extensions](https://downloads.wordpress.org/plugin/surbma-magyar-woocommerce.zip)
2. In your WordPress admin go to **Plugins → Add New → Upload Plugin**.
3. Upload `surbma-magyar-woocommerce.zip` and activate the plugin.
4. Go to **WooCommerce → HuCommerce** to configure your modules.
5. That's it! :)

### Manual Installation via FTP

1. Download the plugin: [HuCommerce | Hungarian WooCommerce Extensions](https://downloads.wordpress.org/plugin/surbma-magyar-woocommerce.zip)
2. Unzip the file on your computer.
3. Upload the `surbma-magyar-woocommerce` folder to `/wp-content/plugins/`.
4. Activate the plugin under **Plugins** in your WordPress admin.
5. Go to **WooCommerce → HuCommerce** to configure your modules.
6. That's it! :)

== Frequently Asked Questions ==

= Where do I find the plugin settings? =

Plugin settings are located under **WooCommerce → HuCommerce** in your WordPress admin.

= The name order is not reversed on the checkout. =

First, clear your server-side cache and your browser cache, then reload the page. Check whether another plugin is causing a conflict. If you have modified any translations, that could also be the cause. Some themes contain custom code that can override this feature.

Note: Name order is only reversed when the store language is set to Hungarian.

= What does "Surbma" mean? =

It's the developer's last name spelled backwards. ;)

== Changelog ==

= 2026.2.0 =

Release date: 2026-03-27

- New: WooCommerce block checkout compatibility. The tax number (adószám) field now appears in the block-based checkout (WooCommerce 8.4+) via the WooCommerce Additional Checkout Fields API.
- The field value is saved to order meta and customer meta for full backwards compatibility with shortcode-based checkout and the My Account page.
- Tested with WooCommerce up to 9.4.

= 2022.1.5 =

Release date: 2022-06-01

- Fix missing files.

= 2022.1.1 =

Release date: 2022-06-01

- Fix translations in the admin area.
- Minor description updates.

= 2022.1.0 =

Release date: 2022-05-31

- First stable release of HuCommerce and HuCommerce Pro.
- All changes from versions 2022.0.0.1 through 2022.0.35 included.

= 2022.0.35 =

Release date: 2022-05-31

- Fix the monitored period in the Product Price History module to correctly identify the lowest active price in the 30 days prior to a discount.
- Minor adjustments to module labels on the HuCommerce settings page.
- Add "Learn More" links to module descriptions on the settings page.
- Update and expand plugin description.

= 2022.0.34 =

Release date: 2022-05-30

- Refine Pro module conditions.
- Retain Product Price History data when the subscription is inactive.

= 2022.0.33 =

Release date: 2022-05-30

- Add option to hide the "lowest price" text per product on the product page.

= 2022.0.32 =

Release date: 2022-05-30

- Update CPS SDK to version 8.9.0.

= 2022.0.31 =

Release date: 2022-05-30

- Fix checkout field compatibility with the Oxygen theme.

= 2022.0.30 =

Release date: 2022-05-30

- New module: Product Price History.
- New badge for modules: Beta.
- Minor layout fix for the Tax Number display module.
- Add disclaimer text to several modules.

= 2022.0.20 =

Release date: 2022-05-26

- Update CPS SDK to 8.8.0.
- Set feed cache to 24 hours.
- Extend manual API requests to include status retrieval.
- Add Pro promo to the licence management page.
- Switch API instance to domain-based binding for easier reactivation.
- Simplify activation/deactivation flow to two buttons.
- Add API sync and management links.
- Fix condition for legacy user notifications.
- Remove HuCommerce Pro promo banner from the settings page.
- Add title to the HuCommerce main menu item; remove filters.
- Simplify newsletter subscription parameters.
- Full UI redesign for HuCommerce settings.

= 2022.0.19 =

Release date: 2022-05-25

- Disable user capability check in license.php.

= 2022.0.18 =

Release date: 2022-05-24

- Full rewrite of API key management. Status checks are now more reliable and efficient.

= 2022.0.17 =

Release date: 2022-05-24

- Update CPS SDK to 8.7.2.

= 2022.0.16 =

Release date: 2022-05-22

- Update admin notice text and conditions for legacy users.
- Add daily rate limit for automatic API status checks.

= 2022.0.15 =

Release date: 2022-05-19

- Remove URL parameter after manual API call to prevent conflicts on page reload.
- Conditionally save instancebackup and licensekeybackup values.
- Confirmed compatibility with WordPress 6.0.

= 2022.0.14 =

Release date: 2022-05-18

- Rename product ID variable.

= 2022.0.13 =

Release date: 2022-05-18

- Add product_id field to license management for easier testing with different products.
- Replace hardcoded product_id with a dynamic value.
- Add placeholder text to licence management fields.

= 2022.0.12 =

Release date: 2022-05-17

- Add per-field toggle to the checkout field format validation module.
- Add per-field toggle to the checkout field value validation module.

= 2022.0.11 =

Release date: 2022-05-17

- Adjust admin notice text based on licence status.

= 2022.0.10 =

Release date: 2022-05-15

- Adjust Help Scout Beacon conditions to also show for users with expired or invalid licence keys.
- Remove HuCommerce admin sidebar (no longer needed after the new UI).
- Refine admin notice conditions and copy.
- Minor admin widget update.
- Move licence management to its own file (extracted from /lib/start.php).
- Clean up /lib/license.php.
- Add manual API request triggers for activation and deactivation.
- Set wp_error condition for API calls to prevent fatal errors on failure.
- Save API response to the database for future use.
- Add licence status notifications.
- Rename coupon module file.
- New: display coupon codes in uppercase in both admin and front-end.
- Fix auto-update cart module for broader theme compatibility.
- Expand the Information tab on HuCommerce settings with useful data.
- Full redesign of the Licence Management tab; handle all conditions and licence states.
- Show licence details on the Licence Management tab.
- Add warning text for legacy HuCommerce users when saving modules.
- Extend validation on module save to cover all fields.
- Add logic to retain module settings for legacy users and expired licences.
- Save new brandnewuser flag to determine how long the user has been using HuCommerce.
- Validate licence-related fields.
- Make the licence management menu icon dynamic (locked/unlocked based on licence status).
- Add licence-related notifications to the HuCommerce settings page.

= 2022.0.9 =

Release date: 2022-05-15

- Update CPS SDK to 8.7.1.
- Minor description update.
- Add newsletter subscription to the description.
- Confirmed compatibility with WooCommerce 6.5.

= 2022.0.8 =

Release date: 2022-05-06

- First version of licence management. API requests not yet working, but the licence key can be saved and modules are managed based on validity.
- Move demo licence management code to license.php.
- New licence menu.
- Add licence field validation.

= 2022.0.7 =

Release date: 2022-05-06

- Extend the uninstall routine with additional options.

= 2022.0.6 =

Release date: 2022-05-06

- Update CPS SDK to 8.4.0.

= 2022.0.5 =

Release date: 2022-05-06

- Extract HuCommerce settings menu items into separate files.
- Reorder social links.
- Update and expand settings page footer.
- Remove settings-options.php (no longer needed).
- Move global settings variables to settings-nav-modules.php.

= 2022.0.4 =

Release date: 2022-04-18

- Extract Modules settings into a separate file.
- Remove HuCommerce Extensions (postponed).
- Restore Offers, Catalogue, and News sections.
- Restructure settings page: each section in its own file.

= 2022.0.3 =

Release date: 2022-04-18

- Minor code optimisation.
- Full redesign of the HuCommerce settings page: new structure, layout, and menu items.
- Extract settings page sections into separate files for maintainability.
- Display new module settings in the new UI.

= 2022.0.2 =

Release date: 2022-04-17

- Remove the farewell message for version 2022.0.0 from the settings page.
- Confirmed compatibility with WooCommerce 6.4.

= 2022.0.1 =

Release date: 2022-04-17

- Minor code fixes.
- Confirmed compatibility with WooCommerce 6.3.

= 2022.0.0 =

Release date: 2022-01-01

- Complete rewrite of the plugin (formerly "Surbma | Magyar WooCommerce").
- New plugin name: HuCommerce | Magyar WooCommerce kiegészítések.
- Modular structure: enable only the features you need.
- All previous features preserved and re-implemented as modules.
