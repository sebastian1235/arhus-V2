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

$ap_roles_usuarios_delete = NULL; // Initialize page object first

class cap_roles_usuarios_delete extends cap_roles_usuarios {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{6A9AC718-A824-45A3-BED3-A95E91E6986D}";

	// Table name
	var $TableName = 'ap_roles_usuarios';

	// Page object name
	var $PageObjName = 'ap_roles_usuarios_delete';

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

		// Table object (ap_roles_usuarios)
		if (!isset($GLOBALS["ap_roles_usuarios"]) || get_class($GLOBALS["ap_roles_usuarios"]) == "cap_roles_usuarios") {
			$GLOBALS["ap_roles_usuarios"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ap_roles_usuarios"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

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
			$this->Page_Terminate("ap_roles_usuarioslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in ap_roles_usuarios class, ap_roles_usuariosinfo.php

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
				$this->Page_Terminate("ap_roles_usuarioslist.php"); // Return to list
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
				$sThisKey .= $row['Id_Rol'];
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("ap_roles_usuarioslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($ap_roles_usuarios_delete)) $ap_roles_usuarios_delete = new cap_roles_usuarios_delete();

// Page init
$ap_roles_usuarios_delete->Page_Init();

// Page main
$ap_roles_usuarios_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ap_roles_usuarios_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fap_roles_usuariosdelete = new ew_Form("fap_roles_usuariosdelete", "delete");

// Form_CustomValidate event
fap_roles_usuariosdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fap_roles_usuariosdelete.ValidateRequired = true;
<?php } else { ?>
fap_roles_usuariosdelete.ValidateRequired = false; 
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
<?php $ap_roles_usuarios_delete->ShowPageHeader(); ?>
<?php
$ap_roles_usuarios_delete->ShowMessage();
?>
<form name="fap_roles_usuariosdelete" id="fap_roles_usuariosdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($ap_roles_usuarios_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $ap_roles_usuarios_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ap_roles_usuarios">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($ap_roles_usuarios_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $ap_roles_usuarios->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($ap_roles_usuarios->Id_Rol->Visible) { // Id_Rol ?>
		<th><span id="elh_ap_roles_usuarios_Id_Rol" class="ap_roles_usuarios_Id_Rol"><?php echo $ap_roles_usuarios->Id_Rol->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_roles_usuarios->grupo_Rol->Visible) { // grupo_Rol ?>
		<th><span id="elh_ap_roles_usuarios_grupo_Rol" class="ap_roles_usuarios_grupo_Rol"><?php echo $ap_roles_usuarios->grupo_Rol->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_roles_usuarios->abrir_Rol->Visible) { // abrir_Rol ?>
		<th><span id="elh_ap_roles_usuarios_abrir_Rol" class="ap_roles_usuarios_abrir_Rol"><?php echo $ap_roles_usuarios->abrir_Rol->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_roles_usuarios->agregar_Rol->Visible) { // agregar_Rol ?>
		<th><span id="elh_ap_roles_usuarios_agregar_Rol" class="ap_roles_usuarios_agregar_Rol"><?php echo $ap_roles_usuarios->agregar_Rol->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_roles_usuarios->editar_Rol->Visible) { // editar_Rol ?>
		<th><span id="elh_ap_roles_usuarios_editar_Rol" class="ap_roles_usuarios_editar_Rol"><?php echo $ap_roles_usuarios->editar_Rol->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_roles_usuarios->eliminar_Rol->Visible) { // eliminar_Rol ?>
		<th><span id="elh_ap_roles_usuarios_eliminar_Rol" class="ap_roles_usuarios_eliminar_Rol"><?php echo $ap_roles_usuarios->eliminar_Rol->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_roles_usuarios->mostrar_Rol->Visible) { // mostrar_Rol ?>
		<th><span id="elh_ap_roles_usuarios_mostrar_Rol" class="ap_roles_usuarios_mostrar_Rol"><?php echo $ap_roles_usuarios->mostrar_Rol->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_roles_usuarios->alias_Rol->Visible) { // alias_Rol ?>
		<th><span id="elh_ap_roles_usuarios_alias_Rol" class="ap_roles_usuarios_alias_Rol"><?php echo $ap_roles_usuarios->alias_Rol->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_roles_usuarios->empresa_Rol->Visible) { // empresa_Rol ?>
		<th><span id="elh_ap_roles_usuarios_empresa_Rol" class="ap_roles_usuarios_empresa_Rol"><?php echo $ap_roles_usuarios->empresa_Rol->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$ap_roles_usuarios_delete->RecCnt = 0;
$i = 0;
while (!$ap_roles_usuarios_delete->Recordset->EOF) {
	$ap_roles_usuarios_delete->RecCnt++;
	$ap_roles_usuarios_delete->RowCnt++;

	// Set row properties
	$ap_roles_usuarios->ResetAttrs();
	$ap_roles_usuarios->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$ap_roles_usuarios_delete->LoadRowValues($ap_roles_usuarios_delete->Recordset);

	// Render row
	$ap_roles_usuarios_delete->RenderRow();
?>
	<tr<?php echo $ap_roles_usuarios->RowAttributes() ?>>
<?php if ($ap_roles_usuarios->Id_Rol->Visible) { // Id_Rol ?>
		<td<?php echo $ap_roles_usuarios->Id_Rol->CellAttributes() ?>>
<span id="el<?php echo $ap_roles_usuarios_delete->RowCnt ?>_ap_roles_usuarios_Id_Rol" class="ap_roles_usuarios_Id_Rol">
<span<?php echo $ap_roles_usuarios->Id_Rol->ViewAttributes() ?>>
<?php echo $ap_roles_usuarios->Id_Rol->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_roles_usuarios->grupo_Rol->Visible) { // grupo_Rol ?>
		<td<?php echo $ap_roles_usuarios->grupo_Rol->CellAttributes() ?>>
<span id="el<?php echo $ap_roles_usuarios_delete->RowCnt ?>_ap_roles_usuarios_grupo_Rol" class="ap_roles_usuarios_grupo_Rol">
<span<?php echo $ap_roles_usuarios->grupo_Rol->ViewAttributes() ?>>
<?php echo $ap_roles_usuarios->grupo_Rol->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_roles_usuarios->abrir_Rol->Visible) { // abrir_Rol ?>
		<td<?php echo $ap_roles_usuarios->abrir_Rol->CellAttributes() ?>>
<span id="el<?php echo $ap_roles_usuarios_delete->RowCnt ?>_ap_roles_usuarios_abrir_Rol" class="ap_roles_usuarios_abrir_Rol">
<span<?php echo $ap_roles_usuarios->abrir_Rol->ViewAttributes() ?>>
<?php echo $ap_roles_usuarios->abrir_Rol->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_roles_usuarios->agregar_Rol->Visible) { // agregar_Rol ?>
		<td<?php echo $ap_roles_usuarios->agregar_Rol->CellAttributes() ?>>
<span id="el<?php echo $ap_roles_usuarios_delete->RowCnt ?>_ap_roles_usuarios_agregar_Rol" class="ap_roles_usuarios_agregar_Rol">
<span<?php echo $ap_roles_usuarios->agregar_Rol->ViewAttributes() ?>>
<?php echo $ap_roles_usuarios->agregar_Rol->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_roles_usuarios->editar_Rol->Visible) { // editar_Rol ?>
		<td<?php echo $ap_roles_usuarios->editar_Rol->CellAttributes() ?>>
<span id="el<?php echo $ap_roles_usuarios_delete->RowCnt ?>_ap_roles_usuarios_editar_Rol" class="ap_roles_usuarios_editar_Rol">
<span<?php echo $ap_roles_usuarios->editar_Rol->ViewAttributes() ?>>
<?php echo $ap_roles_usuarios->editar_Rol->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_roles_usuarios->eliminar_Rol->Visible) { // eliminar_Rol ?>
		<td<?php echo $ap_roles_usuarios->eliminar_Rol->CellAttributes() ?>>
<span id="el<?php echo $ap_roles_usuarios_delete->RowCnt ?>_ap_roles_usuarios_eliminar_Rol" class="ap_roles_usuarios_eliminar_Rol">
<span<?php echo $ap_roles_usuarios->eliminar_Rol->ViewAttributes() ?>>
<?php echo $ap_roles_usuarios->eliminar_Rol->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_roles_usuarios->mostrar_Rol->Visible) { // mostrar_Rol ?>
		<td<?php echo $ap_roles_usuarios->mostrar_Rol->CellAttributes() ?>>
<span id="el<?php echo $ap_roles_usuarios_delete->RowCnt ?>_ap_roles_usuarios_mostrar_Rol" class="ap_roles_usuarios_mostrar_Rol">
<span<?php echo $ap_roles_usuarios->mostrar_Rol->ViewAttributes() ?>>
<?php echo $ap_roles_usuarios->mostrar_Rol->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_roles_usuarios->alias_Rol->Visible) { // alias_Rol ?>
		<td<?php echo $ap_roles_usuarios->alias_Rol->CellAttributes() ?>>
<span id="el<?php echo $ap_roles_usuarios_delete->RowCnt ?>_ap_roles_usuarios_alias_Rol" class="ap_roles_usuarios_alias_Rol">
<span<?php echo $ap_roles_usuarios->alias_Rol->ViewAttributes() ?>>
<?php echo $ap_roles_usuarios->alias_Rol->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_roles_usuarios->empresa_Rol->Visible) { // empresa_Rol ?>
		<td<?php echo $ap_roles_usuarios->empresa_Rol->CellAttributes() ?>>
<span id="el<?php echo $ap_roles_usuarios_delete->RowCnt ?>_ap_roles_usuarios_empresa_Rol" class="ap_roles_usuarios_empresa_Rol">
<span<?php echo $ap_roles_usuarios->empresa_Rol->ViewAttributes() ?>>
<?php echo $ap_roles_usuarios->empresa_Rol->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$ap_roles_usuarios_delete->Recordset->MoveNext();
}
$ap_roles_usuarios_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $ap_roles_usuarios_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fap_roles_usuariosdelete.Init();
</script>
<?php
$ap_roles_usuarios_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ap_roles_usuarios_delete->Page_Terminate();
?>
