<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "ap_estado_preventainfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$ap_estado_preventa_delete = NULL; // Initialize page object first

class cap_estado_preventa_delete extends cap_estado_preventa {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{6A9AC718-A824-45A3-BED3-A95E91E6986D}";

	// Table name
	var $TableName = 'ap_estado_preventa';

	// Page object name
	var $PageObjName = 'ap_estado_preventa_delete';

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

		// Table object (ap_estado_preventa)
		if (!isset($GLOBALS["ap_estado_preventa"]) || get_class($GLOBALS["ap_estado_preventa"]) == "cap_estado_preventa") {
			$GLOBALS["ap_estado_preventa"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ap_estado_preventa"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ap_estado_preventa', TRUE);

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
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("ap_estado_preventalist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id_estado_preventa->SetVisibility();
		$this->nombre_estado_preventa->SetVisibility();
		$this->activo_estado_preventa->SetVisibility();
		$this->detalle_estado_preventa->SetVisibility();
		$this->empresa_estado_preventa->SetVisibility();

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
		global $EW_EXPORT, $ap_estado_preventa;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($ap_estado_preventa);
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
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("ap_estado_preventalist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in ap_estado_preventa class, ap_estado_preventainfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("ap_estado_preventalist.php"); // Return to list
			}
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
		$this->id_estado_preventa->setDbValue($rs->fields('id_estado_preventa'));
		$this->nombre_estado_preventa->setDbValue($rs->fields('nombre_estado_preventa'));
		$this->activo_estado_preventa->setDbValue($rs->fields('activo_estado_preventa'));
		$this->detalle_estado_preventa->setDbValue($rs->fields('detalle_estado_preventa'));
		$this->empresa_estado_preventa->setDbValue($rs->fields('empresa_estado_preventa'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id_estado_preventa->DbValue = $row['id_estado_preventa'];
		$this->nombre_estado_preventa->DbValue = $row['nombre_estado_preventa'];
		$this->activo_estado_preventa->DbValue = $row['activo_estado_preventa'];
		$this->detalle_estado_preventa->DbValue = $row['detalle_estado_preventa'];
		$this->empresa_estado_preventa->DbValue = $row['empresa_estado_preventa'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id_estado_preventa
		// nombre_estado_preventa
		// activo_estado_preventa
		// detalle_estado_preventa
		// empresa_estado_preventa

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id_estado_preventa
		$this->id_estado_preventa->ViewValue = $this->id_estado_preventa->CurrentValue;
		$this->id_estado_preventa->ViewCustomAttributes = "";

		// nombre_estado_preventa
		$this->nombre_estado_preventa->ViewValue = $this->nombre_estado_preventa->CurrentValue;
		$this->nombre_estado_preventa->ViewCustomAttributes = "";

		// activo_estado_preventa
		$this->activo_estado_preventa->ViewValue = $this->activo_estado_preventa->CurrentValue;
		$this->activo_estado_preventa->ViewCustomAttributes = "";

		// detalle_estado_preventa
		$this->detalle_estado_preventa->ViewValue = $this->detalle_estado_preventa->CurrentValue;
		$this->detalle_estado_preventa->ViewCustomAttributes = "";

		// empresa_estado_preventa
		$this->empresa_estado_preventa->ViewValue = $this->empresa_estado_preventa->CurrentValue;
		$this->empresa_estado_preventa->ViewCustomAttributes = "";

			// id_estado_preventa
			$this->id_estado_preventa->LinkCustomAttributes = "";
			$this->id_estado_preventa->HrefValue = "";
			$this->id_estado_preventa->TooltipValue = "";

			// nombre_estado_preventa
			$this->nombre_estado_preventa->LinkCustomAttributes = "";
			$this->nombre_estado_preventa->HrefValue = "";
			$this->nombre_estado_preventa->TooltipValue = "";

			// activo_estado_preventa
			$this->activo_estado_preventa->LinkCustomAttributes = "";
			$this->activo_estado_preventa->HrefValue = "";
			$this->activo_estado_preventa->TooltipValue = "";

			// detalle_estado_preventa
			$this->detalle_estado_preventa->LinkCustomAttributes = "";
			$this->detalle_estado_preventa->HrefValue = "";
			$this->detalle_estado_preventa->TooltipValue = "";

			// empresa_estado_preventa
			$this->empresa_estado_preventa->LinkCustomAttributes = "";
			$this->empresa_estado_preventa->HrefValue = "";
			$this->empresa_estado_preventa->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['id_estado_preventa'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("ap_estado_preventalist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($ap_estado_preventa_delete)) $ap_estado_preventa_delete = new cap_estado_preventa_delete();

// Page init
$ap_estado_preventa_delete->Page_Init();

// Page main
$ap_estado_preventa_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ap_estado_preventa_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fap_estado_preventadelete = new ew_Form("fap_estado_preventadelete", "delete");

// Form_CustomValidate event
fap_estado_preventadelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fap_estado_preventadelete.ValidateRequired = true;
<?php } else { ?>
fap_estado_preventadelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $ap_estado_preventa_delete->ShowPageHeader(); ?>
<?php
$ap_estado_preventa_delete->ShowMessage();
?>
<form name="fap_estado_preventadelete" id="fap_estado_preventadelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($ap_estado_preventa_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $ap_estado_preventa_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ap_estado_preventa">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($ap_estado_preventa_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $ap_estado_preventa->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($ap_estado_preventa->id_estado_preventa->Visible) { // id_estado_preventa ?>
		<th><span id="elh_ap_estado_preventa_id_estado_preventa" class="ap_estado_preventa_id_estado_preventa"><?php echo $ap_estado_preventa->id_estado_preventa->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_estado_preventa->nombre_estado_preventa->Visible) { // nombre_estado_preventa ?>
		<th><span id="elh_ap_estado_preventa_nombre_estado_preventa" class="ap_estado_preventa_nombre_estado_preventa"><?php echo $ap_estado_preventa->nombre_estado_preventa->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_estado_preventa->activo_estado_preventa->Visible) { // activo_estado_preventa ?>
		<th><span id="elh_ap_estado_preventa_activo_estado_preventa" class="ap_estado_preventa_activo_estado_preventa"><?php echo $ap_estado_preventa->activo_estado_preventa->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_estado_preventa->detalle_estado_preventa->Visible) { // detalle_estado_preventa ?>
		<th><span id="elh_ap_estado_preventa_detalle_estado_preventa" class="ap_estado_preventa_detalle_estado_preventa"><?php echo $ap_estado_preventa->detalle_estado_preventa->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_estado_preventa->empresa_estado_preventa->Visible) { // empresa_estado_preventa ?>
		<th><span id="elh_ap_estado_preventa_empresa_estado_preventa" class="ap_estado_preventa_empresa_estado_preventa"><?php echo $ap_estado_preventa->empresa_estado_preventa->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$ap_estado_preventa_delete->RecCnt = 0;
$i = 0;
while (!$ap_estado_preventa_delete->Recordset->EOF) {
	$ap_estado_preventa_delete->RecCnt++;
	$ap_estado_preventa_delete->RowCnt++;

	// Set row properties
	$ap_estado_preventa->ResetAttrs();
	$ap_estado_preventa->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$ap_estado_preventa_delete->LoadRowValues($ap_estado_preventa_delete->Recordset);

	// Render row
	$ap_estado_preventa_delete->RenderRow();
?>
	<tr<?php echo $ap_estado_preventa->RowAttributes() ?>>
<?php if ($ap_estado_preventa->id_estado_preventa->Visible) { // id_estado_preventa ?>
		<td<?php echo $ap_estado_preventa->id_estado_preventa->CellAttributes() ?>>
<span id="el<?php echo $ap_estado_preventa_delete->RowCnt ?>_ap_estado_preventa_id_estado_preventa" class="ap_estado_preventa_id_estado_preventa">
<span<?php echo $ap_estado_preventa->id_estado_preventa->ViewAttributes() ?>>
<?php echo $ap_estado_preventa->id_estado_preventa->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_estado_preventa->nombre_estado_preventa->Visible) { // nombre_estado_preventa ?>
		<td<?php echo $ap_estado_preventa->nombre_estado_preventa->CellAttributes() ?>>
<span id="el<?php echo $ap_estado_preventa_delete->RowCnt ?>_ap_estado_preventa_nombre_estado_preventa" class="ap_estado_preventa_nombre_estado_preventa">
<span<?php echo $ap_estado_preventa->nombre_estado_preventa->ViewAttributes() ?>>
<?php echo $ap_estado_preventa->nombre_estado_preventa->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_estado_preventa->activo_estado_preventa->Visible) { // activo_estado_preventa ?>
		<td<?php echo $ap_estado_preventa->activo_estado_preventa->CellAttributes() ?>>
<span id="el<?php echo $ap_estado_preventa_delete->RowCnt ?>_ap_estado_preventa_activo_estado_preventa" class="ap_estado_preventa_activo_estado_preventa">
<span<?php echo $ap_estado_preventa->activo_estado_preventa->ViewAttributes() ?>>
<?php echo $ap_estado_preventa->activo_estado_preventa->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_estado_preventa->detalle_estado_preventa->Visible) { // detalle_estado_preventa ?>
		<td<?php echo $ap_estado_preventa->detalle_estado_preventa->CellAttributes() ?>>
<span id="el<?php echo $ap_estado_preventa_delete->RowCnt ?>_ap_estado_preventa_detalle_estado_preventa" class="ap_estado_preventa_detalle_estado_preventa">
<span<?php echo $ap_estado_preventa->detalle_estado_preventa->ViewAttributes() ?>>
<?php echo $ap_estado_preventa->detalle_estado_preventa->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_estado_preventa->empresa_estado_preventa->Visible) { // empresa_estado_preventa ?>
		<td<?php echo $ap_estado_preventa->empresa_estado_preventa->CellAttributes() ?>>
<span id="el<?php echo $ap_estado_preventa_delete->RowCnt ?>_ap_estado_preventa_empresa_estado_preventa" class="ap_estado_preventa_empresa_estado_preventa">
<span<?php echo $ap_estado_preventa->empresa_estado_preventa->ViewAttributes() ?>>
<?php echo $ap_estado_preventa->empresa_estado_preventa->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$ap_estado_preventa_delete->Recordset->MoveNext();
}
$ap_estado_preventa_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $ap_estado_preventa_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fap_estado_preventadelete.Init();
</script>
<?php
$ap_estado_preventa_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ap_estado_preventa_delete->Page_Terminate();
?>
