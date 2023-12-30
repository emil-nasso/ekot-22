<?php
$dom = new DOMDocument();
$dom->loadXML(file_get_contents("https://api.sr.se/api/rss/pod/3795/"));

$title = $dom->getElementsByTagName('title')->item(1);
$title->textContent = '[22:00 only] ' . $title->textContent;

$nodesToDelete = [];
foreach($dom->getElementsByTagName('item') as $seg)
{
    if (stripos($seg->getElementsByTagName('title')->item(0)->textContent, '22:00') === false) {
        $nodesToDelete[] = $seg;
    }
}

foreach ($nodesToDelete as $item) $item->parentNode->removeChild($item);

header('Content-Type: text/xml; charset=utf-8');
echo $dom->saveXML();
