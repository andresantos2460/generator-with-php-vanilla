<?php
require 'db_connection.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit(); 
}
$stmt = $pdo->prepare("SELECT app_name, app_email FROM generator WHERE user_id = :user_id");
$stmt->execute([
  ':user_id' => $_SESSION['user_id']
]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);



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
        echo ' <div style="background-color: #edfbd8 !important; position:relative;" class="alert alert-success mx-9" id="alert-modal" role="alert">
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
                        <span class="me-2" data-kt-user-table-select="selected_count"></span>Selected
                      </div>
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

                            <h2 class="fw-bold">New Password</h2>


                            <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                              <i class="ki-duotone ki-cross fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                              </i>
                            </div>

                          </div>


                          <div class="modal-body px-5 my-7">

                            <form id="" class="form" method="POST" action="generatePassword.php">
                              <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
							  <input type="hidden" name="token" value="<?php echo $_SESSION['csrf_token']; ?>">

                                <div class="fv-row mb-7">

                                  <label class="required fw-semibold fs-6 mb-2">App name</label>


                                  <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Instagram" />

                                </div>


                                <div class="fv-row mb-7">

                                  <label class="required fw-semibold fs-6 mb-2">Email</label>


                                  <input type="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="example@domain.com" />

                                </div>


                                <div class="mb-5">

                                  <label class="required fw-semibold fs-6 mb-5">Role</label>



                                  <div class="d-flex fv-row">

                                    <div class="form-check form-check-custom form-check-solid">

                                      <input class="form-check-input me-3" name="numbers" type="checkbox" value="true" id="" checked='checked' />


                                      <label class="form-check-label" for="kt_modal_update_role_option_0">
                                        <div class="fw-bold text-gray-800">Include Numbers</div>
                                        <div class="text-gray-600">Incorporates numbers (0-9) to make your password harder to guess.</div>
                                      </label>

                                    </div>

                                  </div>

                                  <div class='separator separator-dashed my-5'></div>
                                  <div class="d-flex fv-row">

                                    <div class="form-check form-check-custom form-check-solid">

                                      <input class="form-check-input me-3" name="Symbols" type="checkbox" value="true" id="" />


                                      <label class="form-check-label" for="kt_modal_update_role_option_0">
                                        <div class="fw-bold text-gray-800">Include Special Symbols</div>
                                        <div class="text-gray-600">Adds special characters (!, @, #, $, etc.) to increase password complexity.</div>
                                      </label>

                                    </div>

                                  </div>

                                  <div class='separator separator-dashed my-5'></div>

                                  <div class="d-flex fv-row">

                                    <div class="form-check form-check-custom form-check-solid">

                                      <input class="form-check-input me-3" name="Length" type="radio" value="small_characters" id="" />


                                      <label class="form-check-label" for="kt_modal_update_role_option_0">
                                        <div class="fw-bold text-gray-800">Password Length (8-12)</div>
                                        <div class="text-gray-600">Choose the password length, from 8 to 12 characters.</div>
                                      </label>

                                    </div>

                                  </div>
                                  <div class='separator separator-dashed my-5'></div>
                                  <div class="d-flex fv-row">

                                    <div class="form-check form-check-custom form-check-solid">

                                      <input class="form-check-input me-3" name="Length" type="radio" value="large_characters" id="" checked='checked' />


                                      <label class="form-check-label" for="kt_modal_update_role_option_0">
                                        <div class="fw-bold text-gray-800">Password Length (12-32)</div>
                                        <div class="text-gray-600">Choose the password length, from 12 to 32 characters.</div>
                                      </label>

                                    </div>

                                  </div>
                                  <div class='separator separator-dashed my-5'></div>


                                </div>

                              </div>


                              <div class="text-center pt-10">
                                <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Discard</button>
                                <button type="submit" class="btn btn-primary" >
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
                        <?php
        // Função para exibir o alerta
        function showAlert($message, $type = 'success') {
            // Verifica se a mensagem não está vazia
            if (!empty($message)) {
                // Definir a classe de alerta e o ícone com base no tipo (erro ou sucesso)
                $alertClass = ($type === 'error') ? 'alert-danger' : 'alert-success';
                $iconClass = ($type === 'error') ? 'ki-duotone ki-shield-tick fs-2hx text-danger' : 'ki-duotone ki-shield-tick fs-2hx text-success';
                $title = ($type === 'error') ? 'Error' : 'Success';
                echo '
                <div class="alert ' . $alertClass . ' d-flex alert-dismissible mx-9 align-items-center p-5">
                    <i class="' . $iconClass . ' me-4"><span class="path1"></span><span class="path2"></span></i>
                    
                    <div class="d-flex flex-column">
                        <h4 class="mb-1 text-dark">'.$title.'!</h4>
                        
                        <span>' . htmlspecialchars($message) . '</span>
                    </div>
                       <button type="button"  class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
        <i class="ki-duotone ki-cross fs-1 text-dark"><span class="path1"></span><span class="path2"></span></i>
    </button>
                </div>';
            }
        }

        if (isset($_GET['success'])) {
            showAlert($_GET['success'], 'success');
        } 
        else if (isset($_GET['error'])) {
            showAlert($_GET['error'], 'error');
        }
        else if (!empty($errorMessage)) {
            showAlert($errorMessage, 'error');
        }
        ?>



                <div class="card-body py-4">
                  <div class="table-titles item-table d-flex justify-content-between">
                    <span class="dt-column-title"><b>APP</b></span>
                    <span class="dt-column-title"><b>Email</b></span>
                    <span class="dt-column-title"><b>Passoword</b></span>
                    <span class="dt-column-title"><b>Action</b></span>
                  </div>
                      <?php
                      if(empty($results)){
                        ?>
                            <div class="alert alert-dismissible mt-3 bg-light-primary border border-primary d-flex flex-column flex-sm-row p-5 mb-10">
                                <i class="ki-duotone ki-notification-bing fs-2hx text-primary me-4 mb-5 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>

                                <div class="d-flex flex-column pe-0 pe-sm-10">
                                    <h5 class="mb-1 text-primary">No password generated!</h5>

                                    <span>Create your new password now!</span>
                                </div>

                                <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                                    <i class="ki-duotone ki-cross fs-1 text-primary"><span class="path1"></span><span class="path2"></span></i>
                                </button>
                            </div>
                        <?php
                      }
                      ?>
                         <?php
                            foreach ($results as $result) {
                            ?>
                              <div class="item d-flex py-4 item-table align-items-center justify-content-between">
                                
                                <!-- App Name -->
                                <span><?php echo htmlspecialchars($result['app_name']); ?></span>
                                
                                <!-- App Email -->
                                <span><?php echo htmlspecialchars($result['app_email']); ?></span>
                                
                                <!-- Card for password field -->
                                <div class="card border-0">
                                  <div class="card-body">
                                    <div class="input-group">
                                      <input disabled type="text" class="form-control" value="**********" />
                                      
                                      <button class="btn btn-light-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16">
                                          <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7 7 0 0 0-2.79.588l.77.771A6 6 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755q-.247.248-.517.486z" />
                                          <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829" />
                                          <path d="M3.35 5.47q-.27.24-.518.487A13 13 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7 7 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12z" />
                                        </svg>
                                      </button>
                                    </div>
                                  </div>
                                </div>
                                
                                <!-- Actions button -->
                                <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                  Actions <i class="ki-duotone ki-down fs-5 ms-1"></i>
                                </a>
                                
                                <!-- Actions dropdown menu -->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                  <div class="menu-item px-3">
                                    <button type="submit" class="btn btn-sm w-100 btn-light-primary px-3" data-bs-toggle="modal" data-bs-target="#kt_modal_stacked_1">Delete</button>
                                  </div>
                                </div>
                                <!-- modal delete ! -->

                                                                          
                                          <div class="modal fade" tabindex="-1" id="kt_modal_stacked_1">
                                          <div class="modal-dialog modal-dialog-centered">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <h3 class="modal-title">Modal title</h3>
                                                      <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                                          <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                                                      </div>
                                                  </div>

                                                  <div class="modal-body">
                                               
                                                  </div>
                                                  <div class="modal-footer">
                                                      <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                      <button type="button" class="btn btn-primary">Save changes</button>
                                                  </div>
                                              </div>
                                          </div>
                                          </div>
                              </div>
                            <?php
                            }
                            ?>
                
                </div>

              </div>

            </div>

          </div>

        </div>


        <div id="kt_app_footer" class="app-footer">

          <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">

            <div class="text-gray-900 order-2 order-md-1">
              <span class="text-muted fw-semibold me-1">2024&copy; Created by </span>
              <a href="#" target="_blank" class="text-gray-800 text-hover-primary">André Santos</a>
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
<script src="assets/js/theme.js"></script>
</html>
