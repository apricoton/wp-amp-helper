# WP AMP Helper
## Usage
### 1. Add your AMP Template
* PATH : path/to/wp/wp-content/themes/YOUR_THEME_PATH/amp/single.php
```php
<?php
the_post();
$entry_image = [];
$image_id = null;

if (has_post_thumbnail()) {
	$image_id = get_post_thumbnail_id();
} else {
	$image = get_posts([
		'post_parent' => get_the_ID(),
		'post_type' => 'attachment',
		'post_mime_type' => 'image',
		'posts_per_page' => 1,
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'suppress_filters' => false,
	]);
	
	if (is_array($image) && isset($image[0]) && isset($image[0]->ID)) {
		$image_id = $image[0]->ID;
	}
}

if ($image_id) {
	$image_info = wp_get_attachment_image_src($image_id, 'full');
	if (is_array($image_info)) {
		$entry_image['url'] = $image_info[0];
		$entry_image['width'] = $image_info[1];
		$entry_image['height'] = $image_info[2];
	}
}
if (!count($entry_image)) {
	$entry_image['url'] = 'https://dummyimage.com/720x480/666/ffffff&text=No+Image';
	$entry_image['width'] = 720;
	$entry_image['height'] = 480;
}

?><!DOCTYPE html>
<html ⚡ lang="<?= get_bloginfo('language') ?>">
	<head>
		<meta charset="utf-8">
		<title><?= wp_title('|', true, 'right') ?></title>
		<link rel="canonical" href="<?= get_permalink() ?>">
		<meta name="viewport" content="width=device-width, minimum-scale=1, initial-scale=1">
		<script type="application/ld+json">
			<?= json_encode([
				'@context' => 'http://schema.org',
				'@type' => 'NewsArticle',
				'mainEntityOfPage' => get_permalink(),
				'headline' => get_the_title(),
				'datePublished' => get_the_date('c'),
				'dateModified' => get_the_modified_date('c'),
				'image' => [
					'@type' => 'ImageObject',
					'url' => $entry_image['url'],
					'width' => $entry_image['width'],
					'height' => $entry_image['height'],
				],
				'author' => [
					'@type' => 'Person',
					'name' => get_the_author_meta('display_name'),
				],
				'publisher' => [
					'@type' => 'Organization',
					'name' => get_bloginfo('name'),
					'logo' => [
						'@type' => 'ImageObject',
						'url' => 'YOUR_BLOG_LOGO_HERE',
						'width' => 'YOUR_BLOG_LOGO_WIDTH_HERE',
						'height' => 'YOUR_BLOG_LOGO_HEIGHT_HERE',
					],
				],
			]) ?>
		</script>
		<style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
		<script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
		<script async custom-element="amp-social-share" src="https://cdn.ampproject.org/v0/amp-social-share-0.1.js"></script>
		<script async src="https://cdn.ampproject.org/v0.js"></script>
		<style amp-custom>
			/* YOUR_AMP_CSS_HERE */
			img,
			amp-img {
				vertical-align: top;
			}
			
			body {
				font-size: 100%;
				font-family: sans-serif;
			}
			
			body>header,
			body>aside,
			body>footer {
				padding: 1rem;
				text-align: center;
			}
			
			body>header {
				border-top: 4px solid #232323;
				border-bottom: 1px solid #ccc;
			}
			
			body>main {
				margin: 1rem auto 0 auto;
				width: 94%;
			}
			
			body>aside {
				margin: 0 auto;
				width: 94%;
			}
			
			body>footer {
				font-size: 0.875rem;
				border-top: 1px solid #ccc;
			}
			
			body>footer small {
				font-size: 0.6rem;
			}
			
			h1,h2,h3,h4,h5,h6,p {
				margin: 0;
			}
			
			h1,
			h2,
			h3,
			p,
			table {
				margin-bottom: 1rem;
			}
			
			body>header .site_name {
				font-size: 2rem;
			}
			
			body>header .description {
				margin-bottom: 0;
			}
			
			body>main article header {
				padding-bottom: 1rem;
				border-bottom: 1px solid #ccc;
			}
			
			body>main article header h1 {
				margin-bottom: 0;
				font-size: 1.75rem;
			}
			
			body>main article header .published {
				font-size: 0.875rem;
				color: #666;
			}
			
			#content {
				padding: 1rem 0;
				font-size: 1.125rem;
				line-height: 1.6;
				border-bottom: 1px solid #ccc;
			}
			
			#content .amp_img {
				margin: 1rem 0;
			}
		</style>
	</head>
	<body>
		<amp-analytics type="googleanalytics" id="googleanalytics">
			<script type="application/json">
				{
					"vars": {
						"account": "YOUR_TRACKING_ID"
					},
					"triggers": {
						"defaultPageview": {
							"on": "visible",
							"request": "pageview"
						}
					}
				}
			</script>
		</amp-analytics>
		<header>
			<div class="site_name"><?= get_bloginfo('name') ?></div>
			<p class="description"><?= get_bloginfo('description') ?></p>
		</header>
		<main>
			<article>
					<header>
						<h1><?= get_the_title() ?></h1>
						<div class="published"><?= get_the_date('Y/n/j H:i:s') ?></div>
					</header>
					<div id="content"><?= wpAmpHelper::ampFilter(get_the_content()) ?></div>
			</article>
		</main>
		<aside>
			<div id="social_share">
				<amp-social-share type="twitter"></amp-social-share>
				<amp-social-share type="facebook" data-param-app_id="YOUR_FACEBOOK_APP_ID"></amp-social-share>
				<amp-social-share type="gplus"></amp-social-share>
			</div>
		</aside>
		<footer>
			<small>Copyright &copy; <?= get_bloginfo('name') ?> All Rights Reserved.</small>
		</footer>
	</body>
</html>
```

### 2. Enable plugin and Enjoy!