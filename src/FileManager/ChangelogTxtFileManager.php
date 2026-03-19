<?php

declare(strict_types=1);

namespace MHD\RmtVersioning\FileManager;

use DateTime;
use Liip\RMT\Context;

class ChangelogTxtFileManager
{
    /**
     * The name of the file where the changelog
     * @var string
     */
    public const CHANGELOG_FILE = 'CHANGELOG.txt';

    /**
     * Genereated / combined folder + filename for the changelog file
     * @var string
     */
    private string $changelogFile;

    /**
     * Custom changelog filename specified; in case project does not want to use CHANGELOG.txt
     * @var string
     */
    private string $customFileName = '';

    public function __construct(string $folder = '/', string $customChangelogFile = '')
    {
        $this->changelogFile = $folder . DIRECTORY_SEPARATOR;
        if (trim($customChangelogFile) !== '') {
            // there is a custom changelog filename
            $this->customFileName = trim($customChangelogFile);
        }
        $this->changelogFile .= ($this->customFileName !== '' ? $this->customFileName : self::CHANGELOG_FILE);

        // @todo Safety checks; make sure the file is not outside of the project
        $this->changelogFile = str_replace('/../', '/', $this->changelogFile);
    }

    /**
     * Write the given version (1.0.0) to the set changelog file (CHANGELOG.txt)
     * @param string $version
     * @return void
     */
    public function updateChangelog(string $version)
    {
        // first, read the contents of the changelog and prepend the version number, with the current date/time
        $changelog = file_get_contents($this->changelogFile);

        if (trim($changelog) !== '') {
            // there is content, prepend the version and current date/time
            $now = new DateTime();
            $versionDate = $version . ' - ' . $now->format('Y-m-d H:i');
            // generate a line as long as the version + date string
            $underline = str_pad('', strlen($versionDate), '-');

            // prepend to the changelog
            $changelog = $versionDate . PHP_EOL . $underline . PHP_EOL . $changelog;
            // save it
            file_put_contents($this->changelogFile, $changelog);
        }
    }

    /**
     * Returns the changelog filename, for use in vcs commit
     * @return string
     */
    public function getChangelogFileName(): string
    {
        if ($this->customFileName !== '') {
            return $this->customFileName;
        }
        return self::CHANGELOG_FILE;
    }
}
