<?PHP
//--------------------
require('header.php');
require('leader_tables_new.php');
//--------------------
//==========================
print '
<style>

.table {
    width: 95%;
}
  .table>tbody>tr>td,
  .table>tbody>tr>th,
  .table>thead>tr>td,
  .table>thead>tr>th {
    padding: 6px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd
  }
</style>';
//==========================
print years_start();
print months_start();
//==========================
print '
<section class="container" style="margin-left:20px;margin-left:20px;">';
//==========================
$key_year = 'all';
$get_year = $_REQUEST['year'];
//==========================
print "<h1 class='text-center'>$get_year Leaderboard</h1>";
print '<div class="text-center clearfix">';
//==========================
if ($get_year != '') {
    $key_year = $get_year;
};
//==========================
print '<span class="colsm4" style="width:20%;">';
print ma_Numbers_table($key_year);
print '</span>';
//--------------------
//==========================
print'<span class="colsm4" style="width:45%;">';
print "<h3>Top users by number of translations</h3>";

print'<div style="max-height:300px; overflow: auto; padding: 2px 0 2px 5px; background-color:transparent;vertical-align:top;font-size:100%">';
print Make_users_table($Views_by_users[$key_year],$sql_users_tab[$key_year],$Users_word_table[$key_year]);
print '</div>';

print '</span>';
//==========================
//==========================
print'<span class="colsm4" style="width:35%;">';
print Make_lang_table($sql_Languages_tab[$key_year],$all_views_by_lang[$key_year]);
print '</span>';
//==========================
//--------------------
print '
</div>
';
//==========================
if ($get_year == '') {
    //==========================
    print '<br/>';
    print '<h1 class="text-center">Translations in process</h1>';
    //==========================
    print '<span class="colsm4" style="width:33%;">';
    print Make_Pinding_table();
    print "</span>";
};
//==========================
print "</div>";
print "
</section>
</main>
<!-- Footer 
<footer class='app-footer'>
</footer>
-->
</body>
</html>
</div>"
//--------------------
?>