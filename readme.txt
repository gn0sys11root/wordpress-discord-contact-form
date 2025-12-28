=== Discord Contact Form ===
Contributors: gn0sys11wp
Tags: discord, contact form, webhook, forms, contact, messaging, integration, multilingual, ajax
Requires at least: 5.0
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A powerful, multilingual contact form plugin that sends messages directly to Discord channels via webhooks with customizable design and automatic language detection.

== Description ==

Discord Contact Form is a modern, feature-rich contact form plugin that seamlessly integrates your WordPress website with Discord. Instead of traditional email notifications, this plugin sends form submissions directly to your Discord server, making it perfect for gaming communities, tech support, and modern teams that use Discord for communication.

**Key Features:**

* **Discord Integration** - Send form submissions directly to Discord channels via webhooks
* **Multilingual Support** - Automatic language detection with Spanish and English support  
* **Custom Form Builder** - Advanced form editor with multiple field types (text, email, phone, number, textarea)
* **Responsive Design** - Mobile-friendly forms that work perfectly on all devices
* **Color Customization** - Full control over form appearance, colors, and styling
* **AJAX Submissions** - Smooth form submissions without page reloads
* **Field Validation** - Built-in validation for required fields and email addresses
* **Security First** - CSRF protection, data sanitization, and XSS prevention
* **Easy Setup** - Automatic configuration based on WordPress language settings
* **Admin Panel** - User-friendly configuration interface in multiple languages

**Why Choose Discord Contact Form?**

Unlike traditional contact forms that rely on email (often ending up in spam), Discord Contact Form delivers messages instantly to your Discord server where your team is already active. Perfect for:

* Gaming communities and Discord servers
* Tech support and customer service teams  
* Development teams and agencies
* Discord-based businesses and startups
* Modern companies using Discord for internal communication

**Advanced Customization:**

* **Dynamic Form Fields** - Add, remove, and reorder form fields easily
* **Field Types** - Text, Email, Phone, Number, and Textarea fields with validation
* **Color Scheme** - Customize text, background, border, and button colors
* **Button Text** - Personalize submit button text in any language
* **Field Configuration** - Custom labels, placeholders, character limits, and required/optional settings
* **Responsive Layout** - Forms automatically adapt to your theme's design

**True Multilingual Support:**

The plugin automatically detects your WordPress language and configures itself accordingly:

* **Spanish Support** - Full support for all Spanish variants (es_ES, es_AR, es_MX, es_CO, es_VE, es_PE, es_CL, etc.)
* **English Support** - Default for all other languages worldwide
* **Admin Interface** - Complete admin panel translation with language switcher
* **Form Fields** - Automatically translated field labels and placeholders
* **Discord Messages** - Localized message titles and formatting
* **Smart Detection** - Recognizes 20+ Spanish locale variants automatically

**Performance & Security:**

* **Lightweight Code** - Optimized for fast loading and minimal resource usage
* **No Database Overhead** - No additional database tables created
* **GDPR Compliant** - No personal data stored in WordPress database
* **Security Hardened** - Nonce verification, input sanitization, and output escaping
* **Cache Compatible** - Works with all major caching plugins

== Installation ==

**Automatic Installation:**
1. Go to WordPress Admin → Plugins → Add New
2. Search for "Discord Contact Form"  
3. Click "Install Now" and then "Activate"
4. Go to "Discord Form" in your admin menu to configure

**Manual Installation:**
1. Download the plugin ZIP file
2. Go to WordPress Admin → Plugins → Add New → Upload Plugin
3. Choose the ZIP file and click "Install Now"
4. Activate the plugin
5. Configure your Discord webhook in Discord Form → Configuration

**Discord Webhook Setup:**
1. Go to your Discord server
2. Right-click the channel where you want to receive messages
3. Select "Edit Channel" → "Integrations" → "Webhooks"
4. Click "Create Webhook"
5. Copy the webhook URL
6. Paste it in Discord Form → Configuration in WordPress

== Usage ==

**Basic Usage:**
Add the shortcode anywhere you want the contact form to appear:
`[discord_contact_form]`

**With Custom Parameters:**
`[discord_contact_form id="custom-form" class="my-form-style"]`

**Form Configuration:**
1. Go to Discord Form → Configuration to set up webhook and colors
2. Go to Discord Form → Form Editor to customize form fields
3. Add, remove, or modify fields with the visual editor
4. Set field types, labels, placeholders, and validation rules

== Frequently Asked Questions ==

= How do I create a Discord webhook? =
1. Go to your Discord server settings
2. Navigate to the channel where you want messages
3. Click channel settings (gear icon) → Integrations → Webhooks  
4. Click "Create Webhook"
5. Copy the webhook URL and paste it in the plugin configuration

= Can I customize the form fields? =
Yes! Go to Discord Form → Form Editor to add, remove, or modify fields. You can change field types (text, email, phone, number, textarea), labels, placeholders, character limits, and mark fields as required or optional.

= What languages are supported? =
The plugin automatically detects your WordPress language. It fully supports all Spanish variants (Spain, Argentina, Mexico, Colombia, etc.) and uses English for all other languages. The admin panel can be switched between Spanish and English.

= Will it work with my theme? =
Yes! The plugin is designed to work with any WordPress theme. It uses responsive design and adapts to your theme's styling automatically.

= Does it work with caching plugins? =
Yes, the plugin is compatible with all major caching plugins including WP Rocket, W3 Total Cache, WP Super Cache, and others.

= Can I have multiple forms on one page? =
Yes, you can use the `[discord_contact_form]` shortcode multiple times on the same page with different IDs.

= Is it secure and GDPR compliant? =
Yes! The plugin includes CSRF protection, data sanitization, and XSS prevention. It's GDPR compliant as no personal data is stored in your WordPress database - everything is sent directly to Discord.

= Can I change the Discord message format? =
The plugin automatically formats Discord messages with embedded fields for each form submission. The format includes the form title, all field data, and a timestamp.

= What happens if Discord is down? =
If Discord's API is unavailable, the plugin will show an error message to users and prevent data loss. You can monitor form submissions through Discord's webhook status.

== Screenshots ==

1. Admin configuration panel with Discord webhook setup, color customization, and language selection options
2. Advanced form editor showing custom field management with different field types (text, email, textarea)
3. Clean, responsive contact form displayed on the frontend that adapts to any WordPress theme

== Changelog ==

= 1.0.0 =
* Initial release with full feature set
* Discord webhook integration with embedded message formatting
* Complete multilingual support (Spanish/English with auto-detection)
* Advanced form builder with 5 field types (text, email, phone, number, textarea)
* Modular admin panel with separated configuration and form editor
* Full color customization system
* AJAX form submissions with real-time validation
* Responsive design that works with all themes
* Security features: CSRF protection, data sanitization, XSS prevention
* Automatic language detection for 20+ Spanish locale variants
* Character limits and field validation for all field types
* Mobile-optimized interface and form design
* Cache plugin compatibility
* GDPR compliance with no data storage

== Upgrade Notice ==

= 1.0.0 =
Initial release of Discord Contact Form with comprehensive Discord integration, multilingual support, and advanced customization options. Perfect for modern websites that use Discord for communication.

== Technical Requirements ==

* **WordPress:** 5.0 or higher
* **PHP:** 7.4 or higher  
* **Dependencies:** None (pure WordPress plugin)
* **Database:** No additional tables required
* **JavaScript:** Modern browsers with ES5+ support
* **Discord:** Valid webhook URL from Discord server

== Developer Information ==

**Plugin Structure:**
* Main plugin file with core functionality
* Modular admin system with separate configuration and form editor
* Template system for admin pages
* Separate CSS and JavaScript assets
* Multilingual system with language file support

**Hooks and Filters:**
* Standard WordPress hooks for plugin activation
* AJAX handlers for form submission
* Admin menu integration
* Script and style enqueueing

**Security Features:**
* WordPress nonce verification for all forms
* Input sanitization for all user data
* Output escaping for XSS prevention  
* Capability checks for admin access

== Support and Documentation ==

For detailed documentation, tutorials, and support:
* Visit the plugin's official documentation
* Check the FAQ section for common questions
* Submit support tickets for technical issues
* Feature requests are welcome

== Privacy and Data ==

This plugin respects user privacy:
* No tracking or analytics code included
* No personal data stored in WordPress database
* Form submissions sent directly to Discord via secure HTTPS
* No third-party services except Discord's API
* Webhook URLs are stored securely in WordPress options

== Credits ==

Built with ❤️ for the WordPress and Discord communities.
Special thanks to all beta testers and contributors who helped make this plugin better.
