<?php

/**
 * @file classes/author/form/submit/AuthorSubmitStep2Form.inc.php
 *
 * @class AuthorSubmitStep2Form
 * @ingroup author_form_submit
 *
 * @brief Form for Step 2 of author article submission.
 */

import('classes.author.form.submit.AuthorSubmitForm');
import('classes.form.validation.FormValidatorArrayRadios');

class AuthorSubmitStep2Form extends AuthorSubmitForm {

	/**
	 * Constructor.
	 */
	function AuthorSubmitStep2Form(&$article, &$journal) {
		parent::AuthorSubmitForm($article, 2, $journal);
                
		$this->addCheck(new FormValidatorArray($this, 'articleTexts', 'required', 'author.submit.form.titlesRequired', array('scientificTitle', 'publicTitle')));
		$this->addCheck(new FormValidatorArray($this, 'articleTexts', 'required', 'author.submit.form.textsRequired', array('description', 'keyInclusionCriteria', 'keyExclusionCriteria')));                
                $this->addCheck(new FormValidator($this, 'articleDetails-protocolVersion', 'required', 'author.submit.form.protocolVersion.required'));
                $this->addCheck(new FormValidator($this, 'articleDetails-therapeuticArea', 'required', 'author.submit.form.therapeuticArea.required'));
                $this->addCheck(new FormValidator($this, 'articleDetails-otherTherapeuticArea', 'required', 'author.submit.form.otherTherapeuticArea.required'));
		$this->addCheck(new FormValidatorArray($this, 'articleDetails-healthConds', 'required', 'author.submit.form.icd10s.required'));                
		$this->addCheck(new FormValidatorArray($this, 'purposes', 'required', 'author.submit.form.purposes.required', array('interventional')));                
		$this->addCheck(new FormValidatorArray($this, 'purposes', 'required', 'author.submit.form.purposes.fields.required', array('type', 'ctPhase', 'allocation', 'masking', 'control', 'assignment', 'endpoint')));                
		$this->addCheck(new FormValidatorArray($this, 'primaryOutcomes', 'required', 'author.submit.form.primaryOutcome.required', array('name', 'measurement', 'timepoint'), true));                
                $this->addCheck(new FormValidator($this, 'articleDetails-minAgeNum', 'required', 'author.submit.form.minAgeNum.required'));
                $this->addCheck(new FormValidator($this, 'articleDetails-maxAgeNum', 'required', 'author.submit.form.maxAgeNum.required'));
                $this->addCheck(new FormValidator($this, 'articleDetails-sex', 'required', 'author.submit.form.sex.required'));
                $this->addCheck(new FormValidator($this, 'articleDetails-healthy', 'required', 'author.submit.form.healthy.required'));
                $this->addCheck(new FormValidator($this, 'articleDetails-localeSampleSize', 'required', 'author.submit.form.localeSampleSize.required'));
                $this->addCheck(new FormValidator($this, 'articleDetails-multinational', 'required', 'author.submit.form.multinational.required'));
		$this->addCheck(new FormValidatorArray($this, 'articleDetails-intSampleSize', 'required', 'author.submit.form.intSampleSize.required'));
                $this->addCheck(new FormValidator($this, 'articleDetails-startDate', 'required', 'author.submit.form.startDate.required'));
                $this->addCheck(new FormValidator($this, 'articleDetails-endDate', 'required', 'author.submit.form.endDate.required'));
                $this->addCheck(new FormValidator($this, 'articleDetails-recruitStatus', 'required', 'author.submit.form.recruitStatus.required'));
                $this->addCheck(new FormValidator($this, 'articleDetails-adScheme', 'required', 'author.submit.form.adScheme.required'));                
        }
	
        /* Overwrite getting the value of a form field for allowing sub-arrays of arrays.
	 * @param $key string
	 * @return mixed
	 */
	function getData($key) {
                if (!strpos($key, '-')) {
                    return isset($this->_data[$key]) ? $this->_data[$key] : null;                    
                } else {
                    $keyArray = explode('-', $key);
                    $data = null;
                    $countArray = count($keyArray);
                    switch ($countArray) {
                        case 2: 
                            $data = $this->_data[$keyArray[0]][$keyArray[1]];
                            break;
                        case 3:
                            $data = $this->_data[$keyArray[0]][$keyArray[1]][$keyArray[2]];
                            break;
                        case 4:
                            $data = $this->_data[$keyArray[0]][$keyArray[1]][$keyArray[2]][$keyArray[3]];
                            break;
                        default: $data = null;
                            
                    }
                    return isset($data) ? $data : null;                    
                }
	}

        
	/**
	 * Initialize form data from current article.
	 */
	function initData() {
                $journal = Request::getJournal();
                
		if (isset($this->article)) {
			$article =& $this->article;
                        
                        $articleSecIds =& $article->getArticleSecIds();
                        $articleSecIdsArray = array();
                        if ($articleSecIds == null) {
                            $articleSecIdsArray = array(0 => array('type' => null, 'id' => null));
                        } else foreach ($articleSecIds as $articleSecId) {
                            array_push(
                                    $articleSecIdsArray,
                                    array(
                                            'articleSecIdId' => $articleSecId->getId(),
                                            'type' => $articleSecId->getType(),
                                            'id' => $articleSecId->getSecId()
                                    )
                            );
			}
                        
                        $articleDetails =& $article->getArticleDetails();
                        
                        $healthConds = $articleDetails->getHealthCondDiseaseArray();
                        if ($healthConds == null){
                            $healthConds = array(0 => array('code' => null, 'exactCode' => null));
                        }

                        $intSampleSize = $articleDetails->getIntSampleSizeArray();
                        if ($intSampleSize == null){
                            $intSampleSize = array(0 => array('country' => null, 'number' => null));
                        }
                        $articleDetailsArray = array(
                            'protocolVersion' => $articleDetails->getProtocolVersion(),
                            'therapeuticArea' => $articleDetails->getTherapeuticArea(),
                            'otherTherapeuticArea' => $articleDetails->getOtherTherapeuticArea(),
                            'healthConds' => $healthConds,
                            'minAgeNum' => $articleDetails->getMinAgeNum(),
                            'minAgeUnit' => $articleDetails->getMinAgeUnit(),
                            'maxAgeNum' => $articleDetails->getMaxAgeNum(),
                            'maxAgeUnit' => $articleDetails->getMaxAgeUnit(),
                            'sex' => $articleDetails->getSex(),
                            'healthy' => $articleDetails->getHealthy(),
                            'localeSampleSize' => $articleDetails->getLocaleSampleSize(),
                            'multinational' => $articleDetails->getMultinational(),
                            'intSampleSize' => $intSampleSize,
                            'startDate' => $articleDetails->getStartDate(),
                            'endDate' => $articleDetails->getEndDate(),
                            'recruitStatus' => $articleDetails->getRecruitmentStatus(),
                            'adScheme' => $articleDetails->getAdvertisingScheme()
                        );

                        $purposes =& $article->getArticlePurposes();
                        $purposesArray = array();
                        if ($purposes == null) {
                            $purposesArray = array(0 => array('interventional' => null, 'type' => null, 'ctPhase' => null, 'allocation' => null, 'masking' => null, 'control' => null, 'assignment' => null, 'endpoint' => null));
                        } else {
                            foreach ($purposes as $purpose) {
                                array_push(
                                    $purposesArray,
                                    array(
                                        'id' => $purpose->getId(),
                                        'interventional' => $purpose->getInterventional(),
                                        'type' => $purpose->getType(),
                                        'ctPhase' => $purpose->getCTPhase(),
                                        'allocation' => $purpose->getAllocation(),
                                        'masking' => $purpose->getMasking(),
                                        'control' => $purpose->getControl(),         
                                        'assignment' => $purpose->getAssignment(),  
                                        'endpoint' => $purpose->getEndpoint()                                        
                                    )
                                );
                            }
                        }
                        
                        
                        $primaryOutcomes = $article->getArticleOutcomesByType(ARTICLE_OUTCOME_PRIMARY);
                        $primaryOutcomesArray = array();
                        if (empty($primaryOutcomes)) {
                            foreach ($journal->getSupportedLocaleNames() as $localeKey => $localeValue) {
                                $primaryOutcomesArray = array(0 => array($localeKey => array('primaryOutcomeId' => null, 'type' => ARTICLE_OUTCOME_PRIMARY, 'name' => null, 'measurement' => null, 'timepoint' => null)));
                            }
                        } else foreach ($primaryOutcomes as $poKey => $primaryOutcome) {
                            foreach ($journal->getSupportedLocaleNames() as $localeKey => $localeValue) {
                                if (isset($primaryOutcome[$localeKey])) {
                                    $primaryOutcomesArray[$poKey][$localeKey] = array(
                                        'primaryOutcomeId' => $primaryOutcome[$localeKey]->getId(),
                                        'type' => ARTICLE_OUTCOME_PRIMARY,
                                        'name' => $primaryOutcome[$localeKey]->getName(),
                                        'measurement' => $primaryOutcome[$localeKey]->getMeasurement(),
                                        'timepoint' => $primaryOutcome[$localeKey]->getTimepoint()         
                                    );
                                }
                            }
                        }
                        $secondaryOutcomes = $article->getArticleOutcomesByType(ARTICLE_OUTCOME_SECONDARY);
                        $secondaryOutcomesArray = array();
                        if (empty($secondaryOutcomes)) {
                            foreach ($journal->getSupportedLocaleNames() as $localeKey => $localeValue) {
                                $secondaryOutcomesArray = array(0 => array($localeKey => array('primaryOutcomeId' => null, 'type' => ARTICLE_OUTCOME_SECONDARY, 'name' => null, 'measurement' => null, 'timepoint' => null)));
                            }
                        } else foreach ($secondaryOutcomes as $soKey => $secondaryOutcome) {
                            foreach ($journal->getSupportedLocaleNames() as $localeKey => $localeValue) {
                                if (isset($secondaryOutcome[$localeKey])) {
                                    $secondaryOutcomesArray[$soKey][$localeKey] = array(
                                        'secondaryOutcomeId' => $secondaryOutcome[$localeKey]->getId(),
                                        'type' => ARTICLE_OUTCOME_SECONDARY,
                                        'name' => $secondaryOutcome[$localeKey]->getName(),
                                        'measurement' => $secondaryOutcome[$localeKey]->getMeasurement(),
                                        'timepoint' => $secondaryOutcome[$localeKey]->getTimepoint()         
                                    );
                                }
                            }
                        }
                        
                        
                        $this->_data = array(
                            	'articleTexts' => array(),
                                'articleDetails' => $articleDetailsArray,
                            	'articleSecIds' => $articleSecIdsArray,
                            	'purposes' => $purposesArray,
                                'primaryOutcomes' => $primaryOutcomesArray,
                                'secondaryOutcomes' => $secondaryOutcomesArray
			);
                        
                        $articleTexts =& $article->getArticleTexts();
                        foreach ($journal->getSupportedLocaleNames() as $localeKey => $localeValue) {
                            if (isset($articleTexts[$localeKey])) {
                                $this->_data['articleTexts'][$localeKey] = array(
                                        'articleTextId' => $articleTexts[$localeKey]->getId(),
                                        'scientificTitle' => $articleTexts[$localeKey]->getScientificTitle(),
                                        'publicTitle' => $articleTexts[$localeKey]->getPublicTitle(),
                                        'description' => $articleTexts[$localeKey]->getDescription(),
                                        'keyInclusionCriteria' => $articleTexts[$localeKey]->getKeyInclusionCriteria(),
                                        'keyExclusionCriteria' => $articleTexts[$localeKey]->getKeyExclusionCriteria(),
                                        'recruitmentInfo' => $articleTexts[$localeKey]->getRecruitmentInfo(),
                                    );
                            }
                        }
                        
                        
                        
		}
		return parent::initData();
	}

	/**
	 * Assign form data to user-submitted data.
	 */
	function readInputData() {
		$this->readUserVars(
			array(
                            'articleTexts',
                            'articleSecIds',
                            'articleDetails',
                            'purposes',
                            'primaryOutcomes',
                            'secondaryOutcomes'
                        )
		);
	}

	/**
	 * Get the names of fields for which data should be localized
	 * @return array
	 */
	function getLocaleFieldNames() {
		return array();
	}

	/**
	 * Display the form.
	 */
	function display() {
                $journal = Request::getJournal();
                
                $extraFieldDAO =& DAORegistry::getDAO('ExtraFieldDAO');
                $articleSecIdDao =& DAORegistry::getDAO('ArticleSecIdDAO');
                $articleDetailsDao =& DAORegistry::getDAO('ArticleDetailsDAO');
                $purposeDao =& DAORegistry::getDAO('ArticlePurposeDAO');
		$countryDao =& DAORegistry::getDAO('CountryDAO');
                
                $therapeuticAreas = $extraFieldDAO->getExtraFieldsList(EXTRA_FIELD_THERAPEUTIC_AREA, EXTRA_FIELD_ACTIVE);
                $therapeuticAreasWithOther = $therapeuticAreas + array('OTHER' => Locale::translate('common.other'));                
                
		$templateMgr =& TemplateManager::getManager();
                $templateMgr->assign('articleTextLocales', $journal->getSupportedLocaleNames());
                $templateMgr->assign('articleSecIdTypeList', $articleSecIdDao->getTypeMap());
                $templateMgr->assign('articleDetailsTherapeuticAreasList', $therapeuticAreasWithOther);
                $templateMgr->assign('ICD10List', $articleDetailsDao->getICD10s());
                $templateMgr->assign('interventionalRadios', $purposeDao->getInterventionalMap());
                $templateMgr->assign('purposeTypesList', $purposeDao->getTypeMap());
                $templateMgr->assign('CTPhasesList', $purposeDao->getCTPhaseMap());
                $templateMgr->assign('allocationsList', $purposeDao->getAllocationMap());
                $templateMgr->assign('maskingList', $purposeDao->getMaskingMap());
                $templateMgr->assign('controlList', $purposeDao->getControlMap());
                $templateMgr->assign('assignmentList', $purposeDao->getAssignmentMap());
                $templateMgr->assign('endpointList', $purposeDao->getEndpointMap());
                $templateMgr->assign('ageUnitList', $articleDetailsDao->getAgeUnitMap());
                $templateMgr->assign('sexList', $articleDetailsDao->getSexMap());
                $templateMgr->assign('yesNoList', $articleDetailsDao->getYesNoMap());
                $templateMgr->assign('coveringArea', $journal->getLocalizedSetting('location'));
                $templateMgr->assign('coutryList', $countryDao->getCountries());
                $templateMgr->assign('recruitmentStatusMap', $articleDetailsDao->getRecruitmentStatusMap());
                
                parent::display();
	}

	/**
	 * Save changes to article.
	 * @param $request Request
	 * @return int the article ID
	 */
	function execute(&$request) {
		$articleDao =& DAORegistry::getDAO('ArticleDAO');
		$article =& $this->article;
                
                ///////////////////////
                ///// UPDATE TEXTS/////
                ///////////////////////
                
                $journal = Request::getJournal();
                $articleTexts = $this->getData('articleTexts');
                foreach ($journal->getSupportedLocaleNames() as $localeKey => $localeValue) {
                    if ($articleTexts[$localeKey]['articleTextId'] > 0) {
                        $articleText = $article->getArticleTextByLocale($localeKey);
                        $isExistingArticleText = true;
                    } else {
                        $articleText = new ArticleText();
                        $isExistingArticleText = false;
                    }
                    
                    if ($articleText != null) {
                        
                        $articleText->setArticleId($article->getId());		
                        $articleText->setLocale($localeKey);
                        $articleText->setScientificTitle($articleTexts[$localeKey]['scientificTitle']);
                        $articleText->setPublicTitle($articleTexts[$localeKey]['publicTitle']);
                        $articleText->setDescription($articleTexts[$localeKey]['description']);
                        $articleText->setKeyInclusionCriteria($articleTexts[$localeKey]['keyInclusionCriteria']);
                        $articleText->setKeyExclusionCriteria($articleTexts[$localeKey]['keyExclusionCriteria']);
                        $articleText->setRecruitmentInfo($articleTexts[$localeKey]['recruitmentInfo']);		
                        if ($isExistingArticleText == false) {
                                $article->addArticleText($articleText);
                        }

                    }
                    unset($articleText);                    
                }                
                
                ///////////////////////////////////////////
		/////////// Update secondary IDs //////////
                ///////////////////////////////////////////
                
                $secIds = $article->getArticleSecIds();
                $secIdsData = $this->getData('articleSecIds');
                
                //Remove secondary IDs
                foreach ($secIds as $secId) {
                    $isPresent = false;
                    foreach ($secIdsData as $secIdData) {
                        if (!empty($secIdData['articleSecIdId'])) {
                            if ($secId->getId() == $secIdData['articleSecIdId']) {
                                $isPresent = true;
                            }
                        }
                    }
                    if (!$isPresent) {
                        $article->removeArticleSecId($secId->getId());
                    }
                    unset($secId);                    
                }
                foreach ($secIdsData as $secIdData) {  
                    if (!empty($secIdData['type']) && !empty($secIdData['id'])) {
                        if (!empty($secIdData['articleSecIdId'])) {
                            // Update an existing sec id
                            $secId =& $article->getArticleSecId($secIdData['articleSecIdId']);
                        } else {
                            // Create a new sec id
                            $secId = new ArticleSecId();
                        }                        
                        if ($secId != null) {
                            $secId->setArticleId($article->getId());
                            $secId->setType($secIdData['type']);
                            $secId->setSecId($secIdData['id']);                            
                            $article->addArticleSecId($secId);
                        }
                        unset($secId);
                    }
                } 
                ///////////////////////////////////////////
		////////// Update Article Details /////////
                ///////////////////////////////////////////
                
                $articlelDetailsData = $this->getData('articleDetails');
                $articleDetails = new ArticleDetails();

		$articleDetails->setArticleId($article->getId());
		$articleDetails->setProtocolVersion($articlelDetailsData['protocolVersion']);
		$articleDetails->setTherapeuticArea($articlelDetailsData['therapeuticArea'], $articlelDetailsData['otherTherapeuticArea']);
		$articleDetails->setHealthCondDiseaseFromArray($articlelDetailsData['healthConds']);
		$articleDetails->setMinAgeNum($articlelDetailsData['minAgeNum']);
		$articleDetails->setMinAgeUnit($articlelDetailsData['minAgeUnit']);
		$articleDetails->setMaxAgeNum($articlelDetailsData['maxAgeNum']);
		$articleDetails->setMaxAgeUnit($articlelDetailsData['maxAgeUnit']);
		$articleDetails->setSex($articlelDetailsData['sex']);
		$articleDetails->setHealthy($articlelDetailsData['healthy']);
		$articleDetails->setLocaleSampleSize($articlelDetailsData['localeSampleSize']);
		$articleDetails->setMultinational($articlelDetailsData['multinational']);
		$articleDetails->setIntSampleSizeFromArray($articlelDetailsData['intSampleSize']);
		$articleDetails->setStartDate($articlelDetailsData['startDate']);
		$articleDetails->setEndDate($articlelDetailsData['endDate']);
		$articleDetails->setRecruitmentStatus($articlelDetailsData['recruitStatus']);
		$articleDetails->setAdvertisingScheme($articlelDetailsData['adScheme']);

                
                $article->setArticleDetails($articleDetails);

                ///////////////////////////////////////////
		////////// Update Article Purposes ////////
                ///////////////////////////////////////////
                
                $purposesData = $this->getData('purposes');
                $purposes = $article->getArticlePurposes();
                
                //Remove deleted article purposes
                foreach ($purposes as $purpose) {
                    $isPresent = false;
                    foreach ($purposesData as $purposeData) {
                        if (!empty($purposeData['id'])) {
                            if ($purpose->getId() == $purposeData['id']) {
                                $isPresent = true;
                            }
                        }
                    }
                    if (!$isPresent) {
                        $article->removeArticlePurpose($purpose->getId());
                    }
                    unset($purpose);                    
                }
                foreach ($purposesData as $purposeData) {   
                    if (!empty($purposeData['interventional'])) {
                        if (!empty($purposeData['id'])) {
                            // Update an existing purpose
                            $purpose =& $article->getArticlePurpose($purposeData['id']);
                        } else {
                            // Create a new article purpose
                            $purpose = new ArticlePurpose();
                        }               
                        if ($purpose != null) {
                            $purpose->setArticleId($article->getId());
                            if ($purposeData['interventional'] == ARTICLE_PURPOSE_TYPE_OBS) {
                                $purpose->setType(ARTICLE_PURPOSE_TYPE_OBS);                                
                            } else {
                                $purpose->setType($purposeData['type']);                                
                            }
                            $purpose->setCTPhase($purposeData['ctPhase']); 
                            $purpose->setAllocation($purposeData['allocation']); 
                            $purpose->setMasking($purposeData['masking']); 
                            $purpose->setControl($purposeData['control']); 
                            $purpose->setAssignment($purposeData['assignment']); 
                            $purpose->setEndpoint($purposeData['endpoint']); 
                          
                            $article->addArticlePurpose($purpose);
                        }
                        unset($purpose);
                    }
                }                 
                
                ///////////////////////////////////////////
		////////// Update Article Outcomes ////////
                ///////////////////////////////////////////
                
                $primaryOutcomesData = $this->getData('primaryOutcomes');
                $secondaryOutcomesData = $this->getData('secondaryOutcomes');                
                $articlelOutcomes = $article->getArticleOutcomes();
                
                //Remove outcomes
                foreach ($articlelOutcomes as $articlelOutcome) {
                    $isPresent = false;
                    foreach ($primaryOutcomesData as $primaryOutcomeData) {
                        foreach ($journal->getSupportedLocaleNames() as $localeKey => $localeValue) {
                            if (!empty($primaryOutcomeData[$localeKey]['primaryOutcomeId'])) {
                                if ($articlelOutcome[$localeKey]->getId() == $primaryOutcomeData[$localeKey]['primaryOutcomeId']) {
                                    $isPresent = true;
                                }
                            }                            
                        }
                    }
                    foreach ($secondaryOutcomesData as $secondaryOutcomeData) {
                        foreach ($journal->getSupportedLocaleNames() as $localeKey => $localeValue) {
                            if (!empty($secondaryOutcomeData[$localeKey]['secondaryOutcomeId'])) {
                                if ($articlelOutcome[$localeKey]->getId() == $secondaryOutcomeData[$localeKey]['secondaryOutcomeId']) {
                                    $isPresent = true;
                                }
                            }
                        }
                    }
                    if (!$isPresent) {
                        foreach ($journal->getSupportedLocaleNames() as $localeKey => $localeValue) {
                            if (!empty($articlelOutcome[$localeKey])){
                                $article->removeArticleOutcome($articlelOutcome[$localeKey]->getId());                                                            
                            }
                        }
                    }
                    unset($articlelOutcome);                    
                }
                foreach ($primaryOutcomesData as $poKey => $primaryOutcomeData) {
                    foreach ($journal->getSupportedLocaleNames() as $localeKey => $localeValue) {
                        if (!empty($primaryOutcomeData[$localeKey]['name']) && !empty($primaryOutcomeData[$localeKey]['measurement']) && !empty($primaryOutcomeData[$localeKey]['timepoint'])) {
                            if (!empty($primaryOutcomeData[$localeKey]['primaryOutcomeId'])) {
                                $primaryOutcome = $article->getArticleOutcome($primaryOutcomeData[$localeKey]['primaryOutcomeId']);
                            } else {
                                $primaryOutcome = new ArticleOutcome();
                            }
                            if($primaryOutcome != null){
                                $primaryOutcome->setArticleId($article->getId());
                                $primaryOutcome->setName($primaryOutcomeData[$localeKey]['name']);
                                $primaryOutcome->setLocale($localeKey);
                                $primaryOutcome->setType(ARTICLE_OUTCOME_PRIMARY);
                                $primaryOutcome->setMeasurement($primaryOutcomeData[$localeKey]['measurement']);
                                $primaryOutcome->setTimepoint($primaryOutcomeData[$localeKey]['timepoint']);
                                $article->addArticleOutcome($primaryOutcome);                                
                            }
                            unset($primaryOutcome);
                        }
                    }    
                }
                foreach ($secondaryOutcomesData as $poKey => $secondaryOutcomeData) {
                    foreach ($journal->getSupportedLocaleNames() as $localeKey => $localeValue) {
                        if (!empty($secondaryOutcomeData[$localeKey]['name']) && !empty($secondaryOutcomeData[$localeKey]['measurement']) && !empty($secondaryOutcomeData[$localeKey]['timepoint'])) {
                            if (!empty($secondaryOutcomeData[$localeKey]['secondaryOutcomeId'])) {
                                $secondaryOutcome = $article->getArticleOutcome($secondaryOutcomeData[$localeKey]['secondaryOutcomeId']);
                            } else {
                                $secondaryOutcome = new ArticleOutcome();
                            }
                            if($secondaryOutcome != null){
                                $secondaryOutcome->setArticleId($article->getId());
                                $secondaryOutcome->setName($secondaryOutcomeData[$localeKey]['name']);
                                $secondaryOutcome->setLocale($localeKey);
                                $secondaryOutcome->setType(ARTICLE_OUTCOME_SECONDARY);
                                $secondaryOutcome->setMeasurement($secondaryOutcomeData[$localeKey]['measurement']);
                                $secondaryOutcome->setTimepoint($secondaryOutcomeData[$localeKey]['timepoint']);
                                $article->addArticleOutcome($secondaryOutcome);                                
                            }
                            unset($secondaryOutcome);
                        }
                    }    
                }
                //update step
                if ($article->getSubmissionProgress() <= $this->step) {
			$article->stampStatusModified();
			$article->setSubmissionProgress($this->step + 1);
		} elseif ($article->getSubmissionProgress() == 9) {
                        $article->setSubmissionProgress(8);                            
                }               

		parent::execute();

		// Save the article
		$articleDao->updateArticle($article);
                
		return $this->articleId;
	}
}

?>
