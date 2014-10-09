<?php

class Admin_Model_Components_ExchangeModel
{
    var $xmlDocument = "";

    var $date = "";

    var $currency = array();

    function cursBnrXML($url = 'http://www.bnr.ro/nbrfxrates.xml')
    {
       $this->xmlDocument = file_get_contents($url);
       $this->parseXMLDocument();
    }

    function parseXMLDocument()
    {
        $xml = new SimpleXMLElement($this->xmlDocument);

        $this->date=$xml->Header->PublishingDate;

        foreach($xml->Body->Cube->Rate as $line)    
        {                      
            $this->currency[]=array("name"=>$line["currency"], "value"=>$line, "multiplier"=>$line["multiplier"]);
        }
    }

    function getCurs($currency)
    {
       foreach($this->currency as $line)
       {
           if($line["name"]==$currency)
           {
               return $line["value"];
           }
       }

       return "Incorrect currency!";
    }
    
}