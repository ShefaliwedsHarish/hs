<?php
global $baseUrl;
$baseUrl = 'https://pokemagic.nl/api/?action=';

/*
 *Function for CURL 
 */
function GetRequest($url = "")
{
    $curlResponse = array();
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL 
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        $curlResponse['msg'] = curl_error($ch);
        $curlResponse['status'] = false;
    }
    curl_close($ch);
    $curl_data = json_decode($response);
    
    if (!empty($curl_data) && $curl_data->status != false) {
        $curlResponse['data'] = $curl_data;
        $curlResponse['status'] = true;
    } else {
       
        $curlResponse['data'] = '';
        $curlResponse['status'] = false;
    }
  
    
   
    return $curlResponse;
}

/*
 *Function for get  Category 
 */

function wc_filter_category()
{
    global $baseUrl;
    $url = $baseUrl . 'category';


    $categories = GetRequest($url)['data'];
    return $categories;
}

/*
 * GET Product by Category
 */

add_shortcode('wc_getcategory', 'wc_show_category');
function wc_show_category()
{
    if (isset($_GET['slug'])) {
        $page = 1;
        $categorie = $_GET['slug'];
        if (isset($_GET['pagen'])) {
            $page = $_GET['pagen'];
        }

        global $baseUrl;
        $url = $baseUrl . "category-products&slug=" . $categorie . "&pagen=" . $page;
        // echo $url; 
        // die(); 

        $product_data = GetRequest($url)['data'];
       

        get_template_part('wc-templates/shop', 'product', $product_data);
        return ob_get_clean();

    }



}


function wc_home_product()
{
   
    global $baseUrl;
    $url = $baseUrl . "category-products&slug=fusion-strike";

    $product_data= GetRequest($url)['data'];
    return $product_data;
}

function wc_slug()
{
    global $baseUrl;
    $search=$_POST['search'];
    $url = $baseUrl . "get_single&id=".$search; 
    $product_data = GetRequest($url)['data'];
    get_template_part('wc-templates/shop', 'product', $product_data);
    return ob_get_clean();
}










?>