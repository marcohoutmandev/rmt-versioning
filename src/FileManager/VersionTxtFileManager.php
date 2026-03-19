<?php

declare(strict_types=1);

namespace MHD\RmtVersioning\FileManager;

class VersionTxtFileManager
{
    /**
     * The name of the file where the (current) version gets stored
     * @var string
     */
    public const VERSION_FILE = 'VERSION.txt';

    /**
     * Genereated / combined folder + filename for the version file
     * @var string
     */
    private string $versionFile;

    /**
     * Custom version filename specified; in case project does not want to use VERSION.txt
     * @var string
     */
    private string $customFileName = '';

    public function __construct(string $folder = '/', string $customVersionFile = '')
    {
        $this->versionFile = $folder . DIRECTORY_SEPARATOR;
        if (trim($customVersionFile) !== '') {
            // there is a custom version filename
            $this->customFileName = trim($customVersionFile);
        }
        $this->versionFile .= ($this->customFileName !== '' ? $this->customFileName : self::VERSION_FILE);

        // @todo Safety checks; make sure the file is not outside of the project
        $this->versionFile = str_replace('/../', '/', $this->versionFile);
    }

    /**
     * Write the given version (1.0.0) to the set version file (VERSION.txt)
     * @param string $version
     * @return void
     */
    public function writeVersion(string $version)
    {
        file_put_contents($this->versionFile, $version);
    }

    /**
     * Read the version (1.0.0) from the version file (VERSION.txt)
     * @return bool|string
     */
    public function readVersion()
    {
        $version = file_get_contents($this->versionFile);

        return is_bool($version) ? '' : $version;
    }

    /**
     * Returns the version filename, for use in vcs commit
     * @return string
     */
    public function getVersionFileName(): string
    {
        if ($this->customFileName !== '') {
            return $this->customFileName;
        }
        return self::VERSION_FILE;
    }
}
