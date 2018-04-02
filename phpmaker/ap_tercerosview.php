<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "ap_tercerosinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$ap_terceros_view = NULL; // Initialize page object first

class cap_terceros_view extends cap_terceros {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{6A9AC718-A824-45A3-BED3-A95E91E6986D}";

	// Table name
	var $TableName = 'ap_terceros';

	// Page object name
	var $PageObjName = 'ap_terceros_view';

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

		// Table object (ap_terceros)
		if (!isset($GLOBALS["ap_terceros"]) || get_class($GLOBALS["ap_terceros"]) == "cap_terceros") {
			$GLOBALS["ap_terceros"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ap_terceros"];
		}
		$KeyUrl = "";
		if (@$_GET["Id_tercero"] <> "") {
			$this->RecKey["Id_tercero"] = $_GET["Id_tercero"];
			$KeyUrl .= "&amp;Id_tercero=" . urlencode($this->RecKey["Id_tercero"]);
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
			define("EW_TABLE_NAME", 'ap_terceros', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("ap_terceroslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->Id_tercero->SetVisibility();
		$this->Id_tercero->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->nombre_tercero->SetVisibility();
		$this->direccion_tercero->SetVisibility();
		$this->telefono1_tercero->SetVisibility();
		$this->telefono2_tercero->SetVisibility();
		$this->fax_tercero->SetVisibility();
		$this->nit_tercero->SetVisibility();
		$this->tipo_tercero->SetVisibility();
		$this->e_mail_tercero->SetVisibility();
		$this->Contacto_tercero->SetVisibility();
		$this->gran_contrib_tercero->SetVisibility();
		$this->autoretenedor_tercero->SetVisibility();
		$this->activo_tercero->SetVisibility();
		$this->tercero__registrado_por->SetVisibility();
		$this->reg_comun_tercero->SetVisibility();
		$this->responsable_materiales_tercero->SetVisibility();
		$this->grupo_nomina_tercero->SetVisibility();
		$this->tercero__lider_Obra->SetVisibility();
		$this->tercero_nombre_lider->SetVisibility();
		$this->empresa_tercero->SetVisibility();

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
		global $EW_EXPORT, $ap_terceros;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($ap_terceros);
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
			if (@$_GET["Id_tercero"] <> "") {
				$this->Id_tercero->setQueryStringValue($_GET["Id_tercero"]);
				$this->RecKey["Id_tercero"] = $this->Id_tercero->QueryStringValue;
			} elseif (@$_POST["Id_tercero"] <> "") {
				$this->Id_tercero->setFormValue($_POST["Id_tercero"]);
				$this->RecKey["Id_tercero"] = $this->Id_tercero->FormValue;
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
						$this->Page_Terminate("ap_terceroslist.php"); // Return to list page
					} elseif ($bLoadCurrentRecord) { // Load current record position
						$this->SetUpStartRec(); // Set up start record position

						// Point to current record
						if (intval($this->StartRec) <= intval($this->TotalRecs)) {
							$bMatchRecord = TRUE;
							$this->Recordset->Move($this->StartRec-1);
						}
					} else { // Match key values
						while (!$this->Recordset->EOF) {
							if (strval($this->Id_tercero->CurrentValue) == strval($this->Recordset->fields('Id_tercero'))) {
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
						$sReturnUrl = "ap_terceroslist.php"; // No matching record, return to list
					} else {
						$this->LoadRowValues($this->Recordset); // Load row values
					}
			}
		} else {
			$sReturnUrl = "ap_terceroslist.php"; // Not page request, return to list
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
		$this->Id_tercero->setDbValue($rs->fields('Id_tercero'));
		$this->nombre_tercero->setDbValue($rs->fields('nombre_tercero'));
		$this->direccion_tercero->setDbValue($rs->fields('direccion_tercero'));
		$this->telefono1_tercero->setDbValue($rs->fields('telefono1_tercero'));
		$this->telefono2_tercero->setDbValue($rs->fields('telefono2_tercero'));
		$this->fax_tercero->setDbValue($rs->fields('fax_tercero'));
		$this->nit_tercero->setDbValue($rs->fields('nit_tercero'));
		$this->tipo_tercero->setDbValue($rs->fields('tipo_tercero'));
		$this->e_mail_tercero->setDbValue($rs->fields('e_mail_tercero'));
		$this->Contacto_tercero->setDbValue($rs->fields('Contacto_tercero'));
		$this->gran_contrib_tercero->setDbValue($rs->fields('gran_contrib_tercero'));
		$this->autoretenedor_tercero->setDbValue($rs->fields('autoretenedor_tercero'));
		$this->activo_tercero->setDbValue($rs->fields('activo_tercero'));
		$this->tercero__registrado_por->setDbValue($rs->fields('tercero_ registrado_por'));
		$this->reg_comun_tercero->setDbValue($rs->fields('reg_comun_tercero'));
		$this->responsable_materiales_tercero->setDbValue($rs->fields('responsable_materiales_tercero'));
		$this->grupo_nomina_tercero->setDbValue($rs->fields('grupo_nomina_tercero'));
		$this->tercero__lider_Obra->setDbValue($rs->fields('tercero_ lider_Obra'));
		$this->tercero_nombre_lider->setDbValue($rs->fields('tercero_nombre_lider'));
		$this->empresa_tercero->setDbValue($rs->fields('empresa_tercero'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Id_tercero->DbValue = $row['Id_tercero'];
		$this->nombre_tercero->DbValue = $row['nombre_tercero'];
		$this->direccion_tercero->DbValue = $row['direccion_tercero'];
		$this->telefono1_tercero->DbValue = $row['telefono1_tercero'];
		$this->telefono2_tercero->DbValue = $row['telefono2_tercero'];
		$this->fax_tercero->DbValue = $row['fax_tercero'];
		$this->nit_tercero->DbValue = $row['nit_tercero'];
		$this->tipo_tercero->DbValue = $row['tipo_tercero'];
		$this->e_mail_tercero->DbValue = $row['e_mail_tercero'];
		$this->Contacto_tercero->DbValue = $row['Contacto_tercero'];
		$this->gran_contrib_tercero->DbValue = $row['gran_contrib_tercero'];
		$this->autoretenedor_tercero->DbValue = $row['autoretenedor_tercero'];
		$this->activo_tercero->DbValue = $row['activo_tercero'];
		$this->tercero__registrado_por->DbValue = $row['tercero_ registrado_por'];
		$this->reg_comun_tercero->DbValue = $row['reg_comun_tercero'];
		$this->responsable_materiales_tercero->DbValue = $row['responsable_materiales_tercero'];
		$this->grupo_nomina_tercero->DbValue = $row['grupo_nomina_tercero'];
		$this->tercero__lider_Obra->DbValue = $row['tercero_ lider_Obra'];
		$this->tercero_nombre_lider->DbValue = $row['tercero_nombre_lider'];
		$this->empresa_tercero->DbValue = $row['empresa_tercero'];
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

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_tercero
		// nombre_tercero
		// direccion_tercero
		// telefono1_tercero
		// telefono2_tercero
		// fax_tercero
		// nit_tercero
		// tipo_tercero
		// e_mail_tercero
		// Contacto_tercero
		// gran_contrib_tercero
		// autoretenedor_tercero
		// activo_tercero
		// tercero_ registrado_por
		// reg_comun_tercero
		// responsable_materiales_tercero
		// grupo_nomina_tercero
		// tercero_ lider_Obra
		// tercero_nombre_lider
		// empresa_tercero

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Id_tercero
		$this->Id_tercero->ViewValue = $this->Id_tercero->CurrentValue;
		$this->Id_tercero->ViewCustomAttributes = "";

		// nombre_tercero
		$this->nombre_tercero->ViewValue = $this->nombre_tercero->CurrentValue;
		$this->nombre_tercero->ViewCustomAttributes = "";

		// direccion_tercero
		$this->direccion_tercero->ViewValue = $this->direccion_tercero->CurrentValue;
		$this->direccion_tercero->ViewCustomAttributes = "";

		// telefono1_tercero
		$this->telefono1_tercero->ViewValue = $this->telefono1_tercero->CurrentValue;
		$this->telefono1_tercero->ViewCustomAttributes = "";

		// telefono2_tercero
		$this->telefono2_tercero->ViewValue = $this->telefono2_tercero->CurrentValue;
		$this->telefono2_tercero->ViewCustomAttributes = "";

		// fax_tercero
		$this->fax_tercero->ViewValue = $this->fax_tercero->CurrentValue;
		$this->fax_tercero->ViewCustomAttributes = "";

		// nit_tercero
		$this->nit_tercero->ViewValue = $this->nit_tercero->CurrentValue;
		$this->nit_tercero->ViewCustomAttributes = "";

		// tipo_tercero
		$this->tipo_tercero->ViewValue = $this->tipo_tercero->CurrentValue;
		$this->tipo_tercero->ViewCustomAttributes = "";

		// e_mail_tercero
		$this->e_mail_tercero->ViewValue = $this->e_mail_tercero->CurrentValue;
		$this->e_mail_tercero->ViewCustomAttributes = "";

		// Contacto_tercero
		$this->Contacto_tercero->ViewValue = $this->Contacto_tercero->CurrentValue;
		$this->Contacto_tercero->ViewCustomAttributes = "";

		// gran_contrib_tercero
		$this->gran_contrib_tercero->ViewValue = $this->gran_contrib_tercero->CurrentValue;
		$this->gran_contrib_tercero->ViewCustomAttributes = "";

		// autoretenedor_tercero
		$this->autoretenedor_tercero->ViewValue = $this->autoretenedor_tercero->CurrentValue;
		$this->autoretenedor_tercero->ViewCustomAttributes = "";

		// activo_tercero
		$this->activo_tercero->ViewValue = $this->activo_tercero->CurrentValue;
		$this->activo_tercero->ViewCustomAttributes = "";

		// tercero_ registrado_por
		$this->tercero__registrado_por->ViewValue = $this->tercero__registrado_por->CurrentValue;
		$this->tercero__registrado_por->ViewCustomAttributes = "";

		// reg_comun_tercero
		$this->reg_comun_tercero->ViewValue = $this->reg_comun_tercero->CurrentValue;
		$this->reg_comun_tercero->ViewCustomAttributes = "";

		// responsable_materiales_tercero
		$this->responsable_materiales_tercero->ViewValue = $this->responsable_materiales_tercero->CurrentValue;
		$this->responsable_materiales_tercero->ViewCustomAttributes = "";

		// grupo_nomina_tercero
		$this->grupo_nomina_tercero->ViewValue = $this->grupo_nomina_tercero->CurrentValue;
		$this->grupo_nomina_tercero->ViewCustomAttributes = "";

		// tercero_ lider_Obra
		$this->tercero__lider_Obra->ViewValue = $this->tercero__lider_Obra->CurrentValue;
		$this->tercero__lider_Obra->ViewCustomAttributes = "";

		// tercero_nombre_lider
		$this->tercero_nombre_lider->ViewValue = $this->tercero_nombre_lider->CurrentValue;
		$this->tercero_nombre_lider->ViewCustomAttributes = "";

		// empresa_tercero
		$this->empresa_tercero->ViewValue = $this->empresa_tercero->CurrentValue;
		$this->empresa_tercero->ViewCustomAttributes = "";

			// Id_tercero
			$this->Id_tercero->LinkCustomAttributes = "";
			$this->Id_tercero->HrefValue = "";
			$this->Id_tercero->TooltipValue = "";

			// nombre_tercero
			$this->nombre_tercero->LinkCustomAttributes = "";
			$this->nombre_tercero->HrefValue = "";
			$this->nombre_tercero->TooltipValue = "";

			// direccion_tercero
			$this->direccion_tercero->LinkCustomAttributes = "";
			$this->direccion_tercero->HrefValue = "";
			$this->direccion_tercero->TooltipValue = "";

			// telefono1_tercero
			$this->telefono1_tercero->LinkCustomAttributes = "";
			$this->telefono1_tercero->HrefValue = "";
			$this->telefono1_tercero->TooltipValue = "";

			// telefono2_tercero
			$this->telefono2_tercero->LinkCustomAttributes = "";
			$this->telefono2_tercero->HrefValue = "";
			$this->telefono2_tercero->TooltipValue = "";

			// fax_tercero
			$this->fax_tercero->LinkCustomAttributes = "";
			$this->fax_tercero->HrefValue = "";
			$this->fax_tercero->TooltipValue = "";

			// nit_tercero
			$this->nit_tercero->LinkCustomAttributes = "";
			$this->nit_tercero->HrefValue = "";
			$this->nit_tercero->TooltipValue = "";

			// tipo_tercero
			$this->tipo_tercero->LinkCustomAttributes = "";
			$this->tipo_tercero->HrefValue = "";
			$this->tipo_tercero->TooltipValue = "";

			// e_mail_tercero
			$this->e_mail_tercero->LinkCustomAttributes = "";
			$this->e_mail_tercero->HrefValue = "";
			$this->e_mail_tercero->TooltipValue = "";

			// Contacto_tercero
			$this->Contacto_tercero->LinkCustomAttributes = "";
			$this->Contacto_tercero->HrefValue = "";
			$this->Contacto_tercero->TooltipValue = "";

			// gran_contrib_tercero
			$this->gran_contrib_tercero->LinkCustomAttributes = "";
			$this->gran_contrib_tercero->HrefValue = "";
			$this->gran_contrib_tercero->TooltipValue = "";

			// autoretenedor_tercero
			$this->autoretenedor_tercero->LinkCustomAttributes = "";
			$this->autoretenedor_tercero->HrefValue = "";
			$this->autoretenedor_tercero->TooltipValue = "";

			// activo_tercero
			$this->activo_tercero->LinkCustomAttributes = "";
			$this->activo_tercero->HrefValue = "";
			$this->activo_tercero->TooltipValue = "";

			// tercero_ registrado_por
			$this->tercero__registrado_por->LinkCustomAttributes = "";
			$this->tercero__registrado_por->HrefValue = "";
			$this->tercero__registrado_por->TooltipValue = "";

			// reg_comun_tercero
			$this->reg_comun_tercero->LinkCustomAttributes = "";
			$this->reg_comun_tercero->HrefValue = "";
			$this->reg_comun_tercero->TooltipValue = "";

			// responsable_materiales_tercero
			$this->responsable_materiales_tercero->LinkCustomAttributes = "";
			$this->responsable_materiales_tercero->HrefValue = "";
			$this->responsable_materiales_tercero->TooltipValue = "";

			// grupo_nomina_tercero
			$this->grupo_nomina_tercero->LinkCustomAttributes = "";
			$this->grupo_nomina_tercero->HrefValue = "";
			$this->grupo_nomina_tercero->TooltipValue = "";

			// tercero_ lider_Obra
			$this->tercero__lider_Obra->LinkCustomAttributes = "";
			$this->tercero__lider_Obra->HrefValue = "";
			$this->tercero__lider_Obra->TooltipValue = "";

			// tercero_nombre_lider
			$this->tercero_nombre_lider->LinkCustomAttributes = "";
			$this->tercero_nombre_lider->HrefValue = "";
			$this->tercero_nombre_lider->TooltipValue = "";

			// empresa_tercero
			$this->empresa_tercero->LinkCustomAttributes = "";
			$this->empresa_tercero->HrefValue = "";
			$this->empresa_tercero->TooltipValue = "";
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("ap_terceroslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($ap_terceros_view)) $ap_terceros_view = new cap_terceros_view();

// Page init
$ap_terceros_view->Page_Init();

// Page main
$ap_terceros_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ap_terceros_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fap_tercerosview = new ew_Form("fap_tercerosview", "view");

// Form_CustomValidate event
fap_tercerosview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fap_tercerosview.ValidateRequired = true;
<?php } else { ?>
fap_tercerosview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php if (!$ap_terceros_view->IsModal) { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php $ap_terceros_view->ExportOptions->Render("body") ?>
<?php
	foreach ($ap_terceros_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$ap_terceros_view->IsModal) { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php $ap_terceros_view->ShowPageHeader(); ?>
<?php
$ap_terceros_view->ShowMessage();
?>
<form name="fap_tercerosview" id="fap_tercerosview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($ap_terceros_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $ap_terceros_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ap_terceros">
<?php if ($ap_terceros_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($ap_terceros->Id_tercero->Visible) { // Id_tercero ?>
	<tr id="r_Id_tercero">
		<td><span id="elh_ap_terceros_Id_tercero"><?php echo $ap_terceros->Id_tercero->FldCaption() ?></span></td>
		<td data-name="Id_tercero"<?php echo $ap_terceros->Id_tercero->CellAttributes() ?>>
<span id="el_ap_terceros_Id_tercero">
<span<?php echo $ap_terceros->Id_tercero->ViewAttributes() ?>>
<?php echo $ap_terceros->Id_tercero->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_terceros->nombre_tercero->Visible) { // nombre_tercero ?>
	<tr id="r_nombre_tercero">
		<td><span id="elh_ap_terceros_nombre_tercero"><?php echo $ap_terceros->nombre_tercero->FldCaption() ?></span></td>
		<td data-name="nombre_tercero"<?php echo $ap_terceros->nombre_tercero->CellAttributes() ?>>
<span id="el_ap_terceros_nombre_tercero">
<span<?php echo $ap_terceros->nombre_tercero->ViewAttributes() ?>>
<?php echo $ap_terceros->nombre_tercero->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_terceros->direccion_tercero->Visible) { // direccion_tercero ?>
	<tr id="r_direccion_tercero">
		<td><span id="elh_ap_terceros_direccion_tercero"><?php echo $ap_terceros->direccion_tercero->FldCaption() ?></span></td>
		<td data-name="direccion_tercero"<?php echo $ap_terceros->direccion_tercero->CellAttributes() ?>>
<span id="el_ap_terceros_direccion_tercero">
<span<?php echo $ap_terceros->direccion_tercero->ViewAttributes() ?>>
<?php echo $ap_terceros->direccion_tercero->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_terceros->telefono1_tercero->Visible) { // telefono1_tercero ?>
	<tr id="r_telefono1_tercero">
		<td><span id="elh_ap_terceros_telefono1_tercero"><?php echo $ap_terceros->telefono1_tercero->FldCaption() ?></span></td>
		<td data-name="telefono1_tercero"<?php echo $ap_terceros->telefono1_tercero->CellAttributes() ?>>
<span id="el_ap_terceros_telefono1_tercero">
<span<?php echo $ap_terceros->telefono1_tercero->ViewAttributes() ?>>
<?php echo $ap_terceros->telefono1_tercero->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_terceros->telefono2_tercero->Visible) { // telefono2_tercero ?>
	<tr id="r_telefono2_tercero">
		<td><span id="elh_ap_terceros_telefono2_tercero"><?php echo $ap_terceros->telefono2_tercero->FldCaption() ?></span></td>
		<td data-name="telefono2_tercero"<?php echo $ap_terceros->telefono2_tercero->CellAttributes() ?>>
<span id="el_ap_terceros_telefono2_tercero">
<span<?php echo $ap_terceros->telefono2_tercero->ViewAttributes() ?>>
<?php echo $ap_terceros->telefono2_tercero->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_terceros->fax_tercero->Visible) { // fax_tercero ?>
	<tr id="r_fax_tercero">
		<td><span id="elh_ap_terceros_fax_tercero"><?php echo $ap_terceros->fax_tercero->FldCaption() ?></span></td>
		<td data-name="fax_tercero"<?php echo $ap_terceros->fax_tercero->CellAttributes() ?>>
<span id="el_ap_terceros_fax_tercero">
<span<?php echo $ap_terceros->fax_tercero->ViewAttributes() ?>>
<?php echo $ap_terceros->fax_tercero->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_terceros->nit_tercero->Visible) { // nit_tercero ?>
	<tr id="r_nit_tercero">
		<td><span id="elh_ap_terceros_nit_tercero"><?php echo $ap_terceros->nit_tercero->FldCaption() ?></span></td>
		<td data-name="nit_tercero"<?php echo $ap_terceros->nit_tercero->CellAttributes() ?>>
<span id="el_ap_terceros_nit_tercero">
<span<?php echo $ap_terceros->nit_tercero->ViewAttributes() ?>>
<?php echo $ap_terceros->nit_tercero->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_terceros->tipo_tercero->Visible) { // tipo_tercero ?>
	<tr id="r_tipo_tercero">
		<td><span id="elh_ap_terceros_tipo_tercero"><?php echo $ap_terceros->tipo_tercero->FldCaption() ?></span></td>
		<td data-name="tipo_tercero"<?php echo $ap_terceros->tipo_tercero->CellAttributes() ?>>
<span id="el_ap_terceros_tipo_tercero">
<span<?php echo $ap_terceros->tipo_tercero->ViewAttributes() ?>>
<?php echo $ap_terceros->tipo_tercero->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_terceros->e_mail_tercero->Visible) { // e_mail_tercero ?>
	<tr id="r_e_mail_tercero">
		<td><span id="elh_ap_terceros_e_mail_tercero"><?php echo $ap_terceros->e_mail_tercero->FldCaption() ?></span></td>
		<td data-name="e_mail_tercero"<?php echo $ap_terceros->e_mail_tercero->CellAttributes() ?>>
<span id="el_ap_terceros_e_mail_tercero">
<span<?php echo $ap_terceros->e_mail_tercero->ViewAttributes() ?>>
<?php echo $ap_terceros->e_mail_tercero->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_terceros->Contacto_tercero->Visible) { // Contacto_tercero ?>
	<tr id="r_Contacto_tercero">
		<td><span id="elh_ap_terceros_Contacto_tercero"><?php echo $ap_terceros->Contacto_tercero->FldCaption() ?></span></td>
		<td data-name="Contacto_tercero"<?php echo $ap_terceros->Contacto_tercero->CellAttributes() ?>>
<span id="el_ap_terceros_Contacto_tercero">
<span<?php echo $ap_terceros->Contacto_tercero->ViewAttributes() ?>>
<?php echo $ap_terceros->Contacto_tercero->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_terceros->gran_contrib_tercero->Visible) { // gran_contrib_tercero ?>
	<tr id="r_gran_contrib_tercero">
		<td><span id="elh_ap_terceros_gran_contrib_tercero"><?php echo $ap_terceros->gran_contrib_tercero->FldCaption() ?></span></td>
		<td data-name="gran_contrib_tercero"<?php echo $ap_terceros->gran_contrib_tercero->CellAttributes() ?>>
<span id="el_ap_terceros_gran_contrib_tercero">
<span<?php echo $ap_terceros->gran_contrib_tercero->ViewAttributes() ?>>
<?php echo $ap_terceros->gran_contrib_tercero->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_terceros->autoretenedor_tercero->Visible) { // autoretenedor_tercero ?>
	<tr id="r_autoretenedor_tercero">
		<td><span id="elh_ap_terceros_autoretenedor_tercero"><?php echo $ap_terceros->autoretenedor_tercero->FldCaption() ?></span></td>
		<td data-name="autoretenedor_tercero"<?php echo $ap_terceros->autoretenedor_tercero->CellAttributes() ?>>
<span id="el_ap_terceros_autoretenedor_tercero">
<span<?php echo $ap_terceros->autoretenedor_tercero->ViewAttributes() ?>>
<?php echo $ap_terceros->autoretenedor_tercero->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_terceros->activo_tercero->Visible) { // activo_tercero ?>
	<tr id="r_activo_tercero">
		<td><span id="elh_ap_terceros_activo_tercero"><?php echo $ap_terceros->activo_tercero->FldCaption() ?></span></td>
		<td data-name="activo_tercero"<?php echo $ap_terceros->activo_tercero->CellAttributes() ?>>
<span id="el_ap_terceros_activo_tercero">
<span<?php echo $ap_terceros->activo_tercero->ViewAttributes() ?>>
<?php echo $ap_terceros->activo_tercero->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_terceros->tercero__registrado_por->Visible) { // tercero_ registrado_por ?>
	<tr id="r_tercero__registrado_por">
		<td><span id="elh_ap_terceros_tercero__registrado_por"><?php echo $ap_terceros->tercero__registrado_por->FldCaption() ?></span></td>
		<td data-name="tercero__registrado_por"<?php echo $ap_terceros->tercero__registrado_por->CellAttributes() ?>>
<span id="el_ap_terceros_tercero__registrado_por">
<span<?php echo $ap_terceros->tercero__registrado_por->ViewAttributes() ?>>
<?php echo $ap_terceros->tercero__registrado_por->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_terceros->reg_comun_tercero->Visible) { // reg_comun_tercero ?>
	<tr id="r_reg_comun_tercero">
		<td><span id="elh_ap_terceros_reg_comun_tercero"><?php echo $ap_terceros->reg_comun_tercero->FldCaption() ?></span></td>
		<td data-name="reg_comun_tercero"<?php echo $ap_terceros->reg_comun_tercero->CellAttributes() ?>>
<span id="el_ap_terceros_reg_comun_tercero">
<span<?php echo $ap_terceros->reg_comun_tercero->ViewAttributes() ?>>
<?php echo $ap_terceros->reg_comun_tercero->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_terceros->responsable_materiales_tercero->Visible) { // responsable_materiales_tercero ?>
	<tr id="r_responsable_materiales_tercero">
		<td><span id="elh_ap_terceros_responsable_materiales_tercero"><?php echo $ap_terceros->responsable_materiales_tercero->FldCaption() ?></span></td>
		<td data-name="responsable_materiales_tercero"<?php echo $ap_terceros->responsable_materiales_tercero->CellAttributes() ?>>
<span id="el_ap_terceros_responsable_materiales_tercero">
<span<?php echo $ap_terceros->responsable_materiales_tercero->ViewAttributes() ?>>
<?php echo $ap_terceros->responsable_materiales_tercero->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_terceros->grupo_nomina_tercero->Visible) { // grupo_nomina_tercero ?>
	<tr id="r_grupo_nomina_tercero">
		<td><span id="elh_ap_terceros_grupo_nomina_tercero"><?php echo $ap_terceros->grupo_nomina_tercero->FldCaption() ?></span></td>
		<td data-name="grupo_nomina_tercero"<?php echo $ap_terceros->grupo_nomina_tercero->CellAttributes() ?>>
<span id="el_ap_terceros_grupo_nomina_tercero">
<span<?php echo $ap_terceros->grupo_nomina_tercero->ViewAttributes() ?>>
<?php echo $ap_terceros->grupo_nomina_tercero->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_terceros->tercero__lider_Obra->Visible) { // tercero_ lider_Obra ?>
	<tr id="r_tercero__lider_Obra">
		<td><span id="elh_ap_terceros_tercero__lider_Obra"><?php echo $ap_terceros->tercero__lider_Obra->FldCaption() ?></span></td>
		<td data-name="tercero__lider_Obra"<?php echo $ap_terceros->tercero__lider_Obra->CellAttributes() ?>>
<span id="el_ap_terceros_tercero__lider_Obra">
<span<?php echo $ap_terceros->tercero__lider_Obra->ViewAttributes() ?>>
<?php echo $ap_terceros->tercero__lider_Obra->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_terceros->tercero_nombre_lider->Visible) { // tercero_nombre_lider ?>
	<tr id="r_tercero_nombre_lider">
		<td><span id="elh_ap_terceros_tercero_nombre_lider"><?php echo $ap_terceros->tercero_nombre_lider->FldCaption() ?></span></td>
		<td data-name="tercero_nombre_lider"<?php echo $ap_terceros->tercero_nombre_lider->CellAttributes() ?>>
<span id="el_ap_terceros_tercero_nombre_lider">
<span<?php echo $ap_terceros->tercero_nombre_lider->ViewAttributes() ?>>
<?php echo $ap_terceros->tercero_nombre_lider->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_terceros->empresa_tercero->Visible) { // empresa_tercero ?>
	<tr id="r_empresa_tercero">
		<td><span id="elh_ap_terceros_empresa_tercero"><?php echo $ap_terceros->empresa_tercero->FldCaption() ?></span></td>
		<td data-name="empresa_tercero"<?php echo $ap_terceros->empresa_tercero->CellAttributes() ?>>
<span id="el_ap_terceros_empresa_tercero">
<span<?php echo $ap_terceros->empresa_tercero->ViewAttributes() ?>>
<?php echo $ap_terceros->empresa_tercero->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if (!$ap_terceros_view->IsModal) { ?>
<?php if (!isset($ap_terceros_view->Pager)) $ap_terceros_view->Pager = new cPrevNextPager($ap_terceros_view->StartRec, $ap_terceros_view->DisplayRecs, $ap_terceros_view->TotalRecs) ?>
<?php if ($ap_terceros_view->Pager->RecordCount > 0 && $ap_terceros_view->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($ap_terceros_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $ap_terceros_view->PageUrl() ?>start=<?php echo $ap_terceros_view->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($ap_terceros_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $ap_terceros_view->PageUrl() ?>start=<?php echo $ap_terceros_view->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $ap_terceros_view->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($ap_terceros_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $ap_terceros_view->PageUrl() ?>start=<?php echo $ap_terceros_view->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($ap_terceros_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $ap_terceros_view->PageUrl() ?>start=<?php echo $ap_terceros_view->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $ap_terceros_view->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<script type="text/javascript">
fap_tercerosview.Init();
</script>
<?php
$ap_terceros_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ap_terceros_view->Page_Terminate();
?>
