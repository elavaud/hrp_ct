<?php


import('pages.manager.ManagerHandler');

class ApprovalNoticesHandler extends ManagerHandler {
    
        var $approvalNoticeDao;
    
	/**
	 * Constructor
	 **/
	function ApprovalNoticesHandler() {
		parent::ManagerHandler();
		$this->approvalNoticeDao =& DAORegistry::getDAO('ApprovalNoticeDAO');
	}

	/**
	 * Display the files associated with a journal.
	 */
	function approvalNotices() {
		$this->validate();
		$this->setupTemplate(true);
                
		$rangeInfo =& Handler::getRangeInfo('notices');
                
                $templateMgr =& TemplateManager::getManager();
		$templateMgr->assign('pageHierarchy', array(array(Request::url(null, 'manager'), 'manager.journalManagement')));
		$templateMgr->assign('notices', $this->approvalNoticeDao->getApprovalNotices($rangeInfo));
                
		$templateMgr->display('manager/approvalNotices/index.tpl');	
	}

        /**
	 * Create / Edit approval notice.
	 */
	function approvalNoticeEdit($args = array()) {
		$this->validate();
		$this->setupTemplate(true);

		import('classes.manager.form.ApprovalNoticeForm');
                
		$approvalNoticeForm = new ApprovalNoticeForm(!isset($args) || empty($args) ? null : ((int) $args[0]));
		if ($approvalNoticeForm->isLocaleResubmit()) {
			$approvalNoticeForm->readInputData();
		} else {
			$approvalNoticeForm->initData();
		}
		$approvalNoticeForm->display();
	}

        /**
	 * Save changes to an approval notice.
	 */
	function updateApprovalNotice($args, &$request) {
		$this->validate();
		$this->setupTemplate(true);

		import('classes.manager.form.ApprovalNoticeForm');
		$approvalNoticeForm = new ApprovalNoticeForm(!isset($args) || empty($args) ? null : ((int) $args[0]));

		$approvalNoticeForm->readInputData();
		if (!HookRegistry::call('ApprovalNoticesHandler::updateApprovalNotice', array(&$approvalNoticeForm))) {
                        if ($approvalNoticeForm->validate()) {
                                $approvalNoticeForm->execute();
                                Request::redirect(null, null, 'approvalNotices');
                        } else {
                                $approvalNoticeForm->display();
                        }
                    
                }
	}
        
	function approvalNoticeDelete($args) {
		$this->validate();

		if (isset($args) && !empty($args)) {
			$aNoticeId = (int) $args[0];
                        $this->approvalNoticeDao->deleteApprovalNoticeById($aNoticeId);
		}
		Request::redirect(null, null, 'approvalNotices');
	}
        
        
        /**
	 * preview an approval notice.
	 */
	function approvalNoticePreview($args = array()) {
		$this->validate();
		$this->setupTemplate(true);
		$aNoticeId = isset($args[0]) ? (int) $args[0] : 0;
                
		Request::redirect(null, null, 'approvalNotices');
	}

}
?>
