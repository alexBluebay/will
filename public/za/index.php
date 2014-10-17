<?php 
set_time_limit(0);

function extract_email_address ($string) {
   $emails = array();
   $string = str_replace("\r\n",' ',$string);
   $string = str_replace("\n",' ',$string);

   foreach(preg_split('/ /', $string) as $token) {
        $email = filter_var($token, FILTER_VALIDATE_EMAIL);
        if ($email !== false) { 
            $emails[] = $email;
        }
    }
    return $emails['0'];
}

/* function toAscii($str, $replace=array(), $delimiter='-') {
 if( !empty($replace) ) {
  $str = str_replace((array)$replace, ' ', $str);
 }
 $clean = str_replace($nochartitle, "-", $str);
 $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
 $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
 $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
 $clean = ucfirst(strtolower(trim($clean, '-')));

 return $clean;
}
function xss_cleaner($input_str) {
    $return_str = str_replace( array('<','>',"'",'"',')','('), array('&lt;','&gt;','&apos;','&#x22;','&#x29;','&#x28;'), $input_str );
    $return_str = str_ireplace( '%3Cscript', '', $return_str );
    return $return_str;
}
//
function isEmail($email){//check that the email is correct
	$pattern="/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/";
	if(preg_match($pattern, $email) > 0) return true;
	else return false;
}
*/

include_once("simple_html_dom.php");






/*
 * 
 * 
 * 
 * 

$deluat['Autos']['xxxxx']="xxxxx";
$deluat['Autos']['xxxxx']="xxxxx";
$deluat['Autos']['xxxxx']="xxxxx";
$deluat['Autos']['xxxxx']="xxxxx";
$deluat['Autos']['xxxxx']="xxxxx";
$deluat['Autos']['xxxxx']="xxxxx";

*/


//$categoriex
//$subcategoriex
//echo "cat : $categoriex -->> subcat : $subcategoriex -->> $munca<br>";

		$html = file_get_html('http://www.emag.ro/imprimante-laser/sort-priceasc/p23/c');

		
//	foreach($html->find('*[@class="link_imagine"]') as $element) {
//            echo $element->href . '<br>';
//        }
//            $i='0';
//            foreach($html->find('div[@class="produs-listing-price-box"]') as $f){
//                echo $f->find('span[@class="money-int"]', 0).'<br>';
//                echo $f->find('*[@class="link_imagine"]', 0)->href.'<hr>';
//            }
        
            
            
            
            
                
    echo '<table border="1"><tr><td width="30%">Titlu</td><td>Pret</td><td>1 An</td><td>2 Ani</td></tr>';
    foreach($html->find('*[@class="link_imagine"]') as $element) {
        
        
            $descPage = file_get_html('http://www.emag.ro'.$element->href);
            
            $realPrice = $descPage->find('span[@itemprop="price"]', 0)->content;
            
            $title = $descPage->find('div[@id="offer-title"]', 0)->plaintext;
            
            $oneYear = $descPage->find('label[@class="label_extra_warranty"]', 0);
            
            $twoYears = $descPage->find('label[@class="label_extra_warranty"]', 1);
            
            
            echo '<tr>'
            . '<td>'.trim($title).'</td><td>'.$realPrice.'</td><td>'.$oneYear.'</td><td>'.$twoYears.'</td>'
            . '</tr>';
            
        }
                
        echo '</table>';       
                
                

?>
