<?php
/**
 * Plugin Name: Universal JSON Importer (ACF)
 * Description: Importe/Met à jour n'importe quel post type depuis un JSON et remplit tous les champs ACF dynamiquement (scalaires, repeaters…).
 * Version: 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class Universal_JSON_Importer_ACF {

const MENU_SLUG = 'expertise-json-importer';

// Clés réservées WordPress — tout le reste est traité comme champ ACF
const WP_CORE_KEYS = [
'post_type', 'post_name', 'post_title', 'post_status',
'post_content', 'post_excerpt', 'post_author', 'menu_order',
'slug', 'fields',
];

public function __construct() {
add_action( 'admin_menu', [ $this, 'admin_menu' ] );
add_action( 'admin_post_expertise_json_import', [ $this, 'handle_import' ] );
}

public function admin_menu() {
add_management_page(
'Universal JSON Importer',
'Universal JSON Importer',
'manage_options',
self::MENU_SLUG,
[ $this, 'render_page' ]
);
}

public function render_page() {
if ( ! current_user_can( 'manage_options' ) ) wp_die( 'Accès refusé.' );

$last = get_transient( 'expertise_json_import_last' );
?>
<div class="wrap">
<h1>Universal JSON Importer</h1>

<p>Supporte deux formats JSON :</p>
<ul style="list-style:disc;padding-left:24px">
<li><strong>Format A (items)</strong> — <code>{"items":[{"post_type":"…","post_name":"slug","post_title":"…","champ_acf":"valeur"}]}</code></li>
<li><strong>Format B (tableau)</strong> — <code>[{"slug":"…","post_type":"…","fields":{"champ_acf":"valeur"}}]</code></li>
</ul>
<p>Les posts sont matchés par <strong>slug</strong>. Tous les champs hors clés WP core sont envoyés à <code>update_field()</code>. Les tableaux de tableaux sont traités comme <strong>repeaters</strong> ACF.</p>

<?php if ( $last ) : ?>
<div class="notice notice-info is-dismissible"><pre style="white-space:pre-wrap;word-break:break-all"><?php echo esc_html( $last ); ?></pre></div>
<?php endif; ?>

<?php if ( ! function_exists( 'update_field' ) ) : ?>
<div class="notice notice-error"><p><strong>ACF non détecté.</strong> Active Advanced Custom Fields pour que l'import des champs fonctionne.</p></div>
			<?php endif; ?>

			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" enctype="multipart/form-data">
				<?php wp_nonce_field( 'expertise_json_import_nonce' ); ?>
				<input type="hidden" name="action" value="expertise_json_import"/>

				<h2>Option A — Coller le JSON</h2>
				<textarea name="json_text" rows="18" style="width:100%;font-family:monospace;" placeholder='[{"slug":"mon-service","post_type":"service","fields":{"details_titre":"…"}}]'></textarea>

				<h2>Option B — Uploader un fichier .json</h2>
				<input type="file" name="json_file" accept=".json,application/json"/>

				<p style="margin-top:16px;">
					<label style="display:block;margin-bottom:8px;"><strong>Post type par défaut</strong> (utilisé si absent du JSON) :</label>
					<input type="text" name="default_post_type" value="post" style="width:200px;" placeholder="ex: service, expertise, post…"/>
				</p>

				<p style="margin-top:12px;">
					<label>
						<input type="checkbox" name="dry_run" value="1"/>
						Dry run (simulation — aucune écriture)
					</label>
				</p>

				<?php submit_button( "Lancer l'import" ); ?>
			</form>
		</div>
		<?php
	}

	public function handle_import() {
		if ( ! current_user_can( 'manage_options' ) ) wp_die( 'Accès refusé.' );
		check_admin_referer( 'expertise_json_import_nonce' );

		$dry_run          = ! empty( $_POST['dry_run'] );
		$default_post_type = sanitize_key( $_POST['default_post_type'] ?? 'post' );
		if ( $default_post_type === '' ) $default_post_type = 'post';
		$json = '';

		if ( ! empty( $_POST['json_text'] ) ) {
			$json = wp_unslash( $_POST['json_text'] );
		}
		if ( ! empty( $_FILES['json_file']['tmp_name'] ) && is_uploaded_file( $_FILES['json_file']['tmp_name'] ) ) {
			$json = file_get_contents( $_FILES['json_file']['tmp_name'] );
		}

		$json = trim( (string) $json );
		if ( $json === '' ) {
			$this->finish( 'Aucun JSON fourni.' );
		}

		$data = json_decode( $json, true );
		if ( ! is_array( $data ) ) {
			$this->finish( 'JSON invalide (parse impossible) : ' . json_last_error_msg() );
		}

		$items = $this->normalize( $data, $default_post_type );
		if ( $items === null ) {
			$this->finish( 'Format JSON non reconnu. Attendu : tableau racine ou {"items":[…]}.' );
		}

		$report = [ 'created' => 0, 'updated' => 0, 'skipped' => 0, 'errors' => 0, 'lines' => [] ];

		foreach ( $items as $idx => $item ) {
			$pfx = '#' . ( $idx + 1 ) . ': ';
			try {
				$post_type = sanitize_key( $item['post_type'] ?? 'post' );
				$slug      = sanitize_title( $item['post_name'] ?? '' );

				if ( $slug === '' ) {
					$report['errors']++;
					$report['lines'][] = $pfx . 'ERROR — slug manquant';
					continue;
				}

				$existing = get_page_by_path( $slug, OBJECT, $post_type );
				$post_id  = $existing ? (int) $existing->ID : 0;
				$action   = $post_id ? 'UPDATE' : 'CREATE';

				$postarr = [
					'ID'          => $post_id,
					'post_type'   => $post_type,
					'post_status' => $item['post_status'] ?? 'publish',
					'post_title'  => $item['post_title']  ?? $slug,
					'post_name'   => $slug,
				];
				if ( isset( $item['post_content'] ) ) $postarr['post_content'] = $item['post_content'];
				if ( isset( $item['post_excerpt'] ) ) $postarr['post_excerpt'] = $item['post_excerpt'];

				if ( ! $dry_run ) {
					$result = $post_id ? wp_update_post( $postarr, true ) : wp_insert_post( $postarr, true );
					if ( is_wp_error( $result ) ) throw new Exception( $result->get_error_message() );
					$post_id = (int) $result;
				}

				$acf_count = 0;
				if ( function_exists( 'update_field' ) && ! empty( $item['_acf'] ) ) {
					foreach ( $item['_acf'] as $key => $value ) {
						if ( ! $dry_run ) {
							$this->update_acf_field( $key, $value, $post_id );
						}
					}
					$acf_count = count( $item['_acf'] );
				}

				if ( $action === 'CREATE' ) $report['created']++; else $report['updated']++;
				$report['lines'][] = $pfx . $action . ' OK — slug=' . $slug . ', type=' . $post_type . ', ID=' . $post_id . ', acf_fields=' . $acf_count;

			} catch ( Exception $e ) {
				$report['errors']++;
				$report['lines'][] = $pfx . 'ERROR — ' . $e->getMessage();
			}
		}

		$summary = ( $dry_run ? '[DRY RUN] ' : '' )
			. 'created=' . $report['created']
			. ', updated=' . $report['updated']
			. ', skipped=' . $report['skipped']
			. ', errors=' . $report['errors']
			. "\n" . implode( "\n", $report['lines'] );

		$this->finish( $summary );
	}

	/**
	 * Normalise les deux formats en un tableau d'items avec clés WP + _acf.
	 *
	 * Format A : {"items":[{ "post_type":"…", "post_name":"slug", "champ_acf":"val" }]}
	 * Format B : [{ "slug":"…", "post_type":"…", "fields":{ "champ_acf":"val" } }]
	 */
	private function normalize( array $data, string $default_post_type = 'post' ): ?array {
		$raw = [];

		if ( isset( $data['items'] ) && is_array( $data['items'] ) ) {
			// Format A
			$raw = $data['items'];
		} elseif ( isset( $data[0] ) && is_array( $data[0] ) ) {
			// Format B
			$raw = $data;
		} else {
			return null;
		}

		$items = [];

		foreach ( $raw as $entry ) {
			if ( ! is_array( $entry ) ) {
				continue;
			}

			if ( isset( $entry['slug'] ) && isset( $entry['fields'] ) ) {
				// Format B : {slug, post_type, fields}
				$item              = $entry;
				$item['post_name'] = $entry['slug'];
				$item['post_type'] = $entry['post_type'] ?? $default_post_type;
				$item['_acf']      = is_array( $entry['fields'] ) ? $entry['fields'] : [];
			} else {
				// Format A : tout à plat — on extrait les champs ACF
				$item              = $entry;
				$item['post_type'] = $entry['post_type'] ?? $default_post_type;
				$item['_acf']      = [];
				foreach ( $entry as $k => $v ) {
					if ( ! in_array( $k, self::WP_CORE_KEYS, true ) ) {
						$item['_acf'][ $k ] = $v;
					}
				}
			}

			$items[] = $item;
		}

		return $items;
	}

	/**
	 * Met à jour un champ ACF.
 * Tableaux de tableaux → repeater passé directement à update_field.
 */
private function update_acf_field( string $key, $value, int $post_id ): void {
// Repeater : tableau dont le premier élément est lui-même un tableau
if ( is_array( $value ) && ! empty( $value ) && is_array( reset( $value ) ) ) {
$rows = array_map( function( $row ) {
return array_map( fn( $v ) => $v === 0 ? '' : $v, $row );
}, $value );
update_field( $key, $rows, $post_id );
} else {
$clean = ( $value === 0 ) ? '' : $value;
update_field( $key, $clean, $post_id );
}
}

private function finish( string $message ): void {
set_transient( 'expertise_json_import_last', $message, 60 * 60 );
wp_safe_redirect( admin_url( 'tools.php?page=' . self::MENU_SLUG ) );
exit;
}
}

new Universal_JSON_Importer_ACF();
