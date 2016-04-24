<?php

/**
 * @file NewSearchHandler.inc.php
 *
 * Copyright (c) 2003-2011 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class NewSearchHandler
 * @ingroup pages_search
 *
 * @brief Handle site index requests. 
 */

// $Id$


import('classes.search.ArticleSearch');
import('classes.handler.Handler');

class NewSearchHandler extends Handler {
	/**
	 * Constructor
	 **/
	function NewSearchHandler() {
		parent::Handler();
		$this->addCheck(new HandlerValidatorCustom($this, false, null, null, create_function('$journal', 'return !$journal || $journal->getSetting(\'publishingMode\') != PUBLISHING_MODE_NONE;'), array(Request::getJournal())));
	}

	/**
	 * Show the advanced form
	 */
	function index() {
		$this->validate();
		$this->advanced();
	}

	/**
	 * Show the advanced form
	 */
	function search() {
		$this->validate();
		$this->advanced();
	}

	/**
	 * Show advanced search form.
	 */
	function advanced() {
		$this->validate();
		$this->setupTemplate(false);
		$templateMgr =& TemplateManager::getManager();

		$templateMgr->assign('query', Request::getUserVar('query'));
		$fromDate = Request::getUserDateVar('dateFrom', 1, 1);
		
		if ($fromDate !== null) $fromDate = date('Y-m-d H:i:s', $fromDate);
		$toDate = Request::getUserDateVar('dateTo', 32, 12, null, 23, 59, 59);
		if ($toDate !== null) $toDate = date('Y-m-d H:i:s', $toDate);
		
                $extraFieldDao =& DAORegistry::getDAO('ExtraFieldDAO');
                $countries =& $extraFieldDao->getExtraFieldsList(EXTRA_FIELD_GEO_AREA);
                $templateMgr->assign_by_ref('proposalCountries', $countries);	
		
		$templateMgr->assign('dateFrom', $fromDate);
		$templateMgr->assign('dateTo', $toDate);
		
		$templateMgr->display('search/search.tpl');
	}

	/**
	 * Show basic search results.
	 */
	function results() {
		$this->validate();
		$this->advancedResults();
	}

	/**
	 * Show advanced search results.
	 */
	function advancedResults() {
		
		$this->validate();
		$this->setupTemplate(true);
				
		$query = Request::getUserVar('query');
		
		$fromDate = Request::getUserVar('dateFrom');
		if(!$fromDate) $fromDate = Request::getUserDateVar('dateFrom', 1, 1);

		$toDate = Request::getUserVar('dateTo');		
                if(!$toDate) $toDate = Request::getUserDateVar('dateTo', 1, 12, null, 23, 59, 59);

                $country = Request::getUserVar('proposalCountry');

		$status = Request::getUserVar('status');

                $trialSite = Request::getUserVar('trialSite');
		
		$rangeInfo =& Handler::getRangeInfo('search');
		
		$sort = Request::getUserVar('sort');
		$sort = isset($sort) ? $sort : 'title';
		
		$sortDirection = Request::getUserVar('sortDirection');
		$sortDirection = (isset($sortDirection) && ($sortDirection == SORT_DIRECTION_ASC || $sortDirection == SORT_DIRECTION_DESC)) ? $sortDirection : SORT_DIRECTION_ASC;

		$templateMgr =& TemplateManager::getManager();
		
		$templateMgr->assign('dateFrom', $fromDate);
		$templateMgr->assign('dateTo', $toDate);
                
                if ($fromDate == '--') $fromDate = null;
                if ($toDate == '--') $toDate = null;                
                if ($fromDate !== null) $fromDate = date('Y-m-d H:i:s', $fromDate);
		if ($toDate !== null) $toDate = date('Y-m-d H:i:s', $toDate);
                
		$articleDao =& DAORegistry::getDAO('ArticleDAO');
                $extraFieldDao =& DAORegistry::getDAO('ExtraFieldDAO');
                $articleDetailsDao =& DAORegistry::getDAO('ArticleDetailsDAO');
		$trialSiteDao =& DAORegistry::getDAO('TrialSiteDAO');
		$results =& $articleDao->searchProposalsPublic($query, $fromDate, $toDate, $country, $status, $trialSite, $rangeInfo, $sort, $sortDirection);

		$templateMgr->assign('formattedDateFrom', $fromDate);
		$templateMgr->assign('formattedDateTo', $toDate);
                $templateMgr->assign('recruitmentStatusMap', $articleDetailsDao->getRecruitmentStatusMap());
		$templateMgr->assign('statusFilter', $status);
		$templateMgr->assign('trialSite', $trialSite);                
		$templateMgr->assign_by_ref('results', $results);
		$templateMgr->assign('query', $query);
		$templateMgr->assign('region', $country);
                $extraField =& $extraFieldDao->getExtraField($country);
		$templateMgr->assign('country', (isset($extraField) ? $extraField->getLocalizedExtraFieldName() : null));
		$templateMgr->assign('countryCode', $country);
                $templateMgr->assign('proposalCountries', $extraFieldDao->getExtraFieldsList(EXTRA_FIELD_GEO_AREA));	
                $templateMgr->assign('sitesList', $trialSiteDao->getTrialSitesList());	
		$templateMgr->assign('sort', $sort);
		$templateMgr->assign('sortDirection', $sortDirection);

		$templateMgr->assign('count', $results->getCount());		
		
		$templateMgr->assign('dateFrom', $fromDate);
		$templateMgr->assign('dateTo', $toDate);
                
                
		$templateMgr->display('search/searchResults.tpl');
	}
	
	function generateCustomizedCSV($args) {
		parent::validate();
		$this->setupTemplate();
		$query = Request::getUserVar('query');

		$region = Request::getUserVar('region');
		$statusFilter = Request::getUserVar('statusFilter');
				
		$fromDate = Request::getUserVar('dateFrom');
		//if ($fromDate != null) $fromDate = date('Y-m-d H:i:s', $fromDate);		
		$toDate = Request::getUserVar('dateTo');
		//if ($toDate != null) $toDate = date('Y-m-d H:i:s', $toDate);
		
		$columns = array();
		
		$proposalId = false;
		if (Request::getUserVar('proposalId')) {
			$columns = $columns + array('proposalId' => Locale::translate('article.submissionId'));
			$proposalId = true;
		}
					
		$scientificTitle = false;
		if (Request::getUserVar('scientificTitle')) {
			$columns = $columns + array('scientificTitle' => Locale::translate('article.scientificTitle'));
			$scientificTitle = true;
		}
							
		$publicTitle = false;
		if (Request::getUserVar('publicTitle')) {
			$columns = $columns + array('publicTitle' => Locale::translate('article.publicTitle'));
			$publicTitle = true;
		}
		
		$recruitmentStatus = false;
		if (Request::getUserVar('recruitmentStatus')) {
			$columns = $columns + array('recruitmentStatus' => Locale::translate('proposal.recruitment').' '.Locale::translate('proposal.recruitment.status'));
			$recruitmentStatus = true;
		}

		$therapeuticArea = false;
		if (Request::getUserVar('therapeuticArea')) {
			$columns = $columns + array('therapeuticArea' => Locale::translate('proposal.therapeuticArea'));
			$therapeuticArea = true;
		}		
		
		$minAge = false;
		if (Request::getUserVar('minAge')) {
			$columns = $columns + array('minAge' => Locale::translate('proposal.age.minimum'));
			$minAge = true;
		}		
                
		$maxAge = false;
		if (Request::getUserVar('maxAge')) {
			$columns = $columns + array('maxAge' => Locale::translate('proposal.age.maximum'));
			$maxAge = true;
		}		
                
		$sex = false;
		if (Request::getUserVar('sex')) {
			$columns = $columns + array('sex' => Locale::translate('proposal.sex'));
			$sex = true;
		}		
                
                $healthy = false;
		if (Request::getUserVar('healthy')) {
			$columns = $columns + array('healthy' => Locale::translate('proposal.healthy'));
			$healthy = true;
		}		
                
                $pSponsor = false;
		if (Request::getUserVar('pSponsor')) {
			$columns = $columns + array('pSponsor' => Locale::translate('proposal.primarySponsor'));
			$pSponsor = true;
		}		
                
                $enrolment = false;
		if (Request::getUserVar('enrolment')) {
			$columns = $columns + array('enrolment' => Locale::translate('proposal.expectedDate'));
			$enrolment = true;
		}		
                
		header('content-type: text/comma-separated-values');
		header('content-disposition: attachment; filename=searchResults-' . date('Ymd') . '.csv');
				
		
		$fp = fopen('php://output', 'wt');
		String::fputcsv($fp, array_values($columns));

                $articleDao =& DAORegistry::getDAO('ArticleDAO');
		
		$results = $articleDao->searchCustomizedProposalsPublic($query, $region, $fromDate, $toDate, $statusFilter, $proposalId, $scientificTitle, $publicTitle, $recruitmentStatus, $therapeuticArea, $minAge, $maxAge, $sex, $healthy, $pSponsor, $enrolment);

                foreach ($results as $result) {
                        foreach ($columns as $index => $junk) {
				if ($index == 'status') {
					if ($result->getStatus() == '11') $columns[$index] = 'Complete';
					else $columns[$index] = 'Ongoing';
				} elseif ($index == 'date_submitted') {
					$columns[$index] = $result->getDateSubmitted();
				} 
			}
			String::fputcsv($fp, $columns);
		}
		fclose($fp);
		unset($columns);
	}
	
	function viewProposal($args) {
		$journal =& Request::getJournal();
		$articleId = isset($args[0]) ? (int) $args[0] : 0;
		$this->setupTemplate(true, $articleId);
                
		$articleDao =& DAORegistry::getDAO('ArticleDAO');
		$countryDao =& DAORegistry::getDAO('CountryDAO');
                $extraFieldDAO =& DAORegistry::getDAO('ExtraFieldDAO');
                
		$proposal = $articleDao->getArticle($articleId);
                $articleDetails = $proposal->getArticleDetails();
                
		$templateMgr =& TemplateManager::getManager();
		$templateMgr->assign('query', Request::getUserVar('query'));
		$templateMgr->assign('locale', Locale::getLocale());                
		$templateMgr->assign('status', $proposal->getStatus());
		$templateMgr->assign('articleId', $articleId);       
		$templateMgr->assign('proposalId', $proposal->getProposalId());  
		$templateMgr->assign_by_ref('finalReport', $proposal->getPublishedFinalReport());
		$templateMgr->assign_by_ref('articleText', $proposal->getLocalizedArticleText());
                $templateMgr->assign_by_ref('articleSecIds', $proposal->getArticleSecIds());
		$templateMgr->assign('recruitmentStatusKey', $articleDetails->getRecruitmentStatusKey());
		$templateMgr->assign('therapeuticArea', $articleDetails->getRightTherapeuticAreaDisplay());
		$templateMgr->assign('icd10s', $articleDetails->getHealthCondDiseaseArrayToDisplay());
                $templateMgr->assign_by_ref('articlePurposes', $proposal->getArticlePurposes());
                $templateMgr->assign_by_ref('articlePrimaryOutcomes', $proposal->getArticleOutcomesByType(ARTICLE_OUTCOME_PRIMARY));
                $templateMgr->assign_by_ref('articleSecondaryOutcomes', $proposal->getArticleOutcomesByType(ARTICLE_OUTCOME_SECONDARY));
		$templateMgr->assign('minAge', $articleDetails->getMinAgeNum());
		$templateMgr->assign('minAgeUnitKey', $articleDetails->getMinAgeUnitKey());
		$templateMgr->assign('maxAge', $articleDetails->getMaxAgeNum());
		$templateMgr->assign('maxAgeUnitKey', $articleDetails->getMaxAgeUnitKey());
		$templateMgr->assign('sexKey', $articleDetails->getSexKey());
		$templateMgr->assign('healthyYesNoKey', $articleDetails->getYesNoKey($articleDetails->getHealthy()));
                $templateMgr->assign('coveringArea', $journal->getLocalizedSetting('location'));
		$templateMgr->assign('localeSampleSize', $articleDetails->getLocaleSampleSize());
		$templateMgr->assign('multinationalYesNoKey', $articleDetails->getYesNoKey($articleDetails->getMultinational()));
		$templateMgr->assign('multinational', $articleDetails->getMultinational());
                $templateMgr->assign('coutryList', $countryDao->getCountries());
		$templateMgr->assign('intSampleSizeArray', $articleDetails->getIntSampleSizeArray());
		$templateMgr->assign('startDate', $articleDetails->getStartDate());
		$templateMgr->assign('endDate', $articleDetails->getEndDate());
                $templateMgr->assign_by_ref('articleSites', $proposal->getArticleSites());
                $templateMgr->assign('expertisesList', $extraFieldDAO->getExtraFieldsList(EXTRA_FIELD_THERAPEUTIC_AREA, EXTRA_FIELD_ACTIVE));
                $templateMgr->assign_by_ref('fundingSources', $proposal->getArticleFundingSources());
                $templateMgr->assign_by_ref('pSponsor', $proposal->getArticlePrimarySponsor());
                $templateMgr->assign_by_ref('sSponsors', $proposal->getArticleSecondarySponsors());
                $templateMgr->assign_by_ref('contact', $proposal->getArticleContact());                
                
		$templateMgr->display('search/viewProposal.tpl');
	}
	/**
	 * Setup common template variables.
	 * @param $subclass boolean set to true if caller is below this handler in the hierarchy
	 */
	function setupTemplate($subclass = false, $articleId = null) {
		parent::setupTemplate();
		$templateMgr =& TemplateManager::getManager();
		$templateMgr->assign('helpTopicId', 'user.searchAndBrowse');
		if ($articleId == null) {$templateMgr->assign('pageHierarchy',
			$subclass ? array(array(Request::url(null, 'search', 'advancedResults'), 'navigation.search'))
				: array()
		);
		} else {
			$templateMgr->assign('pageHierarchy',
			$subclass ? array(array(Request::url(null, 'search', 'advancedResults'), 'navigation.search'), array(Request::url('hrp', 'search','advancedResults'), 'search.searchResults'))
				: array()
			);
		}
			

		$journal =& Request::getJournal();
		if (!$journal || !$journal->getSetting('restrictSiteAccess')) {
			$templateMgr->setCacheability(CACHEABILITY_PUBLIC);
		}
	}
        
	/**
	 * Download published final report
	 * @param $args ($articleId, fileId)
	 */
	function downloadFinalReport($args) {
		$articleId = isset($args[0]) ? $args[0] : 0;
		$fileId = isset($args[1]) ? $args[1] : 0;
		
		import("classes.file.ArticleFileManager");
		$articleFileManager = new ArticleFileManager($articleId);
		return $articleFileManager->downloadFile($fileId);
	}

}

?>
