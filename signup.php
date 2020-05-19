<html>

<head>
    <title>Sign up</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Mukta|Roboto|Trade+Winds|Rubik&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>

<body>
    <?php    
            ob_start();
            session_start();
            
            $db = mysqli_connect('localhost', 'root', '', 'movieticket');

                error_reporting(0);
                $er_fname = "";
                $fname = "";
                $er_lname = "";
                $lname = "";
                $er_email = "";
                $email = "";
                $er_phone = "";
                $phone = "";
                $er_password = "";
                $password = "";
                $er_conpassword = "";
                $conpassword = "";
                $role = 3;
                $boolean = 0;
                $errors = array();
    
                if(isset($_POST['signup']))
                {                      
                        if (!preg_match("/^[a-zA-Z ]*$/",$_POST["fname"]))
                        {
                            $er_fname = "letters and white space allowed";
                            $boolean = 0;
                            array_push($errors,"letters and white space allowed");
                        }
                        else
                        {
                            $fname =validate_input($_POST["fname"]);
                            $boolean = 1;
                        }

                        
                        if (!preg_match("/^[a-zA-Z ]*$/",$_POST["lname"]))
                        {
                            $er_lname = "letters and white space allowed";
                            $boolean = 0;
                            array_push($errors,"letters and white space allowed");
                        }
                        else
                        {
                            $lname = validate_input($_POST["lname"]);
                            $boolean = 1;
                            
                        }
                        
                        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
                        {
                          $er_email = "Invalid email format";
                          $boolean = 0;
                          array_push($errors, "Invalid email format");
                        }
                        else
                        {
                            $email = validate_input($_POST["email"]);
                            $boolean = 1;
                        }
                        
                        if(!preg_match('/^[0]{1}[1]{1}[1-9]{1}[0-9]{8}$/', $_POST["phone"]))
                        {
                             $er_phone = "Invalid Phone";
                             $boolean = 0;
                            array_push($errors,"Invalid Phone");
                        }
                        else
                        {
                            $phone = validate_input($_POST["phone"]);
                            $boolean = 1;
                        }
                        
                        $len = strlength($_POST["password"]);
                            
                        if ($len)
                        {
                            $er_password = $len;
                            $boolean = 0;
                            array_push($errors, $len);
                        }
                        else
                        {
                            $password = validate_input($_POST["password"]);
                            $boolean = 1;
                        }
                    
                        if($_POST["confirmpassword"] != $password)
                        {
                            $er_conpassword = "Password did't match!";
                            $boolean = 0;
                            array_push($errors,"Password did't match!");
                        }
                        else
                        {
                            $conpassword = validate_input($_POST["confirmpassword"]);
                            $boolean = 1;
                        }
                    
                        $user_check_query = "SELECT * FROM customer WHERE email='$email'";
                        $result = mysqli_query($db, $user_check_query);
                        $customer = mysqli_num_rows($result);

                        if ($customer) 
                        {
                            $existemail = "E-mail already exists";
                            array_push($errors);
                            echo "<script type='text/javascript'>alert('$existemail');</script>";
                        }
                        else
                        {   
                            $numErrors = count($errors);
                            
                            if ($numErrors == 0) 
                            {
                                $password = md5($conpassword);
                                $id = str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);

                                $query = "INSERT INTO customer(id,fname,lname,email,phone,password) VALUES('$id','$fname','$lname','$email','$phone','$password')";  

                                $firstquery = mysqli_query($db, $query); 
                                
                                if($firstquery)
                                {
                                    $querynew = "INSERT INTO login (id,fname,email,password,role) VALUES('$id','$fname','$email','$password','$role')";
                                    mysqli_query($db, $querynew);
                                }

				                $_SESSION['fname'] = $fname;
                            	header('location: login.php');
                            }
                            
                            
                        }
                }
    
			   function validate_input($data) 
               {
                  $data = trim($data);
                  $data = stripslashes($data);
                  $data = htmlspecialchars($data);
                  return $data;
               }
               
               function strlength($str)
               {
                   $ln = strlen($str);
                    
                   if($ln >15)
                   {
                       return "Password should be less then 15 characters!";
                   }
                   elseif($ln<6 && $ln >=1)
                   {
                       return "Password should be greater than 5 characters!";
                   }
                   return;
               }
    
	?>
    <header class="showcase">
        <input type="checkbox" id="check">
        <label for="check" class="checkbtn">
            <i class="fas fa-bars"></i>
        </label>
        <label class="logo">Movie Club</label>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
            <li><a href="#signup">Sign up</a></li>
        </ul>
    </header>
    <section>
        <form action="#" method="post">
            <div id="signup">
                <h1>Sign Up here</h1>
                <div class="textbox">
                    <input type="text" name="fname" value="<?php echo $fname;?>" placeholder="First Name" required>
                </div>
                <span id="span1" style="color: white;"><?php echo $er_fname;?></span>
                <div class="textbox">
                    <input type="text" name="lname" value="<?php echo $lname;?>" placeholder="Last Name" required>
                </div>
                <span id="span1" style="color: white;"><?php echo $er_lname;?></span>
                <div class="textbox">
                    <input type="text" name="email" value="<?php echo $email;?>" placeholder="E-mail" required>
                </div>
                <span id="span1" style="color: white;"><?php echo $er_email;?></span>
                <div class="textbox">
                    <input type="text" name="phone" value="<?php echo $phone;?>" placeholder="Phone Number" required>
                </div>
                <span id="span1" style="color: white;"><?php echo $er_phone;?></span>
                <div class="textbox">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <span id="span1" style="color: white;"><?php echo $er_password;?></span>
                <div class="textbox">
                    <input type="password" name="confirmpassword" placeholder="Confirm Password" required>
                </div>
                <span id="span1" style="color: white;"><?php echo $er_conpassword;?></span>
                <br>
                <div class="checkbox">
                    <input type="checkbox" name="acceptcondition" value="accepted" required> &nbsp <span style="font-size: 12px;">I accept the terms and conditions</span>
                </div>
                <input class="btn" type="submit" name="signup" value="Sign Up">
                <br><br>
                <h5 align="center">Already have an account?</h5>
                <input class="btn" type="button" name="login" value="Sign In" onclick="window.location.href = 'login.php'">
            </div>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <div class="about">
                <h1 style="font-size: 30px; text-shadow: 1px 2px 5px yellow; color: white"> &nbsp &nbsp &nbsp About</h1>
                <div id="about">
                    <br><br>
                    <p align="center">What we do is make people happy, but who we are is a small team of curious people. Curious about your happiness, what makes you special, what you’re experts in. We want to know the what, the why, the how–pick your brain and turn the findings into happiness.<br>
                        We’ve spent the past five years learning about movies and happiness, new and old, local and abroad. Our passion is to take what we earn from you happiness and turn that into our goal that can accomplish anything.</p>
                </div>
            </div>
            <br><br><br><br><br><br><br>
            <h1 style="font-size: 30px; text-shadow: 1px 2px 5px yellow; color: white">&nbsp &nbsp &nbsp Contact us</h1>
            <br><br><br>

            <div id="contact">
                <div class="card">
                    <i class="card-icon far fa-envelope"></i>
                    <p>info@mclub.com</p>
                </div>

                <div class="card">
                    <i class="card-icon fas fa-phone"></i>
                    <p>+01800000000</p>
                </div>

                <div class="card">
                    <i class="card-icon fas fa-map-marker-alt"></i>
                    <p>Dhaka,Bangladesh</p>
                </div>
            </div>
            <br><br><br><br><br><br>
            <h6 style="text-align: center; color: yellow; letter-spacing: 2px">© 2020 Webtech sec: A</h6><br><br><br><br><br>
        </form>
    </section>
</body>

</html>
