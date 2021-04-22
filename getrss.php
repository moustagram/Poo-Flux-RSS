<?php
class Article{
    private $link;
    private $tilte;
    private $description;
    private $pubDate;
    private $media;

    public function __construct($l,$t,$d,$p,$m){
         $this->link=$l;
         $this->tilte=$t;
         $this->description=$d;
         $this->pubDate=$p;
         $this->media=$m;
         $this->affichage();
    }
    
     function affichage(){
        echo '<div style="background-color: #EDC7B7; padding-top: 3%" > <div  class="d-flex justify-content-center"> <h3 style="color: black;"><a  href='.$this->link.'>'.$this->tilte.'</a></h3></div><div class="d-flex justify-content-center"  class="mr-auto;" > <img  style="max-width: 200px; max-height: 200px; " class="img-responsive img-thumbnail" src="'.$this->media.'">  <div class="col-sm-4" class="article">'.$this->description.'</div></div><div class="d-flex justify-content-end">'.$this->pubDate.'</div></div>';
    }
    
}

function loadrss($url)
{

    $xmlDoc = new DOMDocument(); // ça vous rappelle quelque chose ? un flux RSS, c'est du XML et il se trouve que tous les document XML (dont le HTML est une forme particulière) sont navigable via un DOM
    $xmlDoc->load($url); // on initialise ce DOM avec l'url de notre flux

    // Récupération des infos du flux dans la balise "<channel>"
    $channel = $xmlDoc->getElementsByTagName('channel')->item(0);
    // notez la notation fléchée (php objet).

    // récupération du titre du flux
    $channel_title = $channel->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;

    // récupération du lien du flux
   // $channel_link = $channel->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;

    // récupération de la description du flux
    $channel_desc = $channel->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;

    // génération du contenu à partir des infos du flux dans "<channel>"
    // echo("<p><a href='" . $channel_link . "'>Bienvenue sur le flux RSS de " . $channel_title . "</a>");
    // echo("<br>");
    // echo("Description : " . $channel_desc . "</p>");

    // on va ensuite afficher les 3 premiers éléments du flux et les récupérant manuellement
    $x = $xmlDoc->getElementsByTagName('item');

    $itemMax = 0;
    $numberItems = $xmlDoc->getElementsByTagName('item');
    foreach ($numberItems as $item) {
        $itemMax += 1;
    }

    for ($i = 0; $i < $itemMax; $i++) {
        $l = $x->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
        $t = $x->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
        $d = $x->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;
        $p = $x->item($i)->getElementsByTagName('pubDate')->item(0)->childNodes->item(0)->nodeValue;
        $m = $x->item($i)->getElementsByTagName('enclosure')->item(0)->getAttribute('url');
        $node[$i] = new Article($l, $t, $d, $p, $m);
    }
}
    loadrss("https://www.moneycrashers.com/feed/");

?>