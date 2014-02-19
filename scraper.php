<?php
ini_set('memory_limit', '812M');
set_time_limit(0);
require 'scraperwiki/simple_html_dom.php';

$asin_db = scraperWiki::scrape("http://mynexthealth.com/asin.txt");
$asin_array = explode("\n", $asin_db);
shuffle($asin_array);

$dom = new simple_html_dom();
foreach($asin_array as $asin) {

    $html = scraperWiki::scrape("http://www.amazon.com/dp/".$asin."/");
    
    $dom->load($html);



    foreach($dom->find("a") as $obj) {
        
            if(preg_match('#/([\w-]+/)?(dp|gp/product)/(\w+/)?(\w{10})#', $obj->href, $matches)) {
                if(!is_numeric($matches[4][0])) continue;

                $record['asin']  = $matches[4];
                scraperwiki::save(array('asin'), $record); 
        
            }
     }

    //unset($dom);
        
}


?>
