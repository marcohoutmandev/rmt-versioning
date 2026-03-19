<?php

declare(strict_types=1);

namespace MHD\RmtVersioning\Persister;

use Liip\RMT\Context;
use Liip\RMT\Version\Persister\VcsTagPersister;
use MHD\RmtVersioning\FileManager\VersionTxtFileManager;

class VersionPersister extends VcsTagPersister
{
    /**
     * Read the version from the VERSION.txt file, or fallback to parent value (based on the tags in vcs)
     * @return string
     */
    public function getCurrentVersion(): string
    {
        $fileManager = new VersionTxtFileManager(Context::getParam('project-root'));
        // we are basing the current version on the contents of the 'VERSION.txt' file, if
        // this file exists

        $currentVersion = $fileManager->readVersion();
        if ($currentVersion === '') {
            // could not read the file, fallback to parent functionality
            $currentVersion = parent::getCurrentVersion();
        }

        return $currentVersion;
    }
}
