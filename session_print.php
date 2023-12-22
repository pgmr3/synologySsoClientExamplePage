<?php
	include_once('config.php');//fie
	if(session_status() !== PHP_SESSION_ACTIVE) $name_vorher = session_name (SESSION_NAME); //"ServerTools"); //fie
?>

<?php session_start();  // Session starten bzw. wieder aufnehmen ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15"> 
<meta name="author" content="Leop. Riedl"> 
<title>Alle Session-Variablen</title>
<link rel="stylesheet" type="text/css" href="Standard.css">
</head>
<body>
<h2>Alle Session-Variablen auflisten</h2>
<?php
    // Session-Name und Session-ID anzeigen (SID)
    echo "<p>Session-Name und Session-ID:<br>"
        ."<strong>".session_name()." = ".session_id()."</strong></p>";
	echo "<p>Session-Status: <strong>".session_status()." </strong></p><br>".PHP_SESSION_DISABLED."=PHP_SESSION_DISABLED  ".PHP_SESSION_NONE."=PHP_SESSION_NONE ".PHP_SESSION_ACTIVE."=PHP_SESSION_ACTIVE";//fie 

    if (count($_SESSION) == 0) {
        echo "<p><strong>Keine</strong> SESSION-Variablen gefunden.</p>";
    } else {
    
        // Vor der Schleife über alle Einträge in $_SESSION:
        // 1.) Anzahl der Session-Variablen ausgeben
        // 2.) Kopfzeile der Tabelle erzeugen
        
        echo "<p><strong>".count($_SESSION)."</strong> SESSION-Variable(n) gefunden:</p>";
        echo '<table border="1"><tr><th>Variable</th><th>Wert</th></tr>';
        
        foreach($_SESSION as $variable => $wert) {   // Eine Tabellenzeile 
            echo "<tr><td>".$variable."</td><td>";   // mit 2 Spalten pro 
            print_r( $wert );                        // Variable ausgeben.
            echo "</td></tr>"; 
        } 
        // Die Funktion print_r() gibt Variablen-Informationen in lesbarer Form aus.
        // Funktioniert auch mit Arrays und Objekten: erzeugt eine Liste aller 
        // Eintr�ge bzw. Eigenschaften. "_r" steht fuer rekursiv, d.h. Arrays 
        // und Objekte koennen auch verschachtelt sein. 
        // Wir brauchen diese Funktion hier, weil die "gemerkte_auswahl"
        // ein Array ist (mit den ausgew�hlten Bezirks-IDs als Eintr�ge).
        
        echo "</table>";       // Hinter der Schleife: Abschluss der Tabelle.
    }
?>
<p></p>
<div class="phpsource"><h3>PHP-Quellcode</h3>
    <?php highlight_file( basename($_SERVER["PHP_SELF"]) ); ?>
</div>
</body>
</html>