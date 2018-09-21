<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Session;
use App\LogConverter;

class AuditController extends Controller
{
	public function __construct()
    {
        // $this->middleware('auth');
    	// Auth::onceUsingId(1); // TEST BRIAN
    }

    public function buildingsFromAudit($audit, Request $request)
    {
    	$target = $request->get('target');
    	$buildings = collect([
    					[
    						'id' => 1, 
    						'status' => 'critical',
    						'street' => '123457 Silvegwood Street', 
    						'city' => 'Columbus', 
    						'state' => 'OH', 
    						'zip' => '43219', 
    						'auditors' => [
    							['name' => 'Brian Greenwood',
    							'initials' => 'BG',
    							'color' => 'green',
    							'status' => 'warning'],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => '']
    						],
    						'type' => 'building',
    						'areas' => [
    							['type' => 'Elevators', 'qty' => 2, 'status' => 'pending'],
    							['type' => 'ADA', 'qty' => null, 'status' => 'inspected'],
    							['type' => 'Floors', 'qty' => 2, 'status' => 'pending'],
    							['type' => 'Common Areas', 'qty' => 2, 'status' => 'inspected'],
    							['type' => 'Fitness Room', 'qty' => 1, 'status' => 'action']
    						]
    					],
    					[
    						'id' => 2, 
    						'status' => 'action-needed',
    						'street' => '123466 Silvegwood Street', 
    						'city' => 'Columbus', 
    						'state' => 'OH', 
    						'zip' => '43219', 
    						'auditors' => [
    							['name' => 'Brian Greenwood',
    							'initials' => 'BG',
    							'color' => 'green',
    							'status' => 'warning'],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Brian Greenwood',
    							'initials' => 'BG',
    							'color' => 'green',
    							'status' => 'warning'],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Brian Greenwood',
    							'initials' => 'BG',
    							'color' => 'green',
    							'status' => 'warning'],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => '']
    						],
    						'type' => 'pool',
    						'areas' => [
    							['type' => 'Elevators', 'qty' => 2, 'status' => 'pending'],
    							['type' => 'ADA', 'qty' => null, 'status' => 'inspected'],
    							['type' => 'Floors', 'qty' => 2, 'status' => 'pending'],
    							['type' => 'Common Areas', 'qty' => 2, 'status' => 'inspected'],
    							['type' => 'Fitness Room', 'qty' => 1, 'status' => 'action']
    						]
    					],
    					[
    						'id' => 3, 
    						'status' => 'in-progress',
    						'street' => '123466 Silvegwood Street', 
    						'city' => 'Columbus', 
    						'state' => 'OH', 
    						'zip' => '43219', 
    						'auditors' => [
    							['name' => 'Brian Greenwood',
    							'initials' => 'BG',
    							'color' => 'green',
    							'status' => 'warning'],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => '']
    						],
    						'type' => 'building',
    						'areas' => [
    							['type' => 'Elevators', 'qty' => 2, 'status' => 'pending'],
    							['type' => 'ADA', 'qty' => null, 'status' => 'inspected'],
    							['type' => 'Floors', 'qty' => 2, 'status' => 'pending'],
    							['type' => 'Common Areas', 'qty' => 2, 'status' => 'inspected'],
    							['type' => 'Fitness Room', 'qty' => 1, 'status' => 'action']
    						]
    					],
    					[
    						'id' => 4, 
    						'status' => 'ok-actionable',
    						'street' => '123466 Silvegwood Street', 
    						'city' => 'Columbus', 
    						'state' => 'OH', 
    						'zip' => '43219', 
    						'auditors' => [
    							['name' => 'Brian Greenwood',
    							'initials' => 'BG',
    							'color' => 'green',
    							'status' => 'warning'],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Brian Greenwood',
    							'initials' => 'BG',
    							'color' => 'green',
    							'status' => 'warning'],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Brian Greenwood',
    							'initials' => 'BG',
    							'color' => 'green',
    							'status' => 'warning'],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Brian Greenwood',
    							'initials' => 'BG',
    							'color' => 'green',
    							'status' => 'warning'],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Brian Greenwood',
    							'initials' => 'BG',
    							'color' => 'green',
    							'status' => 'warning'],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => '']
    						],
    						'type' => 'building',
    						'areas' => [
    							['type' => 'Elevators', 'qty' => 2, 'status' => 'pending'],
    							['type' => 'ADA', 'qty' => null, 'status' => 'inspected'],
    							['type' => 'Floors', 'qty' => 2, 'status' => 'pending'],
    							['type' => 'Common Areas', 'qty' => 2, 'status' => 'inspected'],
    							['type' => 'Fitness Room', 'qty' => 1, 'status' => 'action']
    						]
    					],
    					[
    						'id' => 5, 
    						'status' => '',
    						'street' => '123466 Silvegwood Street', 
    						'city' => 'Columbus', 
    						'state' => 'OH', 
    						'zip' => '43219', 
    						'auditors' => [
    							['name' => 'Brian Greenwood',
    							'initials' => 'BG',
    							'color' => 'green',
    							'status' => 'warning'],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => '']
    						],
    						'type' => 'building',
    						'areas' => [
    							['type' => 'Elevators', 'qty' => 2, 'status' => 'pending'],
    							['type' => 'ADA', 'qty' => null, 'status' => 'inspected'],
    							['type' => 'Floors', 'qty' => 2, 'status' => 'pending'],
    							['type' => 'Common Areas', 'qty' => 2, 'status' => 'inspected'],
    							['type' => 'Fitness Room', 'qty' => 1, 'status' => 'action']
    						]
    					],
    					[
    						'id' => 6, 
    						'status' => '',
    						'street' => '123466 Silvegwood Street', 
    						'city' => 'Columbus', 
    						'state' => 'OH', 
    						'zip' => '43219', 
    						'auditors' => [
    							['name' => 'Brian Greenwood',
    							'initials' => 'BG',
    							'color' => 'green',
    							'status' => 'warning'],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => '']
    						],
    						'type' => 'pool',
    						'areas' => [
    							['type' => 'Elevators', 'qty' => 2, 'status' => 'pending'],
    							['type' => 'ADA', 'qty' => null, 'status' => 'inspected'],
    							['type' => 'Floors', 'qty' => 2, 'status' => 'pending'],
    							['type' => 'Common Areas', 'qty' => 2, 'status' => 'inspected'],
    							['type' => 'Fitness Room', 'qty' => 1, 'status' => 'action']
    						]
    					],
    					[
    						'id' => 7, 
    						'status' => '',
    						'street' => '123466 Silvegwood Street', 
    						'city' => 'Columbus', 
    						'state' => 'OH', 
    						'zip' => '43219', 
    						'auditors' => [
    							['name' => 'Brian Greenwood',
    							'initials' => 'BG',
    							'color' => 'green',
    							'status' => 'warning'],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => '']
    						],
    						'type' => 'building',
    						'areas' => [
    							['type' => 'Elevators', 'qty' => 2, 'status' => 'pending'],
    							['type' => 'ADA', 'qty' => null, 'status' => 'inspected'],
    							['type' => 'Floors', 'qty' => 2, 'status' => 'pending'],
    							['type' => 'Common Areas', 'qty' => 2, 'status' => 'inspected'],
    							['type' => 'Fitness Room', 'qty' => 1, 'status' => 'action']
    						]
    					]
    				]);

    	return view('dashboard.partials.audit_buildings', compact('audit', 'target', 'buildings'));
    }

    public function detailsFromBuilding($audit, $building, Request $request) {
    	$target = $request->get('target');
    	$targetaudit = $request->get('targetaudit');
    	$details = collect([
    						[
    						'id' => 1, 
    						'status' => 'critical',
    						'street' => '123457 Silvegwood Street', 
    						'city' => 'Columbus', 
    						'state' => 'OH', 
    						'zip' => '43219', 
    						'auditors' => [
    							['name' => 'Brian Greenwood',
    							'initials' => 'BG',
    							'color' => 'green',
    							'status' => 'warning'],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => '']
    						],
    						'type' => 'building',
    						'areas' => [
    							['type' => 'Elevators', 'qty' => 2, 'status' => 'pending'],
    							['type' => 'ADA', 'qty' => null, 'status' => 'inspected'],
    							['type' => 'Floors', 'qty' => 2, 'status' => 'pending'],
    							['type' => 'Common Areas', 'qty' => 2, 'status' => 'inspected'],
    							['type' => 'Fitness Room', 'qty' => 1, 'status' => 'action']
    						]
    					],
    					[
    						'id' => 2, 
    						'status' => 'action-needed',
    						'street' => '123466 Silvegwood Street', 
    						'city' => 'Columbus', 
    						'state' => 'OH', 
    						'zip' => '43219', 
    						'auditors' => [
    							['name' => 'Brian Greenwood',
    							'initials' => 'BG',
    							'color' => 'green',
    							'status' => 'warning'],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Brian Greenwood',
    							'initials' => 'BG',
    							'color' => 'green',
    							'status' => 'warning'],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Brian Greenwood',
    							'initials' => 'BG',
    							'color' => 'green',
    							'status' => 'warning'],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => '']
    						],
    						'type' => 'pool',
    						'areas' => [
    							['type' => 'Elevators', 'qty' => 2, 'status' => 'pending'],
    							['type' => 'ADA', 'qty' => null, 'status' => 'inspected'],
    							['type' => 'Floors', 'qty' => 2, 'status' => 'pending'],
    							['type' => 'Common Areas', 'qty' => 2, 'status' => 'inspected'],
    							['type' => 'Fitness Room', 'qty' => 1, 'status' => 'action']
    						]
    					],
    					[
    						'id' => 3, 
    						'status' => 'in-progress',
    						'street' => '123466 Silvegwood Street', 
    						'city' => 'Columbus', 
    						'state' => 'OH', 
    						'zip' => '43219', 
    						'auditors' => [
    							['name' => 'Brian Greenwood',
    							'initials' => 'BG',
    							'color' => 'green',
    							'status' => 'warning'],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => ''],
    							['name' => 'Another Name',
    							'initials' => 'AN',
    							'color' => 'blue',
    							'status' => '']
    						],
    						'type' => 'building',
    						'areas' => [
    							['type' => 'Elevators', 'qty' => 2, 'status' => 'pending'],
    							['type' => 'ADA', 'qty' => null, 'status' => 'inspected'],
    							['type' => 'Floors', 'qty' => 2, 'status' => 'pending'],
    							['type' => 'Common Areas', 'qty' => 2, 'status' => 'inspected'],
    							['type' => 'Fitness Room', 'qty' => 1, 'status' => 'action']
    						]
    					]
    				]);

    	return view('dashboard.partials.audit_building_details', compact('audit', 'target', 'building', 'details', 'targetaudit'));
    }

    public function inspectionFromBuildingDetail($audit_id, $building_id, $detail_id, Request $request) {
    	$target = $request->get('target');
        $rowid = $request->get('rowid');
    	$inspection = "test";
        $data['detail'] = collect([
                            'id' => 1, 
                            'status' => 'critical',
                            'street' => '123457 Silvegwood Street', 
                            'city' => 'Columbus', 
                            'state' => 'OH', 
                            'zip' => '43219', 
                            'auditors' => [
                                ['name' => 'Brian Greenwood',
                                'initials' => 'BG',
                                'color' => 'green',
                                'status' => 'warning'],
                                ['name' => 'Another Name',
                                'initials' => 'AN',
                                'color' => 'blue',
                                'status' => '']
                            ],
                            'type' => 'building',
                            'areas' => [
                                ['type' => 'Elevators', 'qty' => 2, 'status' => 'pending'],
                                ['type' => 'ADA', 'qty' => null, 'status' => 'inspected'],
                                ['type' => 'Floors', 'qty' => 2, 'status' => 'pending'],
                                ['type' => 'Common Areas', 'qty' => 2, 'status' => 'inspected'],
                                ['type' => 'Fitness Room', 'qty' => 1, 'status' => 'action']
                            ]
                    ]);
        // ok-actionable, no-action, action-needed, action-required, in-progress, critical
        $data['menu'] = collect([
                            ['name' => 'SITE AUDIT', 'icon' => 'a-mobile-home', 'status' => 'critical active', 'style' => ''],
                            ['name' => 'FILE AUDIT', 'icon' => 'a-folder', 'status' => 'action-required', 'style' => ''],
                            ['name' => 'MESSAGES', 'icon' => 'a-envelope-incoming', 'status' => 'action-needed', 'style' => ''],
                            ['name' => 'FOLLOW UPS', 'icon' => 'a-bell-2', 'status' => 'no-action', 'style' => ''],
                            ['name' => 'SUBMIT', 'icon' => 'a-avatar-star', 'status' => 'in-progress', 'style' => 'margin-top:30px;'],
                    ]);
    	$data['areas'] = collect([
    						[
	    						'id' => 1, 
	    						'status' => 'action-needed',
	    						'name' => 'Stair #1', 
	    						'auditor' => [
	    							'name' => 'Brian Greenwood',
	    							'initials' => 'BG',
	    							'color' => 'green',
	    							'status' => 'warning'
	    						],
                                'findings' => [
                                    'nltstatus' => 'action-needed',
                                    'ltstatus' => 'action-required',
                                    'sdstatus' => 'no-action',
                                    'photostatus' => '',
                                    'commentstatus' => '',
                                    'copystatus' => 'no-action',
                                    'trashstatus' => ''
                                ]
	    					],
    						[
	    						'id' => 2, 
	    						'status' => 'critical',
	    						'name' => 'Bedroom #1', 
	    						'auditor' => [
	    							'name' => 'Brian Greenwood',
	    							'initials' => 'BG',
	    							'color' => 'yellow',
	    							'status' => 'warning'
	    						],
                                'findings' => [
                                    'nltstatus' => 'action-needed',
                                    'ltstatus' => 'action-required',
                                    'sdstatus' => 'no-action',
                                    'photostatus' => '',
                                    'commentstatus' => '',
                                    'copystatus' => 'no-action',
                                    'trashstatus' => ''
                                ]
	    					],
                            [
                                'id' => 3, 
                                'status' => 'in-progress',
                                'name' => 'Bedroom #2', 
                                'auditor' => [
                                    'name' => 'Brian Greenwood',
                                    'initials' => 'BG',
                                    'color' => 'pink',
                                    'status' => 'warning'
                                ],
                                'findings' => [
                                    'nltstatus' => 'action-needed',
                                    'ltstatus' => 'action-required',
                                    'sdstatus' => 'no-action',
                                    'photostatus' => '',
                                    'commentstatus' => '',
                                    'copystatus' => 'no-action',
                                    'trashstatus' => ''
                                ]
                            ]
    				]);
        return response()->json($data);
    	//return view('dashboard.partials.audit_building_inspection', compact('audit_id', 'target', 'detail_id', 'building_id', 'detail', 'inspection', 'areas', 'rowid'));
    }
}