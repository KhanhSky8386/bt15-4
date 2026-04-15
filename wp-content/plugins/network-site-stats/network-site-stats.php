<?php
/**
 * Plugin Name: Network Site Stats
 * Plugin URI: http://example.com/network-site-stats
 * Description: Super Admin tính năng theo dõi tình trạng các trang web con trong mạng lưới
 * Version: 1.0.0
 * Author: jimtrung
 * Author URI: http://example.com 
 * Text Domain: network-site-stats
 * Domain Path: /languages
 * Network: true
 * 
 * @package NetworkSiteStats
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main class for Network Site Stats plugin
 */
class Network_Site_Stats {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'network_admin_menu', array( $this, 'add_network_admin_menu' ) );
	}

	/**
	 * Add menu item to Network Admin Dashboard
	 */
	public function add_network_admin_menu() {
		add_menu_page(
			__( 'Network Site Stats', 'network-site-stats' ),
			__( 'Site Stats', 'network-site-stats' ),
			'manage_network',
			'network_site_stats',
			array( $this, 'display_stats_page' ),
			'dashicons-chart-bar',
			2
		);
	}

	/**
	 * Display the stats page
	 */
	public function display_stats_page() {
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Network Site Statistics', 'network-site-stats' ); ?></h1>
			<p><?php esc_html_e( 'Tổng quan về tất cả các trang web trong mạng lưới', 'network-site-stats' ); ?></p>
			
			<?php $this->display_stats_table(); ?>
		</div>
		<?php
	}

	/**
	 * Display the statistics table
	 */
	private function display_stats_table() {
		$sites = get_sites( array(
			'limit' => 999,
		) );

		if ( empty( $sites ) ) {
			echo '<p>' . esc_html__( 'Không có trang web con nào.', 'network-site-stats' ) . '</p>';
			return;
		}

		?>
		<table class="wp-list-table widefat fixed striped">
			<thead>
				<tr>
					<th><?php esc_html_e( 'Site ID', 'network-site-stats' ); ?></th>
					<th><?php esc_html_e( 'Tên Trang Web', 'network-site-stats' ); ?></th>
					<th><?php esc_html_e( 'URL', 'network-site-stats' ); ?></th>
					<th><?php esc_html_e( 'Số lượng Bài Viết', 'network-site-stats' ); ?></th>
					<th><?php esc_html_e( 'Số lượng Users', 'network-site-stats' ); ?></th>
					<th><?php esc_html_e( 'Ngày Đăng Mới Nhất', 'network-site-stats' ); ?></th>
					<th><?php esc_html_e( 'Dung Lượng (MB)', 'network-site-stats' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $sites as $site ) : ?>
					<?php $this->render_site_row( $site ); ?>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php
	}

	/**
	 * Render a single site row in the table
	 *
	 * @param WP_Site $site Site object
	 */
	private function render_site_row( $site ) {
		// Switch to the specific blog to get its data
		switch_to_blog( $site->blog_id );

		// Get post count
		$post_count = wp_count_posts( 'post' );
		$published_posts = isset( $post_count->publish ) ? (int) $post_count->publish : 0;

		// Get latest post date
		$latest_post_query = new WP_Query( array(
			'posts_per_page' => 1,
			'orderby'        => 'date',
			'order'          => 'DESC',
		) );

		$latest_post_date = __( 'N/A', 'network-site-stats' );
		if ( $latest_post_query->have_posts() ) {
			$latest_post = $latest_post_query->posts[0];
			$latest_post_date = date_i18n( 'd/m/Y H:i', strtotime( $latest_post->post_date ) );
		}

		// Get user count for this site
		$user_count = count_users();
		$total_users = isset( $user_count['total_users'] ) ? (int) $user_count['total_users'] : 0;

		// Get database size for this site
		$db_size = $this->get_db_size_for_site( $site->blog_id );

		// Restore the current blog
		restore_current_blog();

		?>
		<tr>
			<td><strong><?php echo esc_html( $site->blog_id ); ?></strong></td>
			<td><strong><?php echo esc_html( get_blog_option( $site->blog_id, 'blogname' ) ); ?></strong></td>
			<td><a href="<?php echo esc_url( $site->siteurl ); ?>" target="_blank"><?php echo esc_html( $site->siteurl ); ?></a></td>
			<td><?php echo esc_html( $published_posts ); ?></td>
			<td><?php echo esc_html( $total_users ); ?></td>
			<td><?php echo esc_html( $latest_post_date ); ?></td>
			<td><?php echo esc_html( number_format( $db_size, 2 ) ); ?></td>
		</tr>
		<?php
	}

	/**
	 * Get database size for a specific site
	 *
	 * @param int $blog_id Blog ID
	 * @return float Size in MB
	 */
	private function get_db_size_for_site( $blog_id ) {
		global $wpdb;

		// Get the table prefix for the specific site
		if ( $blog_id === 1 ) {
			$table_prefix = $wpdb->prefix;
		} else {
			$table_prefix = $wpdb->prefix . $blog_id . '_';
		}

		// Calculate total size of all tables for this site
		$query = $wpdb->prepare(
			"
			SELECT ROUND( ( data_length + index_length ) / 1024 / 1024, 2 ) AS db_size
			FROM information_schema.TABLES
			WHERE table_schema = %s
			AND table_name LIKE %s
			",
			DB_NAME,
			$table_prefix . '%'
		);

		$result = $wpdb->get_var( $query );

		return $result ? (float) $result : 0;
	}
}

// Initialize the plugin
if ( is_multisite() ) {
	new Network_Site_Stats();
}
