<?php

namespace App\Repositories\BadWord;

use App\Models\BadWord;
use App\Repositories\BaseRepository;

class BadWordRepository extends BaseRepository implements BadWordInterface
{
    /**
     * BadWordRepository constructor.
     *
     * @param BadWord $badWord
     */
    public function __construct(BadWord $badWord)
    {
        parent::__construct($badWord);
    }

}
