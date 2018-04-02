<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "ap_roles_usuariosinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$ap_roles_usuarios_view = NULL; // Initialize page object first

class cap_roles_usuarios_view extends cap_roles_usuarios {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{6A9AC718-A824-45A3-BED3-A95E91E6986D}";

	// Table name
	var $TableName = 'ap_roles_usuarios';

	// Page object name
	var $PageObjName = 'ap_roles_usuarios_view';

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

		// Table object (ap_roles_usuarios)
		if (!isset($GLOBALS["ap_roles_usuarios"]) || get_class($GLOBALS["ap_roles_usuarios"]) == "cap_roles_usuarios") {
			$GLOBALS["ap_roles_usuarios"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ap_roles_usuarios"];
		}
		$KeyUrl = "";
		if (@$_GET["Id_Rol"] <> "") {
			$this->RecKey["Id_Rol"] = $_GET["Id_Rol"];
			$KeyUrl .= "&amp;Id_Rol=" . urlencode($this->RecKey["Id_Rol"]);
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
			define("EW_TABLE_NAME", 'ap_roles_usuarios', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("ap_roles_usuarioslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->Id_Rol->SetVisibility();
		$this->Id_Rol->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->grupo_Rol->SetVisibility();
		$this->formulario_Rol->SetVisibility();
		$this->abrir_Rol->SetVisibility();
		$this->agregar_Rol->SetVisibility();
		$this->editar_Rol->SetVisibility();
		$this->eliminar_Rol->SetVisibility();
		$this->mostrar_Rol->SetVisibility();
		$this->alias_Rol->SetVisibility();
		$this->empresa_Rol->SetVisibility();

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
		global $EW_EXPORT, $ap_roles_usuarios;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($ap_roles_usuarios);
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
			if (@$_GET["Id_Rol"] <> "") {
				$this->Id_Rol->setQueryStringValue($_GET["Id_Rol"]);
				$this->RecKey["Id_Rol"] = $this->Id_Rol->QueryStringValue;
			} elseif (@$_POST["Id_Rol"] <> "") {
				$this->Id_Rol->setFormValue($_POST["Id_Rol"]);
				$this->RecKey["Id_Rol"] = $this->Id_Rol->FormValue;
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
						$this->Page_Terminate("ap_roles_usuarioslist.php"); // Return to list page
					} elseif ($bLoadCurrentRecord) { // Load current record position
						$this->SetUpStartRec(); // Set up start record position

						// Point to current record
						if (intval($this->StartRec) <= intval($this->TotalRecs)) {
							$bMatchRecord = TRUE;
							$this->Recordset->Move($this->StartRec-1);
						}
					} else { // Match key values
						while (!$this->Recordset->EOF) {
							if (strval($this->Id_Rol->CurrentValue) == strval($this->Recordset->fields('Id_Rol'))) {
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
						$sReturnUrl = "ap_roles_usuarioslist.php"; // No matching record, return to list
					} else {
						$this->LoadRowValues($this->Recordset); // Load row values
					}
			}
		} else {
			$sReturnUrl = "ap_roles_usuarioslist.php"; // Not page request, return to list
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
		$this->Id_Rol->setDbValue($rs->fields('Id_Rol'));
		$this->grupo_Rol->setDbValue($rs->fields('grupo_Rol'));
		$this->formulario_Rol->setDbValue($rs->fields('formulario_Rol'));
		$this->abrir_Rol->setDbValue($rs->fields('abrir_Rol'));
		$this->agregar_Rol->setDbValue($rs->fields('agregar_Rol'));
		$this->editar_Rol->setDbValue($rs->fields('editar_Rol'));
		$this->eliminar_Rol->setDbValue($rs->fields('eliminar_Rol'));
		$this->mostrar_Rol->setDbValue($rs->fields('mostrar_Rol'));
		$this->alias_Rol->setDbValue($rs->fields('alias_Rol'));
		$this->empresa_Rol->setDbValue($rs->fields('empresa_Rol'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Id_Rol->DbValue = $row['Id_Rol'];
		$this->grupo_Rol->DbValue = $row['grupo_Rol'];
		$this->formulario_Rol->DbValue = $row['formulario_Rol'];
		$this->abrir_Rol->DbValue = $row['abrir_Rol'];
		$this->agregar_Rol->DbValue = $row['agregar_Rol'];
		$this->editar_Rol->DbValue = $row['editar_Rol'];
		$this->eliminar_Rol->DbValue = $row['eliminar_Rol'];
		$this->mostrar_Rol->DbValue = $row['mostrar_Rol'];
		$this->alias_Rol->DbValue = $row['alias_Rol'];
		$this->empresa_Rol->DbValue = $row['empresa_Rol'];
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
		// Id_Rol
		// grupo_Rol
		// formulario_Rol
		// abrir_Rol
		// agregar_Rol
		// editar_Rol
		// eliminar_Rol
		// mostrar_Rol
		// alias_Rol
		// empresa_Rol

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Id_Rol
		$this->Id_Rol->ViewValue = $this->Id_Rol->CurrentValue;
		$this->Id_Rol->ViewCustomAttributes = "";

		// grupo_Rol
		$this->grupo_Rol->ViewValue = $this->grupo_Rol->CurrentValue;
		$this->grupo_Rol->ViewCustomAttributes = "";

		// formulario_Rol
		$this->formulario_Rol->ViewValue = $this->formulario_Rol->CurrentValue;
		$this->formulario_Rol->ViewCustomAttributes = "";

		// abrir_Rol
		$this->abrir_Rol->ViewValue = $this->abrir_Rol->CurrentValue;
		$this->abrir_Rol->ViewCustomAttributes = "";

		// agregar_Rol
		$this->agregar_Rol->ViewValue = $this->agregar_Rol->CurrentValue;
		$this->agregar_Rol->ViewCustomAttributes = "";

		// editar_Rol
		$this->editar_Rol->ViewValue = $this->editar_Rol->CurrentValue;
		$this->editar_Rol->ViewCustomAttributes = "";

		// eliminar_Rol
		$this->eliminar_Rol->ViewValue = $this->eliminar_Rol->CurrentValue;
		$this->eliminar_Rol->ViewCustomAttributes = "";

		// mostrar_Rol
		$this->mostrar_Rol->ViewValue = $this->mostrar_Rol->CurrentValue;
		$this->mostrar_Rol->ViewCustomAttributes = "";

		// alias_Rol
		$this->alias_Rol->ViewValue = $this->alias_Rol->CurrentValue;
		$this->alias_Rol->ViewCustomAttributes = "";

		// empresa_Rol
		$this->empresa_Rol->ViewValue = $this->empresa_Rol->CurrentValue;
		$this->empresa_Rol->ViewCustomAttributes = "";

			// Id_Rol
			$this->Id_Rol->LinkCustomAttributes = "";
			$this->Id_Rol->HrefValue = "";
			$this->Id_Rol->TooltipValue = "";

			// grupo_Rol
			$this->grupo_Rol->LinkCustomAttributes = "";
			$this->grupo_Rol->HrefValue = "";
			$this->grupo_Rol->TooltipValue = "";

			// formulario_Rol
			$this->formulario_Rol->LinkCustomAttributes = "";
			$this->formulario_Rol->HrefValue = "";
			$this->formulario_Rol->TooltipValue = "";

			// abrir_Rol
			$this->abrir_Rol->LinkCustomAttributes = "";
			$this->abrir_Rol->HrefValue = "";
			$this->abrir_Rol->TooltipValue = "";

			// agregar_Rol
			$this->agregar_Rol->LinkCustomAttributes = "";
			$this->agregar_Rol->HrefValue = "";
			$this->agregar_Rol->TooltipValue = "";

			// editar_Rol
			$this->editar_Rol->LinkCustomAttributes = "";
			$this->editar_Rol->HrefValue = "";
			$this->editar_Rol->TooltipValue = "";

			// eliminar_Rol
			$this->eliminar_Rol->LinkCustomAttributes = "";
			$this->eliminar_Rol->HrefValue = "";
			$this->eliminar_Rol->TooltipValue = "";

			// mostrar_Rol
			$this->mostrar_Rol->LinkCustomAttributes = "";
			$this->mostrar_Rol->HrefValue = "";
			$this->mostrar_Rol->TooltipValue = "";

			// alias_Rol
			$this->alias_Rol->LinkCustomAttributes = "";
			$this->alias_Rol->HrefValue = "";
			$this->alias_Rol->TooltipValue = "";

			// empresa_Rol
			$this->empresa_Rol->LinkCustomAttributes = "";
			$this->empresa_Rol->HrefValue = "";
			$this->empresa_Rol->TooltipValue = "";
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("ap_roles_usuarioslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($ap_roles_usuarios_view)) $ap_roles_usuarios_view = new cap_roles_usuarios_view();

// Page init
$ap_roles_usuarios_view->Page_Init();

// Page main
$ap_roles_usuarios_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ap_roles_usuarios_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fap_roles_usuariosview = new ew_Form("fap_roles_usuariosview", "view");

// Form_CustomValidate event
fap_roles_usuariosview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fap_roles_usuariosview.ValidateRequired = true;
<?php } else { ?>
fap_roles_usuariosview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php if (!$ap_roles_usuarios_view->IsModal) { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php $ap_roles_usuarios_view->ExportOptions->Render("body") ?>
<?php
	foreach ($ap_roles_usuarios_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$ap_roles_usuarios_view->IsModal) { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php $ap_roles_usuarios_view->ShowPageHeader(); ?>
<?php
$ap_roles_usuarios_view->ShowMessage();
?>
<form name="fap_roles_usuariosview" id="fap_roles_usuariosview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($ap_roles_usuarios_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $ap_roles_usuarios_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ap_roles_usuarios">
<?php if ($ap_roles_usuarios_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($ap_roles_usuarios->Id_Rol->Visible) { // Id_Rol ?>
	<tr id="r_Id_Rol">
		<td><span id="elh_ap_roles_usuarios_Id_Rol"><?php echo $ap_roles_usuarios->Id_Rol->FldCaption() ?></span></td>
		<td data-name="Id_Rol"<?php echo $ap_roles_usuarios->Id_Rol->CellAttributes() ?>>
<span id="el_ap_roles_usuarios_Id_Rol">
<span<?php echo $ap_roles_usuarios->Id_Rol->ViewAttributes() ?>>
<?php echo $ap_roles_usuarios->Id_Rol->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_roles_usuarios->grupo_Rol->Visible) { // grupo_Rol ?>
	<tr id="r_grupo_Rol">
		<td><span id="elh_ap_roles_usuarios_grupo_Rol"><?php echo $ap_roles_usuarios->grupo_Rol->FldCaption() ?></span></td>
		<td data-name="grupo_Rol"<?php echo $ap_roles_usuarios->grupo_Rol->CellAttributes() ?>>
<span id="el_ap_roles_usuarios_grupo_Rol">
<span<?php echo $ap_roles_usuarios->grupo_Rol->ViewAttributes() ?>>
<?php echo $ap_roles_usuarios->grupo_Rol->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_roles_usuarios->formulario_Rol->Visible) { // formulario_Rol ?>
	<tr id="r_formulario_Rol">
		<td><span id="elh_ap_roles_usuarios_formulario_Rol"><?php echo $ap_roles_usuarios->formulario_Rol->FldCaption() ?></span></td>
		<td data-name="formulario_Rol"<?php echo $ap_roles_usuarios->formulario_Rol->CellAttributes() ?>>
<span id="el_ap_roles_usuarios_formulario_Rol">
<span<?php echo $ap_roles_usuarios->formulario_Rol->ViewAttributes() ?>>
<?php echo $ap_roles_usuarios->formulario_Rol->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_roles_usuarios->abrir_Rol->Visible) { // abrir_Rol ?>
	<tr id="r_abrir_Rol">
		<td><span id="elh_ap_roles_usuarios_abrir_Rol"><?php echo $ap_roles_usuarios->abrir_Rol->FldCaption() ?></span></td>
		<td data-name="abrir_Rol"<?php echo $ap_roles_usuarios->abrir_Rol->CellAttributes() ?>>
<span id="el_ap_roles_usuarios_abrir_Rol">
<span<?php echo $ap_roles_usuarios->abrir_Rol->ViewAttributes() ?>>
<?php echo $ap_roles_usuarios->abrir_Rol->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_roles_usuarios->agregar_Rol->Visible) { // agregar_Rol ?>
	<tr id="r_agregar_Rol">
		<td><span id="elh_ap_roles_usuarios_agregar_Rol"><?php echo $ap_roles_usuarios->agregar_Rol->FldCaption() ?></span></td>
		<td data-name="agregar_Rol"<?php echo $ap_roles_usuarios->agregar_Rol->CellAttributes() ?>>
<span id="el_ap_roles_usuarios_agregar_Rol">
<span<?php echo $ap_roles_usuarios->agregar_Rol->ViewAttributes() ?>>
<?php echo $ap_roles_usuarios->agregar_Rol->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_roles_usuarios->editar_Rol->Visible) { // editar_Rol ?>
	<tr id="r_editar_Rol">
		<td><span id="elh_ap_roles_usuarios_editar_Rol"><?php echo $ap_roles_usuarios->editar_Rol->FldCaption() ?></span></td>
		<td data-name="editar_Rol"<?php echo $ap_roles_usuarios->editar_Rol->CellAttributes() ?>>
<span id="el_ap_roles_usuarios_editar_Rol">
<span<?php echo $ap_roles_usuarios->editar_Rol->ViewAttributes() ?>>
<?php echo $ap_roles_usuarios->editar_Rol->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_roles_usuarios->eliminar_Rol->Visible) { // eliminar_Rol ?>
	<tr id="r_eliminar_Rol">
		<td><span id="elh_ap_roles_usuarios_eliminar_Rol"><?php echo $ap_roles_usuarios->eliminar_Rol->FldCaption() ?></span></td>
		<td data-name="eliminar_Rol"<?php echo $ap_roles_usuarios->eliminar_Rol->CellAttributes() ?>>
<span id="el_ap_roles_usuarios_eliminar_Rol">
<span<?php echo $ap_roles_usuarios->eliminar_Rol->ViewAttributes() ?>>
<?php echo $ap_roles_usuarios->eliminar_Rol->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_roles_usuarios->mostrar_Rol->Visible) { // mostrar_Rol ?>
	<tr id="r_mostrar_Rol">
		<td><span id="elh_ap_roles_usuarios_mostrar_Rol"><?php echo $ap_roles_usuarios->mostrar_Rol->FldCaption() ?></span></td>
		<td data-name="mostrar_Rol"<?php echo $ap_roles_usuarios->mostrar_Rol->CellAttributes() ?>>
<span id="el_ap_roles_usuarios_mostrar_Rol">
<span<?php echo $ap_roles_usuarios->mostrar_Rol->ViewAttributes() ?>>
<?php echo $ap_roles_usuarios->mostrar_Rol->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_roles_usuarios->alias_Rol->Visible) { // alias_Rol ?>
	<tr id="r_alias_Rol">
		<td><span id="elh_ap_roles_usuarios_alias_Rol"><?php echo $ap_roles_usuarios->alias_Rol->FldCaption() ?></span></td>
		<td data-name="alias_Rol"<?php echo $ap_roles_usuarios->alias_Rol->CellAttributes() ?>>
<span id="el_ap_roles_usuarios_alias_Rol">
<span<?php echo $ap_roles_usuarios->alias_Rol->ViewAttributes() ?>>
<?php echo $ap_roles_usuarios->alias_Rol->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ap_roles_usuarios->empresa_Rol->Visible) { // empresa_Rol ?>
	<tr id="r_empresa_Rol">
		<td><span id="elh_ap_roles_usuarios_empresa_Rol"><?php echo $ap_roles_usuarios->empresa_Rol->FldCaption() ?></span></td>
		<td data-name="empresa_Rol"<?php echo $ap_roles_usuarios->empresa_Rol->CellAttributes() ?>>
<span id="el_ap_roles_usuarios_empresa_Rol">
<span<?php echo $ap_roles_usuarios->empresa_Rol->ViewAttributes() ?>>
<?php echo $ap_roles_usuarios->empresa_Rol->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if (!$ap_roles_usuarios_view->IsModal) { ?>
<?php if (!isset($ap_roles_usuarios_view->Pager)) $ap_roles_usuarios_view->Pager = new cPrevNextPager($ap_roles_usuarios_view->StartRec, $ap_roles_usuarios_view->DisplayRecs, $ap_roles_usuarios_view->TotalRecs) ?>
<?php if ($ap_roles_usuarios_view->Pager->RecordCount > 0 && $ap_roles_usuarios_view->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($ap_roles_usuarios_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $ap_roles_usuarios_view->PageUrl() ?>start=<?php echo $ap_roles_usuarios_view->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($ap_roles_usuarios_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $ap_roles_usuarios_view->PageUrl() ?>start=<?php echo $ap_roles_usuarios_view->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $ap_roles_usuarios_view->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($ap_roles_usuarios_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $ap_roles_usuarios_view->PageUrl() ?>start=<?php echo $ap_roles_usuarios_view->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($ap_roles_usuarios_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $ap_roles_usuarios_view->PageUrl() ?>start=<?php echo $ap_roles_usuarios_view->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $ap_roles_usuarios_view->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<script type="text/javascript">
fap_roles_usuariosview.Init();
</script>
<?php
$ap_roles_usuarios_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ap_roles_usuarios_view->Page_Terminate();
?>
