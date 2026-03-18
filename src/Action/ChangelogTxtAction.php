<?php 

declare(strict_types=1);

use Liip\RMT\Action\BaseAction;
use Liip\RMT\Context;
use MHD\RmtVersioning\FileManager\ChangelogTxtFileManager;

class ChangelogTxtAction extends BaseAction
{
    public function execute()
    {
        $changelogTxtFileManager = new ChangelogTxtFileManager(Context::getParam('project-root'));

        $nextVersion = Context::getParam('new-version');

        $changelogTxtFileManager->updateChangelog($nextVersion);
        
        $this->confirmSuccess();
    }
}