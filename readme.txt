The steps to run the system on a local or domain server are different.
Note:
Username = eneskaan
Password = eneskaan142

Running on a Local Server:
Download XAMPP from https://www.apachefriends.org/en/download.html.

Open XAMPP, and click the Start button next to Apache and MySQL.
Go to "http://www.localhost/phpmyadmin/" in your browser.
Click New on the left sidebar and enter "otomatik-sulama-sistemi" as the database name.
Set the collation to "utf8mb4_general_ci".
Then click on the "otomatik-sulama-sistemi" database, click the Import button at the top.
Select the otomatik-sulama-sistemi-veritabani.sql file and click Go at the bottom.
On the left sidebar, click on the "otomatik-sulama-sistemi" database and open the ayarlar table.
Click Edit, change the URL field to "http://www.localhost/otomatik-sulama-sistemi/", and click Go.

In XAMPP, click the Explorer button on the right side.
In the opened window, open the htdocs folder.
Move the "otomatik-sulama-sistemi" folder here.

Open the sinif folder inside the "otomatik-sulama-sistemi" folder.
Open the veritabani.php file (with Notepad, PHPStorm, VSCode, etc.).
In the $sunucu section, change the value to "localhost".
Uncomment the line //var $port="3306"; by removing the //.
Change the $kullanici_adi value to "root".
Leave the $sifre field empty.
Set $veri_tabani_adi to "otomatik-sulama-sistemi".
Remove the comment marks (/* and */) around /*";port=" . $this->port . */ and save the file (Ctrl + S).

Open the .htaccess file and change the RewriteBase to RewriteBase /otomatik-sulama-sistemi/ and save it.
In XAMPP, click on the Config button and select Apache (httpd.conf).
Uncomment the line LoadModule rewrite_module modules/mod_rewrite.so by removing the # at the beginning.
In the <Directory "C:/xampp/htdocs"> section, change AllowOverride None to AllowOverride All.

Download Arduino IDE from https://www.arduino.cc/en/software.

Open the otomatik-sulama-sistemi-esp.ino file in Arduino IDE.
Click File in the top left corner, then click Preferences.
In the Additional boards manager URLs field, add https://arduino.esp8266.com/stable/package_esp8266com_index.json and click OK.
Then, go to Tools → Board → ESP8266 → NodeMCU 1.0 (ESP-12E Module).
Next, go to Tools → Port and select the port where the ESP8266 is connected.
On the left panel, click the library icon, search for dht11, and install the DHT sensor library by Adafruit.
Then, search for esp8266 and install the ESP8266 library.
Change the serverName value to "http://your_ip_address/otomatik-sulama-sistemi/".
To find your IP address, open cmd (Command Prompt) and type ipconfig, then press Enter. Find the IPv4 Address.
Change the ssid and password fields to your Wi-Fi name and password.
Finally, upload the code to the ESP8266 by clicking the Upload button.

Now you can access the system by navigating to "http://www.localhost/otomatik-sulama-sistemi/" in your browser.
Note: XAMPP should be open, and Apache and MySQL must be running.

Running on Hosting:
Upload all the files from the "otomatik-sulama-sistemi" folder to your server.

Import the otomatik-sulama-sistemi-veritabani.sql file into phpMyAdmin.

In the ayarlar table of the otomatik-sulama-sistemi database, change the URL field to your domain.

Open the sinif folder.
Open the veritabani.php file (with Notepad, PHPStorm, VSCode, etc.).
In the $sunucu section, change the value to your server's address.
Change the $kullanici_adi value to your database username.
Change the $sifre value to your database password.
Set $veri_tabani_adi to your database name and save the file.

Open the otomatik-sulama-sistemi-esp.ino file in Arduino IDE.
Click File in the top left corner, then click Preferences.
In the Additional boards manager URLs field, add https://arduino.esp8266.com/stable/package_esp8266com_index.json and click OK.
Then, go to Tools → Board → ESP8266 → NodeMCU 1.0 (ESP-12E Module).
Next, go to Tools → Port and select the port where the ESP8266 is connected.
On the left panel, click the library icon, search for dht11, and install the DHT sensor library by Adafruit.
Then, search for esp8266 and install the ESP8266 library.
Change the serverName value to "https://yourdomain.com/otomatik-sulama-sistemi/".
Finally, upload the code to the ESP8266 by clicking the Upload button.

