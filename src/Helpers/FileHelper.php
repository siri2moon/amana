<?php
/**
 * Created by PhpStorm.
 * User: binhnx
 * Date: 11/30/18
 * Time: 4:42 PM
 */

namespace Herode\Amana\Helpers;

use Exception;
use Illuminate\Http\UploadedFile;
use Storage;

class FileHelper
{
    /** @var $store Storage */
    protected $store;

    public $rootUploads = 'amanas';

    public $directories = [
        'ios'     => 'ios',
        'android' => 'android',
    ];

    public function __construct()
    {
        $this->initStorage();
        $this->store = Storage::disk('amana');
    }

    private function initStorage()
    {
        $rootDir = public_path($this->rootUploads);
        if (!is_dir($rootDir)) {
            mkdir($rootDir);
            chmod($rootDir, 0777);
        }
        foreach ($this->directories as $directory) {
            $path = public_path($this->rootUploads . "/" . $directory);
            if (!is_dir($path)) {
                mkdir($path);
                chmod($path, 0777);
            }
        }
    }

    /**
     * @param $file UploadedFile
     * @param $deviceType
     * @return null|string
     * @throws Exception
     */
    public function appUpload($file, $deviceType)
    {
        try {
            if ('android' == $deviceType) {
                $filename = $file->getClientOriginalName();
            } else {
                $filename = strtr(':type-:time.:ext', [
                    ':type' => $deviceType, ':time' => time(),
                    ':ext' => $file->getClientOriginalExtension()
                ]);
            }

            $result = $this->store->putFileAs($this->directories[$deviceType], $file, $filename);

            return !empty($result) ? $filename : null;
        } catch (Exception $e) {
            throw new Exception('UPLOAD_ERROR');
        }
    }
}
