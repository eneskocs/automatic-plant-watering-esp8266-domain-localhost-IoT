Download XAMPP from https://www.apachefriends.org/en/download.html.

Open XAMPP and click the "Start" button next to the Apache and MySQL modules. Go to the following address in your browser: "http://www.localhost/phpmyadmin/". Click on New on the left sidebar and name the database as "otomatik-sulama-sistemi". Set the collation to "utf8mb4_general_ci". Then click on the "otomatik-sulama-sistemi" database and click the Import button at the top. Choose the file otomatik-sulama-sistemi-veritabani.sql and click Go at the bottom. On the left sidebar, click the "otomatik-sulama-sistemi" database and open the ayarlar table. Click Edit, and change the URL field to "http://www.localhost/otomatik-sulama-sistemi/" and click Go.

In XAMPP, click the Explorer button on the right side.
In the opened window, navigate to the htdocs folder.
Move the "otomatik-sulama-sistemi" folder here.

Open the sinif folder inside the "otomatik-sulama-sistemi" directory.
Open the veritabani.php file using any text editor (Notepad, PHPStorm, VSCode, etc.).
Change the value for $sunucu to "localhost".
Uncomment the line //var $port="3306"; by removing the //.
Change $kullanici_adi to "root".
Leave $sifre empty.
Set $veri_tabani_adi to "otomatik-sulama-sistemi".
Remove the comment marks (/* and */) around /*";port=" . $this->port . */ and save the file with Ctrl + S.

Open the .htaccess file and change the RewriteBase to RewriteBase /otomatik-sulama-sistemi/ and save it.
In XAMPP, open the Apache configuration by clicking Config and then Apache (httpd.conf).
Uncomment the LoadModule rewrite_module modules/mod_rewrite.so line by removing the # at the start.
Find the <Directory "C:/xampp/htdocs"> section and change AllowOverride None to AllowOverride All.

Download the Arduino IDE from https://www.arduino.cc/en/software.

Open the otomatik-sulama-sistemi-esp.ino file in the Arduino IDE.
Click File on the top left, then click Preferences.
In the Additional boards manager URLs section, add https://arduino.esp8266.com/stable/package_esp8266com_index.json and click OK.
Then go to Tools → Board → ESP8266 → NodeMCU 1.0 (ESP-12E Module).
Next, select the correct Port from Tools → Port for the connected ESP8266 device.
On the left panel, click the library icon, search for dht11, and install the DHT sensor library by Adafruit.
Also, search for esp8266 and install the ESP8266 library.
Change the value of serverName to "http://ipadresiniz/otomatik-sulama-sistemi/".
To find your IP address, open Command Prompt (cmd), type ipconfig and press Enter. Look for the IPv4 Address.
Change the ssid and password fields to your Wi-Fi credentials.
Finally, upload the code to the ESP8266 by clicking the Upload button.

Now, you can access the system by going to "http://www.localhost/otomatik-sulama-sistemi/" in your browser.
Note: XAMPP should be open, and Apache and MySQL should be running.

Running the System on Hosting:
Upload all the files from the "otomatik-sulama-sistemi" folder to your server.

Import the otomatik-sulama-sistemi-veritabanı.sql file into phpMyAdmin.

In the ayarlar table of the otomatik-sulama-sistemi database, change the URL field to your domain.

Open the sinif folder.
Open the veritabani.php file using any text editor (Notepad, PHPStorm, VSCode, etc.).
Change $sunucu to your server's address.
Set $kullanici_adi to your database username.
Set $sifre to your database password.
Change $veri_tabani_adi to your database name and save the changes.

Open the otomatik-sulama-sistemi-esp.ino file in the Arduino IDE.
Click File on the top left, then click Preferences.
In the Additional boards manager URLs section, add https://arduino.esp8266.com/stable/package_esp8266com_index.json and click OK.
Then go to Tools → Board → ESP8266 → NodeMCU 1.0 (ESP-12E Module).
Next, select the correct Port from Tools → Port for the connected ESP8266 device.
On the left panel, click the library icon, search for dht11, and install the DHT sensor library by Adafruit.
Also, search for esp8266 and install the ESP8266 library.
Change the value of serverName to "https://yourdomain.com/otomatik-sulama-sistemi/".
Finally, upload the code to the ESP8266 by clicking the Upload button.

