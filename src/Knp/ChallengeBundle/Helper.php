<?php

namespace Knp\ChallengeBundle;

use Guzzle\Http\Client;

class Helper
{
    public function getContent($page)
    {
        if ($page != 0) {
            $page = '-'.$page;
        }
        $client = $client = new Client('http://www.soccerway.com/a/block_competition_matches?block_id=page_competition_1_block_competition_matches_7&callback_params=%7B%22page%22%3A%22-1%22%2C%22round_id%22%3A%2214829%22%2C%22outgroup%22%3A%22%22%2C%22view%22%3A%222%22%7D&action=changePage&params=%7B%22page%22%3A'.$page.'%7D');
        $request = $client->get();
        $response = $request->send();

        $responseArray = $response->json();
        $matchesTable = $responseArray['commands']['0']['parameters']['content'];

        // If empty table
        if (strlen($matchesTable) <= 93) {
            return false;
        }

        return $matchesTable;
    }
}
