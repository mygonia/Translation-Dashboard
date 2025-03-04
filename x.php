<?PHP
//---
require('header.php');
require('tables.php'); 
require('getcats.php');
include_once('functions.php');
//---
?>
</div>
<div align=left>
</div>
<div align=left>
<?PHP
//---
$qids = json_decode( file_get_contents("Tables/mdwiki_to_qid.json"), true) ;
$qids2 = json_decode( file_get_contents("Tables/other_qids.json"), true) ;
//---
$table = "
<table  id='mumu'class='table display'>
<thead>
    <tr>
        <th>#</th>
        <th>title</th>
        <th>qid</th>
        <th>lead word</th>
        <th>all word</th>
        <th>ref</th>
        <th>all ref</th>
        <th>Importance</th>
        <th>enwiki views</th>
    </tr>
</thead>
<tbody>";
//---
foreach( $qids2 as $ta => $q ) {
    //---
    if ($ta != '' && $q != '' ) {
        $qids[$ta] = $q;
    };
}; 
//---
$titles = get_mdwiki_cat_members( 'RTT', $depth=1 );
//---
$no_qid = 0;
$no_word = 0;
$no_allword = 0;
$no_ref = 0;
$no_allref = 0;
$no_Importance = 0;
$no_pv = 0;
$i = 0;
//---
foreach ($titles as $title) {
    $i = $i + 1;
    //---
    $qid = isset($qids[$title]) ? $qids[$title] : "";
    $qid = isset($qid) ? "<a href='https://wikidata.org/wiki/$qid'>$qid</a>" : '';
    //---
    if (!isset($qids[$title])) $no_qid +=1;
    //---
    $word = isset($Words_table[$title]) ? $Words_table[$title] : 0; 
    //---
    $allword = isset($All_Words_table[$title]) ? $All_Words_table[$title] : 0;
    if ($word == 0) $no_word +=1;
    if ($allword == 0) $no_allword +=1;
    //---
    $refs = isset($Lead_Refs_table[$title]) ? $Lead_Refs_table[$title] : 0;
    //---
    $all_refs = isset($All_Refs_table[$title]) ? $All_Refs_table[$title] : 0;
    //---
    if ($refs == 0) $no_ref +=1;
    if ($all_refs == 0) $no_allref +=1;
    $asse = isset($Assessments_table[$title]) ? $Assessments_table[$title] : '';
    if (!isset($Assessments_table[$title])) $no_Importance +=1;
    //---
	$pv = isset($enwiki_pageviews_table[$title]) ? $enwiki_pageviews_table[$title] : 0; 
    if (!isset($enwiki_pageviews_table[$title])) $no_pv +=1;
    //---
    //---
    $table .= "
    <tr>
        <td>$i</td>
        <td><a href='https://mdwiki.org/wiki/$title'>$title</a></td>
        <td>$qid</td>
        <td>$word</td>
        <td>$allword</td>
        <td>$refs</td>
        <td>$all_refs</td>
        <td>$asse</td>
        <td><a href='https://en.wikipedia.org/w/api.php?action=query&prop=pageviews&titles=$title&redirects=1&pvipdays=30'>$pv</a></td>
    </tr>
    ";
}
//---
if ($_REQUEST['test'] != '' ) echo "load " . __file__ . " true.";
//---
$table .= "</table>";
//---
$with_q = $i - $no_qid;
$with_word = $i - $no_word;
$with_allword = $i - $no_allword;
$with_ref = $i - $no_ref;
$with_allref = $i - $no_allref;
$with_Importance = $i - $no_Importance;
$with_pv = $i - $no_pv;
//---
echo "
<table class='table table-striped'>
<tr>
	<th>type</th>
	<th>with</th>
	<th>without</th>
</tr>

<tr>
		<tr><td>qid</td><td>$with_q</td><td>$no_qid</td></tr>
		<tr><td>word</td><td>$with_word</td><td>$no_word</td></tr>
		<tr><td>allword</td><td>$with_allword</td><td>$no_allword</td></tr>
		<tr><td>ref</td><td>$with_ref</td><td>$no_ref</td></tr>
		<tr><td>allref</td><td>$with_allref</td><td>$no_allref</td></tr>
		<tr><td>Importance</td><td>$with_Importance</td><td>$no_Importance</td></tr>
		<tr><td>enwiki views</td><td>$with_pv</td><td>$no_pv</td></tr>
</tr>
<table>";
//---
echo $table;
//---
?>
<script>
$(document).ready( function () {
    $('#mumu').DataTable({
	'lengthMenu': [[100, 150, 200, -1], [100, 150, 200, 'All']]
	});
} );

</script>
<?PHP
//---
print '
</div>
<div>
';
//---
require('foter.php');
//---
?>