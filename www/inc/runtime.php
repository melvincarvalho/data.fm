<?php
/* runtime.php
 * application main runtime
 *
 * $Id$
 */

// base dependencies
require_once('util.lib.php');

// base constants
define('BASE_DOMAIN', 'rdf.me');
define('BASE_URI', 'http://'.BASE_DOMAIN);
define('BASE_HTTP', BASE_URI.'/');
define('X_AGENT', isset($_SERVER['X_AGENT']) ? $_SERVER['X_AGENT'] : 'Mozilla');
define('X_PAD', isset($_SERVER['X_PAD']) ? $_SERVER['X_PAD'] : '(null)');

define('REQUEST_TIME', $_SERVER['REQUEST_TIME']);
if (isHTTPS()) {
$BASE = 'https://'.$_SERVER['SERVER_NAME'].($_SERVER['SERVER_PORT']!='443'?':'.$_SERVER['SERVER_PORT']:'');
} else {
$BASE = 'http://'.$_SERVER['SERVER_NAME'].($_SERVER['SERVER_PORT']!='80'?':'.$_SERVER['SERVER_PORT']:'');
}
$URI = isset($_SERVER['REDIRECT_URL']) ? $_SERVER['REDIRECT_URL'] : $_SERVER['REQUEST_URI'];
define('REQUEST_BASE', $BASE);
define('REQUEST_URL', $URI);
define('REQUEST_URI', $BASE.$URI);

// session startup
session_set_cookie_params(157680000, '/', '.'.BASE_DOMAIN);
session_start();

// application dependencies
require_once('rdf.lib.php');
require_once('app.lib.php');

import_request_variables('gp', 'i_');
if (is_array($_POST))
    extract($_POST, EXTR_PREFIX_ALL, 'p');

if (substr(REQUEST_URL, 0, 5) === '/json') {
    if (isset($g_callback)) {
        header('Content-type: text/javascript');
        echo "$g_callback(";
    } else {
        header('Content-type: application/json');
    }
}

date_default_timezone_set('America/New_York');

// start negotiation: HTTP Accept
$_accept = isset($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : '';
$_accept_lst = array();
foreach (explode(',', $_accept) as $elt) {
    $elt = explode(';', $elt);
    if (count($elt) == 1) {
        $t = trim($elt[0]);
        $q = 'q=1.0';
    } elseif (count($elt) == 2) {
        $t = trim($elt[0]);
        $q = trim($elt[1]);
    } else {
        continue;
    }
    $_accept_lst[$t] = (float)substr($q, 2);
}
asort($_accept_lst, SORT_NUMERIC);
$_accept_lst = array_reverse($_accept_lst);

// start negotiation: HTTP Content-Type
$_content_type = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '';
$_input = '';
foreach (array(
    '/rdf+n3' => 'turtle',
    '/n3' => 'turtle',
    '/turtle' => 'turtle',
    '/rdf+nt' => 'ntriples',
    '/nt' => 'ntriples',
    '/rdf+xml' => 'rdfxml',
    '/rdf' => 'rdfxml',
    '/html' => 'rdfa',
    '/xhtml' => 'rdfa',
    '/rss+xml' => 'rss-tag-soup',
    '/rss' => 'rss-tag-soup',
) as $needle=>$input) {
    if (strstr($_content_type, $needle) !== FALSE) {
        $_input = $input;
        break;
    }
}

$_output = '';
foreach (array_keys($_accept_lst) as $haystack) {
    foreach (array(
        '/rdf+n3' => 'turtle',
        '/n3' => 'turtle',
        '/turtle' => 'turtle',
        '/rdf+nt' => 'ntriples',
        '/nt' => 'ntriples',
        '/rdf+xml' => 'rdfxml-abbrev',
        '/rdf' => 'rdfxml-abbrev',
        '/json' => 'json',
        '/atom+xml' => 'atom',
        '/rss+xml' => 'rss-1.0',
        '/rss' => 'rss-1.0',
        '/dot' => 'dot'
    ) as $needle=>$output) {
        if (strstr($haystack, $needle) !==FALSE) {
            $_output = $output;
            break;
        }
    }
    if (!empty($_output)) break;
}
if (empty($_output))
    $_output = 'turtle';

// TODO: return 415 Unsupported Media Type

TAG(__FILE__, __LINE__, '$Id$');
