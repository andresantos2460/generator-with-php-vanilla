<?php
require 'db_connection.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit(); 
}


?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="canonical" href="http://apps/user-management/users/list.html" />
		<link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
		<link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
		<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Generator</title>
</head>
<body>
    <div class="container pt-5">
      <?php
      if (isset($_SESSION['user_code'])) {
        echo ' <div style="background-color: #edfbd8 !important; position:relative;" class="alert alert-success" id="alert-modal" role="alert">
                <svg style="position:absolute; top:15px; right:15px;" xmlns="http://www.w3.org/2000/svg" width="22" height="22" id="close-button" fill="#2b641e" class="bi bi-x" viewBox="0 0 16 16">
  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
</svg>
            <h4 style="color: #2b641e;" class="alert-heading">Código:<b class="ms-2" id="myInput" data-code='.$_SESSION['user_code'].'>'.$_SESSION['user_code'].'</b></h4>
            <p>Vais Precisar deste código sempre que pretenderes visualizar e eliminar uma password!</p>
            <hr />
            <div class="">
                <div>
                    <button onclick="myFunction()" class="copy-button">
                        <span>
                            <svg
                                width="12"
                                height="12"
                                fill="#0E418F"
                                xmlns="http://www.w3.org/2000/svg"
                                shape-rendering="geometricPrecision"
                                text-rendering="geometricPrecision"
                                image-rendering="optimizeQuality"
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                viewBox="0 0 467 512.22"
                            >
                                <path
                                    fill-rule="nonzero"
                                    d="M131.07 372.11c.37 1 .57 2.08.57 3.2 0 1.13-.2 2.21-.57 3.21v75.91c0 10.74 4.41 20.53 11.5 27.62s16.87 11.49 27.62 11.49h239.02c10.75 0 20.53-4.4 27.62-11.49s11.49-16.88 11.49-27.62V152.42c0-10.55-4.21-20.15-11.02-27.18l-.47-.43c-7.09-7.09-16.87-11.5-27.62-11.5H170.19c-10.75 0-20.53 4.41-27.62 11.5s-11.5 16.87-11.5 27.61v219.69zm-18.67 12.54H57.23c-15.82 0-30.1-6.58-40.45-17.11C6.41 356.97 0 342.4 0 326.52V57.79c0-15.86 6.5-30.3 16.97-40.78l.04-.04C27.51 6.49 41.94 0 57.79 0h243.63c15.87 0 30.3 6.51 40.77 16.98l.03.03c10.48 10.48 16.99 24.93 16.99 40.78v36.85h50c15.9 0 30.36 6.5 40.82 16.96l.54.58c10.15 10.44 16.43 24.66 16.43 40.24v302.01c0 15.9-6.5 30.36-16.96 40.82-10.47 10.47-24.93 16.97-40.83 16.97H170.19c-15.9 0-30.35-6.5-40.82-16.97-10.47-10.46-16.97-24.92-16.97-40.82v-69.78zM340.54 94.64V57.79c0-10.74-4.41-20.53-11.5-27.63-7.09-7.08-16.86-11.48-27.62-11.48H57.79c-10.78 0-20.56 4.38-27.62 11.45l-.04.04c-7.06 7.06-11.45 16.84-11.45 27.62v268.73c0 10.86 4.34 20.79 11.38 27.97 6.95 7.07 16.54 11.49 27.17 11.49h55.17V152.42c0-15.9 6.5-30.35 16.97-40.82 10.47-10.47 24.92-16.96 40.82-16.96h170.35z"
                                ></path>
                            </svg>
                            Copiar
                        </span>
                        <span>Copiado</span>
                    </button>
                    <div></div>
                </div>
            </div>
        </div>';
        unset($_SESSION['user_code']);
    }
      ?>
 	<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
						
						<div class="d-flex flex-column flex-column-fluid">
							
							<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
								
								<div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
									
									<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
										
										<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Users List</h1>
										
										
										<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
											
											<li class="breadcrumb-item text-muted">
												<a href="index.html" class="text-muted text-hover-primary">Home</a>
											</li>
											
											
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-500 w-5px h-2px"></span>
											</li>
											
											
											<li class="breadcrumb-item text-muted">User Management</li>
											
											
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-500 w-5px h-2px"></span>
											</li>
											
											
											<li class="breadcrumb-item text-muted">Users</li>
											
										</ul>
										
									</div>
									
									
									<div class="d-flex align-items-center gap-2 gap-lg-3">
										
									<form action="logout.php" method="POST">
                                        <button class="btn btn-danger">Logout</button>
                                    </form>
										
									</div>
									
								</div>
								
							</div>
							
							
							<div id="kt_app_content" class="app-content flex-column-fluid">
								
								<div id="kt_app_content_container" class="app-container container-xxl">
									
									<div class="card">
										
										<div class="card-header border-0 pt-6">
											
											<div class="card-title">
												
												<div class="d-flex align-items-center position-relative my-1">
													<i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
													<input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Search user" />
												</div>
												
											</div>
											
											
											<div class="card-toolbar">
												
												<div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
													
													<button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
													<i class="ki-duotone ki-filter fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>Filter</button>
													
													<div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
														
														<div class="px-7 py-5">
															<div class="fs-5 text-gray-900 fw-bold">Filter Options</div>
														</div>
														
														
														<div class="separator border-gray-200"></div>
														
														
														<div class="px-7 py-5" data-kt-user-table-filter="form">
															
															<div class="mb-10">
																<label class="form-label fs-6 fw-semibold">Role:</label>
																<select class="form-select form-select-solid fw-bold" data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true" data-kt-user-table-filter="role" data-hide-search="true">
																	<option></option>
																	<option value="Administrator">Administrator</option>
																	<option value="Analyst">Analyst</option>
																	<option value="Developer">Developer</option>
																	<option value="Support">Support</option>
																	<option value="Trial">Trial</option>
																</select>
															</div>
															
															
															<div class="mb-10">
																<label class="form-label fs-6 fw-semibold">Two Step Verification:</label>
																<select class="form-select form-select-solid fw-bold" data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true" data-kt-user-table-filter="two-step" data-hide-search="true">
																	<option></option>
																	<option value="Enabled">Enabled</option>
																</select>
															</div>
															
															
															<div class="d-flex justify-content-end">
																<button type="reset" class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6" data-kt-menu-dismiss="true" data-kt-user-table-filter="reset">Reset</button>
																<button type="submit" class="btn btn-primary fw-semibold px-6" data-kt-menu-dismiss="true" data-kt-user-table-filter="filter">Apply</button>
															</div>
															
														</div>
														
													</div>
													
													
													
													<button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_export_users">
													<i class="ki-duotone ki-exit-up fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>Export</button>
													
													
													<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
													<i class="ki-duotone ki-plus fs-2"></i>Add User</button>
													
												</div>
												
												
												<div class="d-flex justify-content-end align-items-center d-none" data-kt-user-table-toolbar="selected">
													<div class="fw-bold me-5">
													<span class="me-2" data-kt-user-table-select="selected_count"></span>Selected</div>
													<button type="button" class="btn btn-danger" data-kt-user-table-select="delete_selected">Delete Selected</button>
												</div>
												
												
												<div class="modal fade" id="kt_modal_export_users" tabindex="-1" aria-hidden="true">
													
													<div class="modal-dialog modal-dialog-centered mw-650px">
														
														<div class="modal-content">
															
															<div class="modal-header">
																
																<h2 class="fw-bold">Export Users</h2>
																
																
																<div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
																	<i class="ki-duotone ki-cross fs-1">
																		<span class="path1"></span>
																		<span class="path2"></span>
																	</i>
																</div>
																
															</div>
															
															
															<div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
																
																<form id="kt_modal_export_users_form" class="form" action="#">
																	
																	<div class="fv-row mb-10">
																		
																		<label class="fs-6 fw-semibold form-label mb-2">Select Roles:</label>
																		
																		
																		<select name="role" data-control="select2" data-placeholder="Select a role" data-hide-search="true" class="form-select form-select-solid fw-bold">
																			<option></option>
																			<option value="Administrator">Administrator</option>
																			<option value="Analyst">Analyst</option>
																			<option value="Developer">Developer</option>
																			<option value="Support">Support</option>
																			<option value="Trial">Trial</option>
																		</select>
																		
																	</div>
																	
																	
																	<div class="fv-row mb-10">
																		
																		<label class="required fs-6 fw-semibold form-label mb-2">Select Export Format:</label>
																		
																		
																		<select name="format" data-control="select2" data-placeholder="Select a format" data-hide-search="true" class="form-select form-select-solid fw-bold">
																			<option></option>
																			<option value="excel">Excel</option>
																			<option value="pdf">PDF</option>
																			<option value="cvs">CVS</option>
																			<option value="zip">ZIP</option>
																		</select>
																		
																	</div>
																	
																	
																	<div class="text-center">
																		<button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Discard</button>
																		<button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
																			<span class="indicator-label">Submit</span>
																			<span class="indicator-progress">Please wait... 
																			<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
																		</button>
																	</div>
																	
																</form>
																
															</div>
															
														</div>
														
													</div>
													
												</div>
												
												
												<div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">
													
													<div class="modal-dialog modal-dialog-centered mw-650px">
														
														<div class="modal-content">
															
															<div class="modal-header" id="kt_modal_add_user_header">
																
																<h2 class="fw-bold">Add User</h2>
																
																
																<div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
																	<i class="ki-duotone ki-cross fs-1">
																		<span class="path1"></span>
																		<span class="path2"></span>
																	</i>
																</div>
																
															</div>
															
															
															<div class="modal-body px-5 my-7">
																
																<form id="kt_modal_add_user_form" class="form" action="#">
																	
																	<div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
																		
																		<div class="fv-row mb-7">
																			
																			<label class="d-block fw-semibold fs-6 mb-5">Avatar</label>
																			
																			
																			<style>.image-input-placeholder { background-image: url('assets/media/svg/files/blank-image.svg'); } [data-bs-theme="dark"] .image-input-placeholder { background-image: url('assets/media/svg/files/blank-image-dark.svg'); }</style>
																			
																			
																			<div class="image-input image-input-outline image-input-placeholder" data-kt-image-input="true">
																				
																				<div class="image-input-wrapper w-125px h-125px" style="background-image: url(assets/media/avatars/300-6.jpg);"></div>
																				
																				
																				<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
																					<i class="ki-duotone ki-pencil fs-7">
																						<span class="path1"></span>
																						<span class="path2"></span>
																					</i>
																					
																					<input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
																					<input type="hidden" name="avatar_remove" />
																					
																				</label>
																				
																				
																				<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
																					<i class="ki-duotone ki-cross fs-2">
																						<span class="path1"></span>
																						<span class="path2"></span>
																					</i>
																				</span>
																				
																				
																				<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
																					<i class="ki-duotone ki-cross fs-2">
																						<span class="path1"></span>
																						<span class="path2"></span>
																					</i>
																				</span>
																				
																			</div>
																			
																			
																			<div class="form-text">Allowed file types: png, jpg, jpeg.</div>
																			
																		</div>
																		
																		
																		<div class="fv-row mb-7">
																			
																			<label class="required fw-semibold fs-6 mb-2">Full Name</label>
																			
																			
																			<input type="text" name="user_name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Full name" value="Emma Smith" />
																			
																		</div>
																		
																		
																		<div class="fv-row mb-7">
																			
																			<label class="required fw-semibold fs-6 mb-2">Email</label>
																			
																			
																			<input type="email" name="user_email" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="example@domain.com" value="smith@kpmg.com" />
																			
																		</div>
																		
																		
																		<div class="mb-5">
																			
																			<label class="required fw-semibold fs-6 mb-5">Role</label>
																			
																			
																			
																			<div class="d-flex fv-row">
																				
																				<div class="form-check form-check-custom form-check-solid">
																					
																					<input class="form-check-input me-3" name="user_role" type="radio" value="0" id="kt_modal_update_role_option_0" checked='checked' />
																					
																					
																					<label class="form-check-label" for="kt_modal_update_role_option_0">
																						<div class="fw-bold text-gray-800">Administrator</div>
																						<div class="text-gray-600">Best for business owners and company administrators</div>
																					</label>
																					
																				</div>
																				
																			</div>
																			
																			<div class='separator separator-dashed my-5'></div>
																			
																			<div class="d-flex fv-row">
																				
																				<div class="form-check form-check-custom form-check-solid">
																					
																					<input class="form-check-input me-3" name="user_role" type="radio" value="1" id="kt_modal_update_role_option_1" />
																					
																					
																					<label class="form-check-label" for="kt_modal_update_role_option_1">
																						<div class="fw-bold text-gray-800">Developer</div>
																						<div class="text-gray-600">Best for developers or people primarily using the API</div>
																					</label>
																					
																				</div>
																				
																			</div>
																			
																			<div class='separator separator-dashed my-5'></div>
																			
																			<div class="d-flex fv-row">
																				
																				<div class="form-check form-check-custom form-check-solid">
																					
																					<input class="form-check-input me-3" name="user_role" type="radio" value="2" id="kt_modal_update_role_option_2" />
																					
																					
																					<label class="form-check-label" for="kt_modal_update_role_option_2">
																						<div class="fw-bold text-gray-800">Analyst</div>
																						<div class="text-gray-600">Best for people who need full access to analytics data, but don't need to update business settings</div>
																					</label>
																					
																				</div>
																				
																			</div>
																			
																			<div class='separator separator-dashed my-5'></div>
																			
																			<div class="d-flex fv-row">
																				
																				<div class="form-check form-check-custom form-check-solid">
																					
																					<input class="form-check-input me-3" name="user_role" type="radio" value="3" id="kt_modal_update_role_option_3" />
																					
																					
																					<label class="form-check-label" for="kt_modal_update_role_option_3">
																						<div class="fw-bold text-gray-800">Support</div>
																						<div class="text-gray-600">Best for employees who regularly refund payments and respond to disputes</div>
																					</label>
																					
																				</div>
																				
																			</div>
																			
																			<div class='separator separator-dashed my-5'></div>
																			
																			<div class="d-flex fv-row">
																				
																				<div class="form-check form-check-custom form-check-solid">
																					
																					<input class="form-check-input me-3" name="user_role" type="radio" value="4" id="kt_modal_update_role_option_4" />
																					
																					
																					<label class="form-check-label" for="kt_modal_update_role_option_4">
																						<div class="fw-bold text-gray-800">Trial</div>
																						<div class="text-gray-600">Best for people who need to preview content data, but don't need to make any updates</div>
																					</label>
																					
																				</div>
																				
																			</div>
																			
																			
																		</div>
																		
																	</div>
																	
																	
																	<div class="text-center pt-10">
																		<button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Discard</button>
																		<button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
																			<span class="indicator-label">Submit</span>
																			<span class="indicator-progress">Please wait... 
																			<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
																		</button>
																	</div>
																	
																</form>
																
															</div>
															
														</div>
														
													</div>
													
												</div>
												
											</div>
											
										</div>
										
										
										<div class="card-body py-4">
											
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th class="w-10px pe-2">
															<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
																<input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_users .form-check-input" value="1" />
															</div>
														</th>
														<th class="min-w-125px">User</th>
														<th class="min-w-125px">Role</th>
														<th class="min-w-125px">Last login</th>
														<th class="min-w-125px">Two-step</th>
														<th class="min-w-125px">Joined Date</th>
														<th class="text-end min-w-100px">Actions</th>
													</tr>
												</thead>
												<tbody class="text-gray-600 fw-semibold">
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td class="d-flex align-items-center">
															
															<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
																<a href="apps/user-management/users/view.html">
																	<div class="symbol-label">
																		<img src="assets/media/avatars/300-6.jpg" alt="Emma Smith" class="w-100" />
																	</div>
																</a>
															</div>
															
															
															<div class="d-flex flex-column">
																<a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary mb-1">Emma Smith</a>
																<span>smith@kpmg.com</span>
															</div>
															
														</td>
														<td>Administrator</td>
														<td>
															<div class="badge badge-light fw-bold">Yesterday</div>
														</td>
														<td></td>
														<td>19 Aug 2024, 11:30 am</td>
														<td class="text-end">
															<a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-duotone ki-down fs-5 ms-1"></i></a>
															
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																
																<div class="menu-item px-3">
																	<a href="apps/user-management/users/view.html" class="menu-link px-3">Edit</a>
																</div>
																
																
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">Delete</a>
																</div>
																
															</div>
															
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td class="d-flex align-items-center">
															
															<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
																<a href="apps/user-management/users/view.html">
																	<div class="symbol-label fs-3 bg-light-danger text-danger">M</div>
																</a>
															</div>
															
															
															<div class="d-flex flex-column">
																<a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary mb-1">Melody Macy</a>
																<span>melody@altbox.com</span>
															</div>
															
														</td>
														<td>Analyst</td>
														<td>
															<div class="badge badge-light fw-bold">20 mins ago</div>
														</td>
														<td>
															<div class="badge badge-light-success fw-bold">Enabled</div>
														</td>
														<td>20 Dec 2024, 6:05 pm</td>
														<td class="text-end">
															<a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-duotone ki-down fs-5 ms-1"></i></a>
															
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																
																<div class="menu-item px-3">
																	<a href="apps/user-management/users/view.html" class="menu-link px-3">Edit</a>
																</div>
																
																
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">Delete</a>
																</div>
																
															</div>
															
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td class="d-flex align-items-center">
															
															<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
																<a href="apps/user-management/users/view.html">
																	<div class="symbol-label">
																		<img src="assets/media/avatars/300-1.jpg" alt="Max Smith" class="w-100" />
																	</div>
																</a>
															</div>
															
															
															<div class="d-flex flex-column">
																<a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary mb-1">Max Smith</a>
																<span>max@kt.com</span>
															</div>
															
														</td>
														<td>Developer</td>
														<td>
															<div class="badge badge-light fw-bold">3 days ago</div>
														</td>
														<td></td>
														<td>10 Mar 2024, 6:43 am</td>
														<td class="text-end">
															<a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-duotone ki-down fs-5 ms-1"></i></a>
															
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																
																<div class="menu-item px-3">
																	<a href="apps/user-management/users/view.html" class="menu-link px-3">Edit</a>
																</div>
																
																
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">Delete</a>
																</div>
																
															</div>
															
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td class="d-flex align-items-center">
															
															<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
																<a href="apps/user-management/users/view.html">
																	<div class="symbol-label">
																		<img src="assets/media/avatars/300-5.jpg" alt="Sean Bean" class="w-100" />
																	</div>
																</a>
															</div>
															
															
															<div class="d-flex flex-column">
																<a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary mb-1">Sean Bean</a>
																<span>sean@dellito.com</span>
															</div>
															
														</td>
														<td>Support</td>
														<td>
															<div class="badge badge-light fw-bold">5 hours ago</div>
														</td>
														<td>
															<div class="badge badge-light-success fw-bold">Enabled</div>
														</td>
														<td>22 Sep 2024, 5:20 pm</td>
														<td class="text-end">
															<a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-duotone ki-down fs-5 ms-1"></i></a>
															
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																
																<div class="menu-item px-3">
																	<a href="apps/user-management/users/view.html" class="menu-link px-3">Edit</a>
																</div>
																
																
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">Delete</a>
																</div>
																
															</div>
															
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td class="d-flex align-items-center">
															
															<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
																<a href="apps/user-management/users/view.html">
																	<div class="symbol-label">
																		<img src="assets/media/avatars/300-25.jpg" alt="Brian Cox" class="w-100" />
																	</div>
																</a>
															</div>
															
															
															<div class="d-flex flex-column">
																<a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary mb-1">Brian Cox</a>
																<span>brian@exchange.com</span>
															</div>
															
														</td>
														<td>Developer</td>
														<td>
															<div class="badge badge-light fw-bold">2 days ago</div>
														</td>
														<td>
															<div class="badge badge-light-success fw-bold">Enabled</div>
														</td>
														<td>15 Apr 2024, 5:30 pm</td>
														<td class="text-end">
															<a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-duotone ki-down fs-5 ms-1"></i></a>
															
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																
																<div class="menu-item px-3">
																	<a href="apps/user-management/users/view.html" class="menu-link px-3">Edit</a>
																</div>
																
																
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">Delete</a>
																</div>
																
															</div>
															
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td class="d-flex align-items-center">
															
															<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
																<a href="apps/user-management/users/view.html">
																	<div class="symbol-label fs-3 bg-light-warning text-warning">C</div>
																</a>
															</div>
															
															
															<div class="d-flex flex-column">
																<a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary mb-1">Mikaela Collins</a>
																<span>mik@pex.com</span>
															</div>
															
														</td>
														<td>Administrator</td>
														<td>
															<div class="badge badge-light fw-bold">5 days ago</div>
														</td>
														<td></td>
														<td>10 Mar 2024, 2:40 pm</td>
														<td class="text-end">
															<a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-duotone ki-down fs-5 ms-1"></i></a>
															
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																
																<div class="menu-item px-3">
																	<a href="apps/user-management/users/view.html" class="menu-link px-3">Edit</a>
																</div>
																
																
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">Delete</a>
																</div>
																
															</div>
															
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td class="d-flex align-items-center">
															
															<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
																<a href="apps/user-management/users/view.html">
																	<div class="symbol-label">
																		<img src="assets/media/avatars/300-9.jpg" alt="Francis Mitcham" class="w-100" />
																	</div>
																</a>
															</div>
															
															
															<div class="d-flex flex-column">
																<a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary mb-1">Francis Mitcham</a>
																<span>f.mit@kpmg.com</span>
															</div>
															
														</td>
														<td>Trial</td>
														<td>
															<div class="badge badge-light fw-bold">3 weeks ago</div>
														</td>
														<td></td>
														<td>20 Dec 2024, 10:10 pm</td>
														<td class="text-end">
															<a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-duotone ki-down fs-5 ms-1"></i></a>
															
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																
																<div class="menu-item px-3">
																	<a href="apps/user-management/users/view.html" class="menu-link px-3">Edit</a>
																</div>
																
																
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">Delete</a>
																</div>
																
															</div>
															
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td class="d-flex align-items-center">
															
															<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
																<a href="apps/user-management/users/view.html">
																	<div class="symbol-label fs-3 bg-light-danger text-danger">O</div>
																</a>
															</div>
															
															
															<div class="d-flex flex-column">
																<a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary mb-1">Olivia Wild</a>
																<span>olivia@corpmail.com</span>
															</div>
															
														</td>
														<td>Administrator</td>
														<td>
															<div class="badge badge-light fw-bold">Yesterday</div>
														</td>
														<td></td>
														<td>19 Aug 2024, 5:20 pm</td>
														<td class="text-end">
															<a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-duotone ki-down fs-5 ms-1"></i></a>
															
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																
																<div class="menu-item px-3">
																	<a href="apps/user-management/users/view.html" class="menu-link px-3">Edit</a>
																</div>
																
																
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">Delete</a>
																</div>
																
															</div>
															
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td class="d-flex align-items-center">
															
															<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
																<a href="apps/user-management/users/view.html">
																	<div class="symbol-label fs-3 bg-light-primary text-primary">N</div>
																</a>
															</div>
															
															
															<div class="d-flex flex-column">
																<a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary mb-1">Neil Owen</a>
																<span>owen.neil@gmail.com</span>
															</div>
															
														</td>
														<td>Analyst</td>
														<td>
															<div class="badge badge-light fw-bold">20 mins ago</div>
														</td>
														<td>
															<div class="badge badge-light-success fw-bold">Enabled</div>
														</td>
														<td>05 May 2024, 9:23 pm</td>
														<td class="text-end">
															<a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-duotone ki-down fs-5 ms-1"></i></a>
															
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																
																<div class="menu-item px-3">
																	<a href="apps/user-management/users/view.html" class="menu-link px-3">Edit</a>
																</div>
																
																
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">Delete</a>
																</div>
																
															</div>
															
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td class="d-flex align-items-center">
															
															<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
																<a href="apps/user-management/users/view.html">
																	<div class="symbol-label">
																		<img src="assets/media/avatars/300-23.jpg" alt="Dan Wilson" class="w-100" />
																	</div>
																</a>
															</div>
															
															
															<div class="d-flex flex-column">
																<a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary mb-1">Dan Wilson</a>
																<span>dam@consilting.com</span>
															</div>
															
														</td>
														<td>Developer</td>
														<td>
															<div class="badge badge-light fw-bold">3 days ago</div>
														</td>
														<td></td>
														<td>20 Dec 2024, 10:30 am</td>
														<td class="text-end">
															<a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-duotone ki-down fs-5 ms-1"></i></a>
															
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																
																<div class="menu-item px-3">
																	<a href="apps/user-management/users/view.html" class="menu-link px-3">Edit</a>
																</div>
																
																
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">Delete</a>
																</div>
																
															</div>
															
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td class="d-flex align-items-center">
															
															<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
																<a href="apps/user-management/users/view.html">
																	<div class="symbol-label fs-3 bg-light-danger text-danger">E</div>
																</a>
															</div>
															
															
															<div class="d-flex flex-column">
																<a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary mb-1">Emma Bold</a>
																<span>emma@intenso.com</span>
															</div>
															
														</td>
														<td>Support</td>
														<td>
															<div class="badge badge-light fw-bold">5 hours ago</div>
														</td>
														<td>
															<div class="badge badge-light-success fw-bold">Enabled</div>
														</td>
														<td>15 Apr 2024, 6:43 am</td>
														<td class="text-end">
															<a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-duotone ki-down fs-5 ms-1"></i></a>
															
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																
																<div class="menu-item px-3">
																	<a href="apps/user-management/users/view.html" class="menu-link px-3">Edit</a>
																</div>
																
																
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">Delete</a>
																</div>
																
															</div>
															
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td class="d-flex align-items-center">
															
															<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
																<a href="apps/user-management/users/view.html">
																	<div class="symbol-label">
																		<img src="assets/media/avatars/300-12.jpg" alt="Ana Crown" class="w-100" />
																	</div>
																</a>
															</div>
															
															
															<div class="d-flex flex-column">
																<a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary mb-1">Ana Crown</a>
																<span>ana.cf@limtel.com</span>
															</div>
															
														</td>
														<td>Developer</td>
														<td>
															<div class="badge badge-light fw-bold">2 days ago</div>
														</td>
														<td>
															<div class="badge badge-light-success fw-bold">Enabled</div>
														</td>
														<td>20 Jun 2024, 8:43 pm</td>
														<td class="text-end">
															<a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-duotone ki-down fs-5 ms-1"></i></a>
															
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																
																<div class="menu-item px-3">
																	<a href="apps/user-management/users/view.html" class="menu-link px-3">Edit</a>
																</div>
																
																
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">Delete</a>
																</div>
																
															</div>
															
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td class="d-flex align-items-center">
															
															<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
																<a href="apps/user-management/users/view.html">
																	<div class="symbol-label fs-3 bg-light-info text-info">A</div>
																</a>
															</div>
															
															
															<div class="d-flex flex-column">
																<a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary mb-1">Robert Doe</a>
																<span>robert@benko.com</span>
															</div>
															
														</td>
														<td>Administrator</td>
														<td>
															<div class="badge badge-light fw-bold">5 days ago</div>
														</td>
														<td></td>
														<td>25 Oct 2024, 11:30 am</td>
														<td class="text-end">
															<a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-duotone ki-down fs-5 ms-1"></i></a>
															
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																
																<div class="menu-item px-3">
																	<a href="apps/user-management/users/view.html" class="menu-link px-3">Edit</a>
																</div>
																
																
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">Delete</a>
																</div>
																
															</div>
															
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td class="d-flex align-items-center">
															
															<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
																<a href="apps/user-management/users/view.html">
																	<div class="symbol-label">
																		<img src="assets/media/avatars/300-13.jpg" alt="John Miller" class="w-100" />
																	</div>
																</a>
															</div>
															
															
															<div class="d-flex flex-column">
																<a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary mb-1">John Miller</a>
																<span>miller@mapple.com</span>
															</div>
															
														</td>
														<td>Trial</td>
														<td>
															<div class="badge badge-light fw-bold">3 weeks ago</div>
														</td>
														<td></td>
														<td>25 Jul 2024, 6:05 pm</td>
														<td class="text-end">
															<a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-duotone ki-down fs-5 ms-1"></i></a>
															
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																
																<div class="menu-item px-3">
																	<a href="apps/user-management/users/view.html" class="menu-link px-3">Edit</a>
																</div>
																
																
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">Delete</a>
																</div>
																
															</div>
															
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td class="d-flex align-items-center">
															
															<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
																<a href="apps/user-management/users/view.html">
																	<div class="symbol-label fs-3 bg-light-success text-success">L</div>
																</a>
															</div>
															
															
															<div class="d-flex flex-column">
																<a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary mb-1">Lucy Kunic</a>
																<span>lucy.m@fentech.com</span>
															</div>
															
														</td>
														<td>Administrator</td>
														<td>
															<div class="badge badge-light fw-bold">Yesterday</div>
														</td>
														<td></td>
														<td>10 Mar 2024, 10:10 pm</td>
														<td class="text-end">
															<a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-duotone ki-down fs-5 ms-1"></i></a>
															
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																
																<div class="menu-item px-3">
																	<a href="apps/user-management/users/view.html" class="menu-link px-3">Edit</a>
																</div>
																
																
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">Delete</a>
																</div>
																
															</div>
															
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td class="d-flex align-items-center">
															
															<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
																<a href="apps/user-management/users/view.html">
																	<div class="symbol-label fs-3 bg-light-danger text-danger">M</div>
																</a>
															</div>
															
															
															<div class="d-flex flex-column">
																<a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary mb-1">Melody Macy</a>
																<span>melody@altbox.com</span>
															</div>
															
														</td>
														<td>Analyst</td>
														<td>
															<div class="badge badge-light fw-bold">20 mins ago</div>
														</td>
														<td>
															<div class="badge badge-light-success fw-bold">Enabled</div>
														</td>
														<td>25 Jul 2024, 10:30 am</td>
														<td class="text-end">
															<a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-duotone ki-down fs-5 ms-1"></i></a>
															
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																
																<div class="menu-item px-3">
																	<a href="apps/user-management/users/view.html" class="menu-link px-3">Edit</a>
																</div>
																
																
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">Delete</a>
																</div>
																
															</div>
															
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td class="d-flex align-items-center">
															
															<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
																<a href="apps/user-management/users/view.html">
																	<div class="symbol-label">
																		<img src="assets/media/avatars/300-1.jpg" alt="Max Smith" class="w-100" />
																	</div>
																</a>
															</div>
															
															
															<div class="d-flex flex-column">
																<a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary mb-1">Max Smith</a>
																<span>max@kt.com</span>
															</div>
															
														</td>
														<td>Developer</td>
														<td>
															<div class="badge badge-light fw-bold">3 days ago</div>
														</td>
														<td></td>
														<td>25 Jul 2024, 11:05 am</td>
														<td class="text-end">
															<a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-duotone ki-down fs-5 ms-1"></i></a>
															
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																
																<div class="menu-item px-3">
																	<a href="apps/user-management/users/view.html" class="menu-link px-3">Edit</a>
																</div>
																
																
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">Delete</a>
																</div>
																
															</div>
															
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td class="d-flex align-items-center">
															
															<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
																<a href="apps/user-management/users/view.html">
																	<div class="symbol-label">
																		<img src="assets/media/avatars/300-5.jpg" alt="Sean Bean" class="w-100" />
																	</div>
																</a>
															</div>
															
															
															<div class="d-flex flex-column">
																<a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary mb-1">Sean Bean</a>
																<span>sean@dellito.com</span>
															</div>
															
														</td>
														<td>Support</td>
														<td>
															<div class="badge badge-light fw-bold">5 hours ago</div>
														</td>
														<td>
															<div class="badge badge-light-success fw-bold">Enabled</div>
														</td>
														<td>22 Sep 2024, 2:40 pm</td>
														<td class="text-end">
															<a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-duotone ki-down fs-5 ms-1"></i></a>
															
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																
																<div class="menu-item px-3">
																	<a href="apps/user-management/users/view.html" class="menu-link px-3">Edit</a>
																</div>
																
																
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">Delete</a>
																</div>
																
															</div>
															
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td class="d-flex align-items-center">
															
															<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
																<a href="apps/user-management/users/view.html">
																	<div class="symbol-label">
																		<img src="assets/media/avatars/300-25.jpg" alt="Brian Cox" class="w-100" />
																	</div>
																</a>
															</div>
															
															
															<div class="d-flex flex-column">
																<a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary mb-1">Brian Cox</a>
																<span>brian@exchange.com</span>
															</div>
															
														</td>
														<td>Developer</td>
														<td>
															<div class="badge badge-light fw-bold">2 days ago</div>
														</td>
														<td>
															<div class="badge badge-light-success fw-bold">Enabled</div>
														</td>
														<td>22 Sep 2024, 5:20 pm</td>
														<td class="text-end">
															<a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-duotone ki-down fs-5 ms-1"></i></a>
															
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																
																<div class="menu-item px-3">
																	<a href="apps/user-management/users/view.html" class="menu-link px-3">Edit</a>
																</div>
																
																
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">Delete</a>
																</div>
																
															</div>
															
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td class="d-flex align-items-center">
															
															<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
																<a href="apps/user-management/users/view.html">
																	<div class="symbol-label fs-3 bg-light-warning text-warning">C</div>
																</a>
															</div>
															
															
															<div class="d-flex flex-column">
																<a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary mb-1">Mikaela Collins</a>
																<span>mik@pex.com</span>
															</div>
															
														</td>
														<td>Administrator</td>
														<td>
															<div class="badge badge-light fw-bold">5 days ago</div>
														</td>
														<td></td>
														<td>10 Nov 2024, 10:30 am</td>
														<td class="text-end">
															<a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-duotone ki-down fs-5 ms-1"></i></a>
															
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																
																<div class="menu-item px-3">
																	<a href="apps/user-management/users/view.html" class="menu-link px-3">Edit</a>
																</div>
																
																
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">Delete</a>
																</div>
																
															</div>
															
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-check form-check-sm form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox" value="1" />
															</div>
														</td>
														<td class="d-flex align-items-center">
															
															<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
																<a href="apps/user-management/users/view.html">
																	<div class="symbol-label">
																		<img src="assets/media/avatars/300-9.jpg" alt="Francis Mitcham" class="w-100" />
																	</div>
																</a>
															</div>
															
															
															<div class="d-flex flex-column">
																<a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary mb-1">Francis Mitcham</a>
																<span>f.mit@kpmg.com</span>
															</div>
															
														</td>
														<td>Trial</td>
														<td>
															<div class="badge badge-light fw-bold">3 weeks ago</div>
														</td>
														<td></td>
														<td>10 Nov 2024, 6:43 am</td>
														<td class="text-end">
															<a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
															<i class="ki-duotone ki-down fs-5 ms-1"></i></a>
															
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
																
																<div class="menu-item px-3">
																	<a href="apps/user-management/users/view.html" class="menu-link px-3">Edit</a>
																</div>
																
																
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">Delete</a>
																</div>
																
															</div>
															
														</td>
													</tr>
												</tbody>
											</table>
											
										</div>
										
									</div>
									
								</div>
								
							</div>
							
						</div>
						
						
						<div id="kt_app_footer" class="app-footer">
							
							<div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
								
								<div class="text-gray-900 order-2 order-md-1">
									<span class="text-muted fw-semibold me-1">2024&copy;</span>
									<a href="https://keenthemes.com" target="_blank" class="text-gray-800 text-hover-primary">Keenthemes</a>
								</div>
								
								
								<ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
									<li class="menu-item">
										<a href="https://keenthemes.com" target="_blank" class="menu-link px-2">About</a>
									</li>
									<li class="menu-item">
										<a href="https://devs.keenthemes.com" target="_blank" class="menu-link px-2">Support</a>
									</li>
									<li class="menu-item">
										<a href="https://1.envato.market/EA4JP" target="_blank" class="menu-link px-2">Purchase</a>
									</li>
								</ul>
								
							</div>
							
						</div>
						
					</div>
    </div>
</body>
<script src="assets/plugins/global/plugins.bundle.js"></script>
		<script src="assets/js/scripts.bundle.js"></script>
		
		
		<script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
		
		
		<script src="assets/js/custom/apps/user-management/users/list/table.js"></script>
		<script src="assets/js/custom/apps/user-management/users/list/export-users.js"></script>
		<script src="assets/js/custom/apps/user-management/users/list/add.js"></script>
		<script src="assets/js/widgets.bundle.js"></script>
		<script src="assets/js/custom/widgets.js"></script>
		<script src="assets/js/custom/apps/chat/chat.js"></script>
		<script src="assets/js/custom/utilities/modals/upgrade-plan.js"></script>
		<script src="assets/js/custom/utilities/modals/create-app.js"></script>
		<script src="assets/js/custom/utilities/modals/users-search.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="js/theme.js"></script>
</html>
