<?php

namespace AlexanderLogachev;

/**
 * Class ApiNamaztimes
 *
 * @see https://namaztimes.kz/ru/dev
 *
 * @package Nt
 */
class ApiNamaztimes
{
    const BASE_URL   = 'https://namaztimes.kz/ru/api/';
    const CONTRY_URL = 'country?';
    const REGION_URL = 'states?';
    const CITIES_URL = 'cities?';

    const DATA_TYPE_JSON = 'json';
    const DATA_TYPE_xml  = 'xml';

    private $dataType;
    private $parseData;

    /**
     * ApiNamaztimes constructor.
     *
     * @param string $dataType
     * @param bool   $parseData
     */
    public function __construct ($dataType = 'json', $parseData = true)
    {
        $this->dataType  = $dataType;
        $this->parseData = $parseData;
    }

    /**
     * Получаем список стран
     *
     * @return bool|string
     */
    public function getCountries ()
    {
        $query = http_build_query(
            [
                'type' => $this->dataType,
            ]
        );

        return $this->sendRequest(
            self::CONTRY_URL . $query
        );
    }

    /**
     * Получаем список регионов по ID страны
     *
     * @param $countryId
     *
     * @return bool|string
     */
    public function getRegions ($countryId)
    {
        $query = http_build_query(
            [
                'type' => $this->dataType,
                'id'   => $countryId,
            ]
        );

        return $this->sendRequest(
            self::REGION_URL . $query
        );
    }

    /**
     * Получаем список городов по ID региона
     *
     * @param $regionId
     *
     * @return bool|string
     */
    public function getCities ($regionId)
    {
        $query = http_build_query(
            [
                'type' => $this->dataType,
                'id'   => $regionId,
            ]
        );

        return $this->sendRequest(
            self::CITIES_URL . $query
        );
    }

    /**
     * @param $data
     *
     * @return array|stdClass
     */
    private function parseData ($data)
    {
        if ($this->dataType == self::DATA_TYPE_xml) {
            return simplexml_load_string($data);
        }
        else {
            return json_decode($data, true, 512, JSON_BIGINT_AS_STRING);
        }
    }

    /**
     * @param $url
     *
     * @return bool|string
     */
    private function sendRequest ($url)
    {
        $ch = curl_init(self::BASE_URL . $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $data = curl_exec($ch);
        curl_close($ch);

        return $this->parseData ? $this->parseData($data) : $data;
    }
}