<?php

namespace App\Config;

class Quotes extends Service {

    // Random Quote API
    const RANDOM = 'https://api.quotable.io/random';

    // GOQUOTE API
    const GOQUOTES = 'https://goquotes-api.herokuapp.com/api/v1/random?count=1';

    /**
     * Get random quote.
     *
     * @return array
     */
    public function Random()
    {
        try {
            $response = $this->client->get(self::RANDOM)->getBody();
            return json_decode($response, true);
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }

    public function GoQuotes() {
        try {
            $response = $this->client->get(self::GOQUOTES)->getBody();
            return json_decode($response, true);
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }
}