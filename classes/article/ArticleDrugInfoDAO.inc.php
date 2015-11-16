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
