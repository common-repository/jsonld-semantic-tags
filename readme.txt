=== JSONLD Semantic Tags ===

Plugin Name: JSONLD Semantic Tags
Version: 1.1.2
Author: Dean Williams
Author URI: https://webdesires.co.uk
Requires at least: 3.0
Tested up to: 5.3
Stable tag: 1.1.2
Contributors: Dean Williams, Adamidis Athanasios
Tags: semantic, tag, semantic web, tagging, jsonld, citation



Semantic Tags plugin provides you everything you need to create and semantically markup your Tags.


== Description ==


Search has changed.  No longer is it possible to manage your on-site SEO with a single “All-in-one” Plug-In.

Semantic search has not only arrived, but it underpins everything Google’s Hummingbird algorithm is about.

Our Plug-In raises your game.  Unlike others, ours gets to the very source code of your content.

This enables Google and other search engines to understand what your content relates to, even giving you the ability to link out to authority resources from the tag itself.

<h3>How to use the Semantic Tag Plug-In</h3>

Unlike other tags that you simply enter into a sidebar widget, these tags are extremely editable.  You are “marking up” the tags, giving them a whole new dimension and purpose.

Once you have installed the Plug-In, click through your WordPress.org dashboard into the “Posts” section, as you would if you were going in to edit existing posts.

Once through, you will be prompted to “Add new Semantic Tag”. A Word Cloud of the most popular tags will appear above the data entry board. A full list will simultaneously appear to the right, should you need to edit any tags.

Please bear in mind that an edit to the tag will be reflected across your site.

If you’ve created the Semantic Tags or used them in posts before you publish your content, you can add them to your post in the “New Post” dashboard as with the previous tag widget.  Only this time, our Plug-In will render in the sidebar, too.

<h3>Creating your Semantic Tag</h3>

There are 10 possible entry fields - don’t panic.  You’ll soon get used to filling these in quickly and efficiently.

<strong>The features are as follows:</strong>
<ul>
<ol>1. Name - this is the name of your tag and what will appear beneath your post as a Semantic Tag.</ol>
<ol>2. Link - this is the relevant content that you would like your customer to be taken to once they click on the tag.</ol>
<ol>3. Rel - here, you can enter multiple rel= attributes.  If you’re linking to external sources, it is well worth entering a “nofollow“ here as your first rel. A space in between each is all you need to enter multiple rel properties</ol>
<ol>4. Title - is the text that customers see when they hover over the tag; needless to say, it should be relevant to the content you’re linking to.</ol>
<ol>5. Property - what is the type of tag you are entering, such as a Ctag that would be in the source code of your page</ol>
<ol>6. Resource - is a background link that provides authority to your tag.  It will not be clickable on site</ol>
<ol>7. Content - describe the related content to the tag within your article</ol>
<ol>8. Typeof - defines the type of operand to the search engine</ol>
<ol>9. Target - if you want the tag link (2.) to open in new tab, check this box</ol>
<ol>10. Popup - similarly, if you’d prefer a popup (keeping the reader on page), check this box</ol>
</ul>
And that’s all there is to it.

Press update and the tag, with all its configuration data, will save in the “Saved/Editable Tag” list.

You can add each tag to your post from the Semantic Tag Sidebar Widget and, when published, they will render on the screen.

Please proceed to our FAQ where we have a list of queries we had ourselves when creating this Plug-In.

Thanks for downloading our Semantic Tag Plug In; don’t forget to write a rave review!


== Installation ==

1. Upload the whole folder to the /wp-content/plugins/ directory.

2. Activate the plugin through the Plugins menu in WordPress.




<h3>How to use it</h3>

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



== Frequently Asked Questions ==

<h3>Semantic Tag Plug-In FAQ</h3><br>

<strong>Do I need to use other WordPress.org tag widgets?</strong><br>
No, semantic tags are the only tag markup you’ll need.

<strong>Can I use this Plug-In for Authorship markup?</strong><br>
Theoretically, yes, if you were handy with editing the code.
However, we do have a similar Plug-In coming soon that will add rel=author for you.





== Changelog ==


= 1.1.2 =

* tags not visible if url is not set.

= 1.1.0 =

* removed css file

= 1.0.0 =

* Initial release