<?php

require (dirname(__FILE__) . "/../psf/psf.php");
require (dirname(__FILE__) . "/../psf/includes/unit_test/ut.php");

define('G_DNSTOOL_ENTRY_POINT', 'unit.php');

require_once (dirname(__FILE__) . "/../config.default.php");
require_once (dirname(__FILE__) . "/../includes/record_list.php");
require_once (dirname(__FILE__) . "/../includes/zones.php");

$ut = new UnitTest();

$ut->Evaluate('Check for non-existence of PTR zones (none) in empty list', Zones::HasPTRZones() === false);
$g_domains['168.192.in-addr.arpa'] = [ ];
$g_domains['192.in-addr.arpa'] = [ ];
$ut->Evaluate('Check for non-existence of PTR zones (none) in empty list', Zones::HasPTRZones() === true);
$ut->Evaluate('Get zone for FQDN', Zones::GetZoneForFQDN('0.0.168.192.in-addr.arpa') == '168.192.in-addr.arpa');

$dz1 = raw_zone_to_array(file_get_contents('testdata/valid.zone1'));
$dz2 = raw_zone_to_array(file_get_contents('testdata/invalid.zone'));

$ut->Evaluate('Check validness of valid zone testdata/valid.zone1', CheckIfZoneIsComplete($dz1) === true);
$ut->Evaluate('Check validness of invalid zone testdata/invalid.zone', CheckIfZoneIsComplete($dz2) === false);
$ut->Evaluate('Check count of records in testdata/valid.zone1', count($dz1) === 389);

echo ("\n");
$ut->PrintResults();

$ut->Exit();
