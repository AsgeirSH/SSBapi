<?php 

# Bruker du composer holder det å require autoload.php:
# require __DIR__ . '/vendor/autoload.php';
# Alternativt kan du require korrekt fil direkte:
require_once('../src/SSBapi.php');

class Levendefodte extends SSBapi {

	public $year;
	public $table = '04231';

	public function buildQuery() {
		# Sett hvilken ressurs (i.e. tabell) vi vil spørre på.
		$this->setResource('table/'.$this->table);

		# Legg til parametere i spørringen.
		$this->addQueryParameter("Region", "item", $this->_getAllKommuner());
		#$this->addQueryParameter("Kjonn", "item", array("10", "11")); 
		$this->addQueryParameter("Kjonn", "all", array()); # La SSB summere summene for kjønn for oss :D
		$this->addQueryParameter("ContentsCode", "item", array("Levendefodte"));
		$this->addQueryParameter("Tid", "item", array($this->year));
		# Sett hvilken form vi vil ha på resultatet.
		$this->addResponseFormat("json-stat");

		# For debugging kan det være lurt å ta ut spørringen her, for å sjekke i SSBs konsoll (http://data.ssb.no/api/v0/no/console)
	}	# echo $this->query();

	# Returnerer et array av kommuneIDer. 
	# I dette eksempelet ble de originalt hentet fra en databasetabell.
	private function _getAllKommuner() {
		# Test:
		return array($this->getSSBifiedKommuneId(104),$this->getSSBifiedKommuneId(105));
	}
}