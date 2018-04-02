<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "demandainfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$demanda_list = NULL; // Initialize page object first

class cdemanda_list extends cdemanda {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{3c2eb249-6005-4b92-a630-63013a72a8ad}";

	// Table name
	var $TableName = 'demanda';

	// Page object name
	var $PageObjName = 'demanda_list';

	// Grid form hidden field names
	var $FormName = 'fdemandalist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

		// Table object (demanda)
		if (!isset($GLOBALS["demanda"]) || get_class($GLOBALS["demanda"]) == "cdemanda") {
			$GLOBALS["demanda"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["demanda"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "demandaadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "demandadelete.php";
		$this->MultiUpdateUrl = "demandaupdate.php";

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'demanda', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// User table object (usuarios)
		if (!isset($UserTable)) {
			$UserTable = new cusuarios();
			$UserTableConn = Conn($UserTable->DBID);
		}

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption fdemandalistsrch";

		// List actions
		$this->ListActions = new cListActions();
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
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			$this->Page_Terminate(ew_GetUrl("index.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}

		// Get export parameters
		$custom = "";
		if (@$_GET["export"] <> "") {
			$this->Export = $_GET["export"];
			$custom = @$_GET["custom"];
		} elseif (@$_POST["export"] <> "") {
			$this->Export = $_POST["export"];
			$custom = @$_POST["custom"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$this->Export = $_POST["exporttype"];
			$custom = @$_POST["custom"];
		} else {
			$this->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExportFile = $this->TableVar; // Get export file, used in header

		// Get custom export parameters
		if ($this->Export <> "" && $custom <> "") {
			$this->CustomExport = $this->Export;
			$this->Export = "print";
		}
		$gsCustomExport = $this->CustomExport;
		$gsExport = $this->Export; // Get export parameter, used in header

		// Update Export URLs
		if (defined("EW_USE_PHPEXCEL"))
			$this->ExportExcelCustom = FALSE;
		if ($this->ExportExcelCustom)
			$this->ExportExcelUrl .= "&amp;custom=1";
		if (defined("EW_USE_PHPWORD"))
			$this->ExportWordCustom = FALSE;
		if ($this->ExportWordCustom)
			$this->ExportWordUrl .= "&amp;custom=1";
		if ($this->ExportPdfCustom)
			$this->ExportPdfUrl .= "&amp;custom=1";
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

		// Setup export options
		$this->SetupExportOptions();
		$this->origen_dem->SetVisibility();
		$this->tipo_cliente_dem->SetVisibility();
		$this->fecha_llamada->SetVisibility();
		$this->cod_dem->SetVisibility();
		$this->poliza_dem->SetVisibility();
		$this->usuario_captura->SetVisibility();
		$this->campana_demanda->SetVisibility();
		$this->chip_natural->SetVisibility();
		$this->estado_predio->SetVisibility();
		$this->tipo_predio->SetVisibility();
		$this->uso->SetVisibility();
		$this->mecado->SetVisibility();
		$this->nombre_cliente->SetVisibility();
		$this->num_doc->SetVisibility();
		$this->direccion->SetVisibility();
		$this->municipio->SetVisibility();
		$this->telefono->SetVisibility();
		$this->cod_trabajo_original->SetVisibility();
		$this->fecha_trab_dem->SetVisibility();
		$this->cod_ult_visit->SetVisibility();
		$this->res_ult_vis->SetVisibility();
		$this->fecha_ult_visita->SetVisibility();
		$this->usu_asig_primer_trab->SetVisibility();
		$this->fecha_prim_visit->SetVisibility();
		$this->respuesta_pv->SetVisibility();
		$this->fecha_cap_primera_visita->SetVisibility();
		$this->cod_contratista->SetVisibility();
		$this->nom_cont->SetVisibility();
		$this->distrito->SetVisibility();
		$this->malla->SetVisibility();
		$this->sector->SetVisibility();
		$this->descr_estado_dem->SetVisibility();
		$this->estrato->SetVisibility();
		$this->clase_dem->SetVisibility();

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

		// Setup other options
		$this->SetupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
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
		global $EW_EXPORT, $demanda;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($demanda);
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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $DisplayRecs = 25;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;	
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->BasicSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Process filter list
			$this->ProcessFilterList();

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 25; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} else {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";

		// Export data only
		if ($this->CustomExport == "" && in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->SelectRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 0) {
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Load server side filters
		if (EW_SEARCH_FILTER_OPTION == "Server") {
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "fdemandalistsrch");
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->origen_dem->AdvancedSearch->ToJSON(), ","); // Field origen_dem
		$sFilterList = ew_Concat($sFilterList, $this->tipo_cliente_dem->AdvancedSearch->ToJSON(), ","); // Field tipo_cliente_dem
		$sFilterList = ew_Concat($sFilterList, $this->fecha_llamada->AdvancedSearch->ToJSON(), ","); // Field fecha_llamada
		$sFilterList = ew_Concat($sFilterList, $this->cod_dem->AdvancedSearch->ToJSON(), ","); // Field cod_dem
		$sFilterList = ew_Concat($sFilterList, $this->poliza_dem->AdvancedSearch->ToJSON(), ","); // Field poliza_dem
		$sFilterList = ew_Concat($sFilterList, $this->usuario_captura->AdvancedSearch->ToJSON(), ","); // Field usuario_captura
		$sFilterList = ew_Concat($sFilterList, $this->campana_demanda->AdvancedSearch->ToJSON(), ","); // Field campana_demanda
		$sFilterList = ew_Concat($sFilterList, $this->chip_natural->AdvancedSearch->ToJSON(), ","); // Field chip_natural
		$sFilterList = ew_Concat($sFilterList, $this->estado_predio->AdvancedSearch->ToJSON(), ","); // Field estado_predio
		$sFilterList = ew_Concat($sFilterList, $this->tipo_predio->AdvancedSearch->ToJSON(), ","); // Field tipo_predio
		$sFilterList = ew_Concat($sFilterList, $this->uso->AdvancedSearch->ToJSON(), ","); // Field uso
		$sFilterList = ew_Concat($sFilterList, $this->mecado->AdvancedSearch->ToJSON(), ","); // Field mecado
		$sFilterList = ew_Concat($sFilterList, $this->nombre_cliente->AdvancedSearch->ToJSON(), ","); // Field nombre_cliente
		$sFilterList = ew_Concat($sFilterList, $this->num_doc->AdvancedSearch->ToJSON(), ","); // Field num_doc
		$sFilterList = ew_Concat($sFilterList, $this->direccion->AdvancedSearch->ToJSON(), ","); // Field direccion
		$sFilterList = ew_Concat($sFilterList, $this->municipio->AdvancedSearch->ToJSON(), ","); // Field municipio
		$sFilterList = ew_Concat($sFilterList, $this->telefono->AdvancedSearch->ToJSON(), ","); // Field telefono
		$sFilterList = ew_Concat($sFilterList, $this->cod_trabajo_original->AdvancedSearch->ToJSON(), ","); // Field cod_trabajo_original
		$sFilterList = ew_Concat($sFilterList, $this->fecha_trab_dem->AdvancedSearch->ToJSON(), ","); // Field fecha_trab_dem
		$sFilterList = ew_Concat($sFilterList, $this->cod_ult_visit->AdvancedSearch->ToJSON(), ","); // Field cod_ult_visit
		$sFilterList = ew_Concat($sFilterList, $this->res_ult_vis->AdvancedSearch->ToJSON(), ","); // Field res_ult_vis
		$sFilterList = ew_Concat($sFilterList, $this->fecha_ult_visita->AdvancedSearch->ToJSON(), ","); // Field fecha_ult_visita
		$sFilterList = ew_Concat($sFilterList, $this->usu_asig_primer_trab->AdvancedSearch->ToJSON(), ","); // Field usu_asig_primer_trab
		$sFilterList = ew_Concat($sFilterList, $this->fecha_prim_visit->AdvancedSearch->ToJSON(), ","); // Field fecha_prim_visit
		$sFilterList = ew_Concat($sFilterList, $this->respuesta_pv->AdvancedSearch->ToJSON(), ","); // Field respuesta_pv
		$sFilterList = ew_Concat($sFilterList, $this->fecha_cap_primera_visita->AdvancedSearch->ToJSON(), ","); // Field fecha_cap_primera_visita
		$sFilterList = ew_Concat($sFilterList, $this->cod_contratista->AdvancedSearch->ToJSON(), ","); // Field cod_contratista
		$sFilterList = ew_Concat($sFilterList, $this->nom_cont->AdvancedSearch->ToJSON(), ","); // Field nom_cont
		$sFilterList = ew_Concat($sFilterList, $this->distrito->AdvancedSearch->ToJSON(), ","); // Field distrito
		$sFilterList = ew_Concat($sFilterList, $this->malla->AdvancedSearch->ToJSON(), ","); // Field malla
		$sFilterList = ew_Concat($sFilterList, $this->sector->AdvancedSearch->ToJSON(), ","); // Field sector
		$sFilterList = ew_Concat($sFilterList, $this->descr_estado_dem->AdvancedSearch->ToJSON(), ","); // Field descr_estado_dem
		$sFilterList = ew_Concat($sFilterList, $this->estrato->AdvancedSearch->ToJSON(), ","); // Field estrato
		$sFilterList = ew_Concat($sFilterList, $this->clase_dem->AdvancedSearch->ToJSON(), ","); // Field clase_dem
		if ($this->BasicSearch->Keyword <> "") {
			$sWrk = "\"" . EW_TABLE_BASIC_SEARCH . "\":\"" . ew_JsEncode2($this->BasicSearch->Keyword) . "\",\"" . EW_TABLE_BASIC_SEARCH_TYPE . "\":\"" . ew_JsEncode2($this->BasicSearch->Type) . "\"";
			$sFilterList = ew_Concat($sFilterList, $sWrk, ",");
		}
		$sFilterList = preg_replace('/,$/', "", $sFilterList);

		// Return filter list in json
		if ($sFilterList <> "")
			$sFilterList = "\"data\":{" . $sFilterList . "}";
		if ($sSavedFilterList <> "") {
			if ($sFilterList <> "")
				$sFilterList .= ",";
			$sFilterList .= "\"filters\":" . $sSavedFilterList;
		}
		return ($sFilterList <> "") ? "{" . $sFilterList . "}" : "null";
	}

	// Process filter list
	function ProcessFilterList() {
		global $UserProfile;
		if (@$_POST["cmd"] == "savefilters") {
			$filters = ew_StripSlashes(@$_POST["filters"]);
			$UserProfile->SetSearchFilters(CurrentUserName(), "fdemandalistsrch", $filters);
		} elseif (@$_POST["cmd"] == "resetfilter") {
			$this->RestoreFilterList();
		}
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(ew_StripSlashes(@$_POST["filter"]), TRUE);
		$this->Command = "search";

		// Field origen_dem
		$this->origen_dem->AdvancedSearch->SearchValue = @$filter["x_origen_dem"];
		$this->origen_dem->AdvancedSearch->SearchOperator = @$filter["z_origen_dem"];
		$this->origen_dem->AdvancedSearch->SearchCondition = @$filter["v_origen_dem"];
		$this->origen_dem->AdvancedSearch->SearchValue2 = @$filter["y_origen_dem"];
		$this->origen_dem->AdvancedSearch->SearchOperator2 = @$filter["w_origen_dem"];
		$this->origen_dem->AdvancedSearch->Save();

		// Field tipo_cliente_dem
		$this->tipo_cliente_dem->AdvancedSearch->SearchValue = @$filter["x_tipo_cliente_dem"];
		$this->tipo_cliente_dem->AdvancedSearch->SearchOperator = @$filter["z_tipo_cliente_dem"];
		$this->tipo_cliente_dem->AdvancedSearch->SearchCondition = @$filter["v_tipo_cliente_dem"];
		$this->tipo_cliente_dem->AdvancedSearch->SearchValue2 = @$filter["y_tipo_cliente_dem"];
		$this->tipo_cliente_dem->AdvancedSearch->SearchOperator2 = @$filter["w_tipo_cliente_dem"];
		$this->tipo_cliente_dem->AdvancedSearch->Save();

		// Field fecha_llamada
		$this->fecha_llamada->AdvancedSearch->SearchValue = @$filter["x_fecha_llamada"];
		$this->fecha_llamada->AdvancedSearch->SearchOperator = @$filter["z_fecha_llamada"];
		$this->fecha_llamada->AdvancedSearch->SearchCondition = @$filter["v_fecha_llamada"];
		$this->fecha_llamada->AdvancedSearch->SearchValue2 = @$filter["y_fecha_llamada"];
		$this->fecha_llamada->AdvancedSearch->SearchOperator2 = @$filter["w_fecha_llamada"];
		$this->fecha_llamada->AdvancedSearch->Save();

		// Field cod_dem
		$this->cod_dem->AdvancedSearch->SearchValue = @$filter["x_cod_dem"];
		$this->cod_dem->AdvancedSearch->SearchOperator = @$filter["z_cod_dem"];
		$this->cod_dem->AdvancedSearch->SearchCondition = @$filter["v_cod_dem"];
		$this->cod_dem->AdvancedSearch->SearchValue2 = @$filter["y_cod_dem"];
		$this->cod_dem->AdvancedSearch->SearchOperator2 = @$filter["w_cod_dem"];
		$this->cod_dem->AdvancedSearch->Save();

		// Field poliza_dem
		$this->poliza_dem->AdvancedSearch->SearchValue = @$filter["x_poliza_dem"];
		$this->poliza_dem->AdvancedSearch->SearchOperator = @$filter["z_poliza_dem"];
		$this->poliza_dem->AdvancedSearch->SearchCondition = @$filter["v_poliza_dem"];
		$this->poliza_dem->AdvancedSearch->SearchValue2 = @$filter["y_poliza_dem"];
		$this->poliza_dem->AdvancedSearch->SearchOperator2 = @$filter["w_poliza_dem"];
		$this->poliza_dem->AdvancedSearch->Save();

		// Field usuario_captura
		$this->usuario_captura->AdvancedSearch->SearchValue = @$filter["x_usuario_captura"];
		$this->usuario_captura->AdvancedSearch->SearchOperator = @$filter["z_usuario_captura"];
		$this->usuario_captura->AdvancedSearch->SearchCondition = @$filter["v_usuario_captura"];
		$this->usuario_captura->AdvancedSearch->SearchValue2 = @$filter["y_usuario_captura"];
		$this->usuario_captura->AdvancedSearch->SearchOperator2 = @$filter["w_usuario_captura"];
		$this->usuario_captura->AdvancedSearch->Save();

		// Field campana_demanda
		$this->campana_demanda->AdvancedSearch->SearchValue = @$filter["x_campana_demanda"];
		$this->campana_demanda->AdvancedSearch->SearchOperator = @$filter["z_campana_demanda"];
		$this->campana_demanda->AdvancedSearch->SearchCondition = @$filter["v_campana_demanda"];
		$this->campana_demanda->AdvancedSearch->SearchValue2 = @$filter["y_campana_demanda"];
		$this->campana_demanda->AdvancedSearch->SearchOperator2 = @$filter["w_campana_demanda"];
		$this->campana_demanda->AdvancedSearch->Save();

		// Field chip_natural
		$this->chip_natural->AdvancedSearch->SearchValue = @$filter["x_chip_natural"];
		$this->chip_natural->AdvancedSearch->SearchOperator = @$filter["z_chip_natural"];
		$this->chip_natural->AdvancedSearch->SearchCondition = @$filter["v_chip_natural"];
		$this->chip_natural->AdvancedSearch->SearchValue2 = @$filter["y_chip_natural"];
		$this->chip_natural->AdvancedSearch->SearchOperator2 = @$filter["w_chip_natural"];
		$this->chip_natural->AdvancedSearch->Save();

		// Field estado_predio
		$this->estado_predio->AdvancedSearch->SearchValue = @$filter["x_estado_predio"];
		$this->estado_predio->AdvancedSearch->SearchOperator = @$filter["z_estado_predio"];
		$this->estado_predio->AdvancedSearch->SearchCondition = @$filter["v_estado_predio"];
		$this->estado_predio->AdvancedSearch->SearchValue2 = @$filter["y_estado_predio"];
		$this->estado_predio->AdvancedSearch->SearchOperator2 = @$filter["w_estado_predio"];
		$this->estado_predio->AdvancedSearch->Save();

		// Field tipo_predio
		$this->tipo_predio->AdvancedSearch->SearchValue = @$filter["x_tipo_predio"];
		$this->tipo_predio->AdvancedSearch->SearchOperator = @$filter["z_tipo_predio"];
		$this->tipo_predio->AdvancedSearch->SearchCondition = @$filter["v_tipo_predio"];
		$this->tipo_predio->AdvancedSearch->SearchValue2 = @$filter["y_tipo_predio"];
		$this->tipo_predio->AdvancedSearch->SearchOperator2 = @$filter["w_tipo_predio"];
		$this->tipo_predio->AdvancedSearch->Save();

		// Field uso
		$this->uso->AdvancedSearch->SearchValue = @$filter["x_uso"];
		$this->uso->AdvancedSearch->SearchOperator = @$filter["z_uso"];
		$this->uso->AdvancedSearch->SearchCondition = @$filter["v_uso"];
		$this->uso->AdvancedSearch->SearchValue2 = @$filter["y_uso"];
		$this->uso->AdvancedSearch->SearchOperator2 = @$filter["w_uso"];
		$this->uso->AdvancedSearch->Save();

		// Field mecado
		$this->mecado->AdvancedSearch->SearchValue = @$filter["x_mecado"];
		$this->mecado->AdvancedSearch->SearchOperator = @$filter["z_mecado"];
		$this->mecado->AdvancedSearch->SearchCondition = @$filter["v_mecado"];
		$this->mecado->AdvancedSearch->SearchValue2 = @$filter["y_mecado"];
		$this->mecado->AdvancedSearch->SearchOperator2 = @$filter["w_mecado"];
		$this->mecado->AdvancedSearch->Save();

		// Field nombre_cliente
		$this->nombre_cliente->AdvancedSearch->SearchValue = @$filter["x_nombre_cliente"];
		$this->nombre_cliente->AdvancedSearch->SearchOperator = @$filter["z_nombre_cliente"];
		$this->nombre_cliente->AdvancedSearch->SearchCondition = @$filter["v_nombre_cliente"];
		$this->nombre_cliente->AdvancedSearch->SearchValue2 = @$filter["y_nombre_cliente"];
		$this->nombre_cliente->AdvancedSearch->SearchOperator2 = @$filter["w_nombre_cliente"];
		$this->nombre_cliente->AdvancedSearch->Save();

		// Field num_doc
		$this->num_doc->AdvancedSearch->SearchValue = @$filter["x_num_doc"];
		$this->num_doc->AdvancedSearch->SearchOperator = @$filter["z_num_doc"];
		$this->num_doc->AdvancedSearch->SearchCondition = @$filter["v_num_doc"];
		$this->num_doc->AdvancedSearch->SearchValue2 = @$filter["y_num_doc"];
		$this->num_doc->AdvancedSearch->SearchOperator2 = @$filter["w_num_doc"];
		$this->num_doc->AdvancedSearch->Save();

		// Field direccion
		$this->direccion->AdvancedSearch->SearchValue = @$filter["x_direccion"];
		$this->direccion->AdvancedSearch->SearchOperator = @$filter["z_direccion"];
		$this->direccion->AdvancedSearch->SearchCondition = @$filter["v_direccion"];
		$this->direccion->AdvancedSearch->SearchValue2 = @$filter["y_direccion"];
		$this->direccion->AdvancedSearch->SearchOperator2 = @$filter["w_direccion"];
		$this->direccion->AdvancedSearch->Save();

		// Field municipio
		$this->municipio->AdvancedSearch->SearchValue = @$filter["x_municipio"];
		$this->municipio->AdvancedSearch->SearchOperator = @$filter["z_municipio"];
		$this->municipio->AdvancedSearch->SearchCondition = @$filter["v_municipio"];
		$this->municipio->AdvancedSearch->SearchValue2 = @$filter["y_municipio"];
		$this->municipio->AdvancedSearch->SearchOperator2 = @$filter["w_municipio"];
		$this->municipio->AdvancedSearch->Save();

		// Field telefono
		$this->telefono->AdvancedSearch->SearchValue = @$filter["x_telefono"];
		$this->telefono->AdvancedSearch->SearchOperator = @$filter["z_telefono"];
		$this->telefono->AdvancedSearch->SearchCondition = @$filter["v_telefono"];
		$this->telefono->AdvancedSearch->SearchValue2 = @$filter["y_telefono"];
		$this->telefono->AdvancedSearch->SearchOperator2 = @$filter["w_telefono"];
		$this->telefono->AdvancedSearch->Save();

		// Field cod_trabajo_original
		$this->cod_trabajo_original->AdvancedSearch->SearchValue = @$filter["x_cod_trabajo_original"];
		$this->cod_trabajo_original->AdvancedSearch->SearchOperator = @$filter["z_cod_trabajo_original"];
		$this->cod_trabajo_original->AdvancedSearch->SearchCondition = @$filter["v_cod_trabajo_original"];
		$this->cod_trabajo_original->AdvancedSearch->SearchValue2 = @$filter["y_cod_trabajo_original"];
		$this->cod_trabajo_original->AdvancedSearch->SearchOperator2 = @$filter["w_cod_trabajo_original"];
		$this->cod_trabajo_original->AdvancedSearch->Save();

		// Field fecha_trab_dem
		$this->fecha_trab_dem->AdvancedSearch->SearchValue = @$filter["x_fecha_trab_dem"];
		$this->fecha_trab_dem->AdvancedSearch->SearchOperator = @$filter["z_fecha_trab_dem"];
		$this->fecha_trab_dem->AdvancedSearch->SearchCondition = @$filter["v_fecha_trab_dem"];
		$this->fecha_trab_dem->AdvancedSearch->SearchValue2 = @$filter["y_fecha_trab_dem"];
		$this->fecha_trab_dem->AdvancedSearch->SearchOperator2 = @$filter["w_fecha_trab_dem"];
		$this->fecha_trab_dem->AdvancedSearch->Save();

		// Field cod_ult_visit
		$this->cod_ult_visit->AdvancedSearch->SearchValue = @$filter["x_cod_ult_visit"];
		$this->cod_ult_visit->AdvancedSearch->SearchOperator = @$filter["z_cod_ult_visit"];
		$this->cod_ult_visit->AdvancedSearch->SearchCondition = @$filter["v_cod_ult_visit"];
		$this->cod_ult_visit->AdvancedSearch->SearchValue2 = @$filter["y_cod_ult_visit"];
		$this->cod_ult_visit->AdvancedSearch->SearchOperator2 = @$filter["w_cod_ult_visit"];
		$this->cod_ult_visit->AdvancedSearch->Save();

		// Field res_ult_vis
		$this->res_ult_vis->AdvancedSearch->SearchValue = @$filter["x_res_ult_vis"];
		$this->res_ult_vis->AdvancedSearch->SearchOperator = @$filter["z_res_ult_vis"];
		$this->res_ult_vis->AdvancedSearch->SearchCondition = @$filter["v_res_ult_vis"];
		$this->res_ult_vis->AdvancedSearch->SearchValue2 = @$filter["y_res_ult_vis"];
		$this->res_ult_vis->AdvancedSearch->SearchOperator2 = @$filter["w_res_ult_vis"];
		$this->res_ult_vis->AdvancedSearch->Save();

		// Field fecha_ult_visita
		$this->fecha_ult_visita->AdvancedSearch->SearchValue = @$filter["x_fecha_ult_visita"];
		$this->fecha_ult_visita->AdvancedSearch->SearchOperator = @$filter["z_fecha_ult_visita"];
		$this->fecha_ult_visita->AdvancedSearch->SearchCondition = @$filter["v_fecha_ult_visita"];
		$this->fecha_ult_visita->AdvancedSearch->SearchValue2 = @$filter["y_fecha_ult_visita"];
		$this->fecha_ult_visita->AdvancedSearch->SearchOperator2 = @$filter["w_fecha_ult_visita"];
		$this->fecha_ult_visita->AdvancedSearch->Save();

		// Field usu_asig_primer_trab
		$this->usu_asig_primer_trab->AdvancedSearch->SearchValue = @$filter["x_usu_asig_primer_trab"];
		$this->usu_asig_primer_trab->AdvancedSearch->SearchOperator = @$filter["z_usu_asig_primer_trab"];
		$this->usu_asig_primer_trab->AdvancedSearch->SearchCondition = @$filter["v_usu_asig_primer_trab"];
		$this->usu_asig_primer_trab->AdvancedSearch->SearchValue2 = @$filter["y_usu_asig_primer_trab"];
		$this->usu_asig_primer_trab->AdvancedSearch->SearchOperator2 = @$filter["w_usu_asig_primer_trab"];
		$this->usu_asig_primer_trab->AdvancedSearch->Save();

		// Field fecha_prim_visit
		$this->fecha_prim_visit->AdvancedSearch->SearchValue = @$filter["x_fecha_prim_visit"];
		$this->fecha_prim_visit->AdvancedSearch->SearchOperator = @$filter["z_fecha_prim_visit"];
		$this->fecha_prim_visit->AdvancedSearch->SearchCondition = @$filter["v_fecha_prim_visit"];
		$this->fecha_prim_visit->AdvancedSearch->SearchValue2 = @$filter["y_fecha_prim_visit"];
		$this->fecha_prim_visit->AdvancedSearch->SearchOperator2 = @$filter["w_fecha_prim_visit"];
		$this->fecha_prim_visit->AdvancedSearch->Save();

		// Field respuesta_pv
		$this->respuesta_pv->AdvancedSearch->SearchValue = @$filter["x_respuesta_pv"];
		$this->respuesta_pv->AdvancedSearch->SearchOperator = @$filter["z_respuesta_pv"];
		$this->respuesta_pv->AdvancedSearch->SearchCondition = @$filter["v_respuesta_pv"];
		$this->respuesta_pv->AdvancedSearch->SearchValue2 = @$filter["y_respuesta_pv"];
		$this->respuesta_pv->AdvancedSearch->SearchOperator2 = @$filter["w_respuesta_pv"];
		$this->respuesta_pv->AdvancedSearch->Save();

		// Field fecha_cap_primera_visita
		$this->fecha_cap_primera_visita->AdvancedSearch->SearchValue = @$filter["x_fecha_cap_primera_visita"];
		$this->fecha_cap_primera_visita->AdvancedSearch->SearchOperator = @$filter["z_fecha_cap_primera_visita"];
		$this->fecha_cap_primera_visita->AdvancedSearch->SearchCondition = @$filter["v_fecha_cap_primera_visita"];
		$this->fecha_cap_primera_visita->AdvancedSearch->SearchValue2 = @$filter["y_fecha_cap_primera_visita"];
		$this->fecha_cap_primera_visita->AdvancedSearch->SearchOperator2 = @$filter["w_fecha_cap_primera_visita"];
		$this->fecha_cap_primera_visita->AdvancedSearch->Save();

		// Field cod_contratista
		$this->cod_contratista->AdvancedSearch->SearchValue = @$filter["x_cod_contratista"];
		$this->cod_contratista->AdvancedSearch->SearchOperator = @$filter["z_cod_contratista"];
		$this->cod_contratista->AdvancedSearch->SearchCondition = @$filter["v_cod_contratista"];
		$this->cod_contratista->AdvancedSearch->SearchValue2 = @$filter["y_cod_contratista"];
		$this->cod_contratista->AdvancedSearch->SearchOperator2 = @$filter["w_cod_contratista"];
		$this->cod_contratista->AdvancedSearch->Save();

		// Field nom_cont
		$this->nom_cont->AdvancedSearch->SearchValue = @$filter["x_nom_cont"];
		$this->nom_cont->AdvancedSearch->SearchOperator = @$filter["z_nom_cont"];
		$this->nom_cont->AdvancedSearch->SearchCondition = @$filter["v_nom_cont"];
		$this->nom_cont->AdvancedSearch->SearchValue2 = @$filter["y_nom_cont"];
		$this->nom_cont->AdvancedSearch->SearchOperator2 = @$filter["w_nom_cont"];
		$this->nom_cont->AdvancedSearch->Save();

		// Field distrito
		$this->distrito->AdvancedSearch->SearchValue = @$filter["x_distrito"];
		$this->distrito->AdvancedSearch->SearchOperator = @$filter["z_distrito"];
		$this->distrito->AdvancedSearch->SearchCondition = @$filter["v_distrito"];
		$this->distrito->AdvancedSearch->SearchValue2 = @$filter["y_distrito"];
		$this->distrito->AdvancedSearch->SearchOperator2 = @$filter["w_distrito"];
		$this->distrito->AdvancedSearch->Save();

		// Field malla
		$this->malla->AdvancedSearch->SearchValue = @$filter["x_malla"];
		$this->malla->AdvancedSearch->SearchOperator = @$filter["z_malla"];
		$this->malla->AdvancedSearch->SearchCondition = @$filter["v_malla"];
		$this->malla->AdvancedSearch->SearchValue2 = @$filter["y_malla"];
		$this->malla->AdvancedSearch->SearchOperator2 = @$filter["w_malla"];
		$this->malla->AdvancedSearch->Save();

		// Field sector
		$this->sector->AdvancedSearch->SearchValue = @$filter["x_sector"];
		$this->sector->AdvancedSearch->SearchOperator = @$filter["z_sector"];
		$this->sector->AdvancedSearch->SearchCondition = @$filter["v_sector"];
		$this->sector->AdvancedSearch->SearchValue2 = @$filter["y_sector"];
		$this->sector->AdvancedSearch->SearchOperator2 = @$filter["w_sector"];
		$this->sector->AdvancedSearch->Save();

		// Field descr_estado_dem
		$this->descr_estado_dem->AdvancedSearch->SearchValue = @$filter["x_descr_estado_dem"];
		$this->descr_estado_dem->AdvancedSearch->SearchOperator = @$filter["z_descr_estado_dem"];
		$this->descr_estado_dem->AdvancedSearch->SearchCondition = @$filter["v_descr_estado_dem"];
		$this->descr_estado_dem->AdvancedSearch->SearchValue2 = @$filter["y_descr_estado_dem"];
		$this->descr_estado_dem->AdvancedSearch->SearchOperator2 = @$filter["w_descr_estado_dem"];
		$this->descr_estado_dem->AdvancedSearch->Save();

		// Field estrato
		$this->estrato->AdvancedSearch->SearchValue = @$filter["x_estrato"];
		$this->estrato->AdvancedSearch->SearchOperator = @$filter["z_estrato"];
		$this->estrato->AdvancedSearch->SearchCondition = @$filter["v_estrato"];
		$this->estrato->AdvancedSearch->SearchValue2 = @$filter["y_estrato"];
		$this->estrato->AdvancedSearch->SearchOperator2 = @$filter["w_estrato"];
		$this->estrato->AdvancedSearch->Save();

		// Field clase_dem
		$this->clase_dem->AdvancedSearch->SearchValue = @$filter["x_clase_dem"];
		$this->clase_dem->AdvancedSearch->SearchOperator = @$filter["z_clase_dem"];
		$this->clase_dem->AdvancedSearch->SearchCondition = @$filter["v_clase_dem"];
		$this->clase_dem->AdvancedSearch->SearchValue2 = @$filter["y_clase_dem"];
		$this->clase_dem->AdvancedSearch->SearchOperator2 = @$filter["w_clase_dem"];
		$this->clase_dem->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->origen_dem, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->tipo_cliente_dem, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->usuario_captura, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->campana_demanda, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->chip_natural, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->estado_predio, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->tipo_predio, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->uso, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->mecado, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nombre_cliente, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->num_doc, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->direccion, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->municipio, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->telefono, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->res_ult_vis, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->usu_asig_primer_trab, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->respuesta_pv, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->cod_contratista, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nom_cont, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->descr_estado_dem, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->clase_dem, $arKeywords, $type);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSql(&$Where, &$Fld, $arKeywords, $type) {
		$sDefCond = ($type == "OR") ? "OR" : "AND";
		$arSQL = array(); // Array for SQL parts
		$arCond = array(); // Array for search conditions
		$cnt = count($arKeywords);
		$j = 0; // Number of SQL parts
		for ($i = 0; $i < $cnt; $i++) {
			$Keyword = $arKeywords[$i];
			$Keyword = trim($Keyword);
			if (EW_BASIC_SEARCH_IGNORE_PATTERN <> "") {
				$Keyword = preg_replace(EW_BASIC_SEARCH_IGNORE_PATTERN, "\\", $Keyword);
				$ar = explode("\\", $Keyword);
			} else {
				$ar = array($Keyword);
			}
			foreach ($ar as $Keyword) {
				if ($Keyword <> "") {
					$sWrk = "";
					if ($Keyword == "OR" && $type == "") {
						if ($j > 0)
							$arCond[$j-1] = "OR";
					} elseif ($Keyword == EW_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NULL";
					} elseif ($Keyword == EW_NOT_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NOT NULL";
					} elseif ($Fld->FldIsVirtual && $Fld->FldVirtualSearch) {
						$sWrk = $Fld->FldVirtualExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					} elseif ($Fld->FldDataType != EW_DATATYPE_NUMBER || is_numeric($Keyword)) {
						$sWrk = $Fld->FldBasicSearchExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					}
					if ($sWrk <> "") {
						$arSQL[$j] = $sWrk;
						$arCond[$j] = $sDefCond;
						$j += 1;
					}
				}
			}
		}
		$cnt = count($arSQL);
		$bQuoted = FALSE;
		$sSql = "";
		if ($cnt > 0) {
			for ($i = 0; $i < $cnt-1; $i++) {
				if ($arCond[$i] == "OR") {
					if (!$bQuoted) $sSql .= "(";
					$bQuoted = TRUE;
				}
				$sSql .= $arSQL[$i];
				if ($bQuoted && $arCond[$i] <> "OR") {
					$sSql .= ")";
					$bQuoted = FALSE;
				}
				$sSql .= " " . $arCond[$i] . " ";
			}
			$sSql .= $arSQL[$cnt-1];
			if ($bQuoted)
				$sSql .= ")";
		}
		if ($sSql <> "") {
			if ($Where <> "") $Where .= " OR ";
			$Where .=  "(" . $sSql . ")";
		}
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere($Default = FALSE) {
		global $Security;
		$sSearchStr = "";
		if (!$Security->CanSearch()) return "";
		$sSearchKeyword = ($Default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
		$sSearchType = ($Default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;
		if ($sSearchKeyword <> "") {
			$sSearch = trim($sSearchKeyword);
			if ($sSearchType <> "=") {
				$ar = array();

				// Match quoted keywords (i.e.: "...")
				if (preg_match_all('/"([^"]*)"/i', $sSearch, $matches, PREG_SET_ORDER)) {
					foreach ($matches as $match) {
						$p = strpos($sSearch, $match[0]);
						$str = substr($sSearch, 0, $p);
						$sSearch = substr($sSearch, $p + strlen($match[0]));
						if (strlen(trim($str)) > 0)
							$ar = array_merge($ar, explode(" ", trim($str)));
						$ar[] = $match[1]; // Save quoted keyword
					}
				}

				// Match individual keywords
				if (strlen(trim($sSearch)) > 0)
					$ar = array_merge($ar, explode(" ", trim($sSearch)));

				// Search keyword in any fields
				if (($sSearchType == "OR" || $sSearchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
					foreach ($ar as $sKeyword) {
						if ($sKeyword <> "") {
							if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
							$sSearchStr .= "(" . $this->BasicSearchSQL(array($sKeyword), $sSearchType) . ")";
						}
					}
				} else {
					$sSearchStr = $this->BasicSearchSQL($ar, $sSearchType);
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL(array($sSearch), $sSearchType);
			}
			if (!$Default) $this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->origen_dem); // origen_dem
			$this->UpdateSort($this->tipo_cliente_dem); // tipo_cliente_dem
			$this->UpdateSort($this->fecha_llamada); // fecha_llamada
			$this->UpdateSort($this->cod_dem); // cod_dem
			$this->UpdateSort($this->poliza_dem); // poliza_dem
			$this->UpdateSort($this->usuario_captura); // usuario_captura
			$this->UpdateSort($this->campana_demanda); // campana_demanda
			$this->UpdateSort($this->chip_natural); // chip_natural
			$this->UpdateSort($this->estado_predio); // estado_predio
			$this->UpdateSort($this->tipo_predio); // tipo_predio
			$this->UpdateSort($this->uso); // uso
			$this->UpdateSort($this->mecado); // mecado
			$this->UpdateSort($this->nombre_cliente); // nombre_cliente
			$this->UpdateSort($this->num_doc); // num_doc
			$this->UpdateSort($this->direccion); // direccion
			$this->UpdateSort($this->municipio); // municipio
			$this->UpdateSort($this->telefono); // telefono
			$this->UpdateSort($this->cod_trabajo_original); // cod_trabajo_original
			$this->UpdateSort($this->fecha_trab_dem); // fecha_trab_dem
			$this->UpdateSort($this->cod_ult_visit); // cod_ult_visit
			$this->UpdateSort($this->res_ult_vis); // res_ult_vis
			$this->UpdateSort($this->fecha_ult_visita); // fecha_ult_visita
			$this->UpdateSort($this->usu_asig_primer_trab); // usu_asig_primer_trab
			$this->UpdateSort($this->fecha_prim_visit); // fecha_prim_visit
			$this->UpdateSort($this->respuesta_pv); // respuesta_pv
			$this->UpdateSort($this->fecha_cap_primera_visita); // fecha_cap_primera_visita
			$this->UpdateSort($this->cod_contratista); // cod_contratista
			$this->UpdateSort($this->nom_cont); // nom_cont
			$this->UpdateSort($this->distrito); // distrito
			$this->UpdateSort($this->malla); // malla
			$this->UpdateSort($this->sector); // sector
			$this->UpdateSort($this->descr_estado_dem); // descr_estado_dem
			$this->UpdateSort($this->estrato); // estrato
			$this->UpdateSort($this->clase_dem); // clase_dem
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->origen_dem->setSort("");
				$this->tipo_cliente_dem->setSort("");
				$this->fecha_llamada->setSort("");
				$this->cod_dem->setSort("");
				$this->poliza_dem->setSort("");
				$this->usuario_captura->setSort("");
				$this->campana_demanda->setSort("");
				$this->chip_natural->setSort("");
				$this->estado_predio->setSort("");
				$this->tipo_predio->setSort("");
				$this->uso->setSort("");
				$this->mecado->setSort("");
				$this->nombre_cliente->setSort("");
				$this->num_doc->setSort("");
				$this->direccion->setSort("");
				$this->municipio->setSort("");
				$this->telefono->setSort("");
				$this->cod_trabajo_original->setSort("");
				$this->fecha_trab_dem->setSort("");
				$this->cod_ult_visit->setSort("");
				$this->res_ult_vis->setSort("");
				$this->fecha_ult_visita->setSort("");
				$this->usu_asig_primer_trab->setSort("");
				$this->fecha_prim_visit->setSort("");
				$this->respuesta_pv->setSort("");
				$this->fecha_cap_primera_visita->setSort("");
				$this->cod_contratista->setSort("");
				$this->nom_cont->setSort("");
				$this->distrito->setSort("");
				$this->malla->setSort("");
				$this->sector->setSort("");
				$this->descr_estado_dem->setSort("");
				$this->estrato->setSort("");
				$this->clase_dem->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssStyle = "white-space: nowrap;";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = FALSE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = TRUE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt && $this->Export == "" && $this->CurrentAction == "") {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default btn-sm ewActions\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = FALSE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fdemandalistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fdemandalistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fdemandalist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			$this->CurrentAction = ""; // Clear action
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Search button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = ($this->SearchWhere <> "") ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fdemandalistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
		global $Security;
		if (!$Security->CanSearch()) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}
	}

	function SetupListOptionsExt() {
		global $Security, $Language;
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
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
		$this->origen_dem->setDbValue($rs->fields('origen_dem'));
		$this->tipo_cliente_dem->setDbValue($rs->fields('tipo_cliente_dem'));
		$this->fecha_llamada->setDbValue($rs->fields('fecha_llamada'));
		$this->cod_dem->setDbValue($rs->fields('cod_dem'));
		$this->poliza_dem->setDbValue($rs->fields('poliza_dem'));
		$this->usuario_captura->setDbValue($rs->fields('usuario_captura'));
		$this->campana_demanda->setDbValue($rs->fields('campana_demanda'));
		$this->chip_natural->setDbValue($rs->fields('chip_natural'));
		$this->estado_predio->setDbValue($rs->fields('estado_predio'));
		$this->tipo_predio->setDbValue($rs->fields('tipo_predio'));
		$this->uso->setDbValue($rs->fields('uso'));
		$this->mecado->setDbValue($rs->fields('mecado'));
		$this->nombre_cliente->setDbValue($rs->fields('nombre_cliente'));
		$this->num_doc->setDbValue($rs->fields('num_doc'));
		$this->direccion->setDbValue($rs->fields('direccion'));
		$this->municipio->setDbValue($rs->fields('municipio'));
		$this->telefono->setDbValue($rs->fields('telefono'));
		$this->cod_trabajo_original->setDbValue($rs->fields('cod_trabajo_original'));
		$this->fecha_trab_dem->setDbValue($rs->fields('fecha_trab_dem'));
		$this->cod_ult_visit->setDbValue($rs->fields('cod_ult_visit'));
		$this->res_ult_vis->setDbValue($rs->fields('res_ult_vis'));
		$this->fecha_ult_visita->setDbValue($rs->fields('fecha_ult_visita'));
		$this->usu_asig_primer_trab->setDbValue($rs->fields('usu_asig_primer_trab'));
		$this->fecha_prim_visit->setDbValue($rs->fields('fecha_prim_visit'));
		$this->respuesta_pv->setDbValue($rs->fields('respuesta_pv'));
		$this->fecha_cap_primera_visita->setDbValue($rs->fields('fecha_cap_primera_visita'));
		$this->cod_contratista->setDbValue($rs->fields('cod_contratista'));
		$this->nom_cont->setDbValue($rs->fields('nom_cont'));
		$this->distrito->setDbValue($rs->fields('distrito'));
		$this->malla->setDbValue($rs->fields('malla'));
		$this->sector->setDbValue($rs->fields('sector'));
		$this->descr_estado_dem->setDbValue($rs->fields('descr_estado_dem'));
		$this->estrato->setDbValue($rs->fields('estrato'));
		$this->clase_dem->setDbValue($rs->fields('clase_dem'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->origen_dem->DbValue = $row['origen_dem'];
		$this->tipo_cliente_dem->DbValue = $row['tipo_cliente_dem'];
		$this->fecha_llamada->DbValue = $row['fecha_llamada'];
		$this->cod_dem->DbValue = $row['cod_dem'];
		$this->poliza_dem->DbValue = $row['poliza_dem'];
		$this->usuario_captura->DbValue = $row['usuario_captura'];
		$this->campana_demanda->DbValue = $row['campana_demanda'];
		$this->chip_natural->DbValue = $row['chip_natural'];
		$this->estado_predio->DbValue = $row['estado_predio'];
		$this->tipo_predio->DbValue = $row['tipo_predio'];
		$this->uso->DbValue = $row['uso'];
		$this->mecado->DbValue = $row['mecado'];
		$this->nombre_cliente->DbValue = $row['nombre_cliente'];
		$this->num_doc->DbValue = $row['num_doc'];
		$this->direccion->DbValue = $row['direccion'];
		$this->municipio->DbValue = $row['municipio'];
		$this->telefono->DbValue = $row['telefono'];
		$this->cod_trabajo_original->DbValue = $row['cod_trabajo_original'];
		$this->fecha_trab_dem->DbValue = $row['fecha_trab_dem'];
		$this->cod_ult_visit->DbValue = $row['cod_ult_visit'];
		$this->res_ult_vis->DbValue = $row['res_ult_vis'];
		$this->fecha_ult_visita->DbValue = $row['fecha_ult_visita'];
		$this->usu_asig_primer_trab->DbValue = $row['usu_asig_primer_trab'];
		$this->fecha_prim_visit->DbValue = $row['fecha_prim_visit'];
		$this->respuesta_pv->DbValue = $row['respuesta_pv'];
		$this->fecha_cap_primera_visita->DbValue = $row['fecha_cap_primera_visita'];
		$this->cod_contratista->DbValue = $row['cod_contratista'];
		$this->nom_cont->DbValue = $row['nom_cont'];
		$this->distrito->DbValue = $row['distrito'];
		$this->malla->DbValue = $row['malla'];
		$this->sector->DbValue = $row['sector'];
		$this->descr_estado_dem->DbValue = $row['descr_estado_dem'];
		$this->estrato->DbValue = $row['estrato'];
		$this->clase_dem->DbValue = $row['clase_dem'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;

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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// origen_dem
		// tipo_cliente_dem
		// fecha_llamada
		// cod_dem
		// poliza_dem
		// usuario_captura
		// campana_demanda
		// chip_natural
		// estado_predio
		// tipo_predio
		// uso
		// mecado
		// nombre_cliente
		// num_doc
		// direccion
		// municipio
		// telefono
		// cod_trabajo_original
		// fecha_trab_dem
		// cod_ult_visit
		// res_ult_vis
		// fecha_ult_visita
		// usu_asig_primer_trab
		// fecha_prim_visit
		// respuesta_pv
		// fecha_cap_primera_visita
		// cod_contratista
		// nom_cont
		// distrito
		// malla
		// sector
		// descr_estado_dem
		// estrato
		// clase_dem

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// origen_dem
		$this->origen_dem->ViewValue = $this->origen_dem->CurrentValue;
		$this->origen_dem->ViewCustomAttributes = "";

		// tipo_cliente_dem
		$this->tipo_cliente_dem->ViewValue = $this->tipo_cliente_dem->CurrentValue;
		$this->tipo_cliente_dem->ViewCustomAttributes = "";

		// fecha_llamada
		$this->fecha_llamada->ViewValue = $this->fecha_llamada->CurrentValue;
		$this->fecha_llamada->ViewValue = ew_FormatDateTime($this->fecha_llamada->ViewValue, 0);
		$this->fecha_llamada->ViewCustomAttributes = "";

		// cod_dem
		$this->cod_dem->ViewValue = $this->cod_dem->CurrentValue;
		$this->cod_dem->ViewCustomAttributes = "";

		// poliza_dem
		$this->poliza_dem->ViewValue = $this->poliza_dem->CurrentValue;
		$this->poliza_dem->ViewCustomAttributes = "";

		// usuario_captura
		$this->usuario_captura->ViewValue = $this->usuario_captura->CurrentValue;
		$this->usuario_captura->ViewCustomAttributes = "";

		// campana_demanda
		$this->campana_demanda->ViewValue = $this->campana_demanda->CurrentValue;
		$this->campana_demanda->ViewCustomAttributes = "";

		// chip_natural
		$this->chip_natural->ViewValue = $this->chip_natural->CurrentValue;
		$this->chip_natural->ViewCustomAttributes = "";

		// estado_predio
		$this->estado_predio->ViewValue = $this->estado_predio->CurrentValue;
		$this->estado_predio->ViewCustomAttributes = "";

		// tipo_predio
		$this->tipo_predio->ViewValue = $this->tipo_predio->CurrentValue;
		$this->tipo_predio->ViewCustomAttributes = "";

		// uso
		$this->uso->ViewValue = $this->uso->CurrentValue;
		$this->uso->ViewCustomAttributes = "";

		// mecado
		$this->mecado->ViewValue = $this->mecado->CurrentValue;
		$this->mecado->ViewCustomAttributes = "";

		// nombre_cliente
		$this->nombre_cliente->ViewValue = $this->nombre_cliente->CurrentValue;
		$this->nombre_cliente->ViewCustomAttributes = "";

		// num_doc
		$this->num_doc->ViewValue = $this->num_doc->CurrentValue;
		$this->num_doc->ViewCustomAttributes = "";

		// direccion
		$this->direccion->ViewValue = $this->direccion->CurrentValue;
		$this->direccion->ViewCustomAttributes = "";

		// municipio
		$this->municipio->ViewValue = $this->municipio->CurrentValue;
		$this->municipio->ViewCustomAttributes = "";

		// telefono
		$this->telefono->ViewValue = $this->telefono->CurrentValue;
		$this->telefono->ViewCustomAttributes = "";

		// cod_trabajo_original
		$this->cod_trabajo_original->ViewValue = $this->cod_trabajo_original->CurrentValue;
		$this->cod_trabajo_original->ViewCustomAttributes = "";

		// fecha_trab_dem
		$this->fecha_trab_dem->ViewValue = $this->fecha_trab_dem->CurrentValue;
		$this->fecha_trab_dem->ViewValue = ew_FormatDateTime($this->fecha_trab_dem->ViewValue, 0);
		$this->fecha_trab_dem->ViewCustomAttributes = "";

		// cod_ult_visit
		$this->cod_ult_visit->ViewValue = $this->cod_ult_visit->CurrentValue;
		$this->cod_ult_visit->ViewCustomAttributes = "";

		// res_ult_vis
		$this->res_ult_vis->ViewValue = $this->res_ult_vis->CurrentValue;
		$this->res_ult_vis->ViewCustomAttributes = "";

		// fecha_ult_visita
		$this->fecha_ult_visita->ViewValue = $this->fecha_ult_visita->CurrentValue;
		$this->fecha_ult_visita->ViewValue = ew_FormatDateTime($this->fecha_ult_visita->ViewValue, 0);
		$this->fecha_ult_visita->ViewCustomAttributes = "";

		// usu_asig_primer_trab
		$this->usu_asig_primer_trab->ViewValue = $this->usu_asig_primer_trab->CurrentValue;
		$this->usu_asig_primer_trab->ViewCustomAttributes = "";

		// fecha_prim_visit
		$this->fecha_prim_visit->ViewValue = $this->fecha_prim_visit->CurrentValue;
		$this->fecha_prim_visit->ViewValue = ew_FormatDateTime($this->fecha_prim_visit->ViewValue, 0);
		$this->fecha_prim_visit->ViewCustomAttributes = "";

		// respuesta_pv
		$this->respuesta_pv->ViewValue = $this->respuesta_pv->CurrentValue;
		$this->respuesta_pv->ViewCustomAttributes = "";

		// fecha_cap_primera_visita
		$this->fecha_cap_primera_visita->ViewValue = $this->fecha_cap_primera_visita->CurrentValue;
		$this->fecha_cap_primera_visita->ViewValue = ew_FormatDateTime($this->fecha_cap_primera_visita->ViewValue, 0);
		$this->fecha_cap_primera_visita->ViewCustomAttributes = "";

		// cod_contratista
		$this->cod_contratista->ViewValue = $this->cod_contratista->CurrentValue;
		$this->cod_contratista->ViewCustomAttributes = "";

		// nom_cont
		$this->nom_cont->ViewValue = $this->nom_cont->CurrentValue;
		$this->nom_cont->ViewCustomAttributes = "";

		// distrito
		$this->distrito->ViewValue = $this->distrito->CurrentValue;
		$this->distrito->ViewCustomAttributes = "";

		// malla
		$this->malla->ViewValue = $this->malla->CurrentValue;
		$this->malla->ViewCustomAttributes = "";

		// sector
		$this->sector->ViewValue = $this->sector->CurrentValue;
		$this->sector->ViewCustomAttributes = "";

		// descr_estado_dem
		$this->descr_estado_dem->ViewValue = $this->descr_estado_dem->CurrentValue;
		$this->descr_estado_dem->ViewCustomAttributes = "";

		// estrato
		$this->estrato->ViewValue = $this->estrato->CurrentValue;
		$this->estrato->ViewCustomAttributes = "";

		// clase_dem
		$this->clase_dem->ViewValue = $this->clase_dem->CurrentValue;
		$this->clase_dem->ViewCustomAttributes = "";

			// origen_dem
			$this->origen_dem->LinkCustomAttributes = "";
			$this->origen_dem->HrefValue = "";
			$this->origen_dem->TooltipValue = "";

			// tipo_cliente_dem
			$this->tipo_cliente_dem->LinkCustomAttributes = "";
			$this->tipo_cliente_dem->HrefValue = "";
			$this->tipo_cliente_dem->TooltipValue = "";

			// fecha_llamada
			$this->fecha_llamada->LinkCustomAttributes = "";
			$this->fecha_llamada->HrefValue = "";
			$this->fecha_llamada->TooltipValue = "";

			// cod_dem
			$this->cod_dem->LinkCustomAttributes = "";
			$this->cod_dem->HrefValue = "";
			$this->cod_dem->TooltipValue = "";

			// poliza_dem
			$this->poliza_dem->LinkCustomAttributes = "";
			$this->poliza_dem->HrefValue = "";
			$this->poliza_dem->TooltipValue = "";

			// usuario_captura
			$this->usuario_captura->LinkCustomAttributes = "";
			$this->usuario_captura->HrefValue = "";
			$this->usuario_captura->TooltipValue = "";

			// campana_demanda
			$this->campana_demanda->LinkCustomAttributes = "";
			$this->campana_demanda->HrefValue = "";
			$this->campana_demanda->TooltipValue = "";

			// chip_natural
			$this->chip_natural->LinkCustomAttributes = "";
			$this->chip_natural->HrefValue = "";
			$this->chip_natural->TooltipValue = "";

			// estado_predio
			$this->estado_predio->LinkCustomAttributes = "";
			$this->estado_predio->HrefValue = "";
			$this->estado_predio->TooltipValue = "";

			// tipo_predio
			$this->tipo_predio->LinkCustomAttributes = "";
			$this->tipo_predio->HrefValue = "";
			$this->tipo_predio->TooltipValue = "";

			// uso
			$this->uso->LinkCustomAttributes = "";
			$this->uso->HrefValue = "";
			$this->uso->TooltipValue = "";

			// mecado
			$this->mecado->LinkCustomAttributes = "";
			$this->mecado->HrefValue = "";
			$this->mecado->TooltipValue = "";

			// nombre_cliente
			$this->nombre_cliente->LinkCustomAttributes = "";
			$this->nombre_cliente->HrefValue = "";
			$this->nombre_cliente->TooltipValue = "";

			// num_doc
			$this->num_doc->LinkCustomAttributes = "";
			$this->num_doc->HrefValue = "";
			$this->num_doc->TooltipValue = "";

			// direccion
			$this->direccion->LinkCustomAttributes = "";
			$this->direccion->HrefValue = "";
			$this->direccion->TooltipValue = "";

			// municipio
			$this->municipio->LinkCustomAttributes = "";
			$this->municipio->HrefValue = "";
			$this->municipio->TooltipValue = "";

			// telefono
			$this->telefono->LinkCustomAttributes = "";
			$this->telefono->HrefValue = "";
			$this->telefono->TooltipValue = "";

			// cod_trabajo_original
			$this->cod_trabajo_original->LinkCustomAttributes = "";
			$this->cod_trabajo_original->HrefValue = "";
			$this->cod_trabajo_original->TooltipValue = "";

			// fecha_trab_dem
			$this->fecha_trab_dem->LinkCustomAttributes = "";
			$this->fecha_trab_dem->HrefValue = "";
			$this->fecha_trab_dem->TooltipValue = "";

			// cod_ult_visit
			$this->cod_ult_visit->LinkCustomAttributes = "";
			$this->cod_ult_visit->HrefValue = "";
			$this->cod_ult_visit->TooltipValue = "";

			// res_ult_vis
			$this->res_ult_vis->LinkCustomAttributes = "";
			$this->res_ult_vis->HrefValue = "";
			$this->res_ult_vis->TooltipValue = "";

			// fecha_ult_visita
			$this->fecha_ult_visita->LinkCustomAttributes = "";
			$this->fecha_ult_visita->HrefValue = "";
			$this->fecha_ult_visita->TooltipValue = "";

			// usu_asig_primer_trab
			$this->usu_asig_primer_trab->LinkCustomAttributes = "";
			$this->usu_asig_primer_trab->HrefValue = "";
			$this->usu_asig_primer_trab->TooltipValue = "";

			// fecha_prim_visit
			$this->fecha_prim_visit->LinkCustomAttributes = "";
			$this->fecha_prim_visit->HrefValue = "";
			$this->fecha_prim_visit->TooltipValue = "";

			// respuesta_pv
			$this->respuesta_pv->LinkCustomAttributes = "";
			$this->respuesta_pv->HrefValue = "";
			$this->respuesta_pv->TooltipValue = "";

			// fecha_cap_primera_visita
			$this->fecha_cap_primera_visita->LinkCustomAttributes = "";
			$this->fecha_cap_primera_visita->HrefValue = "";
			$this->fecha_cap_primera_visita->TooltipValue = "";

			// cod_contratista
			$this->cod_contratista->LinkCustomAttributes = "";
			$this->cod_contratista->HrefValue = "";
			$this->cod_contratista->TooltipValue = "";

			// nom_cont
			$this->nom_cont->LinkCustomAttributes = "";
			$this->nom_cont->HrefValue = "";
			$this->nom_cont->TooltipValue = "";

			// distrito
			$this->distrito->LinkCustomAttributes = "";
			$this->distrito->HrefValue = "";
			$this->distrito->TooltipValue = "";

			// malla
			$this->malla->LinkCustomAttributes = "";
			$this->malla->HrefValue = "";
			$this->malla->TooltipValue = "";

			// sector
			$this->sector->LinkCustomAttributes = "";
			$this->sector->HrefValue = "";
			$this->sector->TooltipValue = "";

			// descr_estado_dem
			$this->descr_estado_dem->LinkCustomAttributes = "";
			$this->descr_estado_dem->HrefValue = "";
			$this->descr_estado_dem->TooltipValue = "";

			// estrato
			$this->estrato->LinkCustomAttributes = "";
			$this->estrato->HrefValue = "";
			$this->estrato->TooltipValue = "";

			// clase_dem
			$this->clase_dem->LinkCustomAttributes = "";
			$this->clase_dem->HrefValue = "";
			$this->clase_dem->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language;

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = FALSE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = FALSE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a href=\"" . $this->ExportWordUrl . "\" class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = FALSE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a href=\"" . $this->ExportHtmlUrl . "\" class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = FALSE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a href=\"" . $this->ExportXmlUrl . "\" class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = FALSE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a href=\"" . $this->ExportCsvUrl . "\" class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = FALSE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a href=\"" . $this->ExportPdfUrl . "\" class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = TRUE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_demanda\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_demanda',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fdemandalist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
		$item->Visible = FALSE;

		// Drop down button for export
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = TRUE;
		$this->ExportOptions->UseDropDownButton = FALSE;
		if ($this->ExportOptions->UseButtonGroup && ew_IsMobile())
			$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->DropDownButtonPhrase = $Language->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = $this->UseSelectLimit;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $this->SelectRecordCount();
		} else {
			if (!$this->Recordset)
				$this->Recordset = $this->LoadRecordset();
			$rs = &$this->Recordset;
			if ($rs)
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;

		// Export all
		if ($this->ExportAll) {
			set_time_limit(EW_EXPORT_ALL_TIME_LIMIT);
			$this->DisplayRecs = $this->TotalRecs;
			$this->StopRec = $this->TotalRecs;
		} else { // Export one page only
			$this->SetUpStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->DisplayRecs <= 0) {
				$this->StopRec = $this->TotalRecs;
			} else {
				$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
			}
		}
		if ($bSelectLimit)
			$rs = $this->LoadRecordset($this->StartRec-1, $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs);
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$this->ExportDoc = ew_ExportDocument($this, "h");
		$Doc = &$this->ExportDoc;
		if ($bSelectLimit) {
			$this->StartRec = 1;
			$this->StopRec = $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs;
		} else {

			//$this->StartRec = $this->StartRec;
			//$this->StopRec = $this->StopRec;

		}

		// Call Page Exporting server event
		$this->ExportDoc->ExportCustom = !$this->Page_Exporting();
		$ParentTable = "";
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		$Doc->Text .= $sHeader;
		$this->ExportDocument($Doc, $rs, $this->StartRec, $this->StopRec, "");
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		$Doc->Text .= $sFooter;

		// Close recordset
		$rs->Close();

		// Call Page Exported server event
		$this->Page_Exported();

		// Export header and footer
		$Doc->ExportHeaderAndFooter();

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED && $this->Export <> "pdf")
			echo ew_DebugMsg();

		// Output data
		$Doc->Export();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
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
if (!isset($demanda_list)) $demanda_list = new cdemanda_list();

// Page init
$demanda_list->Page_Init();

// Page main
$demanda_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$demanda_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($demanda->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fdemandalist = new ew_Form("fdemandalist", "list");
fdemandalist.FormKeyCountName = '<?php echo $demanda_list->FormKeyCountName ?>';

// Form_CustomValidate event
fdemandalist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdemandalist.ValidateRequired = true;
<?php } else { ?>
fdemandalist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = fdemandalistsrch = new ew_Form("fdemandalistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($demanda->Export == "") { ?>
<div class="ewToolbar">
<?php if ($demanda->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($demanda_list->TotalRecs > 0 && $demanda_list->ExportOptions->Visible()) { ?>
<?php $demanda_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($demanda_list->SearchOptions->Visible()) { ?>
<?php $demanda_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($demanda_list->FilterOptions->Visible()) { ?>
<?php $demanda_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($demanda->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
	$bSelectLimit = $demanda_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($demanda_list->TotalRecs <= 0)
			$demanda_list->TotalRecs = $demanda->SelectRecordCount();
	} else {
		if (!$demanda_list->Recordset && ($demanda_list->Recordset = $demanda_list->LoadRecordset()))
			$demanda_list->TotalRecs = $demanda_list->Recordset->RecordCount();
	}
	$demanda_list->StartRec = 1;
	if ($demanda_list->DisplayRecs <= 0 || ($demanda->Export <> "" && $demanda->ExportAll)) // Display all records
		$demanda_list->DisplayRecs = $demanda_list->TotalRecs;
	if (!($demanda->Export <> "" && $demanda->ExportAll))
		$demanda_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$demanda_list->Recordset = $demanda_list->LoadRecordset($demanda_list->StartRec-1, $demanda_list->DisplayRecs);

	// Set no record found message
	if ($demanda->CurrentAction == "" && $demanda_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$demanda_list->setWarningMessage(ew_DeniedMsg());
		if ($demanda_list->SearchWhere == "0=101")
			$demanda_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$demanda_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$demanda_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($demanda->Export == "" && $demanda->CurrentAction == "") { ?>
<form name="fdemandalistsrch" id="fdemandalistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($demanda_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fdemandalistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="demanda">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($demanda_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($demanda_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $demanda_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($demanda_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($demanda_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($demanda_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($demanda_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $demanda_list->ShowPageHeader(); ?>
<?php
$demanda_list->ShowMessage();
?>
<?php if ($demanda_list->TotalRecs > 0 || $demanda->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid demanda">
<form name="fdemandalist" id="fdemandalist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($demanda_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $demanda_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="demanda">
<div id="gmp_demanda" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($demanda_list->TotalRecs > 0) { ?>
<table id="tbl_demandalist" class="table ewTable">
<?php echo $demanda->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$demanda_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$demanda_list->RenderListOptions();

// Render list options (header, left)
$demanda_list->ListOptions->Render("header", "left");
?>
<?php if ($demanda->origen_dem->Visible) { // origen_dem ?>
	<?php if ($demanda->SortUrl($demanda->origen_dem) == "") { ?>
		<th data-name="origen_dem"><div id="elh_demanda_origen_dem" class="demanda_origen_dem"><div class="ewTableHeaderCaption"><?php echo $demanda->origen_dem->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="origen_dem"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $demanda->SortUrl($demanda->origen_dem) ?>',1);"><div id="elh_demanda_origen_dem" class="demanda_origen_dem">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $demanda->origen_dem->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($demanda->origen_dem->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($demanda->origen_dem->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($demanda->tipo_cliente_dem->Visible) { // tipo_cliente_dem ?>
	<?php if ($demanda->SortUrl($demanda->tipo_cliente_dem) == "") { ?>
		<th data-name="tipo_cliente_dem"><div id="elh_demanda_tipo_cliente_dem" class="demanda_tipo_cliente_dem"><div class="ewTableHeaderCaption"><?php echo $demanda->tipo_cliente_dem->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tipo_cliente_dem"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $demanda->SortUrl($demanda->tipo_cliente_dem) ?>',1);"><div id="elh_demanda_tipo_cliente_dem" class="demanda_tipo_cliente_dem">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $demanda->tipo_cliente_dem->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($demanda->tipo_cliente_dem->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($demanda->tipo_cliente_dem->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($demanda->fecha_llamada->Visible) { // fecha_llamada ?>
	<?php if ($demanda->SortUrl($demanda->fecha_llamada) == "") { ?>
		<th data-name="fecha_llamada"><div id="elh_demanda_fecha_llamada" class="demanda_fecha_llamada"><div class="ewTableHeaderCaption"><?php echo $demanda->fecha_llamada->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha_llamada"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $demanda->SortUrl($demanda->fecha_llamada) ?>',1);"><div id="elh_demanda_fecha_llamada" class="demanda_fecha_llamada">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $demanda->fecha_llamada->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($demanda->fecha_llamada->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($demanda->fecha_llamada->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($demanda->cod_dem->Visible) { // cod_dem ?>
	<?php if ($demanda->SortUrl($demanda->cod_dem) == "") { ?>
		<th data-name="cod_dem"><div id="elh_demanda_cod_dem" class="demanda_cod_dem"><div class="ewTableHeaderCaption"><?php echo $demanda->cod_dem->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="cod_dem"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $demanda->SortUrl($demanda->cod_dem) ?>',1);"><div id="elh_demanda_cod_dem" class="demanda_cod_dem">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $demanda->cod_dem->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($demanda->cod_dem->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($demanda->cod_dem->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($demanda->poliza_dem->Visible) { // poliza_dem ?>
	<?php if ($demanda->SortUrl($demanda->poliza_dem) == "") { ?>
		<th data-name="poliza_dem"><div id="elh_demanda_poliza_dem" class="demanda_poliza_dem"><div class="ewTableHeaderCaption"><?php echo $demanda->poliza_dem->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="poliza_dem"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $demanda->SortUrl($demanda->poliza_dem) ?>',1);"><div id="elh_demanda_poliza_dem" class="demanda_poliza_dem">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $demanda->poliza_dem->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($demanda->poliza_dem->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($demanda->poliza_dem->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($demanda->usuario_captura->Visible) { // usuario_captura ?>
	<?php if ($demanda->SortUrl($demanda->usuario_captura) == "") { ?>
		<th data-name="usuario_captura"><div id="elh_demanda_usuario_captura" class="demanda_usuario_captura"><div class="ewTableHeaderCaption"><?php echo $demanda->usuario_captura->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="usuario_captura"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $demanda->SortUrl($demanda->usuario_captura) ?>',1);"><div id="elh_demanda_usuario_captura" class="demanda_usuario_captura">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $demanda->usuario_captura->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($demanda->usuario_captura->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($demanda->usuario_captura->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($demanda->campana_demanda->Visible) { // campana_demanda ?>
	<?php if ($demanda->SortUrl($demanda->campana_demanda) == "") { ?>
		<th data-name="campana_demanda"><div id="elh_demanda_campana_demanda" class="demanda_campana_demanda"><div class="ewTableHeaderCaption"><?php echo $demanda->campana_demanda->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="campana_demanda"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $demanda->SortUrl($demanda->campana_demanda) ?>',1);"><div id="elh_demanda_campana_demanda" class="demanda_campana_demanda">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $demanda->campana_demanda->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($demanda->campana_demanda->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($demanda->campana_demanda->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($demanda->chip_natural->Visible) { // chip_natural ?>
	<?php if ($demanda->SortUrl($demanda->chip_natural) == "") { ?>
		<th data-name="chip_natural"><div id="elh_demanda_chip_natural" class="demanda_chip_natural"><div class="ewTableHeaderCaption"><?php echo $demanda->chip_natural->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="chip_natural"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $demanda->SortUrl($demanda->chip_natural) ?>',1);"><div id="elh_demanda_chip_natural" class="demanda_chip_natural">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $demanda->chip_natural->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($demanda->chip_natural->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($demanda->chip_natural->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($demanda->estado_predio->Visible) { // estado_predio ?>
	<?php if ($demanda->SortUrl($demanda->estado_predio) == "") { ?>
		<th data-name="estado_predio"><div id="elh_demanda_estado_predio" class="demanda_estado_predio"><div class="ewTableHeaderCaption"><?php echo $demanda->estado_predio->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="estado_predio"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $demanda->SortUrl($demanda->estado_predio) ?>',1);"><div id="elh_demanda_estado_predio" class="demanda_estado_predio">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $demanda->estado_predio->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($demanda->estado_predio->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($demanda->estado_predio->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($demanda->tipo_predio->Visible) { // tipo_predio ?>
	<?php if ($demanda->SortUrl($demanda->tipo_predio) == "") { ?>
		<th data-name="tipo_predio"><div id="elh_demanda_tipo_predio" class="demanda_tipo_predio"><div class="ewTableHeaderCaption"><?php echo $demanda->tipo_predio->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tipo_predio"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $demanda->SortUrl($demanda->tipo_predio) ?>',1);"><div id="elh_demanda_tipo_predio" class="demanda_tipo_predio">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $demanda->tipo_predio->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($demanda->tipo_predio->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($demanda->tipo_predio->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($demanda->uso->Visible) { // uso ?>
	<?php if ($demanda->SortUrl($demanda->uso) == "") { ?>
		<th data-name="uso"><div id="elh_demanda_uso" class="demanda_uso"><div class="ewTableHeaderCaption"><?php echo $demanda->uso->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="uso"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $demanda->SortUrl($demanda->uso) ?>',1);"><div id="elh_demanda_uso" class="demanda_uso">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $demanda->uso->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($demanda->uso->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($demanda->uso->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($demanda->mecado->Visible) { // mecado ?>
	<?php if ($demanda->SortUrl($demanda->mecado) == "") { ?>
		<th data-name="mecado"><div id="elh_demanda_mecado" class="demanda_mecado"><div class="ewTableHeaderCaption"><?php echo $demanda->mecado->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="mecado"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $demanda->SortUrl($demanda->mecado) ?>',1);"><div id="elh_demanda_mecado" class="demanda_mecado">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $demanda->mecado->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($demanda->mecado->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($demanda->mecado->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($demanda->nombre_cliente->Visible) { // nombre_cliente ?>
	<?php if ($demanda->SortUrl($demanda->nombre_cliente) == "") { ?>
		<th data-name="nombre_cliente"><div id="elh_demanda_nombre_cliente" class="demanda_nombre_cliente"><div class="ewTableHeaderCaption"><?php echo $demanda->nombre_cliente->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nombre_cliente"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $demanda->SortUrl($demanda->nombre_cliente) ?>',1);"><div id="elh_demanda_nombre_cliente" class="demanda_nombre_cliente">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $demanda->nombre_cliente->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($demanda->nombre_cliente->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($demanda->nombre_cliente->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($demanda->num_doc->Visible) { // num_doc ?>
	<?php if ($demanda->SortUrl($demanda->num_doc) == "") { ?>
		<th data-name="num_doc"><div id="elh_demanda_num_doc" class="demanda_num_doc"><div class="ewTableHeaderCaption"><?php echo $demanda->num_doc->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="num_doc"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $demanda->SortUrl($demanda->num_doc) ?>',1);"><div id="elh_demanda_num_doc" class="demanda_num_doc">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $demanda->num_doc->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($demanda->num_doc->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($demanda->num_doc->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($demanda->direccion->Visible) { // direccion ?>
	<?php if ($demanda->SortUrl($demanda->direccion) == "") { ?>
		<th data-name="direccion"><div id="elh_demanda_direccion" class="demanda_direccion"><div class="ewTableHeaderCaption"><?php echo $demanda->direccion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="direccion"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $demanda->SortUrl($demanda->direccion) ?>',1);"><div id="elh_demanda_direccion" class="demanda_direccion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $demanda->direccion->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($demanda->direccion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($demanda->direccion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($demanda->municipio->Visible) { // municipio ?>
	<?php if ($demanda->SortUrl($demanda->municipio) == "") { ?>
		<th data-name="municipio"><div id="elh_demanda_municipio" class="demanda_municipio"><div class="ewTableHeaderCaption"><?php echo $demanda->municipio->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="municipio"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $demanda->SortUrl($demanda->municipio) ?>',1);"><div id="elh_demanda_municipio" class="demanda_municipio">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $demanda->municipio->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($demanda->municipio->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($demanda->municipio->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($demanda->telefono->Visible) { // telefono ?>
	<?php if ($demanda->SortUrl($demanda->telefono) == "") { ?>
		<th data-name="telefono"><div id="elh_demanda_telefono" class="demanda_telefono"><div class="ewTableHeaderCaption"><?php echo $demanda->telefono->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="telefono"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $demanda->SortUrl($demanda->telefono) ?>',1);"><div id="elh_demanda_telefono" class="demanda_telefono">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $demanda->telefono->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($demanda->telefono->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($demanda->telefono->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($demanda->cod_trabajo_original->Visible) { // cod_trabajo_original ?>
	<?php if ($demanda->SortUrl($demanda->cod_trabajo_original) == "") { ?>
		<th data-name="cod_trabajo_original"><div id="elh_demanda_cod_trabajo_original" class="demanda_cod_trabajo_original"><div class="ewTableHeaderCaption"><?php echo $demanda->cod_trabajo_original->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="cod_trabajo_original"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $demanda->SortUrl($demanda->cod_trabajo_original) ?>',1);"><div id="elh_demanda_cod_trabajo_original" class="demanda_cod_trabajo_original">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $demanda->cod_trabajo_original->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($demanda->cod_trabajo_original->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($demanda->cod_trabajo_original->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($demanda->fecha_trab_dem->Visible) { // fecha_trab_dem ?>
	<?php if ($demanda->SortUrl($demanda->fecha_trab_dem) == "") { ?>
		<th data-name="fecha_trab_dem"><div id="elh_demanda_fecha_trab_dem" class="demanda_fecha_trab_dem"><div class="ewTableHeaderCaption"><?php echo $demanda->fecha_trab_dem->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha_trab_dem"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $demanda->SortUrl($demanda->fecha_trab_dem) ?>',1);"><div id="elh_demanda_fecha_trab_dem" class="demanda_fecha_trab_dem">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $demanda->fecha_trab_dem->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($demanda->fecha_trab_dem->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($demanda->fecha_trab_dem->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($demanda->cod_ult_visit->Visible) { // cod_ult_visit ?>
	<?php if ($demanda->SortUrl($demanda->cod_ult_visit) == "") { ?>
		<th data-name="cod_ult_visit"><div id="elh_demanda_cod_ult_visit" class="demanda_cod_ult_visit"><div class="ewTableHeaderCaption"><?php echo $demanda->cod_ult_visit->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="cod_ult_visit"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $demanda->SortUrl($demanda->cod_ult_visit) ?>',1);"><div id="elh_demanda_cod_ult_visit" class="demanda_cod_ult_visit">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $demanda->cod_ult_visit->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($demanda->cod_ult_visit->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($demanda->cod_ult_visit->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($demanda->res_ult_vis->Visible) { // res_ult_vis ?>
	<?php if ($demanda->SortUrl($demanda->res_ult_vis) == "") { ?>
		<th data-name="res_ult_vis"><div id="elh_demanda_res_ult_vis" class="demanda_res_ult_vis"><div class="ewTableHeaderCaption"><?php echo $demanda->res_ult_vis->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="res_ult_vis"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $demanda->SortUrl($demanda->res_ult_vis) ?>',1);"><div id="elh_demanda_res_ult_vis" class="demanda_res_ult_vis">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $demanda->res_ult_vis->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($demanda->res_ult_vis->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($demanda->res_ult_vis->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($demanda->fecha_ult_visita->Visible) { // fecha_ult_visita ?>
	<?php if ($demanda->SortUrl($demanda->fecha_ult_visita) == "") { ?>
		<th data-name="fecha_ult_visita"><div id="elh_demanda_fecha_ult_visita" class="demanda_fecha_ult_visita"><div class="ewTableHeaderCaption"><?php echo $demanda->fecha_ult_visita->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha_ult_visita"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $demanda->SortUrl($demanda->fecha_ult_visita) ?>',1);"><div id="elh_demanda_fecha_ult_visita" class="demanda_fecha_ult_visita">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $demanda->fecha_ult_visita->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($demanda->fecha_ult_visita->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($demanda->fecha_ult_visita->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($demanda->usu_asig_primer_trab->Visible) { // usu_asig_primer_trab ?>
	<?php if ($demanda->SortUrl($demanda->usu_asig_primer_trab) == "") { ?>
		<th data-name="usu_asig_primer_trab"><div id="elh_demanda_usu_asig_primer_trab" class="demanda_usu_asig_primer_trab"><div class="ewTableHeaderCaption"><?php echo $demanda->usu_asig_primer_trab->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="usu_asig_primer_trab"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $demanda->SortUrl($demanda->usu_asig_primer_trab) ?>',1);"><div id="elh_demanda_usu_asig_primer_trab" class="demanda_usu_asig_primer_trab">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $demanda->usu_asig_primer_trab->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($demanda->usu_asig_primer_trab->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($demanda->usu_asig_primer_trab->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($demanda->fecha_prim_visit->Visible) { // fecha_prim_visit ?>
	<?php if ($demanda->SortUrl($demanda->fecha_prim_visit) == "") { ?>
		<th data-name="fecha_prim_visit"><div id="elh_demanda_fecha_prim_visit" class="demanda_fecha_prim_visit"><div class="ewTableHeaderCaption"><?php echo $demanda->fecha_prim_visit->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha_prim_visit"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $demanda->SortUrl($demanda->fecha_prim_visit) ?>',1);"><div id="elh_demanda_fecha_prim_visit" class="demanda_fecha_prim_visit">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $demanda->fecha_prim_visit->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($demanda->fecha_prim_visit->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($demanda->fecha_prim_visit->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($demanda->respuesta_pv->Visible) { // respuesta_pv ?>
	<?php if ($demanda->SortUrl($demanda->respuesta_pv) == "") { ?>
		<th data-name="respuesta_pv"><div id="elh_demanda_respuesta_pv" class="demanda_respuesta_pv"><div class="ewTableHeaderCaption"><?php echo $demanda->respuesta_pv->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="respuesta_pv"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $demanda->SortUrl($demanda->respuesta_pv) ?>',1);"><div id="elh_demanda_respuesta_pv" class="demanda_respuesta_pv">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $demanda->respuesta_pv->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($demanda->respuesta_pv->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($demanda->respuesta_pv->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($demanda->fecha_cap_primera_visita->Visible) { // fecha_cap_primera_visita ?>
	<?php if ($demanda->SortUrl($demanda->fecha_cap_primera_visita) == "") { ?>
		<th data-name="fecha_cap_primera_visita"><div id="elh_demanda_fecha_cap_primera_visita" class="demanda_fecha_cap_primera_visita"><div class="ewTableHeaderCaption"><?php echo $demanda->fecha_cap_primera_visita->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha_cap_primera_visita"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $demanda->SortUrl($demanda->fecha_cap_primera_visita) ?>',1);"><div id="elh_demanda_fecha_cap_primera_visita" class="demanda_fecha_cap_primera_visita">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $demanda->fecha_cap_primera_visita->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($demanda->fecha_cap_primera_visita->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($demanda->fecha_cap_primera_visita->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($demanda->cod_contratista->Visible) { // cod_contratista ?>
	<?php if ($demanda->SortUrl($demanda->cod_contratista) == "") { ?>
		<th data-name="cod_contratista"><div id="elh_demanda_cod_contratista" class="demanda_cod_contratista"><div class="ewTableHeaderCaption"><?php echo $demanda->cod_contratista->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="cod_contratista"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $demanda->SortUrl($demanda->cod_contratista) ?>',1);"><div id="elh_demanda_cod_contratista" class="demanda_cod_contratista">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $demanda->cod_contratista->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($demanda->cod_contratista->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($demanda->cod_contratista->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($demanda->nom_cont->Visible) { // nom_cont ?>
	<?php if ($demanda->SortUrl($demanda->nom_cont) == "") { ?>
		<th data-name="nom_cont"><div id="elh_demanda_nom_cont" class="demanda_nom_cont"><div class="ewTableHeaderCaption"><?php echo $demanda->nom_cont->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nom_cont"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $demanda->SortUrl($demanda->nom_cont) ?>',1);"><div id="elh_demanda_nom_cont" class="demanda_nom_cont">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $demanda->nom_cont->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($demanda->nom_cont->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($demanda->nom_cont->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($demanda->distrito->Visible) { // distrito ?>
	<?php if ($demanda->SortUrl($demanda->distrito) == "") { ?>
		<th data-name="distrito"><div id="elh_demanda_distrito" class="demanda_distrito"><div class="ewTableHeaderCaption"><?php echo $demanda->distrito->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="distrito"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $demanda->SortUrl($demanda->distrito) ?>',1);"><div id="elh_demanda_distrito" class="demanda_distrito">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $demanda->distrito->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($demanda->distrito->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($demanda->distrito->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($demanda->malla->Visible) { // malla ?>
	<?php if ($demanda->SortUrl($demanda->malla) == "") { ?>
		<th data-name="malla"><div id="elh_demanda_malla" class="demanda_malla"><div class="ewTableHeaderCaption"><?php echo $demanda->malla->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="malla"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $demanda->SortUrl($demanda->malla) ?>',1);"><div id="elh_demanda_malla" class="demanda_malla">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $demanda->malla->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($demanda->malla->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($demanda->malla->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($demanda->sector->Visible) { // sector ?>
	<?php if ($demanda->SortUrl($demanda->sector) == "") { ?>
		<th data-name="sector"><div id="elh_demanda_sector" class="demanda_sector"><div class="ewTableHeaderCaption"><?php echo $demanda->sector->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="sector"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $demanda->SortUrl($demanda->sector) ?>',1);"><div id="elh_demanda_sector" class="demanda_sector">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $demanda->sector->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($demanda->sector->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($demanda->sector->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($demanda->descr_estado_dem->Visible) { // descr_estado_dem ?>
	<?php if ($demanda->SortUrl($demanda->descr_estado_dem) == "") { ?>
		<th data-name="descr_estado_dem"><div id="elh_demanda_descr_estado_dem" class="demanda_descr_estado_dem"><div class="ewTableHeaderCaption"><?php echo $demanda->descr_estado_dem->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="descr_estado_dem"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $demanda->SortUrl($demanda->descr_estado_dem) ?>',1);"><div id="elh_demanda_descr_estado_dem" class="demanda_descr_estado_dem">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $demanda->descr_estado_dem->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($demanda->descr_estado_dem->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($demanda->descr_estado_dem->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($demanda->estrato->Visible) { // estrato ?>
	<?php if ($demanda->SortUrl($demanda->estrato) == "") { ?>
		<th data-name="estrato"><div id="elh_demanda_estrato" class="demanda_estrato"><div class="ewTableHeaderCaption"><?php echo $demanda->estrato->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="estrato"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $demanda->SortUrl($demanda->estrato) ?>',1);"><div id="elh_demanda_estrato" class="demanda_estrato">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $demanda->estrato->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($demanda->estrato->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($demanda->estrato->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($demanda->clase_dem->Visible) { // clase_dem ?>
	<?php if ($demanda->SortUrl($demanda->clase_dem) == "") { ?>
		<th data-name="clase_dem"><div id="elh_demanda_clase_dem" class="demanda_clase_dem"><div class="ewTableHeaderCaption"><?php echo $demanda->clase_dem->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="clase_dem"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $demanda->SortUrl($demanda->clase_dem) ?>',1);"><div id="elh_demanda_clase_dem" class="demanda_clase_dem">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $demanda->clase_dem->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($demanda->clase_dem->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($demanda->clase_dem->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$demanda_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($demanda->ExportAll && $demanda->Export <> "") {
	$demanda_list->StopRec = $demanda_list->TotalRecs;
} else {

	// Set the last record to display
	if ($demanda_list->TotalRecs > $demanda_list->StartRec + $demanda_list->DisplayRecs - 1)
		$demanda_list->StopRec = $demanda_list->StartRec + $demanda_list->DisplayRecs - 1;
	else
		$demanda_list->StopRec = $demanda_list->TotalRecs;
}
$demanda_list->RecCnt = $demanda_list->StartRec - 1;
if ($demanda_list->Recordset && !$demanda_list->Recordset->EOF) {
	$demanda_list->Recordset->MoveFirst();
	$bSelectLimit = $demanda_list->UseSelectLimit;
	if (!$bSelectLimit && $demanda_list->StartRec > 1)
		$demanda_list->Recordset->Move($demanda_list->StartRec - 1);
} elseif (!$demanda->AllowAddDeleteRow && $demanda_list->StopRec == 0) {
	$demanda_list->StopRec = $demanda->GridAddRowCount;
}

// Initialize aggregate
$demanda->RowType = EW_ROWTYPE_AGGREGATEINIT;
$demanda->ResetAttrs();
$demanda_list->RenderRow();
while ($demanda_list->RecCnt < $demanda_list->StopRec) {
	$demanda_list->RecCnt++;
	if (intval($demanda_list->RecCnt) >= intval($demanda_list->StartRec)) {
		$demanda_list->RowCnt++;

		// Set up key count
		$demanda_list->KeyCount = $demanda_list->RowIndex;

		// Init row class and style
		$demanda->ResetAttrs();
		$demanda->CssClass = "";
		if ($demanda->CurrentAction == "gridadd") {
		} else {
			$demanda_list->LoadRowValues($demanda_list->Recordset); // Load row values
		}
		$demanda->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$demanda->RowAttrs = array_merge($demanda->RowAttrs, array('data-rowindex'=>$demanda_list->RowCnt, 'id'=>'r' . $demanda_list->RowCnt . '_demanda', 'data-rowtype'=>$demanda->RowType));

		// Render row
		$demanda_list->RenderRow();

		// Render list options
		$demanda_list->RenderListOptions();
?>
	<tr<?php echo $demanda->RowAttributes() ?>>
<?php

// Render list options (body, left)
$demanda_list->ListOptions->Render("body", "left", $demanda_list->RowCnt);
?>
	<?php if ($demanda->origen_dem->Visible) { // origen_dem ?>
		<td data-name="origen_dem"<?php echo $demanda->origen_dem->CellAttributes() ?>>
<span id="el<?php echo $demanda_list->RowCnt ?>_demanda_origen_dem" class="demanda_origen_dem">
<span<?php echo $demanda->origen_dem->ViewAttributes() ?>>
<?php echo $demanda->origen_dem->ListViewValue() ?></span>
</span>
<a id="<?php echo $demanda_list->PageObjName . "_row_" . $demanda_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($demanda->tipo_cliente_dem->Visible) { // tipo_cliente_dem ?>
		<td data-name="tipo_cliente_dem"<?php echo $demanda->tipo_cliente_dem->CellAttributes() ?>>
<span id="el<?php echo $demanda_list->RowCnt ?>_demanda_tipo_cliente_dem" class="demanda_tipo_cliente_dem">
<span<?php echo $demanda->tipo_cliente_dem->ViewAttributes() ?>>
<?php echo $demanda->tipo_cliente_dem->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($demanda->fecha_llamada->Visible) { // fecha_llamada ?>
		<td data-name="fecha_llamada"<?php echo $demanda->fecha_llamada->CellAttributes() ?>>
<span id="el<?php echo $demanda_list->RowCnt ?>_demanda_fecha_llamada" class="demanda_fecha_llamada">
<span<?php echo $demanda->fecha_llamada->ViewAttributes() ?>>
<?php echo $demanda->fecha_llamada->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($demanda->cod_dem->Visible) { // cod_dem ?>
		<td data-name="cod_dem"<?php echo $demanda->cod_dem->CellAttributes() ?>>
<span id="el<?php echo $demanda_list->RowCnt ?>_demanda_cod_dem" class="demanda_cod_dem">
<span<?php echo $demanda->cod_dem->ViewAttributes() ?>>
<?php echo $demanda->cod_dem->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($demanda->poliza_dem->Visible) { // poliza_dem ?>
		<td data-name="poliza_dem"<?php echo $demanda->poliza_dem->CellAttributes() ?>>
<span id="el<?php echo $demanda_list->RowCnt ?>_demanda_poliza_dem" class="demanda_poliza_dem">
<span<?php echo $demanda->poliza_dem->ViewAttributes() ?>>
<?php echo $demanda->poliza_dem->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($demanda->usuario_captura->Visible) { // usuario_captura ?>
		<td data-name="usuario_captura"<?php echo $demanda->usuario_captura->CellAttributes() ?>>
<span id="el<?php echo $demanda_list->RowCnt ?>_demanda_usuario_captura" class="demanda_usuario_captura">
<span<?php echo $demanda->usuario_captura->ViewAttributes() ?>>
<?php echo $demanda->usuario_captura->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($demanda->campana_demanda->Visible) { // campana_demanda ?>
		<td data-name="campana_demanda"<?php echo $demanda->campana_demanda->CellAttributes() ?>>
<span id="el<?php echo $demanda_list->RowCnt ?>_demanda_campana_demanda" class="demanda_campana_demanda">
<span<?php echo $demanda->campana_demanda->ViewAttributes() ?>>
<?php echo $demanda->campana_demanda->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($demanda->chip_natural->Visible) { // chip_natural ?>
		<td data-name="chip_natural"<?php echo $demanda->chip_natural->CellAttributes() ?>>
<span id="el<?php echo $demanda_list->RowCnt ?>_demanda_chip_natural" class="demanda_chip_natural">
<span<?php echo $demanda->chip_natural->ViewAttributes() ?>>
<?php echo $demanda->chip_natural->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($demanda->estado_predio->Visible) { // estado_predio ?>
		<td data-name="estado_predio"<?php echo $demanda->estado_predio->CellAttributes() ?>>
<span id="el<?php echo $demanda_list->RowCnt ?>_demanda_estado_predio" class="demanda_estado_predio">
<span<?php echo $demanda->estado_predio->ViewAttributes() ?>>
<?php echo $demanda->estado_predio->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($demanda->tipo_predio->Visible) { // tipo_predio ?>
		<td data-name="tipo_predio"<?php echo $demanda->tipo_predio->CellAttributes() ?>>
<span id="el<?php echo $demanda_list->RowCnt ?>_demanda_tipo_predio" class="demanda_tipo_predio">
<span<?php echo $demanda->tipo_predio->ViewAttributes() ?>>
<?php echo $demanda->tipo_predio->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($demanda->uso->Visible) { // uso ?>
		<td data-name="uso"<?php echo $demanda->uso->CellAttributes() ?>>
<span id="el<?php echo $demanda_list->RowCnt ?>_demanda_uso" class="demanda_uso">
<span<?php echo $demanda->uso->ViewAttributes() ?>>
<?php echo $demanda->uso->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($demanda->mecado->Visible) { // mecado ?>
		<td data-name="mecado"<?php echo $demanda->mecado->CellAttributes() ?>>
<span id="el<?php echo $demanda_list->RowCnt ?>_demanda_mecado" class="demanda_mecado">
<span<?php echo $demanda->mecado->ViewAttributes() ?>>
<?php echo $demanda->mecado->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($demanda->nombre_cliente->Visible) { // nombre_cliente ?>
		<td data-name="nombre_cliente"<?php echo $demanda->nombre_cliente->CellAttributes() ?>>
<span id="el<?php echo $demanda_list->RowCnt ?>_demanda_nombre_cliente" class="demanda_nombre_cliente">
<span<?php echo $demanda->nombre_cliente->ViewAttributes() ?>>
<?php echo $demanda->nombre_cliente->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($demanda->num_doc->Visible) { // num_doc ?>
		<td data-name="num_doc"<?php echo $demanda->num_doc->CellAttributes() ?>>
<span id="el<?php echo $demanda_list->RowCnt ?>_demanda_num_doc" class="demanda_num_doc">
<span<?php echo $demanda->num_doc->ViewAttributes() ?>>
<?php echo $demanda->num_doc->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($demanda->direccion->Visible) { // direccion ?>
		<td data-name="direccion"<?php echo $demanda->direccion->CellAttributes() ?>>
<span id="el<?php echo $demanda_list->RowCnt ?>_demanda_direccion" class="demanda_direccion">
<span<?php echo $demanda->direccion->ViewAttributes() ?>>
<?php echo $demanda->direccion->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($demanda->municipio->Visible) { // municipio ?>
		<td data-name="municipio"<?php echo $demanda->municipio->CellAttributes() ?>>
<span id="el<?php echo $demanda_list->RowCnt ?>_demanda_municipio" class="demanda_municipio">
<span<?php echo $demanda->municipio->ViewAttributes() ?>>
<?php echo $demanda->municipio->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($demanda->telefono->Visible) { // telefono ?>
		<td data-name="telefono"<?php echo $demanda->telefono->CellAttributes() ?>>
<span id="el<?php echo $demanda_list->RowCnt ?>_demanda_telefono" class="demanda_telefono">
<span<?php echo $demanda->telefono->ViewAttributes() ?>>
<?php echo $demanda->telefono->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($demanda->cod_trabajo_original->Visible) { // cod_trabajo_original ?>
		<td data-name="cod_trabajo_original"<?php echo $demanda->cod_trabajo_original->CellAttributes() ?>>
<span id="el<?php echo $demanda_list->RowCnt ?>_demanda_cod_trabajo_original" class="demanda_cod_trabajo_original">
<span<?php echo $demanda->cod_trabajo_original->ViewAttributes() ?>>
<?php echo $demanda->cod_trabajo_original->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($demanda->fecha_trab_dem->Visible) { // fecha_trab_dem ?>
		<td data-name="fecha_trab_dem"<?php echo $demanda->fecha_trab_dem->CellAttributes() ?>>
<span id="el<?php echo $demanda_list->RowCnt ?>_demanda_fecha_trab_dem" class="demanda_fecha_trab_dem">
<span<?php echo $demanda->fecha_trab_dem->ViewAttributes() ?>>
<?php echo $demanda->fecha_trab_dem->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($demanda->cod_ult_visit->Visible) { // cod_ult_visit ?>
		<td data-name="cod_ult_visit"<?php echo $demanda->cod_ult_visit->CellAttributes() ?>>
<span id="el<?php echo $demanda_list->RowCnt ?>_demanda_cod_ult_visit" class="demanda_cod_ult_visit">
<span<?php echo $demanda->cod_ult_visit->ViewAttributes() ?>>
<?php echo $demanda->cod_ult_visit->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($demanda->res_ult_vis->Visible) { // res_ult_vis ?>
		<td data-name="res_ult_vis"<?php echo $demanda->res_ult_vis->CellAttributes() ?>>
<span id="el<?php echo $demanda_list->RowCnt ?>_demanda_res_ult_vis" class="demanda_res_ult_vis">
<span<?php echo $demanda->res_ult_vis->ViewAttributes() ?>>
<?php echo $demanda->res_ult_vis->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($demanda->fecha_ult_visita->Visible) { // fecha_ult_visita ?>
		<td data-name="fecha_ult_visita"<?php echo $demanda->fecha_ult_visita->CellAttributes() ?>>
<span id="el<?php echo $demanda_list->RowCnt ?>_demanda_fecha_ult_visita" class="demanda_fecha_ult_visita">
<span<?php echo $demanda->fecha_ult_visita->ViewAttributes() ?>>
<?php echo $demanda->fecha_ult_visita->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($demanda->usu_asig_primer_trab->Visible) { // usu_asig_primer_trab ?>
		<td data-name="usu_asig_primer_trab"<?php echo $demanda->usu_asig_primer_trab->CellAttributes() ?>>
<span id="el<?php echo $demanda_list->RowCnt ?>_demanda_usu_asig_primer_trab" class="demanda_usu_asig_primer_trab">
<span<?php echo $demanda->usu_asig_primer_trab->ViewAttributes() ?>>
<?php echo $demanda->usu_asig_primer_trab->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($demanda->fecha_prim_visit->Visible) { // fecha_prim_visit ?>
		<td data-name="fecha_prim_visit"<?php echo $demanda->fecha_prim_visit->CellAttributes() ?>>
<span id="el<?php echo $demanda_list->RowCnt ?>_demanda_fecha_prim_visit" class="demanda_fecha_prim_visit">
<span<?php echo $demanda->fecha_prim_visit->ViewAttributes() ?>>
<?php echo $demanda->fecha_prim_visit->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($demanda->respuesta_pv->Visible) { // respuesta_pv ?>
		<td data-name="respuesta_pv"<?php echo $demanda->respuesta_pv->CellAttributes() ?>>
<span id="el<?php echo $demanda_list->RowCnt ?>_demanda_respuesta_pv" class="demanda_respuesta_pv">
<span<?php echo $demanda->respuesta_pv->ViewAttributes() ?>>
<?php echo $demanda->respuesta_pv->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($demanda->fecha_cap_primera_visita->Visible) { // fecha_cap_primera_visita ?>
		<td data-name="fecha_cap_primera_visita"<?php echo $demanda->fecha_cap_primera_visita->CellAttributes() ?>>
<span id="el<?php echo $demanda_list->RowCnt ?>_demanda_fecha_cap_primera_visita" class="demanda_fecha_cap_primera_visita">
<span<?php echo $demanda->fecha_cap_primera_visita->ViewAttributes() ?>>
<?php echo $demanda->fecha_cap_primera_visita->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($demanda->cod_contratista->Visible) { // cod_contratista ?>
		<td data-name="cod_contratista"<?php echo $demanda->cod_contratista->CellAttributes() ?>>
<span id="el<?php echo $demanda_list->RowCnt ?>_demanda_cod_contratista" class="demanda_cod_contratista">
<span<?php echo $demanda->cod_contratista->ViewAttributes() ?>>
<?php echo $demanda->cod_contratista->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($demanda->nom_cont->Visible) { // nom_cont ?>
		<td data-name="nom_cont"<?php echo $demanda->nom_cont->CellAttributes() ?>>
<span id="el<?php echo $demanda_list->RowCnt ?>_demanda_nom_cont" class="demanda_nom_cont">
<span<?php echo $demanda->nom_cont->ViewAttributes() ?>>
<?php echo $demanda->nom_cont->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($demanda->distrito->Visible) { // distrito ?>
		<td data-name="distrito"<?php echo $demanda->distrito->CellAttributes() ?>>
<span id="el<?php echo $demanda_list->RowCnt ?>_demanda_distrito" class="demanda_distrito">
<span<?php echo $demanda->distrito->ViewAttributes() ?>>
<?php echo $demanda->distrito->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($demanda->malla->Visible) { // malla ?>
		<td data-name="malla"<?php echo $demanda->malla->CellAttributes() ?>>
<span id="el<?php echo $demanda_list->RowCnt ?>_demanda_malla" class="demanda_malla">
<span<?php echo $demanda->malla->ViewAttributes() ?>>
<?php echo $demanda->malla->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($demanda->sector->Visible) { // sector ?>
		<td data-name="sector"<?php echo $demanda->sector->CellAttributes() ?>>
<span id="el<?php echo $demanda_list->RowCnt ?>_demanda_sector" class="demanda_sector">
<span<?php echo $demanda->sector->ViewAttributes() ?>>
<?php echo $demanda->sector->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($demanda->descr_estado_dem->Visible) { // descr_estado_dem ?>
		<td data-name="descr_estado_dem"<?php echo $demanda->descr_estado_dem->CellAttributes() ?>>
<span id="el<?php echo $demanda_list->RowCnt ?>_demanda_descr_estado_dem" class="demanda_descr_estado_dem">
<span<?php echo $demanda->descr_estado_dem->ViewAttributes() ?>>
<?php echo $demanda->descr_estado_dem->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($demanda->estrato->Visible) { // estrato ?>
		<td data-name="estrato"<?php echo $demanda->estrato->CellAttributes() ?>>
<span id="el<?php echo $demanda_list->RowCnt ?>_demanda_estrato" class="demanda_estrato">
<span<?php echo $demanda->estrato->ViewAttributes() ?>>
<?php echo $demanda->estrato->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($demanda->clase_dem->Visible) { // clase_dem ?>
		<td data-name="clase_dem"<?php echo $demanda->clase_dem->CellAttributes() ?>>
<span id="el<?php echo $demanda_list->RowCnt ?>_demanda_clase_dem" class="demanda_clase_dem">
<span<?php echo $demanda->clase_dem->ViewAttributes() ?>>
<?php echo $demanda->clase_dem->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$demanda_list->ListOptions->Render("body", "right", $demanda_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($demanda->CurrentAction <> "gridadd")
		$demanda_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($demanda->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($demanda_list->Recordset)
	$demanda_list->Recordset->Close();
?>
<?php if ($demanda->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($demanda->CurrentAction <> "gridadd" && $demanda->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($demanda_list->Pager)) $demanda_list->Pager = new cPrevNextPager($demanda_list->StartRec, $demanda_list->DisplayRecs, $demanda_list->TotalRecs) ?>
<?php if ($demanda_list->Pager->RecordCount > 0 && $demanda_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($demanda_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $demanda_list->PageUrl() ?>start=<?php echo $demanda_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($demanda_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $demanda_list->PageUrl() ?>start=<?php echo $demanda_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $demanda_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($demanda_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $demanda_list->PageUrl() ?>start=<?php echo $demanda_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($demanda_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $demanda_list->PageUrl() ?>start=<?php echo $demanda_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $demanda_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $demanda_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $demanda_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $demanda_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($demanda_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($demanda_list->TotalRecs == 0 && $demanda->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($demanda_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($demanda->Export == "") { ?>
<script type="text/javascript">
fdemandalistsrch.FilterList = <?php echo $demanda_list->GetFilterList() ?>;
fdemandalistsrch.Init();
fdemandalist.Init();
</script>
<?php } ?>
<?php
$demanda_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($demanda->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$demanda_list->Page_Terminate();
?>
