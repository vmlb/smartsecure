<?php
    echo "<div class='container'>";
    echo "<div class='row'>";
    echo "    <div class='col-sm-12' style='border: 1px solid; border-radius: 4px; border-color: lightgrey;'>";

    // Store POST data into variables
    if(isset($_POST['data_type'])){
        $data_type = $_POST['data_type'];
    } else {
        $data_type = "multimedia";
    }
    if(isset($_POST['data_size'])){
        $data_size = $_POST['data_size'];
    } else {
        $data_size = 256;
    }
    if(isset($_POST['energy'])){
        $energy = $_POST['energy'];
    } else {
        $energy = 3;
    }
    if(isset($_POST['cpu'])){
        $CPU = $_POST['cpu'];
    } else {
        $CPU = 3;
    }
    if(isset($_POST['memory'])){
        $MEM = $_POST['memory'];
    } else {
        $MEM = 3;
    }
    if(isset($_POST['message'])){
        $message = $_POST['message'];
    } else {
        $message = "Default Message.";
    }
    if(isset($_POST['resumption'])){
        $resumption = $_POST['resumption'];
    } else {
        $resumption = "True";
    }
    echo $data_type."<br>";
    echo $data_size."<br>";
    echo $energy."<br>";
    echo $CPU."<br>";
    echo $MEM."<br>";
    echo $message."<br>";
    echo $resumption."<br>";
    echo "  </div>";
    echo "</div>";
    echo "<br><br>";
    echo "<div class='row'>";
    echo "    <div class='col-sm-12' style='border: 1px solid; border-radius: 4px; border-color: lightgrey;'>";

    $scheme_names = array('PSK-CHACHA20-POLY1305', 'DHE-PSK-CHACHA20-POLY1305', 'PSK-AES256-CBC-SHA', 'DHE-PSK-AES256-GCM-SHA384');
    $scheme_energy = array(2, 4, 2, 4);
    $scheme_level = array(2, 4, 2, 4);
    $scheme_protocol = array('DTLS', 'DTLS', 'TLS', 'TLS');
    $scheme_type = array('stream', 'stream', 'block', 'block');
    $scheme_auth = array('PSK', 'PSK', 'PSK', 'PSK');

    // Determine protocol and cipher type from the data type and data size
    if($data_type == "multimedia"){
        $protocol = "DTLS";
        $cipher_type = "stream";
    } else {
        if($data_size > 128){ // Data size is measured in bits
            $protocol = "DTLS";
            $cipher_type = "stream";
        } else {
            $protocol = "TLS";
            $cipher_type = "block";
        }
    }

    print("<br>All Security Schemes:<br>");
    print_r($scheme_names);

    // If device has limited energy then remove high-intensity security schemes
    if($energy < 3){
        foreach ($scheme_energy as $index => $energy_required) {
            if($energy_required >= 3) {
                unset($scheme_energy[$index]);
                unset($scheme_names[$index]);
                unset($scheme_level[$index]);
                unset($scheme_protocol[$index]);
                unset($scheme_type[$index]);
            }
        }
    }

    print("<br>Security Schemes After Energy Elimination:<br>");
    print_r($scheme_names);

    // Choose security scheme based upon device's available processing power
    // and memory from the remaining available security schemes. Specifically,
    // choose scheme with highest security level below device's power limit.
    $highlevel = -1;
    $highindex = -1;
    $lowlevel = 100;
    $lowindex = 100;
    $power = min($CPU, $MEM);

    foreach($scheme_level as $index => $level){
        if($power >= $level){
            if($protocol == $scheme_protocol[$index] && $cipher_type == $scheme_type[$index]){
                if($level > $highlevel){
                    $highlevel = $level;
                    $highindex = $index;
                }
            }
        }
        if($level < $lowlevel){
            $lowlevel = $level;
            $lowindex = $index;
        }
    }

    // If no scheme exists below device's power threshold, assign lowest possible
    $PSK = False;
    if($highindex != -1){
        $chosen_scheme = $scheme_names[$highindex];
        if($scheme_auth[$highindex] == 'PSK'){
            $PSK = True;
        }
    } else {
        $chosen_scheme = $scheme_names[$lowindex];
        if($scheme_auth[$lowindex] == 'PSK'){
            $PSK = True;
        }
    }

    print("<br>Best Match Security Scheme:<br>");
    print($chosen_scheme."<br><br>");

    // Build and run the system call from the given parameters
    $client_command = "./examples/client/client -t -l ".$chosen_scheme;
    if($PSK == True){
        $client_command .= " -s";
    }
    if($protocol == "DTLS"){
        $client_command .= " -u";
    }
    if($resumption == "True"){
        $client_command .= " -r";
    }
    echo $client_command;
    echo "<img src='DTLS-DHE-PSK-CHACHA20-POLY1305.jpg'>";
    echo "  </div>";
    echo "</div>";
    echo "<br><br>";
    echo "<div class='row'>";
    echo "    <div class='col-sm-12' style='border: 1px solid; border-radius: 4px; border-color: lightgrey;'>";
    $output = shell_exec("printf '".$message."' | ".$client_command);
    echo "<pre>$output</pre>";
    echo "  </div>";
    echo "</div>";
    echo "</div>";
?>
