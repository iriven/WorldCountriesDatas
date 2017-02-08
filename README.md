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
* Get country ISO-3166-2 code for given ISO-3166-3 or numeric code
<code>

         Example:  For France
         $myObject->getCountryAlpha2Code('fra');
         $myObject->getCountryAlpha2Code('FRA');
         $myObject->getCountryAlpha2Code('250');   
</code>
* Get country ISO-3166-3 code for given ISO-3166-2 or numeric code
<code>

         Example:  For France
         $myObject->getCountryAlpha3Code('fr');
         $myObject->getCountryAlpha3Code('FR');
         $myObject->getCountryAlpha3Code('250');     
</code>
* Get country numeric code for given ISO-3166-2 or ISO-3166-3 code
<code>

         Example:  For France
         $myObject->getCountryNumericCode('fra');
         $myObject->getCountryNumericCode('FRA');
         $myObject->getCountryNumericCode('fr');
         $myObject->getCountryNumericCode('FR');   
</code>
* Get country Currency Code from given alpha-2, alpha-3 or numeric code
<code>

      	Example:  For France
      	$myObject->getCountryCurrencyCode('fra');
      	$myObject->getCountryCurrencyCode('fr');
      	$myObject->getCountryCurrencyCode('250');        
</code>
* Get country Currency Name from given alpha-2, alpha-3 or numeric code
<code>

          Example:  For France
          $myObject->getCountryCurrencyName('fra');
          $myObject->getCountryCurrencyName('fr');
          $myObject->getCountryCurrencyName('250');       
</code>
* Get country Phone Code (ISD) from given alpha-2, alpha-3 or numeric code
<code>

          Example:  For France
          $myObject->getCountryPhoneCode('fra');
          $myObject->getCountryPhoneCode('fr');
          $myObject->getCountryPhoneCode('250');          
</code>
* Get country Name from given alpha-2, alpha-3 or numeric code
<code>

          Example:  For France
          $myObject->getCountryName('fra');
          $myObject->getCountryName('fr');
          $myObject->getCountryName('250');
</code>
* Get Country Capital name from given alpha-2, alpha-3 or numeric code
<code>

          Example:  For France
          $myObject->getCountryCapitalName('fra');
          $myObject->getCountryCapitalName('fr');
          $myObject->getCountryCapitalName('250');     
</code>
* Get the Top Level Domain(TLD) of a Country  from given alpha-2, alpha-3 or numeric code
<code>

          Example:  For France
          $myObject->getCountryDomain('fra');
          $myObject->getCountryDomain('fr');
          $myObject->getCountryDomain('250');    
</code>
* Get Country two letters Continent code from given alpha-2, alpha-3 or numeric code
<code>

          Example:  For France
          $myObject->getCountryRegionAlphaCode('fra');
          $myObject->getCountryRegionAlphaCode('fr');
          $myObject->getCountryRegionAlphaCode('250');       
</code>
* Get Country Continent ISO code from given alpha-2, alpha-3 or numeric code
<code>

          Example:  For France
          $myObject->getCountryRegionNumCode('fra');
          $myObject->getCountryRegionNumCode('fr');
          $myObject->getCountryRegionNumCode('250');     
</code>
* Get Country Continent Name from given alpha-2, alpha-3 or numeric code
<code>

          Example:  For France
          $myObject->getCountryRegionName('fra');
          $myObject->getCountryRegionName('fr');
          $myObject->getCountryRegionName('250');
</code>
* Get Country Sub-region ISO code from given alpha-2, alpha-3 or numeric code
<code>

     	Example:  For France
     	$myObject->getCountrySubRegionCode('fra');
     	$myObject->getCountrySubRegionCode('fr');
     	$myObject->getCountrySubRegionCode('250');          
</code>
* Get Country Sub-region name from given alpha-2, alpha-3 or numeric code
<code>

     	Example:  For France
     	$myObject->getCountrySubRegionName('fra');
     	$myObject->getCountrySubRegionName('fr');
     	$myObject->getCountrySubRegionName('250');
</code>
* Get Languages (code) spoken in a Country  from given alpha-2, alpha-3 or numeric code
<code>

     	Example:  For France
     	$myObject->getCountryLanguage('fra');
     	$myObject->getCountryLanguage('fr');
     	$myObject->getCountryLanguage('250');       
</code>
* Get a Country postal code Regex  from given alpha-2, alpha-3 or numeric code
<code>

     	Example:  For France
     	$myObject->getCountryPostalCodePattern('fra');
     	$myObject->getCountryPostalCodePattern('fr');
     	$myObject->getCountryPostalCodePattern('250');
           
</code>
* Get an associative array of ISO-2, ISO-3 or numeric list of countries
<code>

         Example:  
         $myObject->getAllCountriesCodeAndName($CodeFormat='alpha-2');
         $myObject->getAllCountriesCodeAndName($CodeFormat='alpha-3');
         $myObject->getAllCountriesCodeAndName($CodeFormat='numeric');     
</code>
* Get associative [$code=>$name] array of all Currencies (useful for forms)
<code>

     	$myObject->getAllCurrenciesCodeAndName();
</code>
* Get associative [$isocode=>$name] array of all Regions (useful for forms)
<code>

     	$myObject->getAllRegionsCodeAndName();
</code>
* Get associative array of all countries grouped by region
<code>

     	$myObject->getAllCountriesGroupedByRegions();
</code>
