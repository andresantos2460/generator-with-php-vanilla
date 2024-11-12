<?php
require 'db_connection.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$stmt = $pdo->prepare("SELECT id, app_name, app_email FROM generator WHERE user_id = :user_id");
$stmt->execute([
  ':user_id' => $_SESSION['user_id']
]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_SESSION['decrypted_password'])&& $_SESSION['decrypted_password_id']) {
  $decryptedPassword = $_SESSION['decrypted_password'];
  $decryptedPasswordId=$_SESSION['decrypted_password_id'];
  

  unset($_SESSION['decrypted_password']);
  unset($_SESSION['decrypted_password_id']);

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
		<link rel="shortcut icon" href="images/icon.png" />
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
		<link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
		<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Genius</title>
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

           <a href="index.php"><img width="200px" src="images/mylogo (1).png" alt="Santos WebServices!"></a>


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

                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">

                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Password List</h1>


                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">

                    <li class="breadcrumb-item text-muted">
                    <a href="#" class="text-muted text-hover-primary">Home</a>
                    </li>


                    <li class="breadcrumb-item">
                    <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>


                    <li class="breadcrumb-item text-muted">Password Management</li>




                    </ul>

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

                        <button type="button" class="btn btn-success me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_export_222">
                            <img width="20px" src="images/excel-svgrepo-com.svg">
                            Export Data
                        </button>


                      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
                        <i class="ki-duotone ki-plus fs-2"></i>Create Password</button>

                    </div>


                    <div class="d-flex justify-content-end align-items-center d-none" data-kt-user-table-toolbar="selected">
                      <div class="fw-bold me-5">
                        <span class="me-2" data-kt-user-table-select="selected_count"></span>Selected
                      </div>
                      <button type="button" class="btn btn-danger" data-kt-user-table-select="delete_selected">Delete Selected</button>
                    </div>

                    <div class="modal fade" tabindex="-1" id="kt_modal_export_222">
                      <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h3 class="modal-title">Export to .CSV</h3>
                                  <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                      <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                                  </div>
                              </div>
                              <div class="modal-body">
                                <form method="POST" action="exportData.php">
                                <input type="hidden" name="token" value="<?php echo $_SESSION['csrf_token']; ?>">
                              <div data-kt-password-meter="true">
                              <div class="position-relative mb-3">
                              <input class="form-control form-control-lg form-control-solid" type="password" placeholder="2234" name="code" autocomplete="off" />

                              <!--begin::Visibility toggle-->
                              <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                <i class="ki-duotone ki-eye-slash fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                <i class="ki-duotone ki-eye d-none fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                              </span>
                              <!--end::Visibility toggle-->
                            </div>
                            </div>
                              </div>
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-success"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-eye me-2" viewBox="0 0 16 16">
                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                                  </svg>Show Password</button>
                              </div>
                            </form>
                          </div>
                      </div>
                    </div>

                    <div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">

                      <div class="modal-dialog modal-dialog-centered mw-650px">

                        <div class="modal-content">

                          <div class="modal-header" id="kt_modal_add_user_header">

                            <h2 class="fw-bold">New Password</h2>


                            <button class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                              <i class="ki-duotone ki-cross fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                              </i>
                              </button>

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



                <div class="card-body py-4 mt-4">
                  <div class="table-titles item-table d-flex justify-content-between">
                    <span class="dt-column-title"><b>APP</b></span>
                    <span class="dt-column-title"><b>Email</b></span>
                    <span class="dt-column-title"><b>Password</b></span>
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
                              <div class="item d-flex py-4 item-table password-table-row">
                                
                                <!-- App Name -->
                                <span><?php echo htmlspecialchars($result['app_name']); ?></span>
                                
                                <!-- App Email -->
                                <span><?php echo htmlspecialchars($result['app_email']); ?></span>
                                <!-- if has show password -->
                                 <?php 
                                 if(!empty($decryptedPassword) && !empty($decryptedPasswordId) && $decryptedPasswordId == $result['id']){
                              
                                  ?>
                                  <div class="card border-0 item-row">
                                    <div class="card-body see-pass">
                                        <div class="input-group">
                                            <input id="kt_clipboard_<?php echo $result['id']; ?>" type="text" class="form-control password-field" value="<?php echo htmlspecialchars($decryptedPassword); ?>">
                                            <button class="btn btn-light-primary copy-btn" data-clipboard-target="#kt_clipboard_<?php echo $result['id']; ?>">
                                                Copy
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                  <?php
                                } else{
                                  ?>
                                  <!-- not has show password -->
                                      
                               <div class="card border-0">
                                  <div class="card-body see-pass">
                                    <div class="input-group">
                                      <input disabled type="text" class="form-control" value="**********" />
                                      <button class="btn btn-light-primary" type="button" data-bs-toggle="modal" data-bs-target="#kt_modal_stacked_<?php echo $result['id']; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16">
                                          <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7 7 0 0 0-2.79.588l.77.771A6 6 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755q-.247.248-.517.486z" />
                                          <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829" />
                                          <path d="M3.35 5.47q-.27.24-.518.487A13 13 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7 7 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12z" />
                                        </svg>
                                      </button>
                                    </div>
                                  </div>
                                </div> 
                                  <?php
                                }
                                 ?>
                            
                                
                                <!-- Actions button -->
                                <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                  Actions <i class="ki-duotone ki-down fs-5 ms-1"></i>
                                </a>
                                
                                <!-- Actions dropdown menu -->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                  <div class="menu-item px-3">
                                    <button type="button" class="btn btn-sm w-100 btn-light-primary px-3" data-bs-toggle="modal" data-bs-target="#kt_modal_delete_<?php echo $result['id']; ?>">Delete</button>
                                  </div>
                                </div>
                                <!-- modal delete ! -->

                                                                          
                                          <div class="modal fade" tabindex="-1" id="kt_modal_delete_<?php echo $result['id']; ?>">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3 class="modal-title">Delete My Password</h3>
                                                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                                                        </div>
                                                    </div>

                                                    <div class="modal-body">
                                                      <form method="POST" action="deletePassword.php">
                                                      <input type="hidden" name="token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                                      <input type="hidden" name="product_id" value="<?php echo $result['id']; ?>">
                                                    <div data-kt-password-meter="true">
                                                    <div class="position-relative mb-3">
                                                    <input class="form-control form-control-lg form-control-solid" type="password"  name="code" autocomplete="off" />

                                                    <!--begin::Visibility toggle-->
                                                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                                      <i class="ki-duotone ki-eye-slash fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                                      <i class="ki-duotone ki-eye d-none fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                                    </span>
                                                    <!--end::Visibility toggle-->
                                                  </div>
                                                  </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </div>
                                                  </form>
                                                </div>
                                            </div>
                                          </div>

                                          <!-- modal see -->
                                          <div class="modal fade" tabindex="-1" id="kt_modal_stacked_<?php echo $result['id']; ?>">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3 class="modal-title">Show My Password</h3>
                                                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                                                        </div>
                                                    </div>
                                                    <div class="modal-body">
                                                      <form method="POST" action="showPassword.php">
                                                      <input type="hidden" name="token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                                      <input type="hidden" name="password_id" value="<?php echo $result['id']; ?>">
                                                    <div data-kt-password-meter="true">
                                                    <div class="position-relative mb-3">
                                                    <input class="form-control form-control-lg form-control-solid" type="password" placeholder="2234" name="code" autocomplete="off" />

                                                    <!--begin::Visibility toggle-->
                                                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                                      <i class="ki-duotone ki-eye-slash fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                                      <i class="ki-duotone ki-eye d-none fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                                    </span>
                                                    <!--end::Visibility toggle-->
                                                  </div>
                                                  </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-success"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-eye me-2" viewBox="0 0 16 16">
                                                          <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                                                          <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                                                        </svg>Show Password</button>
                                                    </div>
                                                  </form>
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
              <a href="https://github.com/andresantos2460" target="_blank" class="text-gray-800 text-hover-primary">André Santos</a>
            </div>


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
