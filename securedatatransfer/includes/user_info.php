<?php

$info = (object)[];

    $data = false;

    //validate info
    $data['userid'] = $_SESSION['userid'];
    
    
    if($ERROR == "")
    {
        $query = "select * from users where userid = :userid limit 1 ";
        $result = $DB->read($query,$data);

        if(is_array($result))
        {
            $result = $result[0];
            $result->data_type = "user_info";
            //check if image exists
            $image = ($result->gender == "Male") ? "ui/images/user_male.jpg" : "ui/images/user_female.png";
            if(file_exists($result->image))
            {
                $image = $result->image;
            }
            $result->image = $image;
            echo json_encode($result);
            
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