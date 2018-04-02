<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "ap_solicitudinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$ap_solicitud_view = NULL; // Initialize page object first

class cap_solicitud_view extends cap_solicitud {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{6A9AC718-A824-45A3-BED3-A95E91E6986D}";

	// Table name
	var $TableName = 'ap_solicitud';

	// Page object name
	var $PageObjName = 'ap_solicitud_view';

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

		// Table object (ap_solicitud)
		if (!isset($GLOBALS["ap_solicitud"]) || get_class($GLOBALS["ap_solicitud"]) == "cap_solicitud") {
			$GLOBALS["ap_solicitud"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ap_solicitud"];
		}
		$KeyUrl = "";
		if (@$_GET["id_sol"] <> "") {
			$this->RecKey["id_sol"] = $_GET["id_sol"];
			$KeyUrl .= "&amp;id_sol=" . urlencode($this->RecKey["id_sol"]);
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
			define("EW_TABLE_NAME", 'ap_solicitud', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("ap_solicitudlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}

		// Get export parameters
		$custom = "";
		if (@$_GET["export"] <> "") {
			$this->Export = $_GET["export"];
			$custom = @$_GET["custom"];
		} elseif (@$_POST["export"] <> "") {
			$this->Export = $_POST["export"];
			$custom = @$_POST["custom"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$this->Export = $_POST["exporttype"];
			$custom = @$_POST["custom"];
		} else {
			$this->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExportFile = $this->TableVar; // Get export file, used in header
		if (@$_GET["id_sol"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["id_sol"]);
		}

		// Get custom export parameters
		if ($this->Export <> "" && $custom <> "") {
			$this->CustomExport = $this->Export;
			$this->Export = "print";
		}
		$gsCustomExport = $this->CustomExport;
		$gsExport = $this->Export; // Get export parameter, used in header

		// Update Export URLs
		if (defined("EW_USE_PHPEXCEL"))
			$this->ExportExcelCustom = FALSE;
		if ($this->ExportExcelCustom)
			$this->ExportExcelUrl .= "&amp;custom=1";
		if (defined("EW_USE_PHPWORD"))
			$this->ExportWordCustom = FALSE;
		if ($this->ExportWordCustom)
			$this->ExportWordUrl .= "&amp;custom=1";
		if ($this->ExportPdfCustom)
			$this->ExportPdfUrl .= "&amp;custom=1";
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Setup export options
		$this->SetupExportOptions();
		$this->id_sol->SetVisibility();
		$this->id_sol->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->poliza_sol->SetVisibility();
		$this->demanda_sol->SetVisibility();
		$this->asesor_sol->SetVisibility();
		$this->asignacion_sol->SetVisibility();
		$this->cedula_sol->SetVisibility();
		$this->nombre_sol->SetVisibility();
		$this->direccion_pol_sol->SetVisibility();
		$this->direccion_nueva_sol->SetVisibility();
		$this->localidad_sol->SetVisibility();
		$this->barrio_sol->SetVisibility();
		$this->telefono1_sol->SetVisibility();
		$this->telefono2_sol->SetVisibility();
		$this->celular_sol->SetVisibility();
		$this->servicio_sol->SetVisibility();
		$this->obs_sol->SetVisibility();
		$this->estado_sol->SetVisibility();
		$this->fecha_prevista_sol->SetVisibility();
		$this->fecha_obra_sol->SetVisibility();
		$this->fecha_visita_comerc_sol->SetVisibility();
		$this->obs_estado_sol->SetVisibility();

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
		global $EW_EXPORT, $ap_solicitud;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($ap_solicitud);
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
			if (@$_GET["id_sol"] <> "") {
				$this->id_sol->setQueryStringValue($_GET["id_sol"]);
				$this->RecKey["id_sol"] = $this->id_sol->QueryStringValue;
			} elseif (@$_POST["id_sol"] <> "") {
				$this->id_sol->setFormValue($_POST["id_sol"]);
				$this->RecKey["id_sol"] = $this->id_sol->FormValue;
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
						$this->Page_Terminate("ap_solicitudlist.php"); // Return to list page
					} elseif ($bLoadCurrentRecord) { // Load current record position
						$this->SetUpStartRec(); // Set up start record position

						// Point to current record
						if (intval($this->StartRec) <= intval($this->TotalRecs)) {
							$bMatchRecord = TRUE;
							$this->Recordset->Move($this->StartRec-1);
						}
					} else { // Match key values
						while (!$this->Recordset->EOF) {
							if (strval($this->id_sol->CurrentValue) == strval($this->Recordset->fields('id_sol'))) {
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
						$sReturnUrl = "ap_solicitudlist.php"; // No matching record, return to list
					} else {
						$this->LoadRowValues($this->Recordset); // Load row values
					}
			}

			// Export data only
			if ($this->CustomExport == "" && in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
				$this->ExportData();
				$this->Page_Terminate(); // Terminate response
				exit();
			}
		} else {
			$sReturnUrl = "ap_solicitudlist.php"; // Not page request, return to list
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
		$this->id_sol->setDbValue($rs->fields('id_sol'));
		$this->poliza_sol->setDbValue($rs->fields('poliza_sol'));
		$this->demanda_sol->setDbValue($rs->fields('demanda_sol'));
		$this->asesor_sol->setDbValue($rs->fields('asesor_sol'));
		$this->archivos_sol->setDbValue($rs->fields('archivos_sol'));
		$this->asignacion_sol->setDbValue($rs->fields('asignacion_sol'));
		$this->comis_gas_sol->setDbValue($rs->fields('comis_gas_sol'));
		$this->comis_obra_sol->setDbValue($rs->fields('comis_obra_sol'));
		$this->comis_fija_sol->setDbValue($rs->fields('comis_fija_sol'));
		$this->cedula_sol->setDbValue($rs->fields('cedula_sol'));
		$this->nombre_sol->setDbValue($rs->fields('nombre_sol'));
		$this->direccion_pol_sol->setDbValue($rs->fields('direccion_pol_sol'));
		$this->direccion_nueva_sol->setDbValue($rs->fields('direccion_nueva_sol'));
		$this->localidad_sol->setDbValue($rs->fields('localidad_sol'));
		$this->barrio_sol->setDbValue($rs->fields('barrio_sol'));
		$this->telefono1_sol->setDbValue($rs->fields('telefono1_sol'));
		$this->telefono2_sol->setDbValue($rs->fields('telefono2_sol'));
		$this->celular_sol->setDbValue($rs->fields('celular_sol'));
		$this->email_sol->setDbValue($rs->fields('email_sol'));
		$this->servicio_sol->setDbValue($rs->fields('servicio_sol'));
		$this->texto_sol->setDbValue($rs->fields('texto_sol'));
		$this->registra_sol->setDbValue($rs->fields('registra_sol'));
		$this->tipo_clientegn_sol->setDbValue($rs->fields('tipo_clientegn_sol'));
		$this->unidad_sol->setDbValue($rs->fields('unidad_sol'));
		$this->fecha_reg_sol->setDbValue($rs->fields('fecha_reg_sol'));
		$this->obs_sol->setDbValue($rs->fields('obs_sol'));
		$this->empresa_sol->setDbValue($rs->fields('empresa_sol'));
		$this->estado_sol->setDbValue($rs->fields('estado_sol'));
		$this->fecha_prevista_sol->setDbValue($rs->fields('fecha_prevista_sol'));
		$this->user_preventa_sol->setDbValue($rs->fields('user_preventa_sol'));
		$this->quincena_obra_sol->setDbValue($rs->fields('quincena_obra_sol'));
		$this->fecha_obra_sol->setDbValue($rs->fields('fecha_obra_sol'));
		$this->nombre_tecnico_sol->setDbValue($rs->fields('nombre_tecnico_sol'));
		$this->cod_tecnico_sol->setDbValue($rs->fields('cod_tecnico_sol'));
		$this->lider_obra_sol->setDbValue($rs->fields('lider_obra_sol'));
		$this->fecha_visita_comerc_sol->setDbValue($rs->fields('fecha_visita_comerc_sol'));
		$this->obs_estado_sol->setDbValue($rs->fields('obs_estado_sol'));
		$this->forma_pagogn_sol->setDbValue($rs->fields('forma_pagogn_sol'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id_sol->DbValue = $row['id_sol'];
		$this->poliza_sol->DbValue = $row['poliza_sol'];
		$this->demanda_sol->DbValue = $row['demanda_sol'];
		$this->asesor_sol->DbValue = $row['asesor_sol'];
		$this->archivos_sol->DbValue = $row['archivos_sol'];
		$this->asignacion_sol->DbValue = $row['asignacion_sol'];
		$this->comis_gas_sol->DbValue = $row['comis_gas_sol'];
		$this->comis_obra_sol->DbValue = $row['comis_obra_sol'];
		$this->comis_fija_sol->DbValue = $row['comis_fija_sol'];
		$this->cedula_sol->DbValue = $row['cedula_sol'];
		$this->nombre_sol->DbValue = $row['nombre_sol'];
		$this->direccion_pol_sol->DbValue = $row['direccion_pol_sol'];
		$this->direccion_nueva_sol->DbValue = $row['direccion_nueva_sol'];
		$this->localidad_sol->DbValue = $row['localidad_sol'];
		$this->barrio_sol->DbValue = $row['barrio_sol'];
		$this->telefono1_sol->DbValue = $row['telefono1_sol'];
		$this->telefono2_sol->DbValue = $row['telefono2_sol'];
		$this->celular_sol->DbValue = $row['celular_sol'];
		$this->email_sol->DbValue = $row['email_sol'];
		$this->servicio_sol->DbValue = $row['servicio_sol'];
		$this->texto_sol->DbValue = $row['texto_sol'];
		$this->registra_sol->DbValue = $row['registra_sol'];
		$this->tipo_clientegn_sol->DbValue = $row['tipo_clientegn_sol'];
		$this->unidad_sol->DbValue = $row['unidad_sol'];
		$this->fecha_reg_sol->DbValue = $row['fecha_reg_sol'];
		$this->obs_sol->DbValue = $row['obs_sol'];
		$this->empresa_sol->DbValue = $row['empresa_sol'];
		$this->estado_sol->DbValue = $row['estado_sol'];
		$this->fecha_prevista_sol->DbValue = $row['fecha_prevista_sol'];
		$this->user_preventa_sol->DbValue = $row['user_preventa_sol'];
		$this->quincena_obra_sol->DbValue = $row['quincena_obra_sol'];
		$this->fecha_obra_sol->DbValue = $row['fecha_obra_sol'];
		$this->nombre_tecnico_sol->DbValue = $row['nombre_tecnico_sol'];
		$this->cod_tecnico_sol->DbValue = $row['cod_tecnico_sol'];
		$this->lider_obra_sol->DbValue = $row['lider_obra_sol'];
		$this->fecha_visita_comerc_sol->DbValue = $row['fecha_visita_comerc_sol'];
		$this->obs_estado_sol->DbValue = $row['obs_estado_sol'];
		$this->forma_pagogn_sol->DbValue = $row['forma_pagogn_sol'];
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
		if ($this->poliza_sol->FormValue == $this->poliza_sol->CurrentValue && is_numeric(ew_StrToFloat($this->poliza_sol->CurrentValue)))
			$this->poliza_sol->CurrentValue = ew_StrToFloat($this->poliza_sol->CurrentValue);

		// Convert decimal values if posted back
		if ($this->demanda_sol->FormValue == $this->demanda_sol->CurrentValue && is_numeric(ew_StrToFloat($this->demanda_sol->CurrentValue)))
			$this->demanda_sol->CurrentValue = ew_StrToFloat($this->demanda_sol->CurrentValue);

		// Convert decimal values if posted back
		if ($this->cedula_sol->FormValue == $this->cedula_sol->CurrentValue && is_numeric(ew_StrToFloat($this->cedula_sol->CurrentValue)))
			$this->cedula_sol->CurrentValue = ew_StrToFloat($this->cedula_sol->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id_sol
		// poliza_sol
		// demanda_sol
		// asesor_sol
		// archivos_sol
		// asignacion_sol
		// comis_gas_sol
		// comis_obra_sol
		// comis_fija_sol
		// cedula_sol
		// nombre_sol
		// direccion_pol_sol
		// direccion_nueva_sol
		// localidad_sol
		// barrio_sol
		// telefono1_sol
		// telefono2_sol
		// celular_sol
		// email_sol
		// servicio_sol
		// texto_sol
		// registra_sol
		// tipo_clientegn_sol
		// unidad_sol
		// fecha_reg_sol
		// obs_sol
		// empresa_sol
		// estado_sol
		// fecha_prevista_sol
		// user_preventa_sol
		// quincena_obra_sol
		// fecha_obra_sol
		// nombre_tecnico_sol
		// cod_tecnico_sol
		// lider_obra_sol
		// fecha_visita_comerc_sol
		// obs_estado_sol
		// forma_pagogn_sol

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id_sol
		$this->id_sol->ViewValue = $this->id_sol->CurrentValue;
		$this->id_sol->ViewCustomAttributes = "";

		// poliza_sol
		$this->poliza_sol->ViewValue = $this->poliza_sol->CurrentValue;
		$this->poliza_sol->ViewCustomAttributes = "";

		// demanda_sol
		$this->demanda_sol->ViewValue = $this->demanda_sol->CurrentValue;
		$this->demanda_sol->ViewCustomAttributes = "";

		// asesor_sol
		if (strval($this->asesor_sol->CurrentValue) <> "") {
			$sFilterWrk = "`Id_tercero`" . ew_SearchString("=", $this->asesor_sol->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_tercero`, `nombre_tercero` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ap_terceros`";
		$sWhereWrk = "";
		$this->asesor_sol->LookupFilters = array();
		$lookuptblfilter = "`tipo_tercero`=4";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->asesor_sol, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `nombre_tercero` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->asesor_sol->ViewValue = $this->asesor_sol->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->asesor_sol->ViewValue = $this->asesor_sol->CurrentValue;
			}
		} else {
			$this->asesor_sol->ViewValue = NULL;
		}
		$this->asesor_sol->ViewCustomAttributes = "";

		// archivos_sol
		$this->archivos_sol->ViewValue = $this->archivos_sol->CurrentValue;
		$this->archivos_sol->ViewCustomAttributes = "";

		// asignacion_sol
		if (strval($this->asignacion_sol->CurrentValue) <> "") {
			$sFilterWrk = "`id_asignacion`" . ew_SearchString("=", $this->asignacion_sol->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id_asignacion`, `tipo_asignacion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ap_asignacion`";
		$sWhereWrk = "";
		$this->asignacion_sol->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->asignacion_sol, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `tipo_asignacion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->asignacion_sol->ViewValue = $this->asignacion_sol->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->asignacion_sol->ViewValue = $this->asignacion_sol->CurrentValue;
			}
		} else {
			$this->asignacion_sol->ViewValue = NULL;
		}
		$this->asignacion_sol->ViewCustomAttributes = "";

		// cedula_sol
		$this->cedula_sol->ViewValue = $this->cedula_sol->CurrentValue;
		$this->cedula_sol->ViewCustomAttributes = "";

		// nombre_sol
		$this->nombre_sol->ViewValue = $this->nombre_sol->CurrentValue;
		$this->nombre_sol->ViewCustomAttributes = "";

		// direccion_pol_sol
		$this->direccion_pol_sol->ViewValue = $this->direccion_pol_sol->CurrentValue;
		$this->direccion_pol_sol->ViewCustomAttributes = "";

		// direccion_nueva_sol
		$this->direccion_nueva_sol->ViewValue = $this->direccion_nueva_sol->CurrentValue;
		$this->direccion_nueva_sol->ViewCustomAttributes = "";

		// localidad_sol
		if (strval($this->localidad_sol->CurrentValue) <> "") {
			$sFilterWrk = "`id_loc`" . ew_SearchString("=", $this->localidad_sol->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id_loc`, `nombre_loc` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `siax_localidad`";
		$sWhereWrk = "";
		$this->localidad_sol->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->localidad_sol, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `nombre_loc` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->localidad_sol->ViewValue = $this->localidad_sol->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->localidad_sol->ViewValue = $this->localidad_sol->CurrentValue;
			}
		} else {
			$this->localidad_sol->ViewValue = NULL;
		}
		$this->localidad_sol->ViewCustomAttributes = "";

		// barrio_sol
		if (strval($this->barrio_sol->CurrentValue) <> "") {
			$sFilterWrk = "`cod_sec`" . ew_SearchString("=", $this->barrio_sol->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `cod_sec`, `nombre_sec` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `siax_sectores`";
		$sWhereWrk = "";
		$this->barrio_sol->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->barrio_sol, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `nombre_sec` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->barrio_sol->ViewValue = $this->barrio_sol->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->barrio_sol->ViewValue = $this->barrio_sol->CurrentValue;
			}
		} else {
			$this->barrio_sol->ViewValue = NULL;
		}
		$this->barrio_sol->ViewCustomAttributes = "";

		// telefono1_sol
		$this->telefono1_sol->ViewValue = $this->telefono1_sol->CurrentValue;
		$this->telefono1_sol->ViewCustomAttributes = "";

		// telefono2_sol
		$this->telefono2_sol->ViewValue = $this->telefono2_sol->CurrentValue;
		$this->telefono2_sol->ViewCustomAttributes = "";

		// celular_sol
		$this->celular_sol->ViewValue = $this->celular_sol->CurrentValue;
		$this->celular_sol->ViewCustomAttributes = "";

		// email_sol
		$this->email_sol->ViewValue = $this->email_sol->CurrentValue;
		$this->email_sol->ViewCustomAttributes = "";

		// servicio_sol
		$this->servicio_sol->ViewValue = $this->servicio_sol->CurrentValue;
		$this->servicio_sol->ViewCustomAttributes = "";

		// obs_sol
		$this->obs_sol->ViewValue = $this->obs_sol->CurrentValue;
		$this->obs_sol->ViewCustomAttributes = "";

		// estado_sol
		if (strval($this->estado_sol->CurrentValue) <> "") {
			$sFilterWrk = "`id_estado_preventa`" . ew_SearchString("=", $this->estado_sol->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id_estado_preventa`, `nombre_estado_preventa` AS `DispFld`, `detalle_estado_preventa` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ap_estado_preventa`";
		$sWhereWrk = "";
		$this->estado_sol->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->estado_sol, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `nombre_estado_preventa` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->estado_sol->ViewValue = $this->estado_sol->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->estado_sol->ViewValue = $this->estado_sol->CurrentValue;
			}
		} else {
			$this->estado_sol->ViewValue = NULL;
		}
		$this->estado_sol->ViewCustomAttributes = "";

		// fecha_prevista_sol
		$this->fecha_prevista_sol->ViewValue = $this->fecha_prevista_sol->CurrentValue;
		$this->fecha_prevista_sol->ViewValue = ew_FormatDateTime($this->fecha_prevista_sol->ViewValue, 0);
		$this->fecha_prevista_sol->ViewCustomAttributes = "";

		// fecha_obra_sol
		$this->fecha_obra_sol->ViewValue = $this->fecha_obra_sol->CurrentValue;
		$this->fecha_obra_sol->ViewValue = ew_FormatDateTime($this->fecha_obra_sol->ViewValue, 0);
		$this->fecha_obra_sol->ViewCustomAttributes = "";

		// fecha_visita_comerc_sol
		$this->fecha_visita_comerc_sol->ViewValue = $this->fecha_visita_comerc_sol->CurrentValue;
		$this->fecha_visita_comerc_sol->ViewValue = ew_FormatDateTime($this->fecha_visita_comerc_sol->ViewValue, 0);
		$this->fecha_visita_comerc_sol->ViewCustomAttributes = "";

		// obs_estado_sol
		$this->obs_estado_sol->ViewValue = $this->obs_estado_sol->CurrentValue;
		$this->obs_estado_sol->ViewCustomAttributes = "";

			// id_sol
			$this->id_sol->LinkCustomAttributes = "";
			$this->id_sol->HrefValue = "";
			$this->id_sol->TooltipValue = "";

			// poliza_sol
			$this->poliza_sol->LinkCustomAttributes = "";
			$this->poliza_sol->HrefValue = "";
			$this->poliza_sol->TooltipValue = "";

			// demanda_sol
			$this->demanda_sol->LinkCustomAttributes = "";
			$this->demanda_sol->HrefValue = "";
			$this->demanda_sol->TooltipValue = "";

			// asesor_sol
			$this->asesor_sol->LinkCustomAttributes = "";
			$this->asesor_sol->HrefValue = "";
			$this->asesor_sol->TooltipValue = "";

			// asignacion_sol
			$this->asignacion_sol->LinkCustomAttributes = "";
			$this->asignacion_sol->HrefValue = "";
			$this->asignacion_sol->TooltipValue = "";

			// cedula_sol
			$this->cedula_sol->LinkCustomAttributes = "";
			$this->cedula_sol->HrefValue = "";
			$this->cedula_sol->TooltipValue = "";

			// nombre_sol
			$this->nombre_sol->LinkCustomAttributes = "";
			$this->nombre_sol->HrefValue = "";
			$this->nombre_sol->TooltipValue = "";

			// direccion_pol_sol
			$this->direccion_pol_sol->LinkCustomAttributes = "";
			$this->direccion_pol_sol->HrefValue = "";
			$this->direccion_pol_sol->TooltipValue = "";

			// direccion_nueva_sol
			$this->direccion_nueva_sol->LinkCustomAttributes = "";
			$this->direccion_nueva_sol->HrefValue = "";
			$this->direccion_nueva_sol->TooltipValue = "";

			// localidad_sol
			$this->localidad_sol->LinkCustomAttributes = "";
			$this->localidad_sol->HrefValue = "";
			$this->localidad_sol->TooltipValue = "";

			// barrio_sol
			$this->barrio_sol->LinkCustomAttributes = "";
			$this->barrio_sol->HrefValue = "";
			$this->barrio_sol->TooltipValue = "";

			// telefono1_sol
			$this->telefono1_sol->LinkCustomAttributes = "";
			$this->telefono1_sol->HrefValue = "";
			$this->telefono1_sol->TooltipValue = "";

			// telefono2_sol
			$this->telefono2_sol->LinkCustomAttributes = "";
			$this->telefono2_sol->HrefValue = "";
			$this->telefono2_sol->TooltipValue = "";

			// celular_sol
			$this->celular_sol->LinkCustomAttributes = "";
			$this->celular_sol->HrefValue = "";
			$this->celular_sol->TooltipValue = "";

			// servicio_sol
			$this->servicio_sol->LinkCustomAttributes = "";
			$this->servicio_sol->HrefValue = "";
			$this->servicio_sol->TooltipValue = "";

			// obs_sol
			$this->obs_sol->LinkCustomAttributes = "";
			$this->obs_sol->HrefValue = "";
			$this->obs_sol->TooltipValue = "";

			// estado_sol
			$this->estado_sol->LinkCustomAttributes = "";
			$this->estado_sol->HrefValue = "";
			$this->estado_sol->TooltipValue = "";

			// fecha_prevista_sol
			$this->fecha_prevista_sol->LinkCustomAttributes = "";
			$this->fecha_prevista_sol->HrefValue = "";
			$this->fecha_prevista_sol->TooltipValue = "";

			// fecha_obra_sol
			$this->fecha_obra_sol->LinkCustomAttributes = "";
			$this->fecha_obra_sol->HrefValue = "";
			$this->fecha_obra_sol->TooltipValue = "";

			// fecha_visita_comerc_sol
			$this->fecha_visita_comerc_sol->LinkCustomAttributes = "";
			$this->fecha_visita_comerc_sol->HrefValue = "";
			$this->fecha_visita_comerc_sol->TooltipValue = "";

			// obs_estado_sol
			$this->obs_estado_sol->LinkCustomAttributes = "";
			$this->obs_estado_sol->HrefValue = "";
			$this->obs_estado_sol->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language;

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = FALSE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = FALSE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a href=\"" . $this->ExportWordUrl . "\" class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = FALSE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a href=\"" . $this->ExportHtmlUrl . "\" class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = FALSE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a href=\"" . $this->ExportXmlUrl . "\" class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = FALSE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a href=\"" . $this->ExportCsvUrl . "\" class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = FALSE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a href=\"" . $this->ExportPdfUrl . "\" class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = TRUE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_ap_solicitud\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_ap_solicitud',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fap_solicitudview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
		$item->Visible = FALSE;

		// Drop down button for export
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = TRUE;
		$this->ExportOptions->UseDropDownButton = FALSE;
		if ($this->ExportOptions->UseButtonGroup && ew_IsMobile())
			$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->DropDownButtonPhrase = $Language->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide options for export
		if ($this->Export <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = FALSE;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $this->SelectRecordCount();
		} else {
			if (!$this->Recordset)
				$this->Recordset = $this->LoadRecordset();
			$rs = &$this->Recordset;
			if ($rs)
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;
		$this->SetUpStartRec(); // Set up start record position

		// Set the last record to display
		if ($this->DisplayRecs <= 0) {
			$this->StopRec = $this->TotalRecs;
		} else {
			$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
		}
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$this->ExportDoc = ew_ExportDocument($this, "v");
		$Doc = &$this->ExportDoc;
		if ($bSelectLimit) {
			$this->StartRec = 1;
			$this->StopRec = $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs;
		} else {

			//$this->StartRec = $this->StartRec;
			//$this->StopRec = $this->StopRec;

		}

		// Call Page Exporting server event
		$this->ExportDoc->ExportCustom = !$this->Page_Exporting();
		$ParentTable = "";
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		$Doc->Text .= $sHeader;
		$this->ExportDocument($Doc, $rs, $this->StartRec, $this->StopRec, "view");
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		$Doc->Text .= $sFooter;

		// Close recordset
		$rs->Close();

		// Call Page Exported server event
		$this->Page_Exported();

		// Export header and footer
		$Doc->ExportHeaderAndFooter();

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED && $this->Export <> "pdf")
			echo ew_DebugMsg();

		// Output data
		$Doc->Export();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("ap_solicitudlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($ap_solicitud_view)) $ap_solicitud_view = new cap_solicitud_view();

// Page init
$ap_solicitud_view->Page_Init();

// Page main
$ap_solicitud_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ap_solicitud_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($ap_solicitud->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fap_solicitudview = new ew_Form("fap_solicitudview", "view");

// Form_CustomValidate event
fap_solicitudview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fap_solicitudview.ValidateRequired = true;
<?php } else { ?>
fap_solicitudview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fap_solicitudview.Lists["x_asesor_sol"] = {"LinkField":"x_Id_tercero","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre_tercero","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"ap_terceros"};
fap_solicitudview.Lists["x_asignacion_sol"] = {"LinkField":"x_id_asignacion","Ajax":true,"AutoFill":false,"DisplayFields":["x_tipo_asignacion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"ap_asignacion"};
fap_solicitudview.Lists["x_localidad_sol"] = {"LinkField":"x_id_loc","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre_loc","","",""],"ParentFields":[],"ChildFields":["x_barrio_sol"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"siax_localidad"};
fap_solicitudview.Lists["x_barrio_sol"] = {"LinkField":"x_cod_sec","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre_sec","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"siax_sectores"};
fap_solicitudview.Lists["x_estado_sol"] = {"LinkField":"x_id_estado_preventa","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre_estado_preventa","x_detalle_estado_preventa","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"ap_estado_preventa"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($ap_solicitud->Export == "") { ?>
<div class="ewToolbar">
<?php if (!$ap_solicitud_view->IsModal) { ?>
<?php if ($ap_solicitud->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php } ?>
<?php $ap_solicitud_view->ExportOptions->Render("body") ?>
<?php
	foreach ($ap_solicitud_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$ap_solicitud_view->IsModal) { ?>
<?php if ($ap_solicitud->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $ap_solicitud_view->ShowPageHeader(); ?>
<?php
$ap_solicitud_view->ShowMessage();
?>
<?php if (!$ap_solicitud_view->IsModal) { ?>
<?php if ($ap_solicitud->Export == "") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($ap_solicitud_view->Pager)) $ap_solicitud_view->Pager = new cPrevNextPager($ap_solicitud_view->StartRec, $ap_solicitud_view->DisplayRecs, $ap_solicitud_view->TotalRecs) ?>
<?php if ($ap_solicitud_view->Pager->RecordCount > 0 && $ap_solicitud_view->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($ap_solicitud_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $ap_solicitud_view->PageUrl() ?>start=<?php echo $ap_solicitud_view->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($ap_solicitud_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $ap_solicitud_view->PageUrl() ?>start=<?php echo $ap_solicitud_view->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $ap_solicitud_view->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($ap_solicitud_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $ap_solicitud_view->PageUrl() ?>start=<?php echo $ap_solicitud_view->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($ap_solicitud_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $ap_solicitud_view->PageUrl() ?>start=<?php echo $ap_solicitud_view->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $ap_solicitud_view->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<form name="fap_solicitudview" id="fap_solicitudview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($ap_solicitud_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $ap_solicitud_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ap_solicitud">
<?php if ($ap_solicitud_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($ap_solicitud->id_sol->Visible) { // id_sol ?>
	<tr id="r_id_sol">
		<td><span id="elh_ap_solicitud_id_sol"><?php echo $ap_solicitud->id_sol->FldCaption() ?></span></td>
		<td data-name="id_sol"<?php echo $ap_solicitud->id_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_id_sol">
<span<?php echo $ap_solicitud->id_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->id_sol->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_solicitud->poliza_sol->Visible) { // poliza_sol ?>
	<tr id="r_poliza_sol">
		<td><span id="elh_ap_solicitud_poliza_sol"><?php echo $ap_solicitud->poliza_sol->FldCaption() ?></span></td>
		<td data-name="poliza_sol"<?php echo $ap_solicitud->poliza_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_poliza_sol">
<span<?php echo $ap_solicitud->poliza_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->poliza_sol->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_solicitud->demanda_sol->Visible) { // demanda_sol ?>
	<tr id="r_demanda_sol">
		<td><span id="elh_ap_solicitud_demanda_sol"><?php echo $ap_solicitud->demanda_sol->FldCaption() ?></span></td>
		<td data-name="demanda_sol"<?php echo $ap_solicitud->demanda_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_demanda_sol">
<span<?php echo $ap_solicitud->demanda_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->demanda_sol->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_solicitud->asesor_sol->Visible) { // asesor_sol ?>
	<tr id="r_asesor_sol">
		<td><span id="elh_ap_solicitud_asesor_sol"><?php echo $ap_solicitud->asesor_sol->FldCaption() ?></span></td>
		<td data-name="asesor_sol"<?php echo $ap_solicitud->asesor_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_asesor_sol">
<span<?php echo $ap_solicitud->asesor_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->asesor_sol->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_solicitud->asignacion_sol->Visible) { // asignacion_sol ?>
	<tr id="r_asignacion_sol">
		<td><span id="elh_ap_solicitud_asignacion_sol"><?php echo $ap_solicitud->asignacion_sol->FldCaption() ?></span></td>
		<td data-name="asignacion_sol"<?php echo $ap_solicitud->asignacion_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_asignacion_sol">
<span<?php echo $ap_solicitud->asignacion_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->asignacion_sol->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_solicitud->cedula_sol->Visible) { // cedula_sol ?>
	<tr id="r_cedula_sol">
		<td><span id="elh_ap_solicitud_cedula_sol"><?php echo $ap_solicitud->cedula_sol->FldCaption() ?></span></td>
		<td data-name="cedula_sol"<?php echo $ap_solicitud->cedula_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_cedula_sol">
<span<?php echo $ap_solicitud->cedula_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->cedula_sol->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_solicitud->nombre_sol->Visible) { // nombre_sol ?>
	<tr id="r_nombre_sol">
		<td><span id="elh_ap_solicitud_nombre_sol"><?php echo $ap_solicitud->nombre_sol->FldCaption() ?></span></td>
		<td data-name="nombre_sol"<?php echo $ap_solicitud->nombre_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_nombre_sol">
<span<?php echo $ap_solicitud->nombre_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->nombre_sol->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_solicitud->direccion_pol_sol->Visible) { // direccion_pol_sol ?>
	<tr id="r_direccion_pol_sol">
		<td><span id="elh_ap_solicitud_direccion_pol_sol"><?php echo $ap_solicitud->direccion_pol_sol->FldCaption() ?></span></td>
		<td data-name="direccion_pol_sol"<?php echo $ap_solicitud->direccion_pol_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_direccion_pol_sol">
<span<?php echo $ap_solicitud->direccion_pol_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->direccion_pol_sol->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_solicitud->direccion_nueva_sol->Visible) { // direccion_nueva_sol ?>
	<tr id="r_direccion_nueva_sol">
		<td><span id="elh_ap_solicitud_direccion_nueva_sol"><?php echo $ap_solicitud->direccion_nueva_sol->FldCaption() ?></span></td>
		<td data-name="direccion_nueva_sol"<?php echo $ap_solicitud->direccion_nueva_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_direccion_nueva_sol">
<span<?php echo $ap_solicitud->direccion_nueva_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->direccion_nueva_sol->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_solicitud->localidad_sol->Visible) { // localidad_sol ?>
	<tr id="r_localidad_sol">
		<td><span id="elh_ap_solicitud_localidad_sol"><?php echo $ap_solicitud->localidad_sol->FldCaption() ?></span></td>
		<td data-name="localidad_sol"<?php echo $ap_solicitud->localidad_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_localidad_sol">
<span<?php echo $ap_solicitud->localidad_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->localidad_sol->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_solicitud->barrio_sol->Visible) { // barrio_sol ?>
	<tr id="r_barrio_sol">
		<td><span id="elh_ap_solicitud_barrio_sol"><?php echo $ap_solicitud->barrio_sol->FldCaption() ?></span></td>
		<td data-name="barrio_sol"<?php echo $ap_solicitud->barrio_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_barrio_sol">
<span<?php echo $ap_solicitud->barrio_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->barrio_sol->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_solicitud->telefono1_sol->Visible) { // telefono1_sol ?>
	<tr id="r_telefono1_sol">
		<td><span id="elh_ap_solicitud_telefono1_sol"><?php echo $ap_solicitud->telefono1_sol->FldCaption() ?></span></td>
		<td data-name="telefono1_sol"<?php echo $ap_solicitud->telefono1_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_telefono1_sol">
<span<?php echo $ap_solicitud->telefono1_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->telefono1_sol->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_solicitud->telefono2_sol->Visible) { // telefono2_sol ?>
	<tr id="r_telefono2_sol">
		<td><span id="elh_ap_solicitud_telefono2_sol"><?php echo $ap_solicitud->telefono2_sol->FldCaption() ?></span></td>
		<td data-name="telefono2_sol"<?php echo $ap_solicitud->telefono2_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_telefono2_sol">
<span<?php echo $ap_solicitud->telefono2_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->telefono2_sol->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_solicitud->celular_sol->Visible) { // celular_sol ?>
	<tr id="r_celular_sol">
		<td><span id="elh_ap_solicitud_celular_sol"><?php echo $ap_solicitud->celular_sol->FldCaption() ?></span></td>
		<td data-name="celular_sol"<?php echo $ap_solicitud->celular_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_celular_sol">
<span<?php echo $ap_solicitud->celular_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->celular_sol->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_solicitud->servicio_sol->Visible) { // servicio_sol ?>
	<tr id="r_servicio_sol">
		<td><span id="elh_ap_solicitud_servicio_sol"><?php echo $ap_solicitud->servicio_sol->FldCaption() ?></span></td>
		<td data-name="servicio_sol"<?php echo $ap_solicitud->servicio_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_servicio_sol">
<span<?php echo $ap_solicitud->servicio_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->servicio_sol->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_solicitud->obs_sol->Visible) { // obs_sol ?>
	<tr id="r_obs_sol">
		<td><span id="elh_ap_solicitud_obs_sol"><?php echo $ap_solicitud->obs_sol->FldCaption() ?></span></td>
		<td data-name="obs_sol"<?php echo $ap_solicitud->obs_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_obs_sol">
<span<?php echo $ap_solicitud->obs_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->obs_sol->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_solicitud->estado_sol->Visible) { // estado_sol ?>
	<tr id="r_estado_sol">
		<td><span id="elh_ap_solicitud_estado_sol"><?php echo $ap_solicitud->estado_sol->FldCaption() ?></span></td>
		<td data-name="estado_sol"<?php echo $ap_solicitud->estado_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_estado_sol">
<span<?php echo $ap_solicitud->estado_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->estado_sol->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_solicitud->fecha_prevista_sol->Visible) { // fecha_prevista_sol ?>
	<tr id="r_fecha_prevista_sol">
		<td><span id="elh_ap_solicitud_fecha_prevista_sol"><?php echo $ap_solicitud->fecha_prevista_sol->FldCaption() ?></span></td>
		<td data-name="fecha_prevista_sol"<?php echo $ap_solicitud->fecha_prevista_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_fecha_prevista_sol">
<span<?php echo $ap_solicitud->fecha_prevista_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->fecha_prevista_sol->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_solicitud->fecha_obra_sol->Visible) { // fecha_obra_sol ?>
	<tr id="r_fecha_obra_sol">
		<td><span id="elh_ap_solicitud_fecha_obra_sol"><?php echo $ap_solicitud->fecha_obra_sol->FldCaption() ?></span></td>
		<td data-name="fecha_obra_sol"<?php echo $ap_solicitud->fecha_obra_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_fecha_obra_sol">
<span<?php echo $ap_solicitud->fecha_obra_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->fecha_obra_sol->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_solicitud->fecha_visita_comerc_sol->Visible) { // fecha_visita_comerc_sol ?>
	<tr id="r_fecha_visita_comerc_sol">
		<td><span id="elh_ap_solicitud_fecha_visita_comerc_sol"><?php echo $ap_solicitud->fecha_visita_comerc_sol->FldCaption() ?></span></td>
		<td data-name="fecha_visita_comerc_sol"<?php echo $ap_solicitud->fecha_visita_comerc_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_fecha_visita_comerc_sol">
<span<?php echo $ap_solicitud->fecha_visita_comerc_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->fecha_visita_comerc_sol->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_solicitud->obs_estado_sol->Visible) { // obs_estado_sol ?>
	<tr id="r_obs_estado_sol">
		<td><span id="elh_ap_solicitud_obs_estado_sol"><?php echo $ap_solicitud->obs_estado_sol->FldCaption() ?></span></td>
		<td data-name="obs_estado_sol"<?php echo $ap_solicitud->obs_estado_sol->CellAttributes() ?>>
<span id="el_ap_solicitud_obs_estado_sol">
<span<?php echo $ap_solicitud->obs_estado_sol->ViewAttributes() ?>>
<?php echo $ap_solicitud->obs_estado_sol->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if (!$ap_solicitud_view->IsModal) { ?>
<?php if ($ap_solicitud->Export == "") { ?>
<?php if (!isset($ap_solicitud_view->Pager)) $ap_solicitud_view->Pager = new cPrevNextPager($ap_solicitud_view->StartRec, $ap_solicitud_view->DisplayRecs, $ap_solicitud_view->TotalRecs) ?>
<?php if ($ap_solicitud_view->Pager->RecordCount > 0 && $ap_solicitud_view->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($ap_solicitud_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $ap_solicitud_view->PageUrl() ?>start=<?php echo $ap_solicitud_view->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($ap_solicitud_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $ap_solicitud_view->PageUrl() ?>start=<?php echo $ap_solicitud_view->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $ap_solicitud_view->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($ap_solicitud_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $ap_solicitud_view->PageUrl() ?>start=<?php echo $ap_solicitud_view->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($ap_solicitud_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $ap_solicitud_view->PageUrl() ?>start=<?php echo $ap_solicitud_view->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $ap_solicitud_view->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
<?php } ?>
</form>
<?php if ($ap_solicitud->Export == "") { ?>
<script type="text/javascript">
fap_solicitudview.Init();
</script>
<?php } ?>
<?php
$ap_solicitud_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($ap_solicitud->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$ap_solicitud_view->Page_Terminate();
?>
