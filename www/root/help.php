<?php
/* help.php
 * service help page
 *
 * $Id$
 */

require_once('runtime.php');

defined('HEADER') || include_once('header.php');
$open = substr($_SERVER['SERVER_ADDR'], 0, 3) == '18.';
?>
<?php if ($open) { ?>
<div id="welcome" class="box">
<strong>Welcome!</strong> This <a target="_blank" href="http://www.w3.org/DesignIssues/ReadWriteLinkedData.html">Read/Write</a> <a target="_blank" href="http://www.w3.org/DesignIssues/LinkedData.html">Linked Data</a> service is free (and open-source) for educational and personal use.
</div>
<?php } ?>

<p class="cleft left">This web data platform supports several generations of standards and recommendations:</p>
<ul class="cleft left">
<li>Web 1 and 2: DAV, AJAX, <a target="_blank" href="http://en.wikipedia.org/wiki/JSONP">JSONP</a>, <a target="_blank" href="http://enable-cors.org/">CORS</a></li>
<li>Read/Write Linked Data, RDF/XML/JSON content negotiation, <a target="_blank" href="http://www.w3.org/TR/sparql11-query/">SPARQL 1.1</a>, and <a target="_blank" href="http://www.w3.org/wiki/WebID">WebID</a></li>
</ul>

<p class="cleft left">All endpoints interpret the HTTP request URI as the base URI for RDF operations and the default-graph URI for SPARQL operations.</p>
<p class="cleft left">Specify the media type of your request data with a <code>Content-Type</code> HTTP header.<br />
Specify your response type preference with an <code>Accept</code> HTTP header.</p>

<div id="http-methods" class="cleft left" style="margin: 0.5em; padding: 0.5em;">
<h4>Request methods:</h4>
<ul>
<li>Read: GET, HEAD, OPTIONS</li>
<li>Write: PUT, MKCOL, DELETE</li>
<li>Append: POST</li>
<li>Update:
    <ul>
        <li>JSON PATCH (application/json)</li>
        <li>SPARQL POST (*/sparql-query)</li>
    </ul>
</li>
</ul>
</div>

<div id="output-types" class="left" style="margin: 0.5em; padding: 0.5em;">
<h4>Response types:</h4>
<ul>
<li>Web (index.html, style.css, script.js)</li>
<li>JSON (Accept */json)</li>
<li>JSON-P (GET ?callback=)</li>
<li>SPARQL JSON (GET/POST ?query=)</li>
<li>RSS (Accept */rss+xml)</li>
<li>Atom (Accept */atom+xml)</li>
</ul>
</div>

<div id="media-types" class="left" style="margin: 0.5em; padding: 0.5em;">
<h4>RDF media types:</h4>
<ul>
<li>JSON: application/json</li>
<li>NTriples: */rdf+nt, */nt</li>
<li>RDF/XML: */rdf+xml</li>
<li>RDFa: */html, */xhtml</li>
<li>Turtle: */turtle, */rdf+n3, */n3</li>
</ul>
(defaults to Turtle)
</div>


<div class="clear left">
<dl>
<dt>*/type</dt><dd>refers to a media type, specified in HTTP header (Accept or Content-Type)</dd>
<dt>name.ext</dt><dd>refers to a filename, specified by HTTP request URI</dd>
<dt>?k=v</dt><dd>refers to a query string parameter 'k' with value 'v': passed in URL via GET or application/x-www-form-urlencoded via POST</dd>
</dl>
<p>Some query string options and response (HTTP Accept) media types are complementary.</p>
</div>

<?php if ($open) { ?>
<p class="clear left">All uses of this service must comply with the <a target="_blank" href="http://ist.mit.edu/services/athena/olh/rules#mitnet">MITnet rules of use</a>.</p>
<?php }
TAG(__FILE__, __LINE__, '$Id$');
defined('FOOTER') || include_once('footer.php');
