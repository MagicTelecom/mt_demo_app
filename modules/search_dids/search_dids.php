<?php

use MT\DemoApp\modules\search_dids\controllers\SearchDidsController;

$objSearchDids = new SearchDidsController();

$objCountriesList = $objSearchDids->defaultAction();

if (!isset($page) || $page==0 || !isset($limit) || $limit==0)
{
    $page = 1;
    $limit= 10;
}

if (isset($country))
{
    $strCountryName = $objCountriesList['countriesList'][$country]->name;

    $strIso2 = $objCountriesList['countriesList'][$country]->iso2;

    //this is for make the search easier for US
    if ($strIso2=='US')
    {
        $objCountryRegionList = $objSearchDids->didRegionsAction($strIso2);

        if(isset($region))
        {
            $objCountryLocationList = $objSearchDids->searchDidWithFilter($region, $page, $limit);
        }

        require_once 'views/search_dids/united_states_overview.php';

        return;
    }

    $objCountryLocationList = $objSearchDids->searchDidByCountry($strIso2, $page, $limit);

    require_once 'views/search_dids/country_overview.php';
}
elseif (isset($prefix)) {

    if (preg_match("/^[0-9]+$/", $prefix))
    {
        $objCountryLocationList = $objSearchDids->searchDidWithFilter($prefix, $page, $limit );
    }
    else {
       $objCountryLocationList['error'] = 'Prefix should be numbers';
    }

    require_once 'views/search_dids/prefix_overview.php';
}
else
{
    require_once 'views/search_dids/countries_list.php';
}





