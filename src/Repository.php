<?php namespace VirtualComplete\Config;

use Illuminate\Config\Repository as RepositoryBase;

class Repository extends RepositoryBase
{
    /**
     * The config rewrite object.
     *
     * @var string
     */
    protected $rewrite;
    /**
     * @var string
     */
    private $config_path;

    /**
     * Create a new configuration repository.
     *
     * @param  array  $items
     * @param  Rewrite $rewrite
     */
    public function __construct($items = array(), Rewrite $rewrite, $config_path)
    {
        $this->rewrite = $rewrite;
        $this->config_path = $config_path;
        parent::__construct($items);
    }

    /**
     * Write a given configuration value to file.
     *
     * @param array $values Array of key => value pairs
     * @throws \Exception
     * @return void
     */
    public function write(array $values)
    {
        foreach($values as $key => $value) {
            $this->set($key, $value);
            list($filename, $item) = $this->parseKey($key);
            $config[$filename][$item] = $value;
        }

        foreach($config as $filename => $items) {
            $path = $this->config_path . DIRECTORY_SEPARATOR . $filename;
            if (!is_writeable($path)) throw new \Exception('Configuration file ' . $filename . ' is not writeable.');
            if (!$this->rewrite->toFile($path, $items)) throw new \Exception('Unable to update configuration file ' . $filename);
        }
    }

    /**
     * Split key into 2 parts. The first part will be the filename
     * @param $key
     * @return array
     */
    private function parseKey($key)
    {
        return preg_split('/\./', $key, 2);
    }
}