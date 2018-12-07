<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Session;
use App\Models\SystemSetting;
use App\LogConverter;
use App\Models\CachedAudit;
use Carbon;
use App\Models\CommunicationRecipient;

use Illuminate\Support\Facades\Redis;

class DashboardController extends Controller
{
    public function __construct()
    {
        // $this->middleware('allita.auth');
        if(env('APP_DEBUG_NO_DEVCO') == 'true'){
            Auth::onceUsingId(1); // TEST BRIAN
            //Auth::onceUsingId(286); // TEST BRIAN
            
            // this is normally setup upon login
            $current_user = Auth::user();
            if($current_user->socket_id === null){
                // create a socket id and store in user table
                $token = str_random(10);
                $current_user->socket_id = $token;
                $current_user->save();
            }
        }
    }

    public function login()
    {
        return "This feature has been replaced with a DevCo login. Please visit Devco Online to login.";
    }

    public function index(Request $request)
    {
        if ($request->query('tab') >= 1) {
            $tab = "dash-subtab-".intval($request->query('tab'));
            $showHowTo = 2;
        } else {
            // default tab to load
            $tab = "dash-subtab-1";
        }

        //// load the sitevisit tab instead
        $routed = \Route::getFacadeRoot()->current()->uri();
        if ($routed == "site_visit_manager") {
            // Give instruction on steps to take for a approved POs.
            $loadDetailTab = 2;
        } else {
            $loadDetailTab = 1;
        }

        $current_user = Auth::user();

        $tab = "detail-tab-1";

        $stats_communication_total = CommunicationRecipient::where('user_id', $current_user->id)
                    ->where('seen', 0)
                    ->count();

        //return \view('dashboard.index'); //, compact('user')
        return view('dashboard.index', compact('tab', 'loadDetailTab', 'stats_communication_total', 'current_user'));
    }

    public function audits(Request $request, $page=0)
    {
        
        // $request will contain filters
        // $auditFilterMineOnly
        // $auditFilterMineOnly

        $filter = $request->get('filter');
        $filter_id = $request->get('filterId');

        if(session()->has('audit-sort-by')){
            $sort_by = session('audit-sort-by');

            if(session()->has('audit-sort-order') && session('audit-sort-order') != 'undefined'){
                $sort_order = session('audit-sort-order');
            }else{
                session(['audit-sort-order', 0]);
                $sort_order = 0;
            }
        }else{
            session(['audit-sort-by', 'audit-sort-project']);
            $sort_by = 'audit-sort-project';

            session(['audit-sort-order', 1]);
            $sort_order = 1;
        }

        $auditFilterMineOnly = 1;

        switch ($sort_by) {
            case "audit-sort-lead":
                $sort_by_field = 'lead';
                break;
            case "audit-sort-project":
                $sort_by_field = 'project_ref';
                break;
            case "audit-sort-project-name":
                $sort_by_field = 'title';
                break;
            case "audit-sort-pm":
                $sort_by_field = 'pm';
                break;
            case "audit-sort-address":
                $sort_by_field = 'address';
                break;
            case "audit-sort-city":
                $sort_by_field = 'city';
                break;
            case "audit-sort-state":
                $sort_by_field = 'state';
                break;
            case "audit-sort-zip":
                $sort_by_field = 'zip';
                break;
            case "audit-sort-scheduled-date":
                $sort_by_field = 'inspection_schedule_date';
                break;
            case "audit-sort-assigned-areas":
                $sort_by_field = 'total_items';
                break;
            case "audit-sort-total-areas":
                $sort_by_field = 'inspectable_items';
                break;
            case "audit-sort-compliance-status":
                $sort_by_field = 'audit_compliance_status';
                break;
            case "audit-sort-followup-date":
                $sort_by_field = 'followup_date';
                break;
            case "audit-sort-finding-file":
                $sort_by_field = 'file_audit_status';
                break;
            case "audit-sort-finding-nlt":
                $sort_by_field = 'nlt_audit_status';
                break;
            case "audit-sort-finding-lt":
                $sort_by_field = 'lt_audit_status';
                break;
            case "audit-sort-finding-sd":
                $sort_by_field = 'smoke_audit_status';
                break;
            case "audit-sort-status-auditor":
                $sort_by_field = 'auditor_status';
                break;
            case "audit-sort-status-message":
                $sort_by_field = 'message';
                break;
            case "audit-sort-status-document":
                $sort_by_field = 'document';
                break;
            case "audit-sort-status-history":
                $sort_by_field = 'history_status';
                break;
            case "audit-sort-next-task":
                $sort_by_field = 'step_status';
                break;
            default:
               $sort_by_field = 'id';
        }

        if($sort_order){
            $sort_order_query = "asc";
        }else{
            $sort_order_query = "desc";
        }

        $audits = CachedAudit::orderBy($sort_by_field, $sort_order_query)->get();

        $data = [];

        foreach($audits as $audit){

            if($audit['status'] != 'critical') {
                $notcritical = 'notcritical';
            }else{
                $notcritical = 'critical';
            }

            if(session('audit-hidenoncritical') == 1 && $audit['status'] != 'critical'){
                $display = 'none';
            }else{
                $display = 'table-row';
            }

            if($audit->lead_json){
                $lead_name = $audit->lead_json->name;
                $lead_color = $audit->lead_json->color;
                $lead_initials = $audit->lead_json->initials;
            }else{
                $lead_name = '';
                $lead_color = '';
                $lead_initials = '';
            }

            $pm = strtoupper($audit['pm']);
            $inspectionScheduleDate = \Carbon\Carbon::createFromFormat('Y-m-d', $audit['inspection_schedule_date'])->format('m/d');
            $inspectionScheduleDateYear = \Carbon\Carbon::createFromFormat('Y-m-d', $audit['inspection_schedule_date'])->format('Y');
            $followupDate = \Carbon\Carbon::createFromFormat('Y-m-d', $audit['followup_date'])->format('m/d');
            $followupDateYear = \Carbon\Carbon::createFromFormat('Y-m-d', $audit['followup_date'])->format('Y');

            $data[] = [    
                'id' => $audit->id,
                'title' => $audit->title,
                'notcritical' => $notcritical,
                'display' => $display,
                'tooltipLead' => 'pos:top-left;title:'.$lead_name.';',
                'userBadgeColor' => 'user-badge-'.$lead_color,
                'initials' => $lead_initials,
                'total_buildings' => $audit['total_buildings'],
                'projectRef' => $audit['project_ref'],
                'pm' => $pm,
                'address' => $audit['address'],
                'address2' => $audit['city'].', '.$audit['state'].' '.$audit['zip'],
                'inspectionStatus' => $audit['inspection_status'],
                'tooltipInspectionStatus' => 'title:'.$audit['inspection_status_text'],
                'tooltipInspectionSchedule' => 'title:'.$audit['inspection_schedule_text'],
                'inspectionScheduleDate' => $inspectionScheduleDate,
                'inspectionScheduleDateYear' => $inspectionScheduleDateYear,
                'tooltipInspectableItems' => 'title:'.$audit['inspectable_items'].' INSPECTABLE ITEMS;',
                'inspectableItems' => $audit['inspectable_items'],
                'totalItems' => $audit['total_items'],
                'complianceIconClass' => $audit['audit_compliance_icon'],
                'complianceStatusClass' => $audit['audit_compliance_status'],
                'tooltipComplianceStatus' => 'title:'.$audit['audit_compliance_status_text'],
                'followupStatusClass' => $audit['followup_status'],
                'tooltipFollowupStatus' => 'title:'.$audit['followup_status_text'],
                'followupDate' => $followupDate,
                'followupDateYear' => $followupDateYear,
                'fileAuditStatusClass' => $audit['file_audit_status'],
                'tooltipFileAuditStatus' => 'title:'.$audit['file_audit_status_text'],
                'fileAuditIconClass' => $audit['file_audit_icon'],
                'nltAuditStatusClass' => $audit['nlt_audit_status'],
                'tooltipNltAuditStatus' => 'title:'.$audit['nlt_audit_status_text'],
                'nltAuditIconClass' => $audit['nlt_audit_icon'],
                'ltAuditStatusClass' => $audit['lt_audit_status'],
                'tooltipLtAuditStatus' => 'title:'.$audit['smoke_audit_status_text'],
                'ltAuditIconClass' => $audit['smoke_audit_icon'],

                'auditorStatusIconClass' => $audit['auditor_status_icon'], 
                'messageStatusClass' => $audit['auditor_status'],
                'tooltipAuditorStatus' => 'title:'.$audit['auditor_status_text'].';',
                'messageStatusIconClass' => $audit['message_status_icon'], 
                'messageStatusClass' => $audit['message_status'],
                'tooltipMessageStatus' => 'title:'.$audit['message_status_text'].';',
                'documentStatusIconClass' => $audit['document_status_icon'], 
                'documentStatusClass' => $audit['document_status'],
                'tooltipDocumentStatus' => 'title:'.$audit['document_status_text'].';',
                'historyStatusIconClass' => $audit['history_status_icon'], 
                'historyStatusClass' => $audit['history_status'],
                'tooltipHistoryStatus' => 'title:'.$audit['history_status_text'].';',
                'stepStatusIconClass' => $audit['step_status_icon'],
                'stepStatusClass' => $audit['step_status'],
                'tooltipStepStatus' => 'title:'.$audit['step_status_text'].';'
            ];
        }   

        if($page>0){
            return response()->json($data);
        }else{
            return view('dashboard.audits', compact('data', 'filter', 'auditFilterMineOnly', 'audits', 'sort_by', 'sort_order'));
        }
    }

    public function reports(Request $request)
    {
        
        //return \view('dashboard.index'); //, compact('user')
        return view('dashboard.reports');
    }

    public function autocomplete(Request $request)
    {
        /*
        if (Auth::user()->entity_type == 'hfa') {
            $parcels = Parcel::join('states', 'parcels.state_id', 'states.id')
            ->join('property_status_options as hfa_status', 'parcels.hfa_property_status_id', 'hfa_status.id')
            ->join('property_status_options as lb_status', 'parcels.landbank_property_status_id', 'lb_status.id')
            ->leftJoin('import_rows', 'import_rows.row_id', 'parcels.id')
            ->leftJoin('imports', 'imports.id', 'import_rows.import_id')
            ->leftJoin('users', 'users.id', 'imports.user_id')
            ->select('street_address', 'city', 'state_acronym', 'parcels.parcel_id', 'parcels.id', 'lb_status.option_name as lb_status_name', 'hfa_status.option_name as hfa_status_name', 'import_rows.import_id', 'users.name', 'imports.created_at', 'imports.validated')
            ->where('parcel_id', 'LIKE', '%'.$request->search.'%')
            ->orWhere('city', 'like', '%'.$request->search.'%')
            ->orWhere('street_address', 'like', '%'.$request->search.'%')->take(20)->get()->all();
        } else {
            $parcels = Parcel::join('states', 'parcels.state_id', 'states.id')
                        ->join('property_status_options as lb_status', 'parcels.landbank_property_status_id', 'lb_status.id')
                        ->join('property_status_options as hfa_status', 'parcels.hfa_property_status_id', 'hfa_status.id')
                        ->leftJoin('import_rows', 'import_rows.row_id', 'parcels.id')
                        ->leftJoin('imports', 'imports.id', 'import_rows.import_id')
                        ->leftJoin('users', 'users.id', 'imports.user_id')
                        ->select('street_address', 'city', 'state_acronym', 'parcels.parcel_id', 'parcels.id', 'lb_status.option_name as lb_status_name', 'hfa_status.option_name as hfa_status_name', 'import_rows.import_id as import_id', 'users.name as name', 'imports.created_at', 'imports.validated')

                        ->where('parcels.entity_id', Auth::user()->entity_id)
                        ->where(function ($q) use ($request) {
                            //$request = Request::input();
                            $q->where('parcel_id', 'LIKE', '%'.$request->search.'%')
                            ->orWhere('city', 'like', '%'.$request->search.'%')
                            ->orWhere('street_address', 'like', '%'.$request->search.'%');
                        })->take(20)->get()->all();
        }
        $i = 0;
        $results=[];
        foreach ($parcels as $data) {
            $parcels[$i]->created_at_formatted = date('n/j/y \a\t g:h a', strtotime($data->created_at));
            $results[] = [
                        $data->street_address,
                        $data->city,
                        $data->state_acronym,
                        $data->parcel_id,
                        $data->id,
                        $data->lb_status_name,
                        $data->hfa_status_name,
                        $data->import_id,
                        $data->name,
                        $data->created_at,
                        $data->validated,
                        $parcels[$i]->created_at_formatted];
            $i++;
        }
        */

        //Project Id Audit id Main address Property Manager Name Project Name
        $results = [];
        // $results[] = [
        //                 $data->street_address,
        //                 $data->city,
        //                 $data->state_acronym,
        //                 $data->project_id,
        //                 $data->audit_id,
        //                 $data->manager_name,
        //                 $data->project_name
        //             ];
        //             
                    
        // search for primary address (project), project #, audit#
        $results[] = [
                        '123 Street Name',
                        'City Name',
                        'OH',
                        '123456',
                        '654322',
                        'Bob Manager',
                        'Project Name'
                    ];

        $results[] = [
                        '456 Street Name',
                        'City 2 Name',
                        'OH',
                        '789',
                        '987',
                        'John Manager',
                        'Project Name 2'
                    ];

        $results[] = [
                        '456 Street Name',
                        'City 2 Name',
                        'OH',
                        '789',
                        '987',
                        'John Manager',
                        'Project Name 2'
                    ];

        $results[] = [
                        '456 Street Name',
                        'City 2 Name',
                        'OH',
                        '789',
                        '987',
                        'John Manager',
                        'Project Name 2'
                    ];
        
        $results = json_encode($results);
        return $results;
    }

}