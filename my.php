<?PHP
//---
require('header.php');
echo '<script src="sorttable.js"></script>';
require('tables.php');
include_once('functions.php');
require('langcode.php');
//---
$test = $_REQUEST['test'];
// $mainuser = rawurldecode( str_replace ( '_' , ' ' , $username ) );
//---
//---
//---
$views_sql = array();
//---
// views (target, countall, count2021, count2022, count2023, lang)
$quaa_view = "select p.target,v.countall
from pages p,views v
where p.user = '$username'
and p.target = v.target
;";
$views_query = quary2($quaa_view);
//---
$user_total_views = 0;
//---
foreach ( $views_query AS $Key => $table ) {
    $countall = $table['countall'];
    $targ = $table['target'];
    $views_sql[$targ] = $countall;
    //---
    $user_total_views = $user_total_views + $countall;
    //---
};
//---
//---
function make_td($tabg,$nnnn) {
    // ------------------
    global $code_to_lang, $Words_table, $views_sql;
    // ------------------
    $date     = $tabg['date'];
    //---
    //return $date . '<br>';
    //---
    $llang    = $tabg['lang'];
    $md_title = $tabg['title'];
    $cat      = $tabg['cat'];
    $word     = $tabg['word'];
    $targe    = $tabg['target'];
    $pupdate  = isset($tabg['pupdate']) ? $tabg['pupdate'] : '';
    // ------------------
    $views_number = isset($views_sql[$targe]) ? $views_sql[$targe] : '?';
    // ------------------
    $lang2 = isset($code_to_lang[$llang]) ? $code_to_lang[$llang] : $llang;
    //---
    $ccat = make_cat_url( $cat );
    //---
    $worde = isset($word) ? $word : $Words_table[$md_title];
    //---
    $nana = make_mdwiki_title( $md_title );
    //---
    $targe33 = make_target_url( $targe , $llang );
    //---
    $view = make_view_by_number($targe , $views_number, $llang) ;
    //---
    $tran_type = isset($tabg['translate_type']) ? $tabg['translate_type'] : '';
    if ($tran_type == 'all') { 
        $tran_type = 'Whole article';
    };
    //---
    //---
    $laly = "
        <tr>
            <td>$nnnn</td>
            <td><a target='' href='langs.php?langcode=$llang'>$lang2</a></td>
            <td>$nana</td>
            <!-- <td>$date</td> -->
            <td>$ccat</td>
            <td>$worde</td>
            <td>$tran_type</td>
            <td>$targe33</td>
            <td>$pupdate</td>
            <td>$view</td>
            <td><a target='' href='../fixwikirefs.php?title=$targe&lang=$llang'>fix</a></td>
        </tr>";
    //---
    return $laly;
};
//---
$quaa = "select * from pages where user = '$username'";
$sql_result = quary2($quaa);
//---
//---
$dd_Pending = array();
$dd = array();
foreach ( $sql_result AS $tait => $tabg ) {
        //---
        $kry = str_replace('-','',$tabg['pupdate']) . ':' . $tabg['lang'] . ':' . $tabg['title'] ;
        //---
        if ( $tabg['target'] != '' ) {
            $dd[$kry] = $tabg;
        } else {
            $dd_Pending[$kry] = $tabg;
        };
        //---
    };
//---
//---
krsort($dd);
// print( count($dd) );
//---
$man = make_mdwiki_user_url($username);
//---
echo "
	<div style='margin-right:25px;margin-left:25px;boxSizing:border-box;' align=left>
	<h2 class='text-center'>$man</h2>
	<div class='text-center clearfix leaderboard'>
";
//---
$tab_start = '
    <div class="table-responsive">          
    <table class="table table-striped sortable alignleft">
';
$tab_end = '
        </table>
    </div>';
//---
$table_leg = $tab_start . '
        <tr>
            <th onclick="sortTable(0)">#</th>
            <th onclick="sortTable(1)">Language</th>
            <th onclick="sortTable(2)">Title</th>
            <!--<th onclick="sortTable(3)">Start date</th> -->
            <th onclick="sortTable(4)">Category</th>
            <th onclick="sortTable(5)">Words</th>
            <th onclick="sortTable(6)">type</th>
            <th onclick="sortTable(7)">Translated</th>
';
//---
//---
$vas = 'Pageviews';
if ( $user_total_views != 0) { $vas .= "<br>($user_total_views)"; };
//---
$sato = $table_leg . "
            <th onclick='sortTable(8)'>Completion date</th><th onclick='sortTable(9)'>$vas</th>
            <th onclick='sortTable(9)'>Fix reference</th>";
//---
if ($test != '') $sato .= '
            <th onclick="sortTable(10)">User</th>';
//---
$sato .= '
        </tr>';
//---
$noo = 0;
foreach ( $dd AS $tat => $tabe ) {
    //---
    $noo = $noo + 1;
    $sato .= make_td($tabe,$noo);
    //---
};
//---
$sato .= $tab_end;
print $sato;
print "
</div>";
//---
print '
<div class="text-center clearfix leaderboard" >
    <h2 class="text-center">Translations in process</h2>
';
//---
if ($username == "Mr. Ibrahem") {
    $Pending_a = '<th onclick="sortTable(9)">Remove</th>';
};
//---
echo $tab_start . '
        <tr>
            <th onclick="sortTable(0)">#</th>
            <th onclick="sortTable(1)">Language</th>
            <th onclick="sortTable(2)">Title</th>
            <th onclick="sortTable(3)">Category</th>
            <th onclick="sortTable(4)">Words</th>
            <th onclick="sortTable(5)">type</th>
            <th onclick="sortTable(6)">Translated</th>
            <th onclick="sortTable(7)">Start date</th>
            <th onclick="sortTable(8)">Completion</th>
            ' . $Pending_a . '
        </tr>'; 
//---
$dff = 0;
foreach ( $dd_Pending AS $title=> $kk ) {
    //---
    $dff      = $dff + 1;
    //---
    $lange    = $kk['lang'];
    $lang2    = isset($code_to_lang[$lange]) ? $code_to_lang[$lange] : $lange;
    //---
    // $tran_type = $kk['translate_type'];
    $tran_type = isset($kk['translate_type']) ? $kk['translate_type'] : '';
    if ($tran_type == 'all') { 
        $tran_type = 'Whole article';
    };
    //---
    $md_title = $kk['title'];
    $word     = $kk['word'];
    $lang2    = isset($lang2) ? $lang2 : $lange;
    //---
    $worde = isset($word) ? $word : $Words_table[$md_title];
    $nana = make_mdwiki_title( $md_title );
    print '
        <tr>
            <td>' . $dff  .'</td>
            <td><a target="" href="langs.php?langcode=' . $lange . '">' . $lang2 . '</a>' . '</td>
            <td>' . $nana .'</td>
            <td>' . make_cat_url( $kk['cat'] ) .'</td>
            <td>' . $worde . '</td>
            <td>' . $tran_type . '</td>
            <td>Pending</td>
            <td>' . $kk['date'] .'</td>
';
    //---
    $md_title2 = rawurlencode(str_replace ( ' ' , '_' , $md_title ) );
    $urle = "//$lange.wikipedia.org/wiki/Special:ContentTranslation?page=User%3AMr._Ibrahem%2F" . $md_title2 . "&from=en&to=" . $lange;
    print "<td><a href='$urle'>Completion</a></td>"; 
    //---
    $qua = rawurlencode( "delete from pages where user = '$username' and title = '$md_title' and lang = '$lange';" );
    $urle = "sql.php?code=$qua&pass=yemen&raw=66";
    //---
    if ($username == "Mr. Ibrahem") {
        print "<td><a href='$urle' target='_blank'>Remove</a></td>"; 
    };
    //---
    print '</tr>';
    //---
};
//---
print $tab_end . '
</div>
';
//---
require('foter.php');
//---

?>