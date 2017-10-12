<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _s
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<script>
/*! grunt-grunticon Stylesheet Loader - v2.1.6 | https://github.com/filamentgroup/grunticon | (c) 2015 Scott Jehl, Filament Group, Inc. | MIT license. */

!function(){function e(e,n,t){"use strict";var o=window.document.createElement("link"),r=n||window.document.getElementsByTagName("script")[0],a=window.document.styleSheets;return o.rel="stylesheet",o.href=e,o.media="only x",r.parentNode.insertBefore(o,r),o.onloadcssdefined=function(e){for(var n,t=0;t<a.length;t++)a[t].href&&a[t].href===o.href&&(n=!0);n?e():setTimeout(function(){o.onloadcssdefined(e)})},o.onloadcssdefined(function(){o.media=t||"all"}),o}function n(e,n){e.onload=function(){e.onload=null,n&&n.call(e)},"isApplicationInstalled"in navigator&&"onloadcssdefined"in e&&e.onloadcssdefined(n)}!function(t){var o=function(r,a){"use strict";if(r&&3===r.length){var i=t.navigator,c=t.document,s=t.Image,d=!(!c.createElementNS||!c.createElementNS("http://www.w3.org/2000/svg","svg").createSVGRect||!c.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#Image","1.1")||t.opera&&i.userAgent.indexOf("Chrome")===-1||i.userAgent.indexOf("Series40")!==-1),l=new s;l.onerror=function(){o.method="png",o.href=r[2],e(r[2])},l.onload=function(){var t=1===l.width&&1===l.height,i=r[t&&d?0:t?1:2];t&&d?o.method="svg":t?o.method="datapng":o.method="png",o.href=i,n(e(i),a)},l.src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==",c.documentElement.className+=" grunticon"}};o.loadCSS=e,o.onloadCSS=n,t.grunticon=o}(this),function(e,n){"use strict";var t,o=n.document,r="grunticon:",a=function(e){if(o.attachEvent?"complete"===o.readyState:"loading"!==o.readyState)e();else{var n=!1;o.addEventListener("readystatechange",function(){n||(n=!0,e())},!1)}},i=function(e){return n.document.querySelector('link[href$="'+e+'"]')},c=function(e,n){if(t&&!n)return t;t={};var o,a,i,c,s,d;if(o=e.sheet,!o)return t;a=o.cssRules?o.cssRules:o.rules;for(var l=0;l<a.length;l++)i=a[l].cssText,c=r+a[l].selectorText,s=i.split(");")[0].match(/US\-ASCII\,([^"']+)/),s&&s[1]&&(d=decodeURIComponent(s[1]),t[c]=d);return t},s=function(e,n){var t,a,i,c,s;n?t=e:(n=e,t=o),c="data-grunticon-embed";for(var d in n){s=d.slice(r.length);try{a=t.querySelectorAll(s)}catch(e){continue}i=[];for(var l=0;l<a.length;l++)null!==a[l].getAttribute(c)&&i.push(a[l]);if(i.length)for(l=0;l<i.length;l++)i[l].innerHTML=n[d],i[l].style.backgroundImage="none",i[l].removeAttribute(c)}return i},d=function(n,t){"svg"===e.method&&a(function(){var o=c(i(e.href));"function"==typeof t?(s(n,o),t()):s(o),"function"==typeof n&&n()})};e.embedIcons=s,e.getCSS=i,e.getIcons=c,e.ready=a,e.svgLoadedCallback=d,e.embedSVG=d}(grunticon,this)}();
			
	grunticon(["<?php echo get_template_directory_uri() ?>/img/icons/icons.data.svg.css", "<?php echo get_template_directory_uri() ?>/img/icons/icons.data.png.css", "<?php echo get_template_directory_uri() ?>/img/icons/icons.fallback.css"], grunticon.svgLoadedCallback);
</script>
<noscript><link href="<?php echo get_template_directory_uri() ?>/img/icons/icons.fallback.css" rel="stylesheet"></noscript>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="container">
	<div class="skip-links"><a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'theme_name' ); ?></a></div>

	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">
			<?php
			if ( is_front_page() && is_home() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="http://via.placeholder.com/200x100" alt="<?php bloginfo( 'name' ); ?>"></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="http://via.placeholder.com/200x100" alt="<?php bloginfo( 'name' ); ?>"></a></p>
			<?php
			endif;

			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) : ?>
				<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
			<?php
			endif; ?>
		</div><!-- .site-branding -->

		<input type="checkbox" id="btn-burger" class="btn-burger-checkbox">
		<label for="btn-burger" role="button" class="btn-burger-label" aria-labelledby="menu"><span class="lines"></span></label>

		<nav id="site-navigation" class="main-navigation" role="navigation">					
			
			<?php wp_nav_menu( array( 'theme_location' => 'menu-1', 'menu_id' => 'primary-menu', 'container' => '', 'menu_class' => 'nav-menu' ) ); ?>
		</nav><!-- #site-navigation -->		

	</header><!-- #masthead -->

	<div id="content" class="site-content">
