<?php
class GeoNames {

    const API_URL = 'http://api.geonames.org';
    const PARAM_LATITUDE = 'lat';
    const PARAM_LONGITUDE = 'lng';
    const PARAM_MAX_ROWS = 'maxRows';
    const PARAM_POSTALCODE = 'postalcode';
    const PARAM_PLACENAME = 'placename';
    const PARAM_PLACENAME_STARTS_WITH = 'placename_startsWith';
    const PARAM_COUNTRY = 'country';
    const PARAM_COUNTRY_BIAS = 'countryBias';
    const PARAM_STYLE = 'style';
    const PARAM_OPERATOR = 'operator';
    const PARAM_CHARSEST = 'charset';
    const PARAM_IS_REDUCED = 'isReduced';

    const RESPONSE_JSON = 'JSON';

    private $_username;
    private $_response_type;

    protected static $_web_service_methods = array(
        'postalCodeLookup',
        'findNearbyPostalCodes',
        'postalCodeCountryInfo',
        'findNearbyPlaceName',
        'findNearby',
        'extendedFindNearby',
        'astergdem',
        'children',
        'cities',
        'countryCode',
        'countryInfo',
        'countrySubdivision',
        'earthquakes',
        'findNearestAddress',
        'findNearestIntersection',
        'findNearbyStreets',
        'findNearbyStreetsOSM',
        'findNearbyWeather',
        'findNearbyWikipedia',
        'findNearestIntersectionOSM',
        'findNearbyPOIsOSM',
        'get',
        'gtopo30',
        'hierarchy',
        'neighbourhood',
        'neighbours',
        'ocean',
        'postalCodeSearch',
        'rssToGeo',
        'serach',
        'siblings',
        'srtm3',
        'timezone',
        'weather',
        'weatherIcao',
        'wikipediaBoundingBox',
        'wikipediaSearch'
    );

    public function __construct($username, $response_type = null) {
        $this->_username = $username;
        $this->_response_type = $response_type;
    } 

    public function __call($method, array $params = array(  ))
    {
        if (in_array($method, self::$_web_service_methods)) {
            $url = self::API_URL . '/' . $method . $this->_response_type . '?' . $this->_buildURLParams($params) . 'username=paulsimoneschi';
            return $this->_request($url);
        }
    }

    /**
     * Recursive function for building URL params.  
     *
     * @param array $params
     * @return array $parameters the url parameters
     */
    protected function _buildURLParams(array $params)
    {
        $parameters = null;
        foreach ($params as $param => $value) {
            if (is_array($value)) {
                $parameters .= $this->_buildURLParams($value);
            }
            else {
                $parameters .= $param . '=' . urlencode($value) . '&';
            }
        }

        return $parameters;
    }

    protected function _request($url, $method = 'GET')
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    public function setResponseType($response_type)
    {
        $this->_response_type = $response_type;
    }
}