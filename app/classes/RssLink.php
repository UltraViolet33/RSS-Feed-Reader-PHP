<?php

namespace App;

use SimpleXMLElement;

class RssLink
{
    /**
     * saveJSON
     * save the RSS link in the JSON file
     * @return void
     */
    public function saveJSON(string $url): void
    {
        $link = $this->getLinks($url);
        if (!is_null($link)) {
            $allLinks = $this->getJSON();
            $allLinks[] = $link;
            $json = json_encode($allLinks);
            file_put_contents("data.json", $json);
        }
    }

    /**
     * getLinks
     * get the link for the RSS flux
     * @return 
     */
    private function getLinks(string $url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            $_SESSION['error'] = "URL non valide <br>";
            header("Location: index");
            return null;
            unset($_SESSION['error']);
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
                    #kludge to make the first version of this still work
                    $href = $final_links[$n]['href'];
                }
                if (isset($href)) {
                    if (strstr($href, "http://") !== false) { #if it's absolute
                        $full_url = $href;
                    } else { #otherwise, 'absolutize' it
                        $url_parts = parse_url($url);
                        #only made it work for http:// links. Any problem with this?
                        $full_url = "http://$url_parts[host]";
                        if (isset($url_parts['port'])) {
                            $full_url .= ":$url_parts[port]";
                        }
                        if ($href[0] != '/') { #it's a relative link on the domain
                            $full_url .= dirname($url_parts['path']);
                            if (substr($full_url, -1) != '/') {
                                #if the last character isn't a '/', add it
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
        unset($_SESSION['error']);
    }

    /**
     * getJSON
     * get the json data in the json file and parse it
     * @return array
     */
    private function getJSON(): array
    {
      
        $json = file_get_contents('data.json');
        $array = json_decode($json, true);
       if(is_null($array))
       {
       
      $array = [];
       }
        return $array;
    }

    public function displayXML($content)
    {
        $xml = new SimpleXMLElement($content);

        foreach ($xml->channel->item as $entry) {
            var_dump($entry);
        }
    }


    public function getRSSlinks()
    {
        $dataJSON = file_get_contents('data.json');
        $data = json_decode($dataJSON);
        $websites = [];
        foreach ($data as $link) {
           
            $websites[] = $this->parseXML($link);
        }

      
        return $websites;
    }


    public function parseXML($link)
    {
        $content = file_get_contents($link);

        $data = [];

        $a = new SimpleXMLElement($content);
        // foreach($a->channel as $entry)
        // {
        //    var_dump($entry);
        //     $data['title'] = $entry->title;
        //     $data['link'] = $entry->link;

        // }

        return $a->channel;
    }
}
