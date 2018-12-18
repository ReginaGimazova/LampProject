<?php
/**
 * Created by PhpStorm.
 * User: regagim
 * Date: 18.12.18
 * Time: 19:13
 */

namespace App\services;

use SimpleXMLElement;

class ParsingFile
{
    public static function parseXmlFile(){
        $xmlStr = file_get_contents("/home/regagim/sites/project/src/resources/books.xml");
        $xml = new SimpleXMLElement($xmlStr);
        $result = $xml->xpath("book/price[.>'600']");
        return $result;
    }
}