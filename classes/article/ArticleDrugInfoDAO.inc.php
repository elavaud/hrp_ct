<?php

/**
 * @file classes/article/ArticleDrugInfoDAO.inc.php
 *
 * @class ArticleDrugInfoDAO
 *
 * @brief Operations for retrieving and modifying ArticleDrugInfo objects.
 */

import('classes.article.ArticleDrugInfo');

class ArticleDrugInfoDAO extends DAO {

        /**
	 * Constructor
	 */
	function ArticleDrugInfoDAO() {
            parent::DAO();
	}
        
    	/**
	 * Get the article drug info object of a submission.
	 * @param $articleDrugInfoId int
	 * @return ArticleDrugInfo object
	 */
	function &getArticleDrugInfoById($articleDrugInfoId) {

		$result =& $this->retrieve('SELECT * FROM article_drug_info WHERE drug_id = ?', (int) $articleDrugInfoId);		

		$articleDrugInfo =& $this->_returnArticleDrugInfoFromRow($result->GetRowAssoc(false));

		$result->Close();
		unset($result);

		return $articleDrugInfo;
	}

        /**
	 * Get all article drug info objects of a submission.
	 * @param $articleId int
	 * @return array ArticleDrugInfo
	 */
	function &getArticleDrugInfosByArticleId($articleId) {
                $articleDrugInfos = array();
                
		$result =& $this->retrieve('SELECT * FROM article_drug_info WHERE article_id = ?', (int) $articleId);		

		while (!$result->EOF) {
                    	$row =& $result->getRowAssoc(false);
			$articleDrugInfos[] =& $this->_returnArticleDrugInfoFromRow($row);
			$result->moveNext();
		}
		$result->Close();
		unset($result);

		return $articleDrugInfos;
	}


	/**
	 * Insert a new ArticleDrugInfo object.
	 * @param $articleDrugInfo ArticleDrugInfo
	 */
	function insertArticleDrugInfo(&$articleDrugInfo) {
		$this->update(
			'INSERT INTO article_drug_info 
				(article_id, type, name, brand_name, administration, 
                                other_administration, form, other_form, strength, storage, 
                                pharma_class, study_class, countries, different_conditions_of_use, cpr, 
                                drug_registration_number, imported_quantity)
			VALUES
				(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
			array(
				(int) $articleDrugInfo->getArticleId(),
				$articleDrugInfo->getType(),
				$articleDrugInfo->getName(),
				$articleDrugInfo->getBrandName(),
				$articleDrugInfo->getAdministration(),
				$articleDrugInfo->getOtherAdministration(),
				$articleDrugInfo->getForm(),
				$articleDrugInfo->getOtherForm(),
				$articleDrugInfo->getStrength(),
				$articleDrugInfo->getStorage(),
				$articleDrugInfo->getPharmaClass(),
				$articleDrugInfo->getClasses(),
				$articleDrugInfo->getCountries(),
				$articleDrugInfo->getDifferentConditionsOfUse(),
				$articleDrugInfo->getCPR(),
				$articleDrugInfo->getDrugRegistrationNumber(),
				$articleDrugInfo->getImportedQuantity()
			)
		);		
		return true;
	}

	/**
	 * Update an existing ArticleDrugInfo.
	 * @param $articleDrugInfo ArticleDrugInfo
	 */
	function updateArticleDrugInfo(&$articleDrugInfo) {
		$returner = $this->update(
			'UPDATE article_drug_info
			SET	
				article_id = ?, 
                                type = ?, 
                                name = ?, 
                                brand_name = ?, 
                                administration = ?, 
                                other_administration = ?, 
                                form = ?, 
                                other_form = ?, 
                                strength = ?, 
                                storage = ?, 
                                pharma_class = ?, 
                                study_class = ?, 
                                countries = ?, 
                                different_conditions_of_use = ?, 
                                cpr = ?, 
                                drug_registration_number = ?, 
                                imported_quantity = ?
			WHERE	drug_id = ?',
			array(
				(int) $articleDrugInfo->getArticleId(),
				$articleDrugInfo->getType(),
				$articleDrugInfo->getName(),
				$articleDrugInfo->getBrandName(),
				$articleDrugInfo->getAdministration(),
				$articleDrugInfo->getOtherAdministration(),
				$articleDrugInfo->getForm(),
				$articleDrugInfo->getOtherForm(),
				$articleDrugInfo->getStrength(),
				$articleDrugInfo->getStorage(),
				$articleDrugInfo->getPharmaClass(),
				$articleDrugInfo->getClasses(),
				$articleDrugInfo->getCountries(),
				$articleDrugInfo->getDifferentConditionsOfUse(),
				$articleDrugInfo->getCPR(),
				$articleDrugInfo->getDrugRegistrationNumber(),
				$articleDrugInfo->getImportedQuantity(),
                                $articleDrugInfo->getId()
			)
		);
		return true;
	}

	/**
	 * Delete a specific articleDrugInfo by ID
	 * @param $articleDrugInfoId int
	 */
	function deleteArticleDrugInfo($articleDrugInfoId) {
		
		$returner = $this->update('DELETE FROM article_drug_info WHERE drug_id = ?',(int) $articleDrugInfoId);
		
		return $returner;
	}

        /**
	 * Delete articleDrugInfos by article ID
	 * @param $articleId int
	 */
	function deleteArticleDrugInfosByArticleId($articleId) {
		
		$returner = $this->update('DELETE FROM article_drug_info WHERE article_id = ?',(int) $articleId);
		
		return $returner;
	}
      
        
	/**
	 * Check if an articleDrugInfo exists
	 * @param $submissionId int
	 * @return boolean
	 */
	function articleDrugInfoExists($submissionId) {
		
		$result =& $this->retrieve('SELECT count(*) FROM article_drug_info WHERE article_id = ?', (int) $submissionId);
		
		$returner = $result->fields[0]?true:false;
		$result->Close();
		
		return $returner;
	}

	/**
	 * Internal function to return an articleDrugInfo object from a row.
	 * @param $row array
	 * @return articleDrugInfo ArticleDrugInfo
	 */
	function &_returnArticleDrugInfoFromRow(&$row) {            
		$articleDrugInfo = new ArticleDrugInfo();
		$articleDrugInfo->setId($row['drug_id']);
		$articleDrugInfo->setArticleId($row['article_id']);
                $articleDrugInfo->setType($row['type']);
                $articleDrugInfo->setName($row['name']);
                $articleDrugInfo->setBrandName($row['brand_name']);
                $articleDrugInfo->setAdministration($row['administration']);
                $articleDrugInfo->setOtherAdministration($row['other_administration']);
                $articleDrugInfo->setForm($row['form']);
                $articleDrugInfo->setOtherForm($row['other_form']);
                $articleDrugInfo->setStrength($row['strength']);
                $articleDrugInfo->setStorage($row['storage']);
                $articleDrugInfo->setPharmaClass($row['pharma_class']);
                $articleDrugInfo->setClasses($row['study_class']);
                $articleDrugInfo->setCountries($row['countries']);
                $articleDrugInfo->setDifferentConditionsOfUse($row['different_conditions_of_use']);
                $articleDrugInfo->setCPR($row['cpr']);
                $articleDrugInfo->setDrugRegistrationNumber($row['drug_registration_number']);
                $articleDrugInfo->setImportedQuantity($row['imported_quantity']);
                
		HookRegistry::call('ArticleDrugInfoDAO::_returnArticleDrugInfoFromRow', array(&$articleDrugInfo, &$row));

		return $articleDrugInfo;
	}
     
        /**
	 * Get a map for the type constants to locale key.
	 * @return array
	 */
	function &getTypeMap() {
		static $typeMap;
		if (!isset($typeMap)) {
			$typeMap = array(
				ARTICLE_DRUG_INFO_TYPE_STUDY_DRUG => Locale::translate('proposal.drugInfo.type.studyDrug'),
				ARTICLE_DRUG_INFO_TYPE_CONCOMITANT => Locale::translate('proposal.drugInfo.type.concomitant'),
				ARTICLE_DRUG_INFO_TYPE_COMPARATOR => Locale::translate('proposal.drugInfo.type.comparator'),
				ARTICLE_DRUG_INFO_TYPE_PLACEBO => Locale::translate('proposal.drugInfo.type.placebo')
			);
		}
		return $typeMap;
	}
        /**
	 * Get a map for the administration constants to locale key.
	 * @return array
	 */
	function &getAdministrationMap() {
		static $administrationMap;
		if (!isset($administrationMap)) {
			$administrationMap = array(
                                ARTICLE_DRUG_INFO_ADMINISTRATION_GASTRO => Locale::translate('proposal.drugInfo.administration.gastro'),
                                ARTICLE_DRUG_INFO_ADMINISTRATION_INJECTION => Locale::translate('proposal.drugInfo.administration.injection'),
                                ARTICLE_DRUG_INFO_ADMINISTRATION_MUCOSAL => Locale::translate('proposal.drugInfo.administration.mucosal'),
                                ARTICLE_DRUG_INFO_ADMINISTRATION_TOPICAL => Locale::translate('proposal.drugInfo.administration.topical'),
                                ARTICLE_DRUG_INFO_ADMINISTRATION_INHALATION => Locale::translate('proposal.drugInfo.administration.inhalation')                            
			);
		}
		return $administrationMap;
	}

        /**
	 * Get a map for the pharmaceutical form constants to locale key.
	 * @return array
	 */
	function &getFormMap() {
		static $formMap;
		if (!isset($formMap)) {
			$formMap = array(
                                ARTICLE_DRUG_INFO_FORM_AEROSOLS => Locale::translate('proposal.drugInfo.form.aerosols'),
                                ARTICLE_DRUG_INFO_FORM_CAPSULES => Locale::translate('proposal.drugInfo.form.capsules'),
                                ARTICLE_DRUG_INFO_FORM_DPINHALEUR => Locale::translate('proposal.drugInfo.form.dpinhaleur'),
                                ARTICLE_DRUG_INFO_FORM_EMULSIONS => Locale::translate('proposal.drugInfo.form.emulsions'),
                                ARTICLE_DRUG_INFO_FORM_FOAMS => Locale::translate('proposal.drugInfo.form.foams'),
                                ARTICLE_DRUG_INFO_FORM_GASES => Locale::translate('proposal.drugInfo.form.gases'),
                                ARTICLE_DRUG_INFO_FORM_GELS => Locale::translate('proposal.drugInfo.form.gels'),
                                ARTICLE_DRUG_INFO_FORM_GRANULES => Locale::translate('proposal.drugInfo.form.granules'),
                                ARTICLE_DRUG_INFO_FORM_GUMS => Locale::translate('proposal.drugInfo.form.gums'),
                                ARTICLE_DRUG_INFO_FORM_IMPLANTS => Locale::translate('proposal.drugInfo.form.implants'),
                                ARTICLE_DRUG_INFO_FORM_INSERTS => Locale::translate('proposal.drugInfo.form.inserts'),
                                ARTICLE_DRUG_INFO_FORM_LIQUIDS => Locale::translate('proposal.drugInfo.form.liquids'),
                                ARTICLE_DRUG_INFO_FORM_LOZENGES => Locale::translate('proposal.drugInfo.form.lozenges'),
                                ARTICLE_DRUG_INFO_FORM_OINTMENT => Locale::translate('proposal.drugInfo.form.ointment'),
                                ARTICLE_DRUG_INFO_FORM_PASTES => Locale::translate('proposal.drugInfo.form.pastes'),
                                ARTICLE_DRUG_INFO_FORM_PATCHES => Locale::translate('proposal.drugInfo.form.patches'),
                                ARTICLE_DRUG_INFO_FORM_PELLETS => Locale::translate('proposal.drugInfo.form.pellets'),
                                ARTICLE_DRUG_INFO_FORM_PILLS => Locale::translate('proposal.drugInfo.form.pills'),
                                ARTICLE_DRUG_INFO_FORM_PLASTERS => Locale::translate('proposal.drugInfo.form.plasters'),
                                ARTICLE_DRUG_INFO_FORM_POWDERS => Locale::translate('proposal.drugInfo.form.powders'),
                                ARTICLE_DRUG_INFO_FORM_SOAPS => Locale::translate('proposal.drugInfo.form.soaps'),
                                ARTICLE_DRUG_INFO_FORM_SOLUTIONS => Locale::translate('proposal.drugInfo.form.solutions'),
                                ARTICLE_DRUG_INFO_FORM_SPRAYS => Locale::translate('proposal.drugInfo.form.sprays'),
                                ARTICLE_DRUG_INFO_FORM_SUPPOSITORIES => Locale::translate('proposal.drugInfo.form.suppositories'),
                                ARTICLE_DRUG_INFO_FORM_SUSPENSIONS => Locale::translate('proposal.drugInfo.form.suspensions'),
                                ARTICLE_DRUG_INFO_FORM_TABLET => Locale::translate('proposal.drugInfo.form.tablet'),
                                ARTICLE_DRUG_INFO_FORM_TAPES => Locale::translate('proposal.drugInfo.form.tapes')
			);
		}
		return $formMap;
	}
        /**
	 * Get a map for the storage conditions constants to locale key.
	 * @return array
	 */
	function &getStorageMap() {
		static $storageMap;
		if (!isset($storageMap)) {
			$storageMap = array(
                                ARTICLE_DRUG_INFO_STORAGE_FREEZER => Locale::translate('proposal.drugInfo.storage.freezer'),
                                ARTICLE_DRUG_INFO_STORAGE_COLD => Locale::translate('proposal.drugInfo.storage.cold'),
                                ARTICLE_DRUG_INFO_STORAGE_COOL => Locale::translate('proposal.drugInfo.storage.cool'),
                                ARTICLE_DRUG_INFO_STORAGE_CONTCOLD => Locale::translate('proposal.drugInfo.storage.contCold'),
                                ARTICLE_DRUG_INFO_STORAGE_ROOM => Locale::translate('proposal.drugInfo.storage.room'),
                                ARTICLE_DRUG_INFO_STORAGE_CONTROOM => Locale::translate('proposal.drugInfo.storage.contRoom'),
                                ARTICLE_DRUG_INFO_STORAGE_WARM => Locale::translate('proposal.drugInfo.storage.warm'),
                                ARTICLE_DRUG_INFO_STORAGE_HEAT => Locale::translate('proposal.drugInfo.storage.heat')
			);
		}
		return $storageMap;
	}
        /**
	 * Get a map for the class of drug study constants to locale key.
	 * @return array
	 */
	function &getClassMap() {
            static $classMap;
            if (!isset($classMap)) {
                $classMap = array(
                    ARTICLE_DRUG_INFO_CLASS_I => Locale::translate('proposal.drugInfo.class.I'),
                    ARTICLE_DRUG_INFO_CLASS_II => Locale::translate('proposal.drugInfo.class.II'),
                    ARTICLE_DRUG_INFO_CLASS_III => Locale::translate('proposal.drugInfo.class.III'),
                    ARTICLE_DRUG_INFO_CLASS_IV => Locale::translate('proposal.drugInfo.class.IV')                            
                );
            }
            return $classMap;
	}
        
        /**
	 * Get a map for the conditions of use in the CT constants to locale key.
	 * @return array
	 */
	function &getYesNoMap() {
            static $yesNoMap;
            if (!isset($yesNoMap)) {
                $yesNoMap = array(
                    ARTICLE_DRUG_INFO_YES => Locale::translate('common.yes'),
                    ARTICLE_DRUG_INFO_NO => Locale::translate('common.no')                            
                );
            }
            return $yesNoMap;
	}

        

        ////////////////////////////
        ////// Pharma Classes //////
        ////////////////////////////
        
        function getFilename($locale = null) {
		if ($locale === null) $locale = Locale::getLocale();
		return "locale/$locale/pharmaClasses.xml";
	}
	function &_getPharmaClassCache($locale = null) {
		$caches =& Registry::get('allPharmaClasses', true, array());
		if (!isset($locale)) $locale = Locale::getLocale();                
		if (!isset($caches[$locale])) {
			$cacheManager =& CacheManager::getManager();
			$caches[$locale] = $cacheManager->getFileCache(
				'PharmaClass', $locale,
				array(&$this, '_PharmaClassCacheMiss')
			);
			// Check to see if the data is outdated
			$cacheTime = $caches[$locale]->getCacheTime();
			if ($cacheTime !== null && $cacheTime < filemtime($this->getFilename())) {
				$caches[$locale]->flush();
			}
		}
		return $caches[$locale];
	}
	function _PharmaClassCacheMiss(&$cache, $id) {
		$pharmaClasses =& Registry::get('allPharmaClassesData', true, array());
                
		if (!isset($pharmaClasses[$id])) {
			// Reload pharma classes registry file
			$xmlDao = new XMLDAO();
			$data = $xmlDao->parseStruct($this->getFilename(), array('pharmaClasses', 'pharmaClass'));
                        if (isset($data['pharmaClasses'])) {
				foreach ($data['pharmaClass'] as $pharmaClassData) {
                                        if (strlen($pharmaClassData['attributes']['name']) > 60) {
                                            $name = substr($pharmaClassData['attributes']['name'], 0, 60).'...';
                                        } else {
                                            $name = $pharmaClassData['attributes']['name'];
                                        }
					$pharmaClasses[$id][$pharmaClassData['attributes']['code']] = $pharmaClassData['attributes']['code'].' '.$name;
				}
			}
			asort($pharmaClasses[$id]);
                        $cache->setEntireCache($pharmaClasses[$id]);
		}
		return null;
	}
	function &getPharmaClasses($locale = null) {
		$cache =& $this->_getPharmaClassCache($locale);
                return $cache->getContents();
	}
	function getPharmaClass($code, $locale = null) {
		$cache =& $this->_getPharmaClassCache($locale);
                $pharmaClasses = explode(",", $code);
                $pharmaClassesText = "";
                foreach($pharmaClasses as $i => $pharmaClass) {
                    $pharmaClassesText = $pharmaClassesText . $cache->get(trim($pharmaClass));
                    if($i < count($pharmaClasses)-1) $pharmaClassesText = $pharmaClassesText . ", ";
                }
		return $pharmaClassesText;
	}

}

?>
