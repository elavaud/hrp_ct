<?php

/**
 * @file classes/author/form/submit/AuthorSubmitStep6Form.inc.php
 *
 * @class AuthorSubmitStep6Form
 * @ingroup author_form_submit
 *
 * @brief Form for Step 6 of author article submission.
 */

import('classes.author.form.submit.AuthorSubmitForm');

class AuthorSubmitStep6Form extends AuthorSubmitForm {

	/**
	 * Constructor.
	 */
	function AuthorSubmitStep6Form(&$article, &$journal) {
            parent::AuthorSubmitForm($article, 6, $journal);
		        
            $this->addCheck(new FormValidator($this, 'pqName', 'required', 'author.submit.form.pqName.required'));	
            $this->addCheck(new FormValidator($this, 'pqAffiliation', 'required', 'author.submit.form.pqAffiliation.required'));	
            $this->addCheck(new FormValidator($this, 'pqAddress', 'required', 'author.submit.form.pqAddress.required'));	
            $this->addCheck(new FormValidator($this, 'pqCountry', 'required', 'author.submit.form.pqCountry.required'));	
            $this->addCheck(new FormValidator($this, 'pqPhone', 'required', 'author.submit.form.pqPhone.required'));	
            $this->addCheck(new FormValidator($this, 'pqEmail', 'required', 'author.submit.form.pqEmail.required'));	
            $this->addCheck(new FormValidator($this, 'sqName', 'required', 'author.submit.form.sqName.required'));	
            $this->addCheck(new FormValidator($this, 'sqAffiliation', 'required', 'author.submit.form.sqAffiliation.required'));	
            $this->addCheck(new FormValidator($this, 'sqAddress', 'required', 'author.submit.form.sqAddress.required'));	
            $this->addCheck(new FormValidator($this, 'sqCountry', 'required', 'author.submit.form.sqCountry.required'));	
            $this->addCheck(new FormValidator($this, 'sqPhone', 'required', 'author.submit.form.sqPhone.required'));	
            $this->addCheck(new FormValidator($this, 'sqEmail', 'required', 'author.submit.form.sqEmail.required'));	
                
        }

	/**
	 * Initialize form data from current article.
	 */
	function initData() {
            $sectionDao =& DAORegistry::getDAO('SectionDAO');
            if (isset($this->article)) {
                $article =& $this->article;

                $articleContact = $article->getArticleContact();
                $this->_data = array(
                    'pqName' => $articleContact->getPQName(), 
                    'pqAffiliation' => $articleContact->getPQAffiliation(), 
                    'pqAddress' => $articleContact->getPQAddress(), 
                    'pqCountry' => $articleContact->getPQCountry(), 
                    'pqPhone' => $articleContact->getPQPhone(), 
                    'pqFax' => $articleContact->getPQFax(), 
                    'pqEmail' => $articleContact->getPQEmail(),
                    'sqName' => $articleContact->getSQName(), 
                    'sqAffiliation' => $articleContact->getSQAffiliation(), 
                    'sqAddress' => $articleContact->getSQAddress(), 
                    'sqCountry' => $articleContact->getSQCountry(), 
                    'sqPhone' => $articleContact->getSQPhone(), 
                    'sqFax' => $articleContact->getSQFax(), 
                    'sqEmail' => $articleContact->getSQEmail()
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
                    'pqName', 
                    'pqAffiliation', 
                    'pqAddress', 
                    'pqCountry', 
                    'pqPhone', 
                    'pqFax', 
                    'pqEmail',
                    'sqName', 
                    'sqAffiliation', 
                    'sqAddress', 
                    'sqCountry', 
                    'sqPhone', 
                    'sqFax', 
                    'sqEmail'
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
		$countryDao =& DAORegistry::getDAO('CountryDAO');
		$templateMgr =& TemplateManager::getManager();
                $templateMgr->assign('coutryList', $countryDao->getCountries());
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
                     
                $articleContact = new ArticleContact();
                $articleContact->setArticleId($article->getId());
                $articleContact->setPQName($this->getData('pqName'));
                $articleContact->setPQAffiliation($this->getData('pqAffiliation'));
                $articleContact->setPQAddress($this->getData('pqAddress'));
                $articleContact->setPQCountry($this->getData('pqCountry'));
                $articleContact->setPQPhone($this->getData('pqPhone'));
                $articleContact->setPQFax($this->getData('pqFax'));
                $articleContact->setPQEmail($this->getData('pqEmail'));
                $articleContact->setSQName($this->getData('sqName'));
                $articleContact->setSQAffiliation($this->getData('sqAffiliation'));
                $articleContact->setSQAddress($this->getData('sqAddress'));
                $articleContact->setSQCountry($this->getData('sqCountry'));
                $articleContact->setSQPhone($this->getData('sqPhone'));
                $articleContact->setSQFax($this->getData('sqFax'));
                $articleContact->setSQEmail($this->getData('sqEmail'));
                
                $article->setArticleContact($articleContact);
                
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
