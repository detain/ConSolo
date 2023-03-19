<?php

namespace Detain\ConSolo\Models;

class Media extends Base {

    public function index() {
        echo $this->twig->render('index.twig', [
            'queryString' => $_SERVER['QUERY_STRING']
        ]);
    }

    public function eztv() {
        $limits = json_decode(file_get_contents(__DIR__.'/../../../Watchable/src/Importing/Web/eztv_show_limits.json'), true);
        $thumbs = json_decode(file_get_contents(__DIR__.'/../../../Watchable/src/Importing/Web/eztv_show_thumbs.json'), true);
        $shows = json_decode(file_get_contents(__DIR__.'/../../../Watchable/src/Importing/Web/eztv_shows_small.json'), true);

        //print_r($thumbs);exit;
        foreach ($shows['shows'] as $id => $show) {
            if (isset($show['image'])) {
                $thumb = basename($show['image']);
                if (array_key_exists($thumb, $thumbs)) {
                    $shows['shows'][$id]['image_thumb'] = $thumb;
                    $shows['shows'][$id]['image_thumb_width'] = $thumbs[$thumb][0];
                    $shows['shows'][$id]['image_thumb_height'] = $thumbs[$thumb][0];
                }
            }
        }
        echo $this->twig->render('eztv.twig', [
            'limits' => $limits,
            'shows' => $shows,
        ]);
    }

    public function emulators() {
        $jsonPlats = json_decode(file_get_contents(__DIR__.'/../../../emurelation/platforms/local.json'), true);
        $jsonEmus = json_decode(file_get_contents(__DIR__.'/../../../emurelation/emulators/local.json'), true);
        $companies = ['Unknown' => []];
        $platforms = ['Unknown'];
        $types = ['Unknown'];
        foreach ($jsonEmus as $emuId => $emuData) {
            if (!isset($emuData['platforms']) || count($emuData['platforms']) == 0) {
                $emuData['platforms'] = ['Unknown'];
                $jsonEmus[$emuId]['platforms'] = ['Unknown'];
            }
            if (!in_array($emuData['type'], $types))
                $types[] = $emuData['type'];
            foreach ($emuData['platforms'] as $platId) {
                if (!in_array($platId, $platforms)) {
                    $platforms[] = $platId;
                    $platData = $jsonPlats[$platId];
                    if (!isset($platData['company'])) {
                        $platData['company'] = 'Unknown';
                    }
                    if (!array_key_exists($platData['company'], $companies)) {
                        $companies[$platData['company']] = [];
                    }
                    $companies[$platData['company']][] = $platId;
                }
            }
        }
        if (count($companies['Unknown']) == 0) {
            unset($platforms['Unknown']);
            unset($companies['Unknown']);
        }
        sort($platforms);
        ksort($companies);
        ksort($jsonEmus);
        echo $this->twig->render('emulators.twig', [
            'companies' => $companies,
            'platResults' => $jsonPlats,
            'platforms' => $platforms,
            'types' => $types,
            'results' => $jsonEmus,
            'queryString' => $_SERVER['QUERY_STRING']
        ]);
    }

}
