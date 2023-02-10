<?php

namespace App\Repositories\Translate;

use App\Models\BadWord;
use App\Models\Translate;
use App\Repositories\BaseRepository;

class TranslateRepository extends BaseRepository implements TranslateInterface
{
    /**
     * BadWordRepository constructor.
     *
     * @param Translate $translate
     */
    public function __construct(Translate $translate)
    {
        parent::__construct($translate);
    }

    public function saveTranslate(array $array): array
    {
        $model = new $this->model;
        $model->type = $array['type'];
        $model->language = $array['language'];
        $model->word = $array['word'];
        $model->replacement = $array['replacement'] ?? null;
        $model->save();

        return $model;
    }
}
