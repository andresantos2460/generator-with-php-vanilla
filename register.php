<?php
require 'db_connection.php';
session_start();
if (isset($_SESSION['user_id'])) {
    header('location:login.php');
    exit();
}
/* function generate code */
function codeCreate($pdo) {
    do {
        $code = rand(1000, 9999);

        $stmt = $pdo->prepare("SELECT id FROM user WHERE code = :codigo LIMIT 1");
        $stmt->bindParam(':codigo', $code);
        $stmt->execute();
        
        $codeUnic = ($stmt->rowCount() == 0);
        
    } while (!$codeUnic); 
    
    return $code;
}

function verifyEmail($pdo,$email){
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            return true; 
        } else {
            return false; 
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }

}

/* register proces */
$errorMessage = "";
$successMessage = "";
if($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['password_confirm'];
    $code = codeCreate($pdo);

    if (!empty($email) && !empty($password)&& !empty($name) && !empty($confirm_password)) {
        $emailUnic=verifyEmail($pdo,$email);

     
        if($confirm_password != $password) {
            $errorMessage = "Passwords nao combinam";
            header("Location: register.php?error=" . urlencode($errorMessage));
            exit();

        }else if($emailUnic==false){
            $errorMessage = "Erro, email em uso!";
            header("Location: register.php?error=" . urlencode($errorMessage));
            exit();
        }
        {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO user (name, email, password, code) VALUES (:name, :email, :password, :code)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':code', $code);

            if ($stmt->execute()) {
                $successMessage = "Criado com Sucesso!";
                $user_id = $pdo->lastInsertId();
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_code'] = $code;
                $_SESSION['name'] = $name;  
                header('refresh:1; url=index.php');  // Aguardar 2 segundos e redirecionar
    
            } else {
                $errorMessage = "Erro ao criar Conta!";
    
            }
        }

    
    } else {
        $errorMessage = "Preencha todos os dados!";

    }
    
    }

    

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="style.css">

    <link rel="canonical" href="http://authentication/layouts/corporate/sign-up.html" />
    <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <title>Criar Conta</title>
</head>



<body id="kt_body" class="app-blank">

    <script src="js/theme.js"></script>


    <div class="d-flex flex-column flex-root" id="kt_app_root">

        <div class="d-flex flex-column flex-lg-row flex-column-fluid">

            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">

                <div class="d-flex flex-center flex-column flex-lg-row-fluid">

                    <div class="w-lg-500px p-10">

                        <form class="form w-100" method="POST" action="">

                            <div class="text-center mb-11">

                                <h1 class="text-gray-900 fw-bolder mb-3">Sign Up</h1>

                            </div>

                            <div class="fv-row mb-8">

                                <input required type="text" placeholder="Name" name="name" autocomplete="off"
                                    class="form-control bg-transparent" />

                            </div>
                            <div class="fv-row mb-8">

                                <input required type="text" placeholder="Email" name="email" autocomplete="off"
                                    class="form-control bg-transparent" />

                            </div>

                            <div class="fv-row mb-8" data-kt-password-meter="true">

                                <div class="mb-1">

                                    <div class="position-relative mb-3">
                                        <input required class="form-control bg-transparent" type="password"
                                            placeholder="Password" name="password" autocomplete="off" />
                                        <span
                                            class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                            data-kt-password-meter-control="visibility">
                                            <i class="ki-duotone ki-eye-slash fs-2"></i>
                                            <i class="ki-duotone ki-eye fs-2 d-none"></i>
                                        </span>
                                    </div>


                                    <div class="d-flex align-items-center mb-3"
                                        data-kt-password-meter-control="highlight">
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2">
                                        </div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2">
                                        </div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2">
                                        </div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                    </div>

                                </div>


                                <div class="text-muted">Use 8 or more characters with a mix of letters, numbers &
                                    symbols.</div>

                            </div>


                            <div class="fv-row mb-8">

                                <input required placeholder="Repeat Password" name="password_confirm" type="password"
                                    autocomplete="off" class="form-control bg-transparent" />

                            </div>


                            <div class="fv-row mb-8">
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" required name="toc" value="1" />
                                    <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">I Accept the
                                        <a href="#" class="ms-1 link-primary">Terms</a></span>
                                </label>
                            </div>

                            <?php
                                if (!empty($errorMessage)) {
                                    echo '<div class="alert alert-danger" role="alert">'. $errorMessage .'</div>';
                                }else if(isset($_GET['error'])){
                                        echo '<div class="alert alert-danger" role="alert">'. htmlspecialchars($_GET['error']) . '</div>';
                                    }
                                
                                    ?>
                            <?php
                                if (!empty($successMessage)) {
                                    echo '<div class="alert alert-success" role="alert">'. $successMessage .'</div>';
                                }
                                ?>
                            <div class="d-grid mb-10">
                                <button type="submit" id="kt_sign_up_submit" class="btn btn-primary">

                                    <span class="indicator-label">Sign up</span>


                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>

                                </button>
                            </div>


                            <div class="text-gray-500 text-center fw-semibold fs-6">Already have an Account?
                                <a href="login.php" class="link-primary fw-semibold">Sign in</a>
                            </div>

                        </form>

                    </div>

                </div>




            </div>


            <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2"
                style="background-image: url(assets/media/misc/auth-bg.png)">

                <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">

                    <a href="index.html" class="mb-0 mb-lg-12">
                        <img alt="Logo" src="assets/media/logos/custom-1.png" class="h-60px h-lg-75px" />
                    </a>


                    <img class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-20"
                        src="assets/media/misc/auth-screens.png" alt="" />


                    <h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7">Fast, Efficient and
                        Productive</h1>


                    <div class="d-none d-lg-block text-white fs-base text-center">In this kind of post,
                        <a href="#" class="opacity-75-hover text-warning fw-bold me-1">the blogger</a>introduces a
                        person they’ve interviewed
                        <br />and provides some background information about
                        <a href="#" class="opacity-75-hover text-warning fw-bold me-1">the interviewee</a>and their
                        <br />work following this is a transcript of the interview.
                    </div>

                </div>

            </div>

        </div>

    </div>



    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>


    <script src="assets/js/custom/authentication/sign-up/general.js"></script>


</body>

</html>