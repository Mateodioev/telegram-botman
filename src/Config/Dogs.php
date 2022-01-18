<?php

namespace App\Config;

use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class Dogs extends Service
{

    // The endpoint we will be getting a random image from.
    const RANDOM_ENDPOINT = 'https://dog.ceo/api/breeds/image/random';

    // The endpoint we will hit to get a random image by a given breed name.
    const BREED_ENDPOINT = 'https://dog.ceo/api/breed/%s/images/random';

    // The endpoint we will hit to get a random image by a given breed name and its sub-breed.
    const SUB_BREED_ENDPOINT = 'https://dog.ceo/api/breed/%s/%s/images/random';

    /**
     * Get a random dog image.
     */
    public function Random(): array
    {
        try {
            $response = $this->client->get(self::RANDOM_ENDPOINT)->getBody();
            return json_decode($response, true);
        } catch (\Exception$e) {
            return throw new \Exception($e);
        }
    }

    public function byBreed(string $breed): array
    {
        // We replace %s    in our endpoint with the given breed name.
        $endpoint = sprintf(self::BREED_ENDPOINT, $breed);

        try {
            $response = $this->client->get($endpoint)->getBody();
            return json_decode($response, true);
        } catch (\Exception$e) {
            return throw new \Exception($e);
        }
    }

    public function bySubBreeds(string $breed, string $subBreed): array
    {
        $endpoint = sprintf(self::SUB_BREED_ENDPOINT, $breed, $subBreed);

        try {
            $response = $this->client->get($endpoint)->getBody();
            return json_decode($response, true);
        } catch (\Exception$e) {
            return throw new \Exception($e);
        }
    }

    /**
     * Send img to any chat
     */
    public function Send($bot, string $img, ?string $text=null): void
    {
        $attachment = new Image($img);

        $message = OutgoingMessage::create($text)
            ->withAttachment($attachment);

        // Reply message object
        $bot->reply($message);
    }
}
