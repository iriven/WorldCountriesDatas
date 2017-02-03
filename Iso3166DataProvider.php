<?php
/**
 * Created by PhpStorm.
 * User: Iriven
 * Date: 08/01/2017
 * Time: 07:59
 */

namespace Iriven;

/**
 * Class Iso3166DataProvider
 * @package Ressources\Extensions\Plugins\Iso\Datas
 */
final class Iso3166DataProvider implements \Countable, \IteratorAggregate
{
    /**
     * CAUTION:
     * Don't change any thing nor you know what you're doing
     */
    const ALPHA2 = 0;
    const ALPHA3 = 1;
    const NUMERIC = 2;
    const CURRENCY_CODE = 3;
    const CURRENCY_NAME = 4;
    const PHONE_CODE = 5;
    const COUNTRY = 6;
    const CAPITAL = 7;
    const TLD = 8;
    const REGION_ALPHA_CODE = 9;
    const REGION_NUM_CODE = 10;
    const REGION = 11;
    const SUB_REGION_CODE = 12;
    const SUB_REGION = 13;
    const LANGUAGE = 14;
    const POSTAL_CODE_REGEX = 15;
    /**
     * The Only keys you can retrieve datas with
     * @var array
     */
    private $keys = [self::ALPHA2, self::ALPHA3, self::NUMERIC];
    /**
     * @link http://download.geonames.org/export/dump/countryInfo.txt
     *
     * @var array
     */
    private $KnowledgeBase = [
        ['AD', 'AND', '020', 'EUR', 'Euro', '376', 'Andorra', 'Andorra la Vella', '.ad', 'EU', '150', 'Europe', '039', 'Southern Europe', 'ca', '^(?:AD)*(\d{3})$'],
        ['AE', 'ARE', '784', 'AED', 'UAE Dirham', '971', 'United Arab Emirates', 'Abu Dhabi', '.ae', 'AS', '142', 'Asia', '145', 'Western Asia', 'ar-AE,fa,en,hi,ur', ''],
        ['AF', 'AFG', '004', 'AFN', 'Afghani', '93', 'Afghanistan', 'Kabul', '.af', 'AS', '142', 'Asia', '034', 'Southern Asia', 'fa-AF,ps,uz-AF,tk', ''],
        ['AG', 'ATG', '028', 'XCD', 'East Caribbean Dollar', '+1-268', 'Antigua and Barbuda', 'St. John\'s', '.ag', 'AM', '019', 'Americas', '029', 'Caribbean', 'en-AG', ''],
        ['AI', 'AIA', '660', 'XCD', 'East Caribbean Dollar', '+1-264', 'Anguilla', 'The Valley', '.ai', 'AM', '019', 'Americas', '029', 'Caribbean', 'en-AI', ''],
        ['AL', 'ALB', '008', 'ALL', 'Lek', '355', 'Albania', 'Tirana', '.al', 'EU', '150', 'Europe', '039', 'Southern Europe', 'sq,el', ''],
        ['AM', 'ARM', '051', 'AMD', 'Armenian Dram', '374', 'Armenia', 'Yerevan', '.am', 'AS', '142', 'Asia', '145', 'Western Asia', 'hy', '^(\d{6})$'],
        ['AN', 'ANT', '530', 'ANG', 'Netherlands Antillean Guilder', '599', 'Netherlands Antilles', 'Willemstad', '.an', 'AM', '019', 'Americas', '021', 'Northern America', 'nl-AN,en,es', ''],
        ['AO', 'AGO', '024', 'AOA', 'Kwanza', '244', 'Angola', 'Luanda', '.ao', 'AF', '002', 'Africa', '017', 'Middle Africa', 'pt-AO', ''],
        ['AQ', 'ATA', '010', '', '', '', 'Antarctica', '', '.aq', 'AN', '', '', '', '', '', ''],
        ['AR', 'ARG', '032', 'ARS', 'Argentine Peso', '54', 'Argentina', 'Buenos Aires', '.ar', 'AM', '019', 'Americas', '005', 'South America', 'es-AR,en,it,de,fr,gn', '^[A-Z]?\d{4}[A-Z]{0,3}$'],
        ['AS', 'ASM', '016', 'USD', 'US Dollar', '+1-684', 'American Samoa', 'Pago Pago', '.as', 'OC', '009', 'Oceania', '061', 'Polynesia', 'en-AS,sm,to', ''],
        ['AT', 'AUT', '040', 'EUR', 'Euro', '43', 'Austria', 'Vienna', '.at', 'EU', '150', 'Europe', '155', 'Western Europe', 'de-AT,hr,hu,sl', '^(\d{4})$'],
        ['AU', 'AUS', '036', 'AUD', 'Australian Dollar', '61', 'Australia', 'Canberra', '.au', 'OC', '009', 'Oceania', '053', 'Australia and New Zealand', 'en-AU', '^(\d{4})$'],
        ['AW', 'ABW', '533', 'AWG', 'Aruban Florin', '297', 'Aruba', 'Oranjestad', '.aw', 'AM', '019', 'Americas', '029', 'Caribbean', 'nl-AW,es,en', ''],
        ['AX', 'ALA', '248', 'EUR', 'Euro', '+358-18', 'Aland Islands', 'Mariehamn', '.ax', 'EU', '150', 'Europe', '154', 'Northern Europe', 'sv-AX', '^(?:FI)*(\d{5})$'],
        ['AZ', 'AZE', '031', 'AZN', 'Azerbaijanian Manat', '994', 'Azerbaijan', 'Baku', '.az', 'AS', '142', 'Asia', '145', 'Western Asia', 'az,ru,hy', '^(?:AZ)*(\d{4})$'],
        ['BA', 'BIH', '070', 'BAM', 'Convertible Mark', '387', 'Bosnia and Herzegovina', 'Sarajevo', '.ba', 'EU', '150', 'Europe', '039', 'Southern Europe', 'bs,hr-BA,sr-BA', '^(\d{5})$'],
        ['BB', 'BRB', '052', 'BBD', 'Barbados Dollar', '+1-246', 'Barbados', 'Bridgetown', '.bb', 'AM', '019', 'Americas', '029', 'Caribbean', 'en-BB', '^(?:BB)*(\d{5})$'],
        ['BD', 'BGD', '050', 'BDT', 'Taka', '880', 'Bangladesh', 'Dhaka', '.bd', 'AS', '142', 'Asia', '034', 'Southern Asia', 'bn-BD,en', '^(\d{4})$'],
        ['BE', 'BEL', '056', 'EUR', 'Euro', '32', 'Belgium', 'Brussels', '.be', 'EU', '150', 'Europe', '155', 'Western Europe', 'nl-BE,fr-BE,de-BE', '^(\d{4})$'],
        ['BF', 'BFA', '854', 'XOF', 'CFA Franc BCEAO', '226', 'Burkina Faso', 'Ouagadougou', '.bf', 'AF', '002', 'Africa', '011', 'Western Africa', 'fr-BF', ''],
        ['BG', 'BGR', '100', 'BGN', 'Bulgarian Lev', '359', 'Bulgaria', 'Sofia', '.bg', 'EU', '150', 'Europe', '151', 'Eastern Europe', 'bg,tr-BG,rom', '^(\d{4})$'],
        ['BH', 'BHR', '048', 'BHD', 'Bahraini Dinar', '973', 'Bahrain', 'Manama', '.bh', 'AS', '142', 'Asia', '145', 'Western Asia', 'ar-BH,en,fa,ur', '^(\d{3}\d?)$'],
        ['BI', 'BDI', '108', 'BIF', 'Burundi Franc', '257', 'Burundi', 'Bujumbura', '.bi', 'AF', '002', 'Africa', '014', 'Eastern Africa', 'fr-BI,rn', ''],
        ['BJ', 'BEN', '204', 'XOF', 'CFA Franc BCEAO', '229', 'Benin', 'Porto-Novo', '.bj', 'AF', '002', 'Africa', '011', 'Western Africa', 'fr-BJ', ''],
        ['BL', 'BLM', '652', 'EUR', 'Euro', '590', 'Saint Barthelemy', 'Gustavia', '.gp', 'AM', '019', 'Americas', '029', 'Caribbean', 'fr', ''],
        ['BM', 'BMU', '060', 'BMD', 'Bermudian Dollar', '+1-441', 'Bermuda', 'Hamilton', '.bm', 'AM', '019', 'Americas', '021', 'Northern America', 'en-BM,pt', '^([A-Z]{2}\d{2})$'],
        ['BN', 'BRN', '096', 'BND', 'Brunei Dollar', '673', 'Brunei', 'Bandar Seri Begawan', '.bn', 'AS', '142', 'Asia', '035', 'South-Eastern Asia', 'ms-BN,en-BN', '^([A-Z]{2}\d{4})$'],
        ['BO', 'BOL', '068', 'BOB', 'Boliviano', '591', 'Bolivia (Plurinational State of)', 'Sucre', '.bo', 'AM', '019', 'Americas', '005', 'South America', 'es-BO,qu,ay', ''],
        ['BQ', 'BES', '535', 'USD', 'US Dollar', '599', 'Bonaire, Saint Eustatius and Saba', '', '.bq', 'AM', '019', 'Americas', '021', 'Northern America', 'nl,pap,en', ''],
        ['BR', 'BRA', '076', 'BRL', 'Brazilian Real', '55', 'Brazil', 'Brasilia', '.br', 'AM', '019', 'Americas', '005', 'South America', 'pt-BR,es,en,fr', '^\d{5}-\d{3}$'],
        ['BS', 'BHS', '044', 'BSD', 'Bahamian Dollar', '+1-242', 'Bahamas', 'Nassau', '.bs', 'AM', '019', 'Americas', '029', 'Caribbean', 'en-BS', ''],
        ['BT', 'BTN', '064', 'BTN', 'Ngultrum', '975', 'Bhutan', 'Thimphu', '.bt', 'AS', '142', 'Asia', '034', 'Southern Asia', 'dz', ''],
        ['BV', 'BVT', '074', 'NOK', 'Norwegian Krone', '', 'Bouvet Island', '', '.bv', 'AN', '', '', '', '', '', ''],
        ['BW', 'BWA', '072', 'BWP', 'Pula', '267', 'Botswana', 'Gaborone', '.bw', 'AF', '002', 'Africa', '018', 'Southern Africa', 'en-BW,tn-BW', ''],
        ['BY', 'BLR', '112', 'BYR', 'Belarussian Ruble', '375', 'Belarus', 'Minsk', '.by', 'EU', '150', 'Europe', '151', 'Eastern Europe', 'be,ru', '^(\d{6})$'],
        ['BZ', 'BLZ', '084', 'BZD', 'Belize Dollar', '501', 'Belize', 'Belmopan', '.bz', 'AM', '019', 'Americas', '013', 'Central America', 'en-BZ,es', ''],
        ['CA', 'CAN', '124', 'CAD', 'Canadian Dollar', '1', 'Canada', 'Ottawa', '.ca', 'AM', '019', 'Americas', '021', 'Northern America', 'en-CA,fr-CA,iu', '^([ABCEGHJKLMNPRSTVXY]\d[ABCEGHJKLMNPRSTVWXYZ]) ?(\d[ABCEGHJKLMNPRSTVWXYZ]\d)$'],
        ['CC', 'CCK', '166', 'AUD', 'Australian Dollar', '61', 'Cocos  (Keeling) Islands', 'West Island', '.cc', 'AS', '142', 'Asia', '', '', 'ms-CC,en', ''],
        ['CD', 'COD', '180', 'CDF', 'Congolese Franc', '243', 'Congo (Democratic Republic of the)', 'Kinshasa', '.cd', 'AF', '002', 'Africa', '017', 'Middle Africa', 'fr-CD,ln,kg', ''],
        ['CF', 'CAF', '140', 'XAF', 'CFA Franc BEAC', '236', 'Central African Republic', 'Bangui', '.cf', 'AF', '002', 'Africa', '017', 'Middle Africa', 'fr-CF,sg,ln,kg', ''],
        ['CG', 'COG', '178', 'XAF', 'CFA Franc BEAC', '242', 'Congo (Republic of)', 'Brazzaville', '.cg', 'AF', '002', 'Africa', '017', 'Middle Africa', 'fr-CG,kg,ln-CG', ''],
        ['CH', 'CHE', '756', 'CHF', 'Swiss Franc', '41', 'Switzerland', 'Bern', '.ch', 'EU', '150', 'Europe', '155', 'Western Europe', 'de-CH,fr-CH,it-CH,rm', '^(\d{4})$'],
        ['CI', 'CIV', '384', 'XOF', 'CFA Franc BCEAO', '225', 'Ivory Coast', 'Yamoussoukro', '.ci', 'AF', '002', 'Africa', '011', 'Western Africa', 'fr-CI', ''],
        ['CK', 'COK', '184', 'NZD', 'New Zealand Dollar', '682', 'Cook Islands', 'Avarua', '.ck', 'OC', '009', 'Oceania', '061', 'Polynesia', 'en-CK,mi', ''],
        ['CL', 'CHL', '152', 'CLP', 'Chilean Peso', '56', 'Chile', 'Santiago', '.cl', 'AM', '019', 'Americas', '005', 'South America', 'es-CL', '^(\d{7})$'],
        ['CM', 'CMR', '120', 'XAF', 'CFA Franc BEAC', '237', 'Cameroon', 'Yaounde', '.cm', 'AF', '002', 'Africa', '017', 'Middle Africa', 'en-CM,fr-CM', ''],
        ['CN', 'CHN', '156', 'CNY', 'Yuan Renminbi', '86', 'China', 'Beijing', '.cn', 'AS', '142', 'Asia', '030', 'Eastern Asia', 'zh-CN,yue,wuu,dta,ug,za', '^(\d{6})$'],
        ['CO', 'COL', '170', 'COP', 'Colombian Peso', '57', 'Colombia', 'Bogota', '.co', 'AM', '019', 'Americas', '005', 'South America', 'es-CO', ''],
        ['CR', 'CRI', '188', 'CRC', 'Costa Rican Colon', '506', 'Costa Rica', 'San Jose', '.cr', 'AM', '019', 'Americas', '013', 'Central America', 'es-CR,en', '^(\d{4})$'],
        ['CU', 'CUB', '192', 'CUP', 'Cuban Peso', '53', 'Cuba', 'Havana', '.cu', 'AM', '019', 'Americas', '029', 'Caribbean', 'es-CU', '^(?:CP)*(\d{5})$'],
        ['CV', 'CPV', '132', 'CVE', 'Cabo Verde Escudo', '238', 'Cape Verde', 'Praia', '.cv', 'AF', '002', 'Africa', '011', 'Western Africa', 'pt-CV', '^(\d{4})$'],
        ['CW', 'CUW', '531', 'ANG', 'Netherlands Antillean Guilder', '599', 'Curacao', 'Willemstad', '.cw', 'AM', '019', 'Americas', '029', 'Caribbean', 'nl,pap', ''],
        ['CX', 'CXR', '162', 'AUD', 'Australian Dollar', '61', 'Christmas Island', 'Flying Fish Cove', '.cx', 'AS', '142', 'Asia', '', '', 'en,zh,ms-CC', '^(\d{4})$'],
        ['CY', 'CYP', '196', 'EUR', 'Euro', '357', 'Cyprus', 'Nicosia', '.cy', 'EU', '142', 'Asia', '145', 'Western Asia', 'el-CY,tr-CY,en', '^(\d{4})$'],
        ['CZ', 'CZE', '203', 'CZK', 'Czech Koruna', '420', 'Czech Republic', 'Prague', '.cz', 'EU', '150', 'Europe', '151', 'Eastern Europe', 'cs,sk', '^\d{3}\s?\d{2}$'],
        ['DE', 'DEU', '276', 'EUR', 'Euro', '49', 'Germany', 'Berlin', '.de', 'EU', '150', 'Europe', '155', 'Western Europe', 'de', '^(\d{5})$'],
        ['DJ', 'DJI', '262', 'DJF', 'Djibouti Franc', '253', 'Djibouti', 'Djibouti', '.dj', 'AF', '002', 'Africa', '014', 'Eastern Africa', 'fr-DJ,ar,so-DJ,aa', ''],
        ['DK', 'DNK', '208', 'DKK', 'Danish Krone', '45', 'Denmark', 'Copenhagen', '.dk', 'EU', '150', 'Europe', '154', 'Northern Europe', 'da-DK,en,fo,de-DK', '^(\d{4})$'],
        ['DM', 'DMA', '212', 'XCD', 'East Caribbean Dollar', '+1-767', 'Dominica', 'Roseau', '.dm', 'AM', '019', 'Americas', '029', 'Caribbean', 'en-DM', ''],
        ['DO', 'DOM', '214', 'DOP', 'Dominican Peso', '+1-809 and 1-829', 'Dominican Republic', 'Santo Domingo', '.do', 'AM', '019', 'Americas', '029', 'Caribbean', 'es-DO', '^(\d{5})$'],
        ['DZ', 'DZA', '012', 'DZD', 'Algerian Dinar', '213', 'Algeria', 'Algiers', '.dz', 'AF', '002', 'Africa', '015', 'Northern Africa', 'ar-DZ', '^(\d{5})$'],
        ['EC', 'ECU', '218', 'USD', 'US Dollar', '593', 'Ecuador', 'Quito', '.ec', 'AM', '019', 'Americas', '005', 'South America', 'es-EC', '^([a-zA-Z]\d{4}[a-zA-Z])$'],
        ['EE', 'EST', '233', 'EUR', 'Euro', '372', 'Estonia', 'Tallinn', '.ee', 'EU', '150', 'Europe', '154', 'Northern Europe', 'et,ru', '^(\d{5})$'],
        ['EG', 'EGY', '818', 'EGP', 'Egyptian Pound', '20', 'Egypt', 'Cairo', '.eg', 'AF', '002', 'Africa', '015', 'Northern Africa', 'ar-EG,en,fr', '^(\d{5})$'],
        ['EH', 'ESH', '732', 'MAD', 'Moroccan Dirham', '212', 'Western Sahara', 'El-Aaiun', '.eh', 'AF', '002', 'Africa', '015', 'Northern Africa', 'ar,mey', ''],
        ['ER', 'ERI', '232', 'ERN', 'Nakfa', '291', 'Eritrea', 'Asmara', '.er', 'AF', '002', 'Africa', '014', 'Eastern Africa', 'aa-ER,ar,tig,kun,ti-ER', ''],
        ['ES', 'ESP', '724', 'EUR', 'Euro', '34', 'Spain', 'Madrid', '.es', 'EU', '150', 'Europe', '039', 'Southern Europe', 'es-ES,ca,gl,eu,oc', '^(\d{5})$'],
        ['ET', 'ETH', '231', 'ETB', 'Ethiopian Birr', '251', 'Ethiopia', 'Addis Ababa', '.et', 'AF', '002', 'Africa', '014', 'Eastern Africa', 'am,en-ET,om-ET,ti-ET,so-ET,sid', '^(\d{4})$'],
        ['FI', 'FIN', '246', 'EUR', 'Euro', '358', 'Finland', 'Helsinki', '.fi', 'EU', '150', 'Europe', '154', 'Northern Europe', 'fi-FI,sv-FI,smn', '^(?:FI)*(\d{5})$'],
        ['FJ', 'FJI', '242', 'FJD', 'Fiji Dollar', '679', 'Fiji', 'Suva', '.fj', 'OC', '009', 'Oceania', '054', 'Melanesia', 'en-FJ,fj', ''],
        ['FK', 'FLK', '238', 'FKP', 'Falkland Islands Pound', '500', 'Falkland Islands (Malvinas)', 'Stanley', '.fk', 'AM', '019', 'Americas', '005', 'South America', 'en-FK', ''],
        ['FM', 'FSM', '583', 'USD', 'US Dollar', '691', 'Micronesia', 'Palikir', '.fm', 'OC', '009', 'Oceania', '057', 'Micronesia', 'en-FM,chk,pon,yap,kos,uli,woe,nkr,kpg', '^(\d{5})$'],
        ['FO', 'FRO', '234', 'DKK', 'Danish Krone', '298', 'Faroe Islands', 'Torshavn', '.fo', 'EU', '150', 'Europe', '154', 'Northern Europe', 'fo,da-FO', '^(?:FO)*(\d{3})$'],
        ['FR', 'FRA', '250', 'EUR', 'Euro', '33', 'France', 'Paris', '.fr', 'EU', '150', 'Europe', '155', 'Western Europe', 'fr-FR,frp,br,co,ca,eu,oc', '^(\d{5})$'],
        ['GA', 'GAB', '266', 'XAF', 'CFA Franc BEAC', '241', 'Gabon', 'Libreville', '.ga', 'AF', '002', 'Africa', '017', 'Middle Africa', 'fr-GA', ''],
        ['GB', 'GBR', '826', 'GBP', 'Pound Sterling', '44', 'United Kingdom', 'London', '.uk', 'EU', '150', 'Europe', '154', 'Northern Europe', 'en-GB,cy-GB,gd', '^((?:(?:[A-PR-UWYZ][A-HK-Y]\d[ABEHMNPRV-Y0-9]|[A-PR-UWYZ]\d[A-HJKPS-UW0-9])\s\d[ABD-HJLNP-UW-Z]{2})|GIR\s?0AA)$'],
        ['GD', 'GRD', '308', 'XCD', 'East Caribbean Dollar', '+1-473', 'Grenada', 'St. George\'s', '.gd', 'AM', '019', 'Americas', '029', 'Caribbean', 'en-GD', ''],
        ['GE', 'GEO', '268', 'GEL', 'Lari', '995', 'Georgia', 'Tbilisi', '.ge', 'AS', '142', 'Asia', '145', 'Western Asia', 'ka,ru,hy,az', '^(\d{4})$'],
        ['GF', 'GUF', '254', 'EUR', 'Euro', '594', 'French Guiana', 'Cayenne', '.gf', 'AM', '019', 'Americas', '005', 'South America', 'fr-GF', '^((97|98)3\d{2})$'],
        ['GG', 'GGY', '831', 'GBP', 'Pound Sterling', '+44-1481', 'Guernsey', 'St Peter Port', '.gg', 'EU', '150', 'Europe', '154', 'Northern Europe', 'en,fr', '^((?:(?:[A-PR-UWYZ][A-HK-Y]\d[ABEHMNPRV-Y0-9]|[A-PR-UWYZ]\d[A-HJKPS-UW0-9])\s\d[ABD-HJLNP-UW-Z]{2})|GIR\s?0AA)$'],
        ['GH', 'GHA', '288', 'GHS', 'Ghana Cedi', '233', 'Ghana', 'Accra', '.gh', 'AF', '002', 'Africa', '011', 'Western Africa', 'en-GH,ak,ee,tw', ''],
        ['GI', 'GIB', '292', 'GIP', 'Gibraltar Pound', '350', 'Gibraltar', 'Gibraltar', '.gi', 'EU', '150', 'Europe', '039', 'Southern Europe', 'en-GI,es,it,pt', ''],
        ['GL', 'GRL', '304', 'DKK', 'Danish Krone', '299', 'Greenland', 'Nuuk', '.gl', 'AM', '019', 'Americas', '021', 'Northern America', 'kl,da-GL,en', '^(\d{4})$'],
        ['GM', 'GMB', '270', 'GMD', 'Dalasi', '220', 'Gambia', 'Banjul', '.gm', 'AF', '002', 'Africa', '011', 'Western Africa', 'en-GM,mnk,wof,wo,ff', ''],
        ['GN', 'GIN', '324', 'GNF', 'Guinea Franc', '224', 'Guinea', 'Conakry', '.gn', 'AF', '002', 'Africa', '011', 'Western Africa', 'fr-GN', ''],
        ['GP', 'GLP', '312', 'EUR', 'Euro', '590', 'Guadeloupe', 'Basse-Terre', '.gp', 'AM', '019', 'Americas', '029', 'Caribbean', 'fr-GP', '^((97|98)\d{3})$'],
        ['GQ', 'GNQ', '226', 'XAF', 'CFA Franc BEAC', '240', 'Equatorial Guinea', 'Malabo', '.gq', 'AF', '002', 'Africa', '017', 'Middle Africa', 'es-GQ,fr', ''],
        ['GR', 'GRC', '300', 'EUR', 'Euro', '30', 'Greece', 'Athens', '.gr', 'EU', '150', 'Europe', '039', 'Southern Europe', 'el-GR,en,fr', '^(\d{5})$'],
        ['GS', 'SGS', '239', 'GBP', 'Pound Sterling', '', 'South Georgia and the South Sandwich Islands', 'Grytviken', '.gs', 'AN', '', '', '', '', 'en', ''],
        ['GT', 'GTM', '320', 'GTQ', 'Quetzal', '502', 'Guatemala', 'Guatemala City', '.gt', 'AM', '019', 'Americas', '013', 'Central America', 'es-GT', '^(\d{5})$'],
        ['GU', 'GUM', '316', 'USD', 'US Dollar', '+1-671', 'Guam', 'Hagatna', '.gu', 'OC', '009', 'Oceania', '057', 'Micronesia', 'en-GU,ch-GU', '^(969\d{2})$'],
        ['GW', 'GNB', '624', 'XOF', 'CFA Franc BCEAO', '245', 'Guinea-Bissau', 'Bissau', '.gw', 'AF', '002', 'Africa', '011', 'Western Africa', 'pt-GW,pov', '^(\d{4})$'],
        ['GY', 'GUY', '328', 'GYD', 'Guyana Dollar', '592', 'Guyana', 'Georgetown', '.gy', 'AM', '019', 'Americas', '005', 'South America', 'en-GY', ''],
        ['HK', 'HKG', '344', 'HKD', 'Hong Kong Dollar', '852', 'Hong Kong', 'Hong Kong', '.hk', 'AS', '142', 'Asia', '030', 'Eastern Asia', 'zh-HK,yue,zh,en', ''],
        ['HM', 'HMD', '334', 'AUD', 'Australian Dollar', '', 'Heard Island and McDonald Islands', '', '.hm', 'AN', '', '', '', '', '', ''],
        ['HN', 'HND', '340', 'HNL', 'Lempira', '504', 'Honduras', 'Tegucigalpa', '.hn', 'AM', '019', 'Americas', '013', 'Central America', 'es-HN', '^([A-Z]{2}\d{4})$'],
        ['HR', 'HRV', '191', 'HRK', 'Kuna', '385', 'Croatia', 'Zagreb', '.hr', 'EU', '150', 'Europe', '039', 'Southern Europe', 'hr-HR,sr', '^(?:HR)*(\d{5})$'],
        ['HT', 'HTI', '332', 'HTG', 'Gourde', '509', 'Haiti', 'Port-au-Prince', '.ht', 'AM', '019', 'Americas', '029', 'Caribbean', 'ht,fr-HT', '^(?:HT)*(\d{4})$'],
        ['HU', 'HUN', '348', 'HUF', 'Forint', '36', 'Hungary', 'Budapest', '.hu', 'EU', '150', 'Europe', '151', 'Eastern Europe', 'hu-HU', '^(\d{4})$'],
        ['ID', 'IDN', '360', 'IDR', 'Rupiah', '62', 'Indonesia', 'Jakarta', '.id', 'AS', '142', 'Asia', '035', 'South-Eastern Asia', 'id,en,nl,jv', '^(\d{5})$'],
        ['IE', 'IRL', '372', 'EUR', 'Euro', '353', 'Ireland', 'Dublin', '.ie', 'EU', '150', 'Europe', '154', 'Northern Europe', 'en-IE,ga-IE', '^[A-Z]\d{2}$|^[A-Z]{3}[A-Z]{4}$'],
        ['IL', 'ISR', '376', 'ILS', 'New Israeli Sheqel', '972', 'Israel', 'Jerusalem', '.il', 'AS', '142', 'Asia', '145', 'Western Asia', 'he,ar-IL,en-IL,', '^(\d{5})$'],
        ['IM', 'IMN', '833', 'GBP', 'Pound Sterling', '+44-1624', 'Isle of Man', 'Douglas', '.im', 'EU', '150', 'Europe', '154', 'Northern Europe', 'en,gv', '^((?:(?:[A-PR-UWYZ][A-HK-Y]\d[ABEHMNPRV-Y0-9]|[A-PR-UWYZ]\d[A-HJKPS-UW0-9])\s\d[ABD-HJLNP-UW-Z]{2})|GIR\s?0AA)$'],
        ['IN', 'IND', '356', 'INR', 'Indian Rupee', '91', 'India', 'New Delhi', '.in', 'AS', '142', 'Asia', '034', 'Southern Asia', 'en-IN,hi,bn,te,mr,ta,ur,gu,kn,ml,or,pa,as,bh,sat,ks,ne,sd,kok,doi,mni,sit,sa,fr,lus,inc', '^(\d{6})$'],
        ['IO', 'IOT', '086', 'USD', 'US Dollar', '246', 'British Indian Ocean Territory', 'Diego Garcia', '.io', 'AS', '142', 'Asia', '', '', 'en-IO', ''],
        ['IQ', 'IRQ', '368', 'IQD', 'Iraqi Dinar', '964', 'Iraq', 'Baghdad', '.iq', 'AS', '142', 'Asia', '145', 'Western Asia', 'ar-IQ,ku,hy', '^(\d{5})$'],
        ['IR', 'IRN', '364', 'IRR', 'Iranian Rial', '98', 'Iran (Islamic Republic of)', 'Tehran', '.ir', 'AS', '142', 'Asia', '034', 'Southern Asia', 'fa-IR,ku', '^(\d{10})$'],
        ['IS', 'ISL', '352', 'ISK', 'Iceland Krona', '354', 'Iceland', 'Reykjavik', '.is', 'EU', '150', 'Europe', '154', 'Northern Europe', 'is,en,de,da,sv,no', '^(\d{3})$'],
        ['IT', 'ITA', '380', 'EUR', 'Euro', '39', 'Italy', 'Rome', '.it', 'EU', '150', 'Europe', '039', 'Southern Europe', 'it-IT,de-IT,fr-IT,sc,ca,co,sl', '^(\d{5})$'],
        ['JE', 'JEY', '832', 'GBP', 'Pound Sterling', '+44-1534', 'Jersey', 'Saint Helier', '.je', 'EU', '150', 'Europe', '154', 'Northern Europe', 'en,pt', '^((?:(?:[A-PR-UWYZ][A-HK-Y]\d[ABEHMNPRV-Y0-9]|[A-PR-UWYZ]\d[A-HJKPS-UW0-9])\s\d[ABD-HJLNP-UW-Z]{2})|GIR\s?0AA)$'],
        ['JM', 'JAM', '388', 'JMD', 'Jamaican Dollar', '+1-876', 'Jamaica', 'Kingston', '.jm', 'AM', '019', 'Americas', '029', 'Caribbean', 'en-JM', ''],
        ['JO', 'JOR', '400', 'JOD', 'Jordanian Dinar', '962', 'Jordan', 'Amman', '.jo', 'AS', '142', 'Asia', '145', 'Western Asia', 'ar-JO,en', '^(\d{5})$'],
        ['JP', 'JPN', '392', 'JPY', 'Yen', '81', 'Japan', 'Tokyo', '.jp', 'AS', '142', 'Asia', '030', 'Eastern Asia', 'ja', '^\d{3}-\d{4}$'],
        ['KE', 'KEN', '404', 'KES', 'Kenyan Shilling', '254', 'Kenya', 'Nairobi', '.ke', 'AF', '002', 'Africa', '014', 'Eastern Africa', 'en-KE,sw-KE', '^(\d{5})$'],
        ['KG', 'KGZ', '417', 'KGS', 'Som', '996', 'Kyrgyzstan', 'Bishkek', '.kg', 'AS', '142', 'Asia', '143', 'Central Asia', 'ky,uz,ru', '^(\d{6})$'],
        ['KH', 'KHM', '116', 'KHR', 'Riel', '855', 'Cambodia', 'Phnom Penh', '.kh', 'AS', '142', 'Asia', '035', 'South-Eastern Asia', 'km,fr,en', '^(\d{5})$'],
        ['KI', 'KIR', '296', 'AUD', 'Australian Dollar', '686', 'Kiribati', 'Tarawa', '.ki', 'OC', '009', 'Oceania', '057', 'Micronesia', 'en-KI,gil', ''],
        ['KM', 'COM', '174', 'KMF', 'Comoro Franc', '269', 'Comoros', 'Moroni', '.km', 'AF', '002', 'Africa', '014', 'Eastern Africa', 'ar,fr-KM', ''],
        ['KN', 'KNA', '659', 'XCD', 'East Caribbean Dollar', '+1-869', 'Saint Kitts and Nevis', 'Basseterre', '.kn', 'AM', '019', 'Americas', '029', 'Caribbean', 'en-KN', ''],
        ['KP', 'PRK', '408', 'KPW', 'North Korean Won', '850', 'North Korea (Democratic People\'s Republic of)', 'Pyongyang', '.kp', 'AS', '142', 'Asia', '030', 'Eastern Asia', 'ko-KP', '^(\d{6})$'],
        ['KR', 'KOR', '410', 'KRW', 'Won', '82', 'South Korea (Republic of)', 'Seoul', '.kr', 'AS', '142', 'Asia', '030', 'Eastern Asia', 'ko-KR,en', '^(?:SEOUL)*(\d{6})$'],
        ['KW', 'KWT', '414', 'KWD', 'Kuwaiti Dinar', '965', 'Kuwait', 'Kuwait City', '.kw', 'AS', '142', 'Asia', '145', 'Western Asia', 'ar-KW,en', '^(\d{5})$'],
        ['KY', 'CYM', '136', 'KYD', 'Cayman Islands Dollar', '+1-345', 'Cayman Islands', 'George Town', '.ky', 'AM', '019', 'Americas', '029', 'Caribbean', 'en-KY', ''],
        ['KZ', 'KAZ', '398', 'KZT', 'Tenge', '7', 'Kazakhstan', 'Astana', '.kz', 'AS', '142', 'Asia', '143', 'Central Asia', 'kk,ru', '^(\d{6})$'],
        ['LA', 'LAO', '418', 'LAK', 'Kip', '856', 'Laos', 'Vientiane', '.la', 'AS', '142', 'Asia', '035', 'South-Eastern Asia', 'lo,fr,en', '^(\d{5})$'],
        ['LB', 'LBN', '422', 'LBP', 'Lebanese Pound', '961', 'Lebanon', 'Beirut', '.lb', 'AS', '142', 'Asia', '145', 'Western Asia', 'ar-LB,fr-LB,en,hy', '^(\d{4}(\d{4})?)$'],
        ['LC', 'LCA', '662', 'XCD', 'East Caribbean Dollar', '+1-758', 'Saint Lucia', 'Castries', '.lc', 'AM', '019', 'Americas', '029', 'Caribbean', 'en-LC', ''],
        ['LI', 'LIE', '438', 'CHF', 'Swiss Franc', '423', 'Liechtenstein', 'Vaduz', '.li', 'EU', '150', 'Europe', '155', 'Western Europe', 'de-LI', '^(\d{4})$'],
        ['LK', 'LKA', '144', 'LKR', 'Sri Lanka Rupee', '94', 'Sri Lanka', 'Colombo', '.lk', 'AS', '142', 'Asia', '034', 'Southern Asia', 'si,ta,en', '^(\d{5})$'],
        ['LR', 'LBR', '430', 'LRD', 'Liberian Dollar', '231', 'Liberia', 'Monrovia', '.lr', 'AF', '002', 'Africa', '011', 'Western Africa', 'en-LR', '^(\d{4})$'],
        ['LS', 'LSO', '426', 'LSL', 'Loti', '266', 'Lesotho', 'Maseru', '.ls', 'AF', '002', 'Africa', '018', 'Southern Africa', 'en-LS,st,zu,xh', '^(\d{3})$'],
        ['LT', 'LTU', '440', 'EUR', 'Euro', '370', 'Lithuania', 'Vilnius', '.lt', 'EU', '150', 'Europe', '154', 'Northern Europe', 'lt,ru,pl', '^(?:LT)*(\d{5})$'],
        ['LU', 'LUX', '442', 'EUR', 'Euro', '352', 'Luxembourg', 'Luxembourg', '.lu', 'EU', '150', 'Europe', '155', 'Western Europe', 'lb,de-LU,fr-LU', '^(?:L-)?\d{4}$'],
        ['LV', 'LVA', '428', 'EUR', 'Euro', '371', 'Latvia', 'Riga', '.lv', 'EU', '150', 'Europe', '154', 'Northern Europe', 'lv,ru,lt', '^(?:LV)*(\d{4})$'],
        ['LY', 'LBY', '434', 'LYD', 'Libyan Dinar', '218', 'Libya', 'Tripoli', '.ly', 'AF', '002', 'Africa', '015', 'Northern Africa', 'ar-LY,it,en', ''],
        ['MA', 'MAR', '504', 'MAD', 'Moroccan Dirham', '212', 'Morocco', 'Rabat', '.ma', 'AF', '002', 'Africa', '015', 'Northern Africa', 'ar-MA,fr', '^(\d{5})$'],
        ['MC', 'MCO', '492', 'EUR', 'Euro', '377', 'Monaco', 'Monaco', '.mc', 'EU', '150', 'Europe', '155', 'Western Europe', 'fr-MC,en,it', '^(\d{5})$'],
        ['MD', 'MDA', '498', 'MDL', 'Moldovan Leu', '373', 'Moldova', 'Chisinau', '.md', 'EU', '150', 'Europe', '151', 'Eastern Europe', 'ro,ru,gag,tr', '^MD-\d{4}$'],
        ['ME', 'MNE', '499', 'EUR', 'Euro', '382', 'Montenegro', 'Podgorica', '.me', 'EU', '150', 'Europe', '039', 'Southern Europe', 'sr,hu,bs,sq,hr,rom', '^(\d{5})$'],
        ['MF', 'MAF', '663', 'EUR', 'Euro', '590', 'Saint Martin', 'Marigot', '.gp', 'AM', '019', 'Americas', '029', 'Caribbean', 'fr', ''],
        ['MG', 'MDG', '450', 'MGA', 'Malagasy Ariary', '261', 'Madagascar', 'Antananarivo', '.mg', 'AF', '002', 'Africa', '014', 'Eastern Africa', 'fr-MG,mg', '^(\d{3})$'],
        ['MH', 'MHL', '584', 'USD', 'US Dollar', '692', 'Marshall Islands', 'Majuro', '.mh', 'OC', '009', 'Oceania', '057', 'Micronesia', 'mh,en-MH', ''],
        ['MK', 'MKD', '807', 'MKD', 'Denar', '389', 'Macedonia', 'Skopje', '.mk', 'EU', '150', 'Europe', '039', 'Southern Europe', 'mk,sq,tr,rmm,sr', '^(\d{4})$'],
        ['ML', 'MLI', '466', 'XOF', 'CFA Franc BCEAO', '223', 'Mali', 'Bamako', '.ml', 'AF', '002', 'Africa', '011', 'Western Africa', 'fr-ML,bm', ''],
        ['MM', 'MMR', '104', 'MMK', 'Kyat', '95', 'Myanmar', 'Nay Pyi Taw', '.mm', 'AS', '142', 'Asia', '035', 'South-Eastern Asia', 'my', '^(\d{5})$'],
        ['MN', 'MNG', '496', 'MNT', 'Tugrik', '976', 'Mongolia', 'Ulan Bator', '.mn', 'AS', '142', 'Asia', '030', 'Eastern Asia', 'mn,ru', '^(\d{6})$'],
        ['MO', 'MAC', '446', 'MOP', 'Pataca', '853', 'Macao', 'Macao', '.mo', 'AS', '142', 'Asia', '030', 'Eastern Asia', 'zh,zh-MO,pt', ''],
        ['MP', 'MNP', '580', 'USD', 'US Dollar', '+1-670', 'Northern Mariana Islands', 'Saipan', '.mp', 'OC', '009', 'Oceania', '057', 'Micronesia', 'fil,tl,zh,ch-MP,en-MP', ''],
        ['MQ', 'MTQ', '474', 'EUR', 'Euro', '596', 'Martinique', 'Fort-de-France', '.mq', 'AM', '019', 'Americas', '029', 'Caribbean', 'fr-MQ', '^(\d{5})$'],
        ['MR', 'MRT', '478', 'MRO', 'Ouguiya', '222', 'Mauritania', 'Nouakchott', '.mr', 'AF', '002', 'Africa', '011', 'Western Africa', 'ar-MR,fuc,snk,fr,mey,wo', ''],
        ['MS', 'MSR', '500', 'XCD', 'East Caribbean Dollar', '+1-664', 'Montserrat', 'Plymouth', '.ms', 'AM', '019', 'Americas', '029', 'Caribbean', 'en-MS', ''],
        ['MT', 'MLT', '470', 'EUR', 'Euro', '356', 'Malta', 'Valletta', '.mt', 'EU', '150', 'Europe', '039', 'Southern Europe', 'mt,en-MT', '^[A-Z]{3}\s?\d{4}$'],
        ['MU', 'MUS', '480', 'MUR', 'Mauritius Rupee', '230', 'Mauritius', 'Port Louis', '.mu', 'AF', '002', 'Africa', '014', 'Eastern Africa', 'en-MU,bho,fr', ''],
        ['MV', 'MDV', '462', 'MVR', 'Rufiyaa', '960', 'Maldives', 'Male', '.mv', 'AS', '142', 'Asia', '034', 'Southern Asia', 'dv,en', '^(\d{5})$'],
        ['MW', 'MWI', '454', 'MWK', 'Kwacha', '265', 'Malawi', 'Lilongwe', '.mw', 'AF', '002', 'Africa', '014', 'Eastern Africa', 'ny,yao,tum,swk', ''],
        ['MX', 'MEX', '484', 'MXN', 'Mexican Peso', '52', 'Mexico', 'Mexico City', '.mx', 'AM', '019', 'Americas', '013', 'Central America', 'es-MX', '^(\d{5})$'],
        ['MY', 'MYS', '458', 'MYR', 'Malaysian Ringgit', '60', 'Malaysia', 'Kuala Lumpur', '.my', 'AS', '142', 'Asia', '035', 'South-Eastern Asia', 'ms-MY,en,zh,ta,te,ml,pa,th', '^(\d{5})$'],
        ['MZ', 'MOZ', '508', 'MZN', 'Mozambique Metical', '258', 'Mozambique', 'Maputo', '.mz', 'AF', '002', 'Africa', '014', 'Eastern Africa', 'pt-MZ,vmw', '^(\d{4})$'],
        ['AM', 'NAM', '516', 'NAD', 'Namibia Dollar', '264', 'Namibia', 'Windhoek', '.na', 'AF', '002', 'Africa', '018', 'Southern Africa', 'en-AM,af,de,hz,naq', ''],
        ['NC', 'NCL', '540', 'XPF', 'CFP Franc', '687', 'New Caledonia', 'Noumea', '.nc', 'OC', '009', 'Oceania', '054', 'Melanesia', 'fr-NC', '^(\d{5})$'],
        ['NE', 'NER', '562', 'XOF', 'CFA Franc BCEAO', '227', 'Niger', 'Niamey', '.ne', 'AF', '002', 'Africa', '011', 'Western Africa', 'fr-NE,ha,kr,dje', '^(\d{4})$'],
        ['NF', 'NFK', '574', 'AUD', 'Australian Dollar', '672', 'Norfolk Island', 'Kingston', '.nf', 'OC', '009', 'Oceania', '053', 'Australia and New Zealand', 'en-NF', '^(\d{4})$'],
        ['NG', 'NGA', '566', 'NGN', 'Naira', '234', 'Nigeria', 'Abuja', '.ng', 'AF', '002', 'Africa', '011', 'Western Africa', 'en-NG,ha,yo,ig,ff', '^(\d{6})$'],
        ['NI', 'NIC', '558', 'NIO', 'Cordoba Oro', '505', 'Nicaragua', 'Managua', '.ni', 'AM', '019', 'Americas', '013', 'Central America', 'es-NI,en', '^(\d{7})$'],
        ['NL', 'NLD', '528', 'EUR', 'Euro', '31', 'Netherlands', 'Amsterdam', '.nl', 'EU', '150', 'Europe', '155', 'Western Europe', 'nl-NL,fy-NL', '^(\d{4}[A-Z]{2})$'],
        ['NO', 'NOR', '578', 'NOK', 'Norwegian Krone', '47', 'Norway', 'Oslo', '.no', 'EU', '150', 'Europe', '154', 'Northern Europe', 'no,nb,nn,se,fi', '^(\d{4})$'],
        ['NP', 'NPL', '524', 'NPR', 'Nepalese Rupee', '977', 'Nepal', 'Kathmandu', '.np', 'AS', '142', 'Asia', '034', 'Southern Asia', 'ne,en', '^(\d{5})$'],
        ['NR', 'NRU', '520', 'AUD', 'Australian Dollar', '674', 'Nauru', 'Yaren', '.nr', 'OC', '009', 'Oceania', '057', 'Micronesia', 'na,en-NR', ''],
        ['NU', 'NIU', '570', 'NZD', 'New Zealand Dollar', '683', 'Niue', 'Alofi', '.nu', 'OC', '009', 'Oceania', '061', 'Polynesia', 'niu,en-NU', ''],
        ['NZ', 'NZL', '554', 'NZD', 'New Zealand Dollar', '64', 'New Zealand', 'Wellington', '.nz', 'OC', '009', 'Oceania', '053', 'Australia and New Zealand', 'en-NZ,mi', '^(\d{4})$'],
        ['OM', 'OMN', '512', 'OMR', 'Rial Omani', '968', 'Oman', 'Muscat', '.om', 'AS', '142', 'Asia', '145', 'Western Asia', 'ar-OM,en,bal,ur', '^(\d{3})$'],
        ['PA', 'PAN', '591', 'PAB', 'Balboa', '507', 'Panama', 'Panama City', '.pa', 'AM', '019', 'Americas', '013', 'Central America', 'es-PA,en', ''],
        ['PE', 'PER', '604', 'PEN', 'Nuevo Sol', '51', 'Peru', 'Lima', '.pe', 'AM', '019', 'Americas', '005', 'South America', 'es-PE,qu,ay', ''],
        ['PF', 'PYF', '258', 'XPF', 'CFP Franc', '689', 'French Polynesia', 'Papeete', '.pf', 'OC', '009', 'Oceania', '061', 'Polynesia', 'fr-PF,ty', '^((97|98)7\d{2})$'],
        ['PG', 'PNG', '598', 'PGK', 'Kina', '675', 'Papua New Guinea', 'Port Moresby', '.pg', 'OC', '009', 'Oceania', '054', 'Melanesia', 'en-PG,ho,meu,tpi', '^(\d{3})$'],
        ['PH', 'PHL', '608', 'PHP', 'Philippine Peso', '63', 'Philippines', 'Manila', '.ph', 'AS', '142', 'Asia', '035', 'South-Eastern Asia', 'tl,en-PH,fil', '^(\d{4})$'],
        ['PK', 'PAK', '586', 'PKR', 'Pakistan Rupee', '92', 'Pakistan', 'Islamabad', '.pk', 'AS', '142', 'Asia', '034', 'Southern Asia', 'ur-PK,en-PK,pa,sd,ps,brh', '^(\d{5})$'],
        ['PL', 'POL', '616', 'PLN', 'Zloty', '48', 'Poland', 'Warsaw', '.pl', 'EU', '150', 'Europe', '151', 'Eastern Europe', 'pl', '^\d{2}-\d{3}$'],
        ['PM', 'SPM', '666', 'EUR', 'Euro', '508', 'Saint Pierre and Miquelon', 'Saint-Pierre', '.pm', 'AM', '019', 'Americas', '021', 'Northern America', 'fr-PM', '^(97500)$'],
        ['PN', 'PCN', '612', 'NZD', 'New Zealand Dollar', '870', 'Pitcairn', 'Adamstown', '.pn', 'OC', '009', 'Oceania', '061', 'Polynesia', 'en-PN', ''],
        ['PR', 'PRI', '630', 'USD', 'US Dollar', '+1-787 and 1-939', 'Puerto Rico', 'San Juan', '.pr', 'AM', '019', 'Americas', '029', 'Caribbean', 'en-PR,es-PR', '^00[679]\d{2}(?:-\d{4})?$'],
        ['PS', 'PSE', '275', 'ILS', 'New Israeli Sheqel', '970', 'Palestinian Territory', 'East Jerusalem', '.ps', 'AS', '142', 'Asia', '', '', 'ar-PS', ''],
        ['PT', 'PRT', '620', 'EUR', 'Euro', '351', 'Portugal', 'Lisbon', '.pt', 'EU', '150', 'Europe', '039', 'Southern Europe', 'pt-PT,mwl', '^\d{4}-\d{3}\s?[a-zA-Z]{0,25}$'],
        ['PW', 'PLW', '585', 'USD', 'US Dollar', '680', 'Palau', 'Melekeok', '.pw', 'OC', '009', 'Oceania', '057', 'Micronesia', 'pau,sov,en-PW,tox,ja,fil,zh', '^(96940)$'],
        ['PY', 'PRY', '600', 'PYG', 'Guarani', '595', 'Paraguay', 'Asuncion', '.py', 'AM', '019', 'Americas', '005', 'South America', 'es-PY,gn', '^(\d{4})$'],
        ['QA', 'QAT', '634', 'QAR', 'Qatari Rial', '974', 'Qatar', 'Doha', '.qa', 'AS', '142', 'Asia', '145', 'Western Asia', 'ar-QA,es', ''],
        ['RE', 'REU', '638', 'EUR', 'Euro', '262', 'Reunion', 'Saint-Denis', '.re', 'AF', '002', 'Africa', '014', 'Eastern Africa', 'fr-RE', '^((97|98)(4|7|8)\d{2})$'],
        ['RO', 'ROU', '642', 'RON', 'Romanian Leu', '40', 'Romania', 'Bucharest', '.ro', 'EU', '150', 'Europe', '151', 'Eastern Europe', 'ro,hu,rom', '^(\d{6})$'],
        ['RS', 'SRB', '688', 'RSD', 'Serbian Dinar', '381', 'Serbia', 'Belgrade', '.rs', 'EU', '150', 'Europe', '039', 'Southern Europe', 'sr,hu,bs,rom', '^(\d{6})$'],
        ['RU', 'RUS', '643', 'RUB', 'Russian Ruble', '7', 'Russia', 'Moscow', '.ru', 'EU', '150', 'Europe', '151', 'Eastern Europe', 'ru,tt,xal,cau,ady,kv,ce,tyv,cv,udm,tut,mns,bua,myv,mdf,chm,ba,inh,tut,kbd,krc,ava,sah,nog', '^(\d{6})$'],
        ['RW', 'RWA', '646', 'RWF', 'Rwanda Franc', '250', 'Rwanda', 'Kigali', '.rw', 'AF', '002', 'Africa', '014', 'Eastern Africa', 'rw,en-RW,fr-RW,sw', ''],
        ['AM', 'SAU', '682', 'SAR', 'Saudi Riyal', '966', 'Saudi Arabia', 'Riyadh', '.sa', 'AS', '142', 'Asia', '145', 'Western Asia', 'ar-AM', '^(\d{5})$'],
        ['SB', 'SLB', '090', 'SBD', 'Solomon Islands Dollar', '677', 'Solomon Islands', 'Honiara', '.sb', 'OC', '009', 'Oceania', '054', 'Melanesia', 'en-SB,tpi', ''],
        ['SC', 'SYC', '690', 'SCR', 'Seychelles Rupee', '248', 'Seychelles', 'Victoria', '.sc', 'AF', '002', 'Africa', '014', 'Eastern Africa', 'en-SC,fr-SC', ''],
        ['SD', 'SDN', '729', 'SDG', 'Sudanese Pound', '249', 'Sudan', 'Khartoum', '.sd', 'AF', '002', 'Africa', '015', 'Northern Africa', 'ar-SD,en,fia', '^(\d{5})$'],
        ['SE', 'SWE', '752', 'SEK', 'Swedish Krona', '46', 'Sweden', 'Stockholm', '.se', 'EU', '150', 'Europe', '154', 'Northern Europe', 'sv-SE,se,sma,fi-SE', '^(?:SE)?\d{3}\s\d{2}$'],
        ['SG', 'SGP', '702', 'SGD', 'Singapore Dollar', '65', 'Singapore', 'Singapore', '.sg', 'AS', '142', 'Asia', '035', 'South-Eastern Asia', 'cmn,en-SG,ms-SG,ta-SG,zh-SG', '^(\d{6})$'],
        ['SH', 'SHN', '654', 'SHP', 'Saint Helena Pound', '290', 'Saint Helena', 'Jamestown', '.sh', 'AF', '002', 'Africa', '', '', 'en-SH', '^(STHL1ZZ)$'],
        ['SI', 'SVN', '705', 'EUR', 'Euro', '386', 'Slovenia', 'Ljubljana', '.si', 'EU', '150', 'Europe', '039', 'Southern Europe', 'sl,sh', '^(?:SI)*(\d{4})$'],
        ['SJ', 'SJM', '744', 'NOK', 'Norwegian Krone', '47', 'Svalbard and Jan Mayen', 'Longyearbyen', '.sj', 'EU', '150', 'Europe', '154', 'Northern Europe', 'no,ru', ''],
        ['SK', 'SVK', '703', 'EUR', 'Euro', '421', 'Slovakia', 'Bratislava', '.sk', 'EU', '150', 'Europe', '151', 'Eastern Europe', 'sk,hu', '^\d{3}\s?\d{2}$'],
        ['SL', 'SLE', '694', 'SLL', 'Leone', '232', 'Sierra Leone', 'Freetown', '.sl', 'AF', '002', 'Africa', '011', 'Western Africa', 'en-SL,men,tem', ''],
        ['SM', 'SMR', '674', 'EUR', 'Euro', '378', 'San Marino', 'San Marino', '.sm', 'EU', '150', 'Europe', '039', 'Southern Europe', 'it-SM', '^(4789\d)$'],
        ['SN', 'SEN', '686', 'XOF', 'CFA Franc BCEAO', '221', 'Senegal', 'Dakar', '.sn', 'AF', '002', 'Africa', '011', 'Western Africa', 'fr-SN,wo,fuc,mnk', '^(\d{5})$'],
        ['SO', 'SOM', '706', 'SOS', 'Somali Shilling', '252', 'Somalia', 'Mogadishu', '.so', 'AF', '002', 'Africa', '014', 'Eastern Africa', 'so-SO,ar-SO,it,en-SO', '^([A-Z]{2}\d{5})$'],
        ['SR', 'SUR', '740', 'SRD', 'Surinam Dollar', '597', 'Suriname', 'Paramaribo', '.sr', 'AM', '019', 'Americas', '005', 'South America', 'nl-SR,en,srn,hns,jv', ''],
        ['SS', 'SSD', '728', 'SSP', 'South Sudanese Pound', '211', 'South Sudan', 'Juba', '', 'AF', '002', 'Africa', '014', 'Eastern Africa', 'en', ''],
        ['ST', 'STP', '678', 'STD', 'Dobra', '239', 'Sao Tome and Principe', 'Sao Tome', '.st', 'AF', '002', 'Africa', '017', 'Middle Africa', 'pt-ST', ''],
        ['SV', 'SLV', '222', 'USD', 'US Dollar', '503', 'El Salvador', 'San Salvador', '.sv', 'AM', '019', 'Americas', '013', 'Central America', 'es-SV', '^(?:CP)*(\d{4})$'],
        ['SX', 'SXM', '534', 'ANG', 'Netherlands Antillean Guilder', '599', 'Sint Maarten', 'Philipsburg', '.sx', 'AM', '019', 'Americas', '029', 'Caribbean', 'nl,en', ''],
        ['SY', 'SYR', '760', 'SYP', 'Syrian Pound', '963', 'Syria', 'Damascus', '.sy', 'AS', '142', 'Asia', '145', 'Western Asia', 'ar-SY,ku,hy,arc,fr,en', ''],
        ['SZ', 'SWZ', '748', 'SZL', 'Lilangeni', '268', 'Swaziland', 'Mbabane', '.sz', 'AF', '002', 'Africa', '018', 'Southern Africa', 'en-SZ,ss-SZ', '^([A-Z]\d{3})$'],
        ['TC', 'TCA', '796', 'USD', 'US Dollar', '+1-649', 'Turks and Caicos Islands', 'Cockburn Town', '.tc', 'AM', '019', 'Americas', '029', 'Caribbean', 'en-TC', '^(TKCA 1ZZ)$'],
        ['TD', 'TCD', '148', 'XAF', 'CFA Franc BEAC', '235', 'Chad', 'N\'Djamena', '.td', 'AF', '002', 'Africa', '017', 'Middle Africa', 'fr-TD,ar-TD,sre', ''],
        ['TF', 'ATF', '260', 'EUR', 'Euro', '', 'French Southern Territories', 'Port-aux-Francais', '.tf', 'AN', '', '', '', '', 'fr', ''],
        ['TG', 'TGO', '768', 'XOF', 'CFA Franc BCEAO', '228', 'Togo', 'Lome', '.tg', 'AF', '002', 'Africa', '011', 'Western Africa', 'fr-TG,ee,hna,kbp,dag,ha', ''],
        ['TH', 'THA', '764', 'THB', 'Baht', '66', 'Thailand', 'Bangkok', '.th', 'AS', '142', 'Asia', '035', 'South-Eastern Asia', 'th,en', '^(\d{5})$'],
        ['TJ', 'TJK', '762', 'TJS', 'Somoni', '992', 'Tajikistan', 'Dushanbe', '.tj', 'AS', '142', 'Asia', '143', 'Central Asia', 'tg,ru', '^(\d{6})$'],
        ['TK', 'TKL', '772', 'NZD', 'New Zealand Dollar', '690', 'Tokelau', '', '.tk', 'OC', '009', 'Oceania', '061', 'Polynesia', 'tkl,en-TK', ''],
        ['TL', 'TLS', '626', 'USD', 'US Dollar', '670', 'East Timor', 'Dili', '.tl', 'OC', '142', 'Asia', '035', 'South-Eastern Asia', 'tet,pt-TL,id,en', ''],
        ['TM', 'TKM', '795', 'TMT', 'Turkmenistan New Manat', '993', 'Turkmenistan', 'Ashgabat', '.tm', 'AS', '142', 'Asia', '143', 'Central Asia', 'tk,ru,uz', '^(\d{6})$'],
        ['TN', 'TUN', '788', 'TND', 'Tunisian Dinar', '216', 'Tunisia', 'Tunis', '.tn', 'AF', '002', 'Africa', '015', 'Northern Africa', 'ar-TN,fr', '^(\d{4})$'],
        ['TO', 'TON', '776', 'TOP', 'Paʻanga', '676', 'Tonga', 'Nuku\'alofa', '.to', 'OC', '009', 'Oceania', '061', 'Polynesia', 'to,en-TO', ''],
        ['TR', 'TUR', '792', 'TRY', 'Turkish Lira', '90', 'Turkey', 'Ankara', '.tr', 'AS', '142', 'Asia', '145', 'Western Asia', 'tr-TR,ku,diq,az,av', '^(\d{5})$'],
        ['TT', 'TTO', '780', 'TTD', 'Trinidad and Tobago Dollar', '+1-868', 'Trinidad and Tobago', 'Port of Spain', '.tt', 'AM', '019', 'Americas', '029', 'Caribbean', 'en-TT,hns,fr,es,zh', ''],
        ['TV', 'TUV', '798', 'AUD', 'Australian Dollar', '688', 'Tuvalu', 'Funafuti', '.tv', 'OC', '009', 'Oceania', '061', 'Polynesia', 'tvl,en,sm,gil', ''],
        ['TW', 'TWN', '158', 'TWD', 'New Taiwan Dollar', '886', 'Taiwan', 'Taipei', '.tw', 'AS', '142', 'Asia', '', '', 'zh-TW,zh,nan,hak', '^(\d{5})$'],
        ['TZ', 'TZA', '834', 'TZS', 'Tanzanian Shilling', '255', 'Tanzania', 'Dodoma', '.tz', 'AF', '002', 'Africa', '', '', 'sw-TZ,en,ar', ''],
        ['UA', 'UKR', '804', 'UAH', 'Hryvnia', '380', 'Ukraine', 'Kiev', '.ua', 'EU', '150', 'Europe', '151', 'Eastern Europe', 'uk,ru-UA,rom,pl,hu', '^(\d{5})$'],
        ['UG', 'UGA', '800', 'UGX', 'Uganda Shilling', '256', 'Uganda', 'Kampala', '.ug', 'AF', '002', 'Africa', '014', 'Eastern Africa', 'en-UG,lg,sw,ar', ''],
        ['UM', 'UMI', '581', 'USD', 'US Dollar', '1', 'United States Minor Outlying Islands', '', '.um', 'OC', '009', 'Oceania', '', '', 'en-UM', ''],
        ['US', 'USA', '840', 'USD', 'US Dollar', '1', 'United States', 'Washington', '.us', 'AM', '019', 'Americas', '021', 'Northern America', 'en-US,es-US,haw,fr', '^\d{5}(-\d{4})?$'],
        ['UY', 'URY', '858', 'UYU', 'Peso Uruguayo', '598', 'Uruguay', 'Montevideo', '.uy', 'AM', '019', 'Americas', '005', 'South America', 'es-UY', '^(\d{5})$'],
        ['UZ', 'UZB', '860', 'UZS', 'Uzbekistan Sum', '998', 'Uzbekistan', 'Tashkent', '.uz', 'AS', '142', 'Asia', '143', 'Central Asia', 'uz,ru,tg', '^(\d{6})$'],
        ['VA', 'VAT', '336', 'EUR', 'Euro', '379', 'Vatican', 'Vatican City', '.va', 'EU', '150', 'Europe', '039', 'Southern Europe', 'la,it,fr', '^(\d{5})$'],
        ['VC', 'VCT', '670', 'XCD', 'East Caribbean Dollar', '+1-784', 'Saint Vincent and the Grenadines', 'Kingstown', '.vc', 'AM', '019', 'Americas', '029', 'Caribbean', 'en-VC,fr', ''],
        ['VE', 'VEN', '862', 'VEF', 'Bolivar', '58', 'Venezuela (Bolivarian Republic of)', 'Caracas', '.ve', 'AM', '019', 'Americas', '005', 'South America', 'es-VE', '^(\d{4})$'],
        ['VG', 'VGB', '092', 'USD', 'US Dollar', '+1-284', 'Virgin Islands (British)', 'Road Town', '.vg', 'AM', '019', 'Americas', '029', 'Caribbean', 'en-VG', ''],
        ['VI', 'VIR', '850', 'USD', 'US Dollar', '+1-340', 'Virgin Islands (U.S.)', 'Charlotte Amalie', '.vi', 'AM', '019', 'Americas', '029', 'Caribbean', 'en-VI', '^008\d{2}(?:-\d{4})?$'],
        ['VN', 'VNM', '704', 'VND', 'Dong', '84', 'Vietnam', 'Hanoi', '.vn', 'AS', '142', 'Asia', '035', 'South-Eastern Asia', 'vi,en,fr,zh,km', '^(\d{6})$'],
        ['VU', 'VUT', '548', 'VUV', 'Vatu', '678', 'Vanuatu', 'Port Vila', '.vu', 'OC', '009', 'Oceania', '054', 'Melanesia', 'bi,en-VU,fr-VU', ''],
        ['WF', 'WLF', '876', 'XPF', 'CFP Franc', '681', 'Wallis and Futuna', 'Mata Utu', '.wf', 'OC', '009', 'Oceania', '061', 'Polynesia', 'wls,fud,fr-WF', '^(986\d{2})$'],
        ['WS', 'WSM', '882', 'WST', 'Tala', '685', 'Samoa', 'Apia', '.ws', 'OC', '009', 'Oceania', '061', 'Polynesia', 'sm,en-WS', ''],
        ['XK', 'XKX', '0', 'EUR', 'Euro', '', 'Kosovo', 'Pristina', '', 'EU', '150', 'Europe', '', '', 'sq,sr', ''],
        ['YE', 'YEM', '887', 'YER', 'Yemeni Rial', '967', 'Yemen', 'Sanaa', '.ye', 'AS', '142', 'Asia', '145', 'Western Asia', 'ar-YE', ''],
        ['YT', 'MYT', '175', 'EUR', 'Euro', '262', 'Mayotte', 'Mamoudzou', '.yt', 'AF', '002', 'Africa', '014', 'Eastern Africa', 'fr-YT', '^(\d{5})$'],
        ['ZA', 'ZAF', '710', 'ZAR', 'Rand', '27', 'South Africa', 'Pretoria', '.za', 'AF', '002', 'Africa', '018', 'Southern Africa', 'zu,xh,af,nso,en-ZA,tn,st,ts,ss,ve,nr', '^(\d{4})$'],
        ['ZM', 'ZMB', '894', 'ZMW', 'Zambian Kwacha', '260', 'Zambia', 'Lusaka', '.zm', 'AF', '002', 'Africa', '014', 'Eastern Africa', 'en-ZM,bem,loz,lun,lue,ny,toi', '^(\d{5})$'],
        ['ZW', 'ZWE', '716', 'ZWL', 'Zimbabwe Dollar', '263', 'Zimbabwe', 'Harare', '.zw', 'AF', '002', 'Africa', '014', 'Eastern Africa', 'en-ZW,sn,nr,nd', '']
    ];

    /**
     * IrivenPHPCountriesUtil constructor.
     * @param array $DataSets
     */
    public function __construct(array $DataSets = [])
    {
        if ($DataSets)
            $this->KnowledgeBase = $DataSets;
    }
    /**
     * @return array
     */
    public function all()
    {
        return $this->KnowledgeBase;
    }

    /**
     * @param $IsoFormat
     * @return \Generator
     * @throws \Exception
     */
    public function iterator($IsoFormat = self::ALPHA2)
    {
        $IsoFormat = $this->setISOFormat($IsoFormat);
        if (!in_array($IsoFormat, $this->keys, true))
            throw new \Exception(sprintf('Invalid value for $indexBy, got "%s", expected one of: %s',$IsoFormat,implode(', ', $this->keys)));
        foreach ($this->KnowledgeBase as $country)
            yield $country[$IsoFormat] => $country;
    }

    /**
     * @return mixed
     */
    public function count()
    {
        return count($this->KnowledgeBase);
    }

    /**
     * @return \Generator
     */
    public function getIterator()
    {
        foreach ($this->KnowledgeBase as $country)
            yield $country;
    }

    /**
     * @param $IsoFormat
     * @return string
     */
    private function setISOFormat($IsoFormat)
    {
            $IsoFormat = trim(strtolower($IsoFormat));
            switch($IsoFormat):
                case 'alpha-3':
                case 'alpha3':
                case 'iso-3':
                case 'iso3':
                    $IsoFormat = self::ALPHA3;
                    break;
                case 'alpha-2':
                case 'alpha2':
                case 'iso-2':
                case 'iso2':
                    $IsoFormat = self::ALPHA2;
                    break;
                case 'numeric':
                case 'num':
                    $IsoFormat = self::NUMERIC;
                    break;
                default:
                    in_array($IsoFormat,[self::ALPHA2,self::ALPHA3,self::NUMERIC]) OR $IsoFormat = self::ALPHA2;
                    break;
            endswitch;

        return $IsoFormat;
    }
    /**
     * @param $IsoFormat
     * @param $value
     * @return mixed
     * @throws \Exception
     */
    private function lookup($IsoFormat, $value)
    {
        $IsoFormat = $this->setISOFormat($IsoFormat);
        foreach ($this->KnowledgeBase as $country)
        {
            if (0 === strcasecmp($value, $country[$IsoFormat]))
                return $country;
        }
        if(is_numeric($IsoFormat))
        {
            switch($IsoFormat):
                case '2':
                    $IsoFormat = 'numeric';
                    break;
                default:
                    $IsoFormat = ($IsoFormat == 1)? 'alpha3':'alpha2' ;
                    break;
            endswitch;
        }
        throw new \Exception(sprintf('No "%s" key found matching: %s', $IsoFormat, $value) );
    }

    /**
     * @return array
     */
    private function getAvailableHeaders()
    {
        $oClass = new \ReflectionClass(__CLASS__);
        $res = $oClass->getConstants();
        return array_map('strtolower',array_values(array_flip($res)));
    }
    /**
     * Retrieve datas for given country ISO-3166-2 , ISO-3166-3 or numeric code
     * <code>
     *      Example:  For France
     *      $myObject->getCountryInfos('fr');
     *      $myObject->getCountryInfos('fr', true);
     *      $myObject->getCountryInfos('FR');
     *      $myObject->getCountryInfos('fra');
     *      $myObject->getCountryInfos('FRA');
     *      $myObject->getCountryInfos('FRA', true);
     *      $myObject->getCountryInfos('250');
     *      $myObject->getCountryInfos('250', true);
     * </code>
     *
     * @param $IsoCode
     * @param bool|false $dataOnly
     * @return array|mixed
     * @throws \Exception
     */
    public function getCountryInfos($IsoCode,$dataOnly=false)
    {
        if (!is_string($IsoCode))
            throw new \InvalidArgumentException(sprintf('Expected $IsoCode to be of type string, got: %s', gettype($IsoCode)));
        switch($IsoCode):
            case (is_numeric($IsoCode)):
                if (!preg_match('/^[0-9]{3}$/', $IsoCode))
                    throw new \Exception( sprintf('Not a valid numeric country key: %s', $IsoCode) );
                $IsoFormat = self::NUMERIC;
                break;
            default:
                if (!preg_match('/^[a-zA-Z]{2,3}$/', $IsoCode))
                    throw new \Exception( sprintf('Not a valid alpha2 or alpha3 country key: %s', $IsoCode) );
                $IsoFormat = (strlen($IsoCode) == 2)? self::ALPHA2 : self::ALPHA3;
                break;
        endswitch;
        $datas = array_map(function($a){if(!empty($a)) return $a; return 'n/a';},$this->lookup($IsoFormat, $IsoCode));
        if($dataOnly) return $datas;
        $Headers = $this->getAvailableHeaders();
        return array_combine($Headers,$datas);
    }

    /**
     * Get country ISO-3166-2 code for given ISO-3166-3 or numeric code
     * <code>
     *      Example:  For France
     *      $myObject->getCountryAlpha2Code('fra');
     *      $myObject->getCountryAlpha2Code('FRA');
     *      $myObject->getCountryAlpha2Code('250');
     * </code>
     *
     * @param $IsoCode
     * @return string
     * @throws \Exception
     */
    public function getCountryAlpha2Code($IsoCode)
    {
        if($countryDatas = $this->getCountryInfos($IsoCode,true))
            return $countryDatas[self::ALPHA2];
        return 'n/a';
    }

    /**
     * Get country ISO-3166-3 code for given ISO-3166-2 or numeric code
     * <code>
     *      Example:  For France
     *      $myObject->getCountryAlpha3Code('fr');
     *      $myObject->getCountryAlpha3Code('FR');
     *      $myObject->getCountryAlpha3Code('250');
     * </code>
     *
     * @param $IsoCode
     * @return string
     * @throws \Exception
     */
    public function getCountryAlpha3Code($IsoCode)
    {
        if($countryDatas = $this->getCountryInfos($IsoCode,true))
            return $countryDatas[self::ALPHA3];
        return 'n/a';
    }
    /**
     * Get country numeric code for given ISO-3166-2 or ISO-3166-3 code
     * <code>
     *      Example:  For France
     *      $myObject->getCountryNumericCode('fra');
     *      $myObject->getCountryNumericCode('FRA');
     *      $myObject->getCountryNumericCode('fr');
     *      $myObject->getCountryNumericCode('FR');
     * </code>
     *
     * @param $IsoCode
     * @return string
     * @throws \Exception
     */
    public function getCountryNumericCode($IsoCode)
    {
        if($countryDatas = $this->getCountryInfos($IsoCode,true))
            return $countryDatas[self::NUMERIC];
        return 'n/a';
    }
    /**
     * Get country Currency Code from given alpha-2, alpha-3 or numeric code
     * <code>
     *      Example:  For France
     *      $myObject->getCountryCurrencyCode('fra');
     *      $myObject->getCountryCurrencyCode('fr');
     *      $myObject->getCountryCurrencyCode('250');
     * </code>
     *
     * @param $IsoCode
     * @return string
     * @throws \Exception
     */
    public function getCountryCurrencyCode($IsoCode)
    {
        if($countryDatas = $this->getCountryInfos($IsoCode,true))
            return $countryDatas[self::CURRENCY_CODE];
        return 'n/a';
    }
    /**
     * Get country Currency Name from given alpha-2, alpha-3 or numeric code
     * <code>
     *      Example:  For France
     *      $myObject->getCountryCurrencyName('fra');
     *      $myObject->getCountryCurrencyName('fr');
     *      $myObject->getCountryCurrencyName('250');
     * </code>
     *
     * @param $IsoCode
     * @return string
     * @throws \Exception
     */
    public function getCountryCurrencyName($IsoCode)
    {
        if($countryDatas = $this->getCountryInfos($IsoCode,true))
            return $countryDatas[self::CURRENCY_NAME];
        return 'n/a';
    }
    /**
     * Get country Phone Code (ISD) from given alpha-2, alpha-3 or numeric code
     * <code>
     *      Example:  For France
     *      $myObject->getCountryPhoneCode('fra');
     *      $myObject->getCountryPhoneCode('fr');
     *      $myObject->getCountryPhoneCode('250');
     * </code>
     *
     * @param $IsoCode
     * @return string
     * @throws \Exception
     */
    public function getCountryPhoneCode($IsoCode)
    {
        if($countryDatas = $this->getCountryInfos($IsoCode,true))
            return $countryDatas[self::PHONE_CODE];
        return 'n/a';
    }
    /**
     * Get country Name from given alpha-2, alpha-3 or numeric code
     * <code>
     *      Example:  For France
     *      $myObject->getCountryName('fra');
     *      $myObject->getCountryName('fr');
     *      $myObject->getCountryName('250');
     * </code>
     *
     * @param $IsoCode
     * @return string
     * @throws \Exception
     */
    public function getCountryName($IsoCode)
    {
        if($countryDatas = $this->getCountryInfos($IsoCode,true))
            return $countryDatas[self::COUNTRY];
        return 'n/a';
    }
    /**
     * Get Country Capital name from given alpha-2, alpha-3 or numeric code
     * <code>
     *      Example:  For France
     *      $myObject->getCountryCapitalName('fra');
     *      $myObject->getCountryCapitalName('fr');
     *      $myObject->getCountryCapitalName('250');
     * </code>
     *
     * @param $IsoCode
     * @return string
     * @throws \Exception
     */
    public function getCountryCapitalName($IsoCode)
    {
        if($countryDatas = $this->getCountryInfos($IsoCode,true))
            return $countryDatas[self::CAPITAL];
        return 'n/a';
    }
    /**
     * Get the Top Level Domain(TLD) of a Country  from given alpha-2, alpha-3 or numeric code
     * <code>
     *      Example:  For France
     *      $myObject->getCountryDomain('fra');
     *      $myObject->getCountryDomain('fr');
     *      $myObject->getCountryDomain('250');
     * </code>
     *
     * @param $IsoCode
     * @return string
     * @throws \Exception
     */
    public function getCountryDomain($IsoCode)
    {
        if($countryDatas = $this->getCountryInfos($IsoCode,true))
            return $countryDatas[self::TLD];
        return 'n/a';
    }
    /**
     * Get Country two letters Continent code from given alpha-2, alpha-3 or numeric code
     * <code>
     *      Example:  For France
     *      $myObject->getCountryRegionAlphaCode('fra');
     *      $myObject->getCountryRegionAlphaCode('fr');
     *      $myObject->getCountryRegionAlphaCode('250');
     * </code>
     *
     * @param $IsoCode
     * @return string
     * @throws \Exception
     */
    public function getCountryRegionAlphaCode($IsoCode)
    {
        if($countryDatas = $this->getCountryInfos($IsoCode,true))
            return $countryDatas[self::REGION_ALPHA_CODE];
        return 'n/a';
    }
    /**
     * Get Country Continent ISO code from given alpha-2, alpha-3 or numeric code
     * <code>
     *      Example:  For France
     *      $myObject->getCountryRegionNumCode('fra');
     *      $myObject->getCountryRegionNumCode('fr');
     *      $myObject->getCountryRegionNumCode('250');
     * </code>
     *
     * @param $IsoCode
     * @return string
     * @throws \Exception
     */
    public function getCountryRegionNumCode($IsoCode)
    {
        if($countryDatas = $this->getCountryInfos($IsoCode,true))
            return $countryDatas[self::REGION_NUM_CODE];
        return 'n/a';
    }
    /**
     * Get Country Continent Name from given alpha-2, alpha-3 or numeric code
     * <code>
     *      Example:  For France
     *      $myObject->getCountryRegionName('fra');
     *      $myObject->getCountryRegionName('fr');
     *      $myObject->getCountryRegionName('250');
     * </code>
     *
     * @param $IsoCode
     * @return string
     * @throws \Exception
     */
    public function getCountryRegionName($IsoCode)
    {
        if($countryDatas = $this->getCountryInfos($IsoCode,true))
            return $countryDatas[self::REGION];
        return 'n/a';
    }
    /**
     * Get Country Sub-region ISO code from given alpha-2, alpha-3 or numeric code
     * <code>
     *      Example:  For France
     *      $myObject->getCountrySubRegionCode('fra');
     *      $myObject->getCountrySubRegionCode('fr');
     *      $myObject->getCountrySubRegionCode('250');
     * </code>
     *
     * @param $IsoCode
     * @return string
     * @throws \Exception
     */
    public function getCountrySubRegionCode($IsoCode)
    {
        if($countryDatas = $this->getCountryInfos($IsoCode,true))
            return $countryDatas[self::SUB_REGION_CODE];
        return 'n/a';
    }
    /**
     * Get Country Continent ISO code from given alpha-2, alpha-3 or numeric code
     * <code>
     *      Example:  For France
     *      $myObject->getCountryRegionNumCode('fra');
     *      $myObject->getCountryRegionNumCode('fr');
     *      $myObject->getCountryRegionNumCode('250');
     * </code>
     *
     * @param $IsoCode
     * @return string
     * @throws \Exception
     */
    public function getCountrySubRegionName($IsoCode)
    {
        if($countryDatas = $this->getCountryInfos($IsoCode,true))
            return $countryDatas[self::SUB_REGION];
        return 'n/a';
    }
    /**
     * Get Languages (code) spoken in a Country  from given alpha-2, alpha-3 or numeric code
     * <code>
     *      Example:  For France
     *      $myObject->getCountryLanguage('fra');
     *      $myObject->getCountryLanguage('fr');
     *      $myObject->getCountryLanguage('250');
     * </code>
     *
     * @param $IsoCode
     * @return string
     * @throws \Exception
     */
    public function getCountryLanguage($IsoCode)
    {
        if($countryDatas = $this->getCountryInfos($IsoCode,true))
            return $countryDatas[self::LANGUAGE];
        return 'n/a';
    }

    /**
     * Get a Country postal code Regex  from given alpha-2, alpha-3 or numeric code
     * <code>
     *      Example:  For France
     *      $myObject->getCountryPostalCodePattern('fra');
     *      $myObject->getCountryPostalCodePattern('fr');
     *      $myObject->getCountryPostalCodePattern('250');
     * </code>
     *
     * @param $IsoCode
     * @return string
     * @throws \Exception
     */
    public function getCountryPostalCodePattern($IsoCode)
    {
        if($countryDatas = $this->getCountryInfos($IsoCode,true))
            return $countryDatas[self::POSTAL_CODE_REGEX];
        return 'n/a';
    }
    /**
     * return an associative [$code=>$name] array of all Currencies.
     *
     * @return array
     * @throws \Exception
     */
    public function getAllCurrenciesCodeAndName()
    {
        $DataSets = $this->iterator();
        $output = [];
        foreach ($DataSets as $datas)
        {
            if(!$datas[self::CURRENCY_CODE]) continue;
            isset($output[$datas[self::CURRENCY_CODE]]) or
            $output[$datas[self::CURRENCY_CODE]] = $datas[self::CURRENCY_NAME];
        }
        asort($output);
        return $output;
    }
    /**
     * return an associative array of ISO-2, ISO-3 or numeric list of countries.
     *
     * @param int|string $IsoFormat values [ 0|alpha-2|alpha2|iso-2|iso2 , 1|alpha-3|alpha3|iso-3|iso3 , 2|num|numeric ]
     * @return array
     * @throws \Exception
     */
    public function getAllCountriesCodeAndName($IsoFormat=self::ALPHA2){
        $DataSets = $this->iterator($IsoFormat);
        $output = [];
        foreach ($DataSets as $country)
            $output[$country[$IsoFormat]] = $country[self::COUNTRY];
        asort($output);
        return $output;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getAllRegionsCodeAndName()
    {
        $DataSets = $this->iterator();
        $output = [];
        foreach ($DataSets as $datas)
        {
            if(!$datas[self::REGION_NUM_CODE]) continue;
            isset($output[$datas[self::REGION_NUM_CODE]]) or
            $output[$datas[self::REGION_NUM_CODE]] = $datas[self::REGION];
        }
        asort($output);
        return $output;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getAllCountriesGroupedByRegions()
    {
        $DataSets = $this->iterator();
        $output = [];
        foreach ($DataSets as $datas)
        {
            if(!$datas[self::REGION]) continue;
            isset($output[$datas[self::REGION]][$datas[self::ALPHA2]]) or
            $output[$datas[self::REGION]][$datas[self::ALPHA2]] = $datas[self::COUNTRY];
        }
        asort($output);
        return $output;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getAllCountriesGroupedByCurrencies()
    {
        $DataSets = $this->iterator();
        $output = [];
        foreach ($DataSets as $datas)
        {
            if(!$datas[self::CURRENCY_CODE]) continue;
            isset($output[$datas[self::CURRENCY_CODE]][$datas[self::ALPHA2]]) or
            $output[$datas[self::CURRENCY_CODE]][$datas[self::ALPHA2]] = $datas[self::COUNTRY];
        }
        asort($output);
        return $output;
    }
}
