<?php

namespace App\Services;

use App\Http\Controllers\API\Exceptions\ApiBadRequestException;
use App\Http\Requests\RequestPaginate;
use App\Http\Requests\Translate\ExportTranslate;
use App\Http\Requests\Translate\ImportTranslate;
use App\Models\Translate;
use App\Repositories\Translate\TranslateInterface;
use SimpleXMLElement;

class TranslateService
{
    protected TranslateInterface $translateInterface;

    /**
     * @param TranslateInterface $translateInterface
     */
    public function __construct(TranslateInterface $translateInterface)
    {
        $this->translateInterface = $translateInterface;
    }

    /**
     * @param RequestPaginate $request
     * @return mixed
     */
    public function getPagination(RequestPaginate $request): array
    {
        try {
            return $this->translateInterface->getPagination($request);
        } catch (\Exception) {
            throw new ApiBadRequestException();
        }
    }

    public function import(ImportTranslate $request): array
    {
        if ($request->file->getClientOriginalName() != "uistring_server.xml" && $request->file->getClientOriginalName() != "uistring.xml") {
            return ['status' => 403, 'message' => 'cannot import this files, support only : uistring_server.xml and uistring.xml!'];
        }

        if ($request->file->getClientOriginalName() == "uistring_server.xml") {
            $fileType = "UIStringServer";
        } else {
            $fileType = "UIString";
        }

        ini_set('memory_limit', '-1');
        ini_set('maximum_execution_time', '-1');
        $file = $request->file;
        if (!file_exists($file)) {
            echo "File not found.";
        }
        // load files
        $xml = simplexml_load_file($file);
        if (!$xml) {
            echo "Failed to load XML.";
        }

        if ($request->language == "IDN") {

            // extract xml
            foreach ($xml->message as $message) {
                $mid = $message['mid'];
                $text = (string)$message;

                $checkCurrentData = Translate::with([])
                    ->where('code', '=', $mid)->first();
                if (!$checkCurrentData) {
                    $translate = new Translate();
                    $translate['code'] = $mid;
                    $translate['type'] = $fileType;
                    $translate['IDN'] = $text;;
                    $translate->save();
                } else {
                    Translate::where('code', $checkCurrentData->code)
                        ->update([
                            'IDN' => $text
                        ]);
                }
            }
        } else if ($request->language == "ENG") {
            // extract xml
            foreach ($xml->message as $message) {
                $mid = $message['mid'];
                $text = (string)$message;

                $checkCurrentData = Translate::with([])
                    ->where('code', '=', $mid)->first();
                if (!$checkCurrentData) {
                    $translate = new Translate();
                    $translate['code'] = $mid;
                    $translate['type'] = $fileType;
                    $translate['ENG'] = $text;;
                    $translate->save();
                } else {
                    Translate::where('code', $checkCurrentData->code)
                        ->update([
                            'ENG' => $text
                        ]);

                }
            }
        } else {
            return ['status' => 403, 'message' => 'only support IDN and ENG for languages'];
        }

        return ['status' => 200, 'message' => 'success import XML files !'];
    }

    public function export(ExportTranslate $request): bool|string
    {
        $data = array(
            array(
                'mid' => 2,
                'text' => 'Invalid request.'
            ),
            array(
                'mid' => 3,
                'text' => 'Unknown error.'
            ),
            array(
                'mid' => 4,
                'text' => 'Double Login. Silahkan coba beberapa saat lagi.'
            ),
            array(
                'mid' => 5,
                'text' => 'Duplicate session ID.'
            )
        );

        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><messages name="ServerMsg" lang="ID1"/>');

        foreach ($data as $message) {
            $node = $xml->addChild('message');
            $node->addAttribute('mid', $message['mid']);
            $node->addChild('![CDATA[' . $message['text'] . ']]>');
        }

        return $xml->asXML();;
    }
}
