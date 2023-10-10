<?php

namespace App;

use SimpleXMLElement;

class RssLink
{

    public static function saveLink(string $url): void
    {
        $link = self::getLinks($url);
        if (!is_null($link)) {
            $allLinks = self::getJSON();
            $allLinks[] = $link;
            self::saveFile($allLinks);
        }
    }


    private static function getLinks(string $url): ?string
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            $_SESSION['error'] = "URL non valide <br>";
            header("Location: index");
            return null;
        }

        $html = file_get_contents($url);
        preg_match_all('/<link\s+(.*?)\s*\/?>/si', $html, $matches);
        $links = $matches[1];
        $final_links = array();
        $link_count = count($links);
        for ($n = 0; $n < $link_count; $n++) {
            $attributes = preg_split('/\s+/s', $links[$n]);

            foreach ($attributes as $attribute) {
                $att = preg_split('/\s*=\s*/s', $attribute, 2);
                if (isset($att[1])) {
                    $att[1] = preg_replace('/([\'"]?)(.*)\1/', '$2', $att[1]);
                    $final_link[strtolower($att[0])] = $att[1];
                }
            }
            $final_links[$n] = $final_link;
        }
        for ($n = 0; $n < $link_count; $n++) {
            if (strtolower($final_links[$n]['rel']) == 'alternate') {
                if (strtolower($final_links[$n]['type']) == 'application/rss+xml') {

                    $href = $final_links[$n]['href'];
                }
                if (isset($href) and strtolower($final_links[$n]['type']) == 'text/xml') {
                    $href = $final_links[$n]['href'];
                }
                if (isset($href)) {
                    if (strstr($href, "http://") !== false) {
                        $full_url = $href;
                    } else {
                        $url_parts = parse_url($url);
                        $full_url = "http://$url_parts[host]";
                        if (isset($url_parts['port'])) {
                            $full_url .= ":$url_parts[port]";
                        }
                        if ($href[0] != '/') {
                            $full_url .= dirname($url_parts['path']);
                            if (substr($full_url, -1) != '/') {
                                $full_url .= '/';
                            }
                        }
                        $full_url .= $href;
                    }
                    return $href;
                }
            }
        }
        $_SESSION['error'] = 'URL sans flux RSS';
        header("Location: index");
        return null;
    }


    public static function getJSON(): array
    {
        $json = file_get_contents('data.json');
        $array = json_decode($json, true);
        if (is_null($array)) {
            $array = [];
        }
        return $array;
    }


    public static function getRSSlinks(): array
    {
        $dataJSON = file_get_contents('data.json');
        $data = json_decode($dataJSON);
        $websites = [];
        foreach ($data as $link) {
            $links = self::parseXML($link);
            if ($links) {
                $websites[] = $links;
            }
        }
        return $websites;
    }


    private static function parseXML(string $link)
    {
        if ($content = file_get_contents($link)) {
            $a = new SimpleXMLElement($content);
            return $a->channel;
        }
    }


    public static function deleteLink(int $id): void
    {
        $links = self::getJSON();
        unset($links[$id]);
        self::saveFile($links);
    }


    private static function saveFile(array $links): void
    {
        $jsonLinks = json_encode($links);
        file_put_contents("data.json", $jsonLinks);
    }
}
