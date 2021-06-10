<?php

$info = (object)[];

    $data = false;

    //validate info
    $data['email'] = $DATA_OBJ->email;
    
    if(empty($DATA_OBJ->email))
    {
        $ERROR = "Please enter a valid email<br>";
    }

    if(empty($DATA_OBJ->password))
    {
        $ERROR .= "Please enter a valid password";
    }

    if($ERROR == "")
    {
        $query = "select * from users where email = :email limit 1 ";
        $result = $DB->read($query,$data);

        if(is_array($result))
        {
            $result = $result[0];
            if($result->password == $DATA_OBJ->password)
            {
                $_SESSION['userid'] = $result->userid;
                $info->message = "You are successfully logged in";
                $info->data_type = "info";
                echo json_encode($info);
            }else{

                $info->message = "Wrong Password";
                $info->data_type = "error";
                echo json_encode($info);
            }
            
        }
        else
        {
            
            $info->message = "wrong email";
            $info->data_type = "error";
            echo json_encode($info);
        }
    }
    else
    {
        //echo $ERROR;
        $info->message = $ERROR;
        $info->data_type = "error";
        echo json_encode($info);
        
    }