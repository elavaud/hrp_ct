<?php

/**
 * @defgroup submission_common
 */

/**
 * @file classes/submission/common/Action.inc.php
 *
 * Copyright (c) 2003-2011 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class Action
 * @ingroup submission_common
 *
 * @brief Application-specific submission actions.
 */

/* These constants correspond to editing decision "decision codes". */
define('SUBMISSION_SECTION_NO_DECISION', 0);		//NO DECISION
define('SUBMISSION_SECTION_DECISION_APPROVED', 1);	//APPROVED
define('SUBMISSION_SECTION_DECISION_RESUBMIT', 2);	//REVISE AND RESUBMIT
define('SUBMISSION_SECTION_DECISION_DECLINED', 3);	//NOT APPROVED
define('SUBMISSION_SECTION_DECISION_EXEMPTED', 6);	//EXEMPTED

define('SUBMISSION_SECTION_DECISION_COMPLETE', 4);	//INITIAL REVIEW: COMPLETE
define('SUBMISSION_SECTION_DECISION_INCOMPLETE', 5);	//INCOMPLETE
define('SUBMISSION_SECTION_DECISION_FULL_REVIEW', 7);	//ASSIGN FOR A FULL REVIEW
define('SUBMISSION_SECTION_DECISION_EXPEDITED', 8);	//ASSIGN FOR EXPEDITED REVIEW
define('SUBMISSION_SECTION_DECISION_DONE', 9);          //RESEARCH COMPLETED

/* These constants correspond to the type of review. If modified, should modify to SectionDecision.inc.php */
define('INITIAL_REVIEW', 1);
define('PROGRESS_REPORT', 2);
define('PROTOCOL_AMENDMENT', 3);
define('SERIOUS_ADVERSE_EVENT', 4);
define('FINAL_REPORT', 5);

/* These constants are used as search fields for the various submission lists */
define('SUBMISSION_FIELD_AUTHOR', 1);
define('SUBMISSION_FIELD_EDITOR', 2);
define('SUBMISSION_FIELD_TITLE', 3);
define('SUBMISSION_FIELD_REVIEWER', 4);
define('SUBMISSION_FIELD_COPYEDITOR', 5);
define('SUBMISSION_FIELD_LAYOUTEDITOR', 6);
define('SUBMISSION_FIELD_PROOFREADER', 7);
define('SUBMISSION_FIELD_ID', 8);

define('SUBMISSION_FIELD_DATE_SUBMITTED', 4);
define('SUBMISSION_FIELD_DATE_COPYEDIT_COMPLETE', 5);
define('SUBMISSION_FIELD_DATE_LAYOUT_COMPLETE', 6);
define('SUBMISSION_FIELD_DATE_PROOFREADING_COMPLETE', 7);
define('SUBMISSION_FIELD_DATE_APPROVED', 8);

import('lib.pkp.classes.submission.common.PKPAction');

class Action extends PKPAction {
	/**
	 * Constructor.
	 */
	function Action() {
		parent::PKPAction();
	}

	//
	// Actions.
	//
	/**
	 * View metadata of an article.
	 * @param $article object
	 */
	function viewMetadata($article, $journal) {
		if (!HookRegistry::call('Action::viewMetadata', array(&$article, &$journal))) {
			import('classes.submission.form.MetadataForm');
			$metadataForm = new MetadataForm($article, $journal);
			if ($metadataForm->getCanEdit() && $metadataForm->isLocaleResubmit()) {
				$metadataForm->readInputData();
			} else {
				$metadataForm->initData();
			}
			$metadataForm->display();
		}
	}

	/**
	 * Save metadata.
	 * @param $article object
	 * @param $request PKPRequest
	 */
	function saveMetadata($article, &$request) {
		$router =& $request->getRouter();
		if (!HookRegistry::call('Action::saveMetadata', array(&$article))) {
			import('classes.submission.form.MetadataForm');
			$journal =& $request->getJournal();
			$metadataForm = new MetadataForm($article, $journal);
			$metadataForm->readInputData();

			// Check for any special cases before trying to save
			if ($request->getUserVar('addAuthor')) {
				// Add an author
				$editData = true;
				$authors = $metadataForm->getData('authors');
				array_push($authors, array());
				$metadataForm->setData('authors', $authors);

			} else if (($delAuthor = $request->getUserVar('delAuthor')) && count($delAuthor) == 1) {
				// Delete an author
				$editData = true;
				list($delAuthor) = array_keys($delAuthor);
				$delAuthor = (int) $delAuthor;
				$authors = $metadataForm->getData('authors');
				if (isset($authors[$delAuthor]['authorId']) && !empty($authors[$delAuthor]['authorId'])) {
					$deletedAuthors = explode(':', $metadataForm->getData('deletedAuthors'));
					array_push($deletedAuthors, $authors[$delAuthor]['authorId']);
					$metadataForm->setData('deletedAuthors', join(':', $deletedAuthors));
				}
				array_splice($authors, $delAuthor, 1);
				$metadataForm->setData('authors', $authors);

				if ($metadataForm->getData('primaryContact') == $delAuthor) {
					$metadataForm->setData('primaryContact', 0);
				}

			} else if ($request->getUserVar('moveAuthor')) {
				// Move an author up/down
				$editData = true;
				$moveAuthorDir = $request->getUserVar('moveAuthorDir');
				$moveAuthorDir = $moveAuthorDir == 'u' ? 'u' : 'd';
				$moveAuthorIndex = (int) $request->getUserVar('moveAuthorIndex');
				$authors = $metadataForm->getData('authors');

				if (!(($moveAuthorDir == 'u' && $moveAuthorIndex <= 0) || ($moveAuthorDir == 'd' && $moveAuthorIndex >= count($authors) - 1))) {
					$tmpAuthor = $authors[$moveAuthorIndex];
					$primaryContact = $metadataForm->getData('primaryContact');
					if ($moveAuthorDir == 'u') {
						$authors[$moveAuthorIndex] = $authors[$moveAuthorIndex - 1];
						$authors[$moveAuthorIndex - 1] = $tmpAuthor;
						if ($primaryContact == $moveAuthorIndex) {
							$metadataForm->setData('primaryContact', $moveAuthorIndex - 1);
						} else if ($primaryContact == ($moveAuthorIndex - 1)) {
							$metadataForm->setData('primaryContact', $moveAuthorIndex);
						}
					} else {
						$authors[$moveAuthorIndex] = $authors[$moveAuthorIndex + 1];
						$authors[$moveAuthorIndex + 1] = $tmpAuthor;
						if ($primaryContact == $moveAuthorIndex) {
							$metadataForm->setData('primaryContact', $moveAuthorIndex + 1);
						} else if ($primaryContact == ($moveAuthorIndex + 1)) {
							$metadataForm->setData('primaryContact', $moveAuthorIndex);
						}
					}
				}
				$metadataForm->setData('authors', $authors);
			}

			if (isset($editData)) {
				$metadataForm->display();
				return false;

			} else {
				if (!$metadataForm->validate()) {
					return $metadataForm->display();
				}
				$metadataForm->execute($request);

				// Send a notification to associated users
				import('lib.pkp.classes.notification.NotificationManager');
				$notificationManager = new NotificationManager();
				$notificationUsers = $article->getAssociatedUserIds();
				foreach ($notificationUsers as $userRole) {
					$url = $router->url($request, null, $userRole['role'], 'submission', $article->getId(), null, 'metadata');
					$notificationManager->createNotification($userRole['id'], 'notification.type.metadataModified',
						$article->getProposalId(), $url, 1, NOTIFICATION_TYPE_METADATA_MODIFIED
					);
				}

                                //Added by AIM, Jan 20, 2012
                                $notificationUsers = array();
                                $roleDao =& DAORegistry::getDAO('RoleDAO');
                                $editors = $roleDao->getUsersByRoleId(ROLE_ID_EDITOR);

                                while (!$editors->eof()) {
                                        $editor =& $editors->next();
                                        $notificationUsers[] = array('id' => $editor->getId(), 'role' => $roleDao->getRolePath(ROLE_ID_EDITOR));
                                        unset($editor);
                                }
                                //print_r($notificationUsers); die();
                                foreach ($notificationUsers as $userRole) {
                                        $url = $router->url($request, null, $userRole['role'], 'submission', $article->getId(), null, 'metadata');
                                        $notificationManager->createNotification(
                                                $userRole['id'], 'notification.type.metadataModified',
                                                $article->getProposalId(), $url, 1, NOTIFICATION_TYPE_METADATA_MODIFIED
                                        );
                                }

				// Add log entry
				$user =& $request->getUser();
				import('classes.article.log.ArticleLog');
				import('classes.article.log.ArticleEventLogEntry');
				ArticleLog::logEvent($article->getId(), ARTICLE_LOG_METADATA_UPDATE, ARTICLE_LOG_TYPE_DEFAULT, 0, 'log.editor.metadataModified', Array('editorName' => $user->getFullName()));

				return true;
			}
		}
	}

	/**
	 * Download file.
	 * @param $articleId int
	 * @param $fileId int
	 */
	function downloadFile($articleId, $fileId) {
		import('classes.file.ArticleFileManager');
		$articleFileManager = new ArticleFileManager($articleId);
		return $articleFileManager->downloadFile($fileId);
	}

	/**
	 * View file.
	 * @param $articleId int
	 * @param $fileId int
	 */
	function viewFile($articleId, $fileId) {
		import('classes.file.ArticleFileManager');
		$articleFileManager = new ArticleFileManager($articleId);
		return $articleFileManager->viewFile($fileId);
	}

	/**
	 * Display submission management instructions.
	 * @param $type string the type of instructions (copy, layout, or proof).
	 */
	function instructions($type, $allowed = array('copy', 'layout', 'proof', 'referenceLinking')) {
		$journal =& Request::getJournal();
		$templateMgr =& TemplateManager::getManager();

		if (!HookRegistry::call('Action::instructions', array(&$type, &$allowed))) {
			if (!in_array($type, $allowed)) {
				return false;
			}

			switch ($type) {
				case 'copy':
					$title = 'submission.copyedit.instructions';
					$instructions = $journal->getLocalizedSetting('copyeditInstructions');
					break;
				case 'layout':
					$title = 'submission.layout.instructions';
					$instructions = $journal->getLocalizedSetting('layoutInstructions');
					break;
				case 'proof':
					$title = 'submission.proofread.instructions';
					$instructions = $journal->getLocalizedSetting('proofInstructions');
					break;
				case 'referenceLinking':
					if (!$journal->getSetting('provideRefLinkInstructions')) return false;
					$title = 'submission.layout.referenceLinking';
					$instructions = $journal->getLocalizedSetting('refLinkInstructions');
					break;
				default:
					return false;
			}
		}

		$templateMgr->assign('pageTitle', $title);
		$templateMgr->assign('instructions', $instructions);
		$templateMgr->display('submission/instructions.tpl');

		return true;
	}

	/**
	 * Edit comment.
	 * @param $commentId int
	 */
	function editComment($article, $comment) {
		if (!HookRegistry::call('Action::editComment', array(&$article, &$comment))) {
			import('classes.submission.form.comment.EditCommentForm');

			$commentForm = new EditCommentForm($article, $comment);
			$commentForm->initData();
			$commentForm->display();
		}
	}

	/**
	 * Save comment.
	 * @param $commentId int
	 */
	function saveComment($article, &$comment, $emailComment) {
		if (!HookRegistry::call('Action::saveComment', array(&$article, &$comment, &$emailComment))) {
			import('classes.submission.form.comment.EditCommentForm');

			$commentForm = new EditCommentForm($article, $comment);
			$commentForm->readInputData();

			if ($commentForm->validate()) {
				$commentForm->execute();

				// Send a notification to associated users
				import('lib.pkp.classes.notification.NotificationManager');
				$notificationManager = new NotificationManager();
				$notificationUsers = $article->getAssociatedUserIds(true, false);
				foreach ($notificationUsers as $userRole) {
					$url = Request::url(null, $userRole['role'], 'submission', array($article->getId(),'submissionReview'), null, 'editorDecision');
					$notificationManager->createNotification(
						$userRole['id'], 'notification.type.submissionComment',
						$article->getProposalId(), $url, 1, NOTIFICATION_TYPE_SUBMISSION_COMMENT
					);
				}

				if ($emailComment) {
					$commentForm->email($commentForm->emailHelper());
				}

			} else {
				$commentForm->display();
			}
		}
	}

	/**
	 * Delete comment.
	 * @param $commentId int
	 * @param $user object The user who owns the comment, or null to default to Request::getUser
	 */
	function deleteComment($commentId, $user = null) {
		if ($user == null) $user =& Request::getUser();

		$articleCommentDao =& DAORegistry::getDAO('ArticleCommentDAO');
		$comment =& $articleCommentDao->getArticleCommentById($commentId);

		if ($comment->getAuthorId() == $user->getId()) {
			if (!HookRegistry::call('Action::deleteComment', array(&$comment))) {
				$articleCommentDao->deleteArticleComment($comment);
			}
		}
	}
        
        
        function automaticSummaryInPDF($submission){
            
                $countryDao =& DAORegistry::getDAO('CountryDAO');
                $articleDrugInfoDao =& DAORegistry::getDAO('ArticleDrugInfoDAO');
                $extraFieldDAO =& DAORegistry::getDAO('ExtraFieldDAO');
                    
		$journal =& Request::getJournal();
                
                $submitter =& $submission->getUser();
		$title = $journal->getJournalTitle();
                $articleTexts = $submission->getArticleTexts();
                $articleTextLocales = $journal->getSupportedLocaleNames();
                $secIds = $submission->getArticleSecIds();
                $details = $submission->getArticleDetails();
                $purposes = $submission->getArticlePurposes();                
                $articlePrimaryOutcomes = $submission->getArticleOutcomesByType(ARTICLE_OUTCOME_PRIMARY);
                $articleSecondaryOutcomes = $submission->getArticleOutcomesByType(ARTICLE_OUTCOME_SECONDARY);
                $coutryList = $countryDao->getCountries();                
                $articleDrugs = $submission->getArticleDrugs();
                $pharmaClasses = $articleDrugInfoDao->getPharmaClasses();
                $drugStudyClasses = $articleDrugInfoDao->getClassKeysMap();
                $articleSites = $submission->getArticleSites();
                $expertisesList = $extraFieldDAO->getExtraFieldsList(EXTRA_FIELD_THERAPEUTIC_AREA, EXTRA_FIELD_ACTIVE);
                $fundingSources = $submission->getArticleFundingSources();
                $pSponsor = $submission->getArticlePrimarySponsor();
                $sSponsors = $submission->getArticleSecondarySponsors();
                $CROs = $submission->getArticleCROs();
                $contact = $submission->getArticleContact();                
                    
		Locale::requireComponents(array(LOCALE_COMPONENT_APPLICATION_COMMON, LOCALE_COMPONENT_OJS_EDITOR, LOCALE_COMPONENT_PKP_SUBMISSION, LOCALE_COMPONENT_PKP_USER));
                
                import('classes.lib.tcpdf.pdf');
                import('classes.lib.tcpdf.tcpdf');

                
                $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                                                
                $pdf->SetCreator(PDF_CREATOR);
                
                $pdf->SetAuthor($submitter->getFullName());
                
                $pdf->SetTitle($title);
                
                $subject = $submission->getProposalId().' - '.Locale::translate('submission.summary');
                $pdf->SetSubject($subject);                
                
                $cell_width = 45;
                $cell_height = 6;
                
                // set default header data
                $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 020', PDF_HEADER_STRING);

                // set header and footer fonts
                $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
                $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

                // set default monospaced font
                $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

                // set margins
                $pdf->SetMargins(PDF_MARGIN_LEFT, 58, PDF_MARGIN_RIGHT);
                $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
                $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

                // set auto page breaks
                $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

                // set image scale factor
                $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
                
                $pdf->AddPage();                
                
		// Title
		$pdf->SetFont('Times','B',15);
		$w = $pdf->GetStringWidth($title)+6;
		$pdf->SetX((210-$w)/2);
		$pdf->Cell($w,9,$title,0,1,'C');
                
                // sub-title
		$pdf->SetFont('Times','BI',14);
                $w2 = $pdf->GetStringWidth($subject)+6;
		$pdf->SetX((210-$w2)/2);
		$pdf->Cell($w2,9,$subject,0,1,'C');
                
		// Line break
		$pdf->Ln(10);
                
                // Main Info
		$pdf->SetFont('Times','',12);
                $pdf->MultiRow(50, Locale::translate("common.proposalId"), $submission->getProposalId(), 'L');
                $pdf->MultiRow(50, Locale::translate("article.title"), $submission->getScientificTitle(), 'L');
                $pdf->MultiRow(50, Locale::translate("submission.submitter"), $submitter->getFullName(), 'L');
                $pdf->MultiRow(50, Locale::translate("common.dateSubmitted"), $submission->getDateSubmitted(), 'L');
                
		// Line break
		$pdf->Ln(10);

                //CT Information
		$pdf->SetFont('Times','B',14);
		$pdf->Cell(190,9, 'I'.Locale::translate('common.queue.long.articleDetails', array('id' => '')),0,1,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Times','',12);
                $scientificTitle = null;
                foreach ($articleTexts as $atKey => $articleText) {
                    if (!$scientificTitle) {
                        $pdf->MultiRow(50, Locale::translate("proposal.scientificTitle"), $articleText->getScientificTitle().' ('.$articleTextLocales[$atKey].')', 'L');
                        $scientificTitle = true;
                    } else {
                        $pdf->MultiRow(50, '', $articleText->getScientificTitle().' ('.$articleTextLocales[$atKey].')', 'L');
                    }
                }
                $publicTitle = null;
                foreach ($articleTexts as $atKey => $articleText) {
                    if (!$publicTitle) {
                        $pdf->MultiRow(50, Locale::translate("proposal.publicTitle"), $articleText->getPublicTitle().' ('.$articleTextLocales[$atKey].')', 'L');
                        $publicTitle = true;
                    } else {
                        $pdf->MultiRow(50, '', $articleText->getPublicTitle().' ('.$articleTextLocales[$atKey].')', 'L');
                    }
                }
		$pdf->Ln(3);
                $firstSecId = null;
                foreach ($secIds as $secId) {
                    if (!$firstSecId) {
                        $pdf->MultiRow(50, Locale::translate("proposal.articleSecId"), $secId->getSecId().' ('.Locale::translate($secId->getTypeKey()).')', 'L');
                        $firstSecId = true;
                    } else {
                        $pdf->MultiRow(50, '', $secId->getSecId().' ('.Locale::translate($secId->getTypeKey()).')', 'L');
                    }
                }
		$pdf->Ln(3);
                $pdf->MultiRow(50, Locale::translate("proposal.protocolVersion"), $details->getProtocolVersion(), 'L');
		$pdf->Ln(3);
                $pdf->MultiRow(50, Locale::translate("proposal.therapeuticArea"), $details->getRightTherapeuticAreaDisplay(), 'L');
		$pdf->Ln(3);
                $firstICD10 = null;
                foreach ($details->getHealthCondDiseaseArrayToDisplay() as $healthCond) {
                    $code = $healthCond['code'];
                    $exactCode = $healthCond['exactCode'];
                    if ($exactCode != '') {
                        $code = $code. ' ('.$exactCode.')';
                    }
                    if (!$firstICD10) {
                        $pdf->MultiRow(50, Locale::translate("proposal.icd10s"), $code, 'L');
                        $firstICD10 = true;
                    } else {
                        $pdf->MultiRow(50, '', $code, 'L');
                    }
                }
		$pdf->Ln(3);
                $firstPurpose = null;
                foreach ($purposes as $purpose) {
                    if (!$firstPurpose) {
                        $purposeTitle = Locale::translate("proposal.purposes");
                        $firstPurpose = true;
                    } else {
                        $purposeTitle = '';
                    }
                    if ($purpose->getType() == ARTICLE_PURPOSE_TYPE_OBS) {
                        $pdf->MultiRow(50, $purposeTitle, Locale::translate($purpose->getTypeKey()), 'L');
                    } else {
                        $pdf->MultiRow(50, $purposeTitle, Locale::translate('proposal.purpose.type.int'), 'L');
                        $pdf->MultiRow(50, '', '        '.Locale::translate('proposal.purposes.type').':    '.Locale::translate($purpose->getTypeKey()), 'L');
                        $pdf->MultiRow(50, '', '        '.Locale::translate('proposal.purposes.ctPhase').':    '.Locale::translate($purpose->getCTPhaseKey()), 'L');
                        $pdf->MultiRow(50, '', '        '.Locale::translate('proposal.purposes.studyDesign').', '.Locale::translate('proposal.purposes.allocation').':    '.Locale::translate($purpose->getAllocationKey()), 'L');
                        $pdf->MultiRow(50, '', '                        '.Locale::translate('proposal.purposes.masking').':    '.Locale::translate($purpose->getMaskingKey()), 'L');
                        $pdf->MultiRow(50, '', '                        '.Locale::translate('proposal.purposes.control').':    '.Locale::translate($purpose->getControlKey()), 'L');
                        $pdf->MultiRow(50, '', '                        '.Locale::translate('proposal.purposes.assignment').':    '.Locale::translate($purpose->getAssignmentKey()), 'L');
                        $pdf->MultiRow(50, '', '                        '.Locale::translate('proposal.purposes.endpoint').':    '.Locale::translate($purpose->getEndpointKey()), 'L');
                    }                        
                }
		$pdf->Ln(3);
                $description = null;
                foreach ($articleTexts as $atKey => $articleText) {
                    if (!$description) {
                        $pdf->MultiRow(50, Locale::translate("proposal.description"), $articleText->getDescription().' ('.$articleTextLocales[$atKey].')', 'L');
                        $description = true;
                    } else {
                        $pdf->MultiRow(50, '', $articleText->getDescription().' ('.$articleTextLocales[$atKey].')', 'L');
                    }
                }
		$pdf->Ln(3);
                $kic = null;
                foreach ($articleTexts as $atKey => $articleText) {
                    if (!$kic) {
                        $pdf->MultiRow(50, Locale::translate("proposal.keyInclusionCriteria"), $articleText->getKeyInclusionCriteria().' ('.$articleTextLocales[$atKey].')', 'L');
                        $kic = true;
                    } else {
                        $pdf->MultiRow(50, '', $articleText->getKeyInclusionCriteria().' ('.$articleTextLocales[$atKey].')', 'L');
                    }
                }
		$pdf->Ln(3);
                $kec = null;
                foreach ($articleTexts as $atKey => $articleText) {
                    if (!$kec) {
                        $pdf->MultiRow(50, Locale::translate("proposal.keyExclusionCriteria"), $articleText->getKeyExclusionCriteria().' ('.$articleTextLocales[$atKey].')', 'L');
                        $kec = true;
                    } else {
                        $pdf->MultiRow(50, '', $articleText->getKeyExclusionCriteria().' ('.$articleTextLocales[$atKey].')', 'L');
                    }
                }
		$pdf->Ln(3);                
                $firstPOutcome = null;
                foreach ($articlePrimaryOutcomes as $articleOutcomeLocales) {
                    foreach ($articleOutcomeLocales as $key => $articleOutcome) {
                        if (!$firstPOutcome) {
                            $outcomeTitle = Locale::translate("proposal.primaryOutcomes");
                            $firstPOutcome = true;
                        } else {
                            $outcomeTitle = '';
                        }
                        $pdf->MultiRow(50, $outcomeTitle, $articleOutcome->getName().' ('.$articleTextLocales[$key].')', 'L'); 
                        $pdf->MultiRow(50, '', '        '.Locale::translate('proposal.primaryOutcome.measurement').':        '.$articleOutcome->getMeasurement(), 'L');  
                        $pdf->MultiRow(50, '', '        '.Locale::translate('proposal.primaryOutcome.timepoint').':        '.$articleOutcome->getTimepoint(), 'L');     
                        $pdf->Ln(3);
                    }
                }
                $firstSOutcome = null;
                foreach ($articleSecondaryOutcomes as $articleOutcomeLocales) {
                    foreach ($articleOutcomeLocales as $key => $articleOutcome) {
                        if (!$firstSOutcome) {
                            $sOutcomeTitle = Locale::translate("proposal.secondaryOutcomes");
                            $firstSOutcome = true;
                        } else {
                            $sOutcomeTitle = '';
                        }
                        $pdf->MultiRow(50, $sOutcomeTitle, $articleOutcome->getName().' ('.$articleTextLocales[$key].')', 'L'); 
                        $pdf->MultiRow(50, '', '        '.Locale::translate('proposal.primaryOutcome.measurement').':        '.$articleOutcome->getMeasurement(), 'L');  
                        $pdf->MultiRow(50, '', '        '.Locale::translate('proposal.primaryOutcome.timepoint').':        '.$articleOutcome->getTimepoint(), 'L');     
                        $pdf->Ln(3);
                    }
                }
                $pdf->MultiRow(50, Locale::translate("proposal.age.minimum"), $details->getMinAgeNum().' '.Locale::translate($details->getMinAgeUnitKey()), 'L');
                $pdf->MultiRow(50, Locale::translate("proposal.age.maximum"), $details->getMaxAgeNum().' '.Locale::translate($details->getMaxAgeUnitKey()), 'L');
                $pdf->MultiRow(50, Locale::translate("proposal.sex"), Locale::translate($details->getSexKey()), 'L');
                $pdf->MultiRow(50, Locale::translate("proposal.healthy"), Locale::translate($details->getYesNoKey($details->getHealthy())), 'L');
                $pdf->Ln(3);
                $pdf->MultiRow(50, Locale::translate("proposal.localeSampleSize"), $details->getLocaleSampleSize(), 'L');
                $pdf->MultiRow(50, Locale::translate("proposal.multinational").' '.$journal->getLocalizedSetting('location'), Locale::translate($details->getYesNoKey($details->getMultinational())), 'L');
                if ($details->getMultinational() == ARTICLE_DETAIL_YES) {
                    foreach ($details->getIntSampleSizeArray() as $countryAndNumberArray) {
                        $country = $countryAndNumberArray['country'];
                        $pdf->MultiRow(50, '', '        '.$coutryList[$country].': '.$countryAndNumberArray['number'], 'L');                        
                    }
                }
                $pdf->Ln(3);
                $pdf->MultiRow(50, Locale::translate("proposal.expectedDate"), Locale::translate('proposal.startDate').': '.$details->getStartDate().', '.Locale::translate('proposal.endDate').': '.$details->getEndDate(), 'L');
                $pdf->Ln(3);
                $pdf->MultiRow(50, Locale::translate("proposal.recruitment"), Locale::translate("proposal.recruitment.status").': '.Locale::translate($details->getRecruitmentStatusKey()), 'L');
                $rssi = null;
                foreach ($articleTexts as $atKey => $articleText) {
                    if ($articleText->getRecruitmentInfo() != ''){                        
                        if (!$rssi) {
                            $pdf->MultiRow(50, '', Locale::translate("proposal.recruitment.info").': '.$articleText->getRecruitmentInfo().' ('.$articleTextLocales[$atKey].')', 'L');
                            $rssi = true;
                        } else {
                            $pdf->MultiRow(50, '', $articleText->getRecruitmentInfo().' ('.$articleTextLocales[$atKey].')', 'L');
                        }
                    }
                }
                $pdf->MultiRow(50, '', Locale::translate("proposal.recruitment.adScheme").': '.Locale::translate($details->getYesNoKey($details->getAdvertisingScheme())), 'L');
                  
		// Line break
		$pdf->Ln(10);                
                
                //Drug products
		$pdf->SetFont('Times','B',14);
		$pdf->Cell(190,9, 'II'.Locale::translate('common.queue.long.articleDrugs', array('id' => '')),0,1,'L');
		$pdf->Ln(5);
                foreach ($articleDrugs as $articleDrug) {
                    $pdf->SetFont('Times','BU',12);
                    $pdf->Cell(190,9, $articleDrug->getName(),0,1,'L');
                    $pdf->SetFont('Times','',12);
                    $pdf->Ln(3);
                    $pdf->MultiRow(50, Locale::translate("proposal.drugInfo.type"), Locale::translate($articleDrug->getTypeKey()), 'L');
                    $pdf->MultiRow(50, Locale::translate("proposal.drugInfo.name"), $articleDrug->getName(), 'L');
                    $pdf->MultiRow(50, Locale::translate("proposal.drugInfo.brandName"), $articleDrug->getBrandName(), 'L');
                    if ($articleDrug->getOtherAdministration() == 'NA') {
                        $pdf->MultiRow(50, Locale::translate("proposal.drugInfo.administration"), Locale::translate($articleDrug->getAdministrationKey()), 'L');
                    } else {
                        $pdf->MultiRow(50, Locale::translate("proposal.drugInfo.administration"), $articleDrug->getOtherAdministration(), 'L');
                    }
                    if ($articleDrug->getOtherForm() == 'NA') {
                        $pdf->MultiRow(50, Locale::translate("proposal.drugInfo.form"), Locale::translate($articleDrug->getFormKey()), 'L');
                    } else {
                        $pdf->MultiRow(50, Locale::translate("proposal.drugInfo.form"), $articleDrug->getOtherForm(), 'L');
                    }
                    $pdf->MultiRow(50, Locale::translate("proposal.drugInfo.strength"), $articleDrug->getStrength(), 'L');
                    $pdf->MultiRow(50, Locale::translate("proposal.drugInfo.storage"), Locale::translate($articleDrug->getStorageKey()), 'L');
                    $pdf->MultiRow(50, Locale::translate("proposal.drugInfo.pharmaClass"), $pharmaClasses[$articleDrug->getPharmaClass()], 'L');
                    $firstClass = false;
                    $classIIIOrIV = false;
                    $classesToDisplay = '';
                    foreach ($articleDrug->getClassesArray() as $class){
                        if ($class == ARTICLE_DRUG_INFO_CLASS_III || $class == ARTICLE_DRUG_INFO_CLASS_IV) {
                            $classIIIOrIV = true;
                        }
                        if (!$firstClass) {
                            $classesToDisplay = Locale::translate($drugStudyClasses[$class]);
                        } else {
                            $classesToDisplay = $classesToDisplay.', '.Locale::translate($drugStudyClasses[$class]);
                        }
                        $firstClass = true;
                    }
                    $pdf->MultiRow(50, Locale::translate("proposal.drugInfo.studyClasses"), $classesToDisplay, 'L');
                    if ($classIIIOrIV) {
                        $countriesToDisplay = '';
                        $firstCountry = false;
                        foreach ($articleDrug->getCountriesArray() as $country) {
                            if (!$firstCountry) {
                                $countriesToDisplay = $coutryList[$country];
                            } else {
                                $countriesToDisplay = $countriesToDisplay.', '.$coutryList[$country];
                            }
                            $firstCountry = true;
                        }
                        $pdf->MultiRow(50, '', Locale::translate("proposal.drugInfo.countries").': '.$countriesToDisplay, 'L');
                        $pdf->MultiRow(50, '', Locale::translate("proposal.drugInfo.conditionsOfUse").': '.Locale::translate($articleDrug->getDifferentConditionsOfUseKey()), 'L');
                    }
                    $pdf->MultiRow(50, Locale::translate("proposal.drugInfo.cpr"), Locale::translate($articleDrug->getCPRKey()), 'L');
                    if ($articleDrug->getCPR() == ARTICLE_DRUG_INFO_YES) {
                        $pdf->MultiRow(50, '', Locale::translate("proposal.drugInfo.drugRegistrationNumber").': '.$articleDrug->getDrugRegistrationNumber(), 'L');
                    }
                    if ($articleDrug->getImportedQuantity() != '') {
                        $pdf->MultiRow(50, Locale::translate("proposal.drugInfo.importedQuantity"), $articleDrug->getImportedQuantity(), 'L');
                    }
                    $firstManufacturer = false;
                    foreach ($articleDrug->getManufacturers() as $manufacturer) {
                        $manufacturerTitle = '';
                        if (!$firstManufacturer) {
                            $manufacturerTitle = Locale::translate('proposal.drugInfo.manufacturers');
                        }
                        $pdf->MultiRow(50, $manufacturerTitle, $manufacturer->getName(), 'L');
                        $pdf->MultiRow(50, '', Locale::translate('proposal.drugInfo.manufacturer.address').': '.$manufacturer->getAddress(), 'L');                        
                        $firstManufacturer = true;
                        $pdf->Ln(2);  
                    }
                    $pdf->Ln(3);  
                }
                
		// Line break
		$pdf->Ln(10);   
                
                // Trial Site(s)
		$pdf->SetFont('Times','B',14);
		$pdf->Cell(190,9, 'III'.Locale::translate('common.queue.long.articleSites', array('id' => '')),0,1,'L');
		$pdf->Ln(5);
                foreach ($articleSites as $articleSite) {
                    $trialSiteObject = $articleSite->getTrialSiteObject();    
                    $pdf->SetFont('Times','BU',12);
                    $pdf->Cell(190,9, $trialSiteObject->getName(),0,1,'L');
                    $pdf->SetFont('Times','',12);
                    $pdf->Ln(3);
                    $pdf->MultiRow(50, Locale::translate("proposal.articleSite.site"), $trialSiteObject->getName(), 'L');
                    $pdf->MultiRow(50, '', Locale::translate('proposal.articleSite.siteAddress').': '.$trialSiteObject->getAddress(), 'L');
                    $pdf->MultiRow(50, '', Locale::translate('proposal.articleSite.siteCity').': '.$trialSiteObject->getCity(), 'L');
                    $pdf->MultiRow(50, '', Locale::translate('proposal.articleSite.siteRegion').': '.$trialSiteObject->getRegionText(), 'L');
                    $pdf->MultiRow(50, '', Locale::translate('proposal.articleSite.siteLicensure').': '.$trialSiteObject->getLicensure(), 'L');
                    $pdf->MultiRow(50, '', Locale::translate('proposal.articleSite.siteAccreditation').': '.$trialSiteObject->getAccreditation(), 'L');
                    $pdf->Ln(2);  
                    $pdf->MultiRow(50, Locale::translate("proposal.articleSite.erc"), $articleSite->getERCName(), 'L');
                    $pdf->Ln(2);  
                    $pdf->MultiRow(50, Locale::translate("proposal.articleSite.authority"), $articleSite->getAuthority(), 'L');   
                    $pdf->MultiRow(50, '', Locale::translate('proposal.articleSite.primaryPhone').': '.$articleSite->getPrimaryPhone(), 'L');
                    if ($articleSite->getSecondaryPhone()) {
                        $pdf->MultiRow(50, '', Locale::translate('proposal.articleSite.secondaryPhone').': '.$articleSite->getSecondaryPhone(), 'L');
                    }
                    if ($articleSite->getFax()) {
                        $pdf->MultiRow(50, '', Locale::translate('proposal.articleSite.fax').': '.$articleSite->getFax(), 'L');
                    }
                    $pdf->MultiRow(50, '', Locale::translate('proposal.articleSite.email').': '.$articleSite->getEmail(), 'L');
                    $pdf->Ln(2);  
                    $pdf->MultiRow(50, Locale::translate("proposal.articleSite.subjectsNumber"), $articleSite->getSubjectsNumber(), 'L');
                    $pdf->Ln(2);  
                    $countInvestigators = 1;
                    foreach ($articleSite->getInvestigators() as $investigator) {
                        $investigatorTitle = "";
                        if ($countInvestigators == 1) {
                            $investigatorTitle = Locale::translate('user.role.primaryInvestigator');
                        } elseif ($countInvestigators == 2) {
                            $investigatorTitle = Locale::translate('user.role.coinvestigator');
                        }
                        $pdf->MultiRow(50, $investigatorTitle, $investigator->getFullName(), 'L');
                        $pdf->MultiRow(50, '', Locale::translate('proposal.articleSite.investigator.expertise').': '.$expertisesList[$investigator->getExpertise()], 'L');
                        $pdf->MultiRow(50, '', Locale::translate('proposal.articleSite.investigator.iPrimaryPhone').': '.$investigator->getPrimaryPhoneNumber(), 'L');
                        if ($investigator->getSecondaryPhoneNumber()) {
                            $pdf->MultiRow(50, '', Locale::translate('proposal.articleSite.investigator.iSecondaryPhone').': '.$investigator->getSecondaryPhoneNumber(), 'L');
                        }
                        if ($investigator->getFaxNumber()) {
                            $pdf->MultiRow(50, '', Locale::translate('proposal.articleSite.investigator.iFax').': '.$investigator->getFaxNumber(), 'L');
                        }
                        $pdf->MultiRow(50, '', Locale::translate('proposal.articleSite.investigator.iEmail').': '.$investigator->getEmail(), 'L');
                        $countInvestigators++;
                    }
                    $pdf->Ln(3);  
                }
                
                // Line break
		$pdf->Ln(10);                

                // Sponsors
		$pdf->SetFont('Times','B',14);
		$pdf->Cell(190,9, 'IV'.Locale::translate('common.queue.long.articleSponsors', array('id' => '')),0,1,'L');
		$pdf->Ln(5);
                $pdf->SetFont('Times','',12);
                $firstFSource = false;
                foreach ($fundingSources as $fundingSource) {
                    $fSourceTitle = '';
                    if (!$firstFSource) {
                        $fSourceTitle = Locale::translate('proposal.articleSponsor.fundingSources');
                    }
                    $institution = $fundingSource->getInstitutionObject();
                    $pdf->MultiRow(50, $fSourceTitle, $institution->getInstitutionName(), 'L');
                    $pdf->MultiRow(50, '', '        '.Locale::translate('proposal.articleSponsor.acronym').': '.$institution->getInstitutionAcronym(), 'L');  
                    $pdf->MultiRow(50, '', '        '.Locale::translate('proposal.articleSponsor.type').': '.Locale::translate($institution->getInstitutionTypeKey()), 'L');  
                    $pdf->MultiRow(50, '', '        '.Locale::translate('proposal.articleSponsor.location').': '.$institution->getInstitutionInternationalText(), 'L');  
                    if ($institution->getInstitutionInternational() == INSTITUTION_INTERNATIONAL) {
                        $pdf->MultiRow(50, '', '        '.Locale::translate('proposal.articleSponsor.locationInternational').': '.$institution->getInstitutionLocationText(), 'L');  
                    } else {
                        $pdf->MultiRow(50, '', '        '.Locale::translate('proposal.articleSponsor.locationCountry').': '.$institution->getInstitutionLocationText(), 'L');  
                    }
                    $pdf->Ln(2);
                    $firstFSource = true;
                }
                $pdf->Ln(1);
                $institution = $pSponsor->getInstitutionObject();
                $pdf->MultiRow(50, Locale::translate("proposal.articleSponsor.primarySponsor"), $institution->getInstitutionName(), 'L');   
                $pdf->MultiRow(50, '', '        '.Locale::translate('proposal.articleSponsor.acronym').': '.$institution->getInstitutionAcronym(), 'L');  
                $pdf->MultiRow(50, '', '        '.Locale::translate('proposal.articleSponsor.type').': '.Locale::translate($institution->getInstitutionTypeKey()), 'L');  
                $pdf->MultiRow(50, '', '        '.Locale::translate('proposal.articleSponsor.location').': '.$institution->getInstitutionInternationalText(), 'L');  
                if ($institution->getInstitutionInternational() == INSTITUTION_INTERNATIONAL) {
                    $pdf->MultiRow(50, '', '        '.Locale::translate('proposal.articleSponsor.locationInternational').': '.$institution->getInstitutionLocationText(), 'L');  
                } else {
                    $pdf->MultiRow(50, '', '        '.Locale::translate('proposal.articleSponsor.locationCountry').': '.$institution->getInstitutionLocationText(), 'L');  
                }
                $pdf->Ln(3);
                $firstSSponsor = false;
                foreach ($sSponsors as $sSponsor) {
                    $SSponsorTitle = '';
                    if (!$firstSSponsor) {
                        $SSponsorTitle = Locale::translate('proposal.articleSponsor.secondarySponsors');
                    }
                    $institution = $sSponsor->getInstitutionObject();
                    $pdf->MultiRow(50, $SSponsorTitle, $institution->getInstitutionName(), 'L');
                    $pdf->MultiRow(50, '', '        '.Locale::translate('proposal.articleSponsor.acronym').': '.$institution->getInstitutionAcronym(), 'L');  
                    $pdf->MultiRow(50, '', '        '.Locale::translate('proposal.articleSponsor.type').': '.Locale::translate($institution->getInstitutionTypeKey()), 'L');  
                    $pdf->MultiRow(50, '', '        '.Locale::translate('proposal.articleSponsor.location').': '.$institution->getInstitutionInternationalText(), 'L');  
                    if ($institution->getInstitutionInternational() == INSTITUTION_INTERNATIONAL) {
                        $pdf->MultiRow(50, '', '        '.Locale::translate('proposal.articleSponsor.locationInternational').': '.$institution->getInstitutionLocationText(), 'L');  
                    } else {
                        $pdf->MultiRow(50, '', '        '.Locale::translate('proposal.articleSponsor.locationCountry').': '.$institution->getInstitutionLocationText(), 'L');  
                    }
                    $pdf->Ln(2);
                    $firstSSponsor = true;
                }
                $pdf->Ln(1);
                $pdf->MultiRow(50, Locale::translate("proposal.articleSponsor.croInvolved"), Locale::translate($details->getYesNoKey($details->getCROInvolved())), 'L');  
                foreach ($CROs as $CRO) {
                    $pdf->MultiRow(50, '', $CRO->getName(), 'L'); 
                    $pdf->MultiRow(50, '', Locale::translate('proposal.articleSponsor.cro.location').': '.$CRO->getInternationalText(), 'L');  
                    if ($CRO->getInternational() == CRO_INTERNATIONAL) {
                        $pdf->MultiRow(50, '', Locale::translate('proposal.articleSponsor.locationInternational').': '.$CRO->getLocationText(), 'L');  
                    } else {
                        $pdf->MultiRow(50, '', Locale::translate('proposal.articleSponsor.locationCountry').': '.$CRO->getLocationText(), 'L');  
                    }
                    $pdf->MultiRow(50, '', Locale::translate('proposal.articleSponsor.cro.city').': '.$CRO->getCity(), 'L');   
                    $pdf->MultiRow(50, '', Locale::translate('proposal.articleSponsor.cro.address').': '.$CRO->getAddress(), 'L');   
                    $pdf->MultiRow(50, '', Locale::translate('proposal.articleSponsor.cro.primaryPhone').': '.$CRO->getPrimaryPhone(), 'L');  
                    if ($CRO->getSecondaryPhone()) {
                        $pdf->MultiRow(50, '', Locale::translate('proposal.articleSponsor.cro.secondaryPhone').': '.$CRO->getSecondaryPhone(), 'L');
                    }
                    if ($CRO->getFax()) {
                        $pdf->MultiRow(50, '', Locale::translate('proposal.articleSponsor.cro.fax').': '.$CRO->getFax(), 'L');
                    }
                    $pdf->MultiRow(50, '', Locale::translate('proposal.articleSponsor.cro.email').': '.$CRO->getEmail(), 'L');                       
                    $pdf->Ln(2);
                }
                $pdf->Ln(1);
                
                // Line break
		$pdf->Ln(10);                

                // Contact Information
		$pdf->SetFont('Times','B',14);
		$pdf->Cell(190,9, 'V'.Locale::translate('common.queue.long.articleContact', array('id' => '')),0,1,'L');
		$pdf->Ln(5);
                $pdf->SetFont('Times','',12);
                $pdf->MultiRow(50, Locale::translate("proposal.articleContact.pq"), $contact->getPQName(), 'L');  
                $pdf->MultiRow(50, '', Locale::translate("proposal.articleContact.affiliation").': '.$contact->getPQAffiliation(), 'L');  
                $pdf->MultiRow(50, '', Locale::translate("proposal.articleContact.address").': '.$contact->getPQAddress(), 'L');  
                $pdf->MultiRow(50, '', Locale::translate("proposal.articleContact.country").': '.$coutryList[$contact->getPQCountry()], 'L');  
                $pdf->MultiRow(50, '', Locale::translate("proposal.articleContact.phone").': '.$contact->getPQPhone(), 'L');  
                if ($contact->getPQFax() != '') {
                    $pdf->MultiRow(50, '', Locale::translate("proposal.articleContact.fax").': '.$contact->getPQFax(), 'L');  
                }
                $pdf->MultiRow(50, '', Locale::translate("proposal.articleContact.email").': '.$contact->getPQEmail(), 'L');  
		$pdf->Ln(3);                
                $pdf->MultiRow(50, Locale::translate("proposal.articleContact.sq"), $contact->getSQName(), 'L');  
                $pdf->MultiRow(50, '', Locale::translate("proposal.articleContact.affiliation").': '.$contact->getSQAffiliation(), 'L');  
                $pdf->MultiRow(50, '', Locale::translate("proposal.articleContact.address").': '.$contact->getSQAddress(), 'L');  
                $pdf->MultiRow(50, '', Locale::translate("proposal.articleContact.country").': '.$coutryList[$contact->getSQCountry()], 'L');  
                $pdf->MultiRow(50, '', Locale::translate("proposal.articleContact.phone").': '.$contact->getSQPhone(), 'L');  
                if ($contact->getPQFax() != '') {
                    $pdf->MultiRow(50, '', Locale::translate("proposal.articleContact.fax").': '.$contact->getSQFax(), 'L');  
                }
                $pdf->MultiRow(50, '', Locale::translate("proposal.articleContact.email").': '.$contact->getSQEmail(), 'L');  
                
                $pdf->Output($submission->getProposalId().'-'.Locale::translate('submission.summary').'.pdf',"D");   
        }
        
        
}

?>
