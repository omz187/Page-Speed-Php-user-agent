<?php
/**
 * Combines multiple CSS files into a single file and compresses it on-the-fly.
 * Usage:
 * <link rel="stylesheet" type="text/css" href="/css/styles.css.php" />			-
 *
 */
/* Use https://.. instead of //.. for CDNs or else it will not work */
$css_files = array(
    'merged.min.css',
    'styles.css'

);
$buffer = "";
foreach ( $css_files as $file ) {
    $buffer .= file_get_contents( $file );
}
/* Remove comments */
$buffer = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer );
/* Remove space after colons */
$buffer = str_replace( ': ', ':', $buffer );
/* Remove whitespace */
$buffer = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $buffer );
/* Enable GZip encoding. */
ob_start( 'ob_gzhandler' );
/* Enable caching */
header( 'Cache-Control: public' );
/* Expire in one month */
header( 'Expires: ' . gmdate('D, d M Y H:i:s', time() + 2592000) . ' GMT' );
/* Set the correct MIME type, because Apache won't set it for us */
header( 'Content-type: text/css' );
/* Write everything out */
echo $buffer; ?>
