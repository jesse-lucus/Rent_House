<?php 
    if(!isset($projects_array)){ $projects_array = null;}
    if(!isset($hfa_users_array)){ $hfa_users_array = null;} 
    $crrStatusSelection = 'all';
    $crrProjectSelection = 'all';
    $crrLeadSelection = 'all';
    ?>

<div id="reports_tab">
    <div uk-grid class="uk-margin-top" id="message-filters" data-uk-button-radio="">

        
                <div uk-grid class="uk-width-1-4">
                	@can('access_auditor')

                    <select id="filter-by-owner" class="uk-select filter-drops uk-width-1-1" onchange="loadTab('/dashboard/reports?crr_report_status_id='+this.value, '3','','','',1);">
                        <option value="all">
                            FILTER BY STATUS 
                        </option>
                        <option value="all" @if(session('crr_report_status_id') == 'all')  @endIf>
                            ALL REPORT STATUSES
                        </option>
                        @if(!is_null($crrApprovalTypes))
                            @foreach ($crrApprovalTypes as $status)
                            <option value="{{$status->id}}" @if(session('crr_report_status_id') == $status->id) <?php $crrStatusSelection = $status->name; ?> @endIf><a class="uk-dropdown-close">{{$status->name}}</a></option>    
                            @endforeach
                        @endIf
                    </select>

                    
                    
                    @endCan
                    
                </div>
                
                
                @can('access_auditor')
                <div class="uk-width-1-4" id="recipient-dropdown" style="vertical-align: top;">
                    <select id="filter-by-owner" class="uk-select filter-drops uk-width-1-1" onchange="loadTab('/dashboard/reports?crr_report_project_id='+this.value, '3','','','',1);">
                        <option value="all" selected="">
                            FILTER BY PROJECT 
                        </option>
                        <option value="all" @if(session('crr_report_project_id') == 'all')  @endIf>
                            ALL PROJECTS
                        </option>
                        @if(!is_null($projects_array))
                            <!-- crr_report_project_id -->
	                        @foreach ($projects_array as $project)
	                        <option value="{{$project->id}}" @if(session('crr_report_project_id') == $project->id) <?php $crrProjectSelection = $project->project_number.' : '.$project->project_name; ?>  @endIf><a class="uk-dropdown-close">{{$project->project_number}} : {{$project->project_name}}</a></option>    
	                        @endforeach
	                    @endIf
                    </select>
                    
                </div>
                <div class="uk-width-1-4" style="vertical-align: top;">
                    <select id="filter-by-program" class="uk-select filter-drops uk-width-1-1" onchange="loadTab('/dashboard/reports?crr_report_lead_id='+this.value, '3','','','',1);">
                        <option value="all" selected="">
                            FILTER BY LEAD 
                            </option>
                            <option value="all" @if(session('crr_report_lead_id') == 'all')  @endIf>
                            ALL LEADS
                        </option>
                            @if(!is_null($hfa_users_array))
	                            @foreach ($hfa_users_array as $user)
	                            <option value="{{$user->id}}">@if(session('crr_report_lead_id') == $user->id)<?php $crrLeadSelection = $user->person->first_name.' '.$user->person->last_name; ?>  @endIf<a  class="uk-dropdown-close">{{$user->person->first_name}} {{$user->person->last_name}}</a></option>    
	                            @endforeach 
	                        @endIf      
                        </select>
                </div>
                
                <div class="uk-width-1-4" >
                    <input id="reports-search" name="reports-search" type="text" value="" class=" uk-input" placeholder="Search report content (press enter)">
                        
                </div>
                
                @endCan
    </div>
    <hr class="dashed-hr">
    <div uk-grid class="uk-margin-top ">

        <div class="uk-width-1-1">
            <div class="uk-align-right uk-label  uk-margin-top uk-margin-right">{{$reports->total()}} @if($reports->total() == 1) REPORT @else REPORTS @endif</div>
            <div id="crr-filter-mine" class="uk-badge uk-text-right@s badge-filter" style="background-color:#d8eefa"><a class=" " onclick="dynamicModalLoad('new-report')">
                        <span class="a-file-plus"></span> 
                        <span>NEW REPORT</span>
                    </a>
                </div>
            @if(session('crr_search') && session('crr_search') !== '%%clear-search%%')

            <div id="crr-filter-mine" class="uk-badge uk-text-right@s badge-filter">
                <a onClick="loadTab('/dashboard/reports?search=%%clear-search%%', '3','','','',1);" class="uk-dark uk-light"><i class="a-circle-cross"></i> <span>SEARCH " {{ session('crr_search') }} "</span></a>
                
            </div>
            @endIf
            @if(session('crr_report_status_id') && session('crr_report_status_id') !== 'all')

            <div id="crr-filter-mine" class="uk-badge uk-text-right@s badge-filter">
                <a onClick="loadTab('/dashboard/reports?crr_report_status_id=all', '3','','','',1);" class="uk-dark uk-light"><i class="a-circle-cross"></i> <span>{{ strtoupper($crrStatusSelection) }}</span></a>
                
            </div>
            @endIf
            @if(session('crr_report_project_id') && session('crr_report_project_id') !== 'all')

            <div id="crr-filter-mine" class="uk-badge uk-text-right@s badge-filter">
                <a onClick="loadTab('/dashboard/reports?crr_report_project_id=all', '3','','','',1);" class="uk-dark uk-light"><i class="a-circle-cross"></i> <span>{{ $crrProjectSelection }}</span></a>
                
            </div>
            @endIf

            @if(session('crr_report_lead_id') && session('crr_report_lead_id') !== 'all')

            <div id="crr-filter-mine" class="uk-badge uk-text-right@s badge-filter">
                <a onClick="loadTab('/dashboard/reports?crr_report_lead_id=all', '3','','','',1);" class="uk-dark uk-light"><i class="a-circle-cross"></i> <span>{{ $crrLeadSelection }}</span></a>
                
            </div>
            @endIf
            <div style="display:inline-block" id="report-refreshing"></div>
            
        </div>
        <hr class="dashed-hr uk-width-1-1 uk-margin-bottom">
        <input type="hidden" id="crr-newest" value="{{date('Y-m-d g:h:i',time())}}">
    @if(count($reports))
        <style type="text/css">
            .calendar-button {
                    position: relative;
                    top: 4px;
                    font-size: 16px;
            }
        </style>
        <div class="uk-width-1-1">
            <table class="uk-table " id="crr-report-list">
                <thead>

                    
                    <th ><strong>REPORT</strong></th>
                    <th ><strong>PROJECT</strong></th>
                
                    <th  width="100px"><strong>AUDIT</strong></th>
                
                    <th ><strong>LEAD</strong></th>
                
                    <th ><strong>TYPE</strong></th>

                    <th width="120px"><strong>STATUS</strong></th>
                
                    <th  width="80px"><strong>ACTION</strong></th>

                    <th width="120px"><strong>CREATED</strong></th>

                    <th width="120px"><strong>LAST EDITED</strong></th>
                
                    <th width="120px"><strong>DUE DATE</strong></th>
                    @can('access_auditor')
                        <th width="40px" uk-tooltip title="Report History"><i class="a-person-clock"></i></th>
                    @endCan
               
            </thead>
            
                @include('dashboard.partials.reports-row')
            
        </table>
        {{$reports->links()}}
        <script>

    $(document).ready(function(){
   // your on click function here
       $('.page-link').click(function(){
               $('#detail-tab-3-content').load($(this).attr('href'));
               window.current_finding_type_page = $('#detail-tab-3-content').load($(this).attr('href'));
               return false;
           });
           
        // on doc ready we allow updates to start:
        $('#report-checking').val('0');
            
        });
    
        function searchReports(){
            $.get('/dashboard/reports?search=' + encodeURIComponent($("#reports-search").val()), function(data) {
                    
                        $('#detail-tab-3-content').load('/dashboard/reports');
                        
                    
            } );
        }

        // process search
        $(document).ready(function() {
            $('#reports-search').keydown(function (e) {
              if (e.keyCode == 13) {
                searchReports();
                e.preventDefault();
                return false; 
              }
            });
        });
        @can('access_auditor')
        function reportAction(reportId,action){
            window.crrActionReportId = reportId;
            if(action != 8){
                loadTab('/dashboard/reports?id='+reportId+'&action='+action, '3','','','',1);
            }else if(action == 8){
                UIkit.modal.confirm('Refreshing the dynamic data will set the report back to Draft status - are you sure you want to do this?').then(function(){
                    loadTab('/dashboard/reports?id='+window.crrActionReportId+'&action=8', '3','','','',1);
                },function(){
                    //nope
                });
            }
        }
        @endCan
        @if(count($messages))
            @forEach($messages as $message)
                UIkit.notification({
                    message: '{{$message}}',
                    status: 'success',
                    pos: 'top-right',
                    timeout: 3000
                });
            @endForEach
        @endif

        </script>
        </div>
  
    @else
        <div class="uk-width-1-1">
            <div uk-grid>
            	<div class="uk-width-1-3"></div>
                <div class=" uk-width-1-3 uk-first-row">
                	<article class="uk-comment">
					    <header class="uk-comment-header uk-grid-medium uk-flex-middle" uk-grid>
					        <div class="uk-width-auto">
					            <h1><i class="a-file-fail"></i></h1>
					        </div>
					        <div class="uk-width-expand">
					            <h4 class="uk-comment-title uk-margin-remove"><a class="uk-link-reset" href="#">SORRY!</a></h4>
					            <ul class="uk-comment-meta uk-subnav uk-subnav-divider uk-margin-remove-top">
					                <li><a href="#">No Reports Found</a></li>
					            </ul>
					        </div>
					    </header>
					    <div class="uk-comment-body">
					        
					    </div>
					</article>
                	
                </div>
            </div>
        </div>
    @endif
    </div>
</div>
<?php // keep this script at the bottom of page to ensure the tabs behave appropriately ?>
<script>
	window.reportsLoaded = 1;
</script>
<?php // end script keep ?>