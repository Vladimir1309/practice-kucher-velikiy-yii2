<?php

namespace app\commands;

use app\models\Movie;
use Yii;
use yii\console\Controller;

class PosterController extends Controller
{
    public function actionDownload()
    {
        $directory = Yii::getAlias('@app/web/uploads/posters/');
        if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory)) {
            $this->stderr("Unable to create poster directory: {$directory}\n");
            return self::EXIT_CODE_ERROR;
        }

        $movies = Movie::find()->all();
        $context = stream_context_create([
            'http' => [
                'timeout' => 20,
                'follow_location' => true,
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            ],
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ]);

        foreach ($movies as $movie) {
            if (!is_string($movie->poster_url) || !preg_match('/^https?:\/\//i', $movie->poster_url)) {
                $this->stdout("Skipped: {$movie->title}\n");
                continue;
            }

            $contents = @file_get_contents($movie->poster_url, false, $context);
            if ($contents === false && function_exists('curl_init')) {
                $curl = curl_init($movie->poster_url);
                curl_setopt_array($curl, [
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_MAXREDIRS => 5,
                    CURLOPT_CONNECTTIMEOUT => 10,
                    CURLOPT_TIMEOUT => 20,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                ]);
                $curlContents = curl_exec($curl);
                $httpCode = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
                curl_close($curl);

                if ($curlContents !== false && $httpCode >= 200 && $httpCode < 300) {
                    $contents = $curlContents;
                }
            }
            if ($contents === false) {
                $this->stderr("Failed to download: {$movie->title}\n");
                continue;
            }

            $filename = 'poster_' . $movie->id . '.jpg';
            $path = $directory . $filename;
            if (file_put_contents($path, $contents) === false) {
                $this->stderr("Failed to save: {$movie->title}\n");
                continue;
            }

            $movie->poster_url = '/uploads/posters/' . $filename;
            if (!$movie->save(false, ['poster_url'])) {
                $this->stderr("Failed to update database: {$movie->title}\n");
                continue;
            }

            $this->stdout("Downloaded: {$movie->title}\n");
        }

        return self::EXIT_CODE_NORMAL;
    }
}
