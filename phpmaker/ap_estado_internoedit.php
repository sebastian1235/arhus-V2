<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "ap_estado_internoinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$ap_estado_interno_edit = NULL; // Initialize page object first

class cap_estado_interno_edit extends cap_estado_interno {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{6A9AC718-A824-45A3-BED3-A95E91E6986D}";

	// Table name
	var $TableName = 'ap_estado_interno';

	// Page object name
	var $PageObjName = 'ap_estado_interno_edit';

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

		// Table object (ap_estado_interno)
		if (!isset($GLOBALS["ap_estado_interno"]) || get_class($GLOBALS["ap_estado_interno"]) == "cap_estado_interno") {
			$GLOBALS["ap_estado_interno"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ap_estado_interno"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ap_estado_interno', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// User table object (usuarios)
		if (!isset($UserTable)) {
			$UserTable = new cusuarios();
			$UserTableConn = Conn($UserTable->DBID);
		}
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
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("ap_estado_internolist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->nombre_estado_interno->SetVisibility();
		$this->para_factura_estado_interno->SetVisibility();
		$this->se_paga_comision_estado_interno->SetVisibility();
		$this->porcen_comision_estado_interno->SetVisibility();
		$this->se_paga_bono_estado_interno->SetVisibility();
		$this->porcen_bono_estado_interno->SetVisibility();
		$this->obs_estado_interno->SetVisibility();
		$this->envio_boffice_estado_interno->SetVisibility();
		$this->empresa_estado_interno->SetVisibility();
		$this->id_estado_interno->SetVisibility();
		$this->id_estado_interno->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
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
		global $EW_EXPORT, $ap_estado_interno;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($ap_estado_interno);
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
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Load key from QueryString
		if (@$_GET["id_estado_interno"] <> "") {
			$this->id_estado_interno->setQueryStringValue($_GET["id_estado_interno"]);
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->id_estado_interno->CurrentValue == "") {
			$this->Page_Terminate("ap_estado_internolist.php"); // Invalid key, return to list
		}

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("ap_estado_internolist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "ap_estado_internolist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
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

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->nombre_estado_interno->FldIsDetailKey) {
			$this->nombre_estado_interno->setFormValue($objForm->GetValue("x_nombre_estado_interno"));
		}
		if (!$this->para_factura_estado_interno->FldIsDetailKey) {
			$this->para_factura_estado_interno->setFormValue($objForm->GetValue("x_para_factura_estado_interno"));
		}
		if (!$this->se_paga_comision_estado_interno->FldIsDetailKey) {
			$this->se_paga_comision_estado_interno->setFormValue($objForm->GetValue("x_se_paga_comision_estado_interno"));
		}
		if (!$this->porcen_comision_estado_interno->FldIsDetailKey) {
			$this->porcen_comision_estado_interno->setFormValue($objForm->GetValue("x_porcen_comision_estado_interno"));
		}
		if (!$this->se_paga_bono_estado_interno->FldIsDetailKey) {
			$this->se_paga_bono_estado_interno->setFormValue($objForm->GetValue("x_se_paga_bono_estado_interno"));
		}
		if (!$this->porcen_bono_estado_interno->FldIsDetailKey) {
			$this->porcen_bono_estado_interno->setFormValue($objForm->GetValue("x_porcen_bono_estado_interno"));
		}
		if (!$this->obs_estado_interno->FldIsDetailKey) {
			$this->obs_estado_interno->setFormValue($objForm->GetValue("x_obs_estado_interno"));
		}
		if (!$this->envio_boffice_estado_interno->FldIsDetailKey) {
			$this->envio_boffice_estado_interno->setFormValue($objForm->GetValue("x_envio_boffice_estado_interno"));
		}
		if (!$this->empresa_estado_interno->FldIsDetailKey) {
			$this->empresa_estado_interno->setFormValue($objForm->GetValue("x_empresa_estado_interno"));
		}
		if (!$this->id_estado_interno->FldIsDetailKey)
			$this->id_estado_interno->setFormValue($objForm->GetValue("x_id_estado_interno"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->nombre_estado_interno->CurrentValue = $this->nombre_estado_interno->FormValue;
		$this->para_factura_estado_interno->CurrentValue = $this->para_factura_estado_interno->FormValue;
		$this->se_paga_comision_estado_interno->CurrentValue = $this->se_paga_comision_estado_interno->FormValue;
		$this->porcen_comision_estado_interno->CurrentValue = $this->porcen_comision_estado_interno->FormValue;
		$this->se_paga_bono_estado_interno->CurrentValue = $this->se_paga_bono_estado_interno->FormValue;
		$this->porcen_bono_estado_interno->CurrentValue = $this->porcen_bono_estado_interno->FormValue;
		$this->obs_estado_interno->CurrentValue = $this->obs_estado_interno->FormValue;
		$this->envio_boffice_estado_interno->CurrentValue = $this->envio_boffice_estado_interno->FormValue;
		$this->empresa_estado_interno->CurrentValue = $this->empresa_estado_interno->FormValue;
		$this->id_estado_interno->CurrentValue = $this->id_estado_interno->FormValue;
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
		$this->nombre_estado_interno->setDbValue($rs->fields('nombre_estado_interno'));
		$this->para_factura_estado_interno->setDbValue($rs->fields('para_factura_estado_interno'));
		$this->se_paga_comision_estado_interno->setDbValue($rs->fields('se_paga_comision_estado_interno'));
		$this->porcen_comision_estado_interno->setDbValue($rs->fields('porcen_comision_estado_interno'));
		$this->se_paga_bono_estado_interno->setDbValue($rs->fields('se_paga_bono_estado_interno'));
		$this->porcen_bono_estado_interno->setDbValue($rs->fields('porcen_bono_estado_interno'));
		$this->obs_estado_interno->setDbValue($rs->fields('obs_estado_interno'));
		$this->envio_boffice_estado_interno->setDbValue($rs->fields('envio_boffice_estado_interno'));
		$this->empresa_estado_interno->setDbValue($rs->fields('empresa_estado_interno'));
		$this->id_estado_interno->setDbValue($rs->fields('id_estado_interno'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->nombre_estado_interno->DbValue = $row['nombre_estado_interno'];
		$this->para_factura_estado_interno->DbValue = $row['para_factura_estado_interno'];
		$this->se_paga_comision_estado_interno->DbValue = $row['se_paga_comision_estado_interno'];
		$this->porcen_comision_estado_interno->DbValue = $row['porcen_comision_estado_interno'];
		$this->se_paga_bono_estado_interno->DbValue = $row['se_paga_bono_estado_interno'];
		$this->porcen_bono_estado_interno->DbValue = $row['porcen_bono_estado_interno'];
		$this->obs_estado_interno->DbValue = $row['obs_estado_interno'];
		$this->envio_boffice_estado_interno->DbValue = $row['envio_boffice_estado_interno'];
		$this->empresa_estado_interno->DbValue = $row['empresa_estado_interno'];
		$this->id_estado_interno->DbValue = $row['id_estado_interno'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->porcen_comision_estado_interno->FormValue == $this->porcen_comision_estado_interno->CurrentValue && is_numeric(ew_StrToFloat($this->porcen_comision_estado_interno->CurrentValue)))
			$this->porcen_comision_estado_interno->CurrentValue = ew_StrToFloat($this->porcen_comision_estado_interno->CurrentValue);

		// Convert decimal values if posted back
		if ($this->porcen_bono_estado_interno->FormValue == $this->porcen_bono_estado_interno->CurrentValue && is_numeric(ew_StrToFloat($this->porcen_bono_estado_interno->CurrentValue)))
			$this->porcen_bono_estado_interno->CurrentValue = ew_StrToFloat($this->porcen_bono_estado_interno->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// nombre_estado_interno
		// para_factura_estado_interno
		// se_paga_comision_estado_interno
		// porcen_comision_estado_interno
		// se_paga_bono_estado_interno
		// porcen_bono_estado_interno
		// obs_estado_interno
		// envio_boffice_estado_interno
		// empresa_estado_interno
		// id_estado_interno

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// nombre_estado_interno
		$this->nombre_estado_interno->ViewValue = $this->nombre_estado_interno->CurrentValue;
		$this->nombre_estado_interno->ViewCustomAttributes = "";

		// para_factura_estado_interno
		$this->para_factura_estado_interno->ViewValue = $this->para_factura_estado_interno->CurrentValue;
		$this->para_factura_estado_interno->ViewCustomAttributes = "";

		// se_paga_comision_estado_interno
		$this->se_paga_comision_estado_interno->ViewValue = $this->se_paga_comision_estado_interno->CurrentValue;
		$this->se_paga_comision_estado_interno->ViewCustomAttributes = "";

		// porcen_comision_estado_interno
		$this->porcen_comision_estado_interno->ViewValue = $this->porcen_comision_estado_interno->CurrentValue;
		$this->porcen_comision_estado_interno->ViewCustomAttributes = "";

		// se_paga_bono_estado_interno
		$this->se_paga_bono_estado_interno->ViewValue = $this->se_paga_bono_estado_interno->CurrentValue;
		$this->se_paga_bono_estado_interno->ViewCustomAttributes = "";

		// porcen_bono_estado_interno
		$this->porcen_bono_estado_interno->ViewValue = $this->porcen_bono_estado_interno->CurrentValue;
		$this->porcen_bono_estado_interno->ViewCustomAttributes = "";

		// obs_estado_interno
		$this->obs_estado_interno->ViewValue = $this->obs_estado_interno->CurrentValue;
		$this->obs_estado_interno->ViewCustomAttributes = "";

		// envio_boffice_estado_interno
		$this->envio_boffice_estado_interno->ViewValue = $this->envio_boffice_estado_interno->CurrentValue;
		$this->envio_boffice_estado_interno->ViewCustomAttributes = "";

		// empresa_estado_interno
		$this->empresa_estado_interno->ViewValue = $this->empresa_estado_interno->CurrentValue;
		$this->empresa_estado_interno->ViewCustomAttributes = "";

		// id_estado_interno
		$this->id_estado_interno->ViewValue = $this->id_estado_interno->CurrentValue;
		$this->id_estado_interno->ViewCustomAttributes = "";

			// nombre_estado_interno
			$this->nombre_estado_interno->LinkCustomAttributes = "";
			$this->nombre_estado_interno->HrefValue = "";
			$this->nombre_estado_interno->TooltipValue = "";

			// para_factura_estado_interno
			$this->para_factura_estado_interno->LinkCustomAttributes = "";
			$this->para_factura_estado_interno->HrefValue = "";
			$this->para_factura_estado_interno->TooltipValue = "";

			// se_paga_comision_estado_interno
			$this->se_paga_comision_estado_interno->LinkCustomAttributes = "";
			$this->se_paga_comision_estado_interno->HrefValue = "";
			$this->se_paga_comision_estado_interno->TooltipValue = "";

			// porcen_comision_estado_interno
			$this->porcen_comision_estado_interno->LinkCustomAttributes = "";
			$this->porcen_comision_estado_interno->HrefValue = "";
			$this->porcen_comision_estado_interno->TooltipValue = "";

			// se_paga_bono_estado_interno
			$this->se_paga_bono_estado_interno->LinkCustomAttributes = "";
			$this->se_paga_bono_estado_interno->HrefValue = "";
			$this->se_paga_bono_estado_interno->TooltipValue = "";

			// porcen_bono_estado_interno
			$this->porcen_bono_estado_interno->LinkCustomAttributes = "";
			$this->porcen_bono_estado_interno->HrefValue = "";
			$this->porcen_bono_estado_interno->TooltipValue = "";

			// obs_estado_interno
			$this->obs_estado_interno->LinkCustomAttributes = "";
			$this->obs_estado_interno->HrefValue = "";
			$this->obs_estado_interno->TooltipValue = "";

			// envio_boffice_estado_interno
			$this->envio_boffice_estado_interno->LinkCustomAttributes = "";
			$this->envio_boffice_estado_interno->HrefValue = "";
			$this->envio_boffice_estado_interno->TooltipValue = "";

			// empresa_estado_interno
			$this->empresa_estado_interno->LinkCustomAttributes = "";
			$this->empresa_estado_interno->HrefValue = "";
			$this->empresa_estado_interno->TooltipValue = "";

			// id_estado_interno
			$this->id_estado_interno->LinkCustomAttributes = "";
			$this->id_estado_interno->HrefValue = "";
			$this->id_estado_interno->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// nombre_estado_interno
			$this->nombre_estado_interno->EditAttrs["class"] = "form-control";
			$this->nombre_estado_interno->EditCustomAttributes = "";
			$this->nombre_estado_interno->EditValue = ew_HtmlEncode($this->nombre_estado_interno->CurrentValue);
			$this->nombre_estado_interno->PlaceHolder = ew_RemoveHtml($this->nombre_estado_interno->FldCaption());

			// para_factura_estado_interno
			$this->para_factura_estado_interno->EditAttrs["class"] = "form-control";
			$this->para_factura_estado_interno->EditCustomAttributes = "";
			$this->para_factura_estado_interno->EditValue = ew_HtmlEncode($this->para_factura_estado_interno->CurrentValue);
			$this->para_factura_estado_interno->PlaceHolder = ew_RemoveHtml($this->para_factura_estado_interno->FldCaption());

			// se_paga_comision_estado_interno
			$this->se_paga_comision_estado_interno->EditAttrs["class"] = "form-control";
			$this->se_paga_comision_estado_interno->EditCustomAttributes = "";
			$this->se_paga_comision_estado_interno->EditValue = ew_HtmlEncode($this->se_paga_comision_estado_interno->CurrentValue);
			$this->se_paga_comision_estado_interno->PlaceHolder = ew_RemoveHtml($this->se_paga_comision_estado_interno->FldCaption());

			// porcen_comision_estado_interno
			$this->porcen_comision_estado_interno->EditAttrs["class"] = "form-control";
			$this->porcen_comision_estado_interno->EditCustomAttributes = "";
			$this->porcen_comision_estado_interno->EditValue = ew_HtmlEncode($this->porcen_comision_estado_interno->CurrentValue);
			$this->porcen_comision_estado_interno->PlaceHolder = ew_RemoveHtml($this->porcen_comision_estado_interno->FldCaption());
			if (strval($this->porcen_comision_estado_interno->EditValue) <> "" && is_numeric($this->porcen_comision_estado_interno->EditValue)) $this->porcen_comision_estado_interno->EditValue = ew_FormatNumber($this->porcen_comision_estado_interno->EditValue, -2, -1, -2, 0);

			// se_paga_bono_estado_interno
			$this->se_paga_bono_estado_interno->EditAttrs["class"] = "form-control";
			$this->se_paga_bono_estado_interno->EditCustomAttributes = "";
			$this->se_paga_bono_estado_interno->EditValue = ew_HtmlEncode($this->se_paga_bono_estado_interno->CurrentValue);
			$this->se_paga_bono_estado_interno->PlaceHolder = ew_RemoveHtml($this->se_paga_bono_estado_interno->FldCaption());

			// porcen_bono_estado_interno
			$this->porcen_bono_estado_interno->EditAttrs["class"] = "form-control";
			$this->porcen_bono_estado_interno->EditCustomAttributes = "";
			$this->porcen_bono_estado_interno->EditValue = ew_HtmlEncode($this->porcen_bono_estado_interno->CurrentValue);
			$this->porcen_bono_estado_interno->PlaceHolder = ew_RemoveHtml($this->porcen_bono_estado_interno->FldCaption());
			if (strval($this->porcen_bono_estado_interno->EditValue) <> "" && is_numeric($this->porcen_bono_estado_interno->EditValue)) $this->porcen_bono_estado_interno->EditValue = ew_FormatNumber($this->porcen_bono_estado_interno->EditValue, -2, -1, -2, 0);

			// obs_estado_interno
			$this->obs_estado_interno->EditAttrs["class"] = "form-control";
			$this->obs_estado_interno->EditCustomAttributes = "";
			$this->obs_estado_interno->EditValue = ew_HtmlEncode($this->obs_estado_interno->CurrentValue);
			$this->obs_estado_interno->PlaceHolder = ew_RemoveHtml($this->obs_estado_interno->FldCaption());

			// envio_boffice_estado_interno
			$this->envio_boffice_estado_interno->EditAttrs["class"] = "form-control";
			$this->envio_boffice_estado_interno->EditCustomAttributes = "";
			$this->envio_boffice_estado_interno->EditValue = ew_HtmlEncode($this->envio_boffice_estado_interno->CurrentValue);
			$this->envio_boffice_estado_interno->PlaceHolder = ew_RemoveHtml($this->envio_boffice_estado_interno->FldCaption());

			// empresa_estado_interno
			$this->empresa_estado_interno->EditAttrs["class"] = "form-control";
			$this->empresa_estado_interno->EditCustomAttributes = "";
			$this->empresa_estado_interno->EditValue = ew_HtmlEncode($this->empresa_estado_interno->CurrentValue);
			$this->empresa_estado_interno->PlaceHolder = ew_RemoveHtml($this->empresa_estado_interno->FldCaption());

			// id_estado_interno
			$this->id_estado_interno->EditAttrs["class"] = "form-control";
			$this->id_estado_interno->EditCustomAttributes = "";
			$this->id_estado_interno->EditValue = $this->id_estado_interno->CurrentValue;
			$this->id_estado_interno->ViewCustomAttributes = "";

			// Edit refer script
			// nombre_estado_interno

			$this->nombre_estado_interno->LinkCustomAttributes = "";
			$this->nombre_estado_interno->HrefValue = "";

			// para_factura_estado_interno
			$this->para_factura_estado_interno->LinkCustomAttributes = "";
			$this->para_factura_estado_interno->HrefValue = "";

			// se_paga_comision_estado_interno
			$this->se_paga_comision_estado_interno->LinkCustomAttributes = "";
			$this->se_paga_comision_estado_interno->HrefValue = "";

			// porcen_comision_estado_interno
			$this->porcen_comision_estado_interno->LinkCustomAttributes = "";
			$this->porcen_comision_estado_interno->HrefValue = "";

			// se_paga_bono_estado_interno
			$this->se_paga_bono_estado_interno->LinkCustomAttributes = "";
			$this->se_paga_bono_estado_interno->HrefValue = "";

			// porcen_bono_estado_interno
			$this->porcen_bono_estado_interno->LinkCustomAttributes = "";
			$this->porcen_bono_estado_interno->HrefValue = "";

			// obs_estado_interno
			$this->obs_estado_interno->LinkCustomAttributes = "";
			$this->obs_estado_interno->HrefValue = "";

			// envio_boffice_estado_interno
			$this->envio_boffice_estado_interno->LinkCustomAttributes = "";
			$this->envio_boffice_estado_interno->HrefValue = "";

			// empresa_estado_interno
			$this->empresa_estado_interno->LinkCustomAttributes = "";
			$this->empresa_estado_interno->HrefValue = "";

			// id_estado_interno
			$this->id_estado_interno->LinkCustomAttributes = "";
			$this->id_estado_interno->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!ew_CheckInteger($this->para_factura_estado_interno->FormValue)) {
			ew_AddMessage($gsFormError, $this->para_factura_estado_interno->FldErrMsg());
		}
		if (!ew_CheckInteger($this->se_paga_comision_estado_interno->FormValue)) {
			ew_AddMessage($gsFormError, $this->se_paga_comision_estado_interno->FldErrMsg());
		}
		if (!ew_CheckNumber($this->porcen_comision_estado_interno->FormValue)) {
			ew_AddMessage($gsFormError, $this->porcen_comision_estado_interno->FldErrMsg());
		}
		if (!ew_CheckInteger($this->se_paga_bono_estado_interno->FormValue)) {
			ew_AddMessage($gsFormError, $this->se_paga_bono_estado_interno->FldErrMsg());
		}
		if (!ew_CheckNumber($this->porcen_bono_estado_interno->FormValue)) {
			ew_AddMessage($gsFormError, $this->porcen_bono_estado_interno->FldErrMsg());
		}
		if (!ew_CheckInteger($this->envio_boffice_estado_interno->FormValue)) {
			ew_AddMessage($gsFormError, $this->envio_boffice_estado_interno->FldErrMsg());
		}
		if (!ew_CheckInteger($this->empresa_estado_interno->FormValue)) {
			ew_AddMessage($gsFormError, $this->empresa_estado_interno->FldErrMsg());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// nombre_estado_interno
			$this->nombre_estado_interno->SetDbValueDef($rsnew, $this->nombre_estado_interno->CurrentValue, NULL, $this->nombre_estado_interno->ReadOnly);

			// para_factura_estado_interno
			$this->para_factura_estado_interno->SetDbValueDef($rsnew, $this->para_factura_estado_interno->CurrentValue, NULL, $this->para_factura_estado_interno->ReadOnly);

			// se_paga_comision_estado_interno
			$this->se_paga_comision_estado_interno->SetDbValueDef($rsnew, $this->se_paga_comision_estado_interno->CurrentValue, NULL, $this->se_paga_comision_estado_interno->ReadOnly);

			// porcen_comision_estado_interno
			$this->porcen_comision_estado_interno->SetDbValueDef($rsnew, $this->porcen_comision_estado_interno->CurrentValue, NULL, $this->porcen_comision_estado_interno->ReadOnly);

			// se_paga_bono_estado_interno
			$this->se_paga_bono_estado_interno->SetDbValueDef($rsnew, $this->se_paga_bono_estado_interno->CurrentValue, NULL, $this->se_paga_bono_estado_interno->ReadOnly);

			// porcen_bono_estado_interno
			$this->porcen_bono_estado_interno->SetDbValueDef($rsnew, $this->porcen_bono_estado_interno->CurrentValue, NULL, $this->porcen_bono_estado_interno->ReadOnly);

			// obs_estado_interno
			$this->obs_estado_interno->SetDbValueDef($rsnew, $this->obs_estado_interno->CurrentValue, NULL, $this->obs_estado_interno->ReadOnly);

			// envio_boffice_estado_interno
			$this->envio_boffice_estado_interno->SetDbValueDef($rsnew, $this->envio_boffice_estado_interno->CurrentValue, NULL, $this->envio_boffice_estado_interno->ReadOnly);

			// empresa_estado_interno
			$this->empresa_estado_interno->SetDbValueDef($rsnew, $this->empresa_estado_interno->CurrentValue, NULL, $this->empresa_estado_interno->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("ap_estado_internolist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($ap_estado_interno_edit)) $ap_estado_interno_edit = new cap_estado_interno_edit();

// Page init
$ap_estado_interno_edit->Page_Init();

// Page main
$ap_estado_interno_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ap_estado_interno_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fap_estado_internoedit = new ew_Form("fap_estado_internoedit", "edit");

// Validate form
fap_estado_internoedit.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_para_factura_estado_interno");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_estado_interno->para_factura_estado_interno->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_se_paga_comision_estado_interno");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_estado_interno->se_paga_comision_estado_interno->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_porcen_comision_estado_interno");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_estado_interno->porcen_comision_estado_interno->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_se_paga_bono_estado_interno");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_estado_interno->se_paga_bono_estado_interno->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_porcen_bono_estado_interno");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_estado_interno->porcen_bono_estado_interno->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_envio_boffice_estado_interno");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_estado_interno->envio_boffice_estado_interno->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_empresa_estado_interno");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_estado_interno->empresa_estado_interno->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fap_estado_internoedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fap_estado_internoedit.ValidateRequired = true;
<?php } else { ?>
fap_estado_internoedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$ap_estado_interno_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $ap_estado_interno_edit->ShowPageHeader(); ?>
<?php
$ap_estado_interno_edit->ShowMessage();
?>
<form name="fap_estado_internoedit" id="fap_estado_internoedit" class="<?php echo $ap_estado_interno_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($ap_estado_interno_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $ap_estado_interno_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ap_estado_interno">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($ap_estado_interno_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($ap_estado_interno->nombre_estado_interno->Visible) { // nombre_estado_interno ?>
	<div id="r_nombre_estado_interno" class="form-group">
		<label id="elh_ap_estado_interno_nombre_estado_interno" for="x_nombre_estado_interno" class="col-sm-2 control-label ewLabel"><?php echo $ap_estado_interno->nombre_estado_interno->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_estado_interno->nombre_estado_interno->CellAttributes() ?>>
<span id="el_ap_estado_interno_nombre_estado_interno">
<input type="text" data-table="ap_estado_interno" data-field="x_nombre_estado_interno" name="x_nombre_estado_interno" id="x_nombre_estado_interno" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($ap_estado_interno->nombre_estado_interno->getPlaceHolder()) ?>" value="<?php echo $ap_estado_interno->nombre_estado_interno->EditValue ?>"<?php echo $ap_estado_interno->nombre_estado_interno->EditAttributes() ?>>
</span>
<?php echo $ap_estado_interno->nombre_estado_interno->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_estado_interno->para_factura_estado_interno->Visible) { // para_factura_estado_interno ?>
	<div id="r_para_factura_estado_interno" class="form-group">
		<label id="elh_ap_estado_interno_para_factura_estado_interno" for="x_para_factura_estado_interno" class="col-sm-2 control-label ewLabel"><?php echo $ap_estado_interno->para_factura_estado_interno->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_estado_interno->para_factura_estado_interno->CellAttributes() ?>>
<span id="el_ap_estado_interno_para_factura_estado_interno">
<input type="text" data-table="ap_estado_interno" data-field="x_para_factura_estado_interno" name="x_para_factura_estado_interno" id="x_para_factura_estado_interno" size="30" placeholder="<?php echo ew_HtmlEncode($ap_estado_interno->para_factura_estado_interno->getPlaceHolder()) ?>" value="<?php echo $ap_estado_interno->para_factura_estado_interno->EditValue ?>"<?php echo $ap_estado_interno->para_factura_estado_interno->EditAttributes() ?>>
</span>
<?php echo $ap_estado_interno->para_factura_estado_interno->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_estado_interno->se_paga_comision_estado_interno->Visible) { // se_paga_comision_estado_interno ?>
	<div id="r_se_paga_comision_estado_interno" class="form-group">
		<label id="elh_ap_estado_interno_se_paga_comision_estado_interno" for="x_se_paga_comision_estado_interno" class="col-sm-2 control-label ewLabel"><?php echo $ap_estado_interno->se_paga_comision_estado_interno->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_estado_interno->se_paga_comision_estado_interno->CellAttributes() ?>>
<span id="el_ap_estado_interno_se_paga_comision_estado_interno">
<input type="text" data-table="ap_estado_interno" data-field="x_se_paga_comision_estado_interno" name="x_se_paga_comision_estado_interno" id="x_se_paga_comision_estado_interno" size="30" placeholder="<?php echo ew_HtmlEncode($ap_estado_interno->se_paga_comision_estado_interno->getPlaceHolder()) ?>" value="<?php echo $ap_estado_interno->se_paga_comision_estado_interno->EditValue ?>"<?php echo $ap_estado_interno->se_paga_comision_estado_interno->EditAttributes() ?>>
</span>
<?php echo $ap_estado_interno->se_paga_comision_estado_interno->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_estado_interno->porcen_comision_estado_interno->Visible) { // porcen_comision_estado_interno ?>
	<div id="r_porcen_comision_estado_interno" class="form-group">
		<label id="elh_ap_estado_interno_porcen_comision_estado_interno" for="x_porcen_comision_estado_interno" class="col-sm-2 control-label ewLabel"><?php echo $ap_estado_interno->porcen_comision_estado_interno->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_estado_interno->porcen_comision_estado_interno->CellAttributes() ?>>
<span id="el_ap_estado_interno_porcen_comision_estado_interno">
<input type="text" data-table="ap_estado_interno" data-field="x_porcen_comision_estado_interno" name="x_porcen_comision_estado_interno" id="x_porcen_comision_estado_interno" size="30" placeholder="<?php echo ew_HtmlEncode($ap_estado_interno->porcen_comision_estado_interno->getPlaceHolder()) ?>" value="<?php echo $ap_estado_interno->porcen_comision_estado_interno->EditValue ?>"<?php echo $ap_estado_interno->porcen_comision_estado_interno->EditAttributes() ?>>
</span>
<?php echo $ap_estado_interno->porcen_comision_estado_interno->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_estado_interno->se_paga_bono_estado_interno->Visible) { // se_paga_bono_estado_interno ?>
	<div id="r_se_paga_bono_estado_interno" class="form-group">
		<label id="elh_ap_estado_interno_se_paga_bono_estado_interno" for="x_se_paga_bono_estado_interno" class="col-sm-2 control-label ewLabel"><?php echo $ap_estado_interno->se_paga_bono_estado_interno->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_estado_interno->se_paga_bono_estado_interno->CellAttributes() ?>>
<span id="el_ap_estado_interno_se_paga_bono_estado_interno">
<input type="text" data-table="ap_estado_interno" data-field="x_se_paga_bono_estado_interno" name="x_se_paga_bono_estado_interno" id="x_se_paga_bono_estado_interno" size="30" placeholder="<?php echo ew_HtmlEncode($ap_estado_interno->se_paga_bono_estado_interno->getPlaceHolder()) ?>" value="<?php echo $ap_estado_interno->se_paga_bono_estado_interno->EditValue ?>"<?php echo $ap_estado_interno->se_paga_bono_estado_interno->EditAttributes() ?>>
</span>
<?php echo $ap_estado_interno->se_paga_bono_estado_interno->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_estado_interno->porcen_bono_estado_interno->Visible) { // porcen_bono_estado_interno ?>
	<div id="r_porcen_bono_estado_interno" class="form-group">
		<label id="elh_ap_estado_interno_porcen_bono_estado_interno" for="x_porcen_bono_estado_interno" class="col-sm-2 control-label ewLabel"><?php echo $ap_estado_interno->porcen_bono_estado_interno->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_estado_interno->porcen_bono_estado_interno->CellAttributes() ?>>
<span id="el_ap_estado_interno_porcen_bono_estado_interno">
<input type="text" data-table="ap_estado_interno" data-field="x_porcen_bono_estado_interno" name="x_porcen_bono_estado_interno" id="x_porcen_bono_estado_interno" size="30" placeholder="<?php echo ew_HtmlEncode($ap_estado_interno->porcen_bono_estado_interno->getPlaceHolder()) ?>" value="<?php echo $ap_estado_interno->porcen_bono_estado_interno->EditValue ?>"<?php echo $ap_estado_interno->porcen_bono_estado_interno->EditAttributes() ?>>
</span>
<?php echo $ap_estado_interno->porcen_bono_estado_interno->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_estado_interno->obs_estado_interno->Visible) { // obs_estado_interno ?>
	<div id="r_obs_estado_interno" class="form-group">
		<label id="elh_ap_estado_interno_obs_estado_interno" for="x_obs_estado_interno" class="col-sm-2 control-label ewLabel"><?php echo $ap_estado_interno->obs_estado_interno->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_estado_interno->obs_estado_interno->CellAttributes() ?>>
<span id="el_ap_estado_interno_obs_estado_interno">
<textarea data-table="ap_estado_interno" data-field="x_obs_estado_interno" name="x_obs_estado_interno" id="x_obs_estado_interno" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ap_estado_interno->obs_estado_interno->getPlaceHolder()) ?>"<?php echo $ap_estado_interno->obs_estado_interno->EditAttributes() ?>><?php echo $ap_estado_interno->obs_estado_interno->EditValue ?></textarea>
</span>
<?php echo $ap_estado_interno->obs_estado_interno->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_estado_interno->envio_boffice_estado_interno->Visible) { // envio_boffice_estado_interno ?>
	<div id="r_envio_boffice_estado_interno" class="form-group">
		<label id="elh_ap_estado_interno_envio_boffice_estado_interno" for="x_envio_boffice_estado_interno" class="col-sm-2 control-label ewLabel"><?php echo $ap_estado_interno->envio_boffice_estado_interno->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_estado_interno->envio_boffice_estado_interno->CellAttributes() ?>>
<span id="el_ap_estado_interno_envio_boffice_estado_interno">
<input type="text" data-table="ap_estado_interno" data-field="x_envio_boffice_estado_interno" name="x_envio_boffice_estado_interno" id="x_envio_boffice_estado_interno" size="30" placeholder="<?php echo ew_HtmlEncode($ap_estado_interno->envio_boffice_estado_interno->getPlaceHolder()) ?>" value="<?php echo $ap_estado_interno->envio_boffice_estado_interno->EditValue ?>"<?php echo $ap_estado_interno->envio_boffice_estado_interno->EditAttributes() ?>>
</span>
<?php echo $ap_estado_interno->envio_boffice_estado_interno->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_estado_interno->empresa_estado_interno->Visible) { // empresa_estado_interno ?>
	<div id="r_empresa_estado_interno" class="form-group">
		<label id="elh_ap_estado_interno_empresa_estado_interno" for="x_empresa_estado_interno" class="col-sm-2 control-label ewLabel"><?php echo $ap_estado_interno->empresa_estado_interno->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_estado_interno->empresa_estado_interno->CellAttributes() ?>>
<span id="el_ap_estado_interno_empresa_estado_interno">
<input type="text" data-table="ap_estado_interno" data-field="x_empresa_estado_interno" name="x_empresa_estado_interno" id="x_empresa_estado_interno" size="30" placeholder="<?php echo ew_HtmlEncode($ap_estado_interno->empresa_estado_interno->getPlaceHolder()) ?>" value="<?php echo $ap_estado_interno->empresa_estado_interno->EditValue ?>"<?php echo $ap_estado_interno->empresa_estado_interno->EditAttributes() ?>>
</span>
<?php echo $ap_estado_interno->empresa_estado_interno->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_estado_interno->id_estado_interno->Visible) { // id_estado_interno ?>
	<div id="r_id_estado_interno" class="form-group">
		<label id="elh_ap_estado_interno_id_estado_interno" class="col-sm-2 control-label ewLabel"><?php echo $ap_estado_interno->id_estado_interno->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_estado_interno->id_estado_interno->CellAttributes() ?>>
<span id="el_ap_estado_interno_id_estado_interno">
<span<?php echo $ap_estado_interno->id_estado_interno->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $ap_estado_interno->id_estado_interno->EditValue ?></p></span>
</span>
<input type="hidden" data-table="ap_estado_interno" data-field="x_id_estado_interno" name="x_id_estado_interno" id="x_id_estado_interno" value="<?php echo ew_HtmlEncode($ap_estado_interno->id_estado_interno->CurrentValue) ?>">
<?php echo $ap_estado_interno->id_estado_interno->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$ap_estado_interno_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $ap_estado_interno_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fap_estado_internoedit.Init();
</script>
<?php
$ap_estado_interno_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ap_estado_interno_edit->Page_Terminate();
?>
