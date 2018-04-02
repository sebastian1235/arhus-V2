<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "ap_items_invinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$ap_items_inv_view = NULL; // Initialize page object first

class cap_items_inv_view extends cap_items_inv {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{6A9AC718-A824-45A3-BED3-A95E91E6986D}";

	// Table name
	var $TableName = 'ap_items_inv';

	// Page object name
	var $PageObjName = 'ap_items_inv_view';

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

		// Table object (ap_items_inv)
		if (!isset($GLOBALS["ap_items_inv"]) || get_class($GLOBALS["ap_items_inv"]) == "cap_items_inv") {
			$GLOBALS["ap_items_inv"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ap_items_inv"];
		}
		$KeyUrl = "";
		if (@$_GET["Id_Item"] <> "") {
			$this->RecKey["Id_Item"] = $_GET["Id_Item"];
			$KeyUrl .= "&amp;Id_Item=" . urlencode($this->RecKey["Id_Item"]);
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
			define("EW_TABLE_NAME", 'ap_items_inv', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("ap_items_invlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->Id_Item->SetVisibility();
		$this->Id_Item->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->codigo_item->SetVisibility();
		$this->nombre_item->SetVisibility();
		$this->und_item->SetVisibility();
		$this->precio_item->SetVisibility();
		$this->costo_item->SetVisibility();
		$this->tipo_item->SetVisibility();
		$this->marca_item->SetVisibility();
		$this->cod_marca_item->SetVisibility();
		$this->detalle_item->SetVisibility();
		$this->saldo_item->SetVisibility();
		$this->activo_item->SetVisibility();
		$this->maneja_serial_item->SetVisibility();
		$this->asignado_item->SetVisibility();
		$this->si_no_item->SetVisibility();
		$this->precio_old_item->SetVisibility();
		$this->costo_old_item->SetVisibility();
		$this->registra_item->SetVisibility();
		$this->fecha_registro_item->SetVisibility();
		$this->empresa_item->SetVisibility();

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
		global $EW_EXPORT, $ap_items_inv;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($ap_items_inv);
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
			if (@$_GET["Id_Item"] <> "") {
				$this->Id_Item->setQueryStringValue($_GET["Id_Item"]);
				$this->RecKey["Id_Item"] = $this->Id_Item->QueryStringValue;
			} elseif (@$_POST["Id_Item"] <> "") {
				$this->Id_Item->setFormValue($_POST["Id_Item"]);
				$this->RecKey["Id_Item"] = $this->Id_Item->FormValue;
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
						$this->Page_Terminate("ap_items_invlist.php"); // Return to list page
					} elseif ($bLoadCurrentRecord) { // Load current record position
						$this->SetUpStartRec(); // Set up start record position

						// Point to current record
						if (intval($this->StartRec) <= intval($this->TotalRecs)) {
							$bMatchRecord = TRUE;
							$this->Recordset->Move($this->StartRec-1);
						}
					} else { // Match key values
						while (!$this->Recordset->EOF) {
							if (strval($this->Id_Item->CurrentValue) == strval($this->Recordset->fields('Id_Item'))) {
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
						$sReturnUrl = "ap_items_invlist.php"; // No matching record, return to list
					} else {
						$this->LoadRowValues($this->Recordset); // Load row values
					}
			}
		} else {
			$sReturnUrl = "ap_items_invlist.php"; // Not page request, return to list
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
		$this->Id_Item->setDbValue($rs->fields('Id_Item'));
		$this->codigo_item->setDbValue($rs->fields('codigo_item'));
		$this->nombre_item->setDbValue($rs->fields('nombre_item'));
		$this->und_item->setDbValue($rs->fields('und_item'));
		$this->precio_item->setDbValue($rs->fields('precio_item'));
		$this->costo_item->setDbValue($rs->fields('costo_item'));
		$this->tipo_item->setDbValue($rs->fields('tipo_item'));
		$this->marca_item->setDbValue($rs->fields('marca_item'));
		$this->cod_marca_item->setDbValue($rs->fields('cod_marca_item'));
		$this->detalle_item->setDbValue($rs->fields('detalle_item'));
		$this->saldo_item->setDbValue($rs->fields('saldo_item'));
		$this->activo_item->setDbValue($rs->fields('activo_item'));
		$this->maneja_serial_item->setDbValue($rs->fields('maneja_serial_item'));
		$this->asignado_item->setDbValue($rs->fields('asignado_item'));
		$this->si_no_item->setDbValue($rs->fields('si_no_item'));
		$this->precio_old_item->setDbValue($rs->fields('precio_old_item'));
		$this->costo_old_item->setDbValue($rs->fields('costo_old_item'));
		$this->registra_item->setDbValue($rs->fields('registra_item'));
		$this->fecha_registro_item->setDbValue($rs->fields('fecha_registro_item'));
		$this->empresa_item->setDbValue($rs->fields('empresa_item'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Id_Item->DbValue = $row['Id_Item'];
		$this->codigo_item->DbValue = $row['codigo_item'];
		$this->nombre_item->DbValue = $row['nombre_item'];
		$this->und_item->DbValue = $row['und_item'];
		$this->precio_item->DbValue = $row['precio_item'];
		$this->costo_item->DbValue = $row['costo_item'];
		$this->tipo_item->DbValue = $row['tipo_item'];
		$this->marca_item->DbValue = $row['marca_item'];
		$this->cod_marca_item->DbValue = $row['cod_marca_item'];
		$this->detalle_item->DbValue = $row['detalle_item'];
		$this->saldo_item->DbValue = $row['saldo_item'];
		$this->activo_item->DbValue = $row['activo_item'];
		$this->maneja_serial_item->DbValue = $row['maneja_serial_item'];
		$this->asignado_item->DbValue = $row['asignado_item'];
		$this->si_no_item->DbValue = $row['si_no_item'];
		$this->precio_old_item->DbValue = $row['precio_old_item'];
		$this->costo_old_item->DbValue = $row['costo_old_item'];
		$this->registra_item->DbValue = $row['registra_item'];
		$this->fecha_registro_item->DbValue = $row['fecha_registro_item'];
		$this->empresa_item->DbValue = $row['empresa_item'];
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
		if ($this->precio_item->FormValue == $this->precio_item->CurrentValue && is_numeric(ew_StrToFloat($this->precio_item->CurrentValue)))
			$this->precio_item->CurrentValue = ew_StrToFloat($this->precio_item->CurrentValue);

		// Convert decimal values if posted back
		if ($this->costo_item->FormValue == $this->costo_item->CurrentValue && is_numeric(ew_StrToFloat($this->costo_item->CurrentValue)))
			$this->costo_item->CurrentValue = ew_StrToFloat($this->costo_item->CurrentValue);

		// Convert decimal values if posted back
		if ($this->saldo_item->FormValue == $this->saldo_item->CurrentValue && is_numeric(ew_StrToFloat($this->saldo_item->CurrentValue)))
			$this->saldo_item->CurrentValue = ew_StrToFloat($this->saldo_item->CurrentValue);

		// Convert decimal values if posted back
		if ($this->precio_old_item->FormValue == $this->precio_old_item->CurrentValue && is_numeric(ew_StrToFloat($this->precio_old_item->CurrentValue)))
			$this->precio_old_item->CurrentValue = ew_StrToFloat($this->precio_old_item->CurrentValue);

		// Convert decimal values if posted back
		if ($this->costo_old_item->FormValue == $this->costo_old_item->CurrentValue && is_numeric(ew_StrToFloat($this->costo_old_item->CurrentValue)))
			$this->costo_old_item->CurrentValue = ew_StrToFloat($this->costo_old_item->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Item
		// codigo_item
		// nombre_item
		// und_item
		// precio_item
		// costo_item
		// tipo_item
		// marca_item
		// cod_marca_item
		// detalle_item
		// saldo_item
		// activo_item
		// maneja_serial_item
		// asignado_item
		// si_no_item
		// precio_old_item
		// costo_old_item
		// registra_item
		// fecha_registro_item
		// empresa_item

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Id_Item
		$this->Id_Item->ViewValue = $this->Id_Item->CurrentValue;
		$this->Id_Item->ViewCustomAttributes = "";

		// codigo_item
		$this->codigo_item->ViewValue = $this->codigo_item->CurrentValue;
		$this->codigo_item->ViewCustomAttributes = "";

		// nombre_item
		$this->nombre_item->ViewValue = $this->nombre_item->CurrentValue;
		$this->nombre_item->ViewCustomAttributes = "";

		// und_item
		$this->und_item->ViewValue = $this->und_item->CurrentValue;
		$this->und_item->ViewCustomAttributes = "";

		// precio_item
		$this->precio_item->ViewValue = $this->precio_item->CurrentValue;
		$this->precio_item->ViewCustomAttributes = "";

		// costo_item
		$this->costo_item->ViewValue = $this->costo_item->CurrentValue;
		$this->costo_item->ViewCustomAttributes = "";

		// tipo_item
		$this->tipo_item->ViewValue = $this->tipo_item->CurrentValue;
		$this->tipo_item->ViewCustomAttributes = "";

		// marca_item
		$this->marca_item->ViewValue = $this->marca_item->CurrentValue;
		$this->marca_item->ViewCustomAttributes = "";

		// cod_marca_item
		$this->cod_marca_item->ViewValue = $this->cod_marca_item->CurrentValue;
		$this->cod_marca_item->ViewCustomAttributes = "";

		// detalle_item
		$this->detalle_item->ViewValue = $this->detalle_item->CurrentValue;
		$this->detalle_item->ViewCustomAttributes = "";

		// saldo_item
		$this->saldo_item->ViewValue = $this->saldo_item->CurrentValue;
		$this->saldo_item->ViewCustomAttributes = "";

		// activo_item
		$this->activo_item->ViewValue = $this->activo_item->CurrentValue;
		$this->activo_item->ViewCustomAttributes = "";

		// maneja_serial_item
		$this->maneja_serial_item->ViewValue = $this->maneja_serial_item->CurrentValue;
		$this->maneja_serial_item->ViewCustomAttributes = "";

		// asignado_item
		$this->asignado_item->ViewValue = $this->asignado_item->CurrentValue;
		$this->asignado_item->ViewCustomAttributes = "";

		// si_no_item
		$this->si_no_item->ViewValue = $this->si_no_item->CurrentValue;
		$this->si_no_item->ViewCustomAttributes = "";

		// precio_old_item
		$this->precio_old_item->ViewValue = $this->precio_old_item->CurrentValue;
		$this->precio_old_item->ViewCustomAttributes = "";

		// costo_old_item
		$this->costo_old_item->ViewValue = $this->costo_old_item->CurrentValue;
		$this->costo_old_item->ViewCustomAttributes = "";

		// registra_item
		$this->registra_item->ViewValue = $this->registra_item->CurrentValue;
		$this->registra_item->ViewCustomAttributes = "";

		// fecha_registro_item
		$this->fecha_registro_item->ViewValue = $this->fecha_registro_item->CurrentValue;
		$this->fecha_registro_item->ViewValue = ew_FormatDateTime($this->fecha_registro_item->ViewValue, 0);
		$this->fecha_registro_item->ViewCustomAttributes = "";

		// empresa_item
		$this->empresa_item->ViewValue = $this->empresa_item->CurrentValue;
		$this->empresa_item->ViewCustomAttributes = "";

			// Id_Item
			$this->Id_Item->LinkCustomAttributes = "";
			$this->Id_Item->HrefValue = "";
			$this->Id_Item->TooltipValue = "";

			// codigo_item
			$this->codigo_item->LinkCustomAttributes = "";
			$this->codigo_item->HrefValue = "";
			$this->codigo_item->TooltipValue = "";

			// nombre_item
			$this->nombre_item->LinkCustomAttributes = "";
			$this->nombre_item->HrefValue = "";
			$this->nombre_item->TooltipValue = "";

			// und_item
			$this->und_item->LinkCustomAttributes = "";
			$this->und_item->HrefValue = "";
			$this->und_item->TooltipValue = "";

			// precio_item
			$this->precio_item->LinkCustomAttributes = "";
			$this->precio_item->HrefValue = "";
			$this->precio_item->TooltipValue = "";

			// costo_item
			$this->costo_item->LinkCustomAttributes = "";
			$this->costo_item->HrefValue = "";
			$this->costo_item->TooltipValue = "";

			// tipo_item
			$this->tipo_item->LinkCustomAttributes = "";
			$this->tipo_item->HrefValue = "";
			$this->tipo_item->TooltipValue = "";

			// marca_item
			$this->marca_item->LinkCustomAttributes = "";
			$this->marca_item->HrefValue = "";
			$this->marca_item->TooltipValue = "";

			// cod_marca_item
			$this->cod_marca_item->LinkCustomAttributes = "";
			$this->cod_marca_item->HrefValue = "";
			$this->cod_marca_item->TooltipValue = "";

			// detalle_item
			$this->detalle_item->LinkCustomAttributes = "";
			$this->detalle_item->HrefValue = "";
			$this->detalle_item->TooltipValue = "";

			// saldo_item
			$this->saldo_item->LinkCustomAttributes = "";
			$this->saldo_item->HrefValue = "";
			$this->saldo_item->TooltipValue = "";

			// activo_item
			$this->activo_item->LinkCustomAttributes = "";
			$this->activo_item->HrefValue = "";
			$this->activo_item->TooltipValue = "";

			// maneja_serial_item
			$this->maneja_serial_item->LinkCustomAttributes = "";
			$this->maneja_serial_item->HrefValue = "";
			$this->maneja_serial_item->TooltipValue = "";

			// asignado_item
			$this->asignado_item->LinkCustomAttributes = "";
			$this->asignado_item->HrefValue = "";
			$this->asignado_item->TooltipValue = "";

			// si_no_item
			$this->si_no_item->LinkCustomAttributes = "";
			$this->si_no_item->HrefValue = "";
			$this->si_no_item->TooltipValue = "";

			// precio_old_item
			$this->precio_old_item->LinkCustomAttributes = "";
			$this->precio_old_item->HrefValue = "";
			$this->precio_old_item->TooltipValue = "";

			// costo_old_item
			$this->costo_old_item->LinkCustomAttributes = "";
			$this->costo_old_item->HrefValue = "";
			$this->costo_old_item->TooltipValue = "";

			// registra_item
			$this->registra_item->LinkCustomAttributes = "";
			$this->registra_item->HrefValue = "";
			$this->registra_item->TooltipValue = "";

			// fecha_registro_item
			$this->fecha_registro_item->LinkCustomAttributes = "";
			$this->fecha_registro_item->HrefValue = "";
			$this->fecha_registro_item->TooltipValue = "";

			// empresa_item
			$this->empresa_item->LinkCustomAttributes = "";
			$this->empresa_item->HrefValue = "";
			$this->empresa_item->TooltipValue = "";
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("ap_items_invlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($ap_items_inv_view)) $ap_items_inv_view = new cap_items_inv_view();

// Page init
$ap_items_inv_view->Page_Init();

// Page main
$ap_items_inv_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ap_items_inv_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fap_items_invview = new ew_Form("fap_items_invview", "view");

// Form_CustomValidate event
fap_items_invview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fap_items_invview.ValidateRequired = true;
<?php } else { ?>
fap_items_invview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php if (!$ap_items_inv_view->IsModal) { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php $ap_items_inv_view->ExportOptions->Render("body") ?>
<?php
	foreach ($ap_items_inv_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$ap_items_inv_view->IsModal) { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php $ap_items_inv_view->ShowPageHeader(); ?>
<?php
$ap_items_inv_view->ShowMessage();
?>
<form name="fap_items_invview" id="fap_items_invview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($ap_items_inv_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $ap_items_inv_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ap_items_inv">
<?php if ($ap_items_inv_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($ap_items_inv->Id_Item->Visible) { // Id_Item ?>
	<tr id="r_Id_Item">
		<td><span id="elh_ap_items_inv_Id_Item"><?php echo $ap_items_inv->Id_Item->FldCaption() ?></span></td>
		<td data-name="Id_Item"<?php echo $ap_items_inv->Id_Item->CellAttributes() ?>>
<span id="el_ap_items_inv_Id_Item">
<span<?php echo $ap_items_inv->Id_Item->ViewAttributes() ?>>
<?php echo $ap_items_inv->Id_Item->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_items_inv->codigo_item->Visible) { // codigo_item ?>
	<tr id="r_codigo_item">
		<td><span id="elh_ap_items_inv_codigo_item"><?php echo $ap_items_inv->codigo_item->FldCaption() ?></span></td>
		<td data-name="codigo_item"<?php echo $ap_items_inv->codigo_item->CellAttributes() ?>>
<span id="el_ap_items_inv_codigo_item">
<span<?php echo $ap_items_inv->codigo_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->codigo_item->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_items_inv->nombre_item->Visible) { // nombre_item ?>
	<tr id="r_nombre_item">
		<td><span id="elh_ap_items_inv_nombre_item"><?php echo $ap_items_inv->nombre_item->FldCaption() ?></span></td>
		<td data-name="nombre_item"<?php echo $ap_items_inv->nombre_item->CellAttributes() ?>>
<span id="el_ap_items_inv_nombre_item">
<span<?php echo $ap_items_inv->nombre_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->nombre_item->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_items_inv->und_item->Visible) { // und_item ?>
	<tr id="r_und_item">
		<td><span id="elh_ap_items_inv_und_item"><?php echo $ap_items_inv->und_item->FldCaption() ?></span></td>
		<td data-name="und_item"<?php echo $ap_items_inv->und_item->CellAttributes() ?>>
<span id="el_ap_items_inv_und_item">
<span<?php echo $ap_items_inv->und_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->und_item->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_items_inv->precio_item->Visible) { // precio_item ?>
	<tr id="r_precio_item">
		<td><span id="elh_ap_items_inv_precio_item"><?php echo $ap_items_inv->precio_item->FldCaption() ?></span></td>
		<td data-name="precio_item"<?php echo $ap_items_inv->precio_item->CellAttributes() ?>>
<span id="el_ap_items_inv_precio_item">
<span<?php echo $ap_items_inv->precio_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->precio_item->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_items_inv->costo_item->Visible) { // costo_item ?>
	<tr id="r_costo_item">
		<td><span id="elh_ap_items_inv_costo_item"><?php echo $ap_items_inv->costo_item->FldCaption() ?></span></td>
		<td data-name="costo_item"<?php echo $ap_items_inv->costo_item->CellAttributes() ?>>
<span id="el_ap_items_inv_costo_item">
<span<?php echo $ap_items_inv->costo_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->costo_item->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_items_inv->tipo_item->Visible) { // tipo_item ?>
	<tr id="r_tipo_item">
		<td><span id="elh_ap_items_inv_tipo_item"><?php echo $ap_items_inv->tipo_item->FldCaption() ?></span></td>
		<td data-name="tipo_item"<?php echo $ap_items_inv->tipo_item->CellAttributes() ?>>
<span id="el_ap_items_inv_tipo_item">
<span<?php echo $ap_items_inv->tipo_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->tipo_item->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_items_inv->marca_item->Visible) { // marca_item ?>
	<tr id="r_marca_item">
		<td><span id="elh_ap_items_inv_marca_item"><?php echo $ap_items_inv->marca_item->FldCaption() ?></span></td>
		<td data-name="marca_item"<?php echo $ap_items_inv->marca_item->CellAttributes() ?>>
<span id="el_ap_items_inv_marca_item">
<span<?php echo $ap_items_inv->marca_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->marca_item->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_items_inv->cod_marca_item->Visible) { // cod_marca_item ?>
	<tr id="r_cod_marca_item">
		<td><span id="elh_ap_items_inv_cod_marca_item"><?php echo $ap_items_inv->cod_marca_item->FldCaption() ?></span></td>
		<td data-name="cod_marca_item"<?php echo $ap_items_inv->cod_marca_item->CellAttributes() ?>>
<span id="el_ap_items_inv_cod_marca_item">
<span<?php echo $ap_items_inv->cod_marca_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->cod_marca_item->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_items_inv->detalle_item->Visible) { // detalle_item ?>
	<tr id="r_detalle_item">
		<td><span id="elh_ap_items_inv_detalle_item"><?php echo $ap_items_inv->detalle_item->FldCaption() ?></span></td>
		<td data-name="detalle_item"<?php echo $ap_items_inv->detalle_item->CellAttributes() ?>>
<span id="el_ap_items_inv_detalle_item">
<span<?php echo $ap_items_inv->detalle_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->detalle_item->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_items_inv->saldo_item->Visible) { // saldo_item ?>
	<tr id="r_saldo_item">
		<td><span id="elh_ap_items_inv_saldo_item"><?php echo $ap_items_inv->saldo_item->FldCaption() ?></span></td>
		<td data-name="saldo_item"<?php echo $ap_items_inv->saldo_item->CellAttributes() ?>>
<span id="el_ap_items_inv_saldo_item">
<span<?php echo $ap_items_inv->saldo_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->saldo_item->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_items_inv->activo_item->Visible) { // activo_item ?>
	<tr id="r_activo_item">
		<td><span id="elh_ap_items_inv_activo_item"><?php echo $ap_items_inv->activo_item->FldCaption() ?></span></td>
		<td data-name="activo_item"<?php echo $ap_items_inv->activo_item->CellAttributes() ?>>
<span id="el_ap_items_inv_activo_item">
<span<?php echo $ap_items_inv->activo_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->activo_item->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_items_inv->maneja_serial_item->Visible) { // maneja_serial_item ?>
	<tr id="r_maneja_serial_item">
		<td><span id="elh_ap_items_inv_maneja_serial_item"><?php echo $ap_items_inv->maneja_serial_item->FldCaption() ?></span></td>
		<td data-name="maneja_serial_item"<?php echo $ap_items_inv->maneja_serial_item->CellAttributes() ?>>
<span id="el_ap_items_inv_maneja_serial_item">
<span<?php echo $ap_items_inv->maneja_serial_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->maneja_serial_item->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_items_inv->asignado_item->Visible) { // asignado_item ?>
	<tr id="r_asignado_item">
		<td><span id="elh_ap_items_inv_asignado_item"><?php echo $ap_items_inv->asignado_item->FldCaption() ?></span></td>
		<td data-name="asignado_item"<?php echo $ap_items_inv->asignado_item->CellAttributes() ?>>
<span id="el_ap_items_inv_asignado_item">
<span<?php echo $ap_items_inv->asignado_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->asignado_item->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_items_inv->si_no_item->Visible) { // si_no_item ?>
	<tr id="r_si_no_item">
		<td><span id="elh_ap_items_inv_si_no_item"><?php echo $ap_items_inv->si_no_item->FldCaption() ?></span></td>
		<td data-name="si_no_item"<?php echo $ap_items_inv->si_no_item->CellAttributes() ?>>
<span id="el_ap_items_inv_si_no_item">
<span<?php echo $ap_items_inv->si_no_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->si_no_item->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_items_inv->precio_old_item->Visible) { // precio_old_item ?>
	<tr id="r_precio_old_item">
		<td><span id="elh_ap_items_inv_precio_old_item"><?php echo $ap_items_inv->precio_old_item->FldCaption() ?></span></td>
		<td data-name="precio_old_item"<?php echo $ap_items_inv->precio_old_item->CellAttributes() ?>>
<span id="el_ap_items_inv_precio_old_item">
<span<?php echo $ap_items_inv->precio_old_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->precio_old_item->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_items_inv->costo_old_item->Visible) { // costo_old_item ?>
	<tr id="r_costo_old_item">
		<td><span id="elh_ap_items_inv_costo_old_item"><?php echo $ap_items_inv->costo_old_item->FldCaption() ?></span></td>
		<td data-name="costo_old_item"<?php echo $ap_items_inv->costo_old_item->CellAttributes() ?>>
<span id="el_ap_items_inv_costo_old_item">
<span<?php echo $ap_items_inv->costo_old_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->costo_old_item->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_items_inv->registra_item->Visible) { // registra_item ?>
	<tr id="r_registra_item">
		<td><span id="elh_ap_items_inv_registra_item"><?php echo $ap_items_inv->registra_item->FldCaption() ?></span></td>
		<td data-name="registra_item"<?php echo $ap_items_inv->registra_item->CellAttributes() ?>>
<span id="el_ap_items_inv_registra_item">
<span<?php echo $ap_items_inv->registra_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->registra_item->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_items_inv->fecha_registro_item->Visible) { // fecha_registro_item ?>
	<tr id="r_fecha_registro_item">
		<td><span id="elh_ap_items_inv_fecha_registro_item"><?php echo $ap_items_inv->fecha_registro_item->FldCaption() ?></span></td>
		<td data-name="fecha_registro_item"<?php echo $ap_items_inv->fecha_registro_item->CellAttributes() ?>>
<span id="el_ap_items_inv_fecha_registro_item">
<span<?php echo $ap_items_inv->fecha_registro_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->fecha_registro_item->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_items_inv->empresa_item->Visible) { // empresa_item ?>
	<tr id="r_empresa_item">
		<td><span id="elh_ap_items_inv_empresa_item"><?php echo $ap_items_inv->empresa_item->FldCaption() ?></span></td>
		<td data-name="empresa_item"<?php echo $ap_items_inv->empresa_item->CellAttributes() ?>>
<span id="el_ap_items_inv_empresa_item">
<span<?php echo $ap_items_inv->empresa_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->empresa_item->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if (!$ap_items_inv_view->IsModal) { ?>
<?php if (!isset($ap_items_inv_view->Pager)) $ap_items_inv_view->Pager = new cPrevNextPager($ap_items_inv_view->StartRec, $ap_items_inv_view->DisplayRecs, $ap_items_inv_view->TotalRecs) ?>
<?php if ($ap_items_inv_view->Pager->RecordCount > 0 && $ap_items_inv_view->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($ap_items_inv_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $ap_items_inv_view->PageUrl() ?>start=<?php echo $ap_items_inv_view->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($ap_items_inv_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $ap_items_inv_view->PageUrl() ?>start=<?php echo $ap_items_inv_view->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $ap_items_inv_view->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($ap_items_inv_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $ap_items_inv_view->PageUrl() ?>start=<?php echo $ap_items_inv_view->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($ap_items_inv_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $ap_items_inv_view->PageUrl() ?>start=<?php echo $ap_items_inv_view->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $ap_items_inv_view->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<script type="text/javascript">
fap_items_invview.Init();
</script>
<?php
$ap_items_inv_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ap_items_inv_view->Page_Terminate();
?>
