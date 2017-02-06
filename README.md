# PHP Countries Data Provider Class
All useful information about every country packaged as convenient little country objects. It includes data from ISO 3166 (countries and states/subdivisions ), ISO 4217 (currency), and E.164 (phone numbers). 

* Initialisation
     <code>
  
           $myObject = new Iso\CountriesDataSets();

      </code>

* Retrieve datas for given country ISO-3166-2 , ISO-3166-3 or numeric code.
     <code>
     
           Example:  For France.
           $myObject->getCountryInfos('fr');
           $myObject->getCountryInfos('fr', true);
           $myObject->getCountryInfos('FR');
           $myObject->getCountryInfos('fra');
           $myObject->getCountryInfos('FRA');
           $myObject->getCountryInfos('FRA', true);
           $myObject->getCountryInfos('250');
           $myObject->getCountryInfos('250', true);
           
      </code>
