<?php

/**
 * @file ArticleReportDAO.inc.php
 *
 * Copyright (c) 2003-2011 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class ArticleReportDAO
 * @ingroup plugins_reports_article
 *
 * @brief Article report DAO
 */

// $Id$


import('classes.submission.common.Action');
import('lib.pkp.classes.db.DBRowIterator');

class ArticleReportDAO extends DAO {
	/**
	 * Get the article report data.
	 * @param $journalId int
	 * @return array
	 */
	function getArticleReport($journalId) {
		$primaryLocale = Locale::getPrimaryLocale();
		$locale = Locale::getLocale();

		$result =& $this->retrieve(
			'SELECT	a.article_id AS article_id,
				COALESCE(asl1.setting_value, aspl1.setting_value) AS title,
				COALESCE(asl2.setting_value, aspl2.setting_value) AS abstract,
				COALESCE(sl.setting_value, spl.setting_value) AS section_title,
				a.status AS status,
				a.language AS language
			FROM	articles a
				LEFT JOIN section_decisions sdec ON (a.article_id = sdec.article_id)
                                LEFT JOIN section_decisions sdec2 ON (a.article_id = sdec2.article_id AND sdec.section_decision_id < sdec2.section_decision_id)
				LEFT JOIN article_settings aspl1 ON (aspl1.article_id=a.article_id AND aspl1.setting_name = ? AND aspl1.locale = a.locale)
				LEFT JOIN article_settings asl1 ON (asl1.article_id=a.article_id AND asl1.setting_name = ? AND asl1.locale = ?)
				LEFT JOIN article_settings aspl2 ON (aspl2.article_id=a.article_id AND aspl2.setting_name = ? AND aspl2.locale = a.locale)
				LEFT JOIN article_settings asl2 ON (asl2.article_id=a.article_id AND asl2.setting_name = ? AND asl2.locale = ?)
				LEFT JOIN section_settings spl ON (spl.section_id=sdec.section_id AND spl.setting_name = ? AND spl.locale = ?)
				LEFT JOIN section_settings sl ON (sl.section_id=sdec.section_id AND sl.setting_name = ? AND sl.locale = ?)
			WHERE	a.journal_id = ? AND sdec2.section_decision_id IS NULL
			ORDER BY a.article_id',
			array(
				'title', // Article title
				'title',
				$locale,
				'abstract', // Article abstract
				'abstract',
				$locale,
				'title',
				$primaryLocale,
				'title',
				$locale,
				$journalId
			)
		);
		$articlesReturner = new DBRowIterator($result);

		$result =& $this->retrieve(
			'SELECT	MAX(sd.date_decided) AS date,
				sd.article_id AS article_id
			FROM	section_decisions sd,
				articles a
			WHERE	a.journal_id = ? AND
				a.article_id = sd.article_id
			GROUP BY sd.article_id',
			array($journalId)
		);
		$decisionDatesIterator = new DBRowIterator($result);
		$decisionsReturner = array();
		while ($row =& $decisionDatesIterator->next()) {
			$result =& $this->retrieve(
				'SELECT	decision AS decision,
					article_id AS article_id
				FROM	section_decisions
				WHERE	date_decided = ? AND
					article_id = ?',
				array(
					$row['date'],
					$row['article_id']
				)
			);
			$decisionsReturner[] = new DBRowIterator($result);
			unset($result);
		}

		$articleDao =& DAORegistry::getDAO('ArticleDAO');
		$articles =& $articleDao->getArticlesByJournalId($journalId);
		$authorsReturner = array();
		$index = 1;
		while ($article =& $articles->next()) {
			$result =& $this->retrieve(
				'SELECT	aa.first_name AS fname,
					aa.middle_name AS mname,
					aa.last_name AS lname,
					aa.email AS email,
					aa.country AS country,
					aa.url AS url,
					aa.affiliation AS affiliation
				FROM	authors aa
        				LEFT JOIN article_site ars ON (ars.site_id = aa.site_id)
					LEFT JOIN articles a ON (ars.article_id = a.article_id)
				WHERE
					a.journal_id = ? AND
					ars.article_id = ?',
				array(
					$journalId,
					$article->getId()
				)
			);
			$authorIterator = new DBRowIterator($result);
			$authorsReturner[$article->getId()] =& $authorIterator;
			unset($authorIterator);
			$index++;
			unset($article);
		}

		return array($articlesReturner, $authorsReturner, $decisionsReturner);
	}
}

?>
