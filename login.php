<?php
session_start();
require 'db_connection.php';
if (isset($_SESSION["user_id"])){
    header('location:/index');
    exit();
}

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); 
}
/* login process */
$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if($_POST['token']!=$_SESSION['csrf_token']){
        $errorMessage = "os tokens nao combinam";
        header("Location: /login?error=" . urlencode($errorMessage));
        exit();
    }
    
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        $sql = "SELECT id, name, password FROM user WHERE email = :email LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
     
        if ($user) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id']; 
                $_SESSION['name'] = $user['name'];  

                $successMessage = "Login bem-sucedido! Redirecionando...";
                header('refresh:1; url=/index');  
                exit();  
            } else {
                $errorMessage = "Senha incorreta.";
            }
        } else {
            $errorMessage = "Usuário não encontrado.";
        }
    } else {
        $errorMessage = "Por favor, preencha todos os campos.";
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
    <title>Login Account</title>
</head>



<body id="kt_body" class="app-blank">

    <script src="js/theme.js"></script>


    <div class="d-flex flex-column flex-root" id="kt_app_root">

        <div class="d-flex flex-column flex-lg-row flex-column-fluid">

            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">

                <div class="d-flex flex-center flex-column flex-lg-row-fluid">

                    <div class="w-lg-500px p-10">

                        <form class="form w-100" method="POST" action="">
                            <input type="hidden" name="token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <div class="text-center mb-11">

                                <h1 class="text-gray-900 fw-bolder mb-3">Sign in</h1>

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



                                </div>


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


                            <div class="text-gray-500 text-center fw-semibold fs-6">Dont have an Account?
                                <a href="/register" class="link-primary fw-semibold">Sign up</a>
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