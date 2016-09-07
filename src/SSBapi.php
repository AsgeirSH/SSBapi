<?php

namespace AsgeirSH\SSBapi;

require_once(__DIR__.'/SSBapiInterface.php');
require_once('UKM/curl.class.php');

use AsgeirSH\SSBapi\SSBapiInterface;

class SSBapi implements SSBapiInterface {
	# Selve spørringen.
	private $query = null;
	# Ressurs-ID. Brukes til å finne URLen vi curler til.
	private $resource = null;

	public function setResource($resource) {
		$this->resource = $resource;
	}
	
	public function run() {
		if(null == $this->resource) {
			throw new Exception("Kan ikke kjøre en SSB-spørring mot ukjent ressurs.");
		}

		# Build full API-url
		$url = self::API_URL . $this->resource;

		$curl = new \UKMCURL();
		$curl->post($this->query());
		$result = $curl->process($url);
		return $result;
	}

	# SSB krever at kommune-ID er et firesifret tall med fylkes-id (1-2 siffer) og et kommunetall (1-2 siffer), med 0 i front (i.e. 0104 = Moss). 
	# Input til denne funksjonen er konkatenert
	# UKMs kommune-ID paddes med 0 i front til ett firesifret tall, da det allerede er fylke_id.kommunetall med 0 der nødvendig internt.
	public function getSSBifiedKommuneID($k_id) {
		$k_id = (string)$k_id;
		if(count($k_id) < 4)
			$k_id = str_pad($k_id, 4, '0', STR_PAD_LEFT);	
		return $k_id;
	}

	public function query() {
		return json_encode($this->query);
	}

	# SSB-spørringen er utformet av parametere i et JSON-enkodet objekt.
	# Se http://ssb.no/omssb/tjenester-og-verktoy/api/px-api/_attachment/248256?_ts=157046caac8
	# $code er navnet på parameteren vi skal filtrere etter.
	# $filter er typen filter. Per 07.09.2016 er det tre støttede filtertyper: item, all og top.
	# $values er et array med verdier som brukes til filtrering. Kan være tomt for all.
	public function addQueryParameter($code, $filter, $values = array()) {
		$param = new \stdClass();
		$param->code = $code;
		$param->selection = new \stdClass();
		$param->selection->filter = $filter;
		$param->selection->values = $values;

		$this->query->query[] = $param;
	}

	# SSB-spørringen krever et response-felt som bestemmer på hvilken form output skal være.
	# Per 07.09.2016 er det tre støttede datatyper: json-stat (anbefalt), csv og xlsx.
	public function addResponseFormat($format) {
		$this->query->response = new \stdClass();
		$this->query->response->format = $format;
	}
}