<?php 

declare(strict_types=1);

use Liip\RMT\Action\BaseAction;

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