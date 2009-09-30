=== SidePosts Widget ===
Revision: $Rev: 230 $
Contributors: txanny
Donate link: http://alkivia.org/donate
Tags: sidebar, widget, sideposts, asides, posts, sideblog, miniblog, subblog, miniposts
Requires at least: 2.8
Tested up to: 2.8.4
Stable tag: 2.4

Simple widget to move posts from a category to the sidebar. Posts in this category do not show on index, archives or feeds, and have its own feed.

== Description ==

With this widget you select the category you want, and all entries with this category, will be shown on the sidebar instead the main blog. You will have then a small blog on the sidebar for those special entries. For each entry, you have the link to the post page.
You can select the number to post to show and if must show only the post excerpt or the full post content (Also excerpt with thumbnails can be shown).

Another option is to set a widget to show only private posts. In this case, private posts are hidden only in the home page and nowhere else. When set to private posts, widget only shows to users with `read_private_posts` capability (Administrators and Editors).

Also, you have foot links to the category archive and feed (Not for private posts). With this simple functions, you will have a small subblog on the sidebar.

**To know how to configure and use, you can read the <a href="http://alkivia.org/manuals/sideposts:manual">SidePosts Manual</a>.**

**Features:**

* Have a mini-blog or foto-blog on the sidebar.
* Choose to show the full post, the post excerpt or excerpts with thumbnails.
* Setup a widget to show latest private posts at the sidebar.
* Entries at the aside category, are not shown from main pages.
* Widget will show link to archives page.
* Widget has a link to the selected category feeds.
* Set category, number of posts and title on the widget admin panel.
* Widget allows for multiple instances.
* Some filters can be used by developers.

**Languages included:**

* English
* Spanish
* Catalan *by <a href="http://txanny.net">Jordi Canals</a>*
* Romanian *by <a href="http://drumliber.ro/" rel="nofollow">Drum liber</a>*
* German *by <a href="http://www.flashdevelop.de" rel="nofollow">Andreas Khong</a>*
* French *by <a href="http://www.midiconcept.fr" rel="nofollow">Pierre Tabutiaux</a>*
* Italian *by <a href="http://gidibao.net" rel="nofollow">Gianni Diurno</a>*
* Finnish *by <a href="http://www.tiirikainen.fi" rel="nofollow">Vesa Tiirikainen</a>*
* Portuguese (Brasil) *by <a href="http://http://www.maisquecoisa.net" rel="nofollow">Fabio Freitas</a>*
* Norwegian *by <a href="http://xrunblogg.com" rel="nofollow">^xRun^</a>*
* Swedish *by <a href="http://www.kopahus.se" rel="nofollow">Henrik Mortensen</a>*
* Polish *by <a href="http://aerolit.pl" rel="nofollow">Darek Sieradzki</a>*
* Russian *by <a href="http://www.wp-ru.ru" rel="nofollow">Grib</a>*
* Byelorussian *by <a href="http://www.fatcow.com" rel="nofollow">Marcis Gasuns</a>*
* Farsi (Persian) *by <a href="http://sourena.net" rel="nofollow">Sourena</a>*
* Turkish *by <a href="http://ramerta.com" rel="nofollow">Omer Faruk</a>*
* POT file for easy translation to other languages included. If you translated SidePosts to your language, <a href="http://alkivia.org/contact/">you can tell us</a>

== Installation ==

**System Requirements**

* **Requires PHP-5**. Will not work with obsolete PHP versions. (This includes PHP-4).
* Verify the plugin is compatible with your WordPress Version.
* WordPress SideBars must be used. If you intend to any other sidebars replacement, check it before using this plugin.

**Installing the Widget**

1. Unzip the widget archive
1. Upload the folder sideposts to the /wp-content/plugins directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Add the widget to your sidebar and select the category for the posts to show.
1. Enjoy your widget.

**Updating**

*When updating from a version prior to 2.0, you will loose your information. This is because the changes needed to allow multiple widget instances. You will have to manually set your widget again.*

* Have a backup of your style.css file if you customized it.
* Can use auto-update in wordpress plugins page.
* Can upload the new files to override the old version.

== Frequently Asked Questions ==

**Where can I find more information about this plugin, usage and support ?**

* Take a look to the <a href="http://alkivia.org/wordpress/sideposts">Plugin Homepage</a>.
* A <a href="http://alkivia.org/wordpress/sideposts">manual</a> is available for users and developers.
* The <a href="http://alkivia.org/cat/sideposts">plugin posts archive</a> with new announcements about this plugin.
* If you need help, <a href="http://wordpress.org/tags/sideposts?forum_id=10">ask in the Support forum</a>.

**I've found a bug or want to suggest a new feature. Where can I do it?**

* To fill a bug report or suggest a new feature, please fill a report in our <a href="http://tracker.alkivia.org/set_project.php?project_id=2&ref=view_all_bug_page.php">Bug Tracker</a>.

**I'm a developer, where can I browse source code?**

* You have all links to source code, logs and other information <a href="http://alkivia.org/wordpress/sideposts/changelog">in this page</a>.

== Screenshots ==

1. Widget settings panel.
2. Widget: Full posts.
3. Widget: Showing only excerpts.
4. Widget: Excerpts with thumbnails.
5. Widget: PhotoBlog feature.

== License ==

Copyright (C) 2008-2009  Jordi Canals

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see <http://www.gnu.org/licenses/>.

== Changelog ==

* **2.4** - Allows for a mini-photoblog. Does not show if browsing same category.
* **2.3.1** - Added Romanian translation.
* **2.3** - Now the exceprt thumbnail shown is the first image in gallery order instead the first uploaded image.
* **2.2.2** - Added Finnish translation.
* **2.2.1** - Added Russian translation.
* **2.2** - Now using the new WP_Widget class from WP 2.8. (Requires WP 2.8)
* **2.1.4** - Updated internal dashboard. Tested with WP 2.8.1.
* **2.1.3** - Fixed a dashboard block on WordPress 2.8
* **2.1.2** - Updated Italian translation.
* **2.1.1** - Added Norwegian translation.
* **2.1** - New option to show only title. Now posts are shown in daily archives.
* **2.0.3** - Added belorussian translation.
* **2.0.2** - Added compatiblity for WP 2.8. Solved issues with thumbnails in some browsers. 
* **2.0.1** - Soved problem with thumbnails not showing.
* **2.0** - Allows multiple widget instances. Allows a widget for private posts.
* **1.5.3** - Updated italian translation.
* **1.5.2** - Added Portuguese (Brasil) translation. Some improvements to widget queries.
* **1.5.1** - Solves a query bug introduced in 1.5 related to filter not appliying correctly.
* **1.5** - Now can show excerpts with thumbnails. Added some developers filters. Minor fixes.
* **1.4.5** - Added Swedish and Polish translations.
* **1.4.4** - Fix: When using custom queries on templates, posts show repeated. (b30).
* **1.4.3** - Now language translations are not set until all plugins are loaded. Included Farsi (Persian) translation.
* **1.4.2** - Solved a major bug with "more" tag (b13). Corrected some translations. Increased maximum posts to 20.
* **1.4.1** - Completed Italian Translation for 1.4
* **1.4** - Check system compatibilities and dependencies. Deletes widget and options when deactivated.
* **1.3.3** - Included German Translation.
* **1.3.2** - Included French Translation.
* **1.3.1** - Now posts are shown when viewing tag pages. Improved the query filter.
* **1.3** - Arranged to show Full Content or Excerpt for the Widget. Improved queries to better approach.
* **1.2.1** - Some code cleanup and added Turkish translation.
* **1.2** - Solved presentation issues in some themes.
* **1.1** - Improved filter, and deactivates it when widget is not loaded.
* **1.0.1** - Solved problems with K2 Theme and XHTML fixes.
* **1.0** - First public version
