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

$siax_campana_delete = NULL; // Initialize page object first

class csiax_campana_delete extends csiax_campana {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{6A9AC718-A824-45A3-BED3-A95E91E6986D}";

	// Table name
	var $TableName = 'siax_campana';

	// Page object name
	var $PageObjName = 'siax_campana_delete';

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

		// Table object (siax_campana)
		if (!isset($GLOBALS["siax_campana"]) || get_class($GLOBALS["siax_campana"]) == "csiax_campana") {
			$GLOBALS["siax_campana"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["siax_campana"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

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
		$this->desde_campana->SetVisibility();
		$this->hasta_campana->SetVisibility();
		$this->vigente_campana->SetVisibility();
		$this->tasa_campana->SetVisibility();
		$this->descuento_fijo_campana->SetVisibility();
		$this->manto_max_campana->SetVisibility();

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
			$this->Page_Terminate("siax_campanalist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in siax_campana class, siax_campanainfo.php

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
				$this->Page_Terminate("siax_campanalist.php"); // Return to list
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
				$sThisKey .= $row['id_campana'];
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("siax_campanalist.php"), "", $this->TableVar, TRUE);
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
if (!isset($siax_campana_delete)) $siax_campana_delete = new csiax_campana_delete();

// Page init
$siax_campana_delete->Page_Init();

// Page main
$siax_campana_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$siax_campana_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fsiax_campanadelete = new ew_Form("fsiax_campanadelete", "delete");

// Form_CustomValidate event
fsiax_campanadelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fsiax_campanadelete.ValidateRequired = true;
<?php } else { ?>
fsiax_campanadelete.ValidateRequired = false; 
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
<?php $siax_campana_delete->ShowPageHeader(); ?>
<?php
$siax_campana_delete->ShowMessage();
?>
<form name="fsiax_campanadelete" id="fsiax_campanadelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($siax_campana_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $siax_campana_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="siax_campana">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($siax_campana_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $siax_campana->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($siax_campana->id_campana->Visible) { // id_campana ?>
		<th><span id="elh_siax_campana_id_campana" class="siax_campana_id_campana"><?php echo $siax_campana->id_campana->FldCaption() ?></span></th>
<?php } ?>
<?php if ($siax_campana->nombre_campana->Visible) { // nombre_campana ?>
		<th><span id="elh_siax_campana_nombre_campana" class="siax_campana_nombre_campana"><?php echo $siax_campana->nombre_campana->FldCaption() ?></span></th>
<?php } ?>
<?php if ($siax_campana->descuente_campana->Visible) { // descuente_campana ?>
		<th><span id="elh_siax_campana_descuente_campana" class="siax_campana_descuente_campana"><?php echo $siax_campana->descuente_campana->FldCaption() ?></span></th>
<?php } ?>
<?php if ($siax_campana->desc_financ_campana->Visible) { // desc_financ_campana ?>
		<th><span id="elh_siax_campana_desc_financ_campana" class="siax_campana_desc_financ_campana"><?php echo $siax_campana->desc_financ_campana->FldCaption() ?></span></th>
<?php } ?>
<?php if ($siax_campana->plazo_max_campana->Visible) { // plazo_max_campana ?>
		<th><span id="elh_siax_campana_plazo_max_campana" class="siax_campana_plazo_max_campana"><?php echo $siax_campana->plazo_max_campana->FldCaption() ?></span></th>
<?php } ?>
<?php if ($siax_campana->desde_campana->Visible) { // desde_campana ?>
		<th><span id="elh_siax_campana_desde_campana" class="siax_campana_desde_campana"><?php echo $siax_campana->desde_campana->FldCaption() ?></span></th>
<?php } ?>
<?php if ($siax_campana->hasta_campana->Visible) { // hasta_campana ?>
		<th><span id="elh_siax_campana_hasta_campana" class="siax_campana_hasta_campana"><?php echo $siax_campana->hasta_campana->FldCaption() ?></span></th>
<?php } ?>
<?php if ($siax_campana->vigente_campana->Visible) { // vigente_campana ?>
		<th><span id="elh_siax_campana_vigente_campana" class="siax_campana_vigente_campana"><?php echo $siax_campana->vigente_campana->FldCaption() ?></span></th>
<?php } ?>
<?php if ($siax_campana->tasa_campana->Visible) { // tasa_campana ?>
		<th><span id="elh_siax_campana_tasa_campana" class="siax_campana_tasa_campana"><?php echo $siax_campana->tasa_campana->FldCaption() ?></span></th>
<?php } ?>
<?php if ($siax_campana->descuento_fijo_campana->Visible) { // descuento_fijo_campana ?>
		<th><span id="elh_siax_campana_descuento_fijo_campana" class="siax_campana_descuento_fijo_campana"><?php echo $siax_campana->descuento_fijo_campana->FldCaption() ?></span></th>
<?php } ?>
<?php if ($siax_campana->manto_max_campana->Visible) { // manto_max_campana ?>
		<th><span id="elh_siax_campana_manto_max_campana" class="siax_campana_manto_max_campana"><?php echo $siax_campana->manto_max_campana->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$siax_campana_delete->RecCnt = 0;
$i = 0;
while (!$siax_campana_delete->Recordset->EOF) {
	$siax_campana_delete->RecCnt++;
	$siax_campana_delete->RowCnt++;

	// Set row properties
	$siax_campana->ResetAttrs();
	$siax_campana->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$siax_campana_delete->LoadRowValues($siax_campana_delete->Recordset);

	// Render row
	$siax_campana_delete->RenderRow();
?>
	<tr<?php echo $siax_campana->RowAttributes() ?>>
<?php if ($siax_campana->id_campana->Visible) { // id_campana ?>
		<td<?php echo $siax_campana->id_campana->CellAttributes() ?>>
<span id="el<?php echo $siax_campana_delete->RowCnt ?>_siax_campana_id_campana" class="siax_campana_id_campana">
<span<?php echo $siax_campana->id_campana->ViewAttributes() ?>>
<?php echo $siax_campana->id_campana->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($siax_campana->nombre_campana->Visible) { // nombre_campana ?>
		<td<?php echo $siax_campana->nombre_campana->CellAttributes() ?>>
<span id="el<?php echo $siax_campana_delete->RowCnt ?>_siax_campana_nombre_campana" class="siax_campana_nombre_campana">
<span<?php echo $siax_campana->nombre_campana->ViewAttributes() ?>>
<?php echo $siax_campana->nombre_campana->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($siax_campana->descuente_campana->Visible) { // descuente_campana ?>
		<td<?php echo $siax_campana->descuente_campana->CellAttributes() ?>>
<span id="el<?php echo $siax_campana_delete->RowCnt ?>_siax_campana_descuente_campana" class="siax_campana_descuente_campana">
<span<?php echo $siax_campana->descuente_campana->ViewAttributes() ?>>
<?php echo $siax_campana->descuente_campana->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($siax_campana->desc_financ_campana->Visible) { // desc_financ_campana ?>
		<td<?php echo $siax_campana->desc_financ_campana->CellAttributes() ?>>
<span id="el<?php echo $siax_campana_delete->RowCnt ?>_siax_campana_desc_financ_campana" class="siax_campana_desc_financ_campana">
<span<?php echo $siax_campana->desc_financ_campana->ViewAttributes() ?>>
<?php echo $siax_campana->desc_financ_campana->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($siax_campana->plazo_max_campana->Visible) { // plazo_max_campana ?>
		<td<?php echo $siax_campana->plazo_max_campana->CellAttributes() ?>>
<span id="el<?php echo $siax_campana_delete->RowCnt ?>_siax_campana_plazo_max_campana" class="siax_campana_plazo_max_campana">
<span<?php echo $siax_campana->plazo_max_campana->ViewAttributes() ?>>
<?php echo $siax_campana->plazo_max_campana->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($siax_campana->desde_campana->Visible) { // desde_campana ?>
		<td<?php echo $siax_campana->desde_campana->CellAttributes() ?>>
<span id="el<?php echo $siax_campana_delete->RowCnt ?>_siax_campana_desde_campana" class="siax_campana_desde_campana">
<span<?php echo $siax_campana->desde_campana->ViewAttributes() ?>>
<?php echo $siax_campana->desde_campana->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($siax_campana->hasta_campana->Visible) { // hasta_campana ?>
		<td<?php echo $siax_campana->hasta_campana->CellAttributes() ?>>
<span id="el<?php echo $siax_campana_delete->RowCnt ?>_siax_campana_hasta_campana" class="siax_campana_hasta_campana">
<span<?php echo $siax_campana->hasta_campana->ViewAttributes() ?>>
<?php echo $siax_campana->hasta_campana->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($siax_campana->vigente_campana->Visible) { // vigente_campana ?>
		<td<?php echo $siax_campana->vigente_campana->CellAttributes() ?>>
<span id="el<?php echo $siax_campana_delete->RowCnt ?>_siax_campana_vigente_campana" class="siax_campana_vigente_campana">
<span<?php echo $siax_campana->vigente_campana->ViewAttributes() ?>>
<?php echo $siax_campana->vigente_campana->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($siax_campana->tasa_campana->Visible) { // tasa_campana ?>
		<td<?php echo $siax_campana->tasa_campana->CellAttributes() ?>>
<span id="el<?php echo $siax_campana_delete->RowCnt ?>_siax_campana_tasa_campana" class="siax_campana_tasa_campana">
<span<?php echo $siax_campana->tasa_campana->ViewAttributes() ?>>
<?php echo $siax_campana->tasa_campana->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($siax_campana->descuento_fijo_campana->Visible) { // descuento_fijo_campana ?>
		<td<?php echo $siax_campana->descuento_fijo_campana->CellAttributes() ?>>
<span id="el<?php echo $siax_campana_delete->RowCnt ?>_siax_campana_descuento_fijo_campana" class="siax_campana_descuento_fijo_campana">
<span<?php echo $siax_campana->descuento_fijo_campana->ViewAttributes() ?>>
<?php echo $siax_campana->descuento_fijo_campana->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($siax_campana->manto_max_campana->Visible) { // manto_max_campana ?>
		<td<?php echo $siax_campana->manto_max_campana->CellAttributes() ?>>
<span id="el<?php echo $siax_campana_delete->RowCnt ?>_siax_campana_manto_max_campana" class="siax_campana_manto_max_campana">
<span<?php echo $siax_campana->manto_max_campana->ViewAttributes() ?>>
<?php echo $siax_campana->manto_max_campana->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$siax_campana_delete->Recordset->MoveNext();
}
$siax_campana_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $siax_campana_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fsiax_campanadelete.Init();
</script>
<?php
$siax_campana_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$siax_campana_delete->Page_Terminate();
?>
