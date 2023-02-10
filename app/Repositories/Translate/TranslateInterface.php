<?php

namespace App\Repositories\Translate;

use App\Repositories\BaseRepositoryInterface;

/**
 * Interface BadWordInterface
 */
interface TranslateInterface extends BaseRepositoryInterface
{
    public function saveTranslate(array $array): array;
}
