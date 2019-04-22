<?php
/**
 * Created by PhpStorm.
 * User: binhnx
 * Date: 01/04/2019
 * Time: 14:52
 */

namespace Herode\Amana;

use DB;
use Exception;
use Herode\Amana\Helpers\FileHelper;
use Herode\Amana\Helpers\PlistHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;
use Log;

class AmanaService
{
    /**
     * AmanaService constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return Builder
     */
    public function makeQuery()
    {
        /** @noinspection PhpUndefinedClassInspection */
        return Amana::query();
    }

    public function getLatestVersion($params)
    {
        try {
            $version        = '1.0.1';
            $build          = '1';
            $versionBuilder = $this->makeQuery()
                ->where(['device_type' => $params['device_type'], 'env' => $params['env'], 'is_latest_version' => true])
                ->first();

            if (!empty($versionBuilder)) {
                $version = $versionBuilder->version;
                $build   = intval($versionBuilder->build) + 1;
            }

            return [$version, $build];
        } catch (Exception $e) {
            Log::error('[AMANA]');
            Log::error($e);

            return [null, null];
        }
    }

    /**
     * @param $file UploadedFile
     * @param $params array
     * @return bool|Builder|\Illuminate\Database\Eloquent\Model
     * @throws Exception
     */
    public function uploadApp($file, $params)
    {
        try {
            DB::beginTransaction();
            $fileHelper              = new FileHelper();
            $params['app_file_name'] = $fileHelper->appUpload($file, $params['device_type']);
            if ('ios' === $params['device_type']) {
                $ipaPath                   = asset(strtr('amanas/:deviceType/:fileName', [
                    ':deviceType' => $params['device_type'],
                    ':fileName'   => $params['app_file_name']
                ]));
                $plistHelper               = new PlistHelper();
                $params['plist_file_name'] = $plistHelper->create(['ipaPath' => $ipaPath], $params['env']);
            }
            $params['is_latest_version'] = true;
            $this->removeIsLatestVersions($params['device_type'], $params['env']);

            $result = $this->makeQuery()->create($params);
            DB::commit();

            return $result;
        } catch (Exception $e) {
            Log::error($e);
            DB::rollBack();

            return false;
        }
    }

    public function removeIsLatestVersions($deviceType, $env = 'dev')
    {
        return $this->makeQuery()
            ->where(['device_type' => $deviceType, 'env' => $env])
            ->update(['is_latest_version' => false]);
    }

    public function getBuilds($params)
    {
        $builds = $this->makeQuery()
            ->where('env', '=', $params['env'])
            ->where('device_type', '=', $params['device_type'])
            ->orderBy('id', 'DESC')
            ->limit(4)
            ->get();

        $builds = $builds->map(function ($item) {
            if ('ios' === $item->device_type) {
                $plistLink = asset(strtr('amanas/ios/:filename', [
                    ':filename' => $item->plist_file_name
                ]));

                $item->app_download_url = strtr("itms-services://?action=download-manifest&url=:url", [
                    ':url' => $plistLink
                ]);
            } else {
                $item->app_download_url = asset(strtr('amanas/android/:filename', [
                    ':filename' => $item->app_file_name
                ]));
            }
            return $item;
        });

        return $builds;
    }
}
