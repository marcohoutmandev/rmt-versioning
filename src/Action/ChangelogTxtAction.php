<?php

declare(strict_types=1);

namespace MHD\RmtVersioning\Action;

use Liip\RMT\Action\BaseAction;
use Liip\RMT\Context;
use MHD\RmtVersioning\FileManager\ChangelogTxtFileManager;

class ChangelogTxtAction extends BaseAction
{
    public function execute()
    {
        // get a file manager for the CHANGELOG.txt file
        $fileManager = new ChangelogTxtFileManager(Context::getParam('project-root'));
        // get the next version from the context
        $nextVersion = Context::getParam('new-version');
        // finally, update the file
        $fileManager->updateChangelog($nextVersion);
        // confirm success
        $this->confirmSuccess();
    }
}
