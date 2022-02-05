<?php
/**
 * @package Distance
 * @license GPL
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @uses Distance calculating Class, using Google Maps API for getting Latitude and Longitude. Distance calculation based on the Haversine Formula
 * @author      Csanad Novak <csanad@novak.net.nz>
 * @copyright Csanad Novak <http://csanad.novak.net.nz>
 * @version 1.0
 * @since 10.2011
 */

class Distance
{

    private $earthRadiusinKM = 6371.00; # in km
    private $earthRadiusinMiles = 3960.00; # in miles

    private $dLatitude = "";
    private $dLongitude = "";

    public $firstCoordinates = array();
    public $secondCoordinates = array();

    public $resultArray = array();


    public function setEarthRadius($metric = 'km')
    {
        if ($metric != 'km') {
            $this->earthRadius = $this->earthRadiusinMiles;

        } else {

            $this->earthRadius = $this->earthRadiusinKM;
        }
    }

    /**
     * @method Calculating distance between two address
     * @access public
     * @param      $address1 is string passed to the Google Maps API Geocoding endpoint
     * @param      $address2 is string passed to the Google Maps API Geocoding endpoint
     * @return string, contains the distance in km.
     */
    public function distance_two_point($address1, $address2)
    {
        $this->firstCoordinates = $this->getAddressCoordinates($address1);
        $this->firstLatitude = $this->firstCoordinates[1];
        $this->firstLongitude = $this->firstCoordinates[0];

        $this->secondCoordinates = $this->getAddressCoordinates($address2);
        $this->secondLatitude = $this->secondCoordinates[1];
        $this->secondLongitude = $this->secondCoordinates[0];

        $this->resultDistance = $this->distance_haversine($this->firstLatitude, $this->firstLongitude, $this->secondLatitude, $this->secondLongitude);

        return $this->resultDistance;
    }

    /**
     * @method Retriving geo coordinates for an address
     * @access public
     * @param      $address is string passed to the Google Maps API Geocoding endpoint
     * @return array. First element [0] is longitude, the second element [1] is the latitude
     */
    public function getAddressCoordinates($address)
    {
        if (!is_string($address)) {
            die ("All Addresses must be passed as a string");
        }

        $apiURL = "http://maps.google.com/maps/geo?&output=xml&key=" . $c_setting['googlemap_api'] . "&q=";
        $addressData = file_get_contents($apiURL . urlencode($address));

        $results = $this->xml2array($addressData);

        if (empty($results['Point']['coordinates'])) {
            $result = "Error: Invalid address or missing coordinates";

        } else {

            $result = explode(",", $results['Point']['coordinates']);
        }

        return $result;
    }

    /**
     *
     * @method Take a target address, check the distances with every address was defined in the $options array, then return result the closest - $sortorder = 'asc' - or the farest - $sortorder = 'desc'
     * @access public
     * @param string: $target, the first address
     * @param array: $options, multidimension array of addresses you want to get the distance (example: $options = array ('0' => array ('id' => 2, 'address' => '285-299 Havelock Street, Ashburton'))
     * @param string: $order, possibel values: 'asc' or 'desc'
     * @return array
     */
    public function getAddressesDistances($target, $options, $sortorder)
    {
        if (!is_string($target)) {
            die ("All addresses must be passed as a string");
        }
        if (!is_array($options)) {
            die ("All option addresses must be passed as an array");
        }

        $this->firstCoordinates = $this->getAddressCoordinates($target);
        $this->firstLatitude = $this->firstCoordinates[1];
        $this->firstLongitude = $this->firstCoordinates[0];

        foreach ($options as $key => $value) {
            $this->secondCoordinates = $this->getAddressCoordinates($value['address']);
            $this->secondLatitude = $this->secondCoordinates[1];
            $this->secondLongitude = $this->secondCoordinates[0];

            $this->resultDistance = $this->distance_haversine($this->firstLatitude, $this->firstLongitude, $this->secondLatitude, $this->secondLongitude);

            $this->resultArray[$key]['id'] = $value['id'];
            $this->resultArray[$key]['distance'] = $this->resultDistance;
        }

        $this->resultArray = $this->sortmulti($this->resultArray, 'distance', $sortorder);

        return $this->resultArray[0];
    }

    /**
     * @method Calculating distance between two geo coordinates defined point, using the Haversine Formula
     * @link http://en.wikipedia.org/wiki/Haversine_formula
     * @access protected
     * @param $latitude1 : float, the latitude coordinate for the first point
     * @param $longitude1 : float, the longitude coordinate for the first point
     * @param $latitude2 : float, the latitude coordinate for the second point
     * @param $longitude2 : float, the longitude coordinate for the second point
     * @return float, the distance in km
     */
    function distance_haversine($latitude1, $longitude1, $latitude2, $longitude2)
    {
        $this->dLatitude = $latitude2 - $latitude1;
        $this->dLongitude = $longitude2 - $longitude1;

        $alpha = $this->dLatitude / 2;
        $beta = $this->dLongitude / 2;

        $a = sin(deg2rad($alpha)) * sin(deg2rad($alpha)) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin(deg2rad($beta)) * sin(deg2rad($beta));
        $c = asin(min(1, sqrt($a)));

        $distance = 2 * $this->earthRadius * $c;
        $distance = round($distance, 3);

        return $distance;
    }

    /**
     * @method Sort multidemsional array based on an array index
     * @access protected
     * @param array: $array, must be multidimensional
     * @param string: $index, one of the $array indexes
     * @param string: $order, possibel values: 'asc' or 'desc'
     * @param binary: $natsort, natural sorting (check: http://php.net/manual/en/function.natsort.php)
     * @param binary: $case_sensitive
     * @return array, sorted
     */
    protected function sortmulti($array, $index, $order, $natsort = FALSE, $case_sensitive = FALSE)
    {

        if (is_array($array) && count($array) > 0) {
            foreach (array_keys($array) as $key)
                $temp[$key] = $array[$key][$index];
            if (!$natsort) {
                if ($order == 'asc')
                    asort($temp);
                else
                    arsort($temp);
            } else {
                if ($case_sensitive === true)
                    natsort($temp);
                else
                    natcasesort($temp);
                if ($order != 'asc')
                    $temp = array_reverse($temp, TRUE);
            }
            foreach (array_keys($temp) as $key)
                if (is_numeric($key))
                    $sorted[] = $array[$key];
                else
                    $sorted[$key] = $array[$key];
            return $sorted;
        }
        return $sorted;
    }

    /**
     *  The below functionality comes from PHPCLASS.ORG, Roger Veciana - Associative array to XML Class
     *  Transform an XML string to associative array "XML Parser Functions"
     */
    protected function xml2array($xml)
    {
        $this->depth = -1;
        $this->xml_parser = xml_parser_create();
        xml_set_object($this->xml_parser, $this);
        xml_parser_set_option($this->xml_parser, XML_OPTION_CASE_FOLDING, 0);//Don't put tags uppercase
        xml_set_element_handler($this->xml_parser, "startElement", "endElement");
        xml_set_character_data_handler($this->xml_parser, "characterData");
        xml_parse($this->xml_parser, $xml, true);
        xml_parser_free($this->xml_parser);
        return $this->arrays[3];
    }

    protected function startElement($parser, $name, $attrs)
    {
        $this->keys[] = $name; //We add a key
        $this->node_flag = 1;
        $this->depth++;
    }

    protected function characterData($parser, $data)
    {
        $key = end($this->keys);
        $this->arrays[$this->depth][$key] = $data;
        $this->node_flag = 0; //So that we don't add as an array, but as an element
    }

    protected function endElement($parser, $name)
    {
        $key = array_pop($this->keys);
        //If $node_flag==1 we add as an array, if not, as an element
        if ($this->node_flag == 1) {
            $this->arrays[$this->depth][$key] = $this->arrays[$this->depth + 1];
            unset($this->arrays[$this->depth + 1]);
        }
        $this->node_flag = 1;
        $this->depth--;
    }
    /**
     *  End of Roger Veciana - Associative array to XML Class
     */

}

?>