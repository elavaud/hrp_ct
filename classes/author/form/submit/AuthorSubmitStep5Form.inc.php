<?php

/**
 * @file classes/author/form/submit/AuthorSubmitStep5Form.inc.php
 *
 * @class AuthorSubmitStep5Form
 * @ingroup author_form_submit
 *
 * @brief Form for Step 5 of author article submission.
 */

import('classes.author.form.submit.AuthorSubmitForm');
import('classes.form.validation.FormValidatorArrayRadios');

class AuthorSubmitStep5Form extends AuthorSubmitForm {

        var $institutionDao;
    
	/**
	 * Constructor.
	 */
	function AuthorSubmitStep5Form(&$article, &$journal) {
            parent::AuthorSubmitForm($article, 5, $journal);
            $this->institutionDao = DAORegistry::getDAO("InstitutionDAO");
            $this->addCheck(new FormValidatorArray($this, 'fundingSources', 'required', 'author.submit.form.fundingSources.required', array('institutionId', 'name', 'acronym', 'type', 'location', 'locationCountry', 'locationInternational')));	
            $this->addCheck(new FormValidatorCustom($this, 'fundingSources', 'required', 'author.submit.form.fundingSources.nameUsed', function($fundingSources) {foreach ($fundingSources as $fundingSource) { if($this->institutionDao->institutionExistsByName($fundingSource['name'])) {return false;}} return true;})); 
            $this->addCheck(new FormValidatorCustom($this, 'fundingSources', 'required', 'author.submit.form.fundingSources.acronymUsed', function($fundingSources) {foreach ($fundingSources as $fundingSource) {if($this->institutionDao->institutionExistsByAcronym($fundingSource['acronym'])) {return false;}}return true;})); 
            $this->addCheck(new FormValidatorArrayRadios($this, 'primarySponsor', 'required', 'author.submit.form.primarySponsor.required', array('location')));
            $this->addCheck(new FormValidatorCustom($this, 'primarySponsor', 'required', 'author.submit.form.primarySponsor.nameUsed', function($primarySponsor) {if($this->institutionDao->institutionExistsByName($primarySponsor['name'])) {return false;} return true;})); 
            $this->addCheck(new FormValidatorCustom($this, 'primarySponsor', 'required', 'author.submit.form.primarySponsor.acronymUsed', function($primarySponsor) {if($this->institutionDao->institutionExistsByAcronym($primarySponsor['acronym'])) {return false;}return true;}));             
            $this->addCheck(new FormValidatorArray($this, 'secondarySponsors', 'required', 'author.submit.form.secondarySponsors.required', array('ssName', 'ssAcronym', 'ssType', 'ssLocation', 'ssLocationCountry', 'ssLocationInternational')));	
            $this->addCheck(new FormValidatorCustom($this, 'secondarySponsors', 'required', 'author.submit.form.secondarySponsors.nameUsed', function($secondarySponsors) {foreach ($secondarySponsors as $secondarySponsor) { if($this->institutionDao->institutionExistsByName($secondarySponsor['ssName'])) {return false;}} return true;})); 
            $this->addCheck(new FormValidatorCustom($this, 'secondarySponsors', 'required', 'author.submit.form.secondarySponsors.acronymUsed', function($secondarySponsors) {foreach ($secondarySponsors as $secondarySponsor) {if($this->institutionDao->institutionExistsByAcronym($secondarySponsor['ssAcronym'])) {return false;}}return true;})); 

            // Check if same new institution has been entered twice or more in the fields but the user provided different acronyms for the same name or oppositely
            if(isset($_POST['primarySponsor']) && isset($_POST['secondarySponsors'])) {      
                $this->addCheck(new FormValidatorCustom($this, 'fundingSources', 'required', 'author.submit.form.sponsors.differentNameAcronym', 
                    function($fundingSources, $primarySponsor, $secondarySponsors) {
                        foreach ($fundingSources as $fundingSource) {
                            if ($fundingSource['name'] == $primarySponsor['name'] && $fundingSource['name'] != 'NA' && $fundingSource['acronym'] != $primarySponsor['acronym']) return false;
                            elseif ($fundingSource['acronym'] == $primarySponsor['acronym'] && $fundingSource['acronym'] != 'NA' && $fundingSource['name'] != $primarySponsor['name']) return false;
                            foreach ($secondarySponsors as $secondarySponsor) {
                                if ($fundingSource['name'] == $secondarySponsor['ssName'] && $fundingSource['name'] != 'NA' && $fundingSource['acronym'] != $secondarySponsor['ssAcronym']) return false;
                                elseif ($fundingSource['acronym'] == $secondarySponsor['ssAcronym'] && $fundingSource['acronym'] != 'NA' && $fundingSource['name'] != $secondarySponsor['ssName']) return false;
                                if ($secondarySponsor['ssName'] == $primarySponsor['name'] && $secondarySponsor['ssName'] != 'NA' && $secondarySponsor['ssAcronym'] != $primarySponsor['acronym']) return false;
                                elseif ($secondarySponsor['ssAcronym'] == $primarySponsor['acronym'] && $secondarySponsor['ssAcronym'] != 'NA' && $secondarySponsor['ssName'] != $primarySponsor['name']) return false;
                            }
                        }
                        return true;
                    }, array($_POST["primarySponsor"], $_POST["secondarySponsors"])
                )); 
            }            
            
            // Check if same acronym or same name has been used in the funding sources
            $this->addCheck(new FormValidatorCustom($this, 'fundingSources', 'required', 'author.submit.form.fundingSources.nameOrAcronymAlreadyProvided', 
                function($fundingSources) {
                    foreach ($fundingSources as $fundingSource) { 
                        $found = 0;
                        foreach ($fundingSources as $sFundingSource){
                            if (($fundingSource['name']!= 'NA' && $fundingSource['name'] == $sFundingSource['name']) || ($fundingSource['acronym']!= 'NA' && $fundingSource['acronym'] == $sFundingSource['acronym'])) {
                                $found++;
                            }
                        }
                        if ($found > 1) {
                            return false;
                        }
                    } return true;
                })); 
                
            // Check if same acronym or same name has been used in the secondary sponsors
            $this->addCheck(new FormValidatorCustom($this, 'secondarySponsors', 'required', 'author.submit.form.secondarySponsors.nameOrAcronymAlreadyProvided', 
                function($secondarySponsors) {
                    foreach ($secondarySponsors as $secondarySponsor) { 
                        $found = 0;
                        foreach ($secondarySponsors as $sSecondarySponsor){
                            if (($secondarySponsor['ssName']!= 'NA' && $secondarySponsor['ssName'] == $sSecondarySponsor['ssName']) || ($secondarySponsor['ssAcronym']!= 'NA' && $secondarySponsor['ssAcronym'] == $sSecondarySponsor['ssAcronym'])) {
                                $found++;
                            }
                        }
                        if ($found > 1) {
                            return false;
                        }
                    } return true;
                }));                 
        }
        

	/**
	 * Initialize form data from current article.
	 */
	function initData() {
            if (isset($this->article)) {
                $article =& $this->article;

                $fundingSources = $article->getArticleFundingSources();
                $fundingSourcesArray = array();
                if ($fundingSources == null) {
                    $fundingSourcesArray = array(0 => null);
                } else foreach ($fundingSources as $fundingSource){
                    array_push (
                        $fundingSourcesArray,
                        array(
                            'id' => $fundingSource->getId(),
                            'institutionId' => $fundingSource->getInstitutionId()
                        )
                    );
                }
                $primarySponsor = $article->getArticlePrimarySponsor();
                $primarySponsorArray = array();
                if ($primarySponsor != null) {
                    $primarySponsorArray = array('id' => $primarySponsor->getId(), 'institutionId' => $primarySponsor->getInstitutionId());
                }
                $secondarySponsors = $article->getArticleSecondarySponsors();
                $secondarySponsorsArray = array();
                if ($secondarySponsors == null) {
                    $secondarySponsorsArray = array(0 => null);
                } else foreach ($secondarySponsors as $secondarySponsor){
                    array_push (
                        $secondarySponsorsArray,
                        array(
                            'id' => $secondarySponsor->getId(),
                            'ssInstitutionId' => $secondarySponsor->getInstitutionId()
                        )
                    );
                }
                
                $this->_data = array(
                    'fundingSources' => $fundingSourcesArray,
                    'primarySponsor' => $primarySponsorArray,
                    'secondarySponsors' => $secondarySponsorsArray
                );

            }
            return parent::initData();
	}

	/**
	 * Assign form data to user-submitted data.
	 */
	function readInputData() {
		$this->readUserVars(
			array(
                            'fundingSources',
                            'primarySponsor',
                            'secondarySponsors'
                        )
		);

                // Load the section. This is used in the step 5 form to
		// determine whether or not to display indexing options.
		$sectionDao =& DAORegistry::getDAO('SectionDAO');
		$this->_data['section'] =& $sectionDao->getSection($this->article->getSectionId());
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
		$countryDao =& DAORegistry::getDAO('CountryDAO');
                $extraFieldDAO =& DAORegistry::getDAO('ExtraFieldDAO');
		$institutionDao =& DAORegistry::getDAO('InstitutionDAO');
                
                $geoAreas =& $extraFieldDAO->getExtraFieldsList(EXTRA_FIELD_GEO_AREA, EXTRA_FIELD_ACTIVE);
                
                $institutionsList = $institutionDao->getInstitutionsList();
                $institutionsListWithOther = $institutionsList + array('OTHER' => Locale::translate('common.other'));
                
		$templateMgr =& TemplateManager::getManager();
                $templateMgr->assign('institutionTypesList', $institutionDao->getInstitutionTypes());
                $templateMgr->assign('geoAreasList', $geoAreas);
                $templateMgr->assign('coutryList', $countryDao->getCountries());
                $templateMgr->assign('institutionsList', $institutionsListWithOther);
                $templateMgr->assign('internationalArray', $institutionDao->getInstitutionInternationalArray());
                                
                parent::display();
	}

	/**
	 * Save changes to article.
	 * @param $request Request
	 * @return int the article ID
	 */
	function execute(&$request) {
		$articleDao =& DAORegistry::getDAO('ArticleDAO');
		$institutionDao =& DAORegistry::getDAO('InstitutionDAO');
                import ('classes.journal.Institution');
		$article =& $this->article;
                
                $fundingSourcesData = $this->getData('fundingSources');
                $primarySponsorData = $this->getData('primarySponsor');
                $secondarySponsorsData = $this->getData('secondarySponsors');
                
                $newInstitutions = array();
                
                foreach ($fundingSourcesData as $fundingSourceData) {
                    if (isset($fundingSourceData['id'])) {
                        $articleSource = $article->getArticleFundingSource($fundingSourceData['id']);
                    } else {
                        $articleSource = new ArticleSponsor();
                    }
                    $articleSource->setArticleId($article->getId());
                    $articleSource->setType(ARTICLE_SPONSOR_TYPE_FUNDING);
                    if ($fundingSourceData['institutionId'] == 'OTHER') {
                        $institution = new Institution();
                        $institution->setInstitutionName($fundingSourceData['name']);
                        $institution->setInstitutionAcronym($fundingSourceData['acronym']);
                        $institution->setInstitutionType($fundingSourceData['type']);
                        $institution->setInstitutionInternational($fundingSourceData['location']);                    
                        if($fundingSourceData['location'] == INSTITUTION_NATIONAL){
                            $institution->setInstitutionLocation($fundingSourceData['locationCountry']);
                        } elseif($fundingSourceData['location'] == INSTITUTION_INTERNATIONAL){
                            $institution->setInstitutionLocation($fundingSourceData['locationInternational']);
                        }
                        $institutionId = $institutionDao->insertInstitution($institution);
                        $articleSource->setInstitutionId($institutionId);
                        $fundingSourceData['institutionId'] = $institutionId;
                        array_push($newInstitutions, $fundingSourceData);
                        unset($institution);
                    } else {
                        $articleSource->setInstitutionId($fundingSourceData['institutionId']);
                    }
                    $article->addArticleFundingSource($articleSource);
                    unset($articleSource);
                }
                
                if (isset($primarySponsorData['id'])) {
                    $primarySponsor = $article->getArticlePrimarySponsor();
                } else {
                    $primarySponsor = new ArticleSponsor();
                }
                $primarySponsor->setArticleId($article->getId());
                $primarySponsor->setType(ARTICLE_SPONSOR_TYPE_PRIMARY);
                if ($primarySponsorData['institutionId'] == 'OTHER') {
                    $found = false;
                    foreach ($newInstitutions as $newInstitution) {
                        if ($newInstitution['name'] == $primarySponsorData['name'] || $newInstitution['acronym'] == $primarySponsorData['acronym']){
                            $found = $newInstitution['institutionId'];
                        }
                    }
                    if(!$found) {
                        $institution = new Institution();
                        $institution->setInstitutionName($primarySponsorData['name']);
                        $institution->setInstitutionAcronym($primarySponsorData['acronym']);
                        $institution->setInstitutionType($primarySponsorData['type']);
                        $institution->setInstitutionInternational($primarySponsorData['location']);                    
                        if($primarySponsorData['location'] == INSTITUTION_NATIONAL){
                            $institution->setInstitutionLocation($primarySponsorData['locationCountry']);
                        } elseif($primarySponsorData['location'] == INSTITUTION_INTERNATIONAL){
                            $institution->setInstitutionLocation($primarySponsorData['locationInternational']);
                        }
                        $institutionId = $institutionDao->insertInstitution($institution);
                        $primarySponsor->setInstitutionId($institutionId);
                        $primarySponsorData['institutionId'] = $institutionId;
                        array_push($newInstitutions, $primarySponsorData);
                        unset($institution);
                    } else {
                        $primarySponsor->setInstitutionId($found);
                    }
                } else {
                    $primarySponsor->setInstitutionId($primarySponsorData['institutionId']);
                }
                $article->setArticlePrimarySponsor($primarySponsor);
                
                foreach ($secondarySponsorsData as $secondarySponsorData) {
                    if (isset($secondarySponsorData['id'])) {
                        $secondarySponsor = $article->getArticleSecondarySponsor($secondarySponsorData['id']);
                    } else {
                        $secondarySponsor = new ArticleSponsor();
                    }
                    $secondarySponsor->setArticleId($article->getId());
                    $secondarySponsor->setType(ARTICLE_SPONSOR_TYPE_SECONDARY);                    
                    if ($secondarySponsorData['ssInstitutionId'] == 'OTHER'){
                        $found = false;
                        foreach ($newInstitutions as $newInstitution) {
                            if ($newInstitution['name'] == $secondarySponsorData['ssName'] || $newInstitution['acronym'] == $secondarySponsorData['ssAcronym']){
                                $found = $newInstitution['institutionId'];
                            }
                        }
                        if(!$found) {
                            $institution = new Institution();
                            $institution->setInstitutionName($secondarySponsorData['ssName']);
                            $institution->setInstitutionAcronym($secondarySponsorData['ssAcronym']);
                            $institution->setInstitutionType($secondarySponsorData['ssType']);
                            $institution->setInstitutionInternational($secondarySponsorData['ssLocation']);                    
                            if($secondarySponsorData['ssLocation'] == INSTITUTION_NATIONAL){
                                $institution->setInstitutionLocation($secondarySponsorData['ssLocationCountry']);
                            } elseif($secondarySponsorData['ssLocation'] == INSTITUTION_INTERNATIONAL){
                                $institution->setInstitutionLocation($secondarySponsorData['ssLocationInternational']);
                            }
                            $institutionId = $institutionDao->insertInstitution($institution);
                            $secondarySponsor->setInstitutionId($institutionId);
                            $primarySponsorData['institutionId'] = $institutionId;
                            array_push($newInstitutions, array ('institutionId' => $institutionId, 'name' => $secondarySponsorData['ssName'], 'acronym' => $secondarySponsorData['ssAcronym']));
                            unset($institution);
                        } else {
                            $secondarySponsor->setInstitutionId($found);
                        }                        
                    } else {
                        $secondarySponsor->setInstitutionId($secondarySponsorData['ssInstitutionId']);
                    }
                    $article->addArticleSecondarySponsor($secondarySponsor);
                    unset($secondarySponsor);
                }
                
                //update step
                if ($article->getSubmissionProgress() <= $this->step) {
			$article->stampStatusModified();
			$article->setSubmissionProgress($this->step + 1);
		}                

		parent::execute();

		// Save the article
		$articleDao->updateArticle($article);

		return $this->articleId;
	}
}

?>
