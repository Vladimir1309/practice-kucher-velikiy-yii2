<?php

namespace app\commands;

use app\models\Movie;
use Yii;
use yii\console\Controller;

class PosterController extends Controller
{
    public function actionDownload()
    {
        $directory = Yii::getAlias('@webroot/uploads/posters/');
        if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory)) {
            $this->stderr("Unable to create poster directory: {$directory}\n");
            return self::EXIT_CODE_ERROR;
        }

        $movies = Movie::find()->all();
        $context = stream_context_create([
            'http' => [
                'timeout' => 20,
                'follow_location' => true,
            ],
            'https' => [
                'timeout' => 20,
                'follow_location' => true,
            ],
        ]);

        foreach ($movies as $movie) {
            if (!is_string($movie->poster_url) || !preg_match('/^https?:\/\//i', $movie->poster_url)) {
                $this->stdout("Skipped: {$movie->title}\n");
                continue;
            }

            $contents = @file_get_contents($movie->poster_url, false, $context);
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
