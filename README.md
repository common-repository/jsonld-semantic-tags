<<<<<<< .mine
=== Semantic Tags Plugin ===

/*
Plugin Name: Semantic Tags
Version: 1.2
Author: Adamidis Athanasios
Author URI: http://www.mediapoint.gr/
License: GPL2
Requires at least: 3.0
Tested up to: 3.9.1
Stable tag: 1.2
Contributors: Adamidis Athanasios
Tags: semantic, tag
*/

/*  Copyright 2013  Adamidis Athanasios  (email : info@mediapoint.gr)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/



Semantic Tags plugin provides you everything you need to create tags with semantic architecture.

== Description ==

Semantic Tags have the following properties:

Name	: The name of tag.
Link	: Enter internal or external URL(link)
Rel	: You can add mutliple attributes with a space between them like i.e rel="nofollow bookmark"
Title	: Title attribute
Property: Property e.g. "ctag:label"
Resource: Resource URL (this will not be visible in the browser and not a clickable link)
Content	: Content
Typeof	: Typeof e.g. "ctag:Tag"
Target	: Check if is _blank
Popup	: Check if is popup


Semantic Tags WordPress Plugin, also provides sidebar widget with many options which can be used to display tags in the sidebar.



== Installation ==
 
1. Upload the whole simple-popup-plugin folder to the /wp-content/plugins/ directory.

2. Activate the plugin through the Plugins menu in WordPress.




How to use it
-------------------------

Choose one of the follow:

1. Tag cloud Widget
Go to admin panel on  Appearance-> Widgets.
Add SemanticWidget in a widget area of your choise.

2. Shortcode All
Add the shortcode [semantic_tags] in any text field and show all the tags of the specific page.

3. Shortcode One word
Replace any word in the text with the shortcode [semantic_tags text="tag-name"] (replace the "tag-name" with the tag of your choise)

4. Template page (For developers)
Replace get_the_tag_list('', __(', ' , '')) with SemanticTags_Plugin::get_semantic_tags(); on index.php or function.php files.
Alternative you can add "echo  SemanticTags_Plugin::get_semantic_tags()" in any template page.


== Screenshots ==

1. Screenshot of the edit page.

== Frequently Asked Questions ==
Frequently Asked Questions


== Changelog ==


= 1.0 =

* Initial release>>>>>>> .r809998
