<div class="uk-width-1-6 uk-padding-remove">
							<div class="uk-padding-remove uk-flex">
								<div id="building-{{ $context }}-{{ $target }}-c-1-{{ $key }}" class="uk-inline " style="min-width: 16px; padding: 0 3px;">
									<div class="linespattern"></div>
									<span id="building-{{ $context }}-rid-1" class="uk-position-bottom-center colored"><small>#<span class="rowindex">{{ $loop->iteration }} </span></small></span>
								</div>

								<div id="building-{{ $context }}-{{ $target }}-c-2-{{ $key }}" class="building-type">
									<div class="uk-padding-remove building-type-top uk-height-1-1" uk-grid>
										<div class="uk-width-3-4 uk-padding-remove">
											<div uk-grid>
												<div class="uk-width-1-1 uk-padding-remove">
													<div uk-grid style="padding-top:10px;">
														<div id="building-auditors-{{ $building->building_id }}" class="building-auditors uk-width-1-2 @if($building_auditors && count($building_auditors)) hasAuditors @endif">
															@if($building_auditors && count($building_auditors) && $auditor_exists)
															<div uk-slideshow="animation: slide; min-height:90;">
																<div class="uk-position-relative uk-visible-toggle">
																	<ul class="uk-slideshow-items" style="min-height: 90px;">
																		<li class="uk-active uk-transition-active" style="transform: translateX(0px);">
																			<div uk-grid>
																				@foreach($building_auditors as $auditor)
																				<div class="building-auditor uk-width-1-2 uk-margin-remove">
																					@if($building->building_id === NULL)
																					<div id="building-{{ $context }}-{{ $auditor->id }}-avatar-{{ $loop->iteration }}" uk-tooltip="pos:top-left;title:{{ $auditor->full_name() }};" title="" aria-expanded="false" class="auditor-badge auditor-badge-{{ $auditor->badge_color }} use-hand-cursor no-float" onclick="swapAuditor({{ $auditor->id }}, {{ $audit }}, 0, 0, 'building-audits-{{ $auditor->id }}-avatar-1', {{ $building->amenity_inspection_id }})">
																						{{ $auditor->initials() }}
																					</div>
																					@else
																					<div id="building-{{ $context }}-{{ $target }}-avatar-{{ $loop->iteration }}" uk-tooltip="pos:top-left;title:{{ $auditor->full_name() }};" title="" aria-expanded="false" class="auditor-badge auditor-badge-{{ $auditor->badge_color }} use-hand-cursor no-float" onclick="swapAuditor({{ $auditor->id }}, {{ $audit }}, {{ $building->building_id }}, 0, 'building-auditors-{{ $building->amenity_inspection_id }}')">
																						{{ $auditor->initials() }}
																					</div>
																					@endif
																					@if($auditor->status != '')
																					<div class="auditor-status"><span></span></div>
																					@endif
																				</div>
																				@if($loop->iteration % 6 == 0 && $loop->iteration < count($building_auditors) )
																			</div>
																		</li>
																		<li>
																			<div uk-grid>
																				@endif
																				@endforeach
																			</div>
																		</li>
																	</ul>
																</div>
																<ul class="uk-slideshow-nav uk-dotnav uk-flex-center"></ul>
															</div>
															@else
															<div uk-slideshow="animation: slide; min-height:90;">
																<div class="uk-position-relative uk-visible-toggle">
																	<ul class="uk-slideshow-items" style="min-height: 90px;">
																		<li class="uk-active uk-transition-active" style="transform: translateX(0px);">
																			<div uk-grid>
																				@php
																				$rand = mt_rand();
																				@endphp
																				<div class="building-auditor uk-width-1-2 uk-margin-remove">
																					<div id="building-auditor-{{ $rand }}" class="building-auditor uk-width-1-2 uk-margin-remove">
																						@if($building->building_id === NULL)
																						<i class="a-avatar-plus_1 use-hand-cursor" uk-tooltip="pos:top-left;title:ASSIGN AUDITOR;" onclick="assignAuditor({{ $audit }}, 0, 0, {{ $building->amenity_inspection_id }}, 'building-auditor-{{ $rand }}');"></i>
																						@else
																						<i class="a-avatar-plus_1 use-hand-cursor" uk-tooltip="pos:top-left;title:ASSIGN AUDITOR;" onclick="assignAuditor({{ $audit }}, {{ $building->building_id }}, 0, 0, 'building-auditor-{{ $rand }}');"></i>
																						@endif
																					</div>
																				</div>
																			</div>
																		</li>
																	</ul>
																</div>
																<ul class="uk-slideshow-nav uk-dotnav uk-flex-center"></ul>
															</div>
															@endif
														</div>
														<div class="uk-width-1-2 uk-padding-remove">
															<div class="building-type-icon " uk-tooltip="pos:top-left;title:Building ID {{ $building->id }};">
																@if($building->type == "pool")
																<i class="a-pool colored"></i>
																@else
																<i class="a-buildings colored"></i>
																@endif
															</div>
															<div class="building-status">
																<span class="uk-badge colored" uk-tooltip="pos:top-left;" title="@if($b_findings_total > 0)
																	{{ $b_findings_total }} FINDINGS
																	@else NO FINDINGS @endIf">{{ $b_findings_total }}
																</span>
															</div>
														</div>
													</div>
												</div>
												<div id="inspection-{{ $context }}-menus-{{ $key }}-container" class="uk-width-1-1 uk-margin-remove building-type-bottom" style="display:none;">
													<div id="inspection-{{ $context }}-menus-{{ $key }}"></div>
												</div>
											</div>
										</div>
										<div class="uk-width-1-4 uk-padding-remove uk-text-right">
											<div class=" @if($loop->last) journey-end @elseif($loop->first) journey-start @else journey @endif">
												<i class="@if($loop->last) a-home-marker @elseif($loop->first) a-home-marker @else a-marker-basic @endif colored"></i>
												@if($building->followup_date !== null)
												<div class="alert-icon {{ $building->status }}">
													
													@if($dueDate < $today)
													<i class="a-bell-ring" uk-tooltip="pos:top-left;title:PAST DUE<br />FOLLOWUP: {{ \Carbon\Carbon::createFromFormat('Y-m-d', $building->followup_date)->format('m/d/Y') }}: {{ $building->followup_description }};"></i>
													@elseIf($dueDate === $today)
													<i class="a-bell-ring" uk-tooltip="pos:top-left;title:DUE TODAY<br />FOLLOWUP: {{ \Carbon\Carbon::createFromFormat('Y-m-d', $building->followup_date)->format('m/d/Y') }}: {{ $building->followup_description }};"></i>
													@else
													<i class="a-bell-2" uk-tooltip="pos:top-left;title:FOLLOWUP: {{ \Carbon\Carbon::createFromFormat('Y-m-d', $building->followup_date)->format('m/d/Y') }}: {{ $building->followup_description }};"></i>
													@endIf
												</div>
												@else
												<div style="margin-top: 12px;">
													<i class="a-bell" uk-tooltip="pos:top-left;title:NO INCOMPLETE FOLLOWUPS;"></i>
												</div>
												@endif
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						{{-- Here is that code --}}
						<div class="uk-width-5-6 uk-padding-remove">
							<div uk-grid>
								<div class="uk-width-3-5">
									<div id="building-{{ $context }}-{{ $target }}-c-3-{{ $key }}" class="uk-margin-remove" style="flex: 750px;" uk-grid>
										<div class="uk-width-1-1">
											<div uk-grid>
												<div class="uk-width-3-5 uk-padding-remove">
													<div class="building-address" uk-grid>
														<div class="uk-width-1-1 uk-padding-remove">
															@if($building->building_name)
															<h3 class="uk-margin-bottom-remove colored">{{ $building->building_name }}</h3>
															<small class="colored">
																{{ $building->address }}, {{ $building->city }}, {{ $building->state }} {{ $building->zip }}
															</small>
															@else
															<h3 class="uk-margin-bottom-remove colored">{{ $building->address }}</h3>
															<small class="colored">{{ $building->city }}, {{ $building->state }} {{ $building->zip }}</small>
															@endif

															@if($building->type != "pool")
															<br />
															@if($building->building_id != '' && $building->type_total > 0)
															<small class="colored use-hand-cursor" onclick="buildingDetails({{ $building->building_id }},{{ $audit }},{{ $key }},{{ $target }},10,'{{ $context }}');" uk-tooltip="pos:top-left;title:Building details;" ><i class="a-menu colored uk-text-middle"></i>
																@if($building->type_total > 0)
																<span class="uk-text-middle uk-text-uppercase">{{ $building->type_total }} @if($building->type_total > 1) {{ $building->type_text_plural }} @else {{ $building->type_text }} @endif</span>
																@endif
															</small>
															@endif
															@endif
														</div>
													</div>
												</div>
												<div class="uk-width-2-5 uk-padding-remove uk-margin-small-top">
													<div uk-grid>
														<div class="uk-width-1-1 findings-icons" uk-grid style="margin-top: 0px;">
															<div class="uk-width-1-3 uk-padding-remove-top uk-margin-remove-top uk-text-center {{ $building->finding_file_status }} action-needed">
																@if($building->building_id)
																<div class="findings-icon" onclick="openFindings(this, {{ $audit }}, {{ $building->building_id }}, null, 'file', null, @if($building->building_id) '0' @else '1' @endif);">
																	<i class="a-folder"></i>
																	<div class="findings-icon-status">
																		@if($building->finding_file_completed == 0)
																		<span class="uk-badge {{ $building->finding_file_status }}" uk-tooltip="pos:top-left;title:Unit # finding;">{{ ($building->finding_file_total) ? $building->finding_file_total : 0 }}</span>
																		@else
																		<i class="a-rotate-left {{ $building->finding_file_status }}" uk-tooltip="pos:top-left;title:{{ $building->finding_file_total - $building->finding_file_completed }} in progress<br />{{ $building->finding_file_completed }} completed;"></i>
																		@endif
																	</div>
																</div>
																@elseIf($building->amenity())

																<i id="completed-building-amenity-{{$audit}}{{$building->amenity()->id}}" class="@if($building->amenity()->completed_date_time) a-circle-checked @else a-circle @endif completion-icon completion-icon-big use-hand-cursor" uk-tooltip="title:CLICK TO COMPLETE" onclick="markAmenityComplete({{$audit}}, null, null, {{$building->amenity()->id}}, 'completed-building-amenity-{{$audit}}{{$building->amenity()->id}}',1)" title="" aria-expanded="false"></i>
																@endif
															</div>
															<div class="uk-width-1-3 uk-padding-remove-top uk-margin-remove-top uk-text-center {{ $building->finding_nlt_status }}">
																<div class="findings-icon" onclick="openFindings(this, {{ $audit }}, {{ $building->id }}, null, 'nlt', null, @if($building->building_id) '0' @else '1' @endif);">
																	<i class="a-booboo"></i>
																	<div class="findings-icon-status">
																		@if($building->finding_nlt_completed == 0)
																		<span class="uk-badge {{ $building->finding_nlt_status }}" uk-tooltip="pos:top-left;title:Unit # finding;">{{ $building->finding_nlt_total }}</span>
																		@else
																		<i class="a-rotate-left {{ $building->finding_nlt_status }}" uk-tooltip="pos:top-left;title:{{ $building->finding_nlt_total - $building->finding_nlt_completed }} in progress<br />{{ $building->finding_nlt_completed }} completed;"></i>
																		@endif
																	</div>
																</div>
															</div>
															<div class="uk-width-1-3 uk-padding-remove-top uk-margin-remove-top uk-text-center {{ $building->finding_lt_status }}">
																<div class="findings-icon" onclick="openFindings(this, {{ $audit }}, {{ $building->id }}, null, 'lt', null, @if($building->building_id) '0' @else '1' @endif);">
																	<i class="a-skull" uk-tooltip="pos:top-left;title:Reason;"></i>
																	<div class="findings-icon-status">
																		@if($building->finding_lt_completed == 0)
																		<span class="uk-badge {{ $building->finding_lt_status }}" uk-tooltip="pos:top-left;title:Unit # finding;">{{ $building->finding_lt_total }}</span>
																		@else
																		<i class="a-rotate-left {{ $building->finding_lt_status }}" uk-tooltip="pos:top-left;title:{{ $building->finding_lt_total - $building->finding_lt_completed }} in progress<br />{{ $building->finding_lt_completed }} completed;"></i>
																		@endif
																	</div>
																</div>
															</div>
														</div>
														<div class="uk-width-1-1 uk-margin-remove findings-action ok-actionable" style="margin-top: 0px;">
															@if($building->building_id !== NULL)
															<button class="uk-button program-status uk-link" onclick="@if($building->building_id) inspectionDetailsFromBuilding({{ $building->building_id }}, {{ $audit }}, {{ $key }},{{ $target }}, {{ $loop->iteration }},'{{ $context }}'); @else inspectionDetailsFromBuilding(0, {{ $audit }}, {{ $key }},{{ $target }}, {{ $loop->iteration }},'{{ $context }}'); @endif"><i class="a-home-search"></i> INSPECT BUILDING</button>
															@endif
														</div>
													</div>
												</div>
											</div>
										</div>
										<div id="inspection-{{ $context }}-main-{{ $key }}-container" class="uk-width-1-1 uk-margin-remove-top uk-padding-remove" style="display:none;">
											<div id="inspection-{{ $context }}-main-{{ $key }}" class="inspection-main-list"></div>
										</div>
									</div>
								</div>
								<div class="uk-width-2-5 uk-flex">
									<div id="building-{{ $context }}-{{ $target }}-c-5-{{ $key }}" style="flex: 640px;" class="uk-margin-remove" uk-grid>
										<div class="uk-width-1-1" id="inspection-{{ $context }}-tools-switch-{{ $key }}">
											@if($b_amenity_findings && count($b_amenity_findings) > 0)
											<div uk-grid class="area-status-list">
												@foreach($b_amenity_findings as $amenity)
												@if($loop->iteration < 9)
												<div class="uk-width-1-3 use-hand-cursor uk-padding-remove-top uk-margin-remove-top area-status colored @if($amenity['status'] != '') area-status-{{ $amenity['status'] }} @endif "  onclick="openFindings(this, {{ $audit }}, {{ $building->building_id }}, 0, 'all', {{ $amenity['id'] }});">
													<span class="uk-badge">@if($amenity['completed'] == 1) <i class="a-check"></i> @else {{ $amenity['findings_total'] }} @endif</span>
													{{ $amenity['name'] }}
												</div>
												@else
												@if($loop->iteration == 9)
												<div class="uk-width-1-3 uk-padding-remove-top uk-margin-remove-top area-status colored @if($amenity['status'] != '') area-status-{{ $amenity['status'] }} @endif">
													<span class="uk-badge" uk-tooltip="pos:top-left;title: @endif {{ $amenity['findings_total'] }} {{ $amenity['name'] }}<br /> @if($loop->last) ;"><i class="a-plus"></i> </span> MORE...
												</div>
												@endif
												@endif
												@endforeach
											</div>
											@else
											<div class="uk-inline uk-padding-remove uk-float-right" style="margin-top: 7px;">
												@if($b_amenity)
												<div class="findings-icon toplevel uk-inline uk-margin-right" onclick="copyAmenity('', {{ $audit }}, 0, 0, {{ $b_amenity->id }}, 1);">
													<i class="a-file-copy-2"></i>
													<div class="findings-icon-status toplevel plus">
														<span class="uk-badge">+</span>
													</div>
												</div>
												@endIf
												<div class="findings-icon toplevel uk-inline  uk-margin-right" onclick="deleteAmenity('building-{{ $context }}-r-{{ $key }}', {{ $audit }}, 0, 0, {{ $building->amenity_inspection_id }}, 0, 1);">
													<i class="a-trash-4"></i>
													<div class="findings-icon-status toplevel plus">
														<span class="uk-badge">-</span>
													</div>
												</div>

											</div>
											@endif

										</div>
										<div id="inspection-{{ $context }}-tools-{{ $key }}-container" class="uk-width-1-1 uk-margin-remove-top uk-padding-remove" style="display:none;">
											<div id="inspection-{{ $context }}-tools-{{ $key }}"></div>
										</div>
									</div>
									<div id="building-{{ $context }}-{{ $target }}-c-6-{{ $key }}">
										<div uk-grid class="building-history">
											<div class="uk-width-1-1">
												<i class="a-person-clock colored uk-link"></i>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div> 