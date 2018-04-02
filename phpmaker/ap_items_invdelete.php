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

$ap_items_inv_delete = NULL; // Initialize page object first

class cap_items_inv_delete extends cap_items_inv {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{6A9AC718-A824-45A3-BED3-A95E91E6986D}";

	// Table name
	var $TableName = 'ap_items_inv';

	// Page object name
	var $PageObjName = 'ap_items_inv_delete';

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

		// Table object (ap_items_inv)
		if (!isset($GLOBALS["ap_items_inv"]) || get_class($GLOBALS["ap_items_inv"]) == "cap_items_inv") {
			$GLOBALS["ap_items_inv"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ap_items_inv"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

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
			$this->Page_Terminate("ap_items_invlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in ap_items_inv class, ap_items_invinfo.php

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
				$this->Page_Terminate("ap_items_invlist.php"); // Return to list
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
				$sThisKey .= $row['Id_Item'];
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("ap_items_invlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($ap_items_inv_delete)) $ap_items_inv_delete = new cap_items_inv_delete();

// Page init
$ap_items_inv_delete->Page_Init();

// Page main
$ap_items_inv_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ap_items_inv_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fap_items_invdelete = new ew_Form("fap_items_invdelete", "delete");

// Form_CustomValidate event
fap_items_invdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fap_items_invdelete.ValidateRequired = true;
<?php } else { ?>
fap_items_invdelete.ValidateRequired = false; 
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
<?php $ap_items_inv_delete->ShowPageHeader(); ?>
<?php
$ap_items_inv_delete->ShowMessage();
?>
<form name="fap_items_invdelete" id="fap_items_invdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($ap_items_inv_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $ap_items_inv_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ap_items_inv">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($ap_items_inv_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $ap_items_inv->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($ap_items_inv->Id_Item->Visible) { // Id_Item ?>
		<th><span id="elh_ap_items_inv_Id_Item" class="ap_items_inv_Id_Item"><?php echo $ap_items_inv->Id_Item->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_items_inv->codigo_item->Visible) { // codigo_item ?>
		<th><span id="elh_ap_items_inv_codigo_item" class="ap_items_inv_codigo_item"><?php echo $ap_items_inv->codigo_item->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_items_inv->nombre_item->Visible) { // nombre_item ?>
		<th><span id="elh_ap_items_inv_nombre_item" class="ap_items_inv_nombre_item"><?php echo $ap_items_inv->nombre_item->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_items_inv->und_item->Visible) { // und_item ?>
		<th><span id="elh_ap_items_inv_und_item" class="ap_items_inv_und_item"><?php echo $ap_items_inv->und_item->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_items_inv->precio_item->Visible) { // precio_item ?>
		<th><span id="elh_ap_items_inv_precio_item" class="ap_items_inv_precio_item"><?php echo $ap_items_inv->precio_item->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_items_inv->costo_item->Visible) { // costo_item ?>
		<th><span id="elh_ap_items_inv_costo_item" class="ap_items_inv_costo_item"><?php echo $ap_items_inv->costo_item->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_items_inv->tipo_item->Visible) { // tipo_item ?>
		<th><span id="elh_ap_items_inv_tipo_item" class="ap_items_inv_tipo_item"><?php echo $ap_items_inv->tipo_item->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_items_inv->marca_item->Visible) { // marca_item ?>
		<th><span id="elh_ap_items_inv_marca_item" class="ap_items_inv_marca_item"><?php echo $ap_items_inv->marca_item->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_items_inv->cod_marca_item->Visible) { // cod_marca_item ?>
		<th><span id="elh_ap_items_inv_cod_marca_item" class="ap_items_inv_cod_marca_item"><?php echo $ap_items_inv->cod_marca_item->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_items_inv->detalle_item->Visible) { // detalle_item ?>
		<th><span id="elh_ap_items_inv_detalle_item" class="ap_items_inv_detalle_item"><?php echo $ap_items_inv->detalle_item->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_items_inv->saldo_item->Visible) { // saldo_item ?>
		<th><span id="elh_ap_items_inv_saldo_item" class="ap_items_inv_saldo_item"><?php echo $ap_items_inv->saldo_item->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_items_inv->activo_item->Visible) { // activo_item ?>
		<th><span id="elh_ap_items_inv_activo_item" class="ap_items_inv_activo_item"><?php echo $ap_items_inv->activo_item->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_items_inv->maneja_serial_item->Visible) { // maneja_serial_item ?>
		<th><span id="elh_ap_items_inv_maneja_serial_item" class="ap_items_inv_maneja_serial_item"><?php echo $ap_items_inv->maneja_serial_item->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_items_inv->asignado_item->Visible) { // asignado_item ?>
		<th><span id="elh_ap_items_inv_asignado_item" class="ap_items_inv_asignado_item"><?php echo $ap_items_inv->asignado_item->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_items_inv->si_no_item->Visible) { // si_no_item ?>
		<th><span id="elh_ap_items_inv_si_no_item" class="ap_items_inv_si_no_item"><?php echo $ap_items_inv->si_no_item->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_items_inv->precio_old_item->Visible) { // precio_old_item ?>
		<th><span id="elh_ap_items_inv_precio_old_item" class="ap_items_inv_precio_old_item"><?php echo $ap_items_inv->precio_old_item->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_items_inv->costo_old_item->Visible) { // costo_old_item ?>
		<th><span id="elh_ap_items_inv_costo_old_item" class="ap_items_inv_costo_old_item"><?php echo $ap_items_inv->costo_old_item->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_items_inv->registra_item->Visible) { // registra_item ?>
		<th><span id="elh_ap_items_inv_registra_item" class="ap_items_inv_registra_item"><?php echo $ap_items_inv->registra_item->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_items_inv->fecha_registro_item->Visible) { // fecha_registro_item ?>
		<th><span id="elh_ap_items_inv_fecha_registro_item" class="ap_items_inv_fecha_registro_item"><?php echo $ap_items_inv->fecha_registro_item->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ap_items_inv->empresa_item->Visible) { // empresa_item ?>
		<th><span id="elh_ap_items_inv_empresa_item" class="ap_items_inv_empresa_item"><?php echo $ap_items_inv->empresa_item->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$ap_items_inv_delete->RecCnt = 0;
$i = 0;
while (!$ap_items_inv_delete->Recordset->EOF) {
	$ap_items_inv_delete->RecCnt++;
	$ap_items_inv_delete->RowCnt++;

	// Set row properties
	$ap_items_inv->ResetAttrs();
	$ap_items_inv->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$ap_items_inv_delete->LoadRowValues($ap_items_inv_delete->Recordset);

	// Render row
	$ap_items_inv_delete->RenderRow();
?>
	<tr<?php echo $ap_items_inv->RowAttributes() ?>>
<?php if ($ap_items_inv->Id_Item->Visible) { // Id_Item ?>
		<td<?php echo $ap_items_inv->Id_Item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_delete->RowCnt ?>_ap_items_inv_Id_Item" class="ap_items_inv_Id_Item">
<span<?php echo $ap_items_inv->Id_Item->ViewAttributes() ?>>
<?php echo $ap_items_inv->Id_Item->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_items_inv->codigo_item->Visible) { // codigo_item ?>
		<td<?php echo $ap_items_inv->codigo_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_delete->RowCnt ?>_ap_items_inv_codigo_item" class="ap_items_inv_codigo_item">
<span<?php echo $ap_items_inv->codigo_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->codigo_item->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_items_inv->nombre_item->Visible) { // nombre_item ?>
		<td<?php echo $ap_items_inv->nombre_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_delete->RowCnt ?>_ap_items_inv_nombre_item" class="ap_items_inv_nombre_item">
<span<?php echo $ap_items_inv->nombre_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->nombre_item->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_items_inv->und_item->Visible) { // und_item ?>
		<td<?php echo $ap_items_inv->und_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_delete->RowCnt ?>_ap_items_inv_und_item" class="ap_items_inv_und_item">
<span<?php echo $ap_items_inv->und_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->und_item->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_items_inv->precio_item->Visible) { // precio_item ?>
		<td<?php echo $ap_items_inv->precio_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_delete->RowCnt ?>_ap_items_inv_precio_item" class="ap_items_inv_precio_item">
<span<?php echo $ap_items_inv->precio_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->precio_item->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_items_inv->costo_item->Visible) { // costo_item ?>
		<td<?php echo $ap_items_inv->costo_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_delete->RowCnt ?>_ap_items_inv_costo_item" class="ap_items_inv_costo_item">
<span<?php echo $ap_items_inv->costo_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->costo_item->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_items_inv->tipo_item->Visible) { // tipo_item ?>
		<td<?php echo $ap_items_inv->tipo_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_delete->RowCnt ?>_ap_items_inv_tipo_item" class="ap_items_inv_tipo_item">
<span<?php echo $ap_items_inv->tipo_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->tipo_item->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_items_inv->marca_item->Visible) { // marca_item ?>
		<td<?php echo $ap_items_inv->marca_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_delete->RowCnt ?>_ap_items_inv_marca_item" class="ap_items_inv_marca_item">
<span<?php echo $ap_items_inv->marca_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->marca_item->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_items_inv->cod_marca_item->Visible) { // cod_marca_item ?>
		<td<?php echo $ap_items_inv->cod_marca_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_delete->RowCnt ?>_ap_items_inv_cod_marca_item" class="ap_items_inv_cod_marca_item">
<span<?php echo $ap_items_inv->cod_marca_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->cod_marca_item->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_items_inv->detalle_item->Visible) { // detalle_item ?>
		<td<?php echo $ap_items_inv->detalle_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_delete->RowCnt ?>_ap_items_inv_detalle_item" class="ap_items_inv_detalle_item">
<span<?php echo $ap_items_inv->detalle_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->detalle_item->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_items_inv->saldo_item->Visible) { // saldo_item ?>
		<td<?php echo $ap_items_inv->saldo_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_delete->RowCnt ?>_ap_items_inv_saldo_item" class="ap_items_inv_saldo_item">
<span<?php echo $ap_items_inv->saldo_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->saldo_item->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_items_inv->activo_item->Visible) { // activo_item ?>
		<td<?php echo $ap_items_inv->activo_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_delete->RowCnt ?>_ap_items_inv_activo_item" class="ap_items_inv_activo_item">
<span<?php echo $ap_items_inv->activo_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->activo_item->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_items_inv->maneja_serial_item->Visible) { // maneja_serial_item ?>
		<td<?php echo $ap_items_inv->maneja_serial_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_delete->RowCnt ?>_ap_items_inv_maneja_serial_item" class="ap_items_inv_maneja_serial_item">
<span<?php echo $ap_items_inv->maneja_serial_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->maneja_serial_item->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_items_inv->asignado_item->Visible) { // asignado_item ?>
		<td<?php echo $ap_items_inv->asignado_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_delete->RowCnt ?>_ap_items_inv_asignado_item" class="ap_items_inv_asignado_item">
<span<?php echo $ap_items_inv->asignado_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->asignado_item->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_items_inv->si_no_item->Visible) { // si_no_item ?>
		<td<?php echo $ap_items_inv->si_no_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_delete->RowCnt ?>_ap_items_inv_si_no_item" class="ap_items_inv_si_no_item">
<span<?php echo $ap_items_inv->si_no_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->si_no_item->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_items_inv->precio_old_item->Visible) { // precio_old_item ?>
		<td<?php echo $ap_items_inv->precio_old_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_delete->RowCnt ?>_ap_items_inv_precio_old_item" class="ap_items_inv_precio_old_item">
<span<?php echo $ap_items_inv->precio_old_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->precio_old_item->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_items_inv->costo_old_item->Visible) { // costo_old_item ?>
		<td<?php echo $ap_items_inv->costo_old_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_delete->RowCnt ?>_ap_items_inv_costo_old_item" class="ap_items_inv_costo_old_item">
<span<?php echo $ap_items_inv->costo_old_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->costo_old_item->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_items_inv->registra_item->Visible) { // registra_item ?>
		<td<?php echo $ap_items_inv->registra_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_delete->RowCnt ?>_ap_items_inv_registra_item" class="ap_items_inv_registra_item">
<span<?php echo $ap_items_inv->registra_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->registra_item->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_items_inv->fecha_registro_item->Visible) { // fecha_registro_item ?>
		<td<?php echo $ap_items_inv->fecha_registro_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_delete->RowCnt ?>_ap_items_inv_fecha_registro_item" class="ap_items_inv_fecha_registro_item">
<span<?php echo $ap_items_inv->fecha_registro_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->fecha_registro_item->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ap_items_inv->empresa_item->Visible) { // empresa_item ?>
		<td<?php echo $ap_items_inv->empresa_item->CellAttributes() ?>>
<span id="el<?php echo $ap_items_inv_delete->RowCnt ?>_ap_items_inv_empresa_item" class="ap_items_inv_empresa_item">
<span<?php echo $ap_items_inv->empresa_item->ViewAttributes() ?>>
<?php echo $ap_items_inv->empresa_item->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$ap_items_inv_delete->Recordset->MoveNext();
}
$ap_items_inv_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $ap_items_inv_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fap_items_invdelete.Init();
</script>
<?php
$ap_items_inv_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ap_items_inv_delete->Page_Terminate();
?>
