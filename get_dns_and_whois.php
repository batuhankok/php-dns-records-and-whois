<!doctype html>
<html lang="en">

<head>
   
    <meta charset="utf-8">

    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>How to Get DNS Records and Whois in PHP?</title>
    
    <meta name="author" content="Batuhan KÖK">
    
    <style type="text/css">
        body{ margin:50px auto; box-sizing:border-box; background-color:#fafafa; }
        input[type="text"] { padding:20px; font-size:18px; border:2px solid #ddd; border-radius:3px; width:350px; text-align:center; }
        #result { width:350px; padding:20px; background:#fff; border:2px solid #ddd; border-radius:3px;}
        #whois { width:350px; padding:20px;background:#fff;border:2px solid #ddd; border-radius:3px; max-height: 100px; overflow: auto; }
    </style>

</head>

<body>

    <?php
    
        /*
            Author: Batuhan KÖK
            Website: batuhan.me | Twitter: @BatuhanKOK | Github: @BatuhanKok
        */
    
        $result = "";
        $whois = "";
        $url = @$_GET["url"];
    
        if( strlen($url) < 2 )
        {
            
            $result = "<b>Please enter a valid URL! <br />Like: batuhan.me (don't use http://)</b>";
            $whois = "<i>Whois result will be in here...</i>";
            
        }
        else
        {
            
            #Nameservers
            $dns_record = dns_get_record($url, DNS_NS);
    
            foreach($dns_record as $ns){
                $result .= '<b>NS:</b> ' . $ns['target']. '<br />'; 
            }

            #A Records
            $a_record = dns_get_record($url, DNS_A);

            foreach($a_record as $a){
                $result .= '<b>A:</b> ' . $a['ip'] . '<br />'; 
            }

            #MX Records
            $mx_record = dns_get_record($url, DNS_MX);

            foreach($mx_record as $mx){
                $result .= '<b>MX:</b> Prio: ' . $mx['pri'] . ' TTL:' . $mx['ttl'] . ' URL:' . $mx['target'] . '<br />'; 
            }

            #CNAME Records
            $cname_record = dns_get_record('www.'.$url, DNS_CNAME);

            foreach($cname_record as $cname){
                $result .= '<b>CNAME for (www):</b> ' . $cname['target']. '<br />';  
            }

            #Whois?
            $whois = shell_exec("whois {$url}");
            
        }
    
    ?>
    
    <center>
    
        <form action="" method="GET">

            <input type="text" name="url" value="<?php echo $url; ?>" placeholder="Write a URL, press Enter!" autocomplete="off">

        </form>

        <p id="result"><?php echo $result; ?></p>
        
        <p id="whois"><?php print_r($whois); ?></p>
    
    </center>

</body>

</html>