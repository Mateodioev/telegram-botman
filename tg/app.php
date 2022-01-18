<?php require '../vendor/autoload.php';

use App\Config\{Dogs, Quotes};

use BotMan\BotMan\{BotMan, BotManFactory};
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Telegram\TelegramDriver;

$config = [
    // Your driver-specific configuration
    'telegram' => [
        'token' => 'YOUR_TOKEN_HERE',
    ],
];

// Load the driver(s) you want to use
DriverManager::loadDriver(TelegramDriver::class);

// Create an instance
$botman = BotManFactory::create($config);


// Return a random quote text
$botman->hears('/quotes', function (BotMan $bot) {

    try {
        $res = (new Quotes())->Random();
        $bot->reply('<u>' . $res['author'] . ':</u>' . PHP_EOL . '<i>' . $res['content'] . '</i>', ['parse_mode' => 'HTML']);
    } catch (\Exception$e) {
        $bot->randomReply(['Fail to get quote', 'Try again later', 'Please try again later']);
    }
    exit;
});


// Return a random dog image
$botman->hears('/dog', function (Botman $bot) {

    try {
        $res = (new Dogs())->Random();
        if ($res['status'] == 'success') {
            (new Dogs())->Send($bot, $res['message']);
        } else {
            throw new Exception('Fail to get dog image');
        }
    } catch (\Exception$e) {
        $bot->randomReply(['Fail to get dog', 'Try again later', 'Please try again later']);
    }
    exit;
});

// Return a dog image by breed
$botman->hears('/dog {breed}:{subreed}', function ($bot, $breed, $subbreed) {
    try {
        $res = (new Dogs())->bySubBreeds($breed, $subbreed);
        if ($res['status'] == 'success') {
            (new Dogs())->Send($bot, $res['message']);
        } else {
            $bot->reply($res['message']);
        }
    } catch (Exception $e) {
        $bot->randomReply(['Fail to get dog sub-breed', 'Try again later', 'Please try again later']);
    }
    exit;
});

// Return a dog image by sub-breed
$botman->hears('/dog {breed}', function ($bot, $breed) {
    try {
        $res = (new Dogs())->byBreed($breed);
        if ($res['status'] == 'success') {
            (new Dogs())->Send($bot, $res['message']);
        } else {
            $bot->reply($res['message']);
        }
    } catch (Exception $e) {
        $bot->randomReply(['Fail to get dog breed', 'Try again later', 'Please try again later']);
    }
    exit;
});


// Start listening
$botman->listen();
