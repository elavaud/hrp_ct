<?php

/**
 * @file classes/article/ArticleDAO.inc.php
 *
 * Copyright (c) 2003-2011 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class ArticleDAO
 * @ingroup article
 * @see Article
 *
 * @brief Operations for retrieving and modifying Article objects.
 */

import('classes.article.Article');
import('classes.article.SectionDecision');
import('classes.submission.common.Action');

class ArticleDAO extends DAO {
        var $cache;
        
	var $articleTextDao;

        var $articleSecIdDao;

	var $articleDetailsDao;

        var $articlePurposeDao;

        var $articleOutcomeDao;
        
        var $articleDrugInfoDao;

        var $articleSiteDao;

        var $articleSponsorDao;

        var $articleCRODao;
        
	var $articleContactDao;
        
	function _cacheMiss(&$cache, $id) {
		$article =& $this->getArticle($id, null, false);
		$cache->setCache($id, $article);
		return $article;
	}

	function &_getCache() {
		if (!isset($this->cache)) {
			$cacheManager =& CacheManager::getManager();
			$this->cache =& $cacheManager->getObjectCache('articles', 0, array(&$this, '_cacheMiss'));
		}
		return $this->cache;
	}

	/**
	 * Constructor.
	 */
	function ArticleDAO() {
		parent::DAO();
		$this->articleTextDao =& DAORegistry::getDAO('ArticleTextDAO');   
		$this->articleSecIdDao =& DAORegistry::getDAO('ArticleSecIdDAO');   
                $this->articleDetailsDao =& DAORegistry::getDAO('ArticleDetailsDAO');   
                $this->articlePurposeDao =& DAORegistry::getDAO('ArticlePurposeDAO'); 
                $this->articleOutcomeDao =& DAORegistry::getDAO('ArticleOutcomeDAO'); 
		$this->articleDrugInfoDao =& DAORegistry::getDAO('ArticleDrugInfoDAO');   
		$this->articleSiteDao =& DAORegistry::getDAO('ArticleSiteDAO');   
		$this->articleSponsorDao =& DAORegistry::getDAO('ArticleSponsorDAO');  
		$this->articleCRODao =& DAORegistry::getDAO('ArticleCRODAO');     
                $this->articleContactDao =& DAORegistry::getDAO('ArticleContactDAO');   
        }

	/**
	 * Get a list of field names for which data is localized.
	 * @return array
	 */
	function getLocaleFieldNames() {
		return array(
                    'withdrawReason', 
                    'withdrawComments' 
               );
	}

	/**
	 * Update the settings for this object
	 * @param $article object
	 */
	function updateLocaleFields(&$article) {
		$this->updateDataObjectSettings('article_settings', $article, array(
			'article_id' => $article->getId()
		));
	}

	/**
	 * Retrieve an article by ID.
	 * @param $articleId int
	 * @param $journalId int optional
	 * @param $useCache boolean optional
	 * @return Article
	 */
	function &getArticle($articleId, $journalId = null, $useCache = false) {
		if ($useCache) {
			$cache =& $this->_getCache();
			$returner = $cache->get($articleId);
			if ($returner && $journalId != null && $journalId != $returner->getJournalId()) $returner = null;
			return $returner;
		}

		$primaryLocale = Locale::getPrimaryLocale();
		$locale = Locale::getLocale();
		$params = array(
			'title',
                        $primaryLocale,
			'title',
                        $locale,
			'abbrev',
                        $primaryLocale,
			'abbrev',
                        $locale,
                        $articleId
		);
                
		$sql = 'SELECT	a.*,
				COALESCE(stl.setting_value, stpl.setting_value) AS section_title,
				COALESCE(sal.setting_value, sapl.setting_value) AS section_abbrev
			FROM	articles a
				LEFT JOIN section_decisions sdec ON (a.article_id = sdec.article_id)
                                LEFT JOIN section_decisions sdec2 ON (a.article_id = sdec2.article_id AND sdec.section_decision_id < sdec2.section_decision_id)
				LEFT JOIN section_settings stpl ON (sdec.section_id = stpl.section_id AND stpl.setting_name = ? AND stpl.locale = ?)
				LEFT JOIN section_settings stl ON (sdec.section_id = stl.section_id AND stl.setting_name = ? AND stl.locale = ?)
				LEFT JOIN section_settings sapl ON (sdec.section_id = sapl.section_id AND sapl.setting_name = ? AND sapl.locale = ?)
				LEFT JOIN section_settings sal ON (sdec.section_id = sal.section_id AND sal.setting_name = ? AND sal.locale = ?)
			WHERE	a.article_id = ? AND sdec2.section_decision_id IS NULL';
		if ($journalId !== null) {
			$sql .= ' AND a.journal_id = ?';
			$params[] = $journalId;
		}

		$result =& $this->retrieve($sql, $params);

		$returner = null;
		if ($result->RecordCount() != 0) {
			$returner =& $this->_returnArticleFromRow($result->GetRowAssoc(false), true);
		}

		$result->Close();
		unset($result);

		return $returner;
	}

	/**
	 * Internal function to return an Article object from a row.
	 * @param $row array
	 * @return Article
	 */
	function &_returnArticleFromRow(&$row, $single = false) {
		$article = new Article();
		$this->_articleFromRow($article, $row, $single);
		return $article;
	}

	/**
	 * Internal function to fill in the passed article object from the row.
	 * @param $article Article output article
	 * @param $row array input row
	 * @param $single bool true if a single article to return (do not overuse database queries)
	 */
	function _articleFromRow(&$article, &$row, $single = false) {
		
		if (isset($row['article_id'])) $article->setId($row['article_id']);
		if (isset($row['public_id'])) $article->setProposalId($row['public_id']);
                if (isset($row['user_id'])) $article->setUserId($row['user_id']);
		if (isset($row['journal_id'])) $article->setJournalId($row['journal_id']);
		if (isset($row['section_title'])) $article->setSectionTitle($row['section_title']);
		if (isset($row['section_abbrev'])) $article->setSectionAbbrev($row['section_abbrev']);
		if (isset($row['doi'])) $article->setStoredDOI($row['doi']);
		if (isset($row['language'])) $article->setLanguage($row['language']);
		if (isset($row['comments_to_ed'])) $article->setCommentsToEditor($row['comments_to_ed']);
		if (isset($row['citations'])) $article->setCitations($row['citations']);
		if (isset($row['date_submitted'])) $article->setDateSubmitted($this->datetimeFromDB($row['date_submitted']));
		if (isset($row['date_status_modified'])) $article->setDateStatusModified($this->datetimeFromDB($row['date_status_modified']));
		if (isset($row['last_modified'])) $article->setLastModified($this->datetimeFromDB($row['last_modified']));
		if (isset($row['status'])) $article->setStatus($row['status']);
		if (isset($row['submission_progress'])) $article->setSubmissionProgress($row['submission_progress']);
		if (isset($row['submission_file_id'])) $article->setSubmissionFileId($row['submission_file_id']);
		if (isset($row['revised_file_id'])) $article->setRevisedFileId($row['revised_file_id']);
		if (isset($row['review_file_id'])) $article->setReviewFileId($row['review_file_id']);
		if (isset($row['editor_file_id'])) $article->setEditorFileId($row['editor_file_id']);
		if (isset($row['pages'])) $article->setPages($row['pages']);
		if (isset($row['fast_tracked'])) $article->setFastTracked($row['fast_tracked']);
		if (isset($row['hide_author'])) $article->setHideAuthor($row['hide_author']);
		if (isset($row['comments_status'])) $article->setCommentsStatus($row['comments_status']);
		if (isset($row['scientifictitle'])) $article->setScientificTitle($row['scientifictitle']);
                
                if ($single) {
                    $article = $this->_returnSingleArticleFromRow($article);
                }
                
                $articleFileDao =& DAORegistry::getDAO('ArticleFileDAO');
                $publicFiles = $articleFileDao->getArticleFilesByType($row['article_id'], 'PublicFile');
                if ($publicFiles) {
                    $article->setPublishedFinalReport($publicFiles[0]); // FIX ME: Only one file in folder 'public' -> alwas the final report: Pretty ugly
                }
                $sectionDecisionDao =& DAORegistry::getDAO('SectionDecisionDAO');
		$article->setProposalStatus($sectionDecisionDao->getProposalStatus($article->getId()));

		$this->getDataObjectSettings('article_settings', 'article_id', $row['article_id'], $article);
		
		HookRegistry::call('ArticleDAO::_returnArticleFromRow', array(&$article, &$row, $single));

	}
        
	/**
	 * Internal function to complete the filling of a passed article object from a row (in case of a single article).
	 * @param $article Article output article
	 */
        function _returnSingleArticleFromRow($article){
            $articleId = $article->getId();
            if ($articleId){
		$article->setArticleTexts($this->articleTextDao->getArticleTextsByArticleId($articleId));

                $article->setArticleSecIds($this->articleSecIdDao->getArticleSecIdsByArticleId($articleId));

		$article->setArticleDetails($this->articleDetailsDao->getArticleDetailsByArticleId($articleId));

                $article->setArticlePurposes($this->articlePurposeDao->getArticlePurposesByArticleId($articleId));

                $article->setArticleOutcomes($this->articleOutcomeDao->getArticleOutcomesByArticleId($articleId));

                $article->setArticleDrugs($this->articleDrugInfoDao->getArticleDrugInfosByArticleId($articleId));

                $article->setArticleSites($this->articleSiteDao->getArticleSitesByArticleId($articleId));
                
                $article->setArticleFundingSources($this->articleSponsorDao->getArticleSponsorsByArticleId($articleId, ARTICLE_SPONSOR_TYPE_FUNDING));

                $article->setArticlePrimarySponsor($this->articleSponsorDao->getArticleSponsorsByArticleId($articleId, ARTICLE_SPONSOR_TYPE_PRIMARY, true));
                
                $article->setArticleSecondarySponsors($this->articleSponsorDao->getArticleSponsorsByArticleId($articleId, ARTICLE_SPONSOR_TYPE_SECONDARY));
                
                $article->setArticleCROs($this->articleCRODao->getArticleCROsByArticleId($articleId));
                
		$article->setArticleContact($this->articleContactDao->getArticleContactByArticleId($articleId));                
            }
            return $article;
        }
        
        
	/**
	 * Insert a new Article.
	 * @param $article Article
	 */
	function insertArticle(&$article) {
		$article->stampModified();
		$this->update(
		sprintf('INSERT INTO articles
				(public_id, locale, user_id, journal_id, language, comments_to_ed, citations, date_submitted, date_status_modified, last_modified, status, submission_progress, submission_file_id, revised_file_id, review_file_id, editor_file_id, pages, fast_tracked, hide_author, comments_status, doi)
				VALUES
				(?, ?, ?, ?, ?, ?, ?, %s, %s, %s, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
		$this->datetimeToDB($article->getDateSubmitted()), $this->datetimeToDB($article->getDateStatusModified()), $this->datetimeToDB($article->getLastModified())),
		array(
                        $article->getProposalId(),
			$article->getLocale(),
			$article->getUserId(),
			$article->getJournalId(),
			$article->getLanguage(),
			$article->getCommentsToEditor(),
			$article->getCitations(),
			$article->getStatus() === null ? STATUS_QUEUED : $article->getStatus(),
			$article->getSubmissionProgress() === null ? 1 : $article->getSubmissionProgress(),
			$article->getSubmissionFileId(),
			$article->getRevisedFileId(),
			$article->getReviewFileId(),
			$article->getEditorFileId(),
			$article->getPages(),
			$article->getFastTracked()?1:0,
			$article->getHideAuthor() === null ? 0 : $article->getHideAuthor(),
			$article->getCommentsStatus() === null ? 0 : $article->getCommentsStatus(),
			$article->getStoredDOI()
		)
		);

		$article->setId($this->getInsertArticleId());
		$this->updateLocaleFields($article);

		return $article->getId();
	}

	/**
	 * Update an existing article.
	 * @param $article Article
	 */
	function updateArticle(&$article) {
		$article->stampModified();
		$this->update(
		sprintf('UPDATE articles
				SET	public_id = ?,
					locale = ?,
					user_id = ?,
					language = ?,
					comments_to_ed = ?,
					citations = ?,
					date_submitted = %s,
					date_status_modified = %s,
					last_modified = %s,
					status = ?,
					submission_progress = ?,
					submission_file_id = ?,
					revised_file_id = ?,
					review_file_id = ?,
					editor_file_id = ?,
					pages = ?,
					fast_tracked = ?,
					hide_author = ?,
					comments_status = ?,
					doi = ?
				WHERE article_id = ?',
		$this->datetimeToDB($article->getDateSubmitted()), $this->datetimeToDB($article->getDateStatusModified()), $this->datetimeToDB($article->getLastModified())),
		array(
                        $article->getProposalId(),
			$article->getLocale(),
			$article->getUserId(),
			$article->getLanguage(),
			$article->getCommentsToEditor(),
			$article->getCitations(),
			$article->getStatus(),
			$article->getSubmissionProgress(),
			$article->getSubmissionFileId(),
			$article->getRevisedFileId(),
			$article->getReviewFileId(),
			$article->getEditorFileId(),
			$article->getPages(),
			$article->getFastTracked(),
			$article->getHideAuthor(),
			$article->getCommentsStatus(),
			$article->getStoredDOI(),
			$article->getId()
		)
		);

		$this->updateLocaleFields($article);
                
                // update article texts for this article
		$articleTexts =& $article->getArticleTexts();
		foreach ($articleTexts as $articleText) {
			if ($articleText->getId() > 0) {
				$this->articleTextDao->updateArticleText($articleText);
			} else {
				$this->articleTextDao->insertArticleText($articleText);
			}
                }
                // Remove deleted article texts
		$removedArticleTexts = $article->getRemovedArticleTexts();
		foreach ($removedArticleTexts as $removedArticleTextId) {
			$this->articleTextDao->deleteArticleText($removedArticleTextId);
		}
                
                // update article secondary IDs for this article
		$articleSecIds =& $article->getArticleSecIds();
		foreach ($articleSecIds as $articleSecId) {
			if ($articleSecId->getId() > 0) {
				$this->articleSecIdDao->updateArticleSecId($articleSecId);
			} else {
				$this->articleSecIdDao->insertArticleSecId($articleSecId);
			}
                }
                // Remove deleted article sec Ids
		$removedArticleSecIds = $article->getRemovedArticleSecIds();
		foreach ($removedArticleSecIds as $removedArticleSecIdId) {
			$this->articleSecIdDao->deleteArticleSecId($removedArticleSecIdId);
		}
                
                // update articleDetails for this article
		$articleDetails =& $article->getArticleDetails();
		if ($this->articleDetailsDao->articleDetailsExists($article->getId())) {
			$this->articleDetailsDao->updateArticleDetails($articleDetails);
		} elseif ($articleDetails->getArticleId() > 0) {
			$this->articleDetailsDao->insertArticleDetails($articleDetails);
		}
                
                // update article purposes for this article
		$articlePurposes =& $article->getArticlePurposes();
		foreach ($articlePurposes as $articlePurpose) {
			if ($articlePurpose->getId() > 0) {
				$this->articlePurposeDao->updateArticlePurpose($articlePurpose);
			} else {
				$this->articlePurposeDao->insertArticlePurpose($articlePurpose);
			}
                }
                // Remove deleted article purposes
		$removedArticlePurposes = $article->getRemovedArticlePurposes();
		foreach ($removedArticlePurposes as $removedArticlePurposeId) {
			$this->articlePurposeDao->deleteArticlePurpose($removedArticlePurposeId);
		}
                
                // update article outcomes for this article
                $journal = Request::getJournal();
		$articleOutcomes =& $article->getArticleOutcomes();
		foreach ($articleOutcomes as $articleOutcome) {
                    foreach ($journal->getSupportedLocaleNames() as $localeKey => $localeValue) {
                        if(!empty($articleOutcome[$localeKey])) {
                            if ($articleOutcome[$localeKey]->getId() > 0) {
                                    $this->articleOutcomeDao->updateArticleOutcome($articleOutcome[$localeKey]);
                            } else {
                                    $this->articleOutcomeDao->insertArticleOutcome($articleOutcome[$localeKey]);
                            }                            
                        }
                    }			
                }
                // Remove deleted article outcomes
		$removedArticleOutcomes = $article->getRemovedArticleOutcomes();
		foreach ($removedArticleOutcomes as $removedArticleOutcomeId) {
			$this->articleOutcomeDao->deleteArticleOutcome($removedArticleOutcomeId);
		}
                
                // update article drugs for this article
		$articleDrugs =& $article->getArticleDrugs();
		foreach ($articleDrugs as $articleDrug) {
			if ($articleDrug->getId() > 0) {
				$this->articleDrugInfoDao->updateArticleDrugInfo($articleDrug);
			} else {
				$this->articleDrugInfoDao->insertArticleDrugInfo($articleDrug);
			}
                }
                // Remove deleted article sec Ids
		$removedArticleDrugs = $article->getRemovedArticleDrugs();
		foreach ($removedArticleDrugs as $removedArticleDrugId) {
			$this->articleDrugInfoDao->deleteArticleDrugInfo($removedArticleDrugId);
		}

                // update article sites for this article
		$articleSites =& $article->getArticleSites();
		foreach ($articleSites as $articleSite) {
			if ($articleSite->getId() > 0) {
				$this->articleSiteDao->updateArticleSite($articleSite);
			} else {
				$this->articleSiteDao->insertArticleSite($articleSite);
			}
                }
                // Remove deleted article sec Ids
		$removedArticleSites = $article->getRemovedArticleSites();
		foreach ($removedArticleSites as $removedArticleSiteId) {
			$this->articleSiteDao->deleteArticleSite($removedArticleSiteId);
		}
                
                // update article funding sources for this article
		$fundingSources =& $article->getArticleFundingSources();
		foreach ($fundingSources as $fundingSource) {
			if ($fundingSource->getId() > 0) {
				$this->articleSponsorDao->updateArticleSponsor($fundingSource);
			} else {
				$this->articleSponsorDao->insertArticleSponsor($fundingSource);
			}
                }
                // Remove deleted article funding sources
		$removedFundingSources = $article->getRemovedArticleFundingSources();
		foreach ($removedFundingSources as $removedFundingSourceId) {
			$this->articleSponsorDao->deleteArticleSponsor($removedFundingSourceId);
		}


                // update article primary sponsor for this article
		$primarySponsor =& $article->getArticlePrimarySponsor();
		if ($this->articleSponsorDao->articlePrimarySponsorExists($article->getId())) {
			$this->articleSponsorDao->updateArticleSponsor($primarySponsor);
		} elseif ($primarySponsor->getArticleId() > 0) {
			$this->articleSponsorDao->insertArticleSponsor($primarySponsor);
		}
                
                
                // update article secondary sponsors for this article
		$secondarySponsors =& $article->getArticleSecondarySponsors();
		foreach ($secondarySponsors as $secondarySponsor) {
			if ($secondarySponsor->getId() > 0) {
				$this->articleSponsorDao->updateArticleSponsor($secondarySponsor);
			} else {
				$this->articleSponsorDao->insertArticleSponsor($secondarySponsor);
			}
                }
                // Remove deleted article secondary sponsors
		$removedArticleSecondarySponsors = $article->getRemovedArticleSecondarySponsors();
		foreach ($removedArticleSecondarySponsors as $removedArticleSecondarySponsorId) {
			$this->articleSponsorDao->deleteArticleSponsor($removedArticleSecondarySponsorId);
		}

                
                // update article CROs for this article
		$CROs =& $article->getArticleCROs();
		foreach ($CROs as $CRO) {
			if ($CRO->getId() > 0) {
				$this->articleCRODao->updateArticleCRO($CRO);
			} else {
				$this->articleCRODao->insertArticleCRO($CRO);
			}
                }
                // Remove deleted article CROs
		$removedCROs = $article->getRemovedArticleCROs();
		foreach ($removedCROs as $removedCROId) {
			$this->articleCRODao->deleteArticleCRO($removedCROId);
		}
                
                
                // update articleContact for this article
		$articleContact =& $article->getArticleContact();
		if ($this->articleContactDao->articleContactExists($article->getId())) {
			$this->articleContactDao->updateArticleContact($articleContact);
		} elseif ($articleContact->getArticleId() > 0) {
			$this->articleContactDao->insertArticleContact($articleContact);
		}
                
                
		$this->flushCache();
	}

	/**
	 * Delete an article.
	 * @param $article Article
	 */
	function deleteArticle(&$article) {
		return $this->deleteArticleById($article->getId());
	}

	/**
	 * Delete an article by ID.
	 * @param $articleId int
	 */
	function deleteArticleById($articleId) {
		$publishedArticleDao =& DAORegistry::getDAO('PublishedArticleDAO');
		$publishedArticleDao->deletePublishedArticleByArticleId($articleId);

		$commentDao =& DAORegistry::getDAO('CommentDAO');
		$commentDao->deleteBySubmissionId($articleId);

		$noteDao =& DAORegistry::getDAO('NoteDAO');
		$noteDao->deleteByAssoc(ASSOC_TYPE_ARTICLE, $articleId);

		$sectionEditorSubmissionDao =& DAORegistry::getDAO('SectionEditorSubmissionDAO');
		$sectionEditorSubmissionDao->deleteDecisionsByArticle($articleId);

		// Delete copyedit, layout, and proofread signoffs
		$signoffDao =& DAORegistry::getDAO('SignoffDAO');
		$copyedInitialSignoffs = $signoffDao->getBySymbolic('SIGNOFF_COPYEDITING_INITIAL', ASSOC_TYPE_ARTICLE, $articleId);
		$copyedAuthorSignoffs = $signoffDao->getBySymbolic('SIGNOFF_COPYEDITING_AUTHOR', ASSOC_TYPE_ARTICLE, $articleId);
		$copyedFinalSignoffs = $signoffDao->getBySymbolic('SIGNOFF_COPYEDITING_FINAL', ASSOC_TYPE_ARTICLE, $articleId);
		$layoutSignoffs = $signoffDao->getBySymbolic('SIGNOFF_LAYOUT', ASSOC_TYPE_ARTICLE, $articleId);
		$proofreadAuthorSignoffs = $signoffDao->getBySymbolic('SIGNOFF_PROOFREADING_AUTHOR', ASSOC_TYPE_ARTICLE, $articleId);
		$proofreadProofreaderSignoffs = $signoffDao->getBySymbolic('SIGNOFF_PROOFREADING_PROOFREADER', ASSOC_TYPE_ARTICLE, $articleId);
		$proofreadLayoutSignoffs = $signoffDao->getBySymbolic('SIGNOFF_PROOFREADING_LAYOUT', ASSOC_TYPE_ARTICLE, $articleId);
		$signoffs = array($copyedInitialSignoffs, $copyedAuthorSignoffs, $copyedFinalSignoffs, $layoutSignoffs,
		$proofreadAuthorSignoffs, $proofreadProofreaderSignoffs, $proofreadLayoutSignoffs);
		foreach ($signoffs as $signoff) {
			if ( $signoff ) $signoffDao->deleteObject($signoff);
		}

		$articleCommentDao =& DAORegistry::getDAO('ArticleCommentDAO');
		$articleCommentDao->deleteArticleComments($articleId);

		$articleGalleyDao =& DAORegistry::getDAO('ArticleGalleyDAO');
		$articleGalleyDao->deleteGalleysByArticle($articleId);

		$articleSearchDao =& DAORegistry::getDAO('ArticleSearchDAO');
		$articleSearchDao->deleteArticleKeywords($articleId);

		$articleEventLogDao =& DAORegistry::getDAO('ArticleEventLogDAO');
		$articleEventLogDao->deleteArticleLogEntries($articleId);

		$articleEmailLogDao =& DAORegistry::getDAO('ArticleEmailLogDAO');
		$articleEmailLogDao->deleteArticleLogEntries($articleId);

		$articleEventLogDao =& DAORegistry::getDAO('ArticleEventLogDAO');
		$articleEventLogDao->deleteArticleLogEntries($articleId);

		$suppFileDao =& DAORegistry::getDAO('SuppFileDAO');
		$suppFileDao->deleteSuppFilesByArticle($articleId);

		$sectionDecisionDao =& DAORegistry::getDAO('SectionDecisionDAO');
		$sectionDecisionDao->deleteSectionDecisionsByArticleId($articleId);
						
		// Delete article files -- first from the filesystem, then from the database
		import('classes.file.ArticleFileManager');
		$articleFileDao =& DAORegistry::getDAO('ArticleFileDAO');
		$articleFiles =& $articleFileDao->getArticleFilesByArticle($articleId);

		$articleFileManager = new ArticleFileManager($articleId);
		foreach ($articleFiles as $articleFile) {
			$articleFileManager->deleteFile($articleFile->getFileId());
		}

		$articleFileDao->deleteArticleFiles($articleId);

                //Delete article texts
                $this->articleTextDao->deleteArticleTextsByArticleId($articleId);

                //Delete article secondary IDs
                $this->articleSecIdDao->deleteArticleSecIdsByArticleId($articleId);

                //Delete article details
                $this->articleDetailsDao->deleteArticleDetails($articleId);

                //Delete article purposes
                $this->articlePurposeDao->deleteArticlePurposes($articleId);

                //Delete article outcomes
                $this->articleOutcomeDao->deleteArticleOutcomes($articleId);

                //Delete article drugs
                $this->articleDrugInfoDao->deleteArticleDrugInfosByArticleId($articleId);

                //Delete article sites
                $this->articleSiteDao->deleteArticleSitesByArticleId($articleId);

                //Delete article sponsors
                $this->articleSponsorDao->deleteArticleSponsorsByArticleId($articleId);

                //Delete article CROs
                $this->articleCRODao->deleteArticleCROsByArticleId($articleId);

                //Delete article contact
                $this->articleContactDao->deleteArticleContact($articleId);
                
		// Delete article citations.
		$citationDao =& DAORegistry::getDAO('CitationDAO');
		$citationDao->deleteObjectsByAssocId(ASSOC_TYPE_ARTICLE, $articleId);

		$this->update('DELETE FROM article_settings WHERE article_id = ?', $articleId);
		$this->update('DELETE FROM articles WHERE article_id = ?', $articleId);

		$this->flushCache();
	}

	/**
	 * Get all articles for a journal (or all articles in the system).
	 * @param $userId int
	 * @param $journalId int
	 * @return DAOResultFactory containing matching Articles
	 */
	function &getArticlesByJournalId($journalId = null) {
		$primaryLocale = Locale::getPrimaryLocale();
		$locale = Locale::getLocale();
		$articles = array();

		$params = array(
			'title',
		$primaryLocale,
			'title',
		$locale,
			'abbrev',
		$primaryLocale,
			'abbrev',
		$locale,
		$primaryLocale,
		$locale
		);
		if ($journalId !== null) $params[] = (int) $journalId;

		$result =& $this->retrieve(
			'SELECT	a.*,
				COALESCE(stl.setting_value, stpl.setting_value) AS section_title,
				COALESCE(sal.setting_value, sapl.setting_value) AS section_abbrev,
				COALESCE(atl.scientific_title, atpl.scientific_title) AS scientifictitle
			FROM	articles a
				LEFT JOIN section_decisions sdec ON (a.article_id = sdec.article_id)
                                LEFT JOIN section_decisions sdec2 ON (a.article_id = sdec2.article_id AND sdec.section_decision_id < sdec2.section_decision_id)
				LEFT JOIN section_settings stpl ON (sdec.section_id = stpl.section_id AND stpl.setting_name = ? AND stpl.locale = ?)
				LEFT JOIN section_settings stl ON (sdec.section_id = stl.section_id AND stl.setting_name = ? AND stl.locale = ?)
				LEFT JOIN section_settings sapl ON (sdec.section_id = sapl.section_id AND sapl.setting_name = ? AND sapl.locale = ?)
				LEFT JOIN section_settings sal ON (sdec.section_id = sal.section_id AND sal.setting_name = ? AND sal.locale = ?)
				LEFT JOIN article_text atpl ON (atpl.article_id = a.article_id AND atpl.locale = ?)
				LEFT JOIN article_text atl ON (atl.article_id = a.article_id AND atl.locale = ?)
			' . ($journalId !== null ? 'WHERE a.journal_id = ?' : '') . ' AND sdec2.section_decision_id IS NULL',
		$params
		);

		$returner = new DAOResultFactory($result, $this, '_returnArticleFromRow');
		return $returner;
	}

	/**
	 * Delete all articles by journal ID.
	 * @param $journalId int
	 */
	function deleteArticlesByJournalId($journalId) {
		$articles = $this->getArticlesByJournalId($journalId);

		while (!$articles->eof()) {
			$article =& $articles->next();
			$this->deleteArticleById($article->getId());
		}
	}

	/**
	 * Get all articles for a user.
	 * @param $userId int
	 * @param $journalId int optional
	 * @return array Articles
	 */
	function &getArticlesByUserId($userId, $journalId = null) {
		$primaryLocale = Locale::getPrimaryLocale();
		$locale = Locale::getLocale();
		$params = array(
			'title',
		$primaryLocale,
			'title',
		$locale,
			'abbrev',
		$primaryLocale,
			'abbrev',
		$locale,
		$primaryLocale,
		$locale,
		$userId
		);
		if ($journalId) $params[] = $journalId;
		$articles = array();

		$result =& $this->retrieve(
			'SELECT	a.*,
				COALESCE(stl.setting_value, stpl.setting_value) AS section_title,
				COALESCE(sal.setting_value, sapl.setting_value) AS section_abbrev,
				COALESCE(atl.scientific_title, atpl.scientific_title) AS scientifictitle
			FROM	articles a
				LEFT JOIN section_decisions sdec ON (a.article_id = sdec.article_id)
                                LEFT JOIN section_decisions sdec2 ON (a.article_id = sdec2.article_id AND sdec.section_decision_id < sdec2.section_decision_id)
				LEFT JOIN section_settings stpl ON (sdec.section_id = stpl.section_id AND stpl.setting_name = ? AND stpl.locale = ?)
				LEFT JOIN section_settings stl ON (sdec.section_id = stl.section_id AND stl.setting_name = ? AND stl.locale = ?)
				LEFT JOIN section_settings sapl ON (sdec.section_id = sapl.section_id AND sapl.setting_name = ? AND sapl.locale = ?)
				LEFT JOIN section_settings sal ON (sdec.section_id = sal.section_id AND sal.setting_name = ? AND sal.locale = ?)
				LEFT JOIN article_text atpl ON (atpl.article_id = a.article_id AND atpl.locale = ?)
				LEFT JOIN article_text atl ON (atl.article_id = a.article_id AND atl.locale = ?)
			WHERE	a.user_id = ? AND sdec2.section_decision_id IS NULL' .
		(isset($journalId)?' AND a.journal_id = ?':''),
		$params
		);

		while (!$result->EOF) {
			$articles[] =& $this->_returnArticleFromRow($result->GetRowAssoc(false));
			$result->MoveNext();
		}

		$result->Close();
		unset($result);

		return $articles;
	}

	/**
	 * Get the ID of the journal an article is in.
	 * @param $articleId int
	 * @return int
	 */
	function getArticleJournalId($articleId) {
		$result =& $this->retrieve(
			'SELECT journal_id FROM articles WHERE article_id = ?', $articleId
		);
		$returner = isset($result->fields[0]) ? $result->fields[0] : false;

		$result->Close();
		unset($result);

		return $returner;
	}

	/**
	 * Check if the specified incomplete submission exists.
	 * @param $articleId int
	 * @param $userId int
	 * @param $journalId int
	 * @return int the submission progress
	 */
	function incompleteSubmissionExists($articleId, $userId, $journalId) {
		$result =& $this->retrieve(
			'SELECT submission_progress FROM articles WHERE article_id = ? AND user_id = ? AND journal_id = ? AND date_submitted IS NULL',
		array($articleId, $userId, $journalId)
		);
		$returner = isset($result->fields[0]) ? $result->fields[0] : false;

		$result->Close();
		unset($result);

		return $returner;
	}

	/**
	 * Change the status of the article
	 * @param $articleId int
	 * @param $status int
	 */
	function changeArticleStatus($articleId, $status) {
		$this->update(
			'UPDATE articles SET status = ? WHERE article_id = ?', array((int) $status, (int) $articleId)
		);

		$this->flushCache();
	}

	/**
	 * Change the DOI of an article
	 * @param $articleId int
	 * @param $doi string
	 */
	function changeDOI($articleId, $doi) {
		$this->update(
			'UPDATE articles SET doi = ? WHERE article_id = ?', array($doi, (int) $articleId)
		);

		$this->flushCache();
	}

	function assignDOIs($forceReassign = false, $journalId = null) {
		if ($forceReassign) {
			$this->update(
				'UPDATE articles SET doi = null' . ($journalId !== null?' WHERE journal_id = ?':''),
			$journalId !== null?array((int) $journalId):false
			);
			$this->flushCache();
		}

		$publishedArticleDao =& DAORegistry::getDAO('PublishedArticleDAO');
		$articles =& $publishedArticleDao->getPublishedArticlesByJournalId($journalId);
		while ($article =& $articles->next()) {
			// Cause a DOI to be fetched and stored.
			$article->getDOI();
			unset($article);
		}

		$this->flushCache();
	}

	/**
	 * Removes articles from a section by section ID
	 * @param $sectionId int
         * 
         * Should de modified because no anymore section ID
         * -> move to sectionDecisionDAO ?
	 
	function removeArticlesFromSection($sectionId) {
		$this->update(
			'UPDATE articles SET section_id = null WHERE section_id = ?', $sectionId
		);

		$this->flushCache();
	}
        */
        
	/**
	 * Get the ID of the last inserted article.
	 * @return int
	 */
	function getInsertArticleId() {
		return $this->getInsertId('articles', 'article_id');
	}

	function flushCache() {
		// Because both publishedArticles and articles are cached by
		// article ID, flush both caches on update.
		$cache =& $this->_getCache();
		$cache->flush();
		unset($cache);

		$publishedArticleDao =& DAORegistry::getDAO('PublishedArticleDAO');
		$cache =& $publishedArticleDao->_getPublishedArticleCache();
		$cache->flush();
		unset($cache);
	}


	/**
	 * Get the number of submissions for the year.
	 * @param $year
	 * @return integer
	 */
	function getSubmissionsForYearCount($year) {
		$result =& $this->retrieve('SELECT * FROM articles where date_submitted is not null and extract(year from date_submitted) = ?', $year);
		$count = $result->NumRows();

		return $count;
	}


	/**
	 * Get the number of submissions for the country for the year.
	 * @param $year
	 * @return integer
	 *
	 */
	function getSubmissionsForYearForCountryCount($year, $country) {
		$result =& $this->retrieve('SELECT * FROM articles
                                            WHERE date_submitted is not NULL and extract(year from date_submitted) = ? and
                                            article_id in (SELECT article_id from article_settings where setting_name = ? and setting_value = ?)',
		array($year, 'proposalCountry', $country));

		$count = $result->NumRows();

		return $count;
	}

	/**
	 * Get the number of submissions for the section for the year.
	 * @param $year
	 * @return integer
	 *
	 */
	function getSubmissionsForYearForSectionCount($year, $section) {
		$result =& $this->retrieve('SELECT * FROM articles
                                            WHERE date_submitted is not NULL and extract(year from date_submitted) = ? and
                                            section_id = ?',
		array($year, $section));

		$count = $result->NumRows();

		return $count;
	}

    /**
	 * Get the number of submissions for the country for the year.
	 * @param $year
	 * @return integer
	 *
         * Added 12.25.2011
	 */
	function getICPSubmissionsForYearCount($year) {
		$result =& $this->retrieve('SELECT * FROM articles
                                            WHERE date_submitted is not NULL and extract(year from date_submitted) = ? and public_id LIKE ?',
		array($year, '%.ICP.%'));

		$count = $result->NumRows();

		return $count;
	}


	/************************************
	 * Added by: Anne Ivy Mirasol
	 * Last Updated: May 18, 2011
	 * Reset an article's progress
	 ************************************/

	function changeArticleProgress($articleId, $step) {
		$this->update(
			'UPDATE articles SET submission_progress = ? WHERE article_id = ?', array((int) $step, (int) $articleId)
		);

		$this->flushCache();
	}


	/**
	 *  Added by:  Anne Ivy Mirasol
	 *  Last Updated: May 24, 2011
	 *
	 *  Compare decision date and submission date of proposal to determine if proposal has been resubmitted
	 *  @return boolean
	 */
	function isProposalResubmitted($articleId) {
		$result =& $this->retrieve('SELECT date_submitted FROM articles WHERE article_id = ?', $articleId);
		$row = $result->FetchRow();
		$date_submitted = $row['date_submitted'];


		$result =& $this->retrieve('SELECT date_decided FROM section_decisions WHERE section_decision_id =
                                             (SELECT MAX(section_decision_id) FROM section_decisions WHERE article_id = ? GROUP BY article_id)', $articleId);
		$row = $result->FetchRow();
		$date_decided = $row['date_decided'];

		if($date_decided < $date_submitted) return true;
		else return false;
	}

	/**
	 *  Added by:  Anne Ivy Mirasol
	 *  Last Updated: June 15, 2011
	 *
	 *  Set status in articles table to PROPOSAL_STATUS_WITHDRAWN
	 *  @return boolean
	 */

	function withdrawProposal($articleId) {
		$this->update(
			'UPDATE articles SET status = ? WHERE article_id = ?', array(PROPOSAL_STATUS_WITHDRAWN, (int) $articleId)
		);

		$this->flushCache();
	}

	/**
	 *  Set status in articles table to PROPOSAL_STATUS_ARCHIVED
	 *  @return boolean
	 */

	function sendToArchive($articleId) {
		$this->update(
			'UPDATE articles SET status = ? WHERE article_id = ?', array(STATUS_ARCHIVED, (int) $articleId)
		);
		$this->flushCache();
	}
	

        /**
         *  Added by:  Anne Ivy Mirasol
         *  Last Updated: June 22, 2011
         *
         *  Set status in articles table to PROPOSAL_STATUS_COMPLETED
         *  @return boolean
         */

        function setAsCompleted($articleId) {
            $this->update(
			'UPDATE articles SET status = ? WHERE article_id = ?', array(PROPOSAL_STATUS_COMPLETED, (int) $articleId)
		);

            $this->flushCache();
        }
 
	
	function searchProposalsPublic($query, $dateFrom, $dateTo, $geoAreas, $status = null, $trialSite = null, $rangeInfo = null, $sortBy = null, $sortDirection = SORT_DIRECTION_ASC) {
		
		$locale = Locale::getLocale();
		$primaryLocale = Locale::getPrimaryLocale();
                
		$params = array(
                    $primaryLocale,
                    $locale,
                    ARTICLE_SPONSOR_TYPE_PRIMARY,
                    REVIEW_TYPE_INITIAL,
                    SUBMISSION_SECTION_DECISION_APPROVED,
                    SUBMISSION_SECTION_DECISION_EXEMPTED,
                    SUBMISSION_SECTION_DECISION_DONE
		);
	
		$searchSql = '';
	
		$sql = 'select distinct 
				a.article_id, a.status,
				a.date_submitted as date_submitted,
                                inst.name as psponsorname,
                                ad.therapeutic_area as therapeuticarea,
                                ad.recruitment_status as recruitmentstatus,
				COALESCE(atl.scientific_title, atpl.scientific_title) AS scientifictitle
			FROM articles a
				LEFT JOIN section_decisions sdec ON (a.article_id = sdec.article_id)
				LEFT JOIN article_text atpl ON (atpl.article_id = a.article_id AND atpl.locale = ?)
				LEFT JOIN article_text atl ON (atl.article_id = a.article_id AND atl.locale = ?)
                                LEFT JOIN article_sponsor asp ON (asp.article_id = a.article_id AND asp.type = ?)
                                LEFT JOIN institutions inst ON (inst.institution_id = asp.institution_id)
                                LEFT JOIN article_details ad ON (ad.article_id = a.article_id)
                                LEFT JOIN article_drug_info adi ON (adi.article_id = a.article_id)
                                LEFT JOIN article_site arts ON (arts.article_id = a.article_id)
                                LEFT JOIN trial_site ts ON (ts.site_id = arts.site_id)
			WHERE sdec.review_type = ? AND (sdec.decision = ? 
				OR sdec.decision = ? 
				OR sdec.decision = ?)';
		
		if (!empty($query)) {
			$searchSql .= ' AND (
				LOWER(atl.scientific_title) LIKE LOWER("%'.$query.'%")
				OR LOWER(atl.public_title) LIKE LOWER("%'.$query.'%")
				OR LOWER(atl.description) LIKE LOWER("%'.$query.'%")
				OR LOWER(atpl.public_title) LIKE LOWER("%'.$query.'%")
				OR LOWER(atpl.description) LIKE LOWER("%'.$query.'%")
				OR LOWER(atpl.scientific_title) LIKE LOWER("%'.$query.'%")  
				OR LOWER(adi.name) LIKE LOWER("%'.$query.'%")    
				OR LOWER(adi.brand_name) LIKE LOWER("%'.$query.'%")  
			)';
		}
		
		if (!empty($dateFrom) || !empty($dateTo)){
			if (!empty($dateFrom)) {
				$searchSql .= ' AND (ad.enrolment_end_date >= "'.substr($dateFrom, 0, 10).'")';
			}
			if (!empty($dateTo)) {
				$searchSql .= ' AND (ad.enrolment_start_date <= "'.substr($dateTo, 0, 10).'")';
			}
		}
		
		if ($geoAreas != 'ALL' && $geoAreas != '') $searchSql .= ' AND (ts.region = '.$geoAreas.')';
		
		if ($status != 'ALL' && $status != '') $searchSql .= ' AND ad.recruitment_status = ' . $status;
                
		if ($trialSite != 'ALL' && $trialSite != '') $searchSql .= ' AND arts.site_id = ' . $trialSite;
                
		$result =& $this->retrieveRange(
			$sql . ' ' . $searchSql. ' GROUP BY a.article_id' . ($sortBy?(' ORDER BY ' . $this->getSortMapping($sortBy) . ' ' . $this->getDirectionMapping($sortDirection)) : ''),
			count($params)===1?array_shift($params):$params,
			$rangeInfo
		);
		
		$returner = new DAOResultFactory($result, $this, '_returnSearchArticleFromRow');
		
		return $returner;
	}
	
	/**
	 * Internal function to return an Article object from a row.
	 * @param $row array
	 * @return Article
	 */
	function &_returnSearchArticleFromRow(&$row) {
		$article = new Article();
		$this->_searchArticleFromRow($article, $row);
		return $article;
	}

        function searchCustomizedProposalsPublic($query, $region, $fromDate, $toDate, $statusFilter, $proposalId, $scientificTitle, $publicTitle, $recruitmentStatus, $therapeuticArea, $minAge, $maxAge, $sex, $healthy, $pSponsor, $enrolment) {
		
		$searchSqlBeg = "select distinct a.article_id";
		$searchSqlMid = " FROM articles a                    
                                    LEFT JOIN section_decisions sdec ON (a.article_id = sdec.article_id)
                                    LEFT JOIN article_details ad ON (a.article_id = ad.article_id)
                                    LEFT JOIN article_site asite ON (a.article_id = asite.article_id)
                                    LEFT JOIN article_drug_info adi ON (adi.article_id = a.article_id)
                                    LEFT JOIN article_text atpl ON (atpl.article_id = a.article_id AND atpl.locale = ".Locale::getPrimaryLocale().")
                                    LEFT JOIN article_text atl ON (atl.article_id = a.article_id AND atl.locale = ".Locale::getLocale().")";
		$searchSqlEnd = " WHERE sdec.review_type = ".REVIEW_TYPE_INITIAL." AND (sdec.decision = ".SUBMISSION_SECTION_DECISION_APPROVED." 
                                        OR sdec.decision = ".SUBMISSION_SECTION_DECISION_EXEMPTED." 
                                        OR sdec.decision = ".SUBMISSION_SECTION_DECISION_DONE.")";

		if ($scientificTitle || $publicTitle){
                    if ($scientificTitle) $searchSqlBeg .= ", COALESCE(atl.scientific_title, atpl.scientific_title) AS as s_title";
                    if ($publicTitle == true) $searchSqlBeg .= ", COALESCE(atl.public_title, atpl.public_title) AS as p_title";	
		}

		if ($proposalId){
                    $searchSqlBeg .= ", a.public_id as public_id";
		}
										
		if ($recruitmentStatus){
                    $searchSqlBeg .= ", ad.recruitment_status as r_status";
		}	
		
		if ($therapeuticArea){
                    $searchSqlBeg .= ", ad.therapeutic_area as t_area";
		}	
                
                if ($minAge){
                    $searchSqlBeg .= ", ad.min_age_num as min_age_num, ad.min_age_unit as min_age_unit";
		}
                
                if ($maxAge){
                    $searchSqlBeg .= ", ad.max_age_num as max_age_num, ad.max_age_unit as max_age_unit";
		}	
                
		if ($sex){
                    $searchSqlBeg .= ", ad.sex as sex";
		}
                
		if ($healthy){
                    $searchSqlBeg .= ", ad.healthy as healthy";
		}
                
		if ($pSponsor){
                    $searchSqlMid .= " left join article_sponsor asp ON (asp.article_id = a.article_id AND asp.type = ".ARTICLE_SPONSOR_TYPE_PRIMARY.") ";
                    $searchSqlBeg .= ", asp.institution_id as institution_id";
		}
                     
		if ($enrolment){
                    $searchSqlBeg .= ", ad.enrolment_start_date as enrolment_start_date, ad.enrolment_end_date as enrolment_end_date";
		}
                                
		if (!empty($query)) {
                    $searchSqlEnd .= ' AND (
                            LOWER(atl.scientific_title) LIKE LOWER("%'.$query.'%")
                            OR LOWER(atl.public_title) LIKE LOWER("%'.$query.'%")
                            OR LOWER(atl.description) LIKE LOWER("%'.$query.'%")
                            OR LOWER(atpl.public_title) LIKE LOWER("%'.$query.'%")
                            OR LOWER(atpl.description) LIKE LOWER("%'.$query.'%")
                            OR LOWER(atpl.scientific_title) LIKE LOWER("%'.$query.'%")  
                            OR LOWER(adi.name) LIKE LOWER("%'.$query.'%")    
                            OR LOWER(adi.brand_name) LIKE LOWER("%'.$query.'%")  
			)';
		}

                if (!empty($region)) {
                    $searchSqlEnd .= " ";
		}
		
		if ($fromDate != "--" || $toDate != "--"){
                    if ($fromDate != "--" && $fromDate != null) {
                        $searchSqlEnd .= "";
                    }
                    if ($toDate != "--" && $toDate != null) {
                        $searchSqlEnd .= "";
                    }
		}
					
		if ($statusFilter == 1) $searchSqlEnd .= " AND a.status = 11";
		else if ($statusFilter == 2) $searchSqlEnd .= " AND a.status <> 11";		
		
		$searchSql = $searchSqlBeg.$searchSqlMid.$searchSqlEnd.' GROUP BY a.article_id';
		
		$result =& $this->retrieve($searchSql);
		
		while (!$result->EOF) {
			$articles[] =& $this->_returnSearchArticleFromRow($result->GetRowAssoc(false));
			$result->MoveNext();
		}

		$result->Close();
		unset($result);

                return $articles;
	}

	/**
	 * Internal function to fill in the passed article object from the row.
	 * @param $article Article output article
	 * @param $row array input row
	 */
	function _searchArticleFromRow(&$article, &$row) {
		if (isset($row['status'])) $article->setStatus($row['status']);
		if (isset($row['article_id'])) $article->setId($row['article_id']);
		if (isset($row['public_id'])) $article->setProposalId($row['public_id']);
		if (isset($row['date_submitted'])) $article->setDateSubmitted($this->datetimeFromDB($row['date_submitted']));
		if (isset($row['efname']) or isset($row['elname'])) $article->setPrimaryEditor($row['efname']." ".$row['elname']);
		if (isset($row['decision'])) $article->setProposalStatus($row['decision']);
		if (isset($row['date_decided'])) $article->setDateStatusModified($this->datetimeFromDB($row['date_decided']));
		if (isset($row['scientifictitle'])) $article->setScientificTitle($row['scientifictitle']);
		if (isset($row['psponsorname'])) $article->setArticlePrimarySponsorName($row['psponsorname']);
		if (isset($row['therapeuticarea'])) $article->setArticleTherapeuticArea($row['therapeuticarea']);
		if (isset($row['recruitmentstatus'])) $article->setArticleRecruitmentStatus($row['recruitmentstatus']);
                
                $articleFileDao =& DAORegistry::getDAO('ArticleFileDAO');
                $publicFiles = $articleFileDao->getArticleFilesByType($row['article_id'], 'PublicFile');
                if($publicFiles) $article->setPublishedFinalReport($publicFiles[0]); // FIX ME: Only one file in folder 'public' -> alwas the final report: Pretty ugly

                HookRegistry::call('ArticleDAO::_returnSearchArticleFromRow', array(&$article, &$row));
	}

	function getSortMapping($heading) {
		switch ($heading) {
			case 'title': return 'scientifictitle';
			case 'status': return 'a.status';
			default: return 'a.status';
		}
	}
}

?>
