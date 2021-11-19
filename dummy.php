<?php

            $puv_passenger_info = json_decode(file_get_contents("./vehicles/albuera_HVM-222.json"));
            array_push($puv_passenger_info, array("queuetime" => "123", "leavetime" => "123"));
            print_r(json_encode($puv_passenger_info));
?>
