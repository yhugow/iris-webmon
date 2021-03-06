<?php
    class SignIn
    {
        public function auth($post)
        {
            global $conn;
            global $validation;
            
            if( $validation->validateEmail($post['email_address']) ) 
            {
                $sql = "SELECT `user_id`,`email_address`,`password`,`role`,`status` FROM `user_account` WHERE `email_address`='".$post['email_address']."' AND `password`='".$post['password']."' ";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();

                    if($row['status'] == 'approved') {
                        echo json_encode(array(
                            'errorCode'=>0,
                            'response'=>array(
                                'user_id'=> $row['user_id'],
                                'role'=> $row['role'],
                                'email_address'=> $row['email_address']
                            )
                        ));
                    } 
                    else {
                        echo json_encode(array('errorCode'=>304,'errorMsg'=>'Your account has been '.$row['status'].' by admin. <br/>Raise this to the admin for the immediate resolve for your account.'));
                    }

                } else {
                    echo json_encode(array('errorCode'=>304,'errorMsg'=>'Incorrect email address or password'));
                }
            } 
            else 
            {   
                echo json_encode(array('errorCode'=>304,'errorMsg'=>'Invalid email address'));
            }
        }
    }
?>