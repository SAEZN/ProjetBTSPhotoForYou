<?php
use PHPUnit\Framework\TestCase;
/*

./vendor/bin/phpunit PhotoForYou2022_POO-master/LoginTest.php

*/
class LoginTest extends TestCase
{

    protected static $client;
    protected static $cookie_jar;

    public static function setUpBeforeClass(): void {
        self::$client = new GuzzleHttp\Client(["base_uri" => "http://localhost", "cookies" => true]);
    }

    public function testLoginPageHasLoginInput()
    {
        // Get Login page
        $response = self::$client->get("/");
        $this->assertEquals(200, $response->getStatusCode());

        // Verify presence of login and password inputs
        $doc = new DOMDocument();
        @$doc->loadHTML((string) $response->getBody());
        $this->assertNotNull($doc->getElementById('mail'));
        $this->assertNotNull($doc->getElementById('pass'));
    }

    public function testDoLogin()
    {
        // Post Login info
        $response = self::$client->request('POST', '/index.php?Cible=Connexion&Action=seConnecter', [
            'form_params' => [
                'mail' => 'admin@gmail.com',
                'pass' => 'admin'
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());

        // Verify presence of login and password inputs
        $doc = new DOMDocument();
        @$doc->loadHTML((string) $response->getBody());
        
        // debug output
        // d($doc->saveHTML($doc->getElementsByTagName("body")->item(0)));
        $this->assertNotNull($doc->getElementById('btn btn-secondary'));
        $this->assertEquals("Fin de connexion", $doc->getElementById('btn btn-secondary')->nodeValue);
    }

 /*   public function testGetExcelSuiviCSO() {
        // Activation du suivi pour pouvoir voir des CSO qui ne nous appartiennent pas
        $response = self::$client->get("/index.php?Cible=SuiviAvancement&Action=CommencerSuivi");
        $this->assertEquals(200, $response->getStatusCode());

        // Affichage des CSO et mise en place des filtres
        $response = self::$client->request("POST", "/index.php?Cible=MesCSO&Action=ListeCSO_EnCours", [
            'form_params' => [
                "porteeDuDomaine" => "-1",
                "candidat" => "C1608",
                "nomCandidat" => null,
                "filtreDebut" => "2023-02-25",
                "filtreFin" => "2023-05-16",
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $doc = new DOMDocument();
        @$doc->loadHTML((string) $response->getBody());
        $this->assertNotNull($doc->getElementById('titre-page-extra'));
        $this->assertEquals("Listing des CSO", $doc->getElementById('titre-page-extra')->nodeValue);

        // Téléchargement du excel
        $download_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . "testCSO.xlsx";
        $response = self::$client->get("/index.php?Cible=MesCSO&Action=TelechargementListeCSO", [
            "sink" => $download_path
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertGreaterThanOrEqual(5000, filesize($download_path)); //le fichier est > à 5 ko
    }

    public function testGetPDFCSO() {
        $download_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . "cso2281.pdf";
        $response = self::$client->get("/index.php?Cible=MesCSOCertifie&Action=TelechargerDocumentsFinCSO&ID=2281", [
            "sink" => $download_path
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertGreaterThanOrEqual(15000, filesize($download_path)); //le fichier est > à 15 ko
    }

    public function testEncodingAdminiUtilisateur() {
        $response = self::$client->get("/index.php?Cible=Administration&Action=ModifUtilisateur&IDUtilisateur=1");
        $this->assertEquals(200, $response->getStatusCode());

        $doc = new DOMDocument('1.0', 'UTF-8');
        @$doc->loadHTML(mb_convert_encoding($response->getBody(), 'HTML-ENTITIES', 'UTF-8'));

        $this->assertNotNull($doc->getElementById('prenomUtilisateur'));
        $this->assertEquals("Mickaël", $doc->getElementById('prenomUtilisateur')->getAttribute('value'));

        $this->assertNotNull($doc->getElementById('label-roleContrôleur'));
        $this->assertEquals("Contrôleur", $doc->getElementById('label-roleContrôleur')->nodeValue);

        $this->assertNotNull($doc->getElementById('label-porteeDuDomaineElectricité'));
        $this->assertEquals("Electricité", $doc->getElementById('label-porteeDuDomaineElectricité')->nodeValue);
    }

    public function testViewAs()
    {
        // Post Login info
        $response = self::$client->request('POST', '/index.php?Cible=Connexion&Action=SeConnecterAvec&IDUtilisateur=1475');
        $this->assertEquals(200, $response->getStatusCode());

        // Verify presence of login and password inputs
        $doc = new DOMDocument();
        @$doc->loadHTML((string) $response->getBody());
        
        // debug output
        // d($doc->saveHTML($doc->getElementsByTagName("body")->item(0)));
        $this->assertNotNull($doc->getElementById('nom-client'));
        $this->assertStringContainsString("Christian PADIOLLEAU C0109", $doc->getElementById('nom-client')->nodeValue);
    }
    */
}
