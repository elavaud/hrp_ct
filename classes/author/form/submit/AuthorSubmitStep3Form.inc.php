<?php

/**
 * @file classes/author/form/submit/AuthorSubmitStep3Form.inc.php
 *
 * @class AuthorSubmitStep3Form
 * @ingroup author_form_submit
 *
 * @brief Form for Step 3 of author article submission.
 */

import('classes.author.form.submit.AuthorSubmitForm');
import('classes.form.validation.FormValidatorArrayRadios');

class AuthorSubmitStep3Form extends AuthorSubmitForm {

	/**
	 * Constructor.
	 */
	function AuthorSubmitStep3Form(&$article, &$journal) {
            parent::AuthorSubmitForm($article, 3, $journal);
            $this->addCheck(new FormValidatorArray($this, 'articleDrugs', 'required', 'author.submit.form.drugType.required', array('type')));
            $this->addCheck(new FormValidatorArray($this, 'articleDrugs', 'required', 'author.submit.form.drugName.required', array('name')));
            $this->addCheck(new FormValidatorArray($this, 'articleDrugs', 'required', 'author.submit.form.drugAdministration.required', array('administration')));		        
            $this->addCheck(new FormValidatorArray($this, 'articleDrugs', 'required', 'author.submit.form.drugOtherAdministration.required', array('otherAdministration')));		        
            $this->addCheck(new FormValidatorArray($this, 'articleDrugs', 'required', 'author.submit.form.drugForm.required', array('form')));		        
            $this->addCheck(new FormValidatorArray($this, 'articleDrugs', 'required', 'author.submit.form.drugOtherForm.required', array('otherForm')));		        
            $this->addCheck(new FormValidatorArray($this, 'articleDrugs', 'required', 'author.submit.form.drugStrength.required', array('strength')));		        
            $this->addCheck(new FormValidatorArray($this, 'articleDrugs', 'required', 'author.submit.form.drugStorage.required', array('storage')));		        
            $this->addCheck(new FormValidatorArray($this, 'articleDrugs', 'required', 'author.submit.form.drugPharmaClass.required', array('pharmaClass')));		        
            $this->addCheck(new FormValidatorArray($this, 'articleDrugs', 'required', 'author.submit.form.drugStudyClasses.required', array('studyClasses')));
            $this->addCheck(new FormValidatorArray($this, 'articleDrugs', 'required', 'author.submit.form.drugCountry.required', array('countries')));
            $this->addCheck(new FormValidatorArray($this, 'articleDrugs', 'required', 'author.submit.form.drugConditionsOfUse.required', array('conditionsOfUse')));
            $this->addCheck(new FormValidatorArray($this, 'articleDrugs', 'required', 'author.submit.form.drugCPR.required', array('cpr')));            
            $this->addCheck(new FormValidatorArray($this, 'articleDrugs', 'required', 'author.submit.form.drugRegistrationNumber.required', array('drugRegistrationNumber')));                        
            $this->addCheck(new FormValidatorArray($this, 'articleDrugs', 'required', 'author.submit.form.drugManufacturerName.required', array('manufacturers')));                        
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
		$sectionDao =& DAORegistry::getDAO('SectionDAO');
		if (isset($this->article)) {
                    $article =& $this->article;

                    $articleDrugs =& $article->getArticleDrugs();
                    $articleDrugsArray = array();
                    if ($articleDrugs == null) {
                        $articleDrugsArray = array(0 => array('countries' => array(0 =>null), 'manufacturers' => array(0 => null)));
                    } else foreach ($articleDrugs as $articleDrug) {
                        $manufacturers = $articleDrug->getManufacturers();
                        $manufacturersArray = array();
                        if ($manufacturers) {
                            foreach ($manufacturers as $manufacturer){
                                array_push(
                                    $manufacturersArray, 
                                    array (
                                        'id' => $manufacturer->getId(),
                                        'drugId' => $manufacturer->getDrugId(),
                                        'name' => $manufacturer->getName(),
                                        'address' => $manufacturer->getAddress()
                                    )
                                );
                            }
                        }
                        array_push(
                            $articleDrugsArray,
                            array(
                                'id' => $articleDrug->getId(),
                                'type' => $articleDrug->getType(),
                                'name' => $articleDrug->getName(),
                                'brandName' => $articleDrug->getBrandName(),
                                'administration' => $articleDrug->getAdministration(),
                                'otherAdministration' => $articleDrug->getOtherAdministration(),
                                'form' => $articleDrug->getForm(),
                                'otherForm' => $articleDrug->getOtherForm(),
                                'strength' => $articleDrug->getStrength(),
                                'storage' => $articleDrug->getStorage(),
                                'pharmaClass' => $articleDrug->getPharmaClass(),
                                'studyClasses' => $articleDrug->getClassesArray(),
                                'countries' => $articleDrug->getCountriesArray(),
                                'conditionsOfUse' => $articleDrug->getDifferentConditionsOfUse(),
                                'cpr' => $articleDrug->getCPR(),
                                'drugRegistrationNumber' => $articleDrug->getDrugRegistrationNumber(),
                                'importedQuantity' => $articleDrug->getImportedQuantity(),
                                'manufacturers' => $manufacturersArray
                            )
                        );
                    }
                    $this->_data = array(
                            'articleDrugs' => $articleDrugsArray
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
				'articleDrugs'	
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
                $articleDrugInfoDao =& DAORegistry::getDAO('ArticleDrugInfoDAO');
		$countryDao =& DAORegistry::getDAO('CountryDAO');
                
                $drugAdministrationMap = $articleDrugInfoDao->getAdministrationMap();
                $drugAdministrationMapWithOther = $drugAdministrationMap + array('OTHER' => Locale::translate('common.other'));   

                $drugFormMap = $articleDrugInfoDao->getFormMap();
                $drugFormMapWithOther = $drugFormMap + array('OTHER' => Locale::translate('common.other'));   
                
		$templateMgr =& TemplateManager::getManager();
                $templateMgr->assign('drugTypeMap', $articleDrugInfoDao->getTypeMap());
                $templateMgr->assign('drugAdministrationMap', $drugAdministrationMapWithOther);
                $templateMgr->assign('drugFormMap', $drugFormMapWithOther);
                $templateMgr->assign('drugStorageMap', $articleDrugInfoDao->getStorageMap());
                $templateMgr->assign('drugPharmaClasses', $articleDrugInfoDao->getPharmaClasses());
                $templateMgr->assign('drugStudyClasses', $articleDrugInfoDao->getClassMap());
                $templateMgr->assign('coutryList', $countryDao->getCountries());
                $templateMgr->assign('yesNoMap', $articleDrugInfoDao->getYesNoMap());
                
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
                
                $articleDrugsData = $this->getData('articleDrugs');
                foreach ($articleDrugsData as $articleDrugData) {
                    if (isset($articleDrugData['id'])) {
                        $articleDrug = $article->getArticleDrug($articleDrugData['id']);
                        $isExistingDrug = true;
                    } else {
                        $articleDrug = new ArticleDrugInfo();
                        $isExistingDrug = false;
                    }
                    $articleDrug->setArticleId($article->getId());
                    $articleDrug->setType($articleDrugData['type']);
                    $articleDrug->setName($articleDrugData['name']);
                    $articleDrug->setBrandName($articleDrugData['brandName']);
                    $articleDrug->setAdministration($articleDrugData['administration']);
                    $articleDrug->setOtherAdministration($articleDrugData['otherAdministration']);
                    $articleDrug->setForm($articleDrugData['form']);
                    $articleDrug->setOtherForm($articleDrugData['otherForm']);
                    $articleDrug->setStrength($articleDrugData['strength']);
                    $articleDrug->setStorage($articleDrugData['storage']);
                    $articleDrug->setPharmaClass($articleDrugData['pharmaClass']);
                    $articleDrug->setClassesFromArray($articleDrugData['studyClasses']);
                    $articleDrug->setCountriesFromArray($articleDrugData['countries']);
                    $articleDrug->setDifferentConditionsOfUse($articleDrugData['conditionsOfUse']);
                    $articleDrug->setCPR($articleDrugData['cpr']);
                    $articleDrug->setDrugRegistrationNumber($articleDrugData['drugRegistrationNumber']);
                    $articleDrug->setImportedQuantity($articleDrugData['importedQuantity']);
                    
                    $manufacturersData = $articleDrugData['manufacturers'];
                    foreach ($manufacturersData as $manufacturerData) {                        
                        if (isset($manufacturerData['id'])) {
                            $manufacturer = $articleDrug->getManufacturer($manufacturerData['id']);
                        } else {
                            $manufacturer = new ArticleDrugManufacturer();
                        }
                        if ($isExistingDrug) {
                            $manufacturer->setDrugId($articleDrug->getId());
                        }
                        $manufacturer->setName($manufacturerData['name']);
                        $manufacturer->setAddress($manufacturerData['address']);
                        $articleDrug->addManufacturer($manufacturer);
                    }
                    $article->addArticleDrug($articleDrug);
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
