<?php

/**
 * @file classes/manager/form/setup/JournalSetupStep3Form.inc.php
 *
 * Copyright (c) 2003-2011 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class JournalSetupStep3Form
 * @ingroup manager_form_setup
 *
 * @brief Form for Step 3 of journal setup.
 */



import('classes.manager.form.setup.JournalSetupForm');

class JournalSetupStep3Form extends JournalSetupForm {
	/**
	 * Constructor.
	 */
	function JournalSetupStep3Form() {
		parent::JournalSetupForm(
			3,
			array(
				'authorGuidelines' => 'string',
				'submissionChecklistInfo' => 'string',
        			'submissionChecklist' => 'object',
                                'sourceCurrency' => 'string',
                                'convertionRate' => 'int',
                                'progressReportGuidelines' => 'string',
                                'completionReportGuidelines' => 'string',
                                'protocolAmendmentGuidelines' => 'string',
                                'saeGuidelines' => 'string'
			)
		);
                
                $this->addCheck(new FormValidatorEmail($this, 'copySubmissionAckAddress', 'optional', 'user.profile.form.emailRequired'));
	}

	/**
	 * Get the list of field names for which localized settings are used.
	 * @return array
	 */
	function getLocaleFieldNames() {
		return array('authorGuidelines', 'submissionChecklistInfo','submissionChecklist', 'progressReportGuidelines', 'completionReportGuidelines', 'protocolAmendmentGuidelines', 'saeGuidelines'/*, 'copyrightNotice', 'metaDisciplineExamples', 'metaSubjectClassTitle', 'metaSubjectClassUrl', 'metaSubjectExamples', 'metaCoverageGeoExamples', 'metaCoverageChronExamples', 'metaCoverageResearchSampleExamples', 'metaTypeExamples', 'competingInterestGuidelines'*/);
	}

	/**
	 * Display the form
	 * @param $request Request
	 * @param $dispatcher Dispatcher
	 */
	function display($request, $dispatcher) {
                
		$templateMgr =& TemplateManager::getManager($request);
		// Add extra style sheets required for ajax components
		// FIXME: Must be removed after OMP->OJS backporting
		$templateMgr->addStyleSheet($request->getBaseUrl().'/styles/ojs.css');

		// Add extra java script required for ajax components
		// FIXME: Must be removed after OMP->OJS backporting
		$templateMgr->addJavaScript('lib/pkp/js/grid-clickhandler.js');
		$templateMgr->addJavaScript('lib/pkp/js/modal.js');
		$templateMgr->addJavaScript('lib/pkp/js/lib/jquery/plugins/validate/jquery.validate.min.js');
		$templateMgr->addJavaScript('lib/pkp/js/jqueryValidatorI18n.js');

		import('classes.mail.MailTemplate');
		$mail = new MailTemplate('SUBMISSION_ACK');
		if ($mail->isEnabled()) {
			$templateMgr->assign('submissionAckEnabled', true);
		}

		// Citation editor filter configuration
		//
		// 1) Check whether PHP5 is available.
		if (!checkPhpVersion('5.0.0')) {
			Locale::requireComponents(array(LOCALE_COMPONENT_PKP_SUBMISSION));
			$citationEditorError = 'submission.citations.editor.php5Required';
		} else {
			$citationEditorError = null;
		}
		$templateMgr->assign('citationEditorError', $citationEditorError);

		if (!$citationEditorError) {
			// 2) Add the filter grid URLs
			$parserFilterGridUrl = $dispatcher->url($request, ROUTE_COMPONENT, null, 'grid.filter.ParserFilterGridHandler', 'fetchGrid');
			$templateMgr->assign('parserFilterGridUrl', $parserFilterGridUrl);
			$lookupFilterGridUrl = $dispatcher->url($request, ROUTE_COMPONENT, null, 'grid.filter.LookupFilterGridHandler', 'fetchGrid');
			$templateMgr->assign('lookupFilterGridUrl', $lookupFilterGridUrl);

			// 3) Create a list of all available citation output filters.
			$router =& $request->getRouter();
			$journal =& $router->getContext($request);
			import('lib.pkp.classes.metadata.MetadataDescription');
			$inputSample = new MetadataDescription('lib.pkp.classes.metadata.nlm.NlmCitationSchema', ASSOC_TYPE_CITATION);
			$outputSample = 'any string';
			$filterDao =& DAORegistry::getDAO('FilterDAO');
			$metaCitationOutputFilterObjects =& $filterDao->getCompatibleObjects($inputSample, $outputSample, $journal->getId());
			foreach($metaCitationOutputFilterObjects as $metaCitationOutputFilterObject) {
				$metaCitationOutputFilters[$metaCitationOutputFilterObject->getId()] = $metaCitationOutputFilterObject->getDisplayName();
			}
			$templateMgr->assign_by_ref('metaCitationOutputFilters', $metaCitationOutputFilters);
		}
                
		$currencyDao =& DAORegistry::getDAO('CurrencyDAO');
		$currencies =& $currencyDao->getCurrencies();
		$currenciesArray = array();
		foreach ($currencies as $currency) {
                        $currenciesArray[$currency->getCodeAlpha()] = $currency->getName() . ' (' . $currency->getCodeAlpha() . ')';
		}                
		$templateMgr->assign('currencies', $currenciesArray);                
                
                $originalSourceCurrencyAlpha = $journal->getSetting('sourceCurrency');
                $originalSourceCurrency = $currencyDao->getCurrencyByAlphaCode($originalSourceCurrencyAlpha);
		$templateMgr->assign('originalSourceCurrency', $originalSourceCurrency->getName().' ('.$originalSourceCurrencyAlpha.')');                
                
		parent::display($request, $dispatcher);
	}
        
	function execute() {
		return parent::execute();
	}        
        
}

?>
