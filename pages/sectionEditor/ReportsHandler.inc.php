<?php

/**
* class MeetingsHandler for SectionEditor and Editor Roles (Secretary)
* page handler class for minutes-related operations
* @var unknown_type
*/
define('SECTION_EDITOR_ACCESS_EDIT', 0x00001);
define('SECTION_EDITOR_ACCESS_REVIEW', 0x00002);
// Filter section
define('FILTER_SECTION_ALL', 0);

import('classes.handler.Handler');

class ReportsHandler extends Handler {
	/**
	* Constructor
	**/
	function ReportsHandler() {
		parent::Handler();
		
		$this->addCheck(new HandlerValidatorJournal($this));
		// FIXME This is kind of evil
		$page = Request::getRequestedPage();
		if ( $page == 'sectionEditor' )
		$this->addCheck(new HandlerValidatorRoles($this, true, null, null, array(ROLE_ID_SECTION_EDITOR)));
		elseif ( $page == 'editor' )
		$this->addCheck(new HandlerValidatorRoles($this, true, null, null, array(ROLE_ID_EDITOR)));
	
	}

	/**
	* Setup common template variables.
	* @param $subclass boolean set to true if caller is below this handler in the hierarchy
	*/
	function setupTemplate() {
		parent::setupTemplate();
		Locale::requireComponents(array(LOCALE_COMPONENT_PKP_SUBMISSION, LOCALE_COMPONENT_OJS_EDITOR, LOCALE_COMPONENT_PKP_MANAGER, LOCALE_COMPONENT_OJS_AUTHOR, LOCALE_COMPONENT_OJS_MANAGER));
		$templateMgr =& TemplateManager::getManager();
		$isEditor = Validation::isEditor();
		
		if (Request::getRequestedPage() == 'editor') {
			$templateMgr->assign('helpTopicId', 'editorial.editorsRole');
		
		} else {
			$templateMgr->assign('helpTopicId', 'editorial.sectionEditorsRole');
		}
		
		$roleSymbolic = $isEditor ? 'editor' : 'sectionEditor';
		$roleKey = $isEditor ? 'user.role.coordinator' : 'user.role.sectionEditor';
		$pageHierarchy = array(array(Request::url(null, 'user'), 'navigation.user'), array(Request::url(null, 'user'), $roleKey), array(Request::url(null, $roleSymbolic, 'submissionsReport'), 'editor.reports.reportGenerator'));
		
		$templateMgr->assign('pageHierarchy', $pageHierarchy);
	}

	
	/**
	* Added by igmallare 10/10/2011
	* Display the meeting attendance report form
	* @param $args (type)
	*/
	function meetingAttendanceReport($args, &$request){
		import ('classes.meeting.form.MeetingAttendanceReportForm');
		parent::validate();
		$this->setupTemplate();
		$meetingAttendanceReportForm= new MeetingAttendanceReportForm($args, $request);
		$isSubmit = Request::getUserVar('generateMeetingAttendance') != null ? true : false;
		
		if ($isSubmit) {
			$meetingAttendanceReportForm->readInputData();
			if($meetingAttendanceReportForm->validate()){	
					$this->generateMeetingAttendanceReport($args);
			}else{
				if ($meetingAttendanceReportForm->isLocaleResubmit()) {
					$meetingAttendanceReportForm->readInputData();
				}
				$meetingAttendanceReportForm->display($args);
			}
		}else {
			$meetingAttendanceReportForm->display($args);
		}
	}
	
	/**
	* Added by igmallare 10/11/2011
	* Generate csv file for the meeting attendance report
	* @param $args (type)
	*/
	function generateMeetingAttendanceReport($args) {
		parent::validate();
		$this->setupTemplate();
		$ercMembers = Request::getUserVar('ercMembers');
		
		$fromDate = Request::getUserDateVar('dateFrom', 1, 1);
		if ($fromDate != null) $fromDate = date('Y-m-d H:i:s', $fromDate);
		$toDate = Request::getUserDateVar('dateTo', 32, 12, null, 23, 59, 59);
		if ($toDate != null) $toDate = date('Y-m-d H:i:s', $toDate);
		$meetingDao = DAORegistry::getDAO('MeetingDAO');
		$userDao = DAORegistry::getDAO('UserDAO');
		
		header('content-type: text/comma-separated-values');
		header('content-disposition: attachment; filename=meetingAttendanceReport-' . date('Ymd') . '.csv');
		
		$columns = array(
		'lastname' => Locale::translate('user.lastName'),
		'firstname' => Locale::translate('user.firstName'),
		'middlename' => Locale::translate('user.middleName'),
		'meeting_date' => Locale::translate('editor.reports.meetingDate'),
		'present' => Locale::translate('editor.reports.isPresent'),
		'reason_for_absence' => Locale::translate('editor.reports.reason')
		);
		$yesNoArray = array('present');
		$yesnoMessages = array( 0 => Locale::translate('common.no'), 1 => Locale::translate('common.yes'));
		$fp = fopen('php://output', 'wt');
		String::fputcsv($fp, array_values($columns));
		
		foreach ($ercMembers as $member) {
			$user = $userDao->getUser($member);
			list($meetingsIterator) =  $meetingDao->getMeetingReportByReviewerId($member, $fromDate, $toDate);
		
			$meetings = array();
			while ($row =& $meetingsIterator->next()) {
				foreach ($columns as $index => $junk) {
					if (in_array($index, $yesNoArray)) {
						$columns[$index] = $yesnoMessages[$row[$index]];
					} elseif ($index == "lastname") {
						$columns[$index] = $user->getLastName();
					} elseif ($index == "firstname") {
						$columns[$index] = $user->getFirstName();
					} elseif ($index == "middlename") {
						$columns[$index] = $user->getMiddleName();
					} else {
						$columns[$index] = $row[$index];
					}
				}
				String::fputcsv($fp, $columns);
				unset($row);
			}
		}
		fclose($fp);
	}
	
	/**
	* Added by MSB 10/11/2011
	* Generate csv file for the submission report
	* @param $args (type)
	*/
	function submissionsReport($args) {
		import ('classes.submission.sectionEditor.SubmissionsReportForm');
		parent::validate();
		$this->setupTemplate();
		$submissionsReportForm= new SubmissionsReportForm($args);
		$isSubmit = Request::getUserVar('generateSubmissionsReport') != null ? true : false;
	
		if ($isSubmit) {
			$submissionsReportForm->readInputData();
			if($submissionsReportForm->validate()){
				$this->generateSubmissionsReport($args);
			}else{
				if ($submissionsReportForm->isLocaleResubmit()) {
					$submissionsReportForm->readInputData();
				}
				$submissionsReportForm->display($args);
			}
		}else {
			$submissionsReportForm->display($args);
		}
	}
	
	
	/**
	 * Generate csv file for the submission report
	 * @param $args (type)
	 */
	function generateSubmissionsReport($args) {
		parent::validate();
		$this->setupTemplate();
	
		$journal =& Request::getJournal();
		$journalId = $journal->getId();
		
		//Get user filter decision
                $submissionsAndCriterias = $this->_getFilteredSubmissions($journalId);
                $submissions = $submissionsAndCriterias[0];
                $criterias = $submissionsAndCriterias[1];
                
                $reportType = Request::getUserVar('reportType');
                
                switch($reportType){
                    case 0:
                        $this->_CSVReport($submissions, $criterias);
                        break;
                    case 1:
                        $this->_simpleChart($submissions, $criterias, $reportType);
                        break;                    
                    case 2:
                        $this->_simpleChart($submissions, $criterias, $reportType);
                        break;                    
                    default :
                        break;
                }
	}
        
        /*
         * Internal function for obtaining the submissions after user filters
         */
        function _getFilteredSubmissions($journalId) {
            
		$sectionId = Request::getUserVar('decisionCommittee');
		$decisionType = Request::getUserVar('decisionType');
		$decisionStatus = Request::getUserVar('decisionStatus');
		$decisionAfter = Request::getUserVar('decisionAfter');
		$decisionBefore = Request::getUserVar('decisionBefore');
                
                $editorSubmissionDao =& DAORegistry::getDAO('EditorSubmissionDAO');

                $submissions =& $editorSubmissionDao->getEditorSubmissionsReport(
                        $journalId, $sectionId, $decisionType, $decisionStatus, $decisionAfter, $decisionBefore);
                
                $criterias = $this->_getCriterias(
                        $sectionId, $decisionType, $decisionStatus, $decisionAfter, $decisionBefore);
                                                
		return array( 0 => $submissions->toArray(), 1 => $criterias);            
        }
        
        /*
         * Internal function - Get criterias of the research (user filters)
         */
        function &_getCriterias(
                        $sectionId, $decisionType, $decisionStatus, $decisionAfter, $decisionBefore){

                $institutionDao =& DAORegistry::getDAO('InstitutionDAO');

                $criterias = array();	
                
                if ($decisionType && $decisionStatus) {
                    $decisionTypesMap = array(
                        INITIAL_REVIEW => 'submission.initialReview',
                        PROGRESS_REPORT => 'submission.progressReport',
                        PROTOCOL_AMENDMENT => 'submission.protocolAmendment',
                        SERIOUS_ADVERSE_EVENT => 'submission.seriousAdverseEvents',
                        FINAL_REPORT => 'submission.finalReport'
                    );
                    $decisionStatusMap = array(
                        98 => 'editor.reports.aDecisionsIUR',
                        99 => 'editor.reports.aDecisionsEUR',
                        SUBMISSION_SECTION_DECISION_APPROVED => 'editor.article.decision.approved',
                        SUBMISSION_SECTION_DECISION_RESUBMIT => 'editor.article.decision.resubmit',
                        SUBMISSION_SECTION_DECISION_DECLINED => 'editor.article.decision.declined'
                    );
                    if ($sectionId != 0) {
                        $sectionDao =& DAORegistry::getDAO('SectionDAO');
                        $section =& $sectionDao->getSection($sectionId);
                        $string = Locale::translate('editor.reports.fromCommittee').' '.$section->getLocalizedAbbrev();
                    } else {
                        $string = Locale::translate('editor.reports.fromCommittee').' '.Locale::translate('editor.reports.anyCommittee');
                    }                   
                    array_push($criterias, (Locale::translate('editor.reports.oneDecisionIs').': '.Locale::translate($decisionTypesMap[$decisionType]).' '.Locale::translate($decisionStatusMap[$decisionStatus]).' '.$string));                    
                }
                if ($decisionAfter && $decisionAfter != "") {
                    if ($decisionStatus != 98) {array_push($criterias, (Locale::translate('editor.reports.criterias.decisionAfter').' '.$decisionAfter.' '.Locale::translate('editor.reports.dateInclusive')));}
                    else {array_push($criterias, (Locale::translate('editor.reports.criterias.submittedAfter').' '.$decisionAfter.' '.Locale::translate('editor.reports.dateInclusive')));}
                }
                if ($decisionBefore && $decisionBefore != "") {
                    if ($decisionStatus != 98) {array_push($criterias, (Locale::translate('editor.reports.criterias.decisionBefore').' '.$decisionBefore.' '.Locale::translate('editor.reports.dateInclusive')));}
                    else {array_push($criterias, (Locale::translate('editor.reports.criterias.submittedBefore').' '.$decisionBefore.' '.Locale::translate('editor.reports.dateInclusive')));}
                }
                                
                return $criterias;
        }
        
        function _CSVReport($proposals, $criterias){
                
                $institutionDao =& DAORegistry::getDAO('InstitutionDAO');
                $countryDao =& DAORegistry::getDAO('CountryDAO');
                $extraFieldDao =& DAORegistry::getDAO('ExtraFieldDAO');

                $journal =& Request::getJournal();

                header('content-type: text/comma-separated-values');
		header('content-disposition: attachment; filename=' . $journal->getLocalizedInitials() . '-' . date('YMd') . '-' . Locale::translate('editor.report') . '.csv');
		
		$fp = fopen('php://output', 'wt');
                
                $columns = $this->_getColumnsOfCSV();
                
		//Write into the csv
		String::fputcsv($fp, array_values($columns));
		
		foreach ($proposals as $proposal) {
                    $decisions = $proposal->getDecisions();
                    $investigators = $proposal->getAuthors();    
                    
                    // Set up the for loops in case of multi entries for one proposal
                    if(array_key_exists('committee', $columns)){$decisionsCount = count($decisions);} 
                    else {$decisionsCount = 1;}
                    if(Request::getUserVar('checkAllInvestigators')){$investigatorsCount = count($investigators);} 
                    else {$investigatorsCount = 1;}
                    if(array_key_exists('sourceInstitution', $columns)){$sourcesCount = count($sources);} 
                    else {$sourcesCount = 1;}
                    
                    
                    // Loop through all the possible mutli entries and write the data
                    for($dI = 0; $dI < $decisionsCount; $dI++){
                        for($iI = 0; $iI < $investigatorsCount; $iI++){
                            foreach ($columns as $index => $junk) {

                                // General
                                if ($index == 'proposalId') {
                                    $columns[$index] = $proposal->getProposalId();
                                } elseif ($index == 'committee') {
                                    $columns[$index] = $decisions[$dI]->getSectionAcronym();
                                } elseif ($index == 'decisionType') {
                                    $columns[$index] = Locale::translate($decisions[$dI]->getReviewTypeKey());
                                } elseif ($index == 'decisionStatus') {
                                    $columns[$index] = Locale::translate($decisions[$dI]->getReviewStatusKey());
                                } elseif ($index == 'decisionDate') {
                                    $columns[$index] = date("d-M-Y", strtotime($decisions[$dI]->getDateDecided()));
                                } elseif ($index == 'submitDate') {
                                    $columns[$index] = date("d-M-Y", strtotime($proposal->getDateSubmitted()));
                                }

                                // Investigator(s)
                                elseif ($index == 'investigator') {
                                    $columns[$index] = $this->_removeCommaForCSV($investigators[$iI]->getFullName(true));
                                } elseif ($index == 'investigatorAffiliation') {
                                    $columns[$index] = $this->_removeCommaForCSV($investigators[$iI]->getAffiliation());
                                } elseif ($index == 'investigatorEmail') {
                                    $columns[$index] = $investigators[$iI]->getEmail();
                                } 

                            }						
                            String::fputcsv($fp, $columns);
                        }

                    }
		}
                
                // Display or not the search criterias on the bottom of the CSV file
                if(Request::getUserVar('checkShowCriterias')){
                    String::fputcsv($fp, array(''));
                    String::fputcsv($fp, array(''));
                    if (!empty($criterias)) {
                        $i = 0;
                        foreach ($criterias as $criteria) {
                            if ($i != 0) {
                                $criteria = Locale::translate('common.and').' '.$criteria;
                                String::fputcsv($fp, array('', $criteria));
                            } else {
                                    String::fputcsv($fp, array(Locale::translate('editor.reports.criterias'), $criteria));
                            }	
                            $i++;			
                        }
                    }                    
                } 
		
		fclose($fp);
            
        }
        
        /*
         * Internal function for getting the user' selection of columns for the CSV
         * @return columns Array
         */
        function &_getColumnsOfCSV(){
            
                $journal =& Request::getJournal();
            
		// Implement the columns of the CSV 
		$columns = array();
		
                // General
		if (Request::getUserVar('checkProposalId')){
			$columns = $columns + array('proposalId' => Locale::translate("common.proposalId"));
		}
		if (Request::getUserVar('checkDecisions')){
			$columns = $columns + array('committee' => Locale::translate("editor.article.committee"));
			$columns = $columns + array('decisionType' => Locale::translate("editor.reports.decisionType"));
			$columns = $columns + array('decisionStatus' => Locale::translate("editor.reports.decisionStatus"));
			$columns = $columns + array('decisionDate' => Locale::translate("editor.reports.decisionDate"));
		}
		if (Request::getUserVar('checkDateSubmitted')){
			$columns = $columns + array('submitDate' =>  Locale::translate("editor.reports.submitDate"));
		}
                
                // Investigator(s)
		if (Request::getUserVar('checkName')){
			$columns = $columns + array('investigator' => Locale::translate("editor.reports.author"));
		}
		if (Request::getUserVar('checkAffiliation')){
			$columns = $columns + array('investigatorAffiliation' => Locale::translate("editor.reports.authorAffiliation"));
		}
		if (Request::getUserVar('checkEmail')){
			$columns = $columns + array('investigatorEmail' => Locale::translate("editor.reports.authorEmail"));
		}
                
                return $columns;
            
        }
        
        /*
         * Internal function for removing the comma(s) of a string before a CSV export
         */
        function _removeCommaForCSV($string){
            return str_replace(',', '', $string);
        }
        
        /*
         * Internal function for replacing all double quotes of a string by single quote and brace it with double quote
         */
        function _replaceQuoteCSV($string){
            return '"'.str_replace('"', "'", $string).'"';
        }
        
        function _simpleChart($proposals, $criterias, $reportType){
            
            $countryDao =& DAORegistry::getDAO('CountryDAO');
            $extraFieldDao =& DAORegistry::getDAO('ExtraFieldDAO');
            
            $this->setupTemplate();
            $journal =& Request::getJournal();
                
            $measurement = Request::getUserVar('measurement');
            $chartOptions = Request::getUserVar('chartOptions');
            
            import('classes.lib.libchart.classes.libchart');
            
            if ($reportType == 1) {$pieChart = new PieChart();}
            elseif ($reportType == 2) {$pieChart = new VerticalBarChart();}
            
            $dataSet = new XYDataSet();
            $dataSetArray = array();
            
            $keyNA = Locale::translate('editor.reports.notApplicable');
            $keyN = Locale::translate('editor.reports.nationwide');
            $keyWHS = Locale::translate('editor.reports.chart.withoutHumanSubjects');
            
            if ($measurement == 0){$endTitle = Locale::translate('common.bySomebody').' '.Locale::translate('editor.reports.measurement.proposalNmbre');} 
            else {$endTitle = Locale::translate('common.bySomebody').' '.Locale::translate('editor.reports.measurement.cumulatedBudget');}
            
            foreach ($proposals as $proposal){
                if ($measurement == 0){ $toSumUp = (int) 1;} 
                else {$toSumUp = (int) $proposal->getTotalBudget();}
            }
                                
            switch ($chartOptions) {
            }

            foreach ($dataSetArray as $key => $value){
        	$dataSet->addPoint(new Point($key.' ('.$value.')', $value));                        
            }
            
            $pieChart->setDataSet($dataSet);
            $pieChart->render("classes/lib/libchart/images/".$journal->getLocalizedInitials(). '-'.Locale::translate('editor.reports.chart').".png");
            
            $templateMgr =& TemplateManager::getManager();
            
            $templateMgr->assign('chartLocation', "/classes/lib/libchart/images/".$journal->getLocalizedInitials(). '-'.Locale::translate('editor.reports.chart').".png");
            $templateMgr->assign('criterias', $criterias);
                
            $templateMgr->display('sectionEditor/reports/showChart.tpl');
        }
}

?>
