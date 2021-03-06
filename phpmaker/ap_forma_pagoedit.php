<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "ap_forma_pagoinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$ap_forma_pago_edit = NULL; // Initialize page object first

class cap_forma_pago_edit extends cap_forma_pago {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{6A9AC718-A824-45A3-BED3-A95E91E6986D}";

	// Table name
	var $TableName = 'ap_forma_pago';

	// Page object name
	var $PageObjName = 'ap_forma_pago_edit';

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

		// Table object (ap_forma_pago)
		if (!isset($GLOBALS["ap_forma_pago"]) || get_class($GLOBALS["ap_forma_pago"]) == "cap_forma_pago") {
			$GLOBALS["ap_forma_pago"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ap_forma_pago"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ap_forma_pago', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("ap_forma_pagolist.php"));
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
		$this->Id_forma_ap->SetVisibility();
		$this->nombre_forma_ap->SetVisibility();
		$this->desc_cal_forma_ap->SetVisibility();
		$this->desc_est_forma_ap->SetVisibility();
		$this->desc_obra_forma_ap->SetVisibility();
		$this->tipo_forma_ap->SetVisibility();
		$this->empresa_forma_ap->SetVisibility();

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
		global $EW_EXPORT, $ap_forma_pago;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($ap_forma_pago);
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
		if (@$_GET["Id_forma_ap"] <> "") {
			$this->Id_forma_ap->setQueryStringValue($_GET["Id_forma_ap"]);
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
		if ($this->Id_forma_ap->CurrentValue == "") {
			$this->Page_Terminate("ap_forma_pagolist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("ap_forma_pagolist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "ap_forma_pagolist.php")
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
		if (!$this->Id_forma_ap->FldIsDetailKey) {
			$this->Id_forma_ap->setFormValue($objForm->GetValue("x_Id_forma_ap"));
		}
		if (!$this->nombre_forma_ap->FldIsDetailKey) {
			$this->nombre_forma_ap->setFormValue($objForm->GetValue("x_nombre_forma_ap"));
		}
		if (!$this->desc_cal_forma_ap->FldIsDetailKey) {
			$this->desc_cal_forma_ap->setFormValue($objForm->GetValue("x_desc_cal_forma_ap"));
		}
		if (!$this->desc_est_forma_ap->FldIsDetailKey) {
			$this->desc_est_forma_ap->setFormValue($objForm->GetValue("x_desc_est_forma_ap"));
		}
		if (!$this->desc_obra_forma_ap->FldIsDetailKey) {
			$this->desc_obra_forma_ap->setFormValue($objForm->GetValue("x_desc_obra_forma_ap"));
		}
		if (!$this->tipo_forma_ap->FldIsDetailKey) {
			$this->tipo_forma_ap->setFormValue($objForm->GetValue("x_tipo_forma_ap"));
		}
		if (!$this->empresa_forma_ap->FldIsDetailKey) {
			$this->empresa_forma_ap->setFormValue($objForm->GetValue("x_empresa_forma_ap"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->Id_forma_ap->CurrentValue = $this->Id_forma_ap->FormValue;
		$this->nombre_forma_ap->CurrentValue = $this->nombre_forma_ap->FormValue;
		$this->desc_cal_forma_ap->CurrentValue = $this->desc_cal_forma_ap->FormValue;
		$this->desc_est_forma_ap->CurrentValue = $this->desc_est_forma_ap->FormValue;
		$this->desc_obra_forma_ap->CurrentValue = $this->desc_obra_forma_ap->FormValue;
		$this->tipo_forma_ap->CurrentValue = $this->tipo_forma_ap->FormValue;
		$this->empresa_forma_ap->CurrentValue = $this->empresa_forma_ap->FormValue;
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
		$this->Id_forma_ap->setDbValue($rs->fields('Id_forma_ap'));
		$this->nombre_forma_ap->setDbValue($rs->fields('nombre_forma_ap'));
		$this->desc_cal_forma_ap->setDbValue($rs->fields('desc_cal_forma_ap'));
		$this->desc_est_forma_ap->setDbValue($rs->fields('desc_est_forma_ap'));
		$this->desc_obra_forma_ap->setDbValue($rs->fields('desc_obra_forma_ap'));
		$this->tipo_forma_ap->setDbValue($rs->fields('tipo_forma_ap'));
		$this->empresa_forma_ap->setDbValue($rs->fields('empresa_forma_ap'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Id_forma_ap->DbValue = $row['Id_forma_ap'];
		$this->nombre_forma_ap->DbValue = $row['nombre_forma_ap'];
		$this->desc_cal_forma_ap->DbValue = $row['desc_cal_forma_ap'];
		$this->desc_est_forma_ap->DbValue = $row['desc_est_forma_ap'];
		$this->desc_obra_forma_ap->DbValue = $row['desc_obra_forma_ap'];
		$this->tipo_forma_ap->DbValue = $row['tipo_forma_ap'];
		$this->empresa_forma_ap->DbValue = $row['empresa_forma_ap'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->desc_cal_forma_ap->FormValue == $this->desc_cal_forma_ap->CurrentValue && is_numeric(ew_StrToFloat($this->desc_cal_forma_ap->CurrentValue)))
			$this->desc_cal_forma_ap->CurrentValue = ew_StrToFloat($this->desc_cal_forma_ap->CurrentValue);

		// Convert decimal values if posted back
		if ($this->desc_est_forma_ap->FormValue == $this->desc_est_forma_ap->CurrentValue && is_numeric(ew_StrToFloat($this->desc_est_forma_ap->CurrentValue)))
			$this->desc_est_forma_ap->CurrentValue = ew_StrToFloat($this->desc_est_forma_ap->CurrentValue);

		// Convert decimal values if posted back
		if ($this->desc_obra_forma_ap->FormValue == $this->desc_obra_forma_ap->CurrentValue && is_numeric(ew_StrToFloat($this->desc_obra_forma_ap->CurrentValue)))
			$this->desc_obra_forma_ap->CurrentValue = ew_StrToFloat($this->desc_obra_forma_ap->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_forma_ap
		// nombre_forma_ap
		// desc_cal_forma_ap
		// desc_est_forma_ap
		// desc_obra_forma_ap
		// tipo_forma_ap
		// empresa_forma_ap

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Id_forma_ap
		$this->Id_forma_ap->ViewValue = $this->Id_forma_ap->CurrentValue;
		$this->Id_forma_ap->ViewCustomAttributes = "";

		// nombre_forma_ap
		$this->nombre_forma_ap->ViewValue = $this->nombre_forma_ap->CurrentValue;
		$this->nombre_forma_ap->ViewCustomAttributes = "";

		// desc_cal_forma_ap
		$this->desc_cal_forma_ap->ViewValue = $this->desc_cal_forma_ap->CurrentValue;
		$this->desc_cal_forma_ap->ViewCustomAttributes = "";

		// desc_est_forma_ap
		$this->desc_est_forma_ap->ViewValue = $this->desc_est_forma_ap->CurrentValue;
		$this->desc_est_forma_ap->ViewCustomAttributes = "";

		// desc_obra_forma_ap
		$this->desc_obra_forma_ap->ViewValue = $this->desc_obra_forma_ap->CurrentValue;
		$this->desc_obra_forma_ap->ViewCustomAttributes = "";

		// tipo_forma_ap
		$this->tipo_forma_ap->ViewValue = $this->tipo_forma_ap->CurrentValue;
		$this->tipo_forma_ap->ViewCustomAttributes = "";

		// empresa_forma_ap
		$this->empresa_forma_ap->ViewValue = $this->empresa_forma_ap->CurrentValue;
		$this->empresa_forma_ap->ViewCustomAttributes = "";

			// Id_forma_ap
			$this->Id_forma_ap->LinkCustomAttributes = "";
			$this->Id_forma_ap->HrefValue = "";
			$this->Id_forma_ap->TooltipValue = "";

			// nombre_forma_ap
			$this->nombre_forma_ap->LinkCustomAttributes = "";
			$this->nombre_forma_ap->HrefValue = "";
			$this->nombre_forma_ap->TooltipValue = "";

			// desc_cal_forma_ap
			$this->desc_cal_forma_ap->LinkCustomAttributes = "";
			$this->desc_cal_forma_ap->HrefValue = "";
			$this->desc_cal_forma_ap->TooltipValue = "";

			// desc_est_forma_ap
			$this->desc_est_forma_ap->LinkCustomAttributes = "";
			$this->desc_est_forma_ap->HrefValue = "";
			$this->desc_est_forma_ap->TooltipValue = "";

			// desc_obra_forma_ap
			$this->desc_obra_forma_ap->LinkCustomAttributes = "";
			$this->desc_obra_forma_ap->HrefValue = "";
			$this->desc_obra_forma_ap->TooltipValue = "";

			// tipo_forma_ap
			$this->tipo_forma_ap->LinkCustomAttributes = "";
			$this->tipo_forma_ap->HrefValue = "";
			$this->tipo_forma_ap->TooltipValue = "";

			// empresa_forma_ap
			$this->empresa_forma_ap->LinkCustomAttributes = "";
			$this->empresa_forma_ap->HrefValue = "";
			$this->empresa_forma_ap->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Id_forma_ap
			$this->Id_forma_ap->EditAttrs["class"] = "form-control";
			$this->Id_forma_ap->EditCustomAttributes = "";
			$this->Id_forma_ap->EditValue = $this->Id_forma_ap->CurrentValue;
			$this->Id_forma_ap->ViewCustomAttributes = "";

			// nombre_forma_ap
			$this->nombre_forma_ap->EditAttrs["class"] = "form-control";
			$this->nombre_forma_ap->EditCustomAttributes = "";
			$this->nombre_forma_ap->EditValue = ew_HtmlEncode($this->nombre_forma_ap->CurrentValue);
			$this->nombre_forma_ap->PlaceHolder = ew_RemoveHtml($this->nombre_forma_ap->FldCaption());

			// desc_cal_forma_ap
			$this->desc_cal_forma_ap->EditAttrs["class"] = "form-control";
			$this->desc_cal_forma_ap->EditCustomAttributes = "";
			$this->desc_cal_forma_ap->EditValue = ew_HtmlEncode($this->desc_cal_forma_ap->CurrentValue);
			$this->desc_cal_forma_ap->PlaceHolder = ew_RemoveHtml($this->desc_cal_forma_ap->FldCaption());
			if (strval($this->desc_cal_forma_ap->EditValue) <> "" && is_numeric($this->desc_cal_forma_ap->EditValue)) $this->desc_cal_forma_ap->EditValue = ew_FormatNumber($this->desc_cal_forma_ap->EditValue, -2, -1, -2, 0);

			// desc_est_forma_ap
			$this->desc_est_forma_ap->EditAttrs["class"] = "form-control";
			$this->desc_est_forma_ap->EditCustomAttributes = "";
			$this->desc_est_forma_ap->EditValue = ew_HtmlEncode($this->desc_est_forma_ap->CurrentValue);
			$this->desc_est_forma_ap->PlaceHolder = ew_RemoveHtml($this->desc_est_forma_ap->FldCaption());
			if (strval($this->desc_est_forma_ap->EditValue) <> "" && is_numeric($this->desc_est_forma_ap->EditValue)) $this->desc_est_forma_ap->EditValue = ew_FormatNumber($this->desc_est_forma_ap->EditValue, -2, -1, -2, 0);

			// desc_obra_forma_ap
			$this->desc_obra_forma_ap->EditAttrs["class"] = "form-control";
			$this->desc_obra_forma_ap->EditCustomAttributes = "";
			$this->desc_obra_forma_ap->EditValue = ew_HtmlEncode($this->desc_obra_forma_ap->CurrentValue);
			$this->desc_obra_forma_ap->PlaceHolder = ew_RemoveHtml($this->desc_obra_forma_ap->FldCaption());
			if (strval($this->desc_obra_forma_ap->EditValue) <> "" && is_numeric($this->desc_obra_forma_ap->EditValue)) $this->desc_obra_forma_ap->EditValue = ew_FormatNumber($this->desc_obra_forma_ap->EditValue, -2, -1, -2, 0);

			// tipo_forma_ap
			$this->tipo_forma_ap->EditAttrs["class"] = "form-control";
			$this->tipo_forma_ap->EditCustomAttributes = "";
			$this->tipo_forma_ap->EditValue = ew_HtmlEncode($this->tipo_forma_ap->CurrentValue);
			$this->tipo_forma_ap->PlaceHolder = ew_RemoveHtml($this->tipo_forma_ap->FldCaption());

			// empresa_forma_ap
			$this->empresa_forma_ap->EditAttrs["class"] = "form-control";
			$this->empresa_forma_ap->EditCustomAttributes = "";
			$this->empresa_forma_ap->EditValue = ew_HtmlEncode($this->empresa_forma_ap->CurrentValue);
			$this->empresa_forma_ap->PlaceHolder = ew_RemoveHtml($this->empresa_forma_ap->FldCaption());

			// Edit refer script
			// Id_forma_ap

			$this->Id_forma_ap->LinkCustomAttributes = "";
			$this->Id_forma_ap->HrefValue = "";

			// nombre_forma_ap
			$this->nombre_forma_ap->LinkCustomAttributes = "";
			$this->nombre_forma_ap->HrefValue = "";

			// desc_cal_forma_ap
			$this->desc_cal_forma_ap->LinkCustomAttributes = "";
			$this->desc_cal_forma_ap->HrefValue = "";

			// desc_est_forma_ap
			$this->desc_est_forma_ap->LinkCustomAttributes = "";
			$this->desc_est_forma_ap->HrefValue = "";

			// desc_obra_forma_ap
			$this->desc_obra_forma_ap->LinkCustomAttributes = "";
			$this->desc_obra_forma_ap->HrefValue = "";

			// tipo_forma_ap
			$this->tipo_forma_ap->LinkCustomAttributes = "";
			$this->tipo_forma_ap->HrefValue = "";

			// empresa_forma_ap
			$this->empresa_forma_ap->LinkCustomAttributes = "";
			$this->empresa_forma_ap->HrefValue = "";
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
		if (!$this->Id_forma_ap->FldIsDetailKey && !is_null($this->Id_forma_ap->FormValue) && $this->Id_forma_ap->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_forma_ap->FldCaption(), $this->Id_forma_ap->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Id_forma_ap->FormValue)) {
			ew_AddMessage($gsFormError, $this->Id_forma_ap->FldErrMsg());
		}
		if (!ew_CheckNumber($this->desc_cal_forma_ap->FormValue)) {
			ew_AddMessage($gsFormError, $this->desc_cal_forma_ap->FldErrMsg());
		}
		if (!ew_CheckNumber($this->desc_est_forma_ap->FormValue)) {
			ew_AddMessage($gsFormError, $this->desc_est_forma_ap->FldErrMsg());
		}
		if (!ew_CheckNumber($this->desc_obra_forma_ap->FormValue)) {
			ew_AddMessage($gsFormError, $this->desc_obra_forma_ap->FldErrMsg());
		}
		if (!ew_CheckInteger($this->empresa_forma_ap->FormValue)) {
			ew_AddMessage($gsFormError, $this->empresa_forma_ap->FldErrMsg());
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

			// Id_forma_ap
			// nombre_forma_ap

			$this->nombre_forma_ap->SetDbValueDef($rsnew, $this->nombre_forma_ap->CurrentValue, NULL, $this->nombre_forma_ap->ReadOnly);

			// desc_cal_forma_ap
			$this->desc_cal_forma_ap->SetDbValueDef($rsnew, $this->desc_cal_forma_ap->CurrentValue, NULL, $this->desc_cal_forma_ap->ReadOnly);

			// desc_est_forma_ap
			$this->desc_est_forma_ap->SetDbValueDef($rsnew, $this->desc_est_forma_ap->CurrentValue, NULL, $this->desc_est_forma_ap->ReadOnly);

			// desc_obra_forma_ap
			$this->desc_obra_forma_ap->SetDbValueDef($rsnew, $this->desc_obra_forma_ap->CurrentValue, NULL, $this->desc_obra_forma_ap->ReadOnly);

			// tipo_forma_ap
			$this->tipo_forma_ap->SetDbValueDef($rsnew, $this->tipo_forma_ap->CurrentValue, NULL, $this->tipo_forma_ap->ReadOnly);

			// empresa_forma_ap
			$this->empresa_forma_ap->SetDbValueDef($rsnew, $this->empresa_forma_ap->CurrentValue, NULL, $this->empresa_forma_ap->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("ap_forma_pagolist.php"), "", $this->TableVar, TRUE);
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
if (!isset($ap_forma_pago_edit)) $ap_forma_pago_edit = new cap_forma_pago_edit();

// Page init
$ap_forma_pago_edit->Page_Init();

// Page main
$ap_forma_pago_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ap_forma_pago_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fap_forma_pagoedit = new ew_Form("fap_forma_pagoedit", "edit");

// Validate form
fap_forma_pagoedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Id_forma_ap");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ap_forma_pago->Id_forma_ap->FldCaption(), $ap_forma_pago->Id_forma_ap->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_forma_ap");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_forma_pago->Id_forma_ap->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_desc_cal_forma_ap");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_forma_pago->desc_cal_forma_ap->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_desc_est_forma_ap");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_forma_pago->desc_est_forma_ap->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_desc_obra_forma_ap");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_forma_pago->desc_obra_forma_ap->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_empresa_forma_ap");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ap_forma_pago->empresa_forma_ap->FldErrMsg()) ?>");

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
fap_forma_pagoedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fap_forma_pagoedit.ValidateRequired = true;
<?php } else { ?>
fap_forma_pagoedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$ap_forma_pago_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $ap_forma_pago_edit->ShowPageHeader(); ?>
<?php
$ap_forma_pago_edit->ShowMessage();
?>
<form name="fap_forma_pagoedit" id="fap_forma_pagoedit" class="<?php echo $ap_forma_pago_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($ap_forma_pago_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $ap_forma_pago_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ap_forma_pago">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($ap_forma_pago_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($ap_forma_pago->Id_forma_ap->Visible) { // Id_forma_ap ?>
	<div id="r_Id_forma_ap" class="form-group">
		<label id="elh_ap_forma_pago_Id_forma_ap" for="x_Id_forma_ap" class="col-sm-2 control-label ewLabel"><?php echo $ap_forma_pago->Id_forma_ap->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $ap_forma_pago->Id_forma_ap->CellAttributes() ?>>
<span id="el_ap_forma_pago_Id_forma_ap">
<span<?php echo $ap_forma_pago->Id_forma_ap->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $ap_forma_pago->Id_forma_ap->EditValue ?></p></span>
</span>
<input type="hidden" data-table="ap_forma_pago" data-field="x_Id_forma_ap" name="x_Id_forma_ap" id="x_Id_forma_ap" value="<?php echo ew_HtmlEncode($ap_forma_pago->Id_forma_ap->CurrentValue) ?>">
<?php echo $ap_forma_pago->Id_forma_ap->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_forma_pago->nombre_forma_ap->Visible) { // nombre_forma_ap ?>
	<div id="r_nombre_forma_ap" class="form-group">
		<label id="elh_ap_forma_pago_nombre_forma_ap" for="x_nombre_forma_ap" class="col-sm-2 control-label ewLabel"><?php echo $ap_forma_pago->nombre_forma_ap->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_forma_pago->nombre_forma_ap->CellAttributes() ?>>
<span id="el_ap_forma_pago_nombre_forma_ap">
<input type="text" data-table="ap_forma_pago" data-field="x_nombre_forma_ap" name="x_nombre_forma_ap" id="x_nombre_forma_ap" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($ap_forma_pago->nombre_forma_ap->getPlaceHolder()) ?>" value="<?php echo $ap_forma_pago->nombre_forma_ap->EditValue ?>"<?php echo $ap_forma_pago->nombre_forma_ap->EditAttributes() ?>>
</span>
<?php echo $ap_forma_pago->nombre_forma_ap->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_forma_pago->desc_cal_forma_ap->Visible) { // desc_cal_forma_ap ?>
	<div id="r_desc_cal_forma_ap" class="form-group">
		<label id="elh_ap_forma_pago_desc_cal_forma_ap" for="x_desc_cal_forma_ap" class="col-sm-2 control-label ewLabel"><?php echo $ap_forma_pago->desc_cal_forma_ap->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_forma_pago->desc_cal_forma_ap->CellAttributes() ?>>
<span id="el_ap_forma_pago_desc_cal_forma_ap">
<input type="text" data-table="ap_forma_pago" data-field="x_desc_cal_forma_ap" name="x_desc_cal_forma_ap" id="x_desc_cal_forma_ap" size="30" placeholder="<?php echo ew_HtmlEncode($ap_forma_pago->desc_cal_forma_ap->getPlaceHolder()) ?>" value="<?php echo $ap_forma_pago->desc_cal_forma_ap->EditValue ?>"<?php echo $ap_forma_pago->desc_cal_forma_ap->EditAttributes() ?>>
</span>
<?php echo $ap_forma_pago->desc_cal_forma_ap->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_forma_pago->desc_est_forma_ap->Visible) { // desc_est_forma_ap ?>
	<div id="r_desc_est_forma_ap" class="form-group">
		<label id="elh_ap_forma_pago_desc_est_forma_ap" for="x_desc_est_forma_ap" class="col-sm-2 control-label ewLabel"><?php echo $ap_forma_pago->desc_est_forma_ap->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_forma_pago->desc_est_forma_ap->CellAttributes() ?>>
<span id="el_ap_forma_pago_desc_est_forma_ap">
<input type="text" data-table="ap_forma_pago" data-field="x_desc_est_forma_ap" name="x_desc_est_forma_ap" id="x_desc_est_forma_ap" size="30" placeholder="<?php echo ew_HtmlEncode($ap_forma_pago->desc_est_forma_ap->getPlaceHolder()) ?>" value="<?php echo $ap_forma_pago->desc_est_forma_ap->EditValue ?>"<?php echo $ap_forma_pago->desc_est_forma_ap->EditAttributes() ?>>
</span>
<?php echo $ap_forma_pago->desc_est_forma_ap->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_forma_pago->desc_obra_forma_ap->Visible) { // desc_obra_forma_ap ?>
	<div id="r_desc_obra_forma_ap" class="form-group">
		<label id="elh_ap_forma_pago_desc_obra_forma_ap" for="x_desc_obra_forma_ap" class="col-sm-2 control-label ewLabel"><?php echo $ap_forma_pago->desc_obra_forma_ap->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_forma_pago->desc_obra_forma_ap->CellAttributes() ?>>
<span id="el_ap_forma_pago_desc_obra_forma_ap">
<input type="text" data-table="ap_forma_pago" data-field="x_desc_obra_forma_ap" name="x_desc_obra_forma_ap" id="x_desc_obra_forma_ap" size="30" placeholder="<?php echo ew_HtmlEncode($ap_forma_pago->desc_obra_forma_ap->getPlaceHolder()) ?>" value="<?php echo $ap_forma_pago->desc_obra_forma_ap->EditValue ?>"<?php echo $ap_forma_pago->desc_obra_forma_ap->EditAttributes() ?>>
</span>
<?php echo $ap_forma_pago->desc_obra_forma_ap->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_forma_pago->tipo_forma_ap->Visible) { // tipo_forma_ap ?>
	<div id="r_tipo_forma_ap" class="form-group">
		<label id="elh_ap_forma_pago_tipo_forma_ap" for="x_tipo_forma_ap" class="col-sm-2 control-label ewLabel"><?php echo $ap_forma_pago->tipo_forma_ap->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_forma_pago->tipo_forma_ap->CellAttributes() ?>>
<span id="el_ap_forma_pago_tipo_forma_ap">
<input type="text" data-table="ap_forma_pago" data-field="x_tipo_forma_ap" name="x_tipo_forma_ap" id="x_tipo_forma_ap" size="30" maxlength="80" placeholder="<?php echo ew_HtmlEncode($ap_forma_pago->tipo_forma_ap->getPlaceHolder()) ?>" value="<?php echo $ap_forma_pago->tipo_forma_ap->EditValue ?>"<?php echo $ap_forma_pago->tipo_forma_ap->EditAttributes() ?>>
</span>
<?php echo $ap_forma_pago->tipo_forma_ap->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ap_forma_pago->empresa_forma_ap->Visible) { // empresa_forma_ap ?>
	<div id="r_empresa_forma_ap" class="form-group">
		<label id="elh_ap_forma_pago_empresa_forma_ap" for="x_empresa_forma_ap" class="col-sm-2 control-label ewLabel"><?php echo $ap_forma_pago->empresa_forma_ap->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ap_forma_pago->empresa_forma_ap->CellAttributes() ?>>
<span id="el_ap_forma_pago_empresa_forma_ap">
<input type="text" data-table="ap_forma_pago" data-field="x_empresa_forma_ap" name="x_empresa_forma_ap" id="x_empresa_forma_ap" size="30" placeholder="<?php echo ew_HtmlEncode($ap_forma_pago->empresa_forma_ap->getPlaceHolder()) ?>" value="<?php echo $ap_forma_pago->empresa_forma_ap->EditValue ?>"<?php echo $ap_forma_pago->empresa_forma_ap->EditAttributes() ?>>
</span>
<?php echo $ap_forma_pago->empresa_forma_ap->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$ap_forma_pago_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $ap_forma_pago_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fap_forma_pagoedit.Init();
</script>
<?php
$ap_forma_pago_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ap_forma_pago_edit->Page_Terminate();
?>
