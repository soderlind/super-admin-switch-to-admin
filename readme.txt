=== Super Admin Switch to Admin ===
Contributors: PerS
Tags: super admin, multisite, admin, switch
Requires at least: 6.5
Tested up to: 6.8
Requires PHP: 8.2
Stable tag: 1.0.11
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

If you are logged in as a super admin, allows you to switch to a regular admin account on the current site.

== Description ==

Prerequisite: 

- WordPress Multisite
- [User Switching](https://wordpress.org/plugins/user-switching/) plugin
- The subsite must have at least one regular admin account.

If you are logged in as a super admin, this plugin allows you to switch to a regular admin account on the current site. 
It lists all admins for the current site, except for the super admin., and creates a  linked list  in the admin notices.

== Installation ==

1. **Quick Install**

   * Download [`super-admin-switch-to-admin.zip`](https://github.com/soderlind/super-admin-switch-to-admin/releases/latest/download/super-admin-switch-to-admin.zip)
   * Upload via WordPress Network > Plugins > Add New > Upload Plugin
   * Network activate the plugin.

2. **Updates**
   * Plugin updates are handled automatically via GitHub. No need to manually download and install updates.



== Changelog ==

= 1.0.11 =
* Version bump and maintenance release.

= 1.0.10 =
* Force, via plugin header, the required User Switching plugin.

= 1.0.9 =
* Another bugfix. Note to self, test better before releasing.

= 1.0.8 =
* Bugfix


= 1.0.7 =
* Use generic [WordPress Plugin GitHub Updater](https://github.com/soderlind/wordpress-plugin-gitHub-updater?tab=readme-ov-file#wordpress-plugin-github-updater)


= 1.0.6 =
* Update installation instructions.

= 1.0.5 =
* Hotfix: Add missing class for plugin updater.

= 1.0.4 =
* Add plugin updater.

= 1.0.3 =
* Exclude all super admins from the list of admins.

= 1.0.2 =
* Add Norwegian translation.

= 1.0.1 =
* Add a screenshot.


= 1.0.0 =
* Initial release

