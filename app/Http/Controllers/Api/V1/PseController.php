<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Datakey;
use Illuminate\Http\Request;

use App\Models\Guidecarrier;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use ZipArchive;
use Greenter\XMLSecLibs\Sunat\SignedXml;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

// use Greenter\See;

class PseController extends Controller
{

    public function creaxml(Request $request)
    {
        date_default_timezone_set('America/Lima');
        $today = now()->format('Y-m-d H:i:s');

        $logo = "GENERADO DESDE WWW.SATELITAL.ORG 939236638";
        $fecha_emision = now()->format('Y-m-d');
        $hora_emision = now()->format('H:i:s');

        $doc = new \DOMDocument();
        $doc->formatOutput = FALSE;
        $doc->preserveWhiteSpace = TRUE;
        $doc->encoding = 'utf-8';
        $data = (object) $request->json()->all();
        // dd($data->serie);
        // $data = $request->json()->all();
        // dd($data);
        $entidad = strip_tags($request->entidad_razonsocial);
        $entidad = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $entidad);
        $entidad = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $entidad);
        $entidad = str_replace(' & ', ' &amp; ', html_entity_decode((htmlspecialchars_decode($entidad))));
        // 1.- crear documento XML
        $xmlCPE = new \DomDocument('1.0', 'UTF-8');
        //$xmlCPE->xmlStandalone = false;
        $xmlCPE->preserveWhiteSpace = false;
        $Despatch = $xmlCPE->createElement('DespatchAdvice');

        $Despatch_attibute = $xmlCPE->createAttribute('xmlns:ds');
        $Despatch_attibute->value = "http://www.w3.org/2000/09/xmldsig#";
        $Despatch->appendChild($Despatch_attibute);

        $Despatch_attibute = $xmlCPE->createAttribute('xmlns:xsi');
        $Despatch_attibute->value = "http://www.w3.org/2001/XMLSchema-instance";
        $Despatch->appendChild($Despatch_attibute);

        $Despatch_attibute = $xmlCPE->createAttribute('xmlns:qdt');
        $Despatch_attibute->value = "urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2";
        $Despatch->appendChild($Despatch_attibute);

        $Despatch_attibute = $xmlCPE->createAttribute('xmlns:sac');
        $Despatch_attibute->value = "urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1";
        $Despatch->appendChild($Despatch_attibute);

        $Despatch_attibute = $xmlCPE->createAttribute('xmlns:ext');
        $Despatch_attibute->value = "urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2";
        $Despatch->appendChild($Despatch_attibute);

        $Despatch_attibute = $xmlCPE->createAttribute('xmlns:udt');
        $Despatch_attibute->value = "urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2";
        $Despatch->appendChild($Despatch_attibute);

        $Despatch_attibute = $xmlCPE->createAttribute('xmlns:cac');
        $Despatch_attibute->value = "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2";
        $Despatch->appendChild($Despatch_attibute);

        $Despatch_attibute = $xmlCPE->createAttribute('xmlns:cbc');
        $Despatch_attibute->value = "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2";
        $Despatch->appendChild($Despatch_attibute);

        $Despatch_attibute = $xmlCPE->createAttribute('xmlns:ccts');
        $Despatch_attibute->value = "urn:un:unece:uncefact:documentation:2";
        $Despatch->appendChild($Despatch_attibute);

        $Despatch_attibute = $xmlCPE->createAttribute('xmlns');
        $Despatch_attibute->value = "urn:oasis:names:specification:ubl:schema:xsd:DespatchAdvice-2";
        $Despatch->appendChild($Despatch_attibute);

        $Despatch = $xmlCPE->appendChild($Despatch);

        $comment = $xmlCPE->createComment($logo);
        $Despatch->appendChild($comment);

        $level1 = $xmlCPE->createElement('ext:UBLExtensions');
        $Despatch->appendChild($level1);

        $level2 = $xmlCPE->createElement('ext:UBLExtension');
        $level1->appendChild($level2);

        $level3 = $xmlCPE->createElement('ext:ExtensionContent');
        $level2->appendChild($level3);


        $comment = $xmlCPE->createComment($logo);
        $Despatch->appendChild($comment);

        $level1 = $xmlCPE->createElement('cbc:UBLVersionID', '2.1');
        $Despatch->appendChild($level1);

        $level1 = $xmlCPE->createElement('cbc:CustomizationID', '2.0');
        $Despatch->appendChild($level1);

        $level1 = $xmlCPE->createElement('cbc:ID', $data->serie . '-' . $data->correlativo);
        $Despatch->appendChild($level1);

        $level1 = $xmlCPE->createElement('cbc:IssueDate', $data->fecha_emision);
        $Despatch->appendChild($level1);

        $level1 = $xmlCPE->createElement('cbc:IssueTime', $data->hora_emision);
        $Despatch->appendChild($level1);

        $level1 = $xmlCPE->createElement('cbc:DespatchAdviceTypeCode', $data->tipocpe);
        $Despatch->appendChild($level1);

        // $attribute = $xmlCPE->createAttribute('listAgencyName');
        // $attribute->value = "PE:SUNAT";
        // $level1->appendChild($attribute);

        // $attribute = $xmlCPE->createAttribute('listName');
        // $attribute->value = $data->tipocpe_nombre;
        // $level1->appendChild($attribute);

        // $attribute = $xmlCPE->createAttribute('listURI');
        // $attribute->value = "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo01";
        // $level1->appendChild($attribute);

        $level1 = $xmlCPE->createElement('cbc:Note', $request['nota']);
        $Despatch->appendChild($level1);

        //===============================================================>
        $comment = $xmlCPE->createComment("Datos del Transportista");
        $Despatch->appendChild($comment);

        $level1 = $xmlCPE->createElement('cac:DespatchSupplierParty');
        $Despatch->appendChild($level1);


        // OJO SOLO EN PRUEBA
        $level2 = $xmlCPE->createElement('cbc:CustomerAssignedAccountID', $request->company["ruc"]);
        $level1->appendChild($level2);

        $attribute = $xmlCPE->createAttribute('schemeID');
        $attribute->value = "6";
        $level2->appendChild($attribute);




        $level2 = $xmlCPE->createElement('cac:Party');
        $level1->appendChild($level2);

        $level3 = $xmlCPE->createElement('cac:PartyIdentification');
        $level2->appendChild($level3);

        $level4 = $xmlCPE->createElement('cbc:ID', $request->company["ruc"]);
        $level3->appendChild($level4);

        $attribute = $xmlCPE->createAttribute('schemeID');
        $attribute->value = "6";
        $level4->appendChild($attribute);

        $attribute = $xmlCPE->createAttribute('schemeName');
        $attribute->value = "Documento de Identidad";
        $level4->appendChild($attribute);

        $attribute = $xmlCPE->createAttribute('schemeAgencyName');
        $attribute->value = "PE:SUNAT";
        $level4->appendChild($attribute);

        $attribute = $xmlCPE->createAttribute('schemeURI');
        $attribute->value = "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06";
        $level4->appendChild($attribute);

        $level3 = $xmlCPE->createElement('cac:PartyLegalEntity');
        $level2->appendChild($level3);

        $level4 = $xmlCPE->createElement('cbc:RegistrationName', $request->company["name"]);
        $level3->appendChild($level4);



        // if (isset($request->transportista["autorizacion"])) {
        //     $level4 = $xmlCPE->createElement('cac:AgentParty');
        //     $level3->appendChild($level4);

        //     $level5 = $xmlCPE->createElement('cac:PartyLegalEntity');
        //     $level4->appendChild($level5);

        //     $level6 = $xmlCPE->createElement('cbc:CompanyID', $request->transportista["autorizacion"]);
        //     $level5->appendChild($level6);

        //     $attribute = $xmlCPE->createAttribute('schemeID');
        //     $attribute->value = "Catálogo N° D-37 Ojo arreglar";
        //     $level6->appendChild($attribute);

        //     $attribute = $xmlCPE->createAttribute('schemeName');
        //     $attribute->value = "Entidad Autorizadora Ojo arreglar";
        //     $level6->appendChild($attribute);

        //     $attribute = $xmlCPE->createAttribute('schemeAgencyName');
        //     $attribute->value = "PE:SUNAT";
        //     $level6->appendChild($attribute);
        // }

        //===========================================================//
        foreach ($request->relacionado as $related) {
            $comment = $xmlCPE->createComment(' Documento Relacionado ');
            $Despatch->appendChild($comment);

            $level1 = $xmlCPE->createElement('cac:AdditionalDocumentReference');
            $Despatch->appendChild($level1);

            $level2 = $xmlCPE->createElement('cbc:DocumentType', $related["tipocpe_nombre"]);
            $level1->appendChild($level2);

            $level2 = $xmlCPE->createElement('cbc:DocumentTypeCode', $related["tipocpe"]);
            $level1->appendChild($level2);

            $attribute = $xmlCPE->createAttribute('listAgencyName');
            $attribute->value = "PE:SUNAT";
            $level2->appendChild($attribute);

            $attribute = $xmlCPE->createAttribute('listName');
            $attribute->value = "Documento relacionado al transporte";
            $level2->appendChild($attribute);

            $attribute = $xmlCPE->createAttribute('listURI');
            $attribute->value = "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo61";
            $level2->appendChild($attribute);

            $level2 = $xmlCPE->createElement('cbc:ID', $related["numero"]);
            $level1->appendChild($level2);

            $level2 = $xmlCPE->createElement('cac:IssuerParty');
            $level1->appendChild($level2);

            $level3 = $xmlCPE->createElement('cac:PartyIdentification');
            $level2->appendChild($level3);

            $level4 = $xmlCPE->createElement('cbc:ID', $related["ruc"]);
            $level3->appendChild($level4);

            $attribute = $xmlCPE->createAttribute('schemeID');
            $attribute->value = "6";
            $level2->appendChild($attribute);

            $attribute = $xmlCPE->createAttribute('schemeAgencyName');
            $attribute->value = "PE:SUNAT";
            $level2->appendChild($attribute);

            $attribute = $xmlCPE->createAttribute('schemeURI');
            $attribute->value = "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06";
            $level2->appendChild($attribute);
        }


        //=================================================================>>
        $comment = $xmlCPE->createComment(' Datos del Destinatario ');
        $Despatch->appendChild($comment);

        $level1 = $xmlCPE->createElement('cac:DeliveryCustomerParty');
        $Despatch->appendChild($level1);

        $level2 = $xmlCPE->createElement('cac:Party');
        $level1->appendChild($level2);

        $level3 = $xmlCPE->createElement('cac:PartyIdentification');
        $level2->appendChild($level3);

        $level4 = $xmlCPE->createElement('cbc:ID', $request->destinatario["numeroid"]);
        $level3->appendChild($level4);

        $attribute = $xmlCPE->createAttribute('schemeID');
        $attribute->value = $request->destinatario["tipoid"];
        $level4->appendChild($attribute);

        $attribute = $xmlCPE->createAttribute('schemeName');
        $attribute->value = "Documento de Identidad";
        // $attribute->value = "Registro Único de Contribuyentes";
        $level4->appendChild($attribute);

        $attribute = $xmlCPE->createAttribute('schemeAgencyName');
        $attribute->value = "PE:SUNAT";
        $level4->appendChild($attribute);

        $attribute = $xmlCPE->createAttribute('schemeURI');
        $attribute->value = "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06";
        $level4->appendChild($attribute);

        $level3 = $xmlCPE->createElement('cac:PartyLegalEntity');
        $level2->appendChild($level3);

        $level4 = $xmlCPE->createElement('cbc:RegistrationName', $request->destinatario["razonsocial"]);
        $level3->appendChild($level4);






        //================================================================>>
        $comment = $xmlCPE->createComment(' Datos del Traslado ');
        $Despatch->appendChild($comment);

        $level1 = $xmlCPE->createElement('cac:Shipment');
        $Despatch->appendChild($level1);

        $level2 = $xmlCPE->createElement('cbc:ID', "SUNAT_Envio"); // an11
        $level1->appendChild($level2);

        $level2 = $xmlCPE->createElement('cbc:GrossWeightMeasure', $request->pesobruto); //n12,3 Peso bruto total de la carga
        $level1->appendChild($level2);

        $attribute = $xmlCPE->createAttribute('unitCode');
        $attribute->value = "KGM"; // an3 KGM TNE
        $level2->appendChild($attribute);

        $level2 = $xmlCPE->createElement('cbc:SpecialInstructions', $request['tipoindicador']); //an50 Indicador de retorno de vehículo con envases o embalajes vacíos
        $level1->appendChild($level2);

        $level2 = $xmlCPE->createElement('cac:ShipmentStage');
        $level1->appendChild($level2);

        $level3 = $xmlCPE->createElement('cac:TransitPeriod');
        $level2->appendChild($level3);

        $level4 = $xmlCPE->createElement('cbc:StartDate', $request->trasladoinicio); //Fecha Inicio de traslado
        $level3->appendChild($level4);

        //==================================================================>
        $comment = $xmlCPE->createComment("Permisos del Transportista");
        $level2->appendChild($comment);

        $level3 = $xmlCPE->createElement('cac:CarrierParty');
        $level2->appendChild($level3);

        $level4 = $xmlCPE->createElement('cac:PartyLegalEntity');
        $level3->appendChild($level4);

        $level5 = $xmlCPE->createElement('cbc:CompanyID', $request->company["registromtc"]);
        $level4->appendChild($level5);

        // Solo en PRUEBA

        $level3 = $xmlCPE->createElement('cac:TransportMeans');
        $level2->appendChild($level3);

        $level4 = $xmlCPE->createElement('cac:RoadTransport');
        $level3->appendChild($level4);

        $level5 = $xmlCPE->createElement('cbc:LicensePlateID', $request->vehiculo["matricula"]);
        $level4->appendChild($level5);




        //===============================================================>>
        $comment = $xmlCPE->createComment(' Conductor Principal ');
        $level2->appendChild($comment);

        $level3 = $xmlCPE->createElement('cac:DriverPerson');
        $level2->appendChild($level3);

        $level4 = $xmlCPE->createElement('cbc:ID', $request->conductor["numero_id"]); // an15 (Catálogo N° 06) Tipo y número de documento de identidad del conductor
        $level3->appendChild($level4);

        $attribute = $xmlCPE->createAttribute('schemeID');
        $attribute->value = $request->conductor["tipoid"]; // an 1 Tipo de documento de identidad
        $level4->appendChild($attribute);

        // $attribute = $xmlCPE->createAttribute('schemeName');
        // $attribute->value = "Documento Nacional de Identidad"; //Documento de identidad
        // $level4->appendChild($attribute);

        // $attribute = $xmlCPE->createAttribute('schemeAgencyName');
        // $attribute->value = "PE:SUNAT";
        // $level4->appendChild($attribute);

        // $attribute = $xmlCPE->createAttribute('schemeURI');
        // $attribute->value = "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06";
        // $level4->appendChild($attribute);

        $level4 = $xmlCPE->createElement('cbc:FirstName',  $request->conductor["nombres"]);
        $level3->appendChild($level4);

        $level4 = $xmlCPE->createElement('cbc:FamilyName',  $request->conductor["apellidos"]);
        $level3->appendChild($level4);

        $level4 = $xmlCPE->createElement('cbc:JobTitle', "Principal"); // an9 Tipo de conductor
        $level3->appendChild($level4);

        $level4 = $xmlCPE->createElement('cac:IdentityDocumentReference');
        $level3->appendChild($level4);

        $level5 = $xmlCPE->createElement('cbc:ID',  $request->conductor["licencia"]); //an10 Num Licencia de Conducir
        $level4->appendChild($level5);


        //=============================================================>>
        if (isset($request->conductor2["licencia"])) {

            $comment = $xmlCPE->createComment(' Conductores Secundarios ');
            $level2->appendChild($comment);

            $level3 = $xmlCPE->createElement('cac:DriverPerson');
            $level2->appendChild($level3);

            $level4 = $xmlCPE->createElement('cbc:JobTitle', "Secundario"); // an9 Tipo de conductor
            $level3->appendChild($level4);

            $level4 = $xmlCPE->createElement('cbc:ID', $request->conductor2["numero_id"]); // an15 (Catálogo N° 06) Tipo y número de documento de identidad del conductor2
            $level3->appendChild($level4);

            $attribute = $xmlCPE->createAttribute('schemeID');
            $attribute->value = $request->conductor2["tipo_id"]; // an 1 Tipo de documento de identidad
            $level4->appendChild($attribute);

            $attribute = $xmlCPE->createAttribute('schemeName');
            $attribute->value = "Documento Nacional de Identidad"; //Documento de identidad
            $level4->appendChild($attribute);

            $attribute = $xmlCPE->createAttribute('schemeAgencyName');
            $attribute->value = "PE:SUNAT";
            $level4->appendChild($attribute);

            $attribute = $xmlCPE->createAttribute('schemeURI');
            $attribute->value = "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06";
            $level4->appendChild($attribute);

            $level4 = $xmlCPE->createElement('cbc:FirstName', $request->conductor2["nombres"]);
            $level3->appendChild($level4);

            $level4 = $xmlCPE->createElement('cbc:FamilyName', $request->conductor2["apellidos"]);
            $level3->appendChild($level4);

            $level4 = $xmlCPE->createElement('cac:IdentityDocumentReference');
            $level3->appendChild($level4);

            $level5 = $xmlCPE->createElement('cbc:ID', $request->conductor2["licencia"]); //an10 Num Licencia de Conducir
            $level4->appendChild($level5);
        }

        $level2 = $xmlCPE->createElement('cac:Delivery');
        $level1->appendChild($level2);

        //=====================================================================>>
        $comment = $xmlCPE->createComment(' Direccion del Punto de Llegada ');
        $level2->appendChild($comment);

        $level3 = $xmlCPE->createElement('cac:DeliveryAddress');
        $level2->appendChild($level3);

        $level4 = $xmlCPE->createElement('cbc:ID', $request->llegada["ubigeo"]); //Ubigeo
        $level3->appendChild($level4);

        $attribute = $xmlCPE->createAttribute('schemeAgencyName');
        $attribute->value = "PE:INEI";
        $level4->appendChild($attribute);

        $attribute = $xmlCPE->createAttribute('schemeName');
        $attribute->value = "Ubigeos";
        $level4->appendChild($attribute);

        $level4 = $xmlCPE->createElement('cac:AddressLine');
        $level3->appendChild($level4);

        $level5 = $xmlCPE->createElement('cbc:Line', $request->llegada["direccion"]); //Direccion completa y detallada de llegada
        $level4->appendChild($level5);

        // if (isset($request->llegada["latitud"]) && isset($request->llegada["longitud"])) {
        //     $level4 = $xmlCPE->createElement('cac:LocationCoordinate');
        //     $level3->appendChild($level4);

        //     $level5 = $xmlCPE->createElement('cbc:LatitudeDegreesMeasure', $request->llegada["latitud"]); // (Longitud n 3,8 Punto de georreferencia de llegada
        //     $level4->appendChild($level5);

        //     $attribute = $xmlCPE->createAttribute('unitCode'); // an2
        //     $attribute->value = "DD";
        //     $level5->appendChild($attribute);

        //     $level5 = $xmlCPE->createElement('cbc:LongitudeDegreesMeasure', $request->llegada["longitud"]); // (Longitud n 3,8 Punto de georreferencia de llegada
        //     $level4->appendChild($level5);

        //     $attribute = $xmlCPE->createAttribute('unitCode'); // an2
        //     $attribute->value = "DD";
        //     $level5->appendChild($attribute);
        // }

        //==================================================================>>
        $comment = $xmlCPE->createComment(' Direccion del Punto de Partida ');
        $level2->appendChild($comment);

        $level3 = $xmlCPE->createElement('cac:Despatch');
        $level2->appendChild($level3);

        $level4 = $xmlCPE->createElement('cac:DespatchAddress');
        $level3->appendChild($level4);

        $level5 = $xmlCPE->createElement('cbc:ID', $request->partida["ubigeo"]); //Ubigeo de partida
        $level4->appendChild($level5);

        $attribute = $xmlCPE->createAttribute('schemeAgencyName');
        $attribute->value = "PE:INEI";
        $level5->appendChild($attribute);

        $attribute = $xmlCPE->createAttribute('schemeName');
        $attribute->value = "Ubigeos";
        $level5->appendChild($attribute);

        $level5 = $xmlCPE->createElement('cac:AddressLine');
        $level4->appendChild($level5);

        $level6 = $xmlCPE->createElement('cbc:Line', $request->partida["direccion"]); //Direccion completa y detallada de partida
        $level5->appendChild($level6);

        // if (isset($request->partida["latitud"]) && isset($request->partida["longitud"])) {
        //     $level5 = $xmlCPE->createElement('cac:LocationCoordinate');
        //     $level4->appendChild($level5);

        //     $level6 = $xmlCPE->createElement('cbc:LatitudeDegreesMeasure', $request->partida["latitud"]); // (Longitud n 3,8 Punto de georreferencia de partida
        //     $level5->appendChild($level6);

        //     $attribute = $xmlCPE->createAttribute('unitCode'); // an2
        //     $attribute->value = "DD";
        //     $level6->appendChild($attribute);

        //     $level6 = $xmlCPE->createElement('cbc:LongitudeDegreesMeasure', $request->partida["longitud"]); // (Longitud n 3,8 Punto de georreferencia de partida
        //     $level5->appendChild($level6);

        //     $attribute = $xmlCPE->createAttribute('unitCode'); // an2
        //     $attribute->value = "DD";
        //     $level6->appendChild($attribute);
        // }

        //==============================================================>>
        $comment = $xmlCPE->createComment(' Datos del Remitente ');
        $level3->appendChild($comment);

        $level4 = $xmlCPE->createElement('cac:DespatchParty');
        $level3->appendChild($level4);

        $level5 = $xmlCPE->createElement('cac:PartyIdentification');
        $level4->appendChild($level5);

        $level6 = $xmlCPE->createElement('cbc:ID', $request->remitente["numeroid"]);
        $level5->appendChild($level6);

        $attribute = $xmlCPE->createAttribute('schemeID');
        $attribute->value = $request->remitente["tipoid"];
        $level6->appendChild($attribute);

        $attribute = $xmlCPE->createAttribute('schemeName');
        $attribute->value = "Documento de Identidad";
        // $attribute->value = "Registro Único de Contribuyentes";
        $level6->appendChild($attribute);

        $attribute = $xmlCPE->createAttribute('schemeAgencyName');
        $attribute->value = "PE:SUNAT";
        $level6->appendChild($attribute);

        $attribute = $xmlCPE->createAttribute('schemeURI');
        $attribute->value = "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06";
        $level6->appendChild($attribute);

        $level5 = $xmlCPE->createElement('cac:PartyLegalEntity');
        $level4->appendChild($level5);

        $level6 = $xmlCPE->createElement('cbc:RegistrationName', $request->remitente["razonsocial"]);
        $level5->appendChild($level6);


        //================================================================>>
        $comment = $xmlCPE->createComment(' Vehículo Principal ');
        $level1->appendChild($comment);

        $level2 = $xmlCPE->createElement('cac:TransportHandlingUnit');
        $level1->appendChild($level2);

        $level3 = $xmlCPE->createElement('cac:TransportEquipment');
        $level2->appendChild($level3);

        $level4 = $xmlCPE->createElement('cbc:ID', $request->vehiculo["matricula"]); //an8 Número de placa del vehiculo
        $level3->appendChild($level4);

        $level4 = $xmlCPE->createElement('cac:ApplicableTransportMeans');
        $level3->appendChild($level4);

        $level5 = $xmlCPE->createElement('cbc:RegistrationNationalityID', $request->vehiculo["tuc"]); //an15 Tarjeta Única de Circulación Electrónica o Certificado de Habilitación vehicular
        $level4->appendChild($level5);

        // $level4 = $xmlCPE->createElement('cac:ShipmentDocumentReference');
        // $level3->appendChild($level4);

        // $level5 = $xmlCPE->createElement('cbc:ID', $request->vehiculo["autorizacion"]); //an50 Número de autorización del vehículo emitido por la entidad - vehículo principal
        // $level4->appendChild($level5);

        // $attribute = $xmlCPE->createAttribute('schemeID'); // an2 (Catálogo N° D-37)
        // $attribute->value = "15";
        // $level5->appendChild($attribute);

        // $attribute = $xmlCPE->createAttribute('schemeName');
        // $attribute->value = "Entidad Autorizadora";
        // $level5->appendChild($attribute);

        // $attribute = $xmlCPE->createAttribute('schemeAgencyName');
        // $attribute->value = "PE:SUNAT";
        // $level5->appendChild($attribute);


        //========================================================>>
        if (isset($request->vehiculo2["matricula"])) {
            $comment = $xmlCPE->createComment(' Vehículos Secundarios ');
            $Despatch->appendChild($comment);

            $level1 = $xmlCPE->createElement('cac:Shipment');
            $Despatch->appendChild($level1);

            $level2 = $xmlCPE->createElement('cac:TransportHandlingUnit');
            $level1->appendChild($level2);

            $level3 = $xmlCPE->createElement('cac:TransportEquipment');
            $level2->appendChild($level3);

            $level3 = $xmlCPE->createElement('cac:AttachedTransportEquipment');
            $level2->appendChild($level3);

            $level4 = $xmlCPE->createElement('cbc:ID', $request->vehiculo2["tuc"]); //an8 Número de placa del vehiculo
            $level3->appendChild($level4);

            $level4 = $xmlCPE->createElement('cac:ApplicableTransportMeans');
            $level3->appendChild($level4);

            $level5 = $xmlCPE->createElement('cbc:RegistrationNationalityID', $request->vehiculo2["certificado"]); //an15 Tarjeta Única de Circulación Electrónica o Certificado de Habilitación vehicular
            $level4->appendChild($level5);

            // $level4 = $xmlCPE->createElement('cac:ShipmentDocumentReference');
            // $level3->appendChild($level4);

            // $level5 = $xmlCPE->createElement('cbc:ID', $request->vehiculo2["autorizacion"]); //an50 Número de autorización del vehículo emitido por la entidad - vehículo principal
            // $level4->appendChild($level5);

            // $attribute = $xmlCPE->createAttribute('schemeID'); // an2 (Catálogo N° D-37)
            // $attribute->value = "15";
            // $level5->appendChild($attribute);

            // $attribute = $xmlCPE->createAttribute('schemeName');
            // $attribute->value = "Entidad Autorizadora";
            // $level5->appendChild($attribute);

            // $attribute = $xmlCPE->createAttribute('schemeAgencyName');
            // $attribute->value = "PE:SUNAT";
            // $level5->appendChild($attribute);
        }






        //==================================================================>>
        $comment = $xmlCPE->createComment(' Bienes a transportar ');
        $Despatch->appendChild($comment);
        $index = 0;
        foreach ($request->items as $item) {
            $index++;
            $level1 = $xmlCPE->createElement('cac:DespatchLine');
            $Despatch->appendChild($level1);

            $level2 = $xmlCPE->createElement('cbc:ID', $index);
            $level1->appendChild($level2);

            $level2 = $xmlCPE->createElement('cbc:DeliveredQuantity', "10"); //n12,10 Cantidad
            $level1->appendChild($level2);

            $attribute = $xmlCPE->createAttribute('unitCode');
            $attribute->value = $item["unidad"];
            $level2->appendChild($attribute);

            $attribute = $xmlCPE->createAttribute('unitCodeListID');
            $attribute->value = "UN/ECE rec 20";
            $level2->appendChild($attribute);

            $attribute = $xmlCPE->createAttribute('unitCodeListAgencyName');
            $attribute->value = "United Nations Economic Commission for Europe";
            $level2->appendChild($attribute);

            $level2 = $xmlCPE->createElement('cac:OrderLineReference');
            $level1->appendChild($level2);

            $level3 = $xmlCPE->createElement('cbc:LineID', $item["id"]);
            $level2->appendChild($level3);

            $level2 = $xmlCPE->createElement('cac:Item');
            $level1->appendChild($level2);

            $level3 = $xmlCPE->createElement('cbc:Description', $item["descripcion"]);
            $level2->appendChild($level3);

            $level3 = $xmlCPE->createElement('cac:SellersItemIdentification');
            $level2->appendChild($level3);

            $level4 = $xmlCPE->createElement('cbc:ID', $item["cod_producto"]);
            $level3->appendChild($level4);

            // $level3 = $xmlCPE->createElement('cac:CommodityClassification');
            // $level2->appendChild($level3);

            // $level4 = $xmlCPE->createElement('cbc:ItemClassificationCode', $item["cod_producto"]);
            // $level3->appendChild($level4);

            // $level3 = $xmlCPE->createElement('cac:StandardItemIdentification');
            // $level2->appendChild($level3);

            // $level4 = $xmlCPE->createElement('cbc:ID');  // Código GTIN
            // $level3->appendChild($level4);

            // $attribute = $xmlCPE->createAttribute('schemeID');
            // $attribute->value = "DFFF"; //Tipo de estructura GTIN
            // $level4->appendChild($attribute);

            // $level3 = $xmlCPE->createElement('cac:AdditionalItemProperty');
            // $level2->appendChild($level3);

            // $level3 = $xmlCPE->createElement('cbc:Name');  //Nombre del concepto Partida arancelaria
            // $level2->appendChild($level3);

            // $level3 = $xmlCPE->createElement('cbc:NameCode'); //Código del concepto
            // $level2->appendChild($level3);

            // $attribute = $xmlCPE->createAttribute('listName');
            // $attribute->value = "Propiedad del item"; //Tipo de estructura GTIN
            // $level3->appendChild($attribute);

            // $attribute = $xmlCPE->createAttribute('listURI');
            // $attribute->value = "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo55"; //Tipo de estructura GTIN
            // $level3->appendChild($attribute);

            // $level3 = $xmlCPE->createElement('cac:AdditionalItemProperty');
            // $level2->appendChild($level3);

            // $level4 = $xmlCPE->createElement('cbc:Value'); //Partida arancelaria an10
            // $level3->appendChild($level4);

            // $level4 = $xmlCPE->createElement('cbc:Value', "0"); //Indicador de bien normalizado 0, 1
            // $level3->appendChild($level4);
        }







        // $level1 = $xmlCPE->createElement('cac:DespatchLine');
        // $Despatch->appendChild($level1);

        // $level2 = $xmlCPE->createElement('cbc:ID', "0"); //n1 Anotacion adicional sobre los bienes a transportar
        // $level1->appendChild($level2);

        // $level2 = $xmlCPE->createElement('cac:OrderLineReference');
        // $level1->appendChild($level2);

        // $level3 = $xmlCPE->createElement('cbc:LineID');
        // $level2->appendChild($level3);

        // $level2 = $xmlCPE->createElement('cac:Item');
        // $level1->appendChild($level2);

        // $level3 = $xmlCPE->createElement('cbc:Description', ""); //an500
        // $level2->appendChild($level3);


        // $level2 = $xmlCPE->createElement('cbc:SpecialInstructions', "SUNAT_Envio_IndicadorTrasladoTotal"); //an50 Indicador de traslado total de bienes
        // $level1->appendChild($level2);

        // $level2 = $xmlCPE->createElement('cbc:SpecialInstructions', "SUNAT_Envio_IndicadorRetornoVehiculoVacio"); //an50
        // $level1->appendChild($level2);

        // $level2 = $xmlCPE->createElement('cbc:SpecialInstructions', "SUNAT_Envio_IndicadorTransbordoProgramado"); //an50
        // $level1->appendChild($level2);

        // $level2 = $xmlCPE->createElement('cbc:SpecialInstructions', "SUNAT_Envio_IndicadorTrasporteSubcontratado"); //an50
        // $level1->appendChild($level2);

        // $level2 = $xmlCPE->createElement('cac:ShipmentStage'); //Solo poara guia por eventos
        // $level1->appendChild($level2);

        // $level3 = $xmlCPE->createElement('cac:TransportEvent'); //Solo poara guia por eventos
        // $level2->appendChild($level3);

        // $level4 = $xmlCPE->createElement('cbc:TransportEventTypeCode', "1"); //an1 1-Transbordo no programado  2-Imposibilidad arribo  3-Imposibilidad entrega //Solo poara guia por eventos
        // $level3->appendChild($level4);

        //======================================================>>>
        // $comment = $xmlCPE->createComment(' Datos de empresa que subcontrata ');
        // $level1->appendChild($comment);

        // $level2 = $xmlCPE->createElement('cac:Consignment');
        // $level1->appendChild($level2);

        // $level3 = $xmlCPE->createElement('cbc:ID', "SUNAT_Envio"); //Identificador obligatorio
        // $level2->appendChild($level3);

        // $level3 = $xmlCPE->createElement('cac:LogisticsOperatorParty');
        // $level2->appendChild($level3);

        // $level4 = $xmlCPE->createElement('cac:PartyIdentification'); //
        // $level3->appendChild($level4);

        // $level5 = $xmlCPE->createElement('cbc:ID', "20625252524"); //número de documento de identidad  del subcontratador
        // $level4->appendChild($level5);

        // $attribute = $xmlCPE->createAttribute('schemeID');
        // $attribute->value = "6"; // Tipo de documento
        // $level5->appendChild($attribute);

        // $level4 = $xmlCPE->createElement('cac:PartyLegalEntity'); //
        // $level3->appendChild($level4);

        // $level5 = $xmlCPE->createElement('cac:PartyLegalEntity', "NOVATEXH SAC"); //an 250 razón social del subcontratador
        // $level4->appendChild($level5);

        //=================================================================>>
        // $comment = $xmlCPE->createComment(' Datos quien paga el servicio de transporte - solo se completa cuando paga un tercero ');
        // $Despatch->appendChild($comment);

        // $level1 = $xmlCPE->createElement('cac:OriginatorCustomerParty');
        // $Despatch->appendChild($level1);

        // $level2 = $xmlCPE->createElement('cac:Party');
        // $level1->appendChild($level2);

        // $level3 = $xmlCPE->createElement('cac:PartyIdentification');
        // $level2->appendChild($level3);

        // $level4 = $xmlCPE->createElement('cbc:ID', "20612554545"); //an15 numero de documento de identidad
        // $level3->appendChild($level4);

        // $attribute = $xmlCPE->createAttribute('schemeID');
        // $attribute->value = "6"; //an1 Tipo de documento de identidad
        // $level5->appendChild($attribute);

        // $level3 = $xmlCPE->createElement('cac:PartyLegalEntity');
        // $level2->appendChild($level3);

        // $level4 = $xmlCPE->createElement('cbc:RegistrationName', "NOVATECH SAC"); //an250 razón social de quien paga el servicio
        // $level3->appendChild($level4);

        $comment = $xmlCPE->createComment($logo);
        $Despatch->appendChild($comment);
        //Se eliminan espacios en blanco
        $xmlCPE->preserveWhiteSpace = false;
        $xmlCPE->formatOutput = true;
        //Se instancia el objeto
        $strings_xml = $xmlCPE->saveXML();

        //GUARDAR DOCUMENTO XML EN facturas-sin-firmar
        $_ruta = __DIR__ . "/../../../../../cpe/files/base/";
        $filename = $request->company["ruc"] . '-' . $request->tipocpe . '-' . $request->serie . '-' . $request->correlativo . '.xml';

        try {
            $xmlCPE->save($_ruta . $filename);
            chmod($_ruta . $filename, 0777);
            // \Storage::disk('local')->put($_ruta . $filename,$strings_xml);
            return json_encode("Grabado");
        } catch (\Exception $e) {
            // Aquí puedes devolver una respuesta JSON con el código de estado y el mensaje de error
            return response()->json($e->getMessage());
            // return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function xmlfirma(Request $request)
    {
        date_default_timezone_set('America/Lima');
        require __DIR__ . '/../../../../../vendor/autoload.php';
        $rutaBase = __DIR__ . '/../../../../../cpe/files/base/';
        $rutaSign = __DIR__ . '/../../../../../cpe/files/signed/';
        $rutaCert = __DIR__ . '/../../../../../cpe/certificates/limasur/';
        $filenameXml = $request->filename . '.xml';
        $filenameZip = $request->filename . '.zip';
        $xml = file_get_contents($rutaBase . $filenameXml);
        $cert = file_get_contents($rutaCert . 'certificadolimasur.pem');

        $signer = new SignedXml();
        $signer->setCertificate($cert);

        $xmlSigned = $signer->signXml($xml);

        file_put_contents($rutaSign . $filenameXml, $xmlSigned);

        $zip = new \ZipArchive();
        $zip->open($rutaSign . $filenameZip, \ZipArchive::CREATE);
        $zip->addFile($rutaSign . $filenameXml, $filenameXml);
        $zip->close();

        $greZip = file_get_contents($rutaSign . $filenameZip);
        $arcGreZip = base64_encode($greZip);
        $hashZip = hash('sha256', $greZip);

        return json_encode([
            "archivo" => [
                "nomArchivo" => $filenameZip,
                "arcGreZip" => $arcGreZip,
                "hashZip" => $hashZip
            ]
        ]);
    }

    public function guiatsendmanual(Request $request)
    {
        // Limasur 20606971053
        $token = $request->sunattoken;
        // $url = 'https://api-cpe.sunat.gob.pe/v1/contribuyente/gem/comprobantes/' . $request->filename;

        $ruta = __DIR__ . '/../../../../../cpe/files/signed/';
        $filename = $request->filename . '.zip';
        $greZip = file_get_contents($ruta . $filename);
        $arcGreZip = base64_encode($greZip);
        $hashZip = hash('sha256', $greZip);

        // try {
        //     $response = Http::withToken($token)
        //         ->withHeaders([
        //             'Authorization' => $token,
        //         ])
        //         ->withBody([
        //             'archivo' => [
        //                 'nomArchivo' => $filename,
        //                 'arcGreZip' => $arcGreZip,
        //                 'hashZip' => $hashZip,
        //             ]
        //         ])
        //         ->post($url, [
        //             'numRucEmisor' => $request->ruc,
        //             'codCpe' => $request->cpe,
        //             'numSerie' => $request->serie,
        //             'numCpe' => $request->correlativo
        //         ]);
        //     $data = ($response->json());
        //     return json_encode($data);
        // } catch (\Exception $e) {
        //     // Aquí puedes devolver una respuesta JSON con el código de estado y el mensaje de error
        //     return response()->json($e->getMessage());
        //     // return response()->json(['error' => $e->getMessage(), 'code' => $e->getCode()], $e->getCode());
        // }

        return json_encode([
            "archivo" => [
                "nomArchivo" => $filename,
                "arcGreZip" => $arcGreZip,
                "hashZip" => $hashZip
            ]
        ]);
    }
    public function allxmlcreate(Request $request)
    {
        date_default_timezone_set('America/Lima');
        $today = now()->format('Y-m-d H:i:s');

        $logo = "GENERADO DESDE WWW.SATELITAL.ORG 939236638";
        $fecha_emision = now()->format('Y-m-d');
        $hora_emision = now()->format('H:i:s');

        $doc = new \DOMDocument();
        $doc->formatOutput = FALSE;
        $doc->preserveWhiteSpace = TRUE;
        $doc->encoding = 'utf-8';
        $data = (object) $request->json()->all();
        // dd($data->serie);
        // $data = $request->json()->all();
        // dd($data);
        $entidad = strip_tags($request->entidad_razonsocial);
        $entidad = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $entidad);
        $entidad = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $entidad);
        $entidad = str_replace(' & ', ' &amp; ', html_entity_decode((htmlspecialchars_decode($entidad))));
        // 1.- crear documento XML
        $xmlCPE = new \DomDocument('1.0', 'UTF-8');
        //$xmlCPE->xmlStandalone = false;
        $xmlCPE->preserveWhiteSpace = false;
        $Despatch = $xmlCPE->createElement('DespatchAdvice');

        $Despatch_attibute = $xmlCPE->createAttribute('xmlns:ds');
        $Despatch_attibute->value = "http://www.w3.org/2000/09/xmldsig#";
        $Despatch->appendChild($Despatch_attibute);

        $Despatch_attibute = $xmlCPE->createAttribute('xmlns:xsi');
        $Despatch_attibute->value = "http://www.w3.org/2001/XMLSchema-instance";
        $Despatch->appendChild($Despatch_attibute);

        $Despatch_attibute = $xmlCPE->createAttribute('xmlns:qdt');
        $Despatch_attibute->value = "urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2";
        $Despatch->appendChild($Despatch_attibute);

        $Despatch_attibute = $xmlCPE->createAttribute('xmlns:sac');
        $Despatch_attibute->value = "urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1";
        $Despatch->appendChild($Despatch_attibute);

        $Despatch_attibute = $xmlCPE->createAttribute('xmlns:ext');
        $Despatch_attibute->value = "urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2";
        $Despatch->appendChild($Despatch_attibute);

        $Despatch_attibute = $xmlCPE->createAttribute('xmlns:udt');
        $Despatch_attibute->value = "urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2";
        $Despatch->appendChild($Despatch_attibute);

        $Despatch_attibute = $xmlCPE->createAttribute('xmlns:cac');
        $Despatch_attibute->value = "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2";
        $Despatch->appendChild($Despatch_attibute);

        $Despatch_attibute = $xmlCPE->createAttribute('xmlns:cbc');
        $Despatch_attibute->value = "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2";
        $Despatch->appendChild($Despatch_attibute);

        $Despatch_attibute = $xmlCPE->createAttribute('xmlns:ccts');
        $Despatch_attibute->value = "urn:un:unece:uncefact:documentation:2";
        $Despatch->appendChild($Despatch_attibute);

        $Despatch_attibute = $xmlCPE->createAttribute('xmlns');
        $Despatch_attibute->value = "urn:oasis:names:specification:ubl:schema:xsd:DespatchAdvice-2";
        $Despatch->appendChild($Despatch_attibute);

        $Despatch = $xmlCPE->appendChild($Despatch);

        $comment = $xmlCPE->createComment($logo);
        $Despatch->appendChild($comment);

        $level1 = $xmlCPE->createElement('ext:UBLExtensions');
        $Despatch->appendChild($level1);

        $level2 = $xmlCPE->createElement('ext:UBLExtension');
        $level1->appendChild($level2);

        $level3 = $xmlCPE->createElement('ext:ExtensionContent');
        $level2->appendChild($level3);


        $comment = $xmlCPE->createComment($logo);
        $Despatch->appendChild($comment);

        $level1 = $xmlCPE->createElement('cbc:UBLVersionID', '2.1');
        $Despatch->appendChild($level1);

        $level1 = $xmlCPE->createElement('cbc:CustomizationID', '2.0');
        $Despatch->appendChild($level1);

        $level1 = $xmlCPE->createElement('cbc:ID', $request->serie . '-' . $request->number);
        $Despatch->appendChild($level1);

        $level1 = $xmlCPE->createElement('cbc:IssueDate', $request->createdatdate);
        $Despatch->appendChild($level1);

        $level1 = $xmlCPE->createElement('cbc:IssueTime', $request->createdattime);
        $Despatch->appendChild($level1);

        $level1 = $xmlCPE->createElement('cbc:DespatchAdviceTypeCode', 31); //Catálogo No. 01: Código de Tipo de documento
        $Despatch->appendChild($level1);

        // $attribute = $xmlCPE->createAttribute('listAgencyName');
        // $attribute->value = "PE:SUNAT";
        // $level1->appendChild($attribute);

        // $attribute = $xmlCPE->createAttribute('listName');
        // $attribute->value = $data->tipocpe_nombre;
        // $level1->appendChild($attribute);

        // $attribute = $xmlCPE->createAttribute('listURI');
        // $attribute->value = "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo01";
        // $level1->appendChild($attribute);

        $level1 = $xmlCPE->createElement('cbc:Note', $request['nota']);
        $Despatch->appendChild($level1);

        //===============================================================>
        $comment = $xmlCPE->createComment("Datos del Transportista");
        $Despatch->appendChild($comment);

        $level1 = $xmlCPE->createElement('cac:DespatchSupplierParty');
        $Despatch->appendChild($level1);


        // OJO SOLO EN PRUEBA
        $level2 = $xmlCPE->createElement('cbc:CustomerAssignedAccountID', $request->company["ruc"]);
        $level1->appendChild($level2);

        $attribute = $xmlCPE->createAttribute('schemeID');
        $attribute->value = "6";
        $level2->appendChild($attribute);




        $level2 = $xmlCPE->createElement('cac:Party');
        $level1->appendChild($level2);

        $level3 = $xmlCPE->createElement('cac:PartyIdentification');
        $level2->appendChild($level3);

        $level4 = $xmlCPE->createElement('cbc:ID', $request->company["ruc"]);
        $level3->appendChild($level4);

        $attribute = $xmlCPE->createAttribute('schemeID');
        $attribute->value = "6";
        $level4->appendChild($attribute);

        $attribute = $xmlCPE->createAttribute('schemeName');
        $attribute->value = "Documento de Identidad";
        $level4->appendChild($attribute);

        $attribute = $xmlCPE->createAttribute('schemeAgencyName');
        $attribute->value = "PE:SUNAT";
        $level4->appendChild($attribute);

        $attribute = $xmlCPE->createAttribute('schemeURI');
        $attribute->value = "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06";
        $level4->appendChild($attribute);

        $level3 = $xmlCPE->createElement('cac:PartyLegalEntity');
        $level2->appendChild($level3);

        // $level4 = $xmlCPE->createElement('cbc:RegistrationName', $request->company["name"]);
        // $level3->appendChild($level4);

        $companyName = htmlspecialchars($request->company["name"], ENT_XML1, 'UTF-8');
        $level4 = $xmlCPE->createElement('cbc:RegistrationName', $companyName);
        $level3->appendChild($level4);



        // if (isset($request->transportista["autorizacion"])) {
        //     $level4 = $xmlCPE->createElement('cac:AgentParty');
        //     $level3->appendChild($level4);

        //     $level5 = $xmlCPE->createElement('cac:PartyLegalEntity');
        //     $level4->appendChild($level5);

        //     $level6 = $xmlCPE->createElement('cbc:CompanyID', $request->transportista["autorizacion"]);
        //     $level5->appendChild($level6);

        //     $attribute = $xmlCPE->createAttribute('schemeID');
        //     $attribute->value = "Catálogo N° D-37 Ojo arreglar";
        //     $level6->appendChild($attribute);

        //     $attribute = $xmlCPE->createAttribute('schemeName');
        //     $attribute->value = "Entidad Autorizadora Ojo arreglar";
        //     $level6->appendChild($attribute);

        //     $attribute = $xmlCPE->createAttribute('schemeAgencyName');
        //     $attribute->value = "PE:SUNAT";
        //     $level6->appendChild($attribute);
        // }

        //===========================================================//
        foreach ($request->documents as $related) {
            $comment = $xmlCPE->createComment(' Documento Relacionado ');
            $Despatch->appendChild($comment);

            $level1 = $xmlCPE->createElement('cac:AdditionalDocumentReference');
            $Despatch->appendChild($level1);

            $level2 = $xmlCPE->createElement('cbc:DocumentType', $related["tipocpe"]['name']);
            $level1->appendChild($level2);

            $level2 = $xmlCPE->createElement('cbc:DocumentTypeCode', $related["tipocpe"]["value"]);
            $level1->appendChild($level2);

            $attribute = $xmlCPE->createAttribute('listAgencyName');
            $attribute->value = "PE:SUNAT";
            $level2->appendChild($attribute);

            $attribute = $xmlCPE->createAttribute('listName');
            $attribute->value = "Documento relacionado al transporte";
            $level2->appendChild($attribute);

            $attribute = $xmlCPE->createAttribute('listURI');
            $attribute->value = "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo61";
            $level2->appendChild($attribute);

            $level2 = $xmlCPE->createElement('cbc:ID', $related["number"]);
            $level1->appendChild($level2);

            $level2 = $xmlCPE->createElement('cac:IssuerParty');
            $level1->appendChild($level2);

            $level3 = $xmlCPE->createElement('cac:PartyIdentification');
            $level2->appendChild($level3);

            $level4 = $xmlCPE->createElement('cbc:ID', $related["ruc"]);
            $level3->appendChild($level4);

            $attribute = $xmlCPE->createAttribute('schemeID');
            $attribute->value = "6";
            $level2->appendChild($attribute);

            $attribute = $xmlCPE->createAttribute('schemeAgencyName');
            $attribute->value = "PE:SUNAT";
            $level2->appendChild($attribute);

            $attribute = $xmlCPE->createAttribute('schemeURI');
            $attribute->value = "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06";
            $level2->appendChild($attribute);
        }


        //=================================================================>>
        $comment = $xmlCPE->createComment(' Datos del Destinatario ');
        $Despatch->appendChild($comment);

        $level1 = $xmlCPE->createElement('cac:DeliveryCustomerParty');
        $Despatch->appendChild($level1);

        $level2 = $xmlCPE->createElement('cac:Party');
        $level1->appendChild($level2);

        $level3 = $xmlCPE->createElement('cac:PartyIdentification');
        $level2->appendChild($level3);

        $level4 = $xmlCPE->createElement('cbc:ID', $request->destination["numberid"]);
        $level3->appendChild($level4);

        $attribute = $xmlCPE->createAttribute('schemeID');
        $attribute->value = $request->destination["codeid"];
        $level4->appendChild($attribute);

        $attribute = $xmlCPE->createAttribute('schemeName');
        $attribute->value = "Documento de Identidad";
        // $attribute->value = "Registro Único de Contribuyentes";
        $level4->appendChild($attribute);

        $attribute = $xmlCPE->createAttribute('schemeAgencyName');
        $attribute->value = "PE:SUNAT";
        $level4->appendChild($attribute);

        $attribute = $xmlCPE->createAttribute('schemeURI');
        $attribute->value = "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06";
        $level4->appendChild($attribute);

        $level3 = $xmlCPE->createElement('cac:PartyLegalEntity');
        $level2->appendChild($level3);

        $level4 = $xmlCPE->createElement('cbc:RegistrationName', $request->destination["name"]);
        $level3->appendChild($level4);






        //================================================================>>
        $comment = $xmlCPE->createComment(' Datos del Traslado ');
        $Despatch->appendChild($comment);

        $level1 = $xmlCPE->createElement('cac:Shipment');
        $Despatch->appendChild($level1);

        $level2 = $xmlCPE->createElement('cbc:ID', "SUNAT_Envio"); // an11
        $level1->appendChild($level2);

        $level2 = $xmlCPE->createElement('cbc:GrossWeightMeasure', $request->pesobruto); //n12,3 Peso bruto total de la carga
        $level1->appendChild($level2);

        $attribute = $xmlCPE->createAttribute('unitCode');
        $attribute->value = "KGM"; // an3 KGM TNE
        $level2->appendChild($attribute);

        $level2 = $xmlCPE->createElement('cbc:SpecialInstructions', $request['tipoindicador']); //an50 Indicador de retorno de vehículo con envases o embalajes vacíos
        $level1->appendChild($level2);

        $level2 = $xmlCPE->createElement('cac:ShipmentStage');
        $level1->appendChild($level2);

        $level3 = $xmlCPE->createElement('cac:TransitPeriod');
        $level2->appendChild($level3);

        $level4 = $xmlCPE->createElement('cbc:StartDate', $request->release_date); //Fecha Inicio de traslado
        $level3->appendChild($level4);

        //==================================================================>
        $comment = $xmlCPE->createComment("Permisos del Transportista");
        $level2->appendChild($comment);

        $level3 = $xmlCPE->createElement('cac:CarrierParty');
        $level2->appendChild($level3);

        $level4 = $xmlCPE->createElement('cac:PartyLegalEntity');
        $level3->appendChild($level4);

        $level5 = $xmlCPE->createElement('cbc:CompanyID', $request->vehicle["tuc"]);
        $level4->appendChild($level5);

        // Solo en PRUEBA

        $level3 = $xmlCPE->createElement('cac:TransportMeans');
        $level2->appendChild($level3);

        $level4 = $xmlCPE->createElement('cac:RoadTransport');
        $level3->appendChild($level4);

        $level5 = $xmlCPE->createElement('cbc:LicensePlateID', $request->vehicle["matricula"]);
        $level4->appendChild($level5);




        //===============================================================>>
        $comment = $xmlCPE->createComment(' Conductor Principal ');
        $level2->appendChild($comment);

        $level3 = $xmlCPE->createElement('cac:DriverPerson');
        $level2->appendChild($level3);

        $level4 = $xmlCPE->createElement('cbc:ID', $request->driver["documento"]); // an15 (Catálogo N° 06) Tipo y número de documento de identidad del conductor
        $level3->appendChild($level4);

        $attribute = $xmlCPE->createAttribute('schemeID');
        $attribute->value = $request->driver["doctipocod"]; // an 1 Tipo de documento de identidad
        $level4->appendChild($attribute);

        // $attribute = $xmlCPE->createAttribute('schemeName');
        // $attribute->value = "Documento Nacional de Identidad"; //Documento de identidad
        // $level4->appendChild($attribute);

        // $attribute = $xmlCPE->createAttribute('schemeAgencyName');
        // $attribute->value = "PE:SUNAT";
        // $level4->appendChild($attribute);

        // $attribute = $xmlCPE->createAttribute('schemeURI');
        // $attribute->value = "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06";
        // $level4->appendChild($attribute);

        $level4 = $xmlCPE->createElement('cbc:FirstName',  $request->driver["name"]);
        $level3->appendChild($level4);

        $level4 = $xmlCPE->createElement('cbc:FamilyName',  $request->driver["lastname"]);
        $level3->appendChild($level4);

        $level4 = $xmlCPE->createElement('cbc:JobTitle', "Principal"); // an9 Tipo de conductor
        $level3->appendChild($level4);

        $level4 = $xmlCPE->createElement('cac:IdentityDocumentReference');
        $level3->appendChild($level4);

        $level5 = $xmlCPE->createElement('cbc:ID',  $request->driver["licence"]); //an10 Num Licencia de Conducir
        $level4->appendChild($level5);


        //=============================================================>>
        if (isset($request->conductor2["licencia"])) {

            $comment = $xmlCPE->createComment(' Conductores Secundarios ');
            $level2->appendChild($comment);

            $level3 = $xmlCPE->createElement('cac:DriverPerson');
            $level2->appendChild($level3);

            $level4 = $xmlCPE->createElement('cbc:JobTitle', "Secundario"); // an9 Tipo de conductor
            $level3->appendChild($level4);

            $level4 = $xmlCPE->createElement('cbc:ID', $request->conductor2["documento"]); // an15 (Catálogo N° 06) Tipo y número de documento de identidad del conductor2
            $level3->appendChild($level4);

            $attribute = $xmlCPE->createAttribute('schemeID');
            $attribute->value = $request->conductor2["doctipocod"]; // an 1 Tipo de documento de identidad
            $level4->appendChild($attribute);

            $attribute = $xmlCPE->createAttribute('schemeName');
            $attribute->value = $request->conductor2["doctipo"]; //Documento de identidad
            $level4->appendChild($attribute);

            $attribute = $xmlCPE->createAttribute('schemeAgencyName');
            $attribute->value = "PE:SUNAT";
            $level4->appendChild($attribute);

            $attribute = $xmlCPE->createAttribute('schemeURI');
            $attribute->value = "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06";
            $level4->appendChild($attribute);

            $level4 = $xmlCPE->createElement('cbc:FirstName', $request->conductor2["name"]);
            $level3->appendChild($level4);

            $level4 = $xmlCPE->createElement('cbc:FamilyName', $request->conductor2["lastname"]);
            $level3->appendChild($level4);

            $level4 = $xmlCPE->createElement('cac:IdentityDocumentReference');
            $level3->appendChild($level4);

            $level5 = $xmlCPE->createElement('cbc:ID', $request->conductor2["licence"]); //an10 Num Licencia de Conducir
            $level4->appendChild($level5);
        }

        $level2 = $xmlCPE->createElement('cac:Delivery');
        $level1->appendChild($level2);

        //=====================================================================>>
        $comment = $xmlCPE->createComment(' Direccion del Punto de Llegada ');
        $level2->appendChild($comment);

        $level3 = $xmlCPE->createElement('cac:DeliveryAddress');
        $level2->appendChild($level3);

        $level4 = $xmlCPE->createElement('cbc:ID', $request->destinationbranch["ubigeo"]); //Ubigeo
        $level3->appendChild($level4);

        $attribute = $xmlCPE->createAttribute('schemeAgencyName');
        $attribute->value = "PE:INEI";
        $level4->appendChild($attribute);

        $attribute = $xmlCPE->createAttribute('schemeName');
        $attribute->value = "Ubigeos";
        $level4->appendChild($attribute);

        $level4 = $xmlCPE->createElement('cac:AddressLine');
        $level3->appendChild($level4);

        $level5 = $xmlCPE->createElement('cbc:Line', $request->destinationbranch["address"]); //Direccion completa y detallada de llegada
        $level4->appendChild($level5);

        // if (isset($request->llegada["latitud"]) && isset($request->llegada["longitud"])) {
        //     $level4 = $xmlCPE->createElement('cac:LocationCoordinate');
        //     $level3->appendChild($level4);

        //     $level5 = $xmlCPE->createElement('cbc:LatitudeDegreesMeasure', $request->llegada["latitud"]); // (Longitud n 3,8 Punto de georreferencia de llegada
        //     $level4->appendChild($level5);

        //     $attribute = $xmlCPE->createAttribute('unitCode'); // an2
        //     $attribute->value = "DD";
        //     $level5->appendChild($attribute);

        //     $level5 = $xmlCPE->createElement('cbc:LongitudeDegreesMeasure', $request->llegada["longitud"]); // (Longitud n 3,8 Punto de georreferencia de llegada
        //     $level4->appendChild($level5);

        //     $attribute = $xmlCPE->createAttribute('unitCode'); // an2
        //     $attribute->value = "DD";
        //     $level5->appendChild($attribute);
        // }

        //==================================================================>>
        $comment = $xmlCPE->createComment(' Direccion del Punto de Partida ');
        $level2->appendChild($comment);

        $level3 = $xmlCPE->createElement('cac:Despatch');
        $level2->appendChild($level3);

        $level4 = $xmlCPE->createElement('cac:DespatchAddress');
        $level3->appendChild($level4);

        $level5 = $xmlCPE->createElement('cbc:ID', $request->senderbranch["ubigeo"]); //Ubigeo de partida
        $level4->appendChild($level5);

        $attribute = $xmlCPE->createAttribute('schemeAgencyName');
        $attribute->value = "PE:INEI";
        $level5->appendChild($attribute);

        $attribute = $xmlCPE->createAttribute('schemeName');
        $attribute->value = "Ubigeos";
        $level5->appendChild($attribute);

        $level5 = $xmlCPE->createElement('cac:AddressLine');
        $level4->appendChild($level5);

        $level6 = $xmlCPE->createElement('cbc:Line', $request->senderbranch["address"]); //Direccion completa y detallada de partida
        $level5->appendChild($level6);

        // if (isset($request->partida["latitud"]) && isset($request->partida["longitud"])) {
        //     $level5 = $xmlCPE->createElement('cac:LocationCoordinate');
        //     $level4->appendChild($level5);

        //     $level6 = $xmlCPE->createElement('cbc:LatitudeDegreesMeasure', $request->partida["latitud"]); // (Longitud n 3,8 Punto de georreferencia de partida
        //     $level5->appendChild($level6);

        //     $attribute = $xmlCPE->createAttribute('unitCode'); // an2
        //     $attribute->value = "DD";
        //     $level6->appendChild($attribute);

        //     $level6 = $xmlCPE->createElement('cbc:LongitudeDegreesMeasure', $request->partida["longitud"]); // (Longitud n 3,8 Punto de georreferencia de partida
        //     $level5->appendChild($level6);

        //     $attribute = $xmlCPE->createAttribute('unitCode'); // an2
        //     $attribute->value = "DD";
        //     $level6->appendChild($attribute);
        // }

        //==============================================================>>
        $comment = $xmlCPE->createComment(' Datos del Remitente ');
        $level3->appendChild($comment);

        $level4 = $xmlCPE->createElement('cac:DespatchParty');
        $level3->appendChild($level4);

        $level5 = $xmlCPE->createElement('cac:PartyIdentification');
        $level4->appendChild($level5);

        $level6 = $xmlCPE->createElement('cbc:ID', $request->sender["numberid"]);
        $level5->appendChild($level6);

        $attribute = $xmlCPE->createAttribute('schemeID');
        $attribute->value = $request->sender["codeid"];
        $level6->appendChild($attribute);

        $attribute = $xmlCPE->createAttribute('schemeName');
        $attribute->value = "Documento de Identidad";
        // $attribute->value = "Registro Único de Contribuyentes";
        $level6->appendChild($attribute);

        $attribute = $xmlCPE->createAttribute('schemeAgencyName');
        $attribute->value = "PE:SUNAT";
        $level6->appendChild($attribute);

        $attribute = $xmlCPE->createAttribute('schemeURI');
        $attribute->value = "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06";
        $level6->appendChild($attribute);

        $level5 = $xmlCPE->createElement('cac:PartyLegalEntity');
        $level4->appendChild($level5);

        $level6 = $xmlCPE->createElement('cbc:RegistrationName', $request->sender["name"]);
        $level5->appendChild($level6);


        //================================================================>>
        $comment = $xmlCPE->createComment(' Vehículo Principal ');
        $level1->appendChild($comment);

        $level2 = $xmlCPE->createElement('cac:TransportHandlingUnit');
        $level1->appendChild($level2);

        $level3 = $xmlCPE->createElement('cac:TransportEquipment');
        $level2->appendChild($level3);

        $level4 = $xmlCPE->createElement('cbc:ID', $request->vehicle["matricula"]); //an8 Número de placa del vehiculo
        $level3->appendChild($level4);

        $level4 = $xmlCPE->createElement('cac:ApplicableTransportMeans');
        $level3->appendChild($level4);

        $level5 = $xmlCPE->createElement('cbc:RegistrationNationalityID', $request->vehicle["tuc"]); //an15 Tarjeta Única de Circulación Electrónica o Certificado de Habilitación vehicular
        $level4->appendChild($level5);

        // $level4 = $xmlCPE->createElement('cac:ShipmentDocumentReference');
        // $level3->appendChild($level4);

        // $level5 = $xmlCPE->createElement('cbc:ID', $request->vehiculo["autorizacion"]); //an50 Número de autorización del vehículo emitido por la entidad - vehículo principal
        // $level4->appendChild($level5);

        // $attribute = $xmlCPE->createAttribute('schemeID'); // an2 (Catálogo N° D-37)
        // $attribute->value = "15";
        // $level5->appendChild($attribute);

        // $attribute = $xmlCPE->createAttribute('schemeName');
        // $attribute->value = "Entidad Autorizadora";
        // $level5->appendChild($attribute);

        // $attribute = $xmlCPE->createAttribute('schemeAgencyName');
        // $attribute->value = "PE:SUNAT";
        // $level5->appendChild($attribute);


        //========================================================>>
        if (isset($request->vehiculo2["matricula"])) {
            $comment = $xmlCPE->createComment(' Vehículos Secundarios ');
            $Despatch->appendChild($comment);

            $level1 = $xmlCPE->createElement('cac:Shipment');
            $Despatch->appendChild($level1);

            $level2 = $xmlCPE->createElement('cac:TransportHandlingUnit');
            $level1->appendChild($level2);

            $level3 = $xmlCPE->createElement('cac:TransportEquipment');
            $level2->appendChild($level3);

            $level3 = $xmlCPE->createElement('cac:AttachedTransportEquipment');
            $level2->appendChild($level3);

            $level4 = $xmlCPE->createElement('cbc:ID', $request->vehiculo2["matricula"]); //an8 Número de placa del vehiculo
            $level3->appendChild($level4);

            $level4 = $xmlCPE->createElement('cac:ApplicableTransportMeans');
            $level3->appendChild($level4);

            $level5 = $xmlCPE->createElement('cbc:RegistrationNationalityID', $request->vehiculo2["tuc"]); //an15 Tarjeta Única de Circulación Electrónica o Certificado de Habilitación vehicular
            $level4->appendChild($level5);

            // $level4 = $xmlCPE->createElement('cac:ShipmentDocumentReference');
            // $level3->appendChild($level4);

            // $level5 = $xmlCPE->createElement('cbc:ID', $request->vehiculo2["autorizacion"]); //an50 Número de autorización del vehículo emitido por la entidad - vehículo principal
            // $level4->appendChild($level5);

            // $attribute = $xmlCPE->createAttribute('schemeID'); // an2 (Catálogo N° D-37)
            // $attribute->value = "15";
            // $level5->appendChild($attribute);

            // $attribute = $xmlCPE->createAttribute('schemeName');
            // $attribute->value = "Entidad Autorizadora";
            // $level5->appendChild($attribute);

            // $attribute = $xmlCPE->createAttribute('schemeAgencyName');
            // $attribute->value = "PE:SUNAT";
            // $level5->appendChild($attribute);
        }






        //==================================================================>>
        $comment = $xmlCPE->createComment(' Bienes a transportar ');
        $Despatch->appendChild($comment);
        $index = 0;
        foreach ($request->items as $item) {
            $index++;
            $level1 = $xmlCPE->createElement('cac:DespatchLine');
            $Despatch->appendChild($level1);

            $level2 = $xmlCPE->createElement('cbc:ID', $index);
            $level1->appendChild($level2);

            $level2 = $xmlCPE->createElement('cbc:DeliveredQuantity', "10"); //n12,10 Cantidad
            $level1->appendChild($level2);

            $attribute = $xmlCPE->createAttribute('unitCode');
            $attribute->value = $item["unity"]["abbreviation"];
            $level2->appendChild($attribute);

            $attribute = $xmlCPE->createAttribute('unitCodeListID');
            $attribute->value = "UN/ECE rec 20";
            $level2->appendChild($attribute);

            $attribute = $xmlCPE->createAttribute('unitCodeListAgencyName');
            $attribute->value = "United Nations Economic Commission for Europe";
            $level2->appendChild($attribute);

            $level2 = $xmlCPE->createElement('cac:OrderLineReference');
            $level1->appendChild($level2);

            $level3 = $xmlCPE->createElement('cbc:LineID', $item["id"]);
            $level2->appendChild($level3);

            $level2 = $xmlCPE->createElement('cac:Item');
            $level1->appendChild($level2);

            $level3 = $xmlCPE->createElement('cbc:Description', $item["product"]["name"]);
            $level2->appendChild($level3);

            $level3 = $xmlCPE->createElement('cac:SellersItemIdentification');
            $level2->appendChild($level3);

            $level4 = $xmlCPE->createElement('cbc:ID', $item["product"]["id"]);
            $level3->appendChild($level4);

            // $level3 = $xmlCPE->createElement('cac:CommodityClassification');
            // $level2->appendChild($level3);

            // $level4 = $xmlCPE->createElement('cbc:ItemClassificationCode', $item["cod_producto"]);
            // $level3->appendChild($level4);

            // $level3 = $xmlCPE->createElement('cac:StandardItemIdentification');
            // $level2->appendChild($level3);

            // $level4 = $xmlCPE->createElement('cbc:ID');  // Código GTIN
            // $level3->appendChild($level4);

            // $attribute = $xmlCPE->createAttribute('schemeID');
            // $attribute->value = "DFFF"; //Tipo de estructura GTIN
            // $level4->appendChild($attribute);

            // $level3 = $xmlCPE->createElement('cac:AdditionalItemProperty');
            // $level2->appendChild($level3);

            // $level3 = $xmlCPE->createElement('cbc:Name');  //Nombre del concepto Partida arancelaria
            // $level2->appendChild($level3);

            // $level3 = $xmlCPE->createElement('cbc:NameCode'); //Código del concepto
            // $level2->appendChild($level3);

            // $attribute = $xmlCPE->createAttribute('listName');
            // $attribute->value = "Propiedad del item"; //Tipo de estructura GTIN
            // $level3->appendChild($attribute);

            // $attribute = $xmlCPE->createAttribute('listURI');
            // $attribute->value = "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo55"; //Tipo de estructura GTIN
            // $level3->appendChild($attribute);

            // $level3 = $xmlCPE->createElement('cac:AdditionalItemProperty');
            // $level2->appendChild($level3);

            // $level4 = $xmlCPE->createElement('cbc:Value'); //Partida arancelaria an10
            // $level3->appendChild($level4);

            // $level4 = $xmlCPE->createElement('cbc:Value', "0"); //Indicador de bien normalizado 0, 1
            // $level3->appendChild($level4);
        }







        // $level1 = $xmlCPE->createElement('cac:DespatchLine');
        // $Despatch->appendChild($level1);

        // $level2 = $xmlCPE->createElement('cbc:ID', "0"); //n1 Anotacion adicional sobre los bienes a transportar
        // $level1->appendChild($level2);

        // $level2 = $xmlCPE->createElement('cac:OrderLineReference');
        // $level1->appendChild($level2);

        // $level3 = $xmlCPE->createElement('cbc:LineID');
        // $level2->appendChild($level3);

        // $level2 = $xmlCPE->createElement('cac:Item');
        // $level1->appendChild($level2);

        // $level3 = $xmlCPE->createElement('cbc:Description', ""); //an500
        // $level2->appendChild($level3);


        // $level2 = $xmlCPE->createElement('cbc:SpecialInstructions', "SUNAT_Envio_IndicadorTrasladoTotal"); //an50 Indicador de traslado total de bienes
        // $level1->appendChild($level2);

        // $level2 = $xmlCPE->createElement('cbc:SpecialInstructions', "SUNAT_Envio_IndicadorRetornoVehiculoVacio"); //an50
        // $level1->appendChild($level2);

        // $level2 = $xmlCPE->createElement('cbc:SpecialInstructions', "SUNAT_Envio_IndicadorTransbordoProgramado"); //an50
        // $level1->appendChild($level2);

        // $level2 = $xmlCPE->createElement('cbc:SpecialInstructions', "SUNAT_Envio_IndicadorTrasporteSubcontratado"); //an50
        // $level1->appendChild($level2);

        // $level2 = $xmlCPE->createElement('cac:ShipmentStage'); //Solo poara guia por eventos
        // $level1->appendChild($level2);

        // $level3 = $xmlCPE->createElement('cac:TransportEvent'); //Solo poara guia por eventos
        // $level2->appendChild($level3);

        // $level4 = $xmlCPE->createElement('cbc:TransportEventTypeCode', "1"); //an1 1-Transbordo no programado  2-Imposibilidad arribo  3-Imposibilidad entrega //Solo poara guia por eventos
        // $level3->appendChild($level4);

        //======================================================>>>
        // $comment = $xmlCPE->createComment(' Datos de empresa que subcontrata ');
        // $level1->appendChild($comment);

        // $level2 = $xmlCPE->createElement('cac:Consignment');
        // $level1->appendChild($level2);

        // $level3 = $xmlCPE->createElement('cbc:ID', "SUNAT_Envio"); //Identificador obligatorio
        // $level2->appendChild($level3);

        // $level3 = $xmlCPE->createElement('cac:LogisticsOperatorParty');
        // $level2->appendChild($level3);

        // $level4 = $xmlCPE->createElement('cac:PartyIdentification'); //
        // $level3->appendChild($level4);

        // $level5 = $xmlCPE->createElement('cbc:ID', "20625252524"); //número de documento de identidad  del subcontratador
        // $level4->appendChild($level5);

        // $attribute = $xmlCPE->createAttribute('schemeID');
        // $attribute->value = "6"; // Tipo de documento
        // $level5->appendChild($attribute);

        // $level4 = $xmlCPE->createElement('cac:PartyLegalEntity'); //
        // $level3->appendChild($level4);

        // $level5 = $xmlCPE->createElement('cac:PartyLegalEntity', "NOVATEXH SAC"); //an 250 razón social del subcontratador
        // $level4->appendChild($level5);

        //=================================================================>>
        // $comment = $xmlCPE->createComment(' Datos quien paga el servicio de transporte - solo se completa cuando paga un tercero ');
        // $Despatch->appendChild($comment);

        // $level1 = $xmlCPE->createElement('cac:OriginatorCustomerParty');
        // $Despatch->appendChild($level1);

        // $level2 = $xmlCPE->createElement('cac:Party');
        // $level1->appendChild($level2);

        // $level3 = $xmlCPE->createElement('cac:PartyIdentification');
        // $level2->appendChild($level3);

        // $level4 = $xmlCPE->createElement('cbc:ID', "20612554545"); //an15 numero de documento de identidad
        // $level3->appendChild($level4);

        // $attribute = $xmlCPE->createAttribute('schemeID');
        // $attribute->value = "6"; //an1 Tipo de documento de identidad
        // $level5->appendChild($attribute);

        // $level3 = $xmlCPE->createElement('cac:PartyLegalEntity');
        // $level2->appendChild($level3);

        // $level4 = $xmlCPE->createElement('cbc:RegistrationName', "NOVATECH SAC"); //an250 razón social de quien paga el servicio
        // $level3->appendChild($level4);

        $comment = $xmlCPE->createComment($logo);
        $Despatch->appendChild($comment);
        //Se eliminan espacios en blanco
        $xmlCPE->preserveWhiteSpace = false;
        $xmlCPE->formatOutput = true;
        //Se instancia el objeto
        $strings_xml = $xmlCPE->saveXML();

        //GUARDAR DOCUMENTO XML EN facturas-sin-firmar
        date_default_timezone_set('America/Lima');
        require __DIR__ . '/../../../../../vendor/autoload.php';
        $rutaBase = __DIR__ . "/../../../../../cpe/files/base/";
        $rutaSign = __DIR__ . '/../../../../../cpe/files/signed/';
        $rutaCert = __DIR__ . '/../../../../../cpe/certificates/limasur/';
        $filename = $request->company["ruc"] . '-' . $request->tipocpe . '-' . $request->serie . '-' . $request->number;
        $filenameXml = $filename . '.xml';
        $filenameZip = $filename . '.zip';

        //  GRABAR XML;
        $xmlCPE->save($rutaBase . $filenameXml);
        chmod($rutaBase . $filenameXml, 0777);
        // \Storage::disk('local')->put($_ruta . $filename,$strings_xml);


        //  FIRMADO DIGITAL
        $xml = file_get_contents($rutaBase . $filenameXml);
        $cert = file_get_contents($rutaCert . 'certificadolimasur.pem');

        $signer = new SignedXml();
        $signer->setCertificate($cert);

        $xmlSigned = $signer->signXml($xml);

        file_put_contents($rutaSign . $filenameXml, $xmlSigned);

        $zip = new \ZipArchive();
        $zip->open($rutaSign . $filenameZip, \ZipArchive::CREATE);
        $zip->addFile($rutaSign . $filenameXml, $filenameXml);
        $zip->close();

        $greZip = file_get_contents($rutaSign . $filenameZip);
        $arcGreZip = base64_encode($greZip);
        $hashZip = hash('sha256', $greZip);

        return json_encode([
            "archivo" => [
                "nomArchivo" => $filenameZip,
                "arcGreZip" => $arcGreZip,
                "hashZip" => $hashZip
            ]
        ]);
    }
    public function getTokenSunat(Request $request)
    {
        $user = Auth::user();
        $ruc = Company::where('id', $user->company_id)->pluck('ruc')->first();
        $usuarioapisunat = Crypt::decryptString(Datakey::where('company_id', $user->company_id)
            ->where('label', 'usuarioapisunat')->pluck('content')->first());
        $claveapisunat = Crypt::decryptString(Datakey::where('company_id', $user->company_id)
            ->where('label', 'claveapisunat')->pluck('content')->first());
        $usuariosunat = Crypt::decryptString(Datakey::where('company_id', $user->company_id)
            ->where('label', 'usuariosunat')->pluck('content')->first());
        $clavesolsunat = Crypt::decryptString(Datakey::where('company_id', $user->company_id)
            ->where('label', 'clavesolsunat')->pluck('content')->first());

        $response = Http::withHeaders([
            'Content-Type' => 'application/json', // Cambia a Content-Type: application/json
        ])->asForm()->post('https://api-seguridad.sunat.gob.pe/v1/clientessol/' . $usuarioapisunat . '/oauth2/token', [
            'grant_type' => 'password',
            'scope' => 'https://api-cpe.sunat.gob.pe',
            'client_id' => $usuarioapisunat,
            'client_secret' => $claveapisunat,
            'username' => $ruc . $usuariosunat,
            'password' => $clavesolsunat,
        ]);

        return $response->json();
    }

    public function sendGuideCarrier(Request $request)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json', // Cambia a Content-Type: application/json
        ])->withToken($request->stkn)->retry(3, 100)->withQueryParameters([
            'numRucEmisor' => $request->numRucEmisor,
            'codCpe' => $request->codCpe,
            'numSerie' => $request->numSerie,
            'numCpe' => $request->numCpe,
        ])->post('https://api-cpe.sunat.gob.pe/v1/contribuyente/gem/comprobantes/' . $request->numRucEmisor . '-' . $request->codCpe . '-' . $request->numSerie . '-' . $request->numCpe, [
            'archivo' => $request->archivo,
        ]);

        Guidecarrier::where('id', $request->id)->update([
            'numTicket' => $response["numTicket"],
            'fecRecepcion' =>  $response["fecRecepcion"],
            'status' =>  2, //Estado 2: Enviado
        ]);

        return $response->json();
        // return json_encode(['archivo' => $request->archivo]);
    }

    public function getTiketRequest(Request $request)
    {
        $endpoint = 'https://api-cpe.sunat.gob.pe/v1/contribuyente/gem/comprobantes/envios/' . $request->numTicket;
        // dd($endpoint);
        $invoiceserie = $request->serie;
        $number = $request->number;
        $sunattoken = $request->sunattoken;
        try {
            $response = Http::withHeaders(['Accept' => 'application/json'])
                ->withToken($sunattoken)
                ->get($endpoint);
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
        $arcCdr = null;
        $numError = null;
        $desError = null;
        $indCdrGenerado = null;
        $status = 0;
        // en proceso
        if ($response["codRespuesta"] === "98") {
            $status = 2;
        }
        // Respuesta con Error
        if ($response["codRespuesta"] === "99") {
            if ($response["indCdrGenerado"] === "1") {
                $arcCdr = $response["arcCdr"];
                $numError = $response["error"]["numError"];
                $desError = $response["error"]["desError"];
                $indCdrGenerado = $response["indCdrGenerado"];
                $status = 4;
            } else {
                $numError = $response["error"]["numError"];
                $desError = $response["error"]["desError"];
                $indCdrGenerado = $response["indCdrGenerado"];
                $status = 3;
            }
        }
        // Respuesta envío Ok
        if ($response["codRespuesta"] === "0") {
            $arcCdr = $response["arcCdr"];
            $indCdrGenerado = $response["indCdrGenerado"];
            $status = 5;
        }
        return json_encode([
            "codRespuesta" => $response["codRespuesta"],
            "numError" => $numError,
            "desError" => $desError,
            "indCdrGenerado" => $indCdrGenerado,
            "arcCdr" => $arcCdr,
            "idCdr" => $invoiceserie . '-' . $number,
            "status" => $status
        ]);
    }

    public function guiaGetCdr(Request $request)
    {
        $ruta = __DIR__ . '/../../../../../cpe/files/cdr/';
        $nombreArchivo = 'cdrfile.zip';
        $arcCdrDecodificado = base64_decode($request["arcCdr"]);

        file_put_contents($ruta . $nombreArchivo, $arcCdrDecodificado);

        // Extraer el archivo Zip
        $zip = new ZipArchive();
        if ($zip->open($ruta . $nombreArchivo) !== true) {
            dd('fallo');
            throw new \Exception('Could not download zip file');
        }
        $zip->extractTo($ruta);
        $zip->close();
        File::delete($ruta . $nombreArchivo);
        $nombreArchivoR = "R-20606971053-31-" . $request["idCdr"];
        $nombreArchivo = "20606971053-31-" . $request["idCdr"];
        $rutaArchivoXML = $ruta . $nombreArchivoR . '.xml';
        $contenidoXML = File::get($rutaArchivoXML);
        $xml = new \SimpleXMLElement($contenidoXML);

        if ($request->codRespuesta === "0") {
            $documentDescriptionValue = (string) $xml->xpath('//cbc:DocumentDescription')[0];
            $descriptionValue = (string) $xml->xpath('//cbc:Description')[0];
            $note0Value = (string) $xml->xpath('//cbc:Note')[0];
            if (isset($xml->xpath('//cbc:Note')[1])) {
                $note1Value = (string) $xml->xpath('//cbc:Note')[1];
            }
            if (isset($xml->xpath('//cbc:Note')[2])) {
                $note2Value = (string) $xml->xpath('//cbc:Note')[2];
            }

            // Actualizar sentstatus en la tabla invoice
            Guidecarrier::where('id', $request->id)->update([
                'hash' => $documentDescriptionValue,
                'filename' => $nombreArchivo
            ]);

            $pdfPath = 'public/pdf/' . $nombreArchivo . '.pdf';
            Storage::putFile($pdfPath, $documentDescriptionValue);

            $tempFile = $ruta . $nombreArchivo . '.pdf';
            copy($documentDescriptionValue, $tempFile);

            $result = [
                'description' => $descriptionValue,
                'note0' => $note0Value,
                'note1' => $note1Value,
                'note2' => isset($note2Value) ? $note2Value : "",
                'hash' => $documentDescriptionValue,
                'Error' => [
                    'Codigo' => "0",
                    'Mensaje' => '',
                ],
            ];
        }



        if ($request->codRespuesta === "99") {
            Guidecarrier::where('id', $request->id)->update(['status' => 6]);
            $result = [
                "codRespuesta" => $request->codRespuesta,
                "message" => "envío con error",
            ];
        }

        if ($request->codRespuesta === "98") {
            Guidecarrier::where('id', $request->id)->update(['status' => 2]);
            $result = [
                "codRespuesta" => $request->codRespuesta,
                "message" => "En proceso",
            ];
        }

        return json_encode($result);
    }
}
