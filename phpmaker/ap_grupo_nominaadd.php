<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "ap_grupo_nominainfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$ap_grupo_nomina_add = NULL; // Initialize page object first

class cap_grupo_nomina_add extends cap_grupo_nomina {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{6A9AC718-A824-45A3-BED3-A95E91E6986D}";

	// Table name
	var $TableName = 'ap_grupo_nomina';

	// Page object name
	var $PageObjName = 'ap_grupo_nomina_add';

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

		// Table object (ap_grupo_nomina)
		if (!isset($GLOBALS["ap_grupo_nomina"]) || get_class($GLOBALS["ap_grupo_nomina"]) == "cap_grupo_nomina") {
			$GLOBALS["ap_grupo_nomina"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ap_grupo_nomina"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ap_grupo_nomina', TRUE);

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
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("ap_grupo_nominalist.php"));
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
		$this->id_grupo_nomina->SetVisibility();
		$this->nombre_grupo_nomina->SetVisibility();
		$this->activo_grupo_nomina->SetVisibility();
		$this->empresa_grupo_nomina->SetVisibility();

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
		global $EW_EXPORT, $ap_grupo_nomina;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($ap_grupo_nomina);
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
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

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

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["id_grupo_nomina"] != "") {
				$this->id_grupo_nomina->setQueryStringValue($_GET["id_grupo_nomina"]);
				$this->setKey("id_grupo_nomina", $this->id_grupo_nomina->CurrentValue); // Set up key
			} else {
				$this->setKey("id_grupo_nomina", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else {
			if ($this->CurrentAction == "I") // Load default values for blank record
				$this->LoadDefaultValues();
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("ap_grupo_nominalist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "ap_grupo_nominalist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "ap_grupo_nominaview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->id_grupo_nomina->CurrentValue = NULL;
		$this->id_grupo_nomina->OldValue = $this->id_grupo_nomina->CurrentValue;
		$this->nombre_grupo_nomina->CurrentValue = NULL;
		$this->nombre_grupo_nomina->OldValue = $this->nombre_grupo_nomina->CurrentValue;
		$this->activo_grupo_nomina->CurrentValue = 0;
		$this->empresa_grupo_nomina->CurrentValue = NULL;
		$this->empresa_grupo_nomina->OldValue = $this->empresa_grupo_nomina->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->id_grupo_nomina->FldIsDetailKey) {
			$this->id_grupo_nomina->setFormValue($objForm->GetValue("x_id_grupo_nomina"));
		}
		if (!$this->nombre_grupo_nomina->FldIsDetailKey) {
			$this->nombre_grupo_nomina->setFormValue($objForm->GetValue("x_nombre_grupo_nomina"));
		}
		if (!$this->activo_grupo_nomina->FldIsDetailKey) {
			$this->activo_grupo_nomina->setFormValue($objForm->GetValue("x_activo_grupo_nomina"));
		}
		if (!$this->empresa_grupo_nomina->FldIsDetailKey) {
			$this->empresa_grupo_nomina->setFormValue($objForm->GetValue("x_empresa_grupo_nomina"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->id_grupo_nomina->CurrentValue = $this->id_grupo_nomina->FormValue;
		$this->nombre_grupo_nomina->CurrentValue = $this->nombre_grupo_nomina->FormValue;
		$this->activo_grupo_nomina->CurrentValue = $this->activo_grupo_nomina->FormValue;
		$this->empresa_grupo_nomina->CurrentValue = $this->empresa_grupo_nomina->FormValue;
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
		$this->id_grupo_nomina->setDbValue($rs->fields('id_grupo_nomina'));
		$this->nombre_grupo_nomina->setDbValue($rs->fields('nombre_grupo_nomina'));
		$this->activo_grupo_nomina->setDbValue($rs->fields('activo_grupo_nomina'));
		$this->empresa_grupo_nomina->setDbValue($rs->fields('empresa_grupo_nomina'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id_grupo_nomina->DbValue = $row['id_grupo_nomina'];
		$this->nombre_grupo_nomina->DbValue = $row['nombre_grupo_nomina'];
		$this->activo_grupo_nomina->DbValue = $row['activo_grupo_nomina'];
		$this->empresa_grupo_nomina->DbValue = $row['empresa_grupo_nomina'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id_grupo_nomina")) <> "")
			$this->id_grupo_nomina->CurrentValue = $this->getKey("id_grupo_nomina"); // id_grupo_nomina
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id_grupo_nomina
		// nombre_grupo_nomina
		// activo_grupo_nomina
		// empresa_grupo_nomina

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id_grupo_nomina
		$this->id_grupo_nomina->ViewValue = $this->id_grupo_nomina->CurrentValue;
		$this->id_grupo_nomina->ViewCustomAttributes = "";

		// nombre_grupo_nomina
		$this->nombre_grupo_nomina->ViewValue = $this->nombre_grupo_nomina->CurrentValue;
		$this->nombre_grupo_nomina->ViewCustomAttributes = "";

		// activo_grupo_nomina
		$this->activo_grupo_nomina->ViewValue = $this->activo_grupo_nomina->CurrentValue;
		$this->activo_grupo_nomina->ViewCustomAttributes = "";

		// empresa_grupo_nomina
		$this->empresa_grupo_nomina->ViewValue = $this->empresa_grupo_nomina->CurrentValue;
		$this->empresa_grupo_nomina->ViewCustomAttributes = "";

			// id_grupo_nomina
			$this->id_grupo_nomina->LinkCustomAttributes = "";
			$this->id_grupo_nomina->HrefValue = "";
			$this->id_grupo_nomina->TooltipValue = "";

			// nombre_grupo_nomina
			$this->nombre_grupo_nomina->LinkCustomAttributes = "";
			$this->nombre_grupo_nomina->HrefValue = "";
			$this->nombre_grupo_nomina->TooltipValue = "";

			// activo_grupo_nomina
			$this->activo_grupo_nomina->LinkCustomAttributes = "";
			$this->activo_grupo_nomina->HrefValue = "";
			$this->activo_grupo_nomina->TooltipValue = "";

			// empresa_grupo_nomina
			$this->empresa_grupo_nomina->LinkCustomAttributes = "";
			$this->empresa_grupo_nomina->HrefValue = "";
			$this->empresa_grupo_nomina->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// id_grupo_nomina
			$this->id_grupo_nomina->EditAttrs["class"] = "form-control";
			$this->id_grupo_nomina->EditCustomAttributes = "";
			$this->id_grupo_nomina->EditValue = ew_HtmlEncode($this->id_grupo_nomina->CurrentValue);
			$this->id_grupo_nomina->PlaceHolder = ew_RemoveHtml($this->id_grupo_nomina->FldCaption());

			// nombre_grupo_nomina
			$this->nombre_grupo_nomina->EditAttrs["class"] = "form-control";
			$this->nombre_grupo_nomina->EditCustomAttributes = "";
			$this->nombre_grupo_nomina->EditValue = ew_HtmlEncode($this->nombre_grupo_nomina->CurrentValue);
			$this->nombre_grupo_nomina->PlaceHolder = ew_RemoveHtml($this->nombre_grupo_nomina->FldCaption());

			// activo_grupo_nomina
			$this->activo_grupo_nomina->EditAttrs["class"] = "form-control";
			$this->activo_grupo_nomina->EditCustomAttributes = "";
			$this->activo_grupo_nomina->EditValue = ew_HtmlEncode($this->activo_grupo_nomina->CurrentValue);
			$this->activo_grupo_nomina->PlaceHolder = ew_RemoveHtml($this->activo_grupo_nomina->FldCaption());

			// empresa_grupo_nomina
			$this->empresa_grupo_nomina->EditAttrs["class"] = "form-control";
			$this->empresa_grupo_nomina->EditCustomAttributes = "";
			$this->empresa_grupo_nomina->EditValue = ew_HtmlEncode($this->empresa_grupo_nomina->CurrentValue);
			$this->empresa_grupo_nomina->PlaceHolder = ew_RemoveHtml($this->empresa_grupo_nomina->FldCaption());

			// Add refer script
			// id_grupo_nomina

			$this->id_grupo_nomina->LinkCustomAttributes = "";
			$this->id_grupo_nomina->HrefValue = "";

			// nombre_grupo_nomina
			$this->nombre_grupo_nomina->LinkCustomAttributes = "";
			$this->nombre_grupo_nomina->HrefValue = "";

			// activo_grupo_nomina
			$this->activo_grupo_nomina->LinkCustomAttributes = "";
			$this->activo_grupo_nomina->HrefValue = "";

			// empresa_grupo_nomina
			$this->empresa_grupo_nomina->LinkCustomAttributes = "";
			$this->empresa_grupo_nomina->HrefValue = "";
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
		if (!$this->id_grupo_nomina->FldIsDetailKey && !is_null($this->id_grupo_nomina->FormValue) && $this->id_grupo_nomina->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->id_grupo_nomina->FldCaption(), $this->id_grupo_nomina->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->id_grupo_nomina->FormValue)) {
			ew_AddMessage($gsFormError, $this->id_grupo_nomina->FldErrMsg());
		}
		if (!ew_CheckInteger($this->activo_grupo_nomina->FormValue)) {
			ew_AddMessage($gsFormError, $this->activo_grupo_nomina->FldErrMsg());
		}
		if (!ew_CheckInteger($this->empresa_grupo_nomina->FormValue)) {
			ew_AddMessage($gsFormError, $this->empresa_grupo_nomina->FldErrMsg());
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// id_grupo_nomina
		$this->id_grupo_nomina->SetDbValueDef($rsnew, $this->id_grupo_nomina->CurrentValue, 0, FALSE);

		// nombre_grupo_nomina
		$this->nombre_grupo_nomina->SetDbValueDef($rsnew, $this->nombre_grupo_nomina->CurrentValue, NULL, FALSE);

		// activo_grupo_nomina
		$this->activo_grupo_nomina->SetDbValueDef($rsnew, $this->activo_grupo_nomina->CurrentValue, NULL, strval($this->activo_grupo_nomina->CurrentValue) == "");

		// empresa_grupo_nomina
		$this->empresa_grupo_nomina->SetDbValueDef($rsnew, $this->empresa_grupo_nomina->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['id_grupo_nomina']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}

		// Check for duplicate key
		if ($bInsertRow && $this->ValidateKey) {
			$sFilter = $this->KeyFilter();
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sKeyErrMsg = str_replace("%f", $sFilter, $Language->Phrase("DupKey"));
				$this->setFailureMessage($sKeyErrMsg);
				$rsChk->Close();
				$bInsertRow = FALSE;
			}
		}
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("ap_grupo_nominalist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
if (!isset($ap_grupo_nomina_add)) $ap_grupo_nomina_add = new cap_grupo_nomina_add();

// Page init
$ap_grupo_nomina_add->Page_Init();

// Page main
$ap_grupo_nomina_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ap_grupo_nomina_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fap_grupo_nominaadd = new ew_Form("fap_grupo_nominaadd", "add");

// Validate form
fap_grupo_nominaadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_id_grupo_nomina");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ap_grupo_nomina->id_grupo_nomina->FldCaption(), $ap_grupo_nomina->id_grupo_nomina->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_id_grupo_nomina");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_grupo_nomina->id_grupo_nomina->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_activo_grupo_nomina");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_grupo_nomina->activo_grupo_nomina->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_empresa_grupo_nomina");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_grupo_nomina->empresa_grupo_nomina->FldErrMsg()) ?>");

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
fap_grupo_nominaadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fap_grupo_nominaadd.ValidateRequired = true;
<?php } else { ?>
fap_grupo_nominaadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$ap_grupo_nomina_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $ap_grupo_nomina_add->ShowPageHeader(); ?>
<?php
$ap_grupo_nomina_add->ShowMessage();
?>
<form name="fap_grupo_nominaadd" id="fap_grupo_nominaadd" class="<?php echo $ap_grupo_nomina_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($ap_grupo_nomina_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $ap_grupo_nomina_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ap_grupo_nomina">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($ap_grupo_nomina_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($ap_grupo_nomina->id_grupo_nomina->Visible) { // id_grupo_nomina ?>
	<div id="r_id_grupo_nomina" class="form-group">
		<label id="elh_ap_grupo_nomina_id_grupo_nomina" for="x_id_grupo_nomina" class="col-sm-2 control-label ewLabel"><?php echo $ap_grupo_nomina->id_grupo_nomina->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $ap_grupo_nomina->id_grupo_nomina->CellAttributes() ?>>
<span id="el_ap_grupo_nomina_id_grupo_nomina">
<input type="text" data-table="ap_grupo_nomina" data-field="x_id_grupo_nomina" name="x_id_grupo_nomina" id="x_id_grupo_nomina" size="30" placeholder="<?php echo ew_HtmlEncode($ap_grupo_nomina->id_grupo_nomina->getPlaceHolder()) ?>" value="<?php echo $ap_grupo_nomina->id_grupo_nomina->EditValue ?>"<?php echo $ap_grupo_nomina->id_grupo_nomina->EditAttributes() ?>>
</span>
<?php echo $ap_grupo_nomina->id_grupo_nomina->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_grupo_nomina->nombre_grupo_nomina->Visible) { // nombre_grupo_nomina ?>
	<div id="r_nombre_grupo_nomina" class="form-group">
		<label id="elh_ap_grupo_nomina_nombre_grupo_nomina" for="x_nombre_grupo_nomina" class="col-sm-2 control-label ewLabel"><?php echo $ap_grupo_nomina->nombre_grupo_nomina->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_grupo_nomina->nombre_grupo_nomina->CellAttributes() ?>>
<span id="el_ap_grupo_nomina_nombre_grupo_nomina">
<input type="text" data-table="ap_grupo_nomina" data-field="x_nombre_grupo_nomina" name="x_nombre_grupo_nomina" id="x_nombre_grupo_nomina" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($ap_grupo_nomina->nombre_grupo_nomina->getPlaceHolder()) ?>" value="<?php echo $ap_grupo_nomina->nombre_grupo_nomina->EditValue ?>"<?php echo $ap_grupo_nomina->nombre_grupo_nomina->EditAttributes() ?>>
</span>
<?php echo $ap_grupo_nomina->nombre_grupo_nomina->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_grupo_nomina->activo_grupo_nomina->Visible) { // activo_grupo_nomina ?>
	<div id="r_activo_grupo_nomina" class="form-group">
		<label id="elh_ap_grupo_nomina_activo_grupo_nomina" for="x_activo_grupo_nomina" class="col-sm-2 control-label ewLabel"><?php echo $ap_grupo_nomina->activo_grupo_nomina->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_grupo_nomina->activo_grupo_nomina->CellAttributes() ?>>
<span id="el_ap_grupo_nomina_activo_grupo_nomina">
<input type="text" data-table="ap_grupo_nomina" data-field="x_activo_grupo_nomina" name="x_activo_grupo_nomina" id="x_activo_grupo_nomina" size="30" placeholder="<?php echo ew_HtmlEncode($ap_grupo_nomina->activo_grupo_nomina->getPlaceHolder()) ?>" value="<?php echo $ap_grupo_nomina->activo_grupo_nomina->EditValue ?>"<?php echo $ap_grupo_nomina->activo_grupo_nomina->EditAttributes() ?>>
</span>
<?php echo $ap_grupo_nomina->activo_grupo_nomina->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_grupo_nomina->empresa_grupo_nomina->Visible) { // empresa_grupo_nomina ?>
	<div id="r_empresa_grupo_nomina" class="form-group">
		<label id="elh_ap_grupo_nomina_empresa_grupo_nomina" for="x_empresa_grupo_nomina" class="col-sm-2 control-label ewLabel"><?php echo $ap_grupo_nomina->empresa_grupo_nomina->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_grupo_nomina->empresa_grupo_nomina->CellAttributes() ?>>
<span id="el_ap_grupo_nomina_empresa_grupo_nomina">
<input type="text" data-table="ap_grupo_nomina" data-field="x_empresa_grupo_nomina" name="x_empresa_grupo_nomina" id="x_empresa_grupo_nomina" size="30" placeholder="<?php echo ew_HtmlEncode($ap_grupo_nomina->empresa_grupo_nomina->getPlaceHolder()) ?>" value="<?php echo $ap_grupo_nomina->empresa_grupo_nomina->EditValue ?>"<?php echo $ap_grupo_nomina->empresa_grupo_nomina->EditAttributes() ?>>
</span>
<?php echo $ap_grupo_nomina->empresa_grupo_nomina->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$ap_grupo_nomina_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $ap_grupo_nomina_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fap_grupo_nominaadd.Init();
</script>
<?php
$ap_grupo_nomina_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ap_grupo_nomina_add->Page_Terminate();
?>
