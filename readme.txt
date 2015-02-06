=== iThemes Exchange - Custom Loop Add-on ===

Contributors: ronaldvw
Tags: iThemes Exchange, add-on, addon, Exchange add-on, Exchange addon, store, shop, loop, grid, list
Requires at least: 3.0.0
Tested up to: 4.1
Stable tag: 1.0.6
License: GPLv2 or later

Create a custom loop for your product store pages, add selections, grid/list view and more.

== Description ==
This add-on for [iThemes Exchange](https://ithemes.com/exchange/ "iThemes Exchange") adds the ability to create multiple loops for the products (store) page, including grid/list view selection, pagination, data selections and order by functionality. It allows you to create product category pages, pages per product type etc.

= Add Grid / List View =
Set a default view, either List view, or Grid view. Define how many columns you want in a grid, and how much padding between the items. Define at which viewport width a Grid view should transform in List view.

= Add Pagination =
Set the number of products per page, and the Previous / Next Page text.

= Data Selections =
Select one, more, or all Categories, or Product Types.

= Sort Order =
Set a default Sort order for the products. Order by date, price, name, or use the Exchange default.

= Frontend Options =
Enable or disable a grid/list button for the store, so the user can dynamically change the view. Enable or disable a "order by" dropdown, so the user can change the order in which products are displayed.

= New fields to add content before or after the loop =
This allows you to use a wysiwyg editor to add content before or after the custom loop. Add (for instance) introduction text for your categories or downloads, a slideshow, a video, anything you can thinks of. And at the bottom of your loop, add a newsletter subscription form, social / share and whatever else you wish to add.

= New in 1.0.6 =
Fixed an issue that caused a (harmless) notification when wp_debug is enabled
More localisation enhancements, and I added Serbian translation, kindly provided by Ogi Djuraskovic from [firstsiteguide.com](http://firstsiteguide.com/ "firstsiteguide.com")

= New in 1.0.5 =
Is a minor update that enhances translation abilities

= New in 1.0.4 =
Added wysiwyg fields to add content before and after the loop, as well as preserve existing page content and show the loop before or after existing content.

= New in 1.0.3 =
Fixed an issue where the Default Grid/List View setting wasn't being applied when frontend view wasn't enabled

= New in 1.0.2 =
* You can now choose the text (if any) to display in front of the sort order dropdown
* Added grid/list option "none" to not affect an existing loop at all, so no need to choose either grid or list. It will default to the Exchange default. Note that this will disable the grid/list selections.
* None relevant options are "greyed out" based on selections made.

== Installation ==

1. Upload the folder 'exchange-addon-custom-loop' to the '/wp-content/plugins/' directory
2. Activate 'iThemes Exchange - Custom Loop Add-on' through the 'Plugins' menu in WordPress
3. Open the 'Addons' screen through the 'Exchange' menu in WordPress
4. If Custom Loop is not enabled, click Enable beside the 'Custom Loop' entry in the Addons listing

5. Once enabled, the "write page" screen will have an extra option to enable the custom loop. Upon ticking that option, all custom loop options will become visible and editable. For an overview of all options, see the screenshots section.

Please visit [the official website](http://weerdpress.com/wordpress-plugins/ithemes-exchange-custom-loop-add/ "WeerdPress Plugins") for further details and the latest information on this plugin.

== Screenshots ==
1. Overview of all Custom Loop settings and options on the "write page" screen
2. The Activation option on the write page screen
3. The Grid List Settings
4. The Pagination Settings
5. The Data Selection Settings
6. The Order By Settings
7. The Front End Settings
8. Additional option for grid/list (since 1.0.2)
9. Optional Label text for the "order by" dropdown (since 1.0.2)
10. Added content blocks before and after the loop (since 1.0.4)

== Changelog ==

= 1.0.6 - 2015/02/04 =
* Fixed an issue that caused a (harmless) notification when wp_debug is enabled
* More localisation enhancements, added the ability to store translations in the wp-content/languages/plugins/ folder
* Added Serbian translation, provided by Ogi Djuraskovic from [firstsiteguide.com](http://firstsiteguide.com/ "firstsiteguide.com")

= 1.0.5 =
* Minor update that improves translation abilities and added a .pot file.

= 1.0.4 =
* Added wysiwyg fields to add content before and after the loop, as well as preserve existing page content and show the loop before or after existing content.

= 1.0.3 =
* Fixed issue where Default Grid/List View setting is not applied when frontend view not enabled

= 1.0.2 =
* Added optional "order by" text for the order by dropdown on the frontend
* Added grid/list option "none" to not affect an existing loop at all
* Grey out options that are not relevant in the backend

= 1.0.1 =
* Updated Readme.txt
* Fixed issue where Grid/List would fail if no cookie set yet

= 1.0 =
* Initial release

== Translations ==
Translators, you are invited to translate the plugin, send the translated files over, and I will add your translation to the plugin, with an attribution.

It is common issue with plugin translations that (custom) translations will be overwritten on plugin update. To prevent this, if you have a custom translation, or customised an existing translation, copy the relevant translation (.mo) file to wp-content/languages/plugins/exchange-addon-custom-loop/ The translation file should be named "rvw-exchange-addon-custom-loop-{locale}" where {locale} is your language locale, e.g. de_DE or nl_NL.