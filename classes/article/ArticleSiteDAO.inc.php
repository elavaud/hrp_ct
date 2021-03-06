<?php

/**
 * @file classes/article/ArticleSiteDAO.inc.php
 *
 * @class ArticleSiteDAO
 *
 * @brief Operations for retrieving and modifying ArticleSite objects.
 */

import('classes.article.ArticleSite');

class ArticleSiteDAO extends DAO {

        var $investigatorDao;
    
        /**
	 * Constructor
	 */
	function ArticleSiteDAO() {
            parent::DAO();
            $this->investigatorDao =& DAORegistry::getDAO('AuthorDAO');   
	}
        
    	/**
	 * Get the article site object of a submission.
	 * @param $articleSiteId int
	 * @return ArticleSite object
	 */
	function &getArticleSiteById($articleSiteId) {

		$result =& $this->retrieve('SELECT * FROM article_site WHERE article_site_id = ?', (int) $articleSiteId);		

		$articleSite =& $this->_returnArticleSiteFromRow($result->GetRowAssoc(false));

		$result->Close();
		unset($result);

		return $articleSite;
	}

        /**
	 * Get all article site objects of a submission.
	 * @param $articleId int
	 * @return array ArticleSite
	 */
	function &getArticleSitesByArticleId($articleId) {
                $articleSites = array();
                
		$result =& $this->retrieve('SELECT * FROM article_site WHERE article_id = ?', (int) $articleId);		

		while (!$result->EOF) {
                    	$row =& $result->getRowAssoc(false);
			$articleSites[] =& $this->_returnArticleSiteFromRow($row);
			$result->moveNext();
		}
		$result->Close();
		unset($result);

		return $articleSites;
	}


	/**
	 * Insert a new ArticleSite object.
	 * @param $articleSite ArticleSite
	 */
	function insertArticleSite(&$articleSite) {
		$this->update(
			'INSERT INTO article_site 
				(article_id, site_id, approving_authority, approving_erc, primary_phone, secondary_phone, fax, email, subjects_number)
			VALUES
				(?, ?, ?, ?, ?, ?, ?, ?, ?)',
			array(
				(int) $articleSite->getArticleId(),
				(int) $articleSite->getSiteId(),
				(string) $articleSite->getAuthority(),
				(int) $articleSite->getERCId(),                            
				(string) $articleSite->getPrimaryPhone(),
				(string) $articleSite->getSecondaryPhone(),
				(string) $articleSite->getFax(),
				(string) $articleSite->getEmail(),
				(int) $articleSite->getSubjectsNumber()
			)
		);	
                
                $articleSite->setId($this->getInsertSiteId());
                
                // insert investigators for this site
		$investigators =& $articleSite->getInvestigators();
		foreach ($investigators as $investigator) {
                    $investigator->setSiteId($articleSite->getId());
                    $this->investigatorDao->insertAuthor($investigator);	
                }
                
		return $articleSite->getId();                
	}

	/**
	 * Update an existing ArticleSite.
	 * @param $articleSite ArticleSite
	 */
	function updateArticleSite(&$articleSite) {
		$returner = $this->update(
			'UPDATE article_site
			SET	
				article_id = ?,
				site_id = ?,
				approving_authority = ?,
				approving_erc = ?,                                
				primary_phone = ? ,
				secondary_phone = ? ,
				fax = ? ,
				email = ? ,
				subjects_number = ?  
			WHERE	article_site_id = ?',
			array(
				(int) $articleSite->getArticleId(),
				(int) $articleSite->getSiteId(),
				(string) $articleSite->getAuthority(),
				(int) $articleSite->getERCId(),                            
				(string) $articleSite->getPrimaryPhone(),
				(string) $articleSite->getSecondaryPhone(),
				(string) $articleSite->getFax(),
				(string) $articleSite->getEmail(),
				(int) $articleSite->getSubjectsNumber(),
                                (int) $articleSite->getId()
			)
		);
                
                // update investigators for this site
		$investigators =& $articleSite->getInvestigators();
		foreach ($investigators as $investigator) {
			if ($investigator->getId() > 0) {
                            $this->investigatorDao->updateAuthor($investigator);
			} else {
                            $investigator->setSiteId($articleSite->getId());
                            $this->investigatorDao->insertAuthor($investigator);
			}
                }
                // Remove deleted investigators
		$removedInvestigators = $articleSite->getRemovedInvestigators();
		foreach ($removedInvestigators as $removedInvestigatorId) {
			$this->investigatorDao->deleteAuthorById($removedInvestigatorId);
		}
                
		return $returner;
	}

	/**
	 * Delete a specific articleSite by ID
	 * @param $articleSiteId int
	 */
	function deleteArticleSite($articleSiteId) {
		
                $this->investigatorDao->deleteAuthorsBySite($articleSiteId);
                
		$returner = $this->update('DELETE FROM article_site WHERE article_site_id = ?',(int) $articleSiteId);
		
		return $returner;
	}

        /**
	 * Delete articleSites by article ID
	 * @param $articleId int
	 */
	function deleteArticleSitesByArticleId($articleId) {
		
                $this->investigatorDao->deleteAuthorsByArticle($articleId);
                
		$returner = $this->update('DELETE FROM article_site WHERE article_id = ?',(int) $articleId);
		
		return $returner;
	}
      
        
	/**
	 * Internal function to return an articleSite object from a row.
	 * @param $row array
	 * @return articleSite ArticleSite
	 */
	function &_returnArticleSiteFromRow(&$row) {
		$articleSite = new ArticleSite();
		$articleSite->setId($row['article_site_id']);
		$articleSite->setArticleId($row['article_id']);
                $articleSite->setSiteId($row['site_id']);
                $articleSite->setAuthority($row['approving_authority']);
                $articleSite->setERCId($row['approving_erc']);
                $articleSite->setPrimaryPhone($row['primary_phone']);
                $articleSite->setSecondaryPhone($row['secondary_phone']);
                $articleSite->setFax($row['fax']);
                $articleSite->setEmail($row['email']);
                $articleSite->setSubjectsNumber($row['subjects_number']);
                
                $articleSite->setInvestigators($this->investigatorDao->getAuthorsByArticleSite($row['article_site_id']));
                
		HookRegistry::call('ArticleSiteDAO::_returnArticleSiteFromRow', array(&$articleSite, &$row));

		return $articleSite;
	}
        
        
	/**
	 * Get the ID of the last inserted article site.
	 * @return int
	 */
	function getInsertSiteId() {
		return $this->getInsertId('article_site', 'article_site_id');
	}
}

?>
