<?php
/**
 * Plugin Name: Web4 Presence Spec
 * Description: Publishes agentic presence.w4 data for LLM/agentic SEO. Auto-imports SEO plugin data, supports manual overrides, does robust llms.txt, robots.txt, and settings admin.
 * Version: 0.1.0
 * Author: Shawn McGinnis, FerretDev
 * License: GPL2 or later
 * Text Domain: web4-presence
 */

defined( 'ABSPATH' ) || exit;

if ( version_compare( PHP_VERSION, '7.4', '<' ) ) {
	add_action(
		'admin_notices',
		static function () {
			echo '<div class="notice notice-error"><p>Web4 Presence Spec plugin requires PHP 7.4 or higher.</p></div>';
		}
	);
	return;
}

define( 'WEB4_PRESENCE_CONTEXT_OPTION', 'web4_presence_settings' );
define( 'WEB4_PRESENCE_VERSION', '0.1.0' );
define( 'WEB4_PRESENCE_LLMSTXT_HEADER', "# --- WEB4 PRESENCE SPEC START ---\n" );
define( 'WEB4_PRESENCE_LLMSTXT_FOOTER', "# --- WEB4 PRESENCE SPEC END ---\n" );

/* ---------- Admin: Settings Registration & Page ---------- */
add_action( 'admin_menu', 'web4_presence_register_settings_page' );
function web4_presence_register_settings_page() {
	add_options_page(
		'Web4 Presence',
		'Web4 Presence',
		'manage_options',
		'web4-presence-settings',
		'web4_presence_settings_page'
	);
}
add_action( 'admin_init', 'web4_presence_register_settings' );
function web4_presence_register_settings() {
	register_setting( 'web4_presence_settings', WEB4_PRESENCE_CONTEXT_OPTION );
}
function web4_presence_settings_page() {
	$options = get_option( WEB4_PRESENCE_CONTEXT_OPTION, [] );
	$type  = $options['identity_type'] ?? 'Organization';
	$context = $options['for_agents_context'] ?? '';
	$keywords = $options['for_agents_keywords'] ?? '';
	$city = $options['local_city'] ?? '';
	$region = $options['local_region'] ?? '';
	$country = $options['local_country'] ?? '';
	$primary_action = $options['actions_primary'] ?? '';
	$primary_url = $options['actions_primary_url'] ?? '';
	?>
	<div class="wrap">
	<h1>Web4 Presence Settings</h1>
	<form method="post" action="options.php">
	<?php settings_fields( 'web4_presence_settings' ); ?>
	<table class="form-table">
	<tr>
		<th scope="row"><label for="identity_type">Business type</label></th>
		<td>
		<select name="<?php echo esc_attr( WEB4_PRESENCE_CONTEXT_OPTION ); ?>[identity_type]" id="identity_type">
			<option value="Organization"<?php selected( $type, 'Organization' ); ?>>Organization</option>
			<option value="Person"<?php selected( $type, 'Person' ); ?>>Person</option>
		</select>
		</td>
	</tr>
	<tr>
		<th scope="row"><label for="for_agents_context">Agent Context (for:agents:context)</label></th>
		<td>
			<textarea name="<?php echo esc_attr( WEB4_PRESENCE_CONTEXT_OPTION ); ?>[for_agents_context]" id="for_agents_context" rows="4" cols="60"><?php echo esc_textarea( $context ); ?></textarea>
		</td>
	</tr>
	<tr>
		<th scope="row"><label for="for_agents_keywords">Keywords</label></th>
		<td>
			<input type="text" name="<?php echo esc_attr( WEB4_PRESENCE_CONTEXT_OPTION ); ?>[for_agents_keywords]" id="for_agents_keywords" value="<?php echo esc_attr( $keywords ); ?>" size="60" />
		</td>
	</tr>
	<tr>
		<th scope="row"><label for="local_city">City</label></th>
		<td><input type="text" name="<?php echo esc_attr( WEB4_PRESENCE_CONTEXT_OPTION ); ?>[local_city]" id="local_city" value="<?php echo esc_attr( $city ); ?>" /></td>
	</tr>
	<tr>
		<th scope="row"><label for="local_region">Region</label></th>
		<td><input type="text" name="<?php echo esc_attr( WEB4_PRESENCE_CONTEXT_OPTION ); ?>[local_region]" id="local_region" value="<?php echo esc_attr( $region ); ?>" /></td>
	</tr>
	<tr>
		<th scope="row"><label for="local_country">Country</label></th>
		<td><input type="text" name="<?php echo esc_attr( WEB4_PRESENCE_CONTEXT_OPTION ); ?>[local_country]" id="local_country" value="<?php echo esc_attr( $country ); ?>" /></td>
	</tr>
	<tr>
		<th scope="row"><label for="actions_primary">Primary Action Type</label></th>
		<td><input type="text" name="<?php echo esc_attr( WEB4_PRESENCE_CONTEXT_OPTION ); ?>[actions_primary]" id="actions_primary" value="<?php echo esc_attr( $primary_action ); ?>" /></td>
	</tr>
	<tr>
		<th scope="row"><label for="actions_primary_url">Primary Action URL</label></th>
		<td><input type="url" name="<?php echo esc_attr( WEB4_PRESENCE_CONTEXT_OPTION ); ?>[actions_primary_url]" id="actions_primary_url" value="<?php echo esc_attr( $primary_url ); ?>" size="60" /></td>
	</tr>
	</table>
	<?php submit_button(); ?>
	</form>
	</div>
	<?php
}

/* ---------- Auto-Import: SEO Plugins (Yoast, SEOPress, RankMath), Schema.org JSON-LD ---------- */
function web4_presence_detect_seo_plugin() {
	if ( defined( 'RANK_MATH_VERSION' ) ) {
		return 'rankmath';
	}
	if ( defined( 'WPSEO_VERSION' ) ) {
		return 'yoast';
	}
	if ( function_exists( 'seopress_init' ) || class_exists( 'SEOPRESS_ADMIN' ) ) {
		return 'seopress';
	}
	return 'none';
}

function web4_presence_import_from_rankmath() {
	$data = [];
	$options = get_option( 'rank-math-options-titles', [] );
	$data['identity:type'] = $options['person_or_company'] === 'person' ? 'Person' : 'Organization';
	$data['identity:name'] = $data['identity:type'] === 'Person' ? $options['person_name'] : $options['company_name'];
	$data['meta:tagline'] = $options['home_description'] ?? '';
	$data['identity:tagline'] = $options['home_description'] ?? '';
	$data['identity:image'] = $options['company_logo'] ?? '';
	$data['identity:keywords'] = implode( ',', array_filter( [ $options['home_keywords'] ?? '' ] ) );
	return $data;
}

function web4_presence_import_from_yoast() {
	$data = [];
	$data['identity:type'] = get_option( 'wpseo_company_or_person', 'organization' ) === 'person' ? 'Person' : 'Organization';
	$data['identity:name'] = ( $data['identity:type'] === 'Person' )
		? get_option( 'wpseo_person_name', get_bloginfo( 'name' ) )
		: get_option( 'wpseo_org_name', get_bloginfo( 'name' ) );
	$yoast_settings = get_option( 'wpseo_titles', [] );
	$data['meta:tagline'] = $yoast_settings['metadesc-home-wpseo'] ?? get_bloginfo( 'description' );
	$data['identity:tagline'] = $yoast_settings['metadesc-home-wpseo'] ?? get_bloginfo( 'description' );
	$data['identity:image'] = get_option( 'wpseo_org_logo', function_exists( 'get_site_icon_url' ) ? get_site_icon_url() : '' );
	return $data;
}

function web4_presence_import_from_seopress() {
	$data = [];
	$seopress_titles = get_option( 'seopress_titles_option_name' );
	if ( isset( $seopress_titles['seopress_titles_knowledge_type'] ) ) {
		$data['identity:type'] = $seopress_titles['seopress_titles_knowledge_type'] == 'person' ? 'Person' : 'Organization';
	}
	$data['identity:name'] = $seopress_titles['seopress_titles_knowledge_' . strtolower( $data['identity:type'] ?? 'Organization' ) . '_name'] ?? get_bloginfo( 'name' );
	$data['meta:tagline'] = $seopress_titles['seopress_titles_home_desc'] ?? get_bloginfo( 'description' );
	$data['identity:tagline'] = $seopress_titles['seopress_titles_home_desc'] ?? get_bloginfo( 'description' );
	$data['identity:image'] = $seopress_titles['seopress_titles_knowledge_img'] ?? ( function_exists( 'get_site_icon_url' ) ? get_site_icon_url() : '' );
	return $data;
}

function web4_presence_extract_jsonld_schema() {
	// Fetch homepage HTML
	$response = wp_remote_get( home_url( '/' ) );
	if ( is_wp_error( $response ) ) {
		return [];
	}
	$html = wp_remote_retrieve_body( $response );
	preg_match_all( '/<script type="application\/ld\+json">(.*?)<\/script>/si', $html, $matches );
	$schemas = [];
	foreach ( $matches[1] as $json_ld ) {
		$decoded = json_decode( $json_ld, true );
		if ( is_array( $decoded ) ) {
			if ( isset( $decoded['@type'] ) && in_array( $decoded['@type'], [ 'Organization', 'Person' ], true ) ) {
				$schemas[] = $decoded;
			}
			if ( isset( $decoded['@graph'] ) && is_array( $decoded['@graph'] ) ) {
				foreach ( $decoded['@graph'] as $item ) {
					if ( isset( $item['@type'] ) && in_array( $item['@type'], [ 'Organization', 'Person' ], true ) ) {
						$schemas[] = $item;
					}
				}
			}
		}
	}
	return $schemas;
}

/* ---------- Aggregate presence.w4 fields and settings ---------- */
function web4_build_presence_w4() {
	$options = get_option( WEB4_PRESENCE_CONTEXT_OPTION, [] );
	$seo_tool = web4_presence_detect_seo_plugin();
	$data = [];
	switch ( $seo_tool ) {
		case 'rankmath':
			$data = web4_presence_import_from_rankmath();
			break;
		case 'yoast':
			$data = web4_presence_import_from_yoast();
			break;
		case 'seopress':
			$data = web4_presence_import_from_seopress();
			break;
	}
	$schemas = web4_presence_extract_jsonld_schema();
	if ( ! empty( $schemas ) ) {
		$schema = $schemas[0];
		$data['identity:type'] = $data['identity:type'] ?? ( $schema['@type'] ?? '' );
		$data['identity:name'] = $data['identity:name'] ?? ( $schema['name'] ?? '' );
		$data['identity:tagline'] = $data['identity:tagline'] ?? ( $schema['description'] ?? '' );
		$data['identity:image'] = $data['identity:image'] ?? ( $schema['logo'] ?? '' );
	}
	$data['meta:schema']   = 'https://web4presence.org/schema/2026-03-17';
	$data['meta:version']  = WEB4_PRESENCE_VERSION;
	$data['meta:updated']  = gmdate( 'c' );
	$data['meta:ttl']      = 86400;
	$data['trust:verified'] = get_bloginfo( 'admin_email' );

	$data['identity:type'] = $options['identity_type'] ?? $data['identity:type'] ?? 'Organization';
	$data['for:agents:context']  = $options['for_agents_context'] ?? '';
	$data['for:agents:keywords'] = $options['for_agents_keywords'] ?? '';
	$data['local:city']    = $options['local_city'] ?? '';
	$data['local:region']  = $options['local_region'] ?? '';
	$data['local:country'] = $options['local_country'] ?? '';
	$data['actions:primary'] = $options['actions_primary'] ?? '';
	$data['actions:primary_url'] = $options['actions_primary_url'] ?? '';
	$data['compat:schema-org'] = $seo_tool;
	$data['compat:llms-txt'] = file_exists( ABSPATH . 'llms.txt' ) ? 'exists' : 'absent';

	return apply_filters( 'web4_presence_w4_object', $data );
}

/* ---------- REST API /presence.w4 endpoints ---------- */
add_action( 'rest_api_init', static function () {
	register_rest_route( 'web4/v1', '/presence', [
		'methods' => 'GET',
		'callback' => 'web4_presence_get_data',
		'permission_callback' => '__return_true',
	] );
});
function web4_presence_get_data() {
	return rest_ensure_response( web4_build_presence_w4() );
}

/* .well-known/presence.w4 friendly endpoint */
add_action( 'init', 'web4_presence_add_rewrite_rule' );
function web4_presence_add_rewrite_rule() {
	add_rewrite_rule( '^.well-known/presence.w4$', 'index.php?web4_presence_wellknown=1', 'top' );
}
add_filter( 'query_vars', static function ( $vars ) {
	$vars[] = 'web4_presence_wellknown';
	return $vars;
});
add_action( 'parse_request', static function ( $wp ) {
	if ( ! empty( $wp->query_vars['web4_presence_wellknown'] ) ) {
		header( 'Content-Type: application/web4+json; charset=utf-8' );
		echo wp_json_encode( web4_build_presence_w4() );
		exit;
	}
});

/* ---------- LLMs.txt append-only management ---------- */
function web4_presence_append_llms_section() {
	$llms_file = ABSPATH . 'llms.txt';
	$presence_url = '/wp-json/web4/v1/presence';
	$presence = web4_build_presence_w4();
	$section = WEB4_PRESENCE_LLMSTXT_HEADER;
	$section .= "X-W4-Presence: {$presence_url}\n";
	if ( ! empty( $presence['for:agents:context'] ) ) {
		$section .= "# for:agents:context\n" . $presence['for:agents:context'] . "\n";
	}
	$section .= "updated: " . gmdate( 'c' ) . "\n";
	$section .= WEB4_PRESENCE_LLMSTXT_FOOTER;

	$current = file_exists( $llms_file ) ? file_get_contents( $llms_file ) : '';
	if ( strpos( $current, 'X-W4-Presence:' ) !== false ) {
		// Replace existing section
		$current = preg_replace(
			'/' . preg_quote( WEB4_PRESENCE_LLMSTXT_HEADER, '/' ) . '.*?' . preg_quote( WEB4_PRESENCE_LLMSTXT_FOOTER, '/' ) . '/s',
			$section,
			$current
		);
	} else {
		$current = rtrim( $current ) . "\n" . $section;
	}
	file_put_contents( $llms_file, $current );
}
register_activation_hook( __FILE__, 'web4_presence_append_llms_section' );
add_action( 'update_option_' . WEB4_PRESENCE_CONTEXT_OPTION, 'web4_presence_append_llms_section', 10 );

/* ---------- Uninstall: Only remove Web4 section from llms.txt ---------- */
register_uninstall_hook( __FILE__, 'web4_presence_cleanup_on_uninstall' );
function web4_presence_cleanup_on_uninstall() {
	$llms_file = ABSPATH . 'llms.txt';
	if ( file_exists( $llms_file ) ) {
		$content = file_get_contents( $llms_file );
		$content = preg_replace(
			'/' . preg_quote( WEB4_PRESENCE_LLMSTXT_HEADER, '/' ) . '.*?' . preg_quote( WEB4_PRESENCE_LLMSTXT_FOOTER, '/' ) . '/s',
			'',
			$content
		);
		$content = preg_replace( "/\n+/", "\n", $content );
		file_put_contents( $llms_file, ltrim( $content ) );
	}
	delete_option( WEB4_PRESENCE_CONTEXT_OPTION );
}

/* ---------- robots.txt: Agent rules ---------- */
add_filter( 'robots_txt', static function ( $output, $public ) {
	$agents = [
		'GPTBot', 'ClaudeBot', 'PerplexityBot', 'CCBot',
		'Googlebot', 'bingbot', 'anthropic-ai', 'ChatGPT-User'
	];
	$output .= "\n# Web4/AI-Crawler Agent Permissions\n";
	foreach ( $agents as $a ) {
		$output .= "User-agent: {$a}\nAllow: /wp-json/web4/v1/presence\n";
	}
	return $output;
}, 10, 2 );

/* ---------- HTTP headers & meta ---------- */
add_action( 'send_headers', static function () {
	if ( ! is_admin() ) {
		header( 'Link: </wp-json/web4/v1/presence>; rel="presence"; type="application/web4+json"', false );
	}
});
add_action( 'wp_head', static function () {
	echo '<link rel="presence" href="' . esc_url( home_url( '/wp-json/web4/v1/presence' ) ) . '" type="application/web4+json" />' . "\n";
}, 2 );
