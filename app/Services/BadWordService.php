<?php

namespace App\Services;

use App\Http\Controllers\API\Exceptions\ApiBadRequestException;
use App\Http\Requests\BadWord\ImportRequest;
use App\Http\Requests\RequestPaginate;
use App\Models\BadWord;
use App\Repositories\BadWord\BadWordInterface;


class BadWordService
{
    protected BadWordInterface $badWordInterface;

    /**
     * @param BadWordInterface $badWordInterface
     */
    public function __construct(BadWordInterface $badWordInterface)
    {
        $this->badWordInterface = $badWordInterface;
    }

    /**
     * @param RequestPaginate $request
     * @return mixed
     */
    public function getPagination(RequestPaginate $request): array
    {
        try {
            return $this->badWordInterface->getPagination($request);
        } catch (\Exception) {
            throw new ApiBadRequestException();
        }
    }

    public function import(ImportRequest $request): array
    {
        $file = $request->file;
        if (!file_exists($file)) {
            echo "File not found.";
        }
        // load files
        $xml = simplexml_load_file($file, "SimpleXMLElement", LIBXML_NOCDATA);
        if (!$xml) {
            echo "Failed to load XML.";
        }
        // encode to json
        $jsonAccount = json_encode($xml->Account->AccountWord);
        $arrayAccount = json_decode($jsonAccount, TRUE);

        $jsonWorldChat = json_encode($xml->Chat->ChatWord);
        $arrayWorldChat = json_decode($jsonWorldChat, TRUE);

        for ($i = 0; $i < count($arrayAccount); $i++) {
            $checkCurrentData = BadWord::with([])
                ->where('type', '=', 'Account')
                ->where('word', '=', $arrayAccount[$i]);
            if (!$checkCurrentData->exists()) {
                $badWord = new BadWord();
                $badWord['type'] = 'Account';
                $badWord['word'] = $arrayAccount[$i];
                $badWord['language'] = $request->language;;
                $badWord->save();
            }
        }

        for ($i = 0; $i < count($arrayWorldChat); $i++) {
            $checkCurrentData = BadWord::with([])
                ->where('type', '=', 'WorldChat')
                ->where('word', '=', $arrayWorldChat[$i]);
            if (!$checkCurrentData->exists()) {
                $badWord = new BadWord();
                $badWord['type'] = 'WorldChat';
                $badWord['word'] = $arrayWorldChat[$i];
                $badWord['language'] = $request->language;
                $badWord['replacement'] = 'konoha';
                $badWord->save();
            }
        }

        return ['status' => 200, 'message' => 'success import XML files !'];
    }
}
