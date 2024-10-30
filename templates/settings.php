<h2>How to use it </h2>

<h3>Choose one of the follow:</h3>
<ul>
	<li>
<p><strong>1. Tag cloud Widget</strong></p>
<p>Go to admin panel on  Appearance-> Widgets.</p>
<p>Add SemanticWidget in a widget area of your choise.</p>
	</li>
	<li>
<p><strong>2. Shortcode</strong></br></p>
<p>Add the shortcode [semantic_tags] in any text field.</p>
	</li>
	<li>
<p><strong>3. Template page</strong></p>
<p>Replace get_the_tag_list('', __(', ' , '')) with SemanticTags_Plugin::get_semantic_tags() on index.php or function.php files. </p>
<p>Alternative you can add "echo  SemanticTags_Plugin::get_semantic_tags()" in any template page.</p>
	</li>
<ul>