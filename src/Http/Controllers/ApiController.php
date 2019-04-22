<?php

namespace Herode\Amana\Http\Controllers;

use Exception;
use Herode\Amana\AmanaService;
use Herode\Amana\Http\Requests\GetVersionRequest;
use Herode\Amana\Http\Requests\UploadAppRequest;
use Log;

class ApiController extends Controller
{
    /** @var $amanaService AmanaService */
    protected $amanaService;

    public function __construct()
    {
        parent::__construct();
        $this->amanaService = app(AmanaService::class);
    }

    public function getLatestVersion(GetVersionRequest $request)
    {
        try {
            $params = $request->only('env', 'device_type');

            list($version, $build) = $this->amanaService->getLatestVersion($params);

            $res = [
                'version' => $version,
                'build'   => $build
            ];

            return $this->success($res);
        } catch (Exception $e) {
            Log::error($e);

            return $this->error('HTTP_INTERNAL_ERROR', 500);
        }
    }

    public function postUploadApp(UploadAppRequest $request)
    {
        try {
            $appFile = $request->file('app_file');
            $params  = $request->only('env', 'device_type', 'version', 'build');
            $res     = $this->amanaService->uploadApp($appFile, $params);

            if (!$res) {
                return $this->error('ERROR_HAPPEN', 400);
            }

            return $this->success(true);
        } catch (Exception $e) {
            Log::error($e);

            return $this->error('HTTP_INTERNAL_ERROR', 500);
        }
    }

    public function getDownloads(GetVersionRequest $request)
    {
        $params = $request->only('device_type', 'env');
        $builds = $this->amanaService->getBuilds($params);

        return !empty($builds) ? $this->success($builds) : $this->error('ERROR', 400);
    }
}
