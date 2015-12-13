<?php

/**
 * @defgroup article
 */

/**
 * @file classes/article/ArticleDrugInfo.inc.php
 *
 *
 * @brief ArticleDrugInfo class.
 */

// For integers
define ('ARTICLE_DRUG_INFO_NOT_PROVIDED', 0);

define ('ARTICLE_DRUG_INFO_TYPE_STUDY_DRUG', 1);
define ('ARTICLE_DRUG_INFO_TYPE_CONCOMITANT', 2);
define ('ARTICLE_DRUG_INFO_TYPE_COMPARATOR', 3);
define ('ARTICLE_DRUG_INFO_TYPE_PLACEBO', 4);

define ('ARTICLE_DRUG_INFO_ADMINISTRATION_GASTRO', 1);
define ('ARTICLE_DRUG_INFO_ADMINISTRATION_INJECTION', 2);
define ('ARTICLE_DRUG_INFO_ADMINISTRATION_MUCOSAL', 3);
define ('ARTICLE_DRUG_INFO_ADMINISTRATION_TOPICAL', 4);
define ('ARTICLE_DRUG_INFO_ADMINISTRATION_INHALATION', 5);

define ('ARTICLE_DRUG_INFO_FORM_AEROSOLS', 1);
define ('ARTICLE_DRUG_INFO_FORM_CAPSULES', 2);
define ('ARTICLE_DRUG_INFO_FORM_DPINHALEUR', 3);
define ('ARTICLE_DRUG_INFO_FORM_EMULSIONS', 4);
define ('ARTICLE_DRUG_INFO_FORM_FOAMS', 5);
define ('ARTICLE_DRUG_INFO_FORM_GASES', 6);
define ('ARTICLE_DRUG_INFO_FORM_GELS', 7);
define ('ARTICLE_DRUG_INFO_FORM_GRANULES', 8);
define ('ARTICLE_DRUG_INFO_FORM_GUMS', 9);
define ('ARTICLE_DRUG_INFO_FORM_IMPLANTS', 10);
define ('ARTICLE_DRUG_INFO_FORM_INSERTS', 11);
define ('ARTICLE_DRUG_INFO_FORM_LIQUIDS', 12);
define ('ARTICLE_DRUG_INFO_FORM_LOZENGES', 13);
define ('ARTICLE_DRUG_INFO_FORM_OINTMENT', 14);
define ('ARTICLE_DRUG_INFO_FORM_PASTES', 15);
define ('ARTICLE_DRUG_INFO_FORM_PATCHES', 16);
define ('ARTICLE_DRUG_INFO_FORM_PELLETS', 17);
define ('ARTICLE_DRUG_INFO_FORM_PILLS', 18);
define ('ARTICLE_DRUG_INFO_FORM_PLASTERS', 19);
define ('ARTICLE_DRUG_INFO_FORM_POWDERS', 20);
define ('ARTICLE_DRUG_INFO_FORM_SOAPS', 21);
define ('ARTICLE_DRUG_INFO_FORM_SOLUTIONS', 22);
define ('ARTICLE_DRUG_INFO_FORM_SPRAYS', 23);
define ('ARTICLE_DRUG_INFO_FORM_SUPPOSITORIES', 24);
define ('ARTICLE_DRUG_INFO_FORM_SUSPENSIONS', 25);
define ('ARTICLE_DRUG_INFO_FORM_TABLET', 26);
define ('ARTICLE_DRUG_INFO_FORM_TAPES', 27);

define ('ARTICLE_DRUG_INFO_STORAGE_FREEZER', 1);
define ('ARTICLE_DRUG_INFO_STORAGE_COLD', 2);
define ('ARTICLE_DRUG_INFO_STORAGE_COOL', 3);
define ('ARTICLE_DRUG_INFO_STORAGE_CONTCOLD', 4);
define ('ARTICLE_DRUG_INFO_STORAGE_ROOM', 5);
define ('ARTICLE_DRUG_INFO_STORAGE_CONTROOM', 6);
define ('ARTICLE_DRUG_INFO_STORAGE_WARM', 7);
define ('ARTICLE_DRUG_INFO_STORAGE_HEAT', 8);

define ('ARTICLE_DRUG_INFO_CLASS_I', 1);
define ('ARTICLE_DRUG_INFO_CLASS_II', 2);
define ('ARTICLE_DRUG_INFO_CLASS_III', 3);
define ('ARTICLE_DRUG_INFO_CLASS_IV', 4);

define ('ARTICLE_DRUG_INFO_YES', 1);
define ('ARTICLE_DRUG_INFO_NO', 2);


class ArticleDrugInfo extends DataObject {
	
        var $drugManufacturers;
        
        var $removedDrugManufacturers;

        /**
	 * Constructor.
	 */
	function ArticleDrugInfo() {
            parent::DataObject();
            $this->drugManufacturers = array();
            $this->removedDrugManufacturers = array();	
	}

	
        /**
	 * Get article id.
	 * @return int
	 */
	function getArticleId() {
		return $this->getData('articleId');
	}
	/**
	 * Set article id.
	 * @param $articleId int
	 */
	function setArticleId($articleId) {
		return $this->setData('articleId', $articleId);
	}
        
        
        /**
	 * Get type of the drug.
	 * @return int
	 */
	function getType() {
		return $this->getData('type');
	}
	/**
	 * Set type of the drug.
	 * @param $type int
	 */
	function setType($type) {
		return $this->setData('type', $type);
	}
        /**
	 * Get a map for the type constants to locale key.
	 * @return array
	 */
	function &getTypeMap() {
		static $typeMap;
		if (!isset($typeMap)) {
			$typeMap = array(
                                ARTICLE_DRUG_INFO_NOT_PROVIDED => 'common.dataNotProvided',
				ARTICLE_DRUG_INFO_TYPE_STUDY_DRUG => 'proposal.drugInfo.type.studyDrug',
				ARTICLE_DRUG_INFO_TYPE_CONCOMITANT => 'proposal.drugInfo.type.concomitant',
				ARTICLE_DRUG_INFO_TYPE_COMPARATOR => 'proposal.drugInfo.type.comparator',
				ARTICLE_DRUG_INFO_TYPE_PLACEBO => 'proposal.drugInfo.type.placebo'
			);
		}
		return $typeMap;
	}
	/**
	 * Get a locale key for the type
	 */
	function getTypeKey() {
                $type = $this->getType();
		$typeMap =& $this->getTypeMap();
		return $typeMap[$type];
	}

        
        /**
	 * Get name of the Drug.
	 * @return string
	 */
	function getName() {
		return $this->getData('name');
	}
	/**
	 * Set name of the Drug.
	 * @param $name string
	 */
	function setName($name) {
		return $this->setData('name', $name);
	}
        
        
        /**
	 * Get brand name of the Drug.
	 * @return string
	 */
	function getBrandName() {
		return $this->getData('brandName');
	}
	/**
	 * Set brand name of the Drug.
	 * @param $brandName string
	 */
	function setBrandName($brandName) {
		return $this->setData('brandName', $brandName);
	}
        
        
        /**
	 * Get route of administration of the Drug.
	 * @return int
	 */
	function getAdministration() {
		return $this->getData('administration');
	}
	/**
	 * Set route of administration of the Drug.
	 * @param $administration int
	 */
	function setAdministration($administration) {
		return $this->setData('administration', $administration);
	}
        /**
	 * Get a map for the administration constants to locale key.
	 * @return array
	 */
	function &getAdministrationMap() {
		static $administrationMap;
		if (!isset($administrationMap)) {
			$administrationMap = array(
                                ARTICLE_DRUG_INFO_NOT_PROVIDED => 'common.dataNotProvided',
                                ARTICLE_DRUG_INFO_ADMINISTRATION_GASTRO => 'proposal.drugInfo.administration.gastro',
                                ARTICLE_DRUG_INFO_ADMINISTRATION_INJECTION => 'proposal.drugInfo.administration.injection',
                                ARTICLE_DRUG_INFO_ADMINISTRATION_MUCOSAL => 'proposal.drugInfo.administration.mucosal',
                                ARTICLE_DRUG_INFO_ADMINISTRATION_TOPICAL => 'proposal.drugInfo.administration.topical',
                                ARTICLE_DRUG_INFO_ADMINISTRATION_INHALATION => 'proposal.drugInfo.administration.inhalation'                            
			);
		}
		return $administrationMap;
	}
	/**
	 * Get a locale key for the administration
	 */
	function getAdministrationKey() {
                $administration = $this->getAdministration();
		$administrationMap =& $this->getAdministrationMap();
		return $administrationMap[$administration];
	}

        
        /**
	 * Get other route of administration of the Drug.
	 * @return string
	 */
	function getOtherAdministration() {
		return $this->getData('otherAdministration');
	}
	/**
	 * Set other route of administration of the Drug.
	 * @param $otherAdministration string
	 */
	function setOtherAdministration($otherAdministration) {
		return $this->setData('otherAdministration', $otherAdministration);
	}
        
        
        
        /**
	 * Get pharmaceutical form of the drug.
	 * @return int
	 */
	function getForm() {
		return $this->getData('form');
	}
	/**
	 * Set pharmaceutical form of the Drug.
	 * @param $form int
	 */
	function setForm($form) {
		return $this->setData('form', $form);
	}
        /**
	 * Get a map for the pharmaceutical form constants to locale key.
	 * @return array
	 */
	function &getFormMap() {
		static $formMap;
		if (!isset($formMap)) {
			$formMap = array(
                                ARTICLE_DRUG_INFO_NOT_PROVIDED => 'common.dataNotProvided',
                                ARTICLE_DRUG_INFO_FORM_AEROSOLS => 'proposal.drugInfo.form.aerosols',
                                ARTICLE_DRUG_INFO_FORM_CAPSULES => 'proposal.drugInfo.form.capsules',
                                ARTICLE_DRUG_INFO_FORM_DPINHALEUR => 'proposal.drugInfo.form.dpinhaleur',
                                ARTICLE_DRUG_INFO_FORM_EMULSIONS => 'proposal.drugInfo.form.emulsions',
                                ARTICLE_DRUG_INFO_FORM_FOAMS => 'proposal.drugInfo.form.foams',
                                ARTICLE_DRUG_INFO_FORM_GASES => 'proposal.drugInfo.form.gases',
                                ARTICLE_DRUG_INFO_FORM_GELS => 'proposal.drugInfo.form.gels',
                                ARTICLE_DRUG_INFO_FORM_GRANULES => 'proposal.drugInfo.form.granules',
                                ARTICLE_DRUG_INFO_FORM_GUMS => 'proposal.drugInfo.form.gums',
                                ARTICLE_DRUG_INFO_FORM_IMPLANTS => 'proposal.drugInfo.form.implants',
                                ARTICLE_DRUG_INFO_FORM_INSERTS => 'proposal.drugInfo.form.inserts',
                                ARTICLE_DRUG_INFO_FORM_LIQUIDS => 'proposal.drugInfo.form.liquids',
                                ARTICLE_DRUG_INFO_FORM_LOZENGES => 'proposal.drugInfo.form.lozenges',
                                ARTICLE_DRUG_INFO_FORM_OINTMENT => 'proposal.drugInfo.form.ointment',
                                ARTICLE_DRUG_INFO_FORM_PASTES => 'proposal.drugInfo.form.pastes',
                                ARTICLE_DRUG_INFO_FORM_PATCHES => 'proposal.drugInfo.form.patches',
                                ARTICLE_DRUG_INFO_FORM_PELLETS => 'proposal.drugInfo.form.pellets',
                                ARTICLE_DRUG_INFO_FORM_PILLS => 'proposal.drugInfo.form.pills',
                                ARTICLE_DRUG_INFO_FORM_PLASTERS => 'proposal.drugInfo.form.plasters',
                                ARTICLE_DRUG_INFO_FORM_POWDERS => 'proposal.drugInfo.form.powders',
                                ARTICLE_DRUG_INFO_FORM_SOAPS => 'proposal.drugInfo.form.soaps',
                                ARTICLE_DRUG_INFO_FORM_SOLUTIONS => 'proposal.drugInfo.form.solutions',
                                ARTICLE_DRUG_INFO_FORM_SPRAYS => 'proposal.drugInfo.form.sprays',
                                ARTICLE_DRUG_INFO_FORM_SUPPOSITORIES => 'proposal.drugInfo.form.suppositories',
                                ARTICLE_DRUG_INFO_FORM_SUSPENSIONS => 'proposal.drugInfo.form.suspensions',
                                ARTICLE_DRUG_INFO_FORM_TABLET => 'proposal.drugInfo.form.tablet',
                                ARTICLE_DRUG_INFO_FORM_TAPES => 'proposal.drugInfo.form.tapes'
			);
		}
		return $formMap;
	}
	/**
	 * Get a locale key for the pharmaceutical form
	 */
	function getFormKey() {
                $form = $this->getForm();
		$formMap =& $this->getFormMap();
		return $formMap[$form];
	}

        
        /**
	 * Get other pharmaceutical form of the Drug.
	 * @return string
	 */
	function getOtherForm() {
		return $this->getData('otherForm');
	}
	/**
	 * Set other pharmaceutical form of the Drug.
	 * @param $otherForm string
	 */
	function setOtherForm($otherForm) {
		return $this->setData('otherForm', $otherForm);
	}
        
        
        /**
	 * Get strength of the Drug.
	 * @return string
	 */
	function getStrength() {
		return $this->getData('strength');
	}
	/**
	 * Set strength of the Drug.
	 * @param $strength string
	 */
	function setStrength($strength) {
		return $this->setData('strength', $strength);
	}

        
        /**
	 * Get storage condition of the drug.
	 * @return int
	 */
	function getStorage() {
		return $this->getData('storage');
	}
	/**
	 * Set storage condition of the Drug.
	 * @param $storage int
	 */
	function setStorage($storage) {
		return $this->setData('storage', $storage);
	}
        /**
	 * Get a map for the storage conditions constants to locale key.
	 * @return array
	 */
	function &getStorageMap() {
		static $storageMap;
		if (!isset($storageMap)) {
			$storageMap = array(
                                ARTICLE_DRUG_INFO_NOT_PROVIDED => 'common.dataNotProvided',
                                ARTICLE_DRUG_INFO_STORAGE_FREEZER => 'proposal.drugInfo.storage.freezer',
                                ARTICLE_DRUG_INFO_STORAGE_COLD => 'proposal.drugInfo.storage.cold',
                                ARTICLE_DRUG_INFO_STORAGE_COOL => 'proposal.drugInfo.storage.cool',
                                ARTICLE_DRUG_INFO_STORAGE_CONTCOLD => 'proposal.drugInfo.storage.contCold',
                                ARTICLE_DRUG_INFO_STORAGE_ROOM => 'proposal.drugInfo.storage.room',
                                ARTICLE_DRUG_INFO_STORAGE_CONTROOM => 'proposal.drugInfo.storage.contRoom',
                                ARTICLE_DRUG_INFO_STORAGE_WARM => 'proposal.drugInfo.storage.warm',
                                ARTICLE_DRUG_INFO_STORAGE_HEAT => 'proposal.drugInfo.storage.heat'
			);
		}
		return $storageMap;
	}
	/**
	 * Get a locale key for the storage condition
	 */
	function getStorageKey() {
                $storage = $this->getStorage();
		$storageMap =& $this->getStorageMap();
		return $storageMap[$storage];
	}    
        
        
        /**
	 * Get pharmaceutical class of the Drug.
	 * @return string
	 */
	function getPharmaClass() {
		return $this->getData('pharmaClass');
	}        
	/**
	 * Set pharmaceutical class of the Drug.
	 * @param $pharmaClass string
	 */
	function setPharmaClass($pharmaClass) {
		return $this->setData('pharmaClass', $pharmaClass);
	}
        
        
        /**
	 * Get class of Drug study.
	 * @return string
	 */
	function getClasses() {
		return $this->getData('classes');
	}   
        /**
	 * Get study drug' classes in an array.
	 * @return array
	 */
	function getClassesArray() {
                $classes = $this->getClasses();
                return explode("+", $classes);
        }        
	/**
	 * Set class of drug study.
	 * @param $classes string
	 */
	function setClasses($classes) {
		return $this->setData('classes', $classes);
	}
        /**
	 * Set study classes from an array.
	 * @param $classes array
	 */
	function setClassesFromArray($classes) {
                return $this->setClasses(implode("+", $classes));
	}        
        /**
	 * Get a map for the class of drug study constants to locale key.
	 * @return array
	 */
	function &getClassMap() {
		static $classMap;
		if (!isset($classMap)) {
			$classMap = array(
                                ARTICLE_DRUG_INFO_NOT_PROVIDED => 'common.dataNotProvided',
                                ARTICLE_DRUG_INFO_CLASS_I => 'proposal.drugInfo.class.I',
                                ARTICLE_DRUG_INFO_CLASS_II => 'proposal.drugInfo.class.II',
                                ARTICLE_DRUG_INFO_CLASS_III => 'proposal.drugInfo.class.III',
                                ARTICLE_DRUG_INFO_CLASS_IV => 'proposal.drugInfo.class.IV'                            
			);
		}
		return $classMap;
	}
       	/**
	 * Get a locale key for the class of drug study
	 */
	function getClassKey() {
                $class = $this->getClass();
		$classMap =& $this->getClassMap();
		return $classMap[$class];
	}
        
        
        /**
	 * Get countries in which the drug has been granting marketing authorization.
	 * @return string
	 */
	function getCountries() {
		return $this->getData('countries');
	}   
        /**
	 * Get countries in which the drug has been granting marketing authorization in an array.
	 * @return array
	 */
	function getCountriesArray() {
                $countries = $this->getCountries();
                return explode("+", $countries);
        }        
	/**
	 * Set countries in which the drug has been granting marketing authorization.
	 * @param $countries string
	 */
	function setCountries($countries) {
		return $this->setData('countries', $countries);
	}
        /**
	 * Set countries in which the drug has been granting marketing authorization from an array.
	 * @param $classes array
	 */
	function setCountriesFromArray($countries) {
                return $this->setCountries(implode("+", $countries));
	}        
        
        
        /**
	 * Get if the conditions of use in the CT differ from those authorized.
	 * @return int
	 */
	function getDifferentConditionsOfUse() {
		return $this->getData('differentConditionsOfUse');
	}        
	/**
	 * Set if the conditions of use in the CT differ from those authorized.
	 * @param $differentConditionsOfUse int
	 */
	function setDifferentConditionsOfUse($differentConditionsOfUse) {
		return $this->setData('differentConditionsOfUse', $differentConditionsOfUse);
	}
        /**
	 * Get a map for the conditions of use in the CT constants to locale key.
	 * @return array
	 */
	function &getYesNoMap() {
		static $yesNoMap;
		if (!isset($yesNoMap)) {
			$yesNoMap = array(
                                ARTICLE_DRUG_INFO_NOT_PROVIDED => 'common.dataNotProvided',
                                ARTICLE_DRUG_INFO_YES => 'common.yes',
                                ARTICLE_DRUG_INFO_NO => 'common.no'                            
			);
		}
		return $yesNoMap;
	}
       	/**
	 * Get a locale key for the conditions of use in the CT
	 */
	function getDifferentConditionsOfUseKey() {
                $differentConditionsOfUse = $this->getDifferentConditionsOfUse();
		$yesNoMap =& $this->getYesNoMap();
		return $yesNoMap[$differentConditionsOfUse];
	}
        
        
        /**
	 * Get if the if the drug has been granted CPR.
	 * @return int
	 */
	function getCPR() {
		return $this->getData('cpr');
	}        
	/**
	 * Set if the drug has been granted CPR.
	 * @param $cpr int
	 */
	function setCPR($cpr) {
		return $this->setData('cpr', $cpr);
	}
       	/**
	 * Get a locale key for the CPR
	 */
	function getCPRKey() {
                $cpr = $this->getCPR();
		$yesNoMap =& $this->getYesNoMap();
		return $yesNoMap[$cpr];
	}
        
        
        /**
	 * Get drug registration number.
	 * @return string
	 */
	function getDrugRegistrationNumber() {
		return $this->getData('drugRegistrationNumber');
	}        
	/**
	 * Set drug registration number.
	 * @param $drugRegistrationNumber string
	 */
	function setDrugRegistrationNumber($drugRegistrationNumber) {
		return $this->setData('drugRegistrationNumber', $drugRegistrationNumber);
	}
        
        
        /**
	 * Get imported quantity.
	 * @return string
	 */
	function getImportedQuantity() {
		return $this->getData('importedQuantity');
	}        
	/**
	 * Set imported quantity.
	 * @param $importedQuantity string
	 */
	function setImportedQuantity($importedQuantity) {
		return $this->setData('importedQuantity', $importedQuantity);
	}
        
        /**
	 * Add a drug manufacturer.
	 * @param $manufacturer ArticleDrugManufacturer
	 */
	function addManufacturer($manufacturer) {
                $found = false;
                $i = 0;
                $manufacturers = $this->drugManufacturers;
                foreach ($this->drugManufacturers as $dmKey => $dmValue) {
                    if ($manufacturer->getId() != null && $manufacturer->getId() == $dmValue->getId()){
                        $manufacturers[$dmKey] = $manufacturer;
                        $found = true;
                    }
                    $i++;
                }
                if (!$found) {
                    $manufacturers[$i] = $manufacturer;
                }
                $this->drugManufacturers = $manufacturers;
	}
        /**
	 * Remove a drug manufacturer.
	 * @param $manufacturerId ID of the drug manufacturer to remove
	 * @return boolean drug manufacturer ID was removed
	 */
	function removeManufacturer($manufacturerId) {
                $found = false;
                $i = 0;
		if ($manufacturerId != 0) {
                    $manufacturers = $this->drugManufacturers;
                    foreach ($this->drugManufacturers as $drugManufacturer) {
                        if ($drugManufacturer->getId() == $manufacturerId) {
                            array_push($this->removedDrugManufacturers, $manufacturerId);
                            $found = true;
                        }
                        else {
                            $manufacturers[$i] = $drugManufacturer;
                            $i++;
                        }       
                    }
                    $this->drugManufacturers = $manufacturers;
		}
		return $found;
	}
	/**
	 * Get all manufacturers for this drug.
	 * @return array ArticleDrugManufacturer
	 */
	function &getManufacturers() {
		return $this->drugManufacturers;
	}
        /**
	 * Get manufacturer by ID for this drug.
	 * @return object ArticleDrugManufacturer
	 */
	function &getManufacturer($id) {
                foreach ($this->drugManufacturers as $drugManufacturer) {
                    if ($drugManufacturer->getId() == $id) {
                        return $drugManufacturer;
                    }
                }
		return null;
	}
        /**
	 * Get the IDs of all manufacturers removed from this drug.
	 * @return array int
	 */
	function &getRemovedManufacturers() {
		return $this->removedDrugManufacturers;
	}
        /**
	 * Set drug manufacturers fir this drug.
	 * @param $manufacturers array ArticleDrugManufacturer
	 */
	function setManufacturers($manufacturers) {
		return $this->drugManufacturers = $manufacturers;
	}
        
        
        /**
	 * Get all the Investigator's Brochure files for this drug.
	 * @return array int
	 */
	function &getIBs() {
            $suppFileDao =& DAORegistry::getDAO('SuppFileDAO');
            return $suppFileDao->getSuppFilesByArticleTypeAndAssocId($this->getArticleId(), SUPP_FILE_BROCHURE, $this->getId());
	}
        /**
	 * Get all the SmPC files for this drug.
	 * @return array int
	 */
	function &getSmPCs() {
            $suppFileDao =& DAORegistry::getDAO('SuppFileDAO');
            return $suppFileDao->getSuppFilesByArticleTypeAndAssocId($this->getArticleId(), SUPP_FILE_SMPC, $this->getId());
	}
}
?>
