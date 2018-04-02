<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "siax_campanainfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$siax_campana_view = NULL; // Initialize page object first

class csiax_campana_view extends csiax_campana {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{6A9AC718-A824-45A3-BED3-A95E91E6986D}";

	// Table name
	var $TableName = 'siax_campana';

	// Page object name
	var $PageObjName = 'siax_campana_view';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (siax_campana)
		if (!isset($GLOBALS["siax_campana"]) || get_class($GLOBALS["siax_campana"]) == "csiax_campana") {
			$GLOBALS["siax_campana"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["siax_campana"];
		}
		$KeyUrl = "";
		if (@$_GET["id_campana"] <> "") {
			$this->RecKey["id_campana"] = $_GET["id_campana"];
			$KeyUrl .= "&amp;id_campana=" . urlencode($this->RecKey["id_campana"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'siax_campana', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// User table object (usuarios)
		if (!isset($UserTable)) {
			$UserTable = new cusuarios();
			$UserTableConn = Conn($UserTable->DBID);
		}

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (IsPasswordExpired())
			$this->Page_Terminate(ew_GetUrl("changepwd.php"));
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanView()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("siax_campanalist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id_campana->SetVisibility();
		$this->id_campana->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->nombre_campana->SetVisibility();
		$this->descuente_campana->SetVisibility();
		$this->desc_financ_campana->SetVisibility();
		$this->plazo_max_campana->SetVisibility();
		$this->detalle_campana->SetVisibility();
		$this->aplicacion_campana->SetVisibility();
		$this->desde_campana->SetVisibility();
		$this->hasta_campana->SetVisibility();
		$this->vigente_campana->SetVisibility();
		$this->tasa_campana->SetVisibility();
		$this->descuento_fijo_campana->SetVisibility();
		$this->manto_max_campana->SetVisibility();
		$this->condiciones_campana->SetVisibility();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $siax_campana;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($siax_campana);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		 // Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();

			// Handle modal response
			if ($this->IsModal) {
				$row = array();
				$row["url"] = $url;
				echo ew_ArrayToJson(array($row));
			} else {
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 1;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $RecCnt;
	var $RecKey = array();
	var $IsModal = FALSE;
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id_campana"] <> "") {
				$this->id_campana->setQueryStringValue($_GET["id_campana"]);
				$this->RecKey["id_campana"] = $this->id_campana->QueryStringValue;
			} elseif (@$_POST["id_campana"] <> "") {
				$this->id_campana->setFormValue($_POST["id_campana"]);
				$this->RecKey["id_campana"] = $this->id_campana->FormValue;
			} else {
				$bLoadCurrentRecord = TRUE;
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					$this->StartRec = 1; // Initialize start position
					if ($this->Recordset = $this->LoadRecordset()) // Load records
						$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
					if ($this->TotalRecs <= 0) { // No record found
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$this->Page_Terminate("siax_campanalist.php"); // Return to list page
					} elseif ($bLoadCurrentRecord) { // Load current record position
						$this->SetUpStartRec(); // Set up start record position

						// Point to current record
						if (intval($this->StartRec) <= intval($this->TotalRecs)) {
							$bMatchRecord = TRUE;
							$this->Recordset->Move($this->StartRec-1);
						}
					} else { // Match key values
						while (!$this->Recordset->EOF) {
							if (strval($this->id_campana->CurrentValue) == strval($this->Recordset->fields('id_campana'))) {
								$this->setStartRecordNumber($this->StartRec); // Save record position
								$bMatchRecord = TRUE;
								break;
							} else {
								$this->StartRec++;
								$this->Recordset->MoveNext();
							}
						}
					}
					if (!$bMatchRecord) {
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "siax_campanalist.php"; // No matching record, return to list
					} else {
						$this->LoadRowValues($this->Recordset); // Load row values
					}
			}
		} else {
			$sReturnUrl = "siax_campanalist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("ViewPageAddLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->AddUrl) . "',caption:'" . $addcaption . "'});\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());

		// Edit
		$item = &$option->Add("edit");
		$editcaption = ew_HtmlTitle($Language->Phrase("ViewPageEditLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->EditUrl) . "',caption:'" . $editcaption . "'});\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "" && $Security->CanEdit());

		// Copy
		$item = &$option->Add("copy");
		$copycaption = ew_HtmlTitle($Language->Phrase("ViewPageCopyLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->CopyUrl) . "',caption:'" . $copycaption . "'});\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		$item->Visible = ($this->CopyUrl <> "" && $Security->CanAdd());

		// Delete
		$item = &$option->Add("delete");
		if ($this->IsModal) // Handle as inline delete
			$item->Body = "<a onclick=\"return ew_ConfirmDelete(this);\" class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode(ew_AddQueryStringToUrl($this->DeleteUrl, "a_delete=1")) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "" && $Security->CanDelete());

		// Set up action default
		$option = &$options["action"];
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
		$option->UseImageAndText = TRUE;
		$option->UseDropDownButton = FALSE;
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->SelectSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->id_campana->setDbValue($rs->fields('id_campana'));
		$this->nombre_campana->setDbValue($rs->fields('nombre_campana'));
		$this->descuente_campana->setDbValue($rs->fields('descuente_campana'));
		$this->desc_financ_campana->setDbValue($rs->fields('desc_financ_campana'));
		$this->plazo_max_campana->setDbValue($rs->fields('plazo_max_campana'));
		$this->detalle_campana->setDbValue($rs->fields('detalle_campana'));
		$this->aplicacion_campana->setDbValue($rs->fields('aplicacion_campana'));
		$this->desde_campana->setDbValue($rs->fields('desde_campana'));
		$this->hasta_campana->setDbValue($rs->fields('hasta_campana'));
		$this->vigente_campana->setDbValue($rs->fields('vigente_campana'));
		$this->tasa_campana->setDbValue($rs->fields('tasa_campana'));
		$this->descuento_fijo_campana->setDbValue($rs->fields('descuento_fijo_campana'));
		$this->manto_max_campana->setDbValue($rs->fields('manto_max_campana'));
		$this->condiciones_campana->setDbValue($rs->fields('condiciones_campana'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id_campana->DbValue = $row['id_campana'];
		$this->nombre_campana->DbValue = $row['nombre_campana'];
		$this->descuente_campana->DbValue = $row['descuente_campana'];
		$this->desc_financ_campana->DbValue = $row['desc_financ_campana'];
		$this->plazo_max_campana->DbValue = $row['plazo_max_campana'];
		$this->detalle_campana->DbValue = $row['detalle_campana'];
		$this->aplicacion_campana->DbValue = $row['aplicacion_campana'];
		$this->desde_campana->DbValue = $row['desde_campana'];
		$this->hasta_campana->DbValue = $row['hasta_campana'];
		$this->vigente_campana->DbValue = $row['vigente_campana'];
		$this->tasa_campana->DbValue = $row['tasa_campana'];
		$this->descuento_fijo_campana->DbValue = $row['descuento_fijo_campana'];
		$this->manto_max_campana->DbValue = $row['manto_max_campana'];
		$this->condiciones_campana->DbValue = $row['condiciones_campana'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

		// Convert decimal values if posted back
		if ($this->descuente_campana->FormValue == $this->descuente_campana->CurrentValue && is_numeric(ew_StrToFloat($this->descuente_campana->CurrentValue)))
			$this->descuente_campana->CurrentValue = ew_StrToFloat($this->descuente_campana->CurrentValue);

		// Convert decimal values if posted back
		if ($this->desc_financ_campana->FormValue == $this->desc_financ_campana->CurrentValue && is_numeric(ew_StrToFloat($this->desc_financ_campana->CurrentValue)))
			$this->desc_financ_campana->CurrentValue = ew_StrToFloat($this->desc_financ_campana->CurrentValue);

		// Convert decimal values if posted back
		if ($this->tasa_campana->FormValue == $this->tasa_campana->CurrentValue && is_numeric(ew_StrToFloat($this->tasa_campana->CurrentValue)))
			$this->tasa_campana->CurrentValue = ew_StrToFloat($this->tasa_campana->CurrentValue);

		// Convert decimal values if posted back
		if ($this->descuento_fijo_campana->FormValue == $this->descuento_fijo_campana->CurrentValue && is_numeric(ew_StrToFloat($this->descuento_fijo_campana->CurrentValue)))
			$this->descuento_fijo_campana->CurrentValue = ew_StrToFloat($this->descuento_fijo_campana->CurrentValue);

		// Convert decimal values if posted back
		if ($this->manto_max_campana->FormValue == $this->manto_max_campana->CurrentValue && is_numeric(ew_StrToFloat($this->manto_max_campana->CurrentValue)))
			$this->manto_max_campana->CurrentValue = ew_StrToFloat($this->manto_max_campana->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id_campana
		// nombre_campana
		// descuente_campana
		// desc_financ_campana
		// plazo_max_campana
		// detalle_campana
		// aplicacion_campana
		// desde_campana
		// hasta_campana
		// vigente_campana
		// tasa_campana
		// descuento_fijo_campana
		// manto_max_campana
		// condiciones_campana

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id_campana
		$this->id_campana->ViewValue = $this->id_campana->CurrentValue;
		$this->id_campana->ViewCustomAttributes = "";

		// nombre_campana
		$this->nombre_campana->ViewValue = $this->nombre_campana->CurrentValue;
		$this->nombre_campana->ViewCustomAttributes = "";

		// descuente_campana
		$this->descuente_campana->ViewValue = $this->descuente_campana->CurrentValue;
		$this->descuente_campana->ViewCustomAttributes = "";

		// desc_financ_campana
		$this->desc_financ_campana->ViewValue = $this->desc_financ_campana->CurrentValue;
		$this->desc_financ_campana->ViewCustomAttributes = "";

		// plazo_max_campana
		$this->plazo_max_campana->ViewValue = $this->plazo_max_campana->CurrentValue;
		$this->plazo_max_campana->ViewCustomAttributes = "";

		// detalle_campana
		$this->detalle_campana->ViewValue = $this->detalle_campana->CurrentValue;
		$this->detalle_campana->ViewCustomAttributes = "";

		// aplicacion_campana
		$this->aplicacion_campana->ViewValue = $this->aplicacion_campana->CurrentValue;
		$this->aplicacion_campana->ViewCustomAttributes = "";

		// desde_campana
		$this->desde_campana->ViewValue = $this->desde_campana->CurrentValue;
		$this->desde_campana->ViewValue = ew_FormatDateTime($this->desde_campana->ViewValue, 0);
		$this->desde_campana->ViewCustomAttributes = "";

		// hasta_campana
		$this->hasta_campana->ViewValue = $this->hasta_campana->CurrentValue;
		$this->hasta_campana->ViewValue = ew_FormatDateTime($this->hasta_campana->ViewValue, 0);
		$this->hasta_campana->ViewCustomAttributes = "";

		// vigente_campana
		$this->vigente_campana->ViewValue = $this->vigente_campana->CurrentValue;
		$this->vigente_campana->ViewCustomAttributes = "";

		// tasa_campana
		$this->tasa_campana->ViewValue = $this->tasa_campana->CurrentValue;
		$this->tasa_campana->ViewCustomAttributes = "";

		// descuento_fijo_campana
		$this->descuento_fijo_campana->ViewValue = $this->descuento_fijo_campana->CurrentValue;
		$this->descuento_fijo_campana->ViewCustomAttributes = "";

		// manto_max_campana
		$this->manto_max_campana->ViewValue = $this->manto_max_campana->CurrentValue;
		$this->manto_max_campana->ViewCustomAttributes = "";

		// condiciones_campana
		$this->condiciones_campana->ViewValue = $this->condiciones_campana->CurrentValue;
		$this->condiciones_campana->ViewCustomAttributes = "";

			// id_campana
			$this->id_campana->LinkCustomAttributes = "";
			$this->id_campana->HrefValue = "";
			$this->id_campana->TooltipValue = "";

			// nombre_campana
			$this->nombre_campana->LinkCustomAttributes = "";
			$this->nombre_campana->HrefValue = "";
			$this->nombre_campana->TooltipValue = "";

			// descuente_campana
			$this->descuente_campana->LinkCustomAttributes = "";
			$this->descuente_campana->HrefValue = "";
			$this->descuente_campana->TooltipValue = "";

			// desc_financ_campana
			$this->desc_financ_campana->LinkCustomAttributes = "";
			$this->desc_financ_campana->HrefValue = "";
			$this->desc_financ_campana->TooltipValue = "";

			// plazo_max_campana
			$this->plazo_max_campana->LinkCustomAttributes = "";
			$this->plazo_max_campana->HrefValue = "";
			$this->plazo_max_campana->TooltipValue = "";

			// detalle_campana
			$this->detalle_campana->LinkCustomAttributes = "";
			$this->detalle_campana->HrefValue = "";
			$this->detalle_campana->TooltipValue = "";

			// aplicacion_campana
			$this->aplicacion_campana->LinkCustomAttributes = "";
			$this->aplicacion_campana->HrefValue = "";
			$this->aplicacion_campana->TooltipValue = "";

			// desde_campana
			$this->desde_campana->LinkCustomAttributes = "";
			$this->desde_campana->HrefValue = "";
			$this->desde_campana->TooltipValue = "";

			// hasta_campana
			$this->hasta_campana->LinkCustomAttributes = "";
			$this->hasta_campana->HrefValue = "";
			$this->hasta_campana->TooltipValue = "";

			// vigente_campana
			$this->vigente_campana->LinkCustomAttributes = "";
			$this->vigente_campana->HrefValue = "";
			$this->vigente_campana->TooltipValue = "";

			// tasa_campana
			$this->tasa_campana->LinkCustomAttributes = "";
			$this->tasa_campana->HrefValue = "";
			$this->tasa_campana->TooltipValue = "";

			// descuento_fijo_campana
			$this->descuento_fijo_campana->LinkCustomAttributes = "";
			$this->descuento_fijo_campana->HrefValue = "";
			$this->descuento_fijo_campana->TooltipValue = "";

			// manto_max_campana
			$this->manto_max_campana->LinkCustomAttributes = "";
			$this->manto_max_campana->HrefValue = "";
			$this->manto_max_campana->TooltipValue = "";

			// condiciones_campana
			$this->condiciones_campana->LinkCustomAttributes = "";
			$this->condiciones_campana->HrefValue = "";
			$this->condiciones_campana->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("siax_campanalist.php"), "", $this->TableVar, TRUE);
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

		//$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($siax_campana_view)) $siax_campana_view = new csiax_campana_view();

// Page init
$siax_campana_view->Page_Init();

// Page main
$siax_campana_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$siax_campana_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fsiax_campanaview = new ew_Form("fsiax_campanaview", "view");

// Form_CustomValidate event
fsiax_campanaview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fsiax_campanaview.ValidateRequired = true;
<?php } else { ?>
fsiax_campanaview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php if (!$siax_campana_view->IsModal) { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php $siax_campana_view->ExportOptions->Render("body") ?>
<?php
	foreach ($siax_campana_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$siax_campana_view->IsModal) { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php $siax_campana_view->ShowPageHeader(); ?>
<?php
$siax_campana_view->ShowMessage();
?>
<form name="fsiax_campanaview" id="fsiax_campanaview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($siax_campana_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $siax_campana_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="siax_campana">
<?php if ($siax_campana_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($siax_campana->id_campana->Visible) { // id_campana ?>
	<tr id="r_id_campana">
		<td><span id="elh_siax_campana_id_campana"><?php echo $siax_campana->id_campana->FldCaption() ?></span></td>
		<td data-name="id_campana"<?php echo $siax_campana->id_campana->CellAttributes() ?>>
<span id="el_siax_campana_id_campana">
<span<?php echo $siax_campana->id_campana->ViewAttributes() ?>>
<?php echo $siax_campana->id_campana->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($siax_campana->nombre_campana->Visible) { // nombre_campana ?>
	<tr id="r_nombre_campana">
		<td><span id="elh_siax_campana_nombre_campana"><?php echo $siax_campana->nombre_campana->FldCaption() ?></span></td>
		<td data-name="nombre_campana"<?php echo $siax_campana->nombre_campana->CellAttributes() ?>>
<span id="el_siax_campana_nombre_campana">
<span<?php echo $siax_campana->nombre_campana->ViewAttributes() ?>>
<?php echo $siax_campana->nombre_campana->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($siax_campana->descuente_campana->Visible) { // descuente_campana ?>
	<tr id="r_descuente_campana">
		<td><span id="elh_siax_campana_descuente_campana"><?php echo $siax_campana->descuente_campana->FldCaption() ?></span></td>
		<td data-name="descuente_campana"<?php echo $siax_campana->descuente_campana->CellAttributes() ?>>
<span id="el_siax_campana_descuente_campana">
<span<?php echo $siax_campana->descuente_campana->ViewAttributes() ?>>
<?php echo $siax_campana->descuente_campana->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($siax_campana->desc_financ_campana->Visible) { // desc_financ_campana ?>
	<tr id="r_desc_financ_campana">
		<td><span id="elh_siax_campana_desc_financ_campana"><?php echo $siax_campana->desc_financ_campana->FldCaption() ?></span></td>
		<td data-name="desc_financ_campana"<?php echo $siax_campana->desc_financ_campana->CellAttributes() ?>>
<span id="el_siax_campana_desc_financ_campana">
<span<?php echo $siax_campana->desc_financ_campana->ViewAttributes() ?>>
<?php echo $siax_campana->desc_financ_campana->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($siax_campana->plazo_max_campana->Visible) { // plazo_max_campana ?>
	<tr id="r_plazo_max_campana">
		<td><span id="elh_siax_campana_plazo_max_campana"><?php echo $siax_campana->plazo_max_campana->FldCaption() ?></span></td>
		<td data-name="plazo_max_campana"<?php echo $siax_campana->plazo_max_campana->CellAttributes() ?>>
<span id="el_siax_campana_plazo_max_campana">
<span<?php echo $siax_campana->plazo_max_campana->ViewAttributes() ?>>
<?php echo $siax_campana->plazo_max_campana->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($siax_campana->detalle_campana->Visible) { // detalle_campana ?>
	<tr id="r_detalle_campana">
		<td><span id="elh_siax_campana_detalle_campana"><?php echo $siax_campana->detalle_campana->FldCaption() ?></span></td>
		<td data-name="detalle_campana"<?php echo $siax_campana->detalle_campana->CellAttributes() ?>>
<span id="el_siax_campana_detalle_campana">
<span<?php echo $siax_campana->detalle_campana->ViewAttributes() ?>>
<?php echo $siax_campana->detalle_campana->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($siax_campana->aplicacion_campana->Visible) { // aplicacion_campana ?>
	<tr id="r_aplicacion_campana">
		<td><span id="elh_siax_campana_aplicacion_campana"><?php echo $siax_campana->aplicacion_campana->FldCaption() ?></span></td>
		<td data-name="aplicacion_campana"<?php echo $siax_campana->aplicacion_campana->CellAttributes() ?>>
<span id="el_siax_campana_aplicacion_campana">
<span<?php echo $siax_campana->aplicacion_campana->ViewAttributes() ?>>
<?php echo $siax_campana->aplicacion_campana->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($siax_campana->desde_campana->Visible) { // desde_campana ?>
	<tr id="r_desde_campana">
		<td><span id="elh_siax_campana_desde_campana"><?php echo $siax_campana->desde_campana->FldCaption() ?></span></td>
		<td data-name="desde_campana"<?php echo $siax_campana->desde_campana->CellAttributes() ?>>
<span id="el_siax_campana_desde_campana">
<span<?php echo $siax_campana->desde_campana->ViewAttributes() ?>>
<?php echo $siax_campana->desde_campana->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($siax_campana->hasta_campana->Visible) { // hasta_campana ?>
	<tr id="r_hasta_campana">
		<td><span id="elh_siax_campana_hasta_campana"><?php echo $siax_campana->hasta_campana->FldCaption() ?></span></td>
		<td data-name="hasta_campana"<?php echo $siax_campana->hasta_campana->CellAttributes() ?>>
<span id="el_siax_campana_hasta_campana">
<span<?php echo $siax_campana->hasta_campana->ViewAttributes() ?>>
<?php echo $siax_campana->hasta_campana->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($siax_campana->vigente_campana->Visible) { // vigente_campana ?>
	<tr id="r_vigente_campana">
		<td><span id="elh_siax_campana_vigente_campana"><?php echo $siax_campana->vigente_campana->FldCaption() ?></span></td>
		<td data-name="vigente_campana"<?php echo $siax_campana->vigente_campana->CellAttributes() ?>>
<span id="el_siax_campana_vigente_campana">
<span<?php echo $siax_campana->vigente_campana->ViewAttributes() ?>>
<?php echo $siax_campana->vigente_campana->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($siax_campana->tasa_campana->Visible) { // tasa_campana ?>
	<tr id="r_tasa_campana">
		<td><span id="elh_siax_campana_tasa_campana"><?php echo $siax_campana->tasa_campana->FldCaption() ?></span></td>
		<td data-name="tasa_campana"<?php echo $siax_campana->tasa_campana->CellAttributes() ?>>
<span id="el_siax_campana_tasa_campana">
<span<?php echo $siax_campana->tasa_campana->ViewAttributes() ?>>
<?php echo $siax_campana->tasa_campana->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($siax_campana->descuento_fijo_campana->Visible) { // descuento_fijo_campana ?>
	<tr id="r_descuento_fijo_campana">
		<td><span id="elh_siax_campana_descuento_fijo_campana"><?php echo $siax_campana->descuento_fijo_campana->FldCaption() ?></span></td>
		<td data-name="descuento_fijo_campana"<?php echo $siax_campana->descuento_fijo_campana->CellAttributes() ?>>
<span id="el_siax_campana_descuento_fijo_campana">
<span<?php echo $siax_campana->descuento_fijo_campana->ViewAttributes() ?>>
<?php echo $siax_campana->descuento_fijo_campana->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($siax_campana->manto_max_campana->Visible) { // manto_max_campana ?>
	<tr id="r_manto_max_campana">
		<td><span id="elh_siax_campana_manto_max_campana"><?php echo $siax_campana->manto_max_campana->FldCaption() ?></span></td>
		<td data-name="manto_max_campana"<?php echo $siax_campana->manto_max_campana->CellAttributes() ?>>
<span id="el_siax_campana_manto_max_campana">
<span<?php echo $siax_campana->manto_max_campana->ViewAttributes() ?>>
<?php echo $siax_campana->manto_max_campana->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($siax_campana->condiciones_campana->Visible) { // condiciones_campana ?>
	<tr id="r_condiciones_campana">
		<td><span id="elh_siax_campana_condiciones_campana"><?php echo $siax_campana->condiciones_campana->FldCaption() ?></span></td>
		<td data-name="condiciones_campana"<?php echo $siax_campana->condiciones_campana->CellAttributes() ?>>
<span id="el_siax_campana_condiciones_campana">
<span<?php echo $siax_campana->condiciones_campana->ViewAttributes() ?>>
<?php echo $siax_campana->condiciones_campana->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if (!$siax_campana_view->IsModal) { ?>
<?php if (!isset($siax_campana_view->Pager)) $siax_campana_view->Pager = new cPrevNextPager($siax_campana_view->StartRec, $siax_campana_view->DisplayRecs, $siax_campana_view->TotalRecs) ?>
<?php if ($siax_campana_view->Pager->RecordCount > 0 && $siax_campana_view->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($siax_campana_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $siax_campana_view->PageUrl() ?>start=<?php echo $siax_campana_view->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($siax_campana_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $siax_campana_view->PageUrl() ?>start=<?php echo $siax_campana_view->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $siax_campana_view->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($siax_campana_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $siax_campana_view->PageUrl() ?>start=<?php echo $siax_campana_view->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($siax_campana_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $siax_campana_view->PageUrl() ?>start=<?php echo $siax_campana_view->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $siax_campana_view->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<script type="text/javascript">
fsiax_campanaview.Init();
</script>
<?php
$siax_campana_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$siax_campana_view->Page_Terminate();
?>
