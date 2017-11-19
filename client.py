import serial, time, sys
import signal
import requests
import datetime

from decimal import Decimal
from compiler.pycodegen import EXCEPT
from time import sleep
from serial import Serial
ser = None

#handler per la chiusura con CTRL-C da terminale
def signal_handler(signal, frame):
	if ser:
		ser.close()
	print "\nBye"
	sys.exit(0)

signal.signal(signal.SIGINT, signal_handler)

stop = False

#funzione per la connessione alla porta seriale
def serial_data(port, baudrate):
	ser = serial.Serial(port, baudrate)
	print "Reading on " + port

	while not stop:
		yield ser.readline()
	
	ser.close()

if len(sys.argv) < 1 or len(sys.argv) > 3:
	print "USE: client.py serial_port_path [updater_url]"
	sys.exit(1)

update = True

if len(sys.argv) == 3:
	if sys.argv[2] == "":
		update = False
	else:
		updater = sys.argv[2]
if len(sys.argv) == 1:
	port = "/dev/ttyACM0"
	updater = "http://localhost/MongoUpdater.php"
else:
	updater = "http://localhost/MongoUpdater.php"

while True:
	try :
		for line in serial_data(port, 9600):
			s = line.split(";", 1)
			if update:
				p = s[0].split(":")
				r = requests.post(updater, data={
					'id_sensor': p[0], 
					'humidity': p[1], 
					'temperature': p[2],
					'datetime': datetime.datetime.now().strftime("%Y-%m-%d %H:%M:%S"), 
				})
				print (p)
				print(r)
			else:
				sys.stdout.write(line)
	except Exception as e:
	
		print "Errore porta seriale:", e
		time.sleep(3)
	
	except Exception as e:
		print "Errore: ", e	
		time.sleep(3)
	