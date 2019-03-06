<?php
$header = $nav = $article = $aside = $footer = $search = '';
$get_title = !filter_has_var(INPUT_GET, 'title') ? '' : get_uri(basename($request_uri), 'title');
$get_categ = !filter_has_var(INPUT_GET, 'categ') ? '' : !$get_title ? get_uri(basename($request_uri), 'categ') : get_uri(basename(dirname($request_uri)), 'categ');
$get_page = !filter_has_var(INPUT_GET, 'page') ? '' : get_uri(basename($request_uri), 'page');
$get_dl = !filter_has_var(INPUT_GET, 'dl') ? '' : basename(filter_input(INPUT_GET, 'dl', FILTER_SANITIZE_ENCODED));
$pages = !filter_has_var(INPUT_GET, 'pages') ? 1 : (int)filter_input(INPUT_GET, 'pages', FILTER_SANITIZE_NUMBER_INT);
$query = !filter_has_var(INPUT_GET, 'query') ? '' : trim(mb_convert_kana(filter_input(INPUT_GET, 'query', FILTER_SANITIZE_SPECIAL_CHARS), 'rnsK', $encoding));
$comment_pages = !filter_has_var(INPUT_GET, 'comments') ? 1 : (int)filter_input(INPUT_GET, 'comments', FILTER_SANITIZE_NUMBER_INT);
$breadcrumb = '<li class=breadcrumb-item><a href="'. $url. '">'. $home. '</a></li>';
$dl = is_dir($downloads_dir = 'downloads') ? true : false;
$form = 'includes/form.php';
$title_name = d($get_title);
$categ_name = d($get_categ);
$page_name = d($get_page);
$this_year = date('Y');

if ($contents = get_dirs('contents', false))
{
	foreach($contents as $categ)
		$nav .= '<li><a'. ($categ_name === $categ ? ' class="nav-item nav-link active"' : ' class="nav-item nav-link"'). ' href="'. $url. r($categ). '/">'. h($categ). '</a></li>'. $n;
}
if ($get_page && !is_numeric($get_page))
	include 'page.php';

elseif ($get_categ && !$get_title)
	include 'categ.php';

elseif ($get_categ && $get_title)
	include 'article.php';

elseif (!$get_categ && !$get_title)
{
	if ($use_search && $query)
		include 'search.php';
	else
		include 'home.php';
}
else
	not_found();

$article .= '<div class="clearfix mb-5"></div>';

if ($use_search)
	$search .=
	'<form method=get action="'. $url. '">'. $n.
	'<input placeholder="Search..." type=search id=search name=query required class=form-control tabindex=1 accesskey=i>'. $n.
	'</form>'. $n;

if (is_file($boxtpl = $tpl_dir. 'sideboxes.php'))
	include $boxtpl;
else
	include 'sideboxes.php';

$footer .=
'<small><span class="text-muted text-center align-text-bottom">&copy; '. $this_year. ' '. $site_name. '. <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 328.78 48.312" width="7em" id="kinaga" data-toggle="modal" data-target="#about-kinaga" fill="currentColor"><g transform="translate(-404.18 -719.63)"><title>Powered by Kinaga.</title><path d="m652.34 719.63c-0.816 3.024-1.8525 6.3478-2.8125 8.8438-1.152-0.672-2.7028-1.318-4.7188-1.75l-0.4375 0.34375c1.68 1.968 3.568 5.0308 4 7.7188 3.312 2.496 6.484-1.967 2.5-5.375 2.256-1.68 4.657-3.8668 6.625-6.2188 1.056 0.096 1.6662-0.299 1.9062-0.875l-7.0625-2.6875zm51.062 0.15625c-0.55878 0.0007-1.1172 0.007-1.7188 0.0312l-0.15625 0.59375c5.28 2.352 9.3535 5.8568 10.938 7.9688 5.3475 2.1855 8.2598-8.6156-9.0625-8.5938zm-20.906 1-2.5938 2.875h-15.562l0.4375 1.4062h15.594v13.281h-7.9688l-6.2812-2.4062v22.531c0 4.128 1.345 5.0625 6.625 5.0625h5.4688c8.736 0 11.125-0.94151 11.125-3.4375 0-0.0735 0.004-0.14918 0-0.21875 8.3825-4.3208 12.74-11.273 14.812-18.75 1.056-0.096 1.4452-0.27 1.7812-0.75l-4.875-4.1562-2.7812 2.8438h-9.9062l0.4375 1.4062h9.75c-1.3527 6.8508-4.3343 13.575-9.625 18.312-0.2969-0.34589-0.764-0.63525-1.5312-0.9375l-0.15625-7.9688h-0.53125c-1.056 3.648-1.9095 6.5065-2.4375 7.5625-0.336 0.624-0.57575 0.7645-1.3438 0.8125-0.72 0.048-2.253 0.0625-4.125 0.0625h-5c-1.68 0-2.0312-0.24425-2.0312-1.1562v-17.469h8.5938v4.0938h0.96875c1.824 0 4.6082-1.0558 4.6562-1.3438v-16.469c0.96-0.24 1.6182-0.64725 1.9062-1.0312l-5.4062-4.1562zm-113.84 2.1875v14.875c-2.3125-2.6562-5.0313-4-8.1875-4-2.9219 0.00002-5.3906 1.0156-7.375 3.0312-2.2969 2.3594-3.4375 5.5469-3.4375 9.5625 0 4.0938 1.1875 7.3281 3.5625 9.6875 1.9688 2.0156 4.3906 3.0312 7.25 3.0312 3.4375 0 6.2812-1.625 8.5312-4.875v4.1562h3.75v-35.469h-4.0938zm19.938 0v35.625h3.2188l0.59375-3.5625c2.3594 2.7344 5.1406 4.125 8.375 4.125 2.9062 0 5.3906-1.0156 7.4062-3.0312 2.3437-2.3281 3.5-5.5 3.5-9.5312-0.00003-4.125-1.1563-7.375-3.5-9.7188-2.0156-2.0156-4.4688-3.0312-7.3125-3.0312-3.3438 0.00002-6.0625 1.5469-8.1875 4.5938v-15.469h-4.0938zm-184.41 1.1875v34.281h4.2188v-14.031h5.5c8.9062 0.00002 13.375-3.4687 13.375-10.406-0.00003-6.5625-4.3594-9.8437-13.094-9.8438h-10zm253.62 1.2812c-1.776 4.368-4.803 10.08-7.875 14.688-2.448 0.096-4.502 0.125-5.75 0.125l1.5312 5.5c0.576-0.096 1.1182-0.4865 1.4062-1.0625 1.728-0.48 3.3558-0.9575 4.8438-1.4375v4.25l-4.5625-1.125c-0.48 5.184-1.7285 10.631-3.3125 14.375l0.71875 0.40625c3.072-2.88 5.4762-7.2123 7.1562-12.156v15.688h0.90625c2.592 0 4.2188-1.1015 4.2188-1.4375v-21.531l2.25-0.78125c0.288 1.152 0.48325 2.3022 0.53125 3.4062 4.224 3.84 9.126-4.661-2.25-9.125l-0.46875 0.25c0.624 1.2 1.3012 2.6515 1.7812 4.1875-2.304 0.144-4.6235 0.2165-6.6875 0.3125 4.08-3.504 7.8668-7.6133 10.219-10.781 1.104 0.144 1.7288-0.19075 1.9688-0.71875l-6.625-3.0312zm-249.41 2.125h5.4062c6.0312 0.00003 9.0625 2.1406 9.0625 6.4688-0.00003 4.6719-3.25 7.0313-9.75 7.0312h-4.7188v-13.5zm301.09 0.46875-2.5312 2.875h-11.438l0.4375 1.3438h11.469v25.094c0 0.72-0.22975 1.0625-1.0938 1.0625-1.152 0-6.9375-0.34375-6.9375-0.34375v0.6875c2.688 0.384 3.886 1.0422 4.75 1.9062 0.816 0.864 1.1205 2.2072 1.3125 4.0312 6.768-0.576 7.7188-2.8163 7.7188-6.6562v-22.281c2.448 13.392 7.4495 19.82 14.938 24.812 0.672-2.736 2.3522-4.7532 4.6562-5.2812l0.1875-0.53125c-5.808-2.016-11.795-5.3638-15.875-11.844 4.416-2.112 8.822-5.0565 11.75-7.3125 1.104 0.24 1.587 0.0113 1.875-0.46875l-6.4375-4.2812c-1.584 2.976-4.8365 7.6545-7.8125 11.062-1.392-2.448-2.5132-5.2963-3.2812-8.6562v-0.125c0.912-0.192 1.5078-0.58475 1.8438-0.96875l-5.5312-4.125zm-211.66 5.7188c-3.2031 0.00002-5.8594 1.0782-8 3.2188-2.4062 2.4063-3.625 5.6094-3.625 9.625 0 3.7812 1.1719 6.8438 3.4688 9.1562 2.2812 2.2656 5.1719 3.4062 8.7188 3.4062 4.6875 0 8.1718-1.9219 10.438-5.7188l-2.6875-1.7812c-1.7813 2.8438-4.2032 4.2812-7.25 4.2812-2.3125 0-4.2813-0.8125-5.9062-2.4375-1.5938-1.5937-2.4531-3.7656-2.5938-6.5312h18.438v-0.96875c-0.00003-3.8594-1.125-6.9375-3.4062-9.25-2.0313-1.9844-4.5781-3-7.5938-3zm39.094 0c-3.2031 0.00002-5.8594 1.0782-8 3.2188-2.4062 2.4063-3.625 5.6094-3.625 9.625 0 3.7812 1.1719 6.8438 3.4688 9.1562 2.2812 2.2656 5.1719 3.4062 8.7188 3.4062 4.6875 0 8.1718-1.9219 10.438-5.7188l-2.6875-1.7812c-1.7813 2.8438-4.2032 4.2812-7.25 4.2812-2.3125 0-4.2813-0.8125-5.9062-2.4375-1.5938-1.5937-2.4531-3.7656-2.5938-6.5312h18.438v-0.96875c-0.00003-3.8594-1.125-6.9375-3.4062-9.25-2.0313-1.9844-4.5781-3-7.5938-3zm-97.688 0.0937c-3.3906 0.00002-6.2031 1.1406-8.4688 3.4062-2.375 2.375-3.5625 5.4688-3.5625 9.25 0 3.8594 1.1562 6.9375 3.5 9.2812 2.2344 2.2344 5.0781 3.375 8.5312 3.375s6.3437-1.1406 8.625-3.4062c2.3281-2.3437 3.4687-5.3906 3.4688-9.125-0.00003-3.875-1.1875-7-3.5625-9.375-2.3125-2.2656-5.1563-3.4062-8.5312-3.4062zm84.688 0c-3.375 0.00002-5.9531 2.5938-7.7188 7.7812h-0.0937l0.1875-7.0938h-3.875v23.906h4.125v-12.094c0-1.6562 0.74999-3.5625 2.25-5.75 1.2031-1.7344 2.7187-2.625 4.5625-2.625 0.42186 0.00002 0.90624 0.0781 1.4375 0.1875l0.71875-4.0938c-0.51565-0.14063-1.0469-0.21873-1.5938-0.21875zm-72.781 0.6875 8.3125 24.344h2.875l4.9062-14.344c0.67186-2 1.1719-3.7656 1.5312-5.2812h0.15625c0.48436 2.0938 0.96873 3.8594 1.4688 5.2812l5.0312 14.344h2.9062l8.2812-24.344h-4.1562l-4 13.188c-0.46878 1.5313-0.95315 3.375-1.4688 5.5312h-0.15625c-0.6094-2.4531-1.1406-4.2969-1.5938-5.5312l-4.5-13.188h-3.6562l-4.3125 13.188c-0.59376 1.8281-1.125 3.6719-1.5938 5.5312h-0.125c-0.78126-2.8906-1.3125-4.7344-1.5625-5.5312l-4.0312-13.188h-4.3125zm160.38 0 9.875 22.312-1.5312 3.8438c-0.90625 2.3281-2.6719 3.5-5.2812 3.5h-0.78125l1.0312 3.75h0.53125c3.6406-0.00001 6.2031-1.7969 7.6875-5.375l11.594-28.031h-4.4375l-5 13.438c-0.56251 1.4531-1.1563 3.1563-1.7812 5.0938h-0.15625c-0.39064-1.2187-0.98438-2.9219-1.8125-5.0938l-5.2812-13.438h-4.6562zm-113.78 2.3438c1.75 0.00003 3.2812 0.65627 4.5625 1.9375 1.2969 1.25 2.0468 2.9531 2.2812 5.125h-13.969c0.29687-1.7969 0.95312-3.2969 1.9375-4.4688 1.4375-1.7344 3.1562-2.5937 5.1875-2.5938zm39.094 0c1.75 0.00003 3.2812 0.65627 4.5625 1.9375 1.2969 1.25 2.0468 2.9531 2.2812 5.125h-13.969c0.29687-1.7969 0.95312-3.2969 1.9375-4.4688 1.4375-1.7344 3.1562-2.5937 5.1875-2.5938zm-97.594 0.15625c1.9844 0.00002 3.7187 0.71877 5.1562 2.1562 1.7656 1.8125 2.625 4.2031 2.625 7.1875-0.00002 3.1719-0.8594 5.6094-2.5938 7.3438-1.3906 1.4375-3.125 2.1562-5.1875 2.1562-2.0156 0-3.7188-0.6875-5.125-2.0938-1.7344-1.7344-2.5938-4.1562-2.5938-7.25 0-3.1406 0.89062-5.5781 2.6562-7.3438 1.3906-1.4375 3.0625-2.1562 5.0625-2.1562zm121.97 0.0937c1.6406 0.00002 3.125 0.50002 4.5 1.5 1.9531 1.4688 2.9375 2.9844 2.9375 4.5625v5.9375c-0.00003 0.84375-0.4844 1.9219-1.4375 3.2188-1.6719 2.3281-3.6875 3.5-6.0625 3.5-2.0313 0-3.7344-0.85937-5.0938-2.5625-1.4063-1.7969-2.0938-4.125-2.0938-6.9688 0-3.1562 0.85937-5.5781 2.5625-7.2812 1.2812-1.2812 2.8437-1.9062 4.6875-1.9062zm38.969 0.0312c2 0.00002 3.7031 0.85939 5.0938 2.5938 1.4062 1.7969 2.0937 4.125 2.0938 6.9375-0.00003 3.1094-0.8594 5.5313-2.5625 7.2812-1.2813 1.2812-2.8438 1.9062-4.6875 1.9062-1.5781 0-3.0313-0.48437-4.4062-1.4688-2.0156-1.4375-3.0312-3.0781-3.0312-4.9062v-5.5625c0-1.3437 0.78124-2.8125 2.3438-4.375 1.6094-1.6094 3.3281-2.4062 5.1562-2.4062zm57.625 9.0625-0.53125 0.1875c1.104 2.736 2.2355 6.5195 2.1875 9.6875 4.08 4.176 9.2877-4.355-1.6562-9.875z"/></g></svg></span></small><div class="modal fade" id=about-kinaga aria-hidden=true><div class="modal-dialog modal-dialog-centered"><div class=modal-content><div class=modal-header><a class="h5 modal-title" href="https://github.com/KinagaCMS/">KinagaCMS</a><button type=button class=close data-dismiss=modal><span aria-hidden=true>&times;</span></button></div><div class="modal-body text-black-50"><img src="'. $url. 'images/icon.php" alt=k>Copyright &copy; '. $this_year.' KinagaCMS.</div></div></div></div>'. $n;
if ($use_benchmark === true)
	$footer .= sprintf($benchmark_results, round(microtime(true) - $time_start, 6), size_unit(memory_get_usage() - $base_mem));
$header .=
'<meta name=application-name content=kinaga>'. $n.
'<link rel=alternate type="application/atom+xml" href="'. $url. 'atom.php">'. $n.
(!is_file('favicon.ico') ? '<link href="'. $url. 'images/icon.php" rel=icon type="image/svg+xml" sizes=any>' : '<link rel="shortcut icon" href="'. $url. 'favicon.ico">'). $n.
'<style>#kinaga:hover{cursor:pointer;fill-opacity:.6}</style>'. $n;
