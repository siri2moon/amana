<?php
/**
 * Created by PhpStorm.
 * User: binhnx
 * Date: 12/3/18
 * Time: 9:18 AM
 */

namespace Herode\Amana\Helpers;

use Exception;
use Illuminate\Filesystem\Filesystem;
use Log;

class PlistHelper
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Array params
     *
     * @var array
     */
    protected $params;

    /**
     * The Plist path
     *
     * @var string
     */
    protected $plistPath;

    public function __construct($params = [])
    {
        $this->files     = app(Filesystem::class);
        $this->params    = $params;
        $this->plistPath = public_path('amanas/ios');
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../Stubs/plist-v1.stub';
    }

    /**
     * Get the destination class path.
     *
     * @param  string $filename
     * @return string
     */
    protected function getPath($filename)
    {
        return strtr(':basePath/:filename', [':basePath' => $this->plistPath, ':filename' => $filename]);
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }

        return $path;
    }

    public function create($params, $env = 'dev')
    {
        try {
            $stub          = $this->files->get($this->getStub());
            $stub          = strtr($stub, [
                ':pathToIpa' => str_replace('http://', 'https://', $params['ipaPath']),
                ':bundleId'  => $this->getBundleId($env)
            ]);
            $plistFilename = strtr('IG-:time.plist', [':time' => time()]);
            $plistPath     = $this->getPath($plistFilename);
            $this->makeDirectory($plistPath);
            $this->files->put($plistPath, $stub);

            return $plistFilename;
        } catch (Exception $e) {
            Log::error($e);

            return null;
        }
    }

    public function getBundleId($env)
    {
        return config("amana.bundle_id.{$env}");
    }
}
