<?php

/*
  BBOX=2.38443,48.9322,27.7053,55.0289
 */

$rootpath = '../../';
header('Content-type: text/html; charset=utf-8');
require($rootpath . 'lib/common.inc.php');

$bbox = isset($_REQUEST['BBOX']) ? $_REQUEST['BBOX'] : '0,0,0,0';
$abox = mb_split(',', $bbox);

if (count($abox) != 4)
    exit;

if (!is_numeric($abox[0]))
    exit;
if (!is_numeric($abox[1]))
    exit;
if (!is_numeric($abox[2]))
    exit;
if (!is_numeric($abox[3]))
    exit;

$lat_from = $abox[1];
$lon_from = $abox[0];
$lat_to = $abox[3];
$lon_to = $abox[2];

if ((abs($lon_from - $lon_to) > 2) || (abs($lat_from - $lat_to) > 2)) {
    $lon_from = $lon_to;
    $lat_from = $lat_to;
}

$rs = sql("SELECT `caches`.`cache_id` `cacheid`, `caches`.`longitude` `longitude`, `caches`.`latitude` `latitude`, `caches`.`type` `type`, `caches`.`date_hidden` `date_hidden`, `caches`.`name` `name`, `cache_type`.`pl` `typedesc`, `cache_size`.`pl` `sizedesc`, `caches`.`terrain` `terrain`, `caches`.`difficulty` `difficulty`, `user`.`username` `username` FROM `caches`, `cache_type`, `cache_size`, `user` WHERE `caches`.`type`=`cache_type`.`id` AND `caches`.`size`=`cache_size`.`id` AND `caches`.`user_id`=`user`.`user_id` AND `caches`.`status`=1 AND `caches`.`longitude`>='" . sql_escape($lon_from) . "' AND `caches`.`longitude`<='" . sql_escape($lon_to) . "' AND `caches`.`latitude`>='" . sql_escape($lat_from) . "' AND `caches`.`latitude`<='" . sql_escape($lat_to) . "'");

/*
  kml processing
 */

$kmlLine = '
<Placemark>
  <description><![CDATA[<a href="http://www.opencaching.pl/viewcache.php?cacheid={cacheid}">Zobacz szczegóły skrzynki</a><br />Założona przez {username}<br />&nbsp;<br /><table cellspacing="0" cellpadding="0" border="0"><tr><td>{typeimgurl} </td><td>Rodzaj: {type}<br />Wielkość: {{size}}</td></tr><tr><td colspan="2">Zadanie: {difficulty} z 5.0<br />Teren: {terrain} z 5.0</td></tr></table>]]></description>
  <name>{name}</name>
  <LookAt>
    <longitude>{lon}</longitude>
    <latitude>{lat}</latitude>
    <range>5000</range>
    <tilt>0</tilt>
    <heading>3</heading>
  </LookAt>
  <styleUrl>#{icon}</styleUrl>
  <Point>
    <coordinates>{lon},{lat},0</coordinates>
  </Point>
</Placemark>
';

$kmlHead = '<?xml version="1.0" encoding="UTF-8"?>
<kml xmlns="http://earth.google.com/kml/2.0">
<Document>
    <Style id="tradi">
        <IconStyle>
            <Icon>
                <href>http://www.opencaching.pl/images/ge/tradi.png</href>
            </Icon>
        </IconStyle>
    </Style>
    <Style id="multi">
        <IconStyle>
            <Icon>
                <href>http://www.opencaching.pl/images/ge/multi.png</href>
            </Icon>
        </IconStyle>
    </Style>
    <Style id="myst">
        <IconStyle>
            <Icon>
                <href>http://www.opencaching.pl/images/ge/myst.png</href>
            </Icon>
        </IconStyle>
    </Style>
    <Style id="virtual">
        <IconStyle>
            <Icon>
                <href>http://www.opencaching.pl/images/ge/virtual.png</href>
            </Icon>
        </IconStyle>
    </Style>
    <Style id="webcam">
        <IconStyle>
            <Icon>
                <href>http://www.opencaching.pl/images/ge/webcam.png</href>
            </Icon>
        </IconStyle>
    </Style>
    <Style id="event">
        <IconStyle>
            <Icon>
                <href>http://www.opencaching.pl/images/ge/event.png</href>
            </Icon>
        </IconStyle>
    </Style>
    <Style id="moving">
        <IconStyle>
            <Icon>
                <href>http://www.opencaching.pl/images/ge/moving.png</href>
            </Icon>
        </IconStyle>
    </Style>
    <Style id="unknown">
        <IconStyle>
            <Icon>
                <href>http://www.opencaching.pl/images/ge/unknown.png</href>
            </Icon>
        </IconStyle>
    </Style>
    <Folder>
        <Name>Geocaches (Opencaching) Polska</Name>
        <Open>0</Open>
';
$kmlFoot = '</Folder></Document></kml>';
$kmlTimeFormat = 'Y-m-d\TH:i:s\Z';

//  header("Content-type: application/vnd.google-earth.kml");
//  header("Content-Disposition: attachment; filename=ge.kml");

echo $kmlHead;

while ($r = sql_fetch_array($rs)) {
    $thisline = $kmlLine;

    // icon suchen
    switch ($r['type']) {
        case 2:
            $icon = 'traditional';
            $typeimgurl = '<img src="http://www.opencaching.pl/tpl/stdstyle/images/cache/traditional.png" alt="Tradycyjna" title="Tradycyjna" />';
            break;
        case 3:
            $icon = 'multi';
            $typeimgurl = '<img src="http://www.opencaching.pl/tpl/stdstyle/images/cache/multi.png" alt="Multicache" title="Multicache" />';
            break;
        case 4:
            $icon = 'virtual';
            $typeimgurl = '<img src="http://www.opencaching.pl/tpl/stdstyle/images/cache/virtual.png" alt="Wirtualna" title="Wirtualna" />';
            break;
        case 5:
            $icon = 'webcam';
            $typeimgurl = '<img src="http://www.opencaching.pl/tpl/stdstyle/images/cache/webcam.png" alt="Webcam" title="Webcam" />';
            break;
        case 6:
            $icon = 'event';
            $typeimgurl = '<img src="http://www.opencaching.pl/tpl/stdstyle/images/cache/event.png" alt="Wydarzenie" title="Wydarzenie" />';
            break;
        case 7:
            $icon = 'quiz';
            $typeimgurl = '<img src="http://www.opencaching.pl/tpl/stdstyle/images/cache/quiz.png" alt="Quiz" title="Quiz" />';
            break;
        case 9:
            $icon = 'moving';
            $typeimgurl = '<img src="http://www.opencaching.pl/tpl/stdstyle/images/cache/moving.png" alt="Mobilna" title="Mobilna" />';
            break;
        default:
            $icon = 'unknown';
            $typeimgurl = '<img src="http://www.opencaching.pl/tpl/stdstyle/images/cache/unknown.png" alt="Nietypowa" title="Nietypowa" />';
            break;
    }
    $thisline = mb_ereg_replace('{icon}', $icon, $thisline);
    $thisline = mb_ereg_replace('{typeimgurl}', $typeimgurl, $thisline);

    $lat = sprintf('%01.5f', $r['latitude']);
    $thisline = mb_ereg_replace('{lat}', $lat, $thisline);

    $lon = sprintf('%01.5f', $r['longitude']);
    $thisline = mb_ereg_replace('{lon}', $lon, $thisline);

    $time = date($kmlTimeFormat, strtotime($r['date_hidden']));
    $thisline = mb_ereg_replace('{{time}}', $time, $thisline);

    $thisline = mb_ereg_replace('{name}', xmlentities($r['name']), $thisline);

    if (($r['status'] == 2) || ($r['status'] == 3)) {
        if ($r['status'] == 2)
            $thisline = mb_ereg_replace('{archivedflag}', 'Tymczasowo niedostępna', $thisline);
        else
            $thisline = mb_ereg_replace('{archivedflag}', 'Zarchiwizowana!, ', $thisline);
    } else
        $thisline = mb_ereg_replace('{archivedflag}', '', $thisline);

    $thisline = mb_ereg_replace('{type}', xmlentities($r['typedesc']), $thisline);
    $thisline = mb_ereg_replace('{{size}}', xmlentities($r['sizedesc']), $thisline);

    $difficulty = sprintf('%01.1f', $r['difficulty'] / 2);
    $thisline = mb_ereg_replace('{difficulty}', $difficulty, $thisline);

    $terrain = sprintf('%01.1f', $r['terrain'] / 2);
    $thisline = mb_ereg_replace('{terrain}', $terrain, $thisline);

    $time = date($kmlTimeFormat, strtotime($r['date_hidden']));
    $thisline = mb_ereg_replace('{{time}}', $time, $thisline);

    $thisline = mb_ereg_replace('{username}', xmlentities($r['username']), $thisline);
    $thisline = mb_ereg_replace('{cacheid}', xmlentities($r['cacheid']), $thisline);

    echo $thisline;
}
mysql_free_result($rs);

echo $kmlFoot;
exit;

function xmlentities($str)
{
    $from[0] = '&';
    $to[0] = '&amp;';
    $from[1] = '<';
    $to[1] = '&lt;';
    $from[2] = '>';
    $to[2] = '&gt;';
    $from[3] = '"';
    $to[3] = '&quot;';
    $from[4] = '\'';
    $to[4] = '&apos;';

    for ($i = 0; $i <= 4; $i++)
        $str = mb_ereg_replace($from[$i], $to[$i], $str);

    return $str;
}

?>
