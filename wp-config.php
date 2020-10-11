<?php
/**
 * Il file base di configurazione di WordPress.
 *
 * Questo file viene utilizzato, durante l’installazione, dallo script
 * di creazione di wp-config.php. Non è necessario utilizzarlo solo via web
 * puoi copiare questo file in «wp-config.php» e riempire i valori corretti.
 *
 * Questo file definisce le seguenti configurazioni:
 *
 * * Impostazioni MySQL
 * * Chiavi Segrete
 * * Prefisso Tabella
 * * ABSPATH
 *
 * * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Impostazioni MySQL - È possibile ottenere queste informazioni dal proprio fornitore di hosting ** //
/** Il nome del database di WordPress */
define( 'DB_NAME', 'italiasolidale' );

/** Nome utente del database MySQL */
define( 'DB_USER', 'root' );

/** Password del database MySQL */
define( 'DB_PASSWORD', '' );

/** Hostname MySQL  */
define( 'DB_HOST', 'localhost' );

/** Charset del Database da utilizzare nella creazione delle tabelle. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Il tipo di Collazione del Database. Da non modificare se non si ha idea di cosa sia. */
define('DB_COLLATE', '');

/**#@+
 * Chiavi Univoche di Autenticazione e di Salatura.
 *
 * Modificarle con frasi univoche differenti!
 * È possibile generare tali chiavi utilizzando {@link https://api.wordpress.org/secret-key/1.1/salt/ servizio di chiavi-segrete di WordPress.org}
 * È possibile cambiare queste chiavi in qualsiasi momento, per invalidare tuttii cookie esistenti. Ciò forzerà tutti gli utenti ad effettuare nuovamente il login.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '`fdRlPL,[9:W=!^SYGyNyHmM$hb1|NVC7}+f.]Z`hv:KP4dS(6COFi VyvU!~[=(' );
define( 'SECURE_AUTH_KEY',  'if<{t/%Fj1I]I7lv,]-5GhcA%PkX$23WlT{IsP39:]K<[4oXCS|BFQ%HnPXkjW9Q' );
define( 'LOGGED_IN_KEY',    'q?&(l_q{z46[Xo<ueaGePleLS]9x9ufcU97!Sbv,-->O%1|DX][g;l;K!T$XFXdl' );
define( 'NONCE_KEY',        'qHLO@)xOGd`5T9k[gk4e5q$:v):Iw7O[JmlCG*OtIV<<dHJ(>UA{ XUan+&(;f>%' );
define( 'AUTH_SALT',        'kG)x0:Mj7L=`#%R_r21]re^D<yd^#VpHI==i>h!MCZkE@R_:/<c5>hdz4StO_*U:' );
define( 'SECURE_AUTH_SALT', 'pfAo<xI)+*(uPY$-VZLr<L`k1]0+K|_L2[PjTd_@V,Qj8iJS+;L@pdRg#4V%;5Ml' );
define( 'LOGGED_IN_SALT',   '4AHGu*n,eWuEUst^.u7QJ]Wt/B]a~<W.V`tKW.!03LFm:mp+M*HMTFsdL,wOs2rw' );
define( 'NONCE_SALT',       '<p@xGo/]^f]Hh)*&)SO0dvkxOQ:O0?H)Z?0#(K@>wUzYTTc1P^5feXgdj=v` YxB' );

/**#@-*/

/**
 * Prefisso Tabella del Database WordPress.
 *
 * È possibile avere installazioni multiple su di un unico database
 * fornendo a ciascuna installazione un prefisso univoco.
 * Solo numeri, lettere e sottolineatura!
 */
$table_prefix = 'wp_';

/**
 * Per gli sviluppatori: modalità di debug di WordPress.
 *
 * Modificare questa voce a TRUE per abilitare la visualizzazione degli avvisi durante lo sviluppo
 * È fortemente raccomandato agli svilupaptori di temi e plugin di utilizare
 * WP_DEBUG all’interno dei loro ambienti di sviluppo.
 *
 * Per informazioni sulle altre costanti che possono essere utilizzate per il debug,
 * leggi la documentazione
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define('WP_DEBUG', true);
define('ITAS_IS_STAGING', true);
define('ITAS_URL', ( ITAS_IS_STAGING ? 'http://localhost/italia_solidale/' : 'https://www.italiasolidale.org/'));
define('ITAS_INCLUDES', ITAS_URL.'wp-content/themes/italiasolidale/inc/');

/* Finito, interrompere le modifiche! Buon blogging. */

/** Path assoluto alla directory di WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Imposta le variabili di WordPress ed include i file. */
require_once(ABSPATH . 'wp-settings.php');
