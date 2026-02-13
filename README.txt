=== WP n8n ===
Contributors: Danny
Tags: n8n, workflow, automation, demo, webcomponent, shortcode, integration
Requires at least: 5.2
Tested up to: 6.4
Stable tag: 1.0.1
Requires PHP: 7.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Donate link: https://da2.35g.tw/

Embed interactive n8n workflow demos directly in your WordPress posts, pages, and comments using a simple shortcode.

== Description ==

WP n8n is a powerful WordPress plugin that seamlessly integrates n8n workflow demonstrations into your WordPress website. Whether you're documenting automation workflows, showcasing integration examples, or creating tutorials, this plugin makes it easy to display interactive n8n workflow demos that your visitors can explore directly on your site.

**Perfect for:**
* Technical documentation sites
* Automation and integration tutorials
* SaaS product documentation
* Developer blogs
* Workflow showcase pages

**Key Features:**

* **Simple Shortcode Integration** - Use `[n8n]...[/n8n]` shortcode to embed workflows anywhere in your content
* **Interactive Workflow Demos** - Visitors can interact with your n8n workflows directly on your website
* **Universal Compatibility** - Works with posts, pages, widgets, and comments
* **Automatic Resource Loading** - Automatically loads all required JavaScript libraries from CDN
* **Security First** - Validates and sanitizes all workflow JSON to prevent XSS attacks
* **Zero Configuration** - Works out of the box with no settings required
* **Lightweight** - Minimal performance impact, loads resources only when needed
* **Gutenberg Ready** - Works seamlessly with both Classic and Gutenberg editors
* **Admin Settings Page** - Includes helpful settings page with usage examples and documentation

**How It Works:**

1. Create or export your workflow from n8n
2. Copy the workflow JSON
3. Paste it into the `[n8n]...[/n8n]` shortcode in your WordPress content
4. The plugin automatically renders an interactive workflow demo

The plugin uses the official n8n-demo-webcomponent library, ensuring compatibility with all n8n workflow features and maintaining consistency with the n8n interface your users are familiar with.

== Installation ==

= Automatic Installation =

1. Log in to your WordPress admin panel
2. Navigate to Plugins > Add New
3. Search for "WP n8n"
4. Click "Install Now" and then "Activate"

= Manual Installation =

1. Download the plugin ZIP file
2. Log in to your WordPress admin panel
3. Navigate to Plugins > Add New > Upload Plugin
4. Choose the ZIP file and click "Install Now"
5. Click "Activate Plugin"

= Via FTP =

1. Extract the plugin ZIP file
2. Upload the `WPn8n` folder to `/wp-content/plugins/` directory
3. Log in to your WordPress admin panel
4. Navigate to Plugins
5. Find "WP n8n" and click "Activate"

After activation, visit Settings > WP n8n to view the usage guide and examples.

== Frequently Asked Questions ==

= What is n8n? =

n8n is a powerful workflow automation tool that allows you to connect different services and automate tasks. This plugin allows you to showcase n8n workflows on your WordPress site.

= Do I need an n8n account to use this plugin? =

No, you don't need an active n8n account. You only need the workflow JSON file exported from n8n. However, you'll need n8n to create or edit workflows.

= How do I get the workflow JSON? =

1. Open your workflow in n8n (either locally or cloud)
2. Click the three-dot menu (⋮) in the top right
3. Select "Download" or "Export"
4. Open the downloaded JSON file
5. Copy the entire JSON content
6. Paste it into the `[n8n]...[/n8n]` shortcode

= Can I use this in Gutenberg blocks? =

Yes! You can use the Shortcode block in Gutenberg and paste your `[n8n]...[/n8n]` shortcode there. Alternatively, you can use the Classic block or any block that supports shortcodes.

= Will this plugin affect my existing content? =

No. The plugin only processes shortcodes when content is displayed. Your original content remains completely unchanged in the database. You can safely deactivate or uninstall the plugin without losing any content.

= Does this work with page builders? =

Yes, the plugin works with any page builder that supports WordPress shortcodes, including Elementor, Beaver Builder, Divi, and others. Simply add a shortcode widget/module and paste your `[n8n]...[/n8n]` shortcode.

= Is this plugin secure? =

Yes. The plugin follows WordPress security best practices:
* Validates all JSON input to ensure it's properly formatted
* Sanitizes content using WordPress built-in functions (`esc_attr()`)
* Prevents XSS attacks through proper HTML entity encoding
* Invalid JSON is safely replaced with error comments instead of breaking your site

= Does this plugin collect user data? =

No. The plugin does not collect, store, or transmit any user data. It only loads the n8n-demo-webcomponent library from a CDN to render workflows.

= Can I use multiple workflows on the same page? =

Yes! You can use the `[n8n]...[/n8n]` shortcode multiple times on the same page, each with a different workflow.

= What happens if I paste invalid JSON? =

The plugin will validate the JSON format. If invalid, it will display an HTML comment with an error message (visible only in page source) and skip rendering that particular workflow. Your page will continue to load normally.

= Does this work with caching plugins? =

Yes, the plugin is compatible with caching plugins. However, if you're using aggressive caching, you may need to clear your cache after adding or modifying workflows.

= Can I customize the appearance of the workflow demos? =

The workflow demos use the official n8n-demo-webcomponent, which maintains consistency with the n8n interface. The component supports various attributes like `frame`, `theme`, and `tidyup` that you can add to the shortcode (future versions may support these as shortcode attributes).

= Is there a limit to workflow size? =

There's no hard limit enforced by the plugin, but very large workflows may impact page load times. It's recommended to keep workflows reasonable in size for optimal user experience.

= Does this work with multisite? =

Yes, the plugin is compatible with WordPress multisite installations. You can activate it network-wide or per-site.

== Screenshots ==

1. **Admin Settings Page** - View plugin information, version details, and comprehensive usage examples
2. **Shortcode Usage** - Simple `[n8n]...[/n8n]` shortcode syntax in the editor
3. **Rendered Workflow** - Interactive n8n workflow demo displayed on the frontend
4. **Multiple Workflows** - Showcase multiple workflows on a single page
5. **Gutenberg Integration** - Using the shortcode block in Gutenberg editor

== Changelog ==

= 1.0.1 =
* **Enhancement**: Changed from code block syntax to WordPress shortcode syntax for better compatibility
* **Improvement**: Enhanced shortcode handler to support both attribute and content-based workflow JSON
* **Improvement**: Better error handling for invalid JSON
* **Documentation**: Updated all documentation and examples to reflect shortcode usage

= 1.0.0 =
* **Initial Release**
* Support for WordPress shortcode `[n8n]...[/n8n]` for embedding workflows
* Automatic loading of n8n-demo-webcomponent library
* JSON validation and sanitization for security
* Admin settings page with usage examples
* Support for posts, pages, and comments
* Gutenberg and Classic editor compatibility
* Lightweight implementation with minimal performance impact

== Upgrade Notice ==

= 1.0.1 =
This update changes the syntax from code blocks to WordPress shortcodes. If you were using the previous code block syntax, please update your content to use `[n8n]...[/n8n]` shortcode format. This provides better compatibility with WordPress editors and page builders.

= 1.0.0 =
Initial release. Start embedding interactive n8n workflow demos in your WordPress content today!

== Credits ==

This plugin uses the n8n-demo-webcomponent library developed by n8n.io.

**n8n-demo-webcomponent**
* Copyright (c) n8n.io
* Website: https://n8n.io/
* Component Documentation: https://n8n-io.github.io/n8n-demo-webcomponent/

**n8n**
* n8n is a powerful workflow automation tool
* Website: https://n8n.io/
* Documentation: https://docs.n8n.io/

== Support ==

For support, feature requests, or bug reports, please visit:
* WordPress.org Support Forums: https://wordpress.org/support/plugin/wp-n8n/
* GitHub Issues: (if applicable)

== Privacy ==

This plugin:
* Does not collect any personal data
* Does not store any user information
* Does not track user behavior
* Only loads external resources (n8n-demo-webcomponent) from CDN when workflows are displayed
* All processing happens locally on your server

== License ==

This plugin is licensed under the GPL v2 or later.

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
