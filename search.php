<?php

//find the Showing results range 
if ($_GET['start'] && $_GET['num']) {
    $beg = $_GET['start'] + 1;
    $end = $_GET['start'] + $_GET['num'];
}elseif ($_GET['num']) {
    $beg = 1;
    $end = $_GET['num'];
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Search PiOnline.com</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>

    <body>
    <div id='content'>
        <form action="search.php" method="GET">
            <div id='search'>
                <input 
                    type ='text' 
                    name='q' 
<? 
                     if (isset($_GET['q'])) { echo 'value="' . $_GET['q'] . '"';}
?>
                >
                <input type ='submit' value='search'>
            </div>

            <div id='results'>
                Results per page:
                <select name='num'>
                    <option value='20'>20</option>
                    <option value='30'>30</option>
                    <option value='40'>40</option>
                    <option value='50'>50</option>
                </select>
            </div>
            
        </form>
            
        <div id='sort'>
            SORT BY: <button id='date'>Date</button> | <button id='rel'>Relevance</button>
        </div>

<?
    //get the search query and the number of results to return
    if ($_GET['q'] && $_GET['num']) {
        
        $q = $_GET['q'];
        $n = $_GET['num'];

        //get the sort type (relevance or date), defaults to relevance
        if ($_GET['sort']) {
            $sort = $_GET['sort'];
        }else {
            $sort = 'rel';
        }

        //pagination
        if ($_GET['start']) {
            $start = $_GET['start'];
        }else {
            $start = 0;
        }

        $string = "http://search.pionline.com/search/?q=". 
        $q . "&start=". $start  . "&num=" . $n .  "&sort=" . $sort. "&printXML=true";

        $xml = simplexml_load_file($string);

        $data = array();

        $search_data = $xml->xpath("
            /Doc/Content/SiteSearch/ResultSet
            ");

        foreach ($search_data as $val)
        {
            $data['total_results'] = $val['total-results'];
            $data['has_next'] = $val['has-next'];
            $data['has_previous'] = $val['has-previous'];
            $data['resultsreturned'] = $val['results-returned'];
        }

        $pagin_data = $xml->xpath("
            /Doc/Content/SiteSearch/ResultSet/SearchParams
            ");

        foreach ($pagin_data as $val)
        {
            //number of results to return per page
            $data['number'] = $val['number'];

            //starting position within pagination
            $data['start'] = $val['start'];

            $data['search_string'] = $val['search-string'];
            
        }

?>
        <input type='hidden' name='hStart' value='<?=$data['start']?>'>
        <input type='hidden' name='hNum' value='<?=$data['number']?>'>

        <div id='how_many'>
            Showing results <?=$beg?> - <?=$end?> of <?=$data['total_results']?></div>
<?
            $pag_buttons = ceil($data['total_results'] / $data['number']);

            if ($data['total_results'] > 0) {
?>
        <div id='select_page'> 
            Select Page: <select name='start'>
<?
                for ($i = 1; $i <= $pag_buttons; $i++) {
?>
                    <option value='<?=$i?>'><?=$i?></button>
<?                                        
                }

            }
?>        
            </select>

        </div>

        <div id='results'>

<?
            $results = $xml->xpath("
            /Doc/Content/SearchFilters/ResultSet/Results/
            CompleteResult/EpisodeMetaData
            ");

            foreach ($results as $key => $val) {
                $title = $val->Title;
                $html_url = $val['html-url'];
                $description = $val->Description;
                $author = $val->Author;
?>
                <div class='resultsPart'>
                    <span class='searchNum'><?=$key+1 + $data['start']?>.</span> 
                    <h2><a href='<?=$html_url?>'><?=$title?></a></h2>
                    <p><?=$description?></p>
                </div>

<?
            }   

    }
?>
        </div>

    </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/jquery-ui.min.js"></script>
        <script src="search.js"></script>
    </body>
</html>