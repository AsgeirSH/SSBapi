AsgeirSH/SSBapi
===============

Et enkelt, objektorientert PHP-verktøy for å spørre ut SSBs API. Verktøyet ble opprinnelig skrevet for å hente ut data fra SSBs statistikk om levendefødte til statistikk UKM Norge lager om målgruppe og deltakelse.

Kildekodekrav
-------------
Biblioteket krever kun open source-kildekode, spesifikt:
- [Min egen CURL-wrapper](https://github.com/AsgeirSH/CURLlib/). Denne requires av composer, så du trenger ikke gjøre noe. Du kan enkelt skrive din egen CURL-wrapper, men den må i så fall implementere CURLInterface fra AsgeirSH\CURLlib.

Hvordan installere biblioteket?
-------------------------------
Bruk composer, og legg til følgende i composer.json:
 ```json
"repositories": [
    {
        "url": "https://github.com/AsgeirSH/SSBapi.git",
        "type": "git"
    }
],

"require": {
    "asgeirsh/ssbapi": "dev-master"
}, 
 ```

Når koden har en stabil versjon kan dev-master byttes ut med standard Composer-versjonsuttrykk.


Hvordan bruke biblioteket?
--------------------------
Det er veldig enkelt å bruke biblioteket. Alt du trenger er klassen SSBapi, enten via å extende den til din egen klasse eller bruke den direkte i et script. Skal jeg hente ut en rapport ofte lager jeg gjerne en egen klasse for dette (se [Eksempel/Levendefodte.php](Eksempel/Levendefodte.php)).

Eksempel-kode:
--------------
 ```php
$SSBapi = new SSBapi();

# Sett hvilken ressurs (i.e. tabell) vi vil spørre på. 
# Argumentet her må være på formen ressurs/ID.
$SSBapi->setResource('table/'.$this->table);

# Legg til parametere i spørringen.
$SSBapi->addQueryParameter("Region", "item", array("0104")); # 0104 = Moss

# [Sett flere parametre...]

# Velg resultat-format. Alternativene er json-stat, csv og xlsx.
$SSBapi->addResponseFormat("json-stat");

# Kjør spørringen mot SSB og returner resultatet i en variabel.
$result = $SSBapi->run();
```

TODO / Veien videre:
--------------------
- Skriv tester
- Release en versjon.