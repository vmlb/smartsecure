<?php

  $prot = array ("-v 3", "-u -v 3");
  $auth = array ("PSK", "DHE-PSK","ECDHE-PSK", "DHE-RSA","ECDHE-ECDSA", "ECDHE-RSA");
  $enc = array ("AES128", "AES128-CBC", "AES128-CCM", "AES128-GCM", "AES256", "AES256-CBC", "AES256-CCM", "AES256-GCM", "CHACHA20");
  $mac = array ("SHA", "SHA256", "SHA384", "POLY1305");
  $ses = array ("-r", "");

  foreach ($prot as $p){
    foreach ($mac as $m){
        foreach ($enc as $e) {
            foreach ($auth as $a) {            
                foreach($ses as $s) {

                    $file = "output_redo_all.csv";
                    if ($p == "-u -v 3") {$protocol="DTLS";} else {$protocol="TLS";}
                    //file_put_contents($file, "protocol is $p and $protocol\n", FILE_APPEND);                    
                    
                    if ($s == "-r") {$session="Session Resumption";} else {$session = "No Session Resumption";}
                    //file_put_contents($file, "session is $s and $session\n", FILE_APPEND);
                    
                    if ($a == "DHE-RSA" || $a == "ECDHE-RSA") {$cert_server = "-c ./certs/server-cert.pem -k ./certs/server-key.pem";$cert_client="";}
                    else if ($a == "PSK" || $a == "DHE-PSK" || $a == "ECDHE-PSK") {$cert_server = "-s";$cert_client = "-s";}
                    else {$cert_server = "-c ./certs/server-ecc.pem -k ./certs/ecc-key.pem";$cert_client="";}
                    //file_put_contents($file, "auth is $a and cert is $cert_server\n", FILE_APPEND);
                    
                    $info = "********Current security scheme is, $protocol,$a,$e,$m,$session,$cert_server,\n";                    
                    file_put_contents($file, $info, FILE_APPEND);
                    


                    //********************************************************************
                    // Don't run the follow two sections together. Race conditions happen. 
                    // better run one section, save result, and run the other 
                    //********************************************************************


                    //for testing memory usage
                    system("gnome-terminal -e 'bash -c \"./examples/server/server -l $a-$e-$m $p $s $cert_server -t >> $file; exit; exec bash\"'");
                    system("gnome-terminal -e 'bash -c \"./examples/client/client -l $a-$e-$m $p $s $cert_client -t >> $file; exit; exec bash\"'");
                    
                    system("sleep 2;"); 
                    
                    

                    if ($protocol="TLS") {
                    
                        //for TLS benchmark, use 6400b of data and both client and server use the -B flag
                        system("gnome-terminal -e 'bash -c \"./examples/server/server -l $a-$e-$m $p $s $cert_server -t -B 6400 >> $file; exit; exec bash\"'");
                        system("gnome-terminal -e 'bash -c \"./examples/client/client -l $a-$e-$m $p $s $cert_client -t -B 6400>> $file; ./examples/client/client -l $a-$e-$m $p $s $cert_client -t -B 6400>> $file; exit; exec bash\"'");                         

                    }
                    
                    else (){
                    
                        //for DTLS benchmark, use 20b of data and only server uses the -B flag, also only run 1 client command
                        system("gnome-terminal -e 'bash -c \"./examples/server/server -l $a-$e-$m $p $s $cert_server -t -B 20 >> $file; exit; exec bash\"'");
                        system("gnome-terminal -e 'bash -c \"./examples/client/client -l $a-$e-$m $p $s $cert_client -t >> $file; exit; exec bash\"'");                         

                    
                    }
                    
                    file_put_contents($file, "\n\n", FILE_APPEND);

                    // to avoid race conditions
                    system("sleep 2;"); 
                    
                
                }            
            }
        }
    }
  }

?>