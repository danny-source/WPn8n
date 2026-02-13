<?php
/**
 * Plugin Name:       WP n8n
 * Plugin URI:        https://da2.35g.tw/
 * Description:       Embed interactive n8n workflow demos directly in your WordPress posts, pages, and comments using a simple shortcode. Perfect for documentation, tutorials, and showcasing automation workflows.
 * Version:           1.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Danny
 * Author URI:        https://da2.35g.tw/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       wpn8n
 * Domain Path:       /languages
 *
 * WP n8n is a WordPress plugin that enables n8n workflow demo rendering.
 */

// 版本資訊
define( 'WPN8N_VERSION', '1.0.1' );
define( 'WPN8N_N8N_DEMO_VERSION', 'latest' );

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Main plugin class.
 *
 * A singleton class to ensure the plugin is loaded only once.
 */
final class WPN8N_Plugin {

	/**
	 * The single instance of the class.
	 *
	 * @var WPN8N_Plugin|null
	 */
	private static ?WPN8N_Plugin $instance = null;

	/**
	 * Main instance.
	 *
	 * Ensures only one instance of the class is loaded.
	 *
	 * @return WPN8N_Plugin - The main instance.
	 */
	public static function instance(): WPN8N_Plugin {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 *
	 * Private to prevent direct object creation.
	 */
	private function __construct() {
		$this->define_constants();
		$this->register_hooks();
	}

	/**
	 * Define plugin constants.
	 */
	private function define_constants(): void {
		define( 'WPN8N_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		define( 'WPN8N_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
	}

	/**
	 * Register all hooks for the plugin.
	 */
	private function register_hooks(): void {
		// Load text domain for translations
		add_action( 'plugins_loaded', [ $this, 'load_textdomain' ] );

		// Add n8n-demo-webcomponent scripts
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_n8n_demo_script' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_n8n_demo_script' ] );

		// Set n8n-demo-component script as module type
		add_filter( 'script_loader_tag', [ $this, 'set_n8n_demo_script_module_type' ], 10, 2 );

		// 添加設定頁面
		add_action( 'admin_menu', [ $this, 'add_admin_menu' ] );
		add_action( 'admin_init', [ $this, 'register_settings' ] );

		// 在外掛列表加入 Settings 連結
		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), [ $this, 'add_settings_link' ] );

		// Register WordPress shortcode
		add_shortcode( 'n8n', [ $this, 'n8n_shortcode' ] );
	}

	/**
	 * Load plugin textdomain.
	 */
	public function load_textdomain(): void {
		load_plugin_textdomain(
			'wpn8n',
			false,
			dirname( plugin_basename( __FILE__ ) ) . '/languages'
		);
	}

	/**
	 * Enqueue n8n-demo-webcomponent scripts
	 */
	public function enqueue_n8n_demo_script(): void {
		// Web Components Loader
		wp_enqueue_script(
			'webcomponents-loader',
			'https://cdn.jsdelivr.net/npm/@webcomponents/webcomponentsjs@2.0.0/webcomponents-loader.js',
			[],
			'2.0.0',
			false
		);

		// Lit polyfill support
		wp_enqueue_script(
			'lit-polyfill-support',
			'https://www.unpkg.com/lit@2.0.0-rc.2/polyfill-support.js',
			[],
			'2.0.0-rc.2',
			false
		);

		// n8n-demo component (module script)
		wp_enqueue_script(
			'n8n-demo-component',
			'https://cdn.jsdelivr.net/npm/@n8n_io/n8n-demo-component/n8n-demo.bundled.js',
			[],
			WPN8N_N8N_DEMO_VERSION,
			true
		);
	}

	/**
	 * Set n8n-demo-component script as module type
	 *
	 * @param string $tag    The script tag HTML.
	 * @param string $handle The script handle.
	 * @return string Modified script tag.
	 */
	public function set_n8n_demo_script_module_type( string $tag, string $handle ): string {
		if ( 'n8n-demo-component' === $handle ) {
			$tag = str_replace( '<script ', '<script type="module" ', $tag );
		}
		return $tag;
	}

	/**
	 * WordPress shortcode handler for n8n workflow demos
	 *
	 * Usage: [n8n workflow='...'] or [n8n]...[/n8n]
	 *
	 * @param array  $atts    Shortcode attributes.
	 * @param string $content Shortcode content (if using closing tag).
	 * @return string The rendered n8n-demo web component.
	 */
	public function n8n_shortcode( $atts = [], $content = null ): string {
		// Parse attributes
		$atts = shortcode_atts(
			[
				'workflow' => '',
			],
			$atts,
			'n8n'
		);

		// Get workflow JSON from attribute or content
		$workflow_json = ! empty( $atts['workflow'] ) ? $atts['workflow'] : $content;
		
		if ( empty( $workflow_json ) ) {
			return '<!-- n8n shortcode: No workflow JSON provided -->';
		}

		// Clean up the JSON (remove extra whitespace, decode HTML entities)
		$workflow_json = trim( $workflow_json );
		$workflow_json = html_entity_decode( $workflow_json, ENT_QUOTES | ENT_HTML5, 'UTF-8' );
		
		// Validate JSON format
		$decoded = json_decode( $workflow_json, true );
		if ( json_last_error() !== JSON_ERROR_NONE ) {
			// If not valid JSON, return error message
			return '<!-- Invalid n8n workflow JSON: ' . esc_html( json_last_error_msg() ) . ' -->';
		}
		
		// Security: Re-encode JSON to prevent XSS, but keep it as valid JSON string
		$workflow_json_escaped = esc_attr( $workflow_json );
		
		// Output the n8n-demo web component
		return '<n8n-demo workflow=\'' . $workflow_json_escaped . '\'></n8n-demo>';
	}

	/**
	 * 添加設定頁面到 WordPress 後台選單
	 */
	public function add_admin_menu(): void {
		add_options_page(
			'WP n8n Settings', // 頁面標題
			'WP n8n',          // 選單標題
			'manage_options',   // 權限
			'wpn8n',           // 選單 slug
			[ $this, 'render_settings_page' ] // 回調函數
		);
	}

	/**
	 * 註冊設定
	 */
	public function register_settings(): void {
		register_setting( 'wpn8n_settings', 'wpn8n_settings' );
	}

	/**
	 * 渲染設定頁面
	 */
	public function render_settings_page(): void {
		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			
			<div class="card">
				<h2>Core Components Information</h2>
				<table class="form-table">
					<tr>
						<th scope="row">Author</th>
						<td>
							<p>Danny</p>
							<p>Website: <a href="https://da2.35g.tw" target="_blank">https://da2.35g.tw</a></p>
						</td>
					</tr>
					<tr>
						<th scope="row">Plugin Version</th>
						<td><?php echo esc_html( WPN8N_VERSION ); ?></td>
					</tr>
					<tr>
						<th scope="row">n8n-demo-webcomponent</th>
						<td>
							<p>Version: <?php echo esc_html( WPN8N_N8N_DEMO_VERSION ); ?></p>
							<p>Used for rendering n8n workflow demos</p>
							<p>Source: <a href="https://n8n-io.github.io/n8n-demo-webcomponent/" target="_blank">https://n8n-io.github.io/n8n-demo-webcomponent/</a></p>
						</td>
					</tr>
				</table>
			</div>

			<div class="card">
				<h2>Usage Guide</h2>
				<p>Write your content and use the <code>[n8n]</code> shortcode to embed n8n workflow demos.</p>
				
				<h3>Basic Example:</h3>
				<pre><code>[n8n]
{
  "nodes": [
    {
      "name": "Webhook",
      "type": "n8n-nodes-base.webhook",
      "position": [250, 300],
      "parameters": {
        "path": "webhook",
        "httpMethod": "POST"
      },
      "typeVersion": 1
    },
    {
      "name": "Set",
      "type": "n8n-nodes-base.set",
      "position": [450, 300],
      "parameters": {},
      "typeVersion": 1
    }
  ],
  "connections": {
    "Webhook": {
      "main": [
        [
          {
            "node": "Set",
            "type": "main",
            "index": 0
          }
        ]
      ]
    }
  }
}
[/n8n]</code></pre>

				<h3>Complete Workflow Example:</h3>
				<pre><code>[n8n]
{
  "nodes": [
    {
      "name": "Start",
      "type": "n8n-nodes-base.webhook",
      "position": [240, 300],
      "parameters": {
        "path": "demo",
        "httpMethod": "GET"
      },
      "typeVersion": 1
    },
    {
      "name": "HTTP Request",
      "type": "n8n-nodes-base.httpRequest",
      "position": [460, 300],
      "parameters": {
        "url": "https://api.example.com/data",
        "method": "GET"
      },
      "typeVersion": 1
    },
    {
      "name": "Set",
      "type": "n8n-nodes-base.set",
      "position": [680, 300],
      "parameters": {
        "values": {
          "string": [
            {
              "name": "message",
              "value": "Hello from n8n!"
            }
          ]
        }
      },
      "typeVersion": 1
    }
  ],
  "connections": {
    "Start": {
      "main": [
        [
          {
            "node": "HTTP Request",
            "type": "main",
            "index": 0
          }
        ]
      ]
    },
    "HTTP Request": {
      "main": [
        [
          {
            "node": "Set",
            "type": "main",
            "index": 0
          }
        ]
      ]
    }
  }
}
[/n8n]</code></pre>

				<h3>Alternative Syntax (using workflow attribute):</h3>
				<pre><code>[n8n workflow='{"nodes":[...],"connections":{}}']</code></pre>

				<p><strong>Note:</strong> The workflow JSON must be valid JSON format. You can export workflows from n8n and paste the JSON directly into the shortcode. Use the closing tag format <code>[n8n]...[/n8n]</code> for better readability with multi-line JSON.</p>
			</div>
		</div>
		<?php
	}

	/**
	 * 在外掛列表加入 Settings 連結
	 */
	public function add_settings_link( $links ) {
		$settings_link = '<a href="options-general.php?page=wpn8n">Settings</a>';
		array_unshift( $links, $settings_link );
		return $links;
	}

	/**
	 * Cloning is forbidden.
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'wpn8n' ), '1.0.0' );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'wpn8n' ), '1.0.0' );
	}
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @return WPN8N_Plugin The instance of the plugin.
 */
function wpn8n_plugin_run(): WPN8N_Plugin {
	return WPN8N_Plugin::instance();
}

// Let's get this party started!
wpn8n_plugin_run();
